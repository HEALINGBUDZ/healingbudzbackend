<!DOCTYPE html>
<html lang="en">
    <link href='https://fonts.googleapis.com/css?family=PT+Sans&subset=latin' rel='stylesheet' type='text/css'>
    <link href='<?php echo asset('userassets/css/jquery.mentionsInput.css') ?>' rel='stylesheet' type='text/css'>
    <!--<link href='<?php // echo asset('userassets/css/style.css') ?>' rel='stylesheet' type='text/css'>-->
    <?php include('includes/top.php'); ?>
    <body class="wall">
        <div id="wrapper">
            <?php include('includes/sidebar.php'); ?>
            <article id="content">
                <?php include('includes/header.php'); ?>
                <!-- for drop zone -->
                <link rel="stylesheet" href="<?php // echo asset('userassets/css/bootstrap.css'); ?>">
                <link rel="stylesheet" href="<?php echo asset('userassets/css/dropzone.css'); ?>">
                <link rel="stylesheet" href="<?php echo asset('userassets/css/custom.css'); ?>">
                <!-- for drop zone -->
                <link rel="stylesheet" href="<?php echo asset('userassets/css/jquery.bxslider.css'); ?>">
                <link rel="stylesheet" href="<?php echo asset('userassets/css/wall.css'); ?>">
                <script src='//cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js' type='text/javascript'></script>

                <main id="wall">
                    <div class="wall-post-col">
