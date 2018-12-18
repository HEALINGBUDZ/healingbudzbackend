<!DOCTYPE html>
<html lang="en">
    <link href='https://fonts.googleapis.com/css?family=PT+Sans&subset=latin' rel='stylesheet' type='text/css'>
    <link href='<?php echo asset('userassets/css/jquery.mentionsInput.css') ?>' rel='stylesheet' type='text/css'>
    <!--<link href='<?php // echo asset('userassets/css/style.css')             ?>' rel='stylesheet' type='text/css'>-->
    <?php include('includes/top.php'); ?>
    <style>
        #description{   
            background-image: url("<?php echo asset('userassets/images/5.gif') ?>");
            background-size: 25px 25px;
            background-position:left center;
            background-repeat: no-repeat;
        } 
    </style>
    <body class="wall">
        
        <!--Intro Start-->
        
        <div <?php if(! \Illuminate\Support\Facades\Session::get('is_register')){ ?> style="display: none" <?php } ?>class="intro_overlay" id="intro_screen">
            <div class="intro_box">
                <div class="intro_slides slide_one">
                    <div class="intro_top_section">
                        <div class="inner_top">
                            <h2>Welcome to Healing Budz</h2>
                            <img src="<?= asset('userassets/images/welcometohealingbudz.png') ?>" alt="Budz Map"/>
                        </div>
                    </div>
                    <div class="intro_bottom_section">
                        <h3>Back in the day you got everything you needed to know about cannabis from your cousin Tommy.</h3>
                        <div class="intro_divider"><span></span></div>
                        <p>Today's cannabis patients are part horticulturalist, part herbalist, and part chemist, but they are also passionate about sharing their knowledge. Our Budz are patients with stories to tell. The Healing Budz community connects you to decades of real life experience. Demystify cannabis and get all the answers you couldn't ask Tommy - privately and anonymously. </p>
                    </div>               
                </div> <!-- slide 1st -->
                 <div class="intro_slides slide_fifth">
                    <div class="intro_top_section">
                        <div class="inner_top">
                            <h2>"The Budz" Feed</h2>
                            <img src="<?= asset('userassets/images/BuzFeed.png') ?>" alt="Budz Map"/>
                        </div>
                    </div>
                    <div class="intro_bottom_section">
                        <h3>Just like the old smoke circles around the bonfire...</h3>
                        <div class="intro_divider"><span></span></div>
                        <p>Community is at the core of cannabis culture, and Healing Budz is passionate about creating connection. The Buzz is where users can share their thoughts, healing stories, pictures, videos, advice and more.

