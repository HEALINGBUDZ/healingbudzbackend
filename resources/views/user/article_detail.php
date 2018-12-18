<html>
    <?php include('includes/home_page_head.php'); ?>
    <body>
       <?php include('includes/home_page_header.php'); ?>
        <main>

            <div class="article-banner" style="background-image: url(<?php echo asset('public/images/'.$article->image) ?>);" >

              
                   <div class="article-header">
                        <h2>Article of the Day</h2>
                        <!--<h2 class="article-date">Oct 3rd,2018</h2>-->
                        <h2 class="article-date"><?php echo date("M jS, Y", strtotime($article->created_at))?></h2>
                    </div>
            </div>
            <section class="article-detail">
            	<h1 class="article-title"><?php echo $article->title;?></h1>
               
            	<p><?php echo $article->description;?></p>
	  </section>     
        </main>
        <section>
            <div class="ho-daily-budz">
                <div class="ho-style-head">
                    <h2>Daily Buzz</h2>
                </div>
                <div class="ho-article-list-btn">
                        <a href="<?= asset('home-article-list')?>">View All</a>
                    </div>
                <div class="ho-cus-row">
                    
                    <?php if($today_article && $_GET['article_type'] == 'question') { ?>
                        <div class="ho-cus-col">
                            <a href="<?php echo asset('article_detail/' . $today_article->id . '?article_type=article'); ?>">
                            <figure style="background-image: url(<?php echo asset('public/images'.$today_article->image) ?>)">
                                <figcaption>Article of the Day</figcaption>
                            </figure>
                            <article>
                                <h3><?php echo $today_article->title; ?></h3>
                                <div class="ho-cus-para">
                                    <!--<p> <?php // echo ($today_article->teaser_text); ?></p>-->
                                </div>
                                <div class="ho-buzz-btn">
                                    <a href="<?php echo asset('article_detail/'.$today_article->id.'?article_type=article'); ?>">Read More <img src="<?php echo asset('userassets/images/arrow-right.png') ?>" alt="icon" /></a>
                                </div>
                            </article>
                            </a>
                        </div>
                    <?php } ?>
                    <?php if($today_strain && $_GET['article_type'] == 'article') { ?>
                        <div class="ho-cus-col">
                            <?php if (Auth::guard('user')->check()) { 
                                $usr_strain= asset('user-strain-detail?strain_id='.$today_strain->getUserStrain->getStrain->id.'&user_strain_id='.$today_strain->user_strain_id);
                                $class='';
                                
                            } else {
                                    $usr_strain = '#loginModal';
                                    $class = 'new_popup_opener';
                                }
                                ?>
                            <a href="<?php echo $usr_strain; ?>" class="<?= $class ?>">
                            <figure style="background-image: url(<?php echo asset('public/images'.$today_strain->image) ?>)">
                                <figcaption>Strain of the Day</figcaption>
                            </figure>
                            <article>
                                <h3><?php echo $today_strain->title; ?></h3>
                                <div class="ho-cus-para">
<!--                                    <p><?php // echo ($today_strain->teaser_text); ?></p>-->
        </div>
                                <div class="ho-buzz-btn">
                                    <div class="ho-reward" style="display: inline-block">
                                        <span>
                                            <img src="<?php echo asset('userassets/images/reward.png') ?>" alt="icon" /><?php echo $today_strain->get_user_strain_likes_count; ?>
                                            <span>by: <?php echo $today_strain->getUserStrain->getUser->first_name;?></span>
                                        </span>
                                    </div>
                                    <?php if (Auth::guard('user')->check()) {?>
                                        <a href="<?php echo asset('user-strain-detail?strain_id='.$today_strain->getUserStrain->getStrain->id.'&user_strain_id='.$today_strain->user_strain_id); ?>">
                                            Strain Profile 
                                            <img src="<?php echo asset('userassets/images/arrow-right.png') ?>" alt="icon" />
                                        </a>
                                    <?php }else{ ?>
                                        <a href="#loginModal" class="new_popup_opener">
                                            Strain Profile 
                                            <img src="<?php echo asset('userassets/images/arrow-right.png') ?>" alt="icon" />
                                        </a>
                                    <?php } ?>
                                    
                                </div>
                            </article>
                                </a>
                        </div>
                    <?php } ?>
                              <!--<a href="#loginModal" class="new_popup_opener">Open Modal</a>-->
            <!-- The Modal -->
            <div id="loginModal" class="login-modal">
              <!-- Modal content -->
                <div class="login-content">
                    <span class="close">&times;</span>
                    <form method="post" action="<?php echo asset('/'); ?>">
                        <input type="hidden" name="_token" value="<?php echo csrf_token();?>">
                        <input type="hidden" NAME="lng" ID="lng" VALUE="">
                        <input type="hidden" NAME="lat" ID="lat" VALUE="">
                        <h4>Login</h4>
                        <div class="trans-input">
                            <input type="email" name="email" placeholder="Email" value="<?php echo old('email');?>"/>
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
                            <a href="<?= asset('forget')?>" class="forgot">Forgot Your Password?</a>
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
                                <a href="<?php echo asset('fb-login');?>">
                                    <img src="<?php echo asset('userassets/images/fb-btn.png') ?>" alt="fb" />
                                </a>
                                <a href="<?php echo asset('google-login');?>">
                                    <img src="<?php echo asset('userassets/images/gmail-btn.png') ?>" alt="gmail" />
                                </a>
                            </div>
                            <span class="member">Not a Member? <a href="<?php echo asset('register'); ?>">Sign Up</a></span>

                        </div>
                     </form>
                </div>
            </div>
                    <?php if($today_question && $_GET['article_type'] == 'article') { 
                                if (Auth::guard('user')->check()) {
                                    if ($today_question->question_id) {
                                        $url = asset('get-question-answers/' . $today_question->question_id);
                                        $class = '';
                                    } else {
                                        $url = asset('article_detail/' . $today_question->id . '?article_type=question');
                                        $class = '';
                                    }
                                } else {
                                    $url = '#loginModal';
                                    $class = 'new_popup_opener';
                                }
                                ?>
            
                        <div class="ho-cus-col">
                            <a href="<?php echo $url; ?>" class="<?= $class ?>">
                            <figure style="background-image: url(<?php echo asset('public/images'.$today_question->image) ?>)">
                                <figcaption>Question of the Day</figcaption>
                            </figure>
                            <article>
                                <h3><?php echo $today_question->title; ?></h3>
                                <div class="ho-cus-para"> 
                                    <!--<p><?php // echo ($today_question->teaser_text); ?></p>-->
                                </div>
                                <?php if($today_question->question_id){ ?>
                                    <div class="ho-buzz-btn">
                                        <?php if (Auth::guard('user')->check()) {?>
                                            <a href="<?php echo asset('get-question-answers/'.$today_question->question_id)?>">
                                                Read More 
                                                <img src="<?php echo asset('userassets/images/arrow-right.png') ?>" alt="icon" />
                                            </a>
                                        <?php }else{ ?>
                                            <a href="#loginModal" class="new_popup_opener">
                                                Read More 
                                                <img src="<?php echo asset('userassets/images/arrow-right.png') ?>" alt="icon" />
                                            </a>
                                        <?php } ?>
                                    </div>
                                <?php }else{ ?>
                                    <div class="ho-buzz-btn">
                                        <a href="<?php echo asset('article_detail/'.$today_question->id.'?article_type=question'); ?>">Read More <img src="<?php echo asset('userassets/images/arrow-right.png') ?>" alt="icon" /></a>
                                    </div>
                                <?php } ?>
                            </article>
                            </a>
                        </div>
                
                    <?php } ?>
                </div>
            </div>
        </section>
        <?php include('includes/home_page_footer.php'); ?>
    </body>
</html>