<!--                        <div class="wall-post-col-head">
                            <div class="wall-search">
                                <input type="search" name="search" placeholder="Hey Bud, what would you like to search for?" />
                            </div>
                        </div>-->
                        <div class="wall-post-col-body">
                            <div class="wall-post-single" id="user-posts">
                               <div id="single-post">
                                    <div class="wall-post-single-head">
                                        <div class="wall-post-single-in-head">
                                            <div class="wall-post-single-in-head-img-area">
                                                <div class="wall-post-profile-image">
                                                    <figure style="background-image: url(<?php echo getImage($post->User->image_path, $post->User->avatar) ?>);"></figure>
                                                </div>
                                                <div class="wall-post-profile-detail <?= getRatingClass($post->User->points); ?>">
                                                    <div class="wall-post-profile-detail-in">
                                                        <h2><?= $post->User->first_name; ?></h2>
                                                        <div class="wall-post-leaf-main">
                                                            <span class="wall-post-leaf">
                                                                <img src="<?= getRatingImage($post->User->points); ?>" alt="" /> 
                                                                <span><?= $post->User->points; ?></span>
                                                            </span>
                                                            <span class="wall-post-leaf-name"><span></span><?= getRatingText($post->User->points)?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="wall-post-single-in-head-opt-area">
                                                <span class="wall-time" id="post-time"><?= timeago($post->created_at); ?></span>
                                                <span class="wall-opt-dots" onclick="dot_menu(this)">
                                                    <img src="<?php echo asset('userassets/images/wall/three-dots.png') ?>" alt="Menu Dots">
                                                </span>
                                                <div class="wall-post-opt-toggle">
                                                    <input type="text" id="post-url-<?= $post->id; ?>" value="<?php echo asset('/get-post/'.$post->id)?>" style="display:none">
                                                    <ul>
                                                        <li onclick="copyPostLink(<?= $post->id; ?>)"><a href="javascript:void(0)">Copy Link</a></li>
                                                        <li>
                                                            <a href="#share-post" class="flag-icon btn-popup">Share</a>
                                                        </li>
                                                        <li>
                                                            <a href="#report-post-<?= $post->id ?>" class="flag-icon report btn-popup" id="report-post<?php echo $post->id; ?>"  class="flag-icon">Report</a>
                                                        </li>
                                                        <li id="single-post-mute-<?= $post->id; ?>" onclick="mutePost(<?= $post->id; ?>)" <?php if ($post->mute_post_by_user_count) { ?> style="display: none" <?php } ?>><a href="javascript:void(0)">Mute</a></li>
                                                        <li id="single-post-unmute-<?= $post->id; ?>" onclick="unmutePost(<?= $post->id; ?>)" <?php if (!$post->mute_post_by_user_count) { ?> style="display: none" <?php } ?>><a href="javascript:void(0)">Unmute</a></li>
                                                        <?php if ($current_id == $post->user_id) { ?>
                                                            <li onclick="deletePost(<?= $post->id; ?>)"><a href="javascript:void(0)">Delete</a></li>
                                                        <?php } ?>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="wall-post-single-in-body">
                                            <ul class="list-none post_gallery_thumbs <?php if (count($post->files) > 2) { ?> multiple <?php } ?>" onclick="showpopup('<?= $post->id ?>')">
                                                <?php foreach ($post->files->take(3) as $file) { ?>
                                                    <li >
                                                        <?php if ($file->type == 'image') { ?>
                                                            <figure>
                                                                <img id="myImage" src="<?php echo asset('public/images' . $file->file) ?>" alt="Post">
                                                            </figure>
                                                        <?php } else { ?>
                                                        <figure>
                                                                <img id="myImage" src="<?php echo asset('public/images' . $file->poster) ?>" alt="Post">
                                                            </figure>

                                                        <?php } ?>
                                                    </li>
                                                <?php } ?>
                                            </ul>
                                            <figcaption>
                                                <p><?= postDescription($post->description, $post->json_data); ?>
                                                </p>
                                                <ul>
                                                    -with
                                                <?php foreach ($post->Tagged  as $tagged_user) { ?>
                                                    <li>
                                                        <a href="<?=  asset('user-profile-detail/'.$tagged_user->user->id)?>"><?= $tagged_user->user->first_name?></a>
                                                    </li>
                                                <?php } ?>
                                                    </ul>
                                                <a href="<?php echo asset('get-post/' . $post->id); ?>" class="wall-read-more">- Read More</a>
                                            </figcaption>
                                            <?php if($post->scrapedUrl && count($post->files) == 0){ ?>
                                                <div class="scraped-data">
                                                    <h4><?= $post->scrapedUrl->title ?></h4>
                                                    <p><?= $post->scrapedUrl->content ?></p>
                                                    <img src="<?= $post->scrapedUrl->image; ?>" alt="">
                                                </div>
                                            <?php } ?>
                                        </div>
                                        <div class="wall-post-single-in-foot">
                                            <div class="wall-post-single-like" id="wall-post-single-like-<?= $post->id; ?>" onclick="like_post(<?= $post->id; ?>)" <?php if($post->liked_count){ ?> style="display: none" <?php } ?>>
                                                <span class="wall-post-single-like-span"></span>
                                                <span><span id="likes-count"><?= count($post->Likes);?></span> Likes</span>
                                            </div>
                                            <div class="wall-post-single-like wall-post-like" id="wall-post-single-dislike-<?= $post->id; ?>" onclick="dislike_post(<?= $post->id; ?>)" <?php if(!$post->liked_count){ ?> style="display: none" <?php } ?>>
                                                <span class="wall-post-single-like-span"></span>
                                                <span><span id="likes-count"><?= count($post->Likes);?></span> Likes</span>
                                            </div>
                                            <div class="wall-post-single-comment" onclick="load_comments(<?= $post->id; ?>)">
                                                <span class="wall-post-single-comment-span"></span>
                                                <span><span id="comments-count"><?= count($post->Comments);?></span> Comments</span>
                                            </div>
                                            <?php //if ($post->allow_repost == 1 && $post->user_id != $current_id) { ?>
                                            <div class="wall-post-single-repost">
                                                <span class="wall-post-single-repost-span"></span>
                                                <span><?= ($post->shared_count);?> <a href="#repost_popup" class="btn-popup">Reposts</a></span>
                                            </div>
                                            <?php //} ?>
                                        </div>
                                    </div>
                                    <div class="wall-post-single-body" id="wall-post-single-body">
                                        <div class="wall-post-single-body-in">
                                            <div class="wall-comments-write">
                                                <div class="wall-write-comment">
                                                    <div class="wall-post-profile-image">
                                                        <figure style="background-image: url(<?php echo $current_photo ?>);"></figure>
                                                    </div>
                                                    <div id="wall-comment-textarea" class="wall-post-write-textarea">
                                                        <input type="text" name="" class="comments-mention" onkeyup="postComment(event,this, <?= $post->id; ?>)" placeholder="Write a Comment..." />
                                                        <div class="wall-post-write-photo">
                                                            <span class="wall-post-write-photo-span"></span>
                                                        </div>
                                                        <span class="wall-mid-border"></span>
                                                        <div class="wall-post-write-video">
                                                            <span class="wall-post-write-video-span"></span>
                                                        </div>
                                                        <span class="wall-post-enter">Press enter to post</span>
                                                    </div>
                                                </div>
                                                <div class="wall-write-comment-photo"  >
                                                    <div class="container-fluid">
                                                        <div class="row">
                                                            <div class="col-sm-10 offset-sm-1">
                                                                <!--<h2 class="page-heading">Upload your Images <span id="image-counter"></span></h2>-->
                                                                <form method="post" action="<?php echo asset('/images-save'); ?>" enctype="multipart/form-data" class="dropzone comment_image_dropzone" id="comment-dropzone-image">
                                                                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                                                    <div class="dz-message">
                                                                        <div class="col-xs-8">
                                                                            <div class="message">
                                                                                <p>Drop files here or Click to Upload</p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="fallback">
                                                                        <input type="file" name="file" multiple>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                        <div id="comment-image-preview" style="display: none;">
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
                                                <div class="wall-write-comment-video">
                                                    <div class="container-fluid">
                                                        <div class="row">
                                                            <div class="col-sm-10 offset-sm-1">
                                                                <!--<h2 class="page-heading">Upload your Video <span id="video-counter"></span></h2>-->
                                                                <form method="post" action="<?php echo asset('/video-save'); ?>" enctype="multipart/form-data" class="dropzone comment_video_dropzone" id="comment-dropzone-video">
                                                                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                                                    <div class="dz-message">
                                                                        <div class="col-xs-8">
                                                                            <div class="message">
                                                                                <p>Drop files here or Click to Upload</p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="fallback">
                                                                        <input type="file" name="file" multiple>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                        <div id="comment-video-preview" style="display: none;">
                                                            <div class="dz-preview dz-file-preview">
                                                                <div class="dz-image video-poster"><img data-dz-thumbnail /></div>
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
                                            </div>
                                            <div class="wall-comments-area-<?= $post->id; ?>">
                                                <?php $comments = $post->Comments->sortByDesc('created_at');; ?>
                                                <?php foreach($comments as $comment) { ?>
                                                    <div class="wall-comments-inner">
                                                        <div class="wall-post-single-in-head">
                                                            <div class="wall-post-single-in-head-img-area">
                                                                <div class="wall-post-profile-image">
                                                                    <figure style="background-image: url(<?php echo getImage($comment->User->image_path, $comment->User->avatar) ?>);"></figure>
                                                                </div>
                                                                <div class="wall-post-profile-detail <?= getRatingClass($comment->User->points); ?>">
                                                                    <div class="wall-post-profile-detail-in">
                                                                        <h2><a href="<?= asset('user-profile-detail/'.$comment->User->id)?>"><?= $comment->User->first_name; ?></a></h2>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="wall-post-single-in-head-opt-area">
                                                                <span class="wall-time" ><?= timeago($comment->created_at); ?></span>
                                                    <!--            <span class="wall-opt-dots" onclick="comment_menu(this)">
                                                                    <img src="<?php echo asset('userassets/images/wall/three-dots.png') ?>" alt="Menu Dots">
                                                                </span>
                                                                <div class="wall-post-opt-toggle">
                                                                    <ul>
                                                                        <li><a href="#">Copy Link</a></li>
                                                                        <li><a href="#">Report</a></li>
                                                                        <li><a href="#">Delete</a></li>
                                                                    </ul>
                                                                </div>-->
                                                            </div>
                                                        </div>
                                                        <div class="wall-comment-view">
                                                            <p><?= $comment->comment; ?></p>
                                                    <!--        <figure>
                                                                <div class="wall-comment-view-image" style="background-image:url(<?php echo asset('userassets/images/wall/wall-comment-image.png') ?>);">
                                                                    <div class="wall-comment-layer">
                                                                        <button id="openImage">Open Image</button>
                                                                    </div>
                                                                </div>
                                                            </figure>-->
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- The Modal -->
                                    <div id="wallMyModal" class="wall-modal">
                                        <!-- Modal content -->
                                        <div class="modal-content">
                                            <span class="close">&times;</span>
                                            <figure>
                                                <img src="<?php echo asset('userassets/images/wall/wall-comment-image.png') ?>" alt="Image">
                                            </figure>
                                        </div>
                                    </div>
                                    <div id="wallMyModal1" class="wall-modal">
                                        <!-- Modal content -->
                                        <div class="modal-content">
                                            <span class="close">&times;</span>
                                            <figure>
                                                <ul>
                                                    <li class="mySlides"><img src="<?php echo asset('userassets/images/wall/wall-comment-image.png') ?>" alt="Image"></li>
                                                    <li class="mySlides"><img src="<?php echo asset('userassets/images/wall/post-main.jpg') ?>" alt="Image"></li>
                                                    <li class="mySlides">
                                                        <video width="320" height="240" controls>
                                                            <source src="<?php echo asset('userassets/videos/sample.mp4') ?>" type="video/mp4">
                                                        </video>
                                                    </li>
                                                    <li class="mySlides"><img src="<?php echo asset('userassets/images/wall/post-main.jpg') ?>" alt="Image"></li>
                                                    <li class="mySlides"><img src="<?php echo asset('userassets/images/wall/wall-comment-image.png') ?>" alt="Image"></li>
                                                </ul>
                                                <div class="" style="width:100%">
                                                    <div class="" onclick="plusDivs(-1)">&#10094;</div>
                                                    <div class="" onclick="plusDivs(1)">&#10095;</div>
                                                    <span class="demo" onclick="currentDiv(1)"></span>
                                                    <span class="demo" onclick="currentDiv(2)"></span>
                                                    <span class="demo" onclick="currentDiv(3)"></span>
                                                </div>
                                            </figure>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="share-post" class="popup">
                        <div class="popup-holder">
                            <div class="popup-area">
                                <div class="reporting-form">
                                    <h2>Select an option</h2>
                                    <div class="custom-shares custom_style">
                                        <?php
                                            echo Share::page(asset('get-post/' . $post->id), $post->description, ['class' => 'strain_class','id'=>$post->id])
                                            ->facebook($post->description)
                                            ->twitter($post->description)
                                            ->googlePlus($post->description);
                                        ?>
                                    </div>
                                    <a href="#" class="btn-close"><i class="fa fa-times-circle-o" aria-hidden="true"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="report-post-<?= $post->id ?>" class="popup">
                        <div class="popup-holder">
                            <div class="popup-area">
                                <form action="<?php echo asset('report-single-post'); ?>" class="reporting-form" method="post">
                                    <input type="hidden" value="<?php echo $post->id; ?>" name="post_id">
                                    <input type="hidden" value="<?php echo csrf_token(); ?>" name="_token">
                                    <fieldset>
                                        <h2>Reason For Reporting</h2>
                                        
                                          <input type="radio" name="reason" id="sexual<?= $post->id ?>" checked value="Nudity or sexual content">
                            <label for="sexual<?= $post->id ?>">Nudity or sexual content</label>

                            <input type="radio" name="reason" id="harasssment<?= $post->id ?>"  value="Harassment or hate speech">
                            <label for="harasssment<?= $post->id ?>">Harassment or hate speech</label>

                            <input type="radio" name="reason" id="threatening<?= $post->id ?>"  value="Threatening, violent, or concerning">
                            <label for="threatening<?= $post->id ?>">Threatening, violent, or concerning</label>
                            
                                        <input type="radio" name="reason" id="abused<?= $post->id ?>"  value="Abused">
                                        <label for="abused<?= $post->id ?>">Post is offensive</label>
                                        <input type="radio" name="reason" id="spam<?= $post->id ?>" value="Spam">
                                        <label for="spam<?= $post->id ?>">Spam</label>
                                        <input type="radio" name="reason" id="unrelated<?= $post->id ?>" value="Unrelated">
                                        <label for="unrelated<?= $post->id ?>">Unrelated</label>
                                        <input type="submit" value="Report Post">
                                        <a href="#" class="btn-close">x</a>
                                    </fieldset>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    <div id="repost_popup" class="popup sharing_popup">
                        <div class="popup-holder">
                            <div class="popup-area">
                                <div class="reporting-form">
                                    <h3>Share post</h3>
                                    <div class="share_popup_text">
                                        <div class="share_img_holder"><img src="userassets/images/img1.jpg" alt="Image" class="img-responsive"></div>
                                        <p>Neque porro quisquam est qui <strong>@john</strong> ipsum quia dolor sit amet, consectetur, adipisci velit <em>Neque porro</em> quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit. est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit</p>
                                    </div>
                                    <div class="to_whom">
                                         <div class="wall-post-write-tag-view">
                                            <span class="wall-with-span">with</span>
                                            <select class="js-example-basic-multiple tagged-budz" name="states[]" multiple="multiple">
                                                <option value="">First Name</option>
                                                <option value="">Middle Name</option>
                                                <option value="">Last Name</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="sharing_footer">
                                        <div class="post_as">
                                            <span>Post as</span>
                                            <select class="wall-post-profile-btn">
                                                <option value="u_1">ijaz</option>
                                                <option value="s_1">test1</option>
                                                <option value="s_3">test3</option>
                                                <option value="s_6">test medical</option>
                                                <option value="s_7">test medical</option>
                                                <option value="s_8">test medical</option>
                                                <option value="s_9">test medical</option>
                                                <option value="s_10">test event</option>
                                                <option value="s_13"> new one</option>
                                                <option value="s_14">u 56 54</option>
                                            </select>
                                        </div>
                                        <a href="Share Post" class="submit_btn">Share Post</a>
                                    </div>
                                    <a href="#" class="btn-close"><i class="fa fa-times-circle-o" aria-hidden="true"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php include 'includes/rightsidebar.php';?>
                </main>
            </article>
        </div>
        <?php include('includes/footer.php'); ?>
        <script src="<?php echo asset('userassets/js/dropzone.js'); ?>"></script>
        <script src="<?php echo asset('userassets/js/post-comment-image-dropzone-config.js'); ?>"></script>
        <script src="<?php echo asset('userassets/js/post-comment-video-dropzone-config.js'); ?>"></script>
        <script src='<?php echo asset('userassets/js/jquery.events.input.js') ?>' type='text/javascript'></script>
        <script src='<?php echo asset('userassets/js/jquery.elastic.js') ?>' type='text/javascript'></script>
        <script src='<?php echo asset('userassets/js/jquery.mentionsInput.js') ?>' type='text/javascript'></script>
        <script src='<?php echo asset('userassets/js/jquery.bxslider.min.js') ?>' type='text/javascript'></script>
        <script>
            //constants
            appended_post_count = 0;
            
            // Get the modal
            var modal = $('#wallMyModal');
            // main post image gallery modal
            var modal1 = document.getElementById('wallMyModal1');

            // Get the button that opens the modal
            var btn = document.getElementById("openImage");
            var btn1 = document.getElementById("myImage");

            // Get the <span> element that closes the modal
            var span = document.getElementsByClassName("close")[0];

//            function test(obj){
//                $(obj).parents('.wall-post-single').find('.wall-post-single-body').toggle();
//            }
            function load_comments(param){
//                alert('#wall-post-single-body-'+param)
//                $(param).parents('.wall-post-single').find('#wall-post-single-body-'+param).toggle();
                $('#wall-post-single-body').toggle();
            }
            
            function like_post(post_id){
                $.ajax({
                    type: "POST",
                    url: "<?php echo asset('like-post'); ?>",
                    data: {post_id: post_id, is_like:1},
                    success: function (response) {
                        if(response.message == 'success'){
                            $("#wall-post-single-dislike-"+post_id).css("display", "block");
                            $("#wall-post-single-like-"+post_id).css("display", "none");
                            $("#wall-post-single-dislike-"+post_id).find("#likes-count").text(response.likes_count);
//                            $("#likes-count-"+post_id).text(response.likes_count);
                        }
                        else{
                            alert('Error.');
                        }
                    }
                });
                
//                $('#wall-post-single-like-'+param).addClass('wall-post-like');
            }
            
            function dislike_post(post_id){
                $.ajax({
                    type: "POST",
                    url: "<?php echo asset('like-post'); ?>",
                    data: {post_id: post_id, is_like:0},
                    success: function (response) {
                        if(response.message == 'success'){
                            $("#wall-post-single-like-"+post_id).css("display", "block");
                            $("#wall-post-single-dislike-"+post_id).css("display", "none");
                            $("#wall-post-single-like-"+post_id).find("#likes-count").text(response.likes_count);
//                            $("#likes-count-"+post_id).text(response.likes_count);
                        }
                        else{
                            alert('Error.');
                        }
                    }
                });
                
            }
            
            function dot_menu(param){
                $(param).parents('.wall-post-single-in-head-opt-area').find('.wall-post-opt-toggle').toggle();
                return false;
            }
             
            function comment_menu(param){
                $(param).parents('.wall-post-single-in-head-opt-area').find('.wall-post-opt-toggle').toggle();
            }
            
           function deletePost(post_id){
//                alert(post_id);
                $.ajax({
                    type: "GET",
                    url: "<?php echo asset('delete-post'); ?>",
                    data: {post_id: post_id},
                    success: function (response) {
                        if(response.message == 'success'){
                            $("#single-post-"+post_id).remove();
                            alert('Post deleted successfully.');
                        }
                        else{
                            alert('Error.');
                        }
                    }
                });
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
            
            
//            // When the user clicks the button, open the modal 
//            btn.onclick = function () {
//                modal.style.display = "block";
//            }
//            btn1.onclick = function () {
//                modal1.style.display = "block";
//            }

//             When the user clicks on <span> (x), close the modal
//            span.onclick = function () {
//                modal.style.display = "none";
//            }
//            span.onclick = function () {
//                modal1.style.display = "none";
//            }

            // When the user clicks anywhere outside of the modal, close it
            window.onclick = function (event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
                if (event.target == modal1) {
                    modal1.style.display = "none";
                }
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
              if (n > x.length) {slideIndex = 1}    
              if (n < 1) {slideIndex = x.length}
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
                
                $.fn.scrollView = function () {
                    return this.each(function () {
                        if ($(this).css('display') !='none')
                        {
                            $('html, body').animate({
                                scrollTop: $(this).offset().top-65
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
//                $('#wall-opt .wall-post-write-photo').click(function () {
//                    $('.wall-post-write-photo-view').toggle().scrollView();
//                });
//                $('#wall-opt .wall-post-write-video').click(function () {
//                    $('.wall-post-write-video-view').toggle().scrollView();
//                });
                $('#wall-opt .wall-post-write-tag').click(function () {
                    $('.wall-post-write-tag-view').toggle().scrollView();
                });
                $('.wall-read-more').click(function (e) {
                    e.preventDefault();
                    $('.wall-read-comp-text').toggle();
                });
                $('#wall-comment-textarea .wall-post-write-photo').click(function () {
                    $('.wall-write-comment-photo').toggle();
                });
                $('#wall-comment-textarea .wall-post-write-video').click(function () {
                    $('.wall-write-comment-video').toggle();
                });
                
                addTags();
            });
            
            
            users = <?= $users ?>;
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

            $.each(tags, function (key, obj) {
                image = getImage(obj.image_path, obj.avatar);
                mention_tags.push({
                    id: obj.id,
                    type: "tag",
                    name: obj.title,
                    avatar: '',
                    trigger: "#"
                });
            });
            
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

            $('input .comments-mention').mentionsInput({

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
            
            function postComment(e,obj, post_id) {
//                var _this = $(this);
                if (e.keyCode === 13) {
                    var comment = $(obj).val().trim();
                    if (comment.length > 1 || comment_image_attachments.length > 0 || comment_video_attachments.length > 0) {
                        var comment_count = $('#comments-count').text();
                        var images = JSON.stringify(comment_image_attachments);
                        var video = JSON.stringify(comment_video_attachments);
                        $.ajax({
                            type: "POST",
                            url: "<?php echo asset('add-comment'); ?>",
                            data: {post_id: post_id, comment: comment, images: images, video:video},
                            success: function (response) {
                                if (response) {
                                    $('.wall-comments-area-'+post_id).prepend(response);
                                    $(obj).val('');
                                    comment_count = parseInt(comment_count)+1;
                                    $('#comments-count').text(comment_count);
                                    
                                    //clear attachments
                                    var objDZ = Dropzone.forElement(".comment_image_dropzone");
                                    objDZ.emit("resetFiles");
                                    var objDZ = Dropzone.forElement(".comment_video_dropzone");
                                    objDZ.emit("resetFiles");
                                    $('.delete_preview_'+post_id).remove();
                                    total_photos_counter = 0;
                                    comment_image_attachments = [];
                                    total_videos_counter = 0;
                                    comment_video_attachments = [];

                                    $('.dropzone').removeClass('dz-started');
                                    
                                    //Show image upload
                                    $('.wall-post-write-photo').css('display','block');
                                    //Show video upload
                                    $('.wall-post-write-video').css('display','block');
                                }
                                
                            }
                        });
                    }
                }
            };
            
            
            function copyPostLink(post_id){
                var copyText = document.getElementById("post-url-"+post_id);
                copyText.style.display = 'block';
                /* Select the text field */
                copyText.select();

                /* Copy the text inside the text field */
                document.execCommand("copy");
                /* Alert the copied text */
                $('#showcopypaste').show().fadeOut(3000);
//                alert("Copied the text: " + copyText.value);
                copyText.style.display = 'none';
            }
            
            
            
            
            $('.sort ul li').click(function() {
            });
            
            function addTags() {
                $('input.comments-mention').mentionsInput({

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
            }
            
        </script>
    </body>
</html>