</p>
                    </div>               
                </div> <!-- slide 1st -->
                <div class="intro_slides slide_second">
                    <div class="intro_top_section">
                        <div class="inner_top">
                            <h2>Live Q&A Forum</h2>
                            <img src="<?= asset('userassets/images/Live-Q&A-Forum.png') ?>" alt="Live Q&A Forum"/>
                        </div>
                    </div>
                    <div class="intro_bottom_section">
                        <h3>The Healing Budz Community has heard it all...</h3>
                        <div class="intro_divider"><span></span></div>
                        <p>So ask away and get quick answers to thousands of live questions on a range of plant science and healing topics. Answer questions on your area of expertise and earn points towards our rewards program!</p>
                    </div>               
                </div> <!-- slide 2nd -->
                <div class="intro_slides slide_third">
                    <div class="intro_top_section">
                        <div class="inner_top">
                            <h2>Strain User Reviews</h2>
                            <img src="<?= asset('userassets/images/Strain-User-Reviews.png') ?>" alt="Strain-User-Reviews.png"/>
                        </div>
                    </div>
                    <div class="intro_bottom_section">
                        <h3>Individualized strain reviews, powered by you, not a laboratory... </h3>
                        <div class="intro_divider"><span></span></div>
                        <p>From Acapulco Gold to White Widow, find your strain in our database with our individualized strain reviews, rankings on aroma, taste, potency, genetics, and health benefits. Powered by you, not a laboratory, in a language you can understand without a botany degree. Share your prize worthy bud photos, best growing techniques, mood, sensation, and effects. </p>
                    </div>               
                </div> <!-- slide 2nd -->
                <div class="intro_slides slide_fourth">
                    <div class="intro_top_section">
                        <div class="inner_top">
                            <h2>Budz Adz</h2>
                            <img src="<?= asset('userassets/images/buds-ads-l.svg') ?>" alt="Budz Map"/>
                        </div>
                    </div>
                    <div class="intro_bottom_section">
                        <h3>Find medical dispensaries, physicians, natural healers, smoke shops, glass artists, canna chefs...</h3>
                        <div class="intro_divider"><span></span></div>
                        <p>Discover your local canna community. Be in the know about upcoming deals, promotions, fun industry events, and educational seminars in just a few taps.</p>
                    </div>               
                </div> <!-- slide 1st -->
                <div class="intro_footer">
                    <a href="<?= asset('/wall?sorting=Newest&remove_session=true') ?>" class="intro_skip" id="skip_intro_screen">Skip</a>
                    <div class="intro_pagination">
                        <span class="intro_page" onclick="currentSlide(1)"></span>
                        <span class="intro_page" onclick="currentSlide(2)"></span>
                        <span class="intro_page" onclick="currentSlide(3)"></span>
                        <span class="intro_page" onclick="currentSlide(4)"></span>
                         <span class="intro_page" onclick="currentSlide(5)"></span>
                    </div>
                    <span class="intro_next_slide" onclick="nextSlides(1)">Next</span>
                </div>
                <a href="<?= asset('/wall?sorting=Newest&remove_session=true') ?>" class="intro_skip" id="skip_intro_screen_mobile">Skip</a>
            </div>
        </div>
        
        <!--Intro Finish-->
        
        <div id="wrapper">
            <?php include('includes/sidebar.php'); ?>
            <article id="content">
                <?php include('includes/header.php'); ?>

                <!-- for drop zone -->
                <link rel="stylesheet" href="<?php // echo asset('userassets/css/bootstrap.css');             ?>">
                <link rel="stylesheet" href="<?php echo asset('userassets/css/dropzone.css'); ?>">
                <link rel="stylesheet" href="<?php echo asset('userassets/css/custom.css'); ?>">
                <!-- for drop zone -->
                <link rel="stylesheet" href="<?php echo asset('userassets/css/jquery.bxslider.css'); ?>">
                <link rel="stylesheet" href="<?php echo asset('userassets/css/wall.css'); ?>">
                <script src='//cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js' type='text/javascript'></script>
                <?php
                if (isset($_GET['sorting'])) {
                    $sorting = $_GET['sorting'];
                } else {
                    $sorting = '';
                }
                ?>
                <main id="wall">

                    <div class="padding-div">
                        <div class="new_container">

                            <div class="wall-post-col">
                                <h2 class="upper-heading">The Buzz</h2>
                                <?php if($current_user){ ?>
                                <div class="wall-post-col-head">
                                    <!--                            <div class="wall-search">
                                                                    <input type="search" name="search" placeholder="Hey Bud, what would you like to search for?" />
                                                                </div>-->
                                    <div class="wall-post-write-sec">
                                        <div class="wall-post-profile-img">
                                            <div class="wall-img pre-main-image" style="background-image: url(<?php echo $current_photo ?>);">
                                                <?php if ($current_special_image) { ?>
                                                    <span class="fest-pre-img" style="background-image: url(<?php echo asset('public/images' . $current_special_image) ?>);"></span>
                                                <?php } ?>
                                            </div>

                                            <?php if (count($subusers) > 0) { ?>
                                                <span class="wall-post-profile-head">Post as</span>
                                                <div class="wall-post-profile-btn-sec">
                                                    <select class="wall-post-profile-btn" id="posting_user">
                                                        <option value="u_<?= $current_user->id ?>"><?= $current_user->first_name ?></option>
                                                        <?php foreach ($subusers as $subuser) { ?>
                                                            <option value="s_<?= $subuser->id ?>"><?= $subuser->title ?></option>
                                                        <?php } ?>
                                                        <!--subusers-->
                                                    </select>
                                                </div>
                                            <?php } else {if($current_user){ ?>
                                                <input type="hidden" value="u_<?= $current_user->id ?>" id="posting_user">
                                            <?php }} ?>
                                        </div>
                                        <div class="wall-post-write-col">
                                            <div class="wall-post-write-text">
                                                <textarea placeholder="" class="mention scroller busy_div" id="description"></textarea> 

                                            </div>

                                            <div class="wall-post-write-tag-view" style="display: none">
                                                <span class="wall-with-span">with</span>
                                                <?php $all_users = json_decode($users); ?>
                                                <select class="js-example-basic-multiple tagged-budz" name="states[]" multiple="multiple" id="select2">
                                                    <?php foreach ($user_follows as $user_follow) { ?>
                                                        <option value="<?= $user_follow->getUser->id ?>"><?= $user_follow->getUser->first_name ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="wall-post-write-photo-view">
                                                <div class="container-fluid">
                                                    <div class="row">
                                                        <div class="col-sm-10 offset-sm-1">
                                                            <!--<h2 class="page-heading">Upload your Images <span id="image-counter"></span></h2>-->
                                                            <form method="post" action="<?php echo asset('/images-save'); ?>" enctype="multipart/form-data" class="dropzone" id="my-dropzone-image">
                                                                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                                                <div class="dz-message">
                                                                    <div class="col-xs-8">
                                                                        <strong class="ph_heading">Photos</strong>
                                                                        <div class="message">
                                                                            <p>Drop images here or Click to Upload</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="fallback">
                                                                    <input type="file" name="file" multiple>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                    <div id="image-preview" style="display: none;">
                                                        <div class="dz-preview dz-file-preview">
                                                            <div class="dz-image"><img data-dz-thumbnail /></div>
                                                            <div class="dz-details">
                                                                <div class="dz-size"><span data-dz-size></span></div>
                                                                <div class="dz-filename"><span data-dz-name></span></div>
                                                            </div>
                                                            <div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div>
                                                            <div class="dz-error-message"><span data-dz-errormessage></span></div>
                                                            <div class="dz-success-mark">
                                                                <svg width="54px" height="54px" viewBox="0 0 54 54" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
                                                                <!-- Generator: Sketch 3.2.1 (9971) - http://www.bohemiancoding.com/sketch -->
                                                                <title>Check</title>
                                                                <desc>Created with Sketch.</desc>
                                                                <defs></defs>
                                                                <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">
                                                                <path d="M23.5,31.8431458 L17.5852419,25.9283877 C16.0248253,24.3679711 13.4910294,24.366835 11.9289322,25.9289322 C10.3700136,27.4878508 10.3665912,30.0234455 11.9283877,31.5852419 L20.4147581,40.0716123 C20.5133999,40.1702541 20.6159315,40.2626649 20.7218615,40.3488435 C22.2835669,41.8725651 24.794234,41.8626202 26.3461564,40.3106978 L43.3106978,23.3461564 C44.8771021,21.7797521 44.8758057,19.2483887 43.3137085,17.6862915 C41.7547899,16.1273729 39.2176035,16.1255422 37.6538436,17.6893022 L23.5,31.8431458 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z" id="Oval-2" stroke-opacity="0.198794158" stroke="#747474" fill-opacity="0.816519475" fill="#FFFFFF" sketch:type="MSShapeGroup"></path>
                                                                </g>
                                                                </svg>
                                                            </div>
                                                            <div class="dz-error-mark">

                                                                <svg width="54px" height="54px" viewBox="0 0 54 54" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
                                                                <!-- Generator: Sketch 3.2.1 (9971) - http://www.bohemiancoding.com/sketch -->
                                                                <title>error</title>
                                                                <desc>Created with Sketch.</desc>
                                                                <defs></defs>
                                                                <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">
                                                                <g id="Check-+-Oval-2" sketch:type="MSLayerGroup" stroke="#747474" stroke-opacity="0.198794158" fill="#FFFFFF" fill-opacity="0.816519475">
                                                                <path d="M32.6568542,29 L38.3106978,23.3461564 C39.8771021,21.7797521 39.8758057,19.2483887 38.3137085,17.6862915 C36.7547899,16.1273729 34.2176035,16.1255422 32.6538436,17.6893022 L27,23.3431458 L21.3461564,17.6893022 C19.7823965,16.1255422 17.2452101,16.1273729 15.6862915,17.6862915 C14.1241943,19.2483887 14.1228979,21.7797521 15.6893022,23.3461564 L21.3431458,29 L15.6893022,34.6538436 C14.1228979,36.2202479 14.1241943,38.7516113 15.6862915,40.3137085 C17.2452101,41.8726271 19.7823965,41.8744578 21.3461564,40.3106978 L27,34.6568542 L32.6538436,40.3106978 C34.2176035,41.8744578 36.7547899,41.8726271 38.3137085,40.3137085 C39.8758057,38.7516113 39.8771021,36.2202479 38.3106978,34.6538436 L32.6568542,29 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z" id="Oval-2" sketch:type="MSShapeGroup"></path>
                                                                </g>
                                                                </g>
                                                                </svg>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="wall-post-write-video-view">
                                                <div class="container-fluid">
                                                    <div class="row">
                                                        <div class="col-sm-10 offset-sm-1">
                                                            <!--<h2 class="page-heading">Upload your Video <span id="video-counter"></span></h2>-->
                                                            <form method="post" action="<?php echo asset('/video-save'); ?>" enctype="multipart/form-data" class="dropzone dropzone_video" id="my-dropzone-video">
                                                                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                                                <div class="dz-message">
                                                                    <div class="col-xs-8">
                                                                        <strong class="ph_heading">Video</strong>
                                                                        <div class="message">
                                                                            <p>Drop video here or Click to Upload</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="fallback">
                                                                    <input type="file" name="file" multiple>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>

                                                    <div id="video-preview" style="display: none;">
                                                        <div class="dz-preview dz-file-preview">
                                                            <div class="dz-image video-poster"><img class="data-dz-thumbnail" /></div>
                                                            <div class="dz-details">
                                                                <div class="dz-size"><span data-dz-size></span></div>
                                                                <div class="dz-filename"><span data-dz-name></span></div>
                                                            </div>
                                                            <div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div>
                                                            <div class="dz-error-message"><span data-dz-errormessage></span></div>
                                                            <div class="dz-success-mark">
                                                                <svg width="54px" height="54px" viewBox="0 0 54 54" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
                                                                <!-- Generator: Sketch 3.2.1 (9971) - http://www.bohemiancoding.com/sketch -->
                                                                <title>Check</title>
                                                                <desc>Created with Sketch.</desc>
                                                                <defs></defs>
                                                                <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">
                                                                <path d="M23.5,31.8431458 L17.5852419,25.9283877 C16.0248253,24.3679711 13.4910294,24.366835 11.9289322,25.9289322 C10.3700136,27.4878508 10.3665912,30.0234455 11.9283877,31.5852419 L20.4147581,40.0716123 C20.5133999,40.1702541 20.6159315,40.2626649 20.7218615,40.3488435 C22.2835669,41.8725651 24.794234,41.8626202 26.3461564,40.3106978 L43.3106978,23.3461564 C44.8771021,21.7797521 44.8758057,19.2483887 43.3137085,17.6862915 C41.7547899,16.1273729 39.2176035,16.1255422 37.6538436,17.6893022 L23.5,31.8431458 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z" id="Oval-2" stroke-opacity="0.198794158" stroke="#747474" fill-opacity="0.816519475" fill="#FFFFFF" sketch:type="MSShapeGroup"></path>
                                                                </g>
                                                                </svg>
                                                            </div>
                                                            <div class="dz-error-mark">
                                                                <svg width="54px" height="54px" viewBox="0 0 54 54" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
                                                                <!-- Generator: Sketch 3.2.1 (9971) - http://www.bohemiancoding.com/sketch -->
                                                                <title>error</title>
                                                                <desc>Created with Sketch.</desc>
                                                                <defs></defs>
                                                                <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">
                                                                <g id="Check-+-Oval-2" sketch:type="MSLayerGroup" stroke="#747474" stroke-opacity="0.198794158" fill="#FFFFFF" fill-opacity="0.816519475">
                                                                <path d="M32.6568542,29 L38.3106978,23.3461564 C39.8771021,21.7797521 39.8758057,19.2483887 38.3137085,17.6862915 C36.7547899,16.1273729 34.2176035,16.1255422 32.6538436,17.6893022 L27,23.3431458 L21.3461564,17.6893022 C19.7823965,16.1255422 17.2452101,16.1273729 15.6862915,17.6862915 C14.1241943,19.2483887 14.1228979,21.7797521 15.6893022,23.3461564 L21.3431458,29 L15.6893022,34.6538436 C14.1228979,36.2202479 14.1241943,38.7516113 15.6862915,40.3137085 C17.2452101,41.8726271 19.7823965,41.8744578 21.3461564,40.3106978 L27,34.6568542 L32.6538436,40.3106978 C34.2176035,41.8744578 36.7547899,41.8726271 38.3137085,40.3137085 C39.8758057,38.7516113 39.8771021,36.2202479 38.3106978,34.6538436 L32.6568542,29 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z" id="Oval-2" sketch:type="MSShapeGroup"></path>
                                                                </g>
                                                                </g>
                                                                </svg>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="wall-opt" class="wall-post-write-opt">
                                                <div class="wall-post-write-cbox">
                                                    <label for="write-cbox">
                                                        <input type="checkbox" name="repost_to_wall" id="write-cbox" checked="" />
                                                        <span class="wall-post-write-cbox-span"></span>
                                                        <span>Allow repost to wall</span>
                                                    </label>
                                                </div>
                                                <div class="wall-post-write-photo">
                                                    <span class="wall-post-write-photo-span"></span>
                                                    <span>Photo</span>
                                                </div>
                                                <div class="wall-post-write-video">
                                                    <span class="wall-post-write-video-span"></span>
                                                    <span>Video</span>
                                                </div>
                                                <div class="wall-post-write-tag">
                                                    <span class="wall-post-write-tag-span"></span>
                                                    <span>Tag People</span>
                                                </div>
                                                <div class="wall-post-write-btn" onclick="submitPost()" id="submit_post">
                                                    <button>Post</button>
                                                    <div class="fb_loader_img hb_simple_loader"><img id="post_loader" style="display: none"src="<?php echo asset('userassets/images/new_loadeer.svg') ?>" alt="loading.." class="fb_loader"></div>
                                                    <span></span>

                                                </div>
                                            </div>
                                            <div id="results"></div>
                                            <input type="hidden" id="img_url" name="image" value="">
                                            <input type="hidden"  value="" name="title">
                                            <input type="hidden" value="" name="content">
                                            <input type="hidden" value="" name="extracted_url">
                                            <input type="hidden" value="" name="url">
                                        </div>
                                    </div>
                                </div>
                                
                                <?php } ?>
                                <div class="wall-post-col-body">
                                    <div class="search-area updated">
                                        <div class="sort-dropdown new_dropdown">
                                            <div class="form-holder">                                        
                                                <form action="" id="q_sorting">
                                                    <fieldset>
                                                        <a href="#" class="new_toggler"><i class="fa fa-angle-down" aria-hidden="true"></i></a>
                                                        <select name="sorting" id="sorting_value">
                                                            <option value="" <?php if ($sorting == 'Please Select') { ?> selected <?php } ?>>Sort By</option>
                                                            <option value="" <?php if ($sorting == 'Newest') { ?> selected <?php } ?>>Newest</option>
                                                            <option value="" <?php if ($sorting == 'Followers First') { ?> selected <?php } ?>>Followers First</option>
                                                            <option value="" <?php if ($sorting == 'Most Liked') { ?> selected <?php } ?>>Most Liked</option>
                                                        </select>
                                                    </fieldset>
                                                </form>
                                                <a href="#" class="options-toggler opener">
                                                    <i class="fa fa-caret-down" aria-hidden="true"></i>
                                                </a>
                                            </div>
                                            <div class="options">
                                                <div class="sort">
                                                    <ul class="list-none">
                                                        <li>
                                                          <!--   <span><img src="<?php echo asset('userassets/images/new-icon.svg') ?>" alt="Newest"></span> -->
                                                            <span>Newest</span>
                                                            <?php if ($sorting == 'Newest') { ?>
                                                                <a href="<?= asset('wall') ?>"></a>
                                                            <?php } ?>
                                                        </li>
                                                        <li>
                                                          <!--   <span><img src="<?php echo asset('userassets/images/new-icon.svg') ?>" alt="Newest"></span> -->
                                                            <span>Followers First</span>
                                                            <?php if ($sorting == 'Followers First') { ?>
                                                                <a href="<?= asset('wall') ?>"></a>
                                                            <?php } ?>
                                                        </li>
                                                        <li>
                                                               <!--   <span><img src="<?php echo asset('userassets/images/wall/liked.svg') ?>" alt="Liked"></span> -->
                                                            <span>Most Liked</span>
                                                            <?php if ($sorting == 'Most Liked') { ?>
                                                                <a href="<?= asset('wall') ?>"></a>
                                                            <?php } ?>
                                                        </li>
                                                    </ul>
                                                    <a href="#" class="options-toggler closer"><i class="fa fa-caret-up" aria-hidden="true"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="wall-post-single" id="user-posts">
                                        <?php //include('includes/posts.php');  ?>

                                    </div>
                                </div>
                            </div></div>
                        <div class="right_sidebars">
                            <?php if($current_user){ include 'includes/rightsidebar.php'; ?>
                            <?php include 'includes/chat-rightsidebar.php';} ?>
                        </div>
                    </div>
                </main>

            </article>
        </div>
        <?php
        $filters = '';
        if (isset($_GET['sorting'])) {
            $filters = $_GET['sorting'];
        }
        ?>

        <?php include('includes/footer.php'); ?>
        <script src="<?php echo asset('userassets/js/dropzone.js'); ?>"></script>
        <script src="<?php echo asset('userassets/js/image-dropzone-config.js'); ?>"></script>
        <script src="<?php echo asset('userassets/js/video-dropzone-config.js'); ?>"></script>
        <script src='<?php echo asset('userassets/js/jquery.events.input.js') ?>' type='text/javascript'></script>
        <script src='<?php echo asset('userassets/js/jquery.elastic.js') ?>' type='text/javascript'></script>
        <script src='<?php echo asset('userassets/js/jquery.mentionsInput.js') ?>' type='text/javascript'></script>
        <script src='<?php echo asset('userassets/js/jquery.bxslider.min.js') ?>' type='text/javascript'></script>



        <script>

        </script>


        <script>

            $(document).ready(function () {

                $(window).on("load", function () {
                    $('#description').css('background', 'transparent');
                    $('#description').attr('placeholder', "Hey Bud, what's on your mind?");
                });

                $('.scroller').scroll(function (e) {
                    $('.scroller').scrollTop(e.target.scrollTop);
                });
            });

            var char_div = $('.wall-post-single-head');
            char_div.text(char_div.text().substring(0, 40));
            $('.wall-read-more').click(function (e) {

                e.preventDefault();
                var close_char_div = $$(this).closest('.wall-post-single-head');
                close_char_div.text(char_div.text().substring(0, 1200));
            });


            function handleFileSelect(evt) {
                var files = evt.target.files; // FileList object
                document.getElementById('img-previews').innerHTML = '';
                // Loop through the FileList and render image files as thumbnails.
                for (var i = 0, f; f = files[i]; i++) {
                    // Only process image files.
                    if (!f.type.match('image.*')) {
                        continue;
                    }
                    $('.img-preview-wrapper').removeClass('hidden');
                    var reader = new FileReader();
                    reader.onload = (function (theFile) {
                        return function (e) {
                            // Render thumbnail.
                            var figure = document.createElement('figure');
                            figure.innerHTML = ['<img class="img-preview" src="', e.target.result,
                                '" title="', escape(theFile.name), '"/>'].join('');
                            document.getElementById('img-previews').insertBefore(figure, null);
                        };
                    })(f);
                    // Read in the image file as a data URL.
                    reader.readAsDataURL(f);
                }
            }


            $("input[type=file]").bind('change', handleFileSelect);



            //constants
            appended_post_count = 0;
            appended_comment_count = 0;

            // Get the modal
            var modal = $('#wallMyModal');
            // main post image gallery modal
            var modal1 = document.getElementById('wallMyModal1');

            // Get the button that opens the modal
            var btn = document.getElementById("openImage");
            var btn1 = document.getElementById("myImage");

            // Get the <span> element that closes the modal
            var span = document.getElementsByClassName("close")[0];

            function load_comments(param) {
                $('#wall-post-single-body-' + param).toggle();
            }

            function like_post(post_id) {
                var current_id = '<?= $current_id ?>';
                $("#wall-post-single-dislike-" + post_id).css("display", "block");
                $("#wall-post-single-like-" + post_id).css("display", "none");
                $("#removed_likes_liksiting_" + post_id).hide();
                var_likes_popup='';
                <?php if($current_user){ ?>
                var_likes_popup = '<li id="hide_likes_liksiting_' + post_id + current_id + '"><div class="img-holder pre-main-image"><span class="hb_round_img hb_bg_img" style="width:35px; height: 35px; display: block; background-image: url(<?php echo $current_photo ?>)"></span> <span class="fest-pre-img" style="background-image: url(<?php echo $current_special_icon_user ?>);"></span>' +
                        '</div><div class="txt <?= getRatingClass($current_user->points); ?>"><i class="fa fa-thumbs-up" aria-hidden="true"></i>' +
                        '<span><a  class="<?= getRatingClass($current_user->points); ?>"  href="<?= asset('user-profile-detail/' . $current_id) ?>"><?= $current_user->first_name ?></a> liked this post</span></div></li>';
                <?php } ?>
                $('#likes_liksiting_' + post_id).prepend(var_likes_popup);
                $.ajax({
                    type: "POST",
                    url: "<?php echo asset('like-post'); ?>",
                    data: {post_id: post_id, is_like: 1},
                    success: function (response) {
                        if (response.message == 'success') {
//                            $("#wall-post-single-dislike-" + post_id).css("display", "block");
//                            $("#wall-post-single-like-" + post_id).css("display", "none");
                            $(".total_likes_btn-" + post_id).find("#likes-count").text(response.likes_count);

//                            $("#likes-count-"+post_id).text(response.likes_count);
                        } else {
                            alert('Error.');
                        }
                    }
                });
            }
            function dislike_post(post_id) {
                var current_id = '<?= $current_id ?>';
                $("#wall-post-single-like-" + post_id).css("display", "block");
                $("#wall-post-single-dislike-" + post_id).css("display", "none");
                $("#hide_likes_liksiting_" + post_id + current_id).hide();
                $.ajax({
                    type: "POST",
                    url: "<?php echo asset('like-post'); ?>",
                    data: {post_id: post_id, is_like: 0},
                    success: function (response) {
                        if (response.message == 'success') {

                            $(".total_likes_btn-" + post_id).find("#likes-count").text(response.likes_count);

                            if (response.likes_count == 0) {
                                $("#removed_likes_liksiting_" + post_id).css("display", "block");
                            }
                            //                            $("#likes-count-"+post_id).text(response.likes_count);
                        } else {
                            alert('Error.');
                        }
                    }
                });
            }

            function dot_menu(param) {
                //hidenot()
                hide_all($(param).parents('.wall-post-single-in-head-opt-area').find('.wall-post-opt-toggle'));


                $(param).parents('.wall-post-single-in-head-opt-area').find('.wall-post-opt-toggle').toggle();
            }
            function com_dot_menu(param) {
                //hidenot()
                hide_all($(param).parents('.wall-post-single-body-in').find('.wall-post-opt-toggle'));

                $(param).parents('.add-com-toggle').find('.wall-post-opt-toggle').toggle();
            }
            function hide_all(hidenot) {
                $('.wall-post-opt-toggle').not(hidenot).hide();
                $('.sort-dropdown .options ul').hide()
            }
            function comment_menu(param) {
                $(param).parents('.wall-post-single-in-head-opt-area').find('.wall-post-opt-toggle').toggle();
            }



            function deletePost(post_id) {
                $.ajax({
                    type: "GET",
                    url: "<?php echo asset('delete-post'); ?>",
                    data: {post_id: post_id},
                    success: function (response) {
                        if (response.message == 'success') {
                            $("#single-post-" + post_id).remove();
                            $("#wall-post-single-body-" + post_id).remove();
                            $('#deleteThanks').fadeIn().fadeOut(5000);
//                                                            
                        } else {
                            alert('Error.');
                        }
                    }
                });
                $('#delete_post-' + post_id).hide(300);
            }


            function deletePostComment(comment_id, post_id) {
                $.ajax({
                    type: "GET",
                    url: "<?php echo asset('delete-comment'); ?>",
                    data: {comment_id: comment_id},
                    success: function (response) {
                        if (response.message == 'success') {
                            skip = $("#skip-comments-" + post_id).val();
                            $("#skip-comments-" + post_id).val(parseInt(skip) - parseInt(1));
                            $("#post-single-comment-" + comment_id).remove();
                            $('#deleteCommentThanks').fadeIn().fadeOut(5000);
                            var comment_count = $('#comments-count-' + post_id).text();
                            comment_count = parseInt(comment_count) - 1;
                            $('#comments-count-' + post_id).text(comment_count);
//                                                            
                        } else {
                            alert('Error.');
                        }
                    }
                });
                $('#delete_post_comment-' + comment_id).hide(300);
            }


            function mutePost(post_id) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo asset('mute-post'); ?>",
                    data: {post_id: post_id, is_mute: 1},
                    success: function (response) {
                        if (response.message == 'success') {
                            $("#single-post-unmute-" + post_id).css("display", "block");
                            $("#single-post-mute-" + post_id).css("display", "none");
                        } else {
                            alert('Error.');
                        }
                    }
                });
            }


            function unmutePost(post_id) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo asset('mute-post'); ?>",
                    data: {post_id: post_id, is_mute: 0},
                    success: function (response) {
                        if (response.message == 'success') {
                            $("#single-post-mute-" + post_id).css("display", "block");
                            $("#single-post-unmute-" + post_id).css("display", "none");
                        } else {
                            alert('Error.');
                        }
                    }
                });
            }



            // When the user clicks anywhere outside of the modal, close it
            window.onclick = function (event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
                if (event.target == modal1) {
                    modal1.style.display = "none";
                }
            }


            function submitPost() {

                // $('#post_loader').show();//show loading indicator image
                $("#submit_post").css('pointer-events', 'none'); //disable post button

                var description_data = '';
                $('textarea.mention').mentionsInput('getMentions', function (data) {

                    if (data.length > 0) {
                        description_data = JSON.stringify(data);
                    }
                  
                });
                var post_description = $('#description').val();
                var repost_to_wall = $('input[name="repost_to_wall"]:checked').length;
                var posting_user = $('#posting_user').val();

                var tagged_users = JSON.stringify($("#select2").select2("val"));


                if (!post_description.trim() && image_attachments.length === 0 && video_attachments.length === 0) {
                    $('#showError').html('Please insert post data.').show().fadeOut(3000);
                    $('#post_loader').hide();
                    $("#submit_post").css('pointer-events', 'auto');
                } else {
                    $('.mentions-autocomplete-list').hide();
                    var images = JSON.stringify(image_attachments);
                    var video = JSON.stringify(video_attachments);
                    var scraped_title = $('input[name="title"]').val();
                    var scraped_content = $('input[name="content"]').val();
                    var scraped_image = $('input[name="image"]').val();
                    var scraped_url = $('input[name="extracted_url"]').val();
                    var site_url = $('input[name="url"]').val();

                    //Disable text area
                    var imageUrl = "<?php echo asset('userassets/images/new_loadeer.svg') ?>";
                    $('#description').css('background-image', 'url(' + imageUrl + ')');
                    $('#description').css('background-position', 'left center');
                    $('#description').css('background-size', '25px 25px');
                    $('#description').css('background-repeat', 'no-repeat');
                    $('#description').attr('readonly', true);

                    $.ajax({
                        type: "POST",
                        url: "<?php echo asset('add-post'); ?>",
                        data: {
                            post_description: post_description,
                            description_data: description_data,
                            posting_user: posting_user,
                            tagged_users: tagged_users,
                            repost_to_wall: repost_to_wall,
                            images: images,
                            video: video,
                            scraped_title: scraped_title,
                            scraped_content: scraped_content,
                            scraped_image: scraped_image,
                            scraped_url: scraped_url,
                            site_url: site_url,
                            _token: $('[name="_token"]').val()
                        },
                        //                    processData: false,
                        //                    contentType: false,
                        success: function (response) {
                            var objDZ = Dropzone.forElement(".dropzone");
                            objDZ.emit("resetFiles");
                            var objDZ = Dropzone.forElement(".dropzone_video");
                            objDZ.emit("resetFiles");

                            total_photos_counter = 0;
                            image_attachments = [];
                            total_videos_counter = 0;
                            video_attachments = [];

                            $('.dropzone').removeClass('dz-started');
                            $("#description").val('');
                            $(".mentions").html('');
                            $("#results").html('');
                            $('#select2').val(null).trigger('change');
                            $("#results").html('');
                            $(".wall-post-write-tag-view").css('display', 'none');
                            $('.wall-post-write-photo-view').css('display', 'none');
                            $('.wall-post-write-sec .dropzone .add-more-plus').remove();
                            $('.wall-post-write-video-view').css('display', 'none');
                            addTextareaTags();
                            $('#post_loader').hide();//hide loader
                            $("#submit_post").css('pointer-events', 'auto'); //enable post button
                            appended_post_count = parseInt(appended_post_count) + 1;
                            //                            setTimeout(function() {
                            $('#user-posts').prepend(response);
                            //                            }, 3000);

                            //Remove laoding from textarea
                            $('#description').css('background', 'transparent');
                            $('#description').css('background-position', '');
                            $('#description').css('background-size', '');
                            $('#description').css('background-repeat', '');
                            $('#description').attr('readonly', false);

//                            addTags();
                        }
                    });
                }

            }
            var win = $(window);
            var count = 0;
            var ajaxcall = 1;
            win.on('scroll', function () {
                var docheight = parseInt($(document).height());
                var winheight = parseInt(win.height());
                var differnce = (docheight - winheight) - win.scrollTop();
                if (differnce < 100) {
                    if (ajaxcall === 1) {
                        $('#loading').show();
                        ajaxcall = 0;
                        var skip = (parseInt(count) * 5) + parseInt(appended_post_count);

                        var response = load_posts(skip, 5);
                    }
                    $('#loading').hide();
                }
            });

            function load_posts(skip, take) {
                 ajaxcall = 0;
                filters = '<?= $filters ?>';
                $('#loaderposts').remove();
                var loader = '<div class="loader" id="loaderposts" style="width:110px"><img src="<?php echo asset('userassets/images/edit_post_loader.svg') ?>"></div>';
                $('#user-posts').append(loader);

                $.ajax({
                    type: "GET",
                    url: "<?php echo asset('get-user-posts/' . $current_id); ?>",
                    data: {skip: skip, take: take, filters: filters},
                    success: function (response) {
                        $('#loaderposts').remove();
                        if (response) {
//                            console.log(response);
                            $('#user-posts').append(response);
//                            addTags();
                            $('.js-example-basic-multiple').select2();
                            ajaxcall = 1;
                            var a = parseInt(1);
                            var b = parseInt(count);
                            count = b + a;
                            var skip = (parseInt(count) * 5) + parseInt(appended_post_count);
                           load_posts(skip, 5);
                            return true;
                        } else {
                            $('#loading').hide();
                            ajaxcall = 0;
                            noposts = ' <div class="loader hb_not_more_posts_lbl" id="nomoreposts">No more post to show</div> ';
                            $('#user-posts').append(noposts);
                            return false;
                        }
                    }
                });
            }

            var slideIndex = 1;
            showDivs(slideIndex);

            function plusDivs(n) {
                showDivs(slideIndex += n);
            }

            function currentDiv(n) {
                showDivs(slideIndex = n);
            }

            function showDivs(n) {
                var i;
                var x = document.getElementsByClassName("mySlides");
                var dots = document.getElementsByClassName("demo");
                if (n > x.length) {
                    slideIndex = 1
                }
                if (n < 1) {
                    slideIndex = x.length
                }
                for (i = 0; i < x.length; i++) {
                    x[i].style.display = "none";
                }
                for (i = 0; i < dots.length; i++) {
                    dots[i].className = dots[i].className.replace(" w3-white", "");
                }
//              x[slideIndex-1].style.display = "block";  
//              dots[slideIndex-1].className += " w3-white";
            }

            $(document).ready(function () {

                // load posts
                var skip = 0;
                var take = 5;
                load_posts(skip, take);


                $.fn.scrollView = function () {
                    return this.each(function () {
                        if ($(this).css('display') != 'none')
                        {
                            $('html, body').animate({
                                scrollTop: $(this).offset().top - 65
                            }, 1000);
                        }
                    });
                };
                var slider = $('.bxslider').bxSlider({
                    mode: 'fade',
                    captions: true,
                    slideWidth: 600
                });
                $('#myImage').on('.modal', function (e) {
                    slider.reloadSlider();
                });
                $('.js-example-basic-multiple').select2();
                $('#wall-opt .wall-post-write-photo').click(function () {
                    $('.wall-post-write-photo-view').toggle()/*.scrollView()*/;
                });
                $('#wall-opt .wall-post-write-video').click(function () {
                    $('.wall-post-write-video-view').toggle()/*.scrollView()*/;
                });
                $('#wall-opt .wall-post-write-tag').click(function () {
                    $('.wall-post-write-tag-view').toggle()/*.scrollView()*/;
                });
                $('.wall-read-more').click(function (e) {
                    e.preventDefault();
                    $('.wall-read-comp-text').toggle();
                });



                //url scraping
                var getUrl = $('#description'); //url to extract from text field
//                getUrl.keyup(function () { //user types url in text field     
                $(document).on('input paste', '#description', function () {

                    new_val = (convertTostring(getUrl.val()));
                    $('#description').val(new_val);
                    //url to match in the text field
                    var match_url = /\b(https?):\/\/([\-A-Z0-9.]+)(\/[\-A-Z0-9+&@#\/%=~_|!:,.;]*)?(\?[A-Z0-9+&@#\/%=~_|!:,.;]*)?/i;
                    //continue if matched url is found in text field
                    if (match_url.test(getUrl.val())) {
//                        $('#post_loader').show();//show loading indicator image
                        $("#submit_post").css('pointer-events', 'none'); //disable post button
                        var extracted_url = getUrl.val().match(match_url)[0]; //extracted first url from text filed
                        var www_url = extracted_url.replace(/(^\w+:|^)\/\//, '');
                        $.ajax({
                            url: "<?php echo asset('scrape-url') ?>",
                            data: {'url': extracted_url},
                            type: "POST",

                            success: function (responseData) {
                                if (responseData[0] == false) {
                                    $('#post_loader').hide();//hide loader
                                    $("#submit_post").css('pointer-events', 'auto');
                                } else {
                                    var inc_image = '';
                                    var data = JSON.parse(responseData);
                                
                                    extracted_images = data.images;
                                    if (data.images instanceof Array) {

                                        total_images = parseInt(data.images.length - 1);
                                        var img_arr_pos = total_images;

                                        if (data.images.length > 0 && data.images.length <= 2) {

                                            img_arr_pos = (data.images.length - 1);
                                            inc_image = inc_image = data.images[(0)];
                                        } else if (data.images.length > 2) {
                                            img_arr_pos = (data.images.length - 2);
                                            inc_image = data.images[(0)];
                                            //                                                                        alert(inc_image)
                                        } else {
                                            inc_image = extracted_images;
                                        }
                                    } else if (data.images instanceof String) {
                                        inc_image = extracted_images;
                                    } //content to be loaded in #results element
                                    if (inc_image) {
//                                        img = '<img src="' + inc_image + '" alt="Image" class="img-responsive">';
                                        img = '<figure class="wall-result-img-view" style="background-image: url(' + inc_image + ');"></figure>';
                                    } else {
                                        img = '';
                                    }
                                    content_to_show ='';
                                    if(data.url != 'www.youtube.com'){
                                       content_to_show=data.content; 
                                    }
//                                    data.content
                                    var content = img + '<div class="quick_show quick_show_post">\
                    <div class="quick_show_preview"><button class="quick_remove"><i class="fa fa-times"\ aria-hidden="true"></i></button><a href="' + extracted_url + '" target="_blank"><div id="extracted_thumb" class="quick_pic_review extracted_thumb" style="background-image:url(' + inc_image + '); background-size:cover; background-position:center;"></div><div class="quick_content"><a href="' + extracted_url + '">' + data.title + '</a></div><div class="quick_content">' + content_to_show + '</div><div class="quick_content"><a href="' + data.url + '">' + data.url + '</a></div></div></a>\
                    \
                </div>';
                                    $('input[name="image"]').val(inc_image);
                                    $('input[name="title"]').val(data.title);
                                    $('input[name="content"]').val(data.content);
                                      
                                    $('input[name="extracted_url"]').val(extracted_url);
                                    $('input[name="url"]').val(data.url);
                                    //load results in the element
                                    //alert($('.quick_pic_review').width());
                                    $("#results").html(content); //append received data into the element
                                    $("#results").slideDown(); //show results with slide down effect

                                    $('#post_loader').hide();//hide loader
                                    $("#submit_post").css('pointer-events', 'auto'); //enable post button

                                    $('.quick_remove').on('click', function () {
                                        $(".mentions").html('');
                                        removeScrapedUrlData();
                                        $('#description').val('');
                                        $("#results").html('');
                                    });
                                }
                            }
                        });
                    } else {
                        removeScrapedUrlData();

                        $('#post_loader').hide();//hide loader
                        $("#submit_post").css('pointer-events', 'auto'); //enable post button
                        $("#results").html('');
                    }
                });
            });


            users = <?= $mention_users ?>;
            budz_users = <?= $mention_budz ?>;

            tags = <?= $tags ?>;
            mention_users = [];
            mention_tags = [];
            $.each(users, function (key, obj) {
                image = getImage(obj.image_path, obj.avatar);
                mention_users.push({
                    id: obj.id,
                    type: "user",
                    name: obj.first_name,
                    avatar: image,
                    trigger: "@"
                });
            });
            $.each(budz_users, function (key, obj) {
                image = getBudzImage(obj.logo);
                mention_users.push({
                    id: obj.id,
                    type: "budz",
                    name: obj.title,
                    avatar: image,
                    trigger: "@"
                });
            });
            $.each(tags, function (key, obj) {
                image = getImage(obj.image_path, obj.avatar);
                mention_tags.push({
                    id: obj.id,
                    type: "tag",
                    name: obj.title,
                    avatar: '<?= asset('userassets/images/ic_hashtag.png') ?>',
                    trigger: "#"
                });
            });

//            $(window).load(function() {

            $(document).ready(function () {
//    setTimeout(function(){
                $('textarea.mention').mentionsInput({

                    onDataRequest: function (mode, query, triggerChar, callback) {

                        if (triggerChar == "@") {
                            var data = mention_users;
                        } else {
                            var data = mention_tags;
                        }
                        data = _.filter(data, function (item) {

                            return item.name.toLowerCase().indexOf(query.toLowerCase()) > -1
                        });
                        
                        callback.call(this, data);
                    }

                });
                $('.mentions').addClass('scroller');


            });
            function addTextareaTags() {
                $('textarea.mention').mentionsInput({

                    onDataRequest: function (mode, query, triggerChar, callback) {

                        if (triggerChar == "@") {
                            var data = mention_users;
                        } else {
                            var data = mention_tags;
                        }
                        data = _.filter(data, function (item) {
                            return item.name.toLowerCase().indexOf(query.toLowerCase()) > -1
                        });

                        callback.call(this, data);
                    }

                });
                $('.mentions').addClass('scroller');
            }
            function getImage(image, avatar) {
                if (image === null && avatar === null) {
                    return '<?= asset('public/images/profile_pics/demo.png') ?>';
                }
                if (image) {

                    if (image.indexOf('http') >= 0) {
                        return image;
                    } else {
                        return '<?= asset('public/images') ?>' + image;
                    }
                }
                if (avatar) {
                    return '<?= asset('public/images') ?>' + avatar;
                }
            }


            function getBudzImage(logo) {
                if (!logo) {
                    return '<?= asset('userassets/images/budz-adz-thumbnail.svg') ?>';
                } else {
                    return '<?= asset('public/images') ?>' + logo;
                }
            }
            var ajax_post_comment=0;
            function postComment(e, obj, post_id) {
                if (e.keyCode === 13) {

                    if(ajax_post_comment == 0){
                        $('.mentions-autocomplete-list').hide();
                        ajax_post_comment=1;
                    var comment = $(obj).val().trim();
                    //empty comment area
                    $(obj).val('');
                    $(obj).parents('.mentions-input-box').find('.mentions').find('div').html('');
                    var description_data = '';
                    $('input.show_tag_hash'+post_id).mentionsInput('getMentions', function (data) {
                        if (data.length > 0) {
                            description_data = JSON.stringify(data);
                        }
                    });
            if (comment.length > 1 || comment_image_attachments.length > 0 || comment_video_attachments.length > 0) {

                        var comment_count = $('#comments-count-' + post_id).text();
                        var images = JSON.stringify(comment_image_attachments);
                        var video = JSON.stringify(comment_video_attachments);
                        var comment_id = $('.comment_id').val();
                        $.ajax({
                            type: "POST",
                            url: "<?php echo asset('add-comment'); ?>",
                            data: {"post_id": post_id, "comment_id": comment_id, "comment": comment, "description_data": description_data, 'images': images, 'video': video},
                            success: function (response) {
                                ajax_post_comment = 0;
                                setTimeout(function(){
                                 ajax_post_comment = 0;   
                                },700);
                                if (response) {
                                    $('.wall-comments-area-' + post_id).prepend(response);
                                    $(obj).val('');
                                    comment_count = parseInt(comment_count) + 1;
                                    $('#comments-count-' + post_id).text(comment_count);

                                    //clear attachments
                                    var objDZ = Dropzone.forElement(".comment_image_dropzone_" + post_id);
                                    objDZ.emit("resetFiles");
                                    var objDZVideo = Dropzone.forElement(".comment_video_dropzone_" + post_id);
                                     objDZVideo.emit("resetFiles");
                                     $('.delete_preview_'+post_id).remove();
                                    $('.wall-write-comment-photo').css('display', 'none');
                                    $('.wall-write-comment-video').css('display', 'none');
                                    comment_image_attachments = [];
                                    comment_video_attachments = [];
                                    $('.comment_image_dropzone_' + post_id).removeClass('dz-started');
                                    $('.comment_video_dropzone_' + post_id).removeClass('dz-started');



                                    //Show image upload
                                    $('#wall-post-comment-image-' + post_id).css('cssText', 'display: inline-block !important');
                                    //Show video upload
                                    $('#wall-post-comment-video-' + post_id).css('cssText', 'display: inline-block !important');
                                    if (!comment_id) {
                                        var skip = $('#skip-comments-' + post_id).val();
                                        $('#skip-comments-' + post_id).val(parseInt(skip) + 1);

                                    } else {
                                        $('.comment_id').val('');
                                    }
                                    appended_comment_count = parseInt(appended_comment_count) + 1;

                                    $('.add-com-toggle').show(200);
                                    
                                    //send notifications
                                    $.ajax({
                                        type: "POST",
                                        url: "<?php echo asset('send-comment-notifications'); ?>",
                                        data: {"post_id": post_id, "description_data": description_data},
                                        success: function (data) {
                                        }
                                    });
                                }
                            }
                        });
                    }

                }}
            }
            ;

            function moreComments(post_id) {
                var total_comments = $("#comments-count-" + post_id).text();
                var skip = $("#skip-comments-" + post_id).val();
                var take = 5;
                var next = parseInt(total_comments) - parseInt(skip);
                if (next > 0) {
                    $.ajax({
                        type: "GET",
                        url: "<?php echo asset('get-post-comments/'); ?>",
                        data: {skip: skip, post_id: post_id, take: take},
                        success: function (response) {
                            if (response) {
                                
                                $('.wall-comments-area-' + post_id).append(response);

                                $("#skip-comments-" + post_id).val(parseInt(skip) + parseInt(take));
                                var proceed = (parseInt(total_comments)) - (parseInt(skip) + parseInt(take));
                                if (proceed <= 0) {
                                    $("#see-more-comments-" + post_id).css("display", "none");
                                }
                            } else {
                                noposts = ' <div class="loader hb_not_more_posts_lbl" id="nomoreposts">No More Comments To Show</div> ';
                                $('#user-posts').append(noposts);
                            }
                        }
                    });
                } else {
                    $("#see-more-comments-" + post_id).css("display", "none");
                }
            }


            function copyPostLink(post_id) {
                var copyText = document.getElementById("post-url-" + post_id);
                copyText.style.display = 'block';
                /* Select the text field */
                copyText.select();

                /* Copy the text inside the text field */
                document.execCommand("copy");
                $('#showcopypaste').show().fadeOut(3000);
                /* Alert the copied text */
//                alert("Copied the text: " + copyText.value);
                copyText.style.display = 'none';


            }


//            function addTags() {
//                $('input.comments-mention').mentionsInput({
//                    onDataRequest: function (mode, query, triggerChar, callback) {
//                        if (triggerChar == "@") {
//                            var data = mention_users;
//                        } else {
//                            var data = mention_tags;
//                        }
//                        data = _.filter(data, function (item) {
//                            return item.name.toLowerCase().indexOf(query.toLowerCase()) > -1
//                        });
//                        callback.call(this, data);
//                    }
//                });
//            }

            /* attach a submit handler to the form */
            function report_post(post_id) {
                $('input[name=reason].reason_' + post_id + ':checked').val();
                reason = $('input[name=reason].reason_' + post_id + ':checked').val();
                $.ajax({
                    type: "POST",
                    url: "<?php echo asset('report-single-post'); ?>",
                    data: {post_id: post_id, reason: reason},
                    success: function (response) {
                        $('#report_post_' + post_id).hide();
                        $('#report-post-' + post_id).hide();
                        $('#reported_post_' + post_id).show();
                        $("#single-post-" + post_id).remove();
                        $("#wall-post-single-body-" + post_id).remove();
                        $('#showreportPost').show().fadeOut(3000);
                    }
                });
            }
            ;


            function removeScrapedUrlData() {
                $('input[name="image"]').val('');
                $('input[name="title"]').val('');
                $('input[name="content"]').val('');
                $('input[name="extracted_url"]').val('');
                $('input[name="url"]').val('');
            }
            function convertTostring(str) {
                duble_space = str.replace(/\s\s+/g, ' ');
                return duble_space.replace(/^\s+/g, "");
            }
            $('#description').click(function () {
                $(this).removeAttr('placeholder');
            });
            $('#description').focusout(function () {
//    alert('asd')
//    $(this).css("height","60px");
            });

        </script>
        <!--for intro screen-->
        <script>
        var intro_screen = document.getElementById('intro_screen');
if (intro_screen) {
    var skip_intro_screen = document.getElementById('skip_intro_screen');

//                skip_intro_screen.addEventListener('click', function () {
//                    intro_screen.style.display = 'none';
//                });

    var skip_intro_screen_mobile = document.getElementById('skip_intro_screen_mobile');

    skip_intro_screen_mobile.addEventListener('click', function () {
        intro_screen.style.display = 'none';
    });

}


var slideIndex = 1;
showSlides(slideIndex);

// Next/previous controls
function nextSlides(n) {
    if (slideIndex == 5) {
        window.location.href = "<?= asset('wall?sorting=Newest&remove_session=true') ?>"
    } else {
        showSlides(slideIndex += n);
    }
}

// Thumbnail image controls
function currentSlide(n) {
    showSlides(slideIndex = n);
}

function showSlides(n) {
    var i;
    var slides = document.getElementsByClassName("intro_slides");
    var dots = document.getElementsByClassName("intro_page");
    if (n > slides.length) {
        slideIndex = 1
    }
    if (n < 1) {
        slideIndex = slides.length
    }
    for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
    }
    for (i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(" active", "");
    }
    slides[slideIndex - 1].style.display = "block";
    dots[slideIndex - 1].className += " active";
}
        </script>
    </body>
</html>