<html>
    <?php include('includes/home_page_head.php'); ?>
    <body class="">

        <?php include('includes/home_page_header.php'); ?>
        <main>
            <section class="article-lists">
                <div class="left-list-articles">
                    <div class="sidebar-list-article">
                        <div class="article-lists-search">
                            <form method="get" action="<?= asset('search_artical') ?>">
                                <input autocomplete="off" type="search" name="q" placeholder="Search" />
                            </form>
                        </div>
                        <div class="article-list-cate">
                            <h4 class="article-list-side-heading">Category</h4>
                            <ul>
                                <li><a href="<?= asset('home-article-list') ?>">All<span><?= $articals_count?></span></a></li>
                                <?php foreach ($cats as $cat) { ?>
                                    <li><a href="<?= asset('get_selected_articals/' . $cat->id) ?>"><?= $cat->title ?> <span><?php echo $cat->artical_count ?></span></a></li>
                                <?php } ?>
                            </ul>
                        </div>
                        <div class="article-list-recent">
                            <h4 class="article-list-side-heading">Recent</h4>
                            <ul>
                                <?php foreach ($tops as $top) { ?>
                                    <li>
                                        <a href="<?php echo asset('article_detail/' . $top->id . '?article_type=article'); ?>">
                                            <figure style="background-image: url(<?php echo asset('public/images/' . $top->thumb) ?>)"></figure>
                                            <p><?= $top->title ?></p>
                                        </a>
                                    </li>

                                <?php } ?>
                            </ul>
                        </div>
                        <!--                        <div class="article-list-tags">
                                                    <h4 class="article-list-side-heading">Tags</h4>
                                                    <ul>
                                                        <li>Nutrients,</li>
                                                        <li>Nutrients,</li>
                                                        <li>Nutrients,</li>
                                                        <li>Nutrients,</li>
                                                        <li>Nutrients</li>
                                                    </ul>
                                                </div>-->
                    </div>
                </div>
                <div class="right-list-articles">
                    <div class="ho-daily-budz">
                        <div class="ho-cus-row">
                            <?php foreach ($articals as $artical) { ?>
                                <div class="ho-cus-col">
                                    <a href="<?php echo asset('article_detail/' . $artical->id . '?article_type=article'); ?>">
                                        <figure style="background-image: url(<?php echo asset('public/images' . $artical->thumb) ?>)">

                                        </figure>
                                        <article>
                                            <h3><?php echo $artical->title; ?></h3>
                                            <?php if ($artical->category) { ?>
                                                <div><span style="background: #7cc244;padding: 5px 10px;display: inline-block;margin-bottom: 10px;border-radius: 5px;"><?php echo $artical->category->title; ?></span></div>
                                            <?php } else { ?>
                                                <div><span style=" padding: 2px;"></span></div> 
                                            <?php } ?>
                                            <div class="ho-cus-para">
                                                <p><?php $char_len= strlen($artical->teaser_text); $add_dot='';if($char_len > 115){$add_dot='...';} echo substr($artical->teaser_text, 0, 115).$add_dot; ?></p>
                                            </div>
                                            <div class="ho-buzz-btn">
                                                <a class="white flag report btn-popup pull-left" href="#budz-review<?= $artical->id; ?>">
                                                    <i class="fa fa-share-alt" aria-hidden="true" style="margin-right: 5px;"></i> Share
                                                </a>
                                                <a href="<?php echo asset('article_detail/' . $artical->id . '?article_type=article'); ?>">
                                                <span>Read More <img src="<?php echo asset('userassets/images/arrow-right.png') ?>" alt="icon" /></span>
                                                </a> </div>

                                        </article>
                                    </a>


                                    <!--Share Model-->
                                    <div id="budz-review<?= $artical->id; ?>" class="popup">
                                        <div class="popup-holder">
                                            <div class="popup-area">
                                                <div class="reporting-form">
                                                    <h2>Select an option</h2>
                                                    <div class="custom-shares">
                                                        <?php
                                                        echo Share::page(asset('article_detail/' . $artical->id . '?article_type=article'),$artical->teaser_text, ['class' => 'artical_class', 'id' => $artical->id])
                                                                ->facebook($artical->teaser_text)
                                                                ->twitter($artical->teaser_text)
                                                                ->googlePlus($artical->teaser_text);
                                                        ?>
                                                        <?php if (Auth::user()) { ?>
                                                            <div class="budz_review_class in_app_button artical_class" onclick="shareInapp('<?= asset('article_detail/' . $artical->id . '?article_type=article') ?>', '<?php echo str_replace("'",'',trim(revertTagSpace($artical->title))); ?>', '<?php echo asset('public/images' . $artical->thumb) ?>', '<?= str_replace("'",'',$artical->teaser_text) ?>')"> <span class="hb_icon_repost"></span> In App</div>
                                                        <?php } ?>
                                                    </div>
                                                    <a href="javascript:void(0)" class="btn-close"><i class="fa fa-times-circle-o" aria-hidden="true"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>

                        </div>
                    </div>
                </div>

            </section>
            <section>
                <div class="article-list-pagination"><?= $articals->links() ?></div>
            </section>
            <!--<a href="#loginModal" class="new_popup_opener">Open Modal</a>-->
            <!-- The Modal -->
            <div id="loginModal" class="login-modal home-pg-login">
                <!-- Modal content -->
                <div class="login-content">
                    <span class="close">&times;</span>
                    <form method="post" action="<?php echo asset('/'); ?>">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                        <input type="hidden" NAME="lng" ID="lng" VALUE="">
                        <input type="hidden" NAME="lat" ID="lat" VALUE="">
                        <h4>Login</h4>
                        <div class="trans-input">
                            <input type="email" name="email" placeholder="Email" value="<?php echo old('email'); ?>"/>
                            <input type="password" name="password" placeholder="Password" />
                        </div>
                        <?php
                        if (Session::has('message')) {
                            $data = json_decode(Session::get('message'));
                            if ($data) {
                                foreach ($data as $errors) {
                                    ?>
                                    <h6 class="alert alert-danger"> <?php echo $errors[0]; ?></h6>
                                    <?php
                                }
                            }
                        }
                        if (Session::has('error')) {
                            ?>
                            <div class="alert alert-danger">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times</a>
                                <?php echo Session::get('error') ?>
                            </div>
                        <?php } ?>
                        <div class="margin_row">
                            <a href="<?= asset('forget') ?>" class="forgot">Forgot Your Password?</a>
                            <span class="remember">
                                <input type="checkbox" checked name="remember_me" id="remember_me1" class="hidden">
                                <label for="remember_me1" class="keep_signed">Keep me signed in</label>
                            </span>
                        </div>
                        <div class="submit-area">
                            <div class="misc_holder">
                                <input type="submit" value="LOG IN">
                                <span class="or"><em>OR</em></span>
                            </div>
                            <div class="socials-conects">
                                <a href="<?php echo asset('fb-login'); ?>">
                                    <img src="<?php echo asset('userassets/images/fb-btn.png') ?>" alt="fb" />
                                </a>
                                <a href="<?php echo asset('google-login'); ?>">
                                    <img src="<?php echo asset('userassets/images/gmail-btn.png') ?>" alt="gmail" />
                                </a>
                            </div>
                            <span class="member">Not a Member? <a href="<?php echo asset('register'); ?>">Sign Up</a></span>

                        </div>
                    </form>
                </div>
            </div>

        </main>


        <?php include('includes/home_page_footer.php'); ?>


</html>
