<html>
    <?php include('includes/home_page_head.php'); ?>
    <body onLoad="initGeolocation();" onload="myFunction()" class="">

        <?php include('includes/home_page_header.php'); ?>
        <main>
            <div class="ho-banner" <?php if($image->type=='image'){ ?> style="background-image: url(<?php echo asset('public/images/'.$image->file) ?>);" <?php } ?>>
                <div class="header_video"> 
         <?php if($image->type=='video'){ ?>
                    <video style="opacity: 0.5;" playsinline="playsinline" autoplay="autoplay" muted="muted" loop="loop">
            <source src="<?php  echo asset('public/images/'.$image->file) ?>" type="video/mp4">
        </video>
         <?php } ?>
                </div>
                <div class="ho-ban-layer">
                    <section>
                        <div class="ho-green-bg">
                            <h2>The Community for Natural Healing</h2>
                            <p>We've heard it all! Search in Questions, Answers, Strains, Budz Adz or by Keyword</p>
                            <div class="ho-search">
                                <?php if (Auth::user()) { ?>
                                    <form class="new-ser-dgn" action="<?php echo asset('globle-search'); ?>">
                                        <input autocomplete="off" id="search_box" name="q" type="search" placeholder="Hey Bud, what whould you like to search for?" />
                                        <img src="<?php echo asset('userassets/images/search.png') ?>" alt="search" />
                                    </form>
                                <?php } else { ?>
                                    <form class="new-ser-dgn" action="<?php echo asset('login'); ?>">
                                        <input autocomplete="off" id="search_box" name="q" type="search" placeholder="Hey Bud, what whould you like to search for?" />
                                        <img src="<?php echo asset('userassets/images/search.png') ?>" alt="search" />
                                    </form>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="ho-counter">
                            <div class="ho-cus-col ho-coun-green">
                                <strong class="count"><?= $budz_count; ?></strong>

                                <span>Budz in the Community</span>
                            </div>
                            <div class="ho-cus-col ho-coun-yellow">
                                <strong class="count"><?= $strains_count; ?></strong>
                                <span>Healing Strains</span>
                            </div>
                            <div class="ho-cus-col ho-coun-blue">
                                <strong class="count"><?= $questions_count; ?></strong>
                                <span>Questions Answered</span>
                            </div>
                        </div>

                    </section>
                    <div class="ho-bg-ban-over"></div>
                </div>
            </div>
            <div class="three_col_section_wrap">
                <section>
                    <div class="ho-top-budz">
                        <div class="ho-cus-col ho-top-green">
                            <h4 class="text-uppercase">TOP 3 BUDZ</h4>
                            <div class="hb_ho-cus-row_wrap">                            
                                <?php
                                foreach ($top_budz as $bud) {
                                    $url_user = asset('user-profile-detail/' . $bud->id);
                                    if (Auth::user()) {
                                        $url_user = asset('user-profile-detail/' . $bud->id);
                                    }
                                    ?>
                                    <div class="ho-cus-row">
                                        <div class="ho-first-top">
                                            <div class="ho-left-top ">
                                                <img src="<?php echo getRatingImage($bud->points) ?>" alt="leaf" />
                                                <span class="<?= getRatingClass($bud->points) ?>"><?= $bud->points; ?></span>
                                            </div>
                                            <div class="ho-right-top">
                                                <a href="<?= $url_user ?>">
                                                    <figure class="ho-pro-icon" style="background-image: url(<?= getImage($bud->image_path, $bud->avatar) ?>);"></figure>
                                                    <strong><?= $bud->first_name; ?>
                                                        <span><?= $bud->location; ?></span>
                                                    </strong>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="ho-last-top">
                                            <?php if (Auth::guard('user')->check()) {
                                                if(checkIsFolloing($bud->id)) { ?>
                                                <a href="<?php echo asset('user-profile-detail/' . $bud->id); ?>" class="ho-cus-btn">Unfollow</a>
                                                <?php }else{ ?>
                                                <a href="<?php echo asset('user-profile-detail/' . $bud->id); ?>" class="ho-cus-btn">Follow</a>    
                                               <?php } } else { ?>
                                                <a href="<?php echo asset('user-profile-detail/' . $bud->id); ?>" class="ho-cus-btn ">Follow</a>
                                            <?php } ?>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                            <?php if (Auth::user()) { ?>
                                <a href="<?php echo asset('wall?sorting=Newest'); ?>" class="ho-top-btn">EXPLORE COMMUNITY</a>
                            <?php } else { ?>
                                <a href="<?php echo asset('wall?sorting=Newest'); ?>" class="ho-top-btn">EXPLORE COMMUNITY</a>
                            <?php } ?>
                        </div>
                        <div class="ho-cus-col ho-top-yellow">
                            <h4>TOP 3 STRAINS</h4>
                            <div class="hb_ho-cus-row_wrap">                            
                                <?php
                                foreach ($top_strains as $strain) {
                                    $url_user = asset('strain-details/' . $strain->getStrain->id);
                                    if (Auth::user()) {
                                        $url_user = asset('strain-details/' . $strain->getStrain->id);
                                    }
                                    ?>
                                    <div class="ho-cus-row">
                                        <div class="ho-first-top">
                                            <div class="ho-left-top">
                                                <?php if ($strain->getStrain->getMainImages) { ?>
                                                    <figure class="ho-pro-icon" style="background-image: url(<?php echo asset('public/images' . $strain->getStrain->getMainImages->image_path) ?>);"></figure>
                                                <?php } else { ?>
                                                    <figure class="ho-pro-icon" style="background-image: url(<?php echo asset('userasstes/images/bgImage3.png') ?>);"></figure>
                                                <?php } ?>
                                                <span class="key <?= $strain->getStrain->getType->title; ?>"><?= substr($strain->getStrain->getType->title, 0, 1); ?></span>
                                            </div>
                                            <div class="ho-right-top">
                                                <a href="<?= $url_user; ?>">
                                                    <span><?= $strain->getStrain->title; ?></span>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="ho-last-top">
                                            <div class="ho-rat-leaf">
                                                <img src="<?php echo asset('userassets/images/leaf-yellow.png') ?>" alt="leaf" />
                                                <span><?= number_format((float) $strain->total, 1, '.', ''); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>                                    
                            <?php if (Auth::guard('user')->check()) { ?>
                                <a href="<?php echo asset('strains-list?filter=alphabetically'); ?>" class="ho-top-btn">USE OUR STRAIN MATCHING TOOL</a>
                            <?php } else { ?>
                                <a href="#loginModal" class="ho-top-btn new_popup_opener">USE OUR STRAIN MATCHING TOOL</a>
                            <?php } ?>
                        </div>
                        <div class="ho-cus-col ho-top-blue">
                            <h4>TOP 3 QUESTIONS</h4>
                            <div class="hb_ho-cus-row_wrap">                            
                                <?php
                                foreach ($top_questions as $question) {
//                              $str = preg_replace("/<a[^>]+\>/i","",$question->question) ;
//                              $str = str_replace("</a>","",$str) ;
                                    $url_user = asset('get-question-answers/' . $question->id);
                                    if (Auth::user()) {
                                        $url_user = asset('get-question-answers/' . $question->id);
                                    }
                                    ?>
                                    <div class="ho-cus-row">
                                        <div class="ho-first-top">
                                            <a href="<?= $url_user ?>">
                                                <strong><img src="<?php echo asset('userassets/images/ques.png') ?>" alt="" /></strong>
                                                <span><?php $question_text=trim(revertTagSpace($question->question)); echo substr(preg_replace("/<\/?a( [^>]*)?>/i", "", $question_text), 0, 60); ?></span>
                                            </a>
                                        </div>
                                        <div class="ho-last-top">
                                            <strong><?= $question->get_answers_count; ?><span>ANSWERS</span></strong>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                            <?php if (Auth::guard('user')->check()) { ?>
                                <a href="<?php echo asset('questions'); ?>" class="ho-top-btn">ASK A QUESTION</a>
                            <?php } else { ?>
                                <a href="#loginModal" class="ho-top-btn new_popup_opener">ASK A QUESTION</a>
                            <?php } ?>
                        </div>
                    </div>
                </section>
            </div>
            <section>
                <div class="ho-daily-budz">
                    <div class="ho-style-head">
                        <h2>Daily Buzz</h2>
                    </div>
                    <div class="ho-article-list-btn">
                        <a href="<?= asset('home-article-list')?>">View All</a>
                    </div>
                    <div class="ho-cus-row">
                        <?php if (count($today_articles) > 0) {
                         foreach ($today_articles as $today_article ){ ?>
                            <div class="ho-cus-col">
                                <a href="<?php echo asset('article_detail/' . $today_article->id . '?article_type=article'); ?>">
                                    <figure style="background-image: url(<?php echo asset('public/images' . $today_article->thumb) ?>)">
                                        <figcaption>Article of the Day</figcaption>
                                    </figure>
                                    <article>
                                        <h3><?php echo ($today_article->title); ?></h3>
                                        <?php if ($today_article->category) { ?>
                                                <div><span style="background: #7cc244;padding: 5px 10px;display: inline-block;margin-bottom: 10px;border-radius: 5px;"><?php echo $today_article->category->title; ?></span></div>
                                            <?php } else { ?>
                                                <div><span style=" padding: 2px;"></span></div> 
                                            <?php } ?>
                                        <div class="ho-cus-para">
                                            <p><?php $char_len= strlen($today_article->teaser_text);$add_dot='';if($char_len > 115){$add_dot='...';} echo substr($today_article->teaser_text, 0, 100).$add_dot; ?></p>
                                        </div>
                                        <div class="ho-buzz-btn">
                                           <span>Read More <img src="<?php echo asset('userassets/images/arrow-right.png') ?>" alt="icon" /></span>
                                        </div>
                                    </article>
                                </a>
                                <a class="white flag report btn-popup pull-left" href="#budz-review<?= $today_article->id; ?>">
                                            <i class="fa fa-share-alt" aria-hidden="true" style="margin-right: 5px;"></i> Share
                                        </a>
                            </div>
                        <!--Share Model-->
                                    <div id="budz-review<?= $today_article->id; ?>" class="popup">
                                        <div class="popup-holder">
                                            <div class="popup-area">
                                                <div class="reporting-form">
                                                    <h2>Select an option</h2>
                                                    <div class="custom-shares">
                                                        <?php 
                                                        echo Share::page(asset('article_detail/' . $today_article->id . '?article_type=article'),$today_article->teaser_text, ['class' => 'artical_class', 'id' => $today_article->id])
                                                                ->facebook($today_article->teaser_text)
                                                                ->twitter($today_article->teaser_text)
                                                                ->googlePlus($today_article->teaser_text);
                                                        ?>
                                                        <?php if (Auth::user()) { ?>
                                                            <div class="budz_review_class in_app_button artical_class" onclick="shareInapp('<?= asset('article_detail/' . $today_article->id . '?article_type=article') ?>', '<?php echo str_replace("'",'',trim(revertTagSpace($today_article->title))); ?>', '<?php echo asset('public/images' . $today_article->thumb) ?>', '<?= str_replace("'",'',$today_article->teaser_text) ?>')"> <span class="hb_icon_repost"></span> In App</div>
                                                        <?php } ?>
                                                    </div>
                                                    <a href="javascript:void(0)" class="btn-close"><i class="fa fa-times-circle-o" aria-hidden="true"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                        <?php }} ?>

                    </div>
                </div>
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

            <!--            18 enter pop up-->
            <?php if (!Auth::user() && !( Session::has('not_pop_up'))) { ?>
                <div id="id01" class="notification_modal">
                    <form class="modal-content animate" action="/action_page.php">
                        <div class="imgcontainer">
                            <!--â€™-->
                            <!--<span onclick="document.getElementById('id01').style.display = 'none'" class="close" title="Close Modal">&times;</span>-->
                            <img src="<?php echo asset('userassets/images/new_logo1.png') ?>" alt="Avatar" class="avatar">
                        </div>
                        <h2>Age Verification</h2>
                        <p>The services offered by this website are intended for adult's
                            only. By entering, you verify that by you are of age 21 or older.</p>
                        <div class="age-veri-chkbox">
                            <input id="session_check_box" type="checkbox" name="" />
                            Don't show me
                        </div>
                        <div class="enter_verfiy">
                            <button type="button" onclick="document.getElementById('id01').style.display = 'none'" class="cancelbtn">ENTER</button>
                            <a href="<?= asset('agenotverified') ?>" type="button"  class="exitlbtn" >EXIT</a>
                        </div>
                    </form>
                </div>
            <?php } ?>

        </main>

        <?php include('includes/home_page_footer.php'); ?>
        <?php if($agent == 'AndroidOS' || $agent == 'iOS') { 
             $url='https://itunes.apple.com';
             $text='App Store';
             if($agent == 'AndroidOS'){
               $url='https://play.google.com/'; 
               $text='Play Store';
             }
           ?>
        <script> 
    $("body").addClass("mobile_app_popup_padding");
    function removeClass(){
        $("body").removeClass("mobile_app_popup_padding");
        $('.mobile_app_popup').hide();
    }
        </script>
        <div class="mobile_app_popup">
            <div class="app_popup_inner">
                <div class="app_popup_content">
                    <span class="app_site_img" style="background-image: url(<?php echo asset('userassets/images/new_logo1.png') ?>)">
                        <span onclick="removeClass()" class="mobile_app_popup_closer"></span>
                        
                    </span>
                    <p class="title">Healing Budz</p>
                    <p>Healing Budz</p>
                    <p>Free in <?= $text?></p>
                </div>
                <a href="<?= $url?>" target="_blank" class="btnview">View</a>
            </div>
        </div>
        <?php } ?>
        <script>   $('#session_check_box').change(function(){
      if(this.checked) {
       $.ajax({
                        url: "<?php echo asset('save_popup_session') ?>",
                        type: "GET",
                        data: {
                            "save": 1
                        }
                    });    
       }else{
          $.ajax({
                        url: "<?php echo asset('save_popup_session') ?>",
                        type: "GET"
                    });  
       }
       });
       </script>
       
    </body>

    <script type="text/javascript">
     
        function initGeolocation()
        {
            if (navigator.geolocation)
            {
                // Call getCurrentPosition with success and failure callbacks
                navigator.geolocation.getCurrentPosition(success, fail);
            } else
            {
                alert("Sorry, your browser does not support geolocation services.");
            }
        }

        function success(position)
        {

            document.getElementById('lng').value = position.coords.longitude;
            document.getElementById('lat').value = position.coords.latitude
        }

        function fail()
        {
            // Could not obtain location
        }
        (function() {
            var search = document.getElementById('search_box');
            if(search) {
                var search_placeholder = search.placeholder;              
                function short_placeholder() {
                    if( window.innerWidth<335) {
                        search.placeholder = "Hey Bud, what whould you like to search...";                    
                    } else {
                        search.placeholder = search_placeholder;                            
                    }
                }
                short_placeholder();
                window.addEventListener('resize', short_placeholder);
            }
        })();
    </script> 

    <?php if (isset($_GET['user_id'])) { ?>
        <script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async='async'></script>
        <script>

        OneSignal = window.OneSignal || [];
        OneSignal.push(function () {

            OneSignal.deleteTag("user_id");
        });


        </script>

    <?php } ?>
</html>
