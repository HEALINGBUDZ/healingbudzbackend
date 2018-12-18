<?php
$current_user = Auth::user();
$current_id = $current_user->id;
$current_photo = getImage($current_user->image_path, $current_user->avatar);
?>
<?php foreach ($posts as $post) { ?>
    <div id="single-post-<?= $post->id; ?>">
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
                                <span class="wall-post-leaf-name"><span></span><?= getRatingText($post->User->points) ?></span>
                            </div>
                        </div>
                    </div>
                </div>
<<<<<<< HEAD
                <div class="wall-post-single-in-head-opt-area">
                    <span class="wall-time" id="post-time-<?= $post->id; ?>"><?= timeago($post->created_at); ?></span>
                    <span class="wall-opt-dots" onclick="dot_menu(this)">
                        <img src="<?php echo asset('userassets/images/wall/three-dots.png') ?>" alt="Menu Dots">
                    </span>
                    <div class="wall-post-opt-toggle">
                        <input type="text" id="post-url-<?= $post->id; ?>" value="<?php echo asset('/get-post/' . $post->id) ?>" style="display:none">
                        <ul>
                            <li onclick="copyPostLink(<?= $post->id; ?>)"><a href="javascript:void(0)">Copy Link</a></li>
                            <li>
                                <a href="#report-post-<?= $post->id ?>" class="flag-icon report btn-popup" id="report-post<?php echo $post->id; ?>"  class="flag-icon">Report</a>
                            </li>
                            <li id="single-post-mute-<?= $post->id; ?>" onclick="mutePost(<?= $post->id; ?>)" <?php if ($post->mute_post_by_user_count) { ?> style="display: none" <?php } ?>><a href="javascript:void(0)">Mute</a></li>
                            <li id="single-post-unmute-<?= $post->id; ?>" onclick="unmutePost(<?= $post->id; ?>)" <?php if (!$post->mute_post_by_user_count) { ?> style="display: none" <?php } ?>><a href="javascript:void(0)">Unmute</a></li>
                            <?php if ($current_id == $post->user_id) { ?>
                                <li onclick="deletePost(<?= $post->id; ?>)"><a href="javascript:void(0)">Delete</a></li>
                            <?php } ?>
                        </ul>
=======
                <div class="wall-post-single-in-body">
                    <ul class="list-none post_gallery_thumbs multiple">
                        <li>
                            <figure>
                                <img id="myImage" src="<?php echo asset('userassets/images/wall/post-main.jpg') ?>" alt="Post">
                            </figure>
                        </li>
                        <li>
                            <figure>
                                <img id="myImage" src="<?php echo asset('userassets/images/wall/post-main.jpg') ?>" alt="Post">
                            </figure>
                            <figure>
                                <img id="myImage" src="<?php echo asset('userassets/images/wall/post-main.jpg') ?>" alt="Post">
                            </figure>
                        </li>
                    </ul>
                    <figcaption>
                        <p><?= $post->description;?></p>
                       <a href="<?php echo asset('get-post/'.$post->id); ?>" class="wall-read-more">- Read More</a>
                    </figcaption>

                </div>
                <div class="wall-post-single-in-foot">
                    <div class="wall-post-single-like" id="wall-post-single-like-<?= $post->id; ?>" onclick="like_post(<?= $post->id; ?>)" <?php if($post->liked_count){ ?> style="display: none" <?php } ?>>
                        <span class="wall-post-single-like-span"></span>
                        <span><span id="likes-count"><?= count($post->Likes);?></span> Likes</span>
                    </div>
                    <div class="wall-post-single-like wall-post-like" id="wall-post-single-dislike-<?= $post->id; ?>" onclick="dislike_post(<?= $post->id; ?>)" <?php if(!$post->liked_count){ ?> style="display: none" <?php } ?>>
                        <span class="wall-post-single-like-span"></span>
                        <span><span id="likes-count"><?= count($post->Likes);?></span> Likes</span>
>>>>>>> 1ade925be0b1894514c3b441fb618a11f6506005
                    </div>
                </div>
            </div>
            <div class="wall-post-single-in-body">
                <figure>
                    <div class="align-right">
                        <a class="like_heart" style="display: none" href=""> <i style="color:#ff2525;" class="fa fa-heart" aria-hidden="true"></i></a>
                        <a class="like_heart" href=""> <i class="fa fa-heart-o" aria-hidden="true"></i></a>
                    </div>
                    <img id="myImage" src="<?php echo asset('userassets/images/wall/post-main.jpg') ?>" alt="Post">
                    <figcaption>
                        <p><?= $post->description; ?></p>
                        <a href="<?php echo asset('get-post/' . $post->id); ?>" class="wall-read-more">- Read More</a>
                    </figcaption>
                </figure>
            </div>
            <div class="wall-post-single-in-foot">
                <div class="wall-post-single-like" id="wall-post-single-like-<?= $post->id; ?>" onclick="like_post(<?= $post->id; ?>)" <?php if ($post->liked_count) { ?> style="display: none" <?php } ?>>
                    <span class="wall-post-single-like-span"></span>
                    <span><span id="likes-count"><?= count($post->Likes); ?></span> Likes</span>
                </div>
                <div class="wall-post-single-like wall-post-like" id="wall-post-single-dislike-<?= $post->id; ?>" onclick="dislike_post(<?= $post->id; ?>)" <?php if (!$post->liked_count) { ?> style="display: none" <?php } ?>>
                    <span class="wall-post-single-like-span"></span>
                    <span><span id="likes-count"><?= count($post->Likes); ?></span> Likes</span>
                </div>
                <div class="wall-post-single-comment" onclick="load_comments(<?= $post->id; ?>)">
                    <span class="wall-post-single-comment-span"></span>
                    <span><span id="comments-count-<?= $post->id; ?>"><?= $post->comments_count; ?></span> Comments</span>
                </div>
                <?php if ($post->allow_repost == 1 && $post->user_id != $current_id) { ?>
                    <div class="wall-post-single-repost">
                        <span class="wall-post-single-repost-span"></span>
                        <span><?= $post->shared_count ?> Reposts</span>
                    </div>
                <?php } ?>
            </div>
        </div>
        <div class="wall-post-single-body" id="wall-post-single-body-<?= $post->id; ?>">
            <div class="wall-post-single-body-in">
                <div class="wall-comments-write">
                    <div class="wall-write-comment">
                        <div class="wall-post-profile-image">
                            <figure style="background-image: url(<?php echo $current_photo ?>);"></figure>
                        </div>
                        <div id="wall-comment-textarea" class="wall-post-write-textarea">
                            <input type="text" name="" class="comment-mention" onkeyup="postComment(event, this, <?= $post->id; ?>)" placeholder="Write a Comment..." />
                            <div class="wall-post-write-photo">
                                <span class="wall-post-write-photo-span"></span>
                            </div>
<<<<<<< HEAD
                            <span class="wall-mid-border"></span>
                            <div class="wall-post-write-video">
                                <span class="wall-post-write-video-span"></span>
                            </div>
                            <span class="wall-post-enter">Press enter to post</span>
                        </div>
=======
                            <div id="wall-comment-textarea" class="wall-post-write-textarea">
                                <input type="text" name="" class="comment-mention" onkeyup="postComment(event,this, <?= $post->id; ?>)" placeholder="Write a Comment..." />
                                <div class="wall-post-write-photo">
                                    <input type="file" multiple id="comment_file-1" class="hidden" accept="image/*">
                                    <label for="comment_file-1" class="wall-post-write-photo-span"></label>
                                </div>
                                <span class="wall-mid-border"></span>
                                <div class="wall-post-write-video">
                                    <input type="file" multiple id="comment_video-1" class="hidden" accept="video/*">
                                    <label for="comment_video-1" class="wall-post-write-video-span"></label>
                                </div>
                                <span class="wall-post-enter">Press enter to post</span>
                                <ul class="list-none" id="uploaded_images"></ul>
                            </div>
                            <div class="wall-write-comment-photo" style="height: 50px;"></div>
                            <div class="wall-write-comment-video" style="height: 50px;"></div>
                    </div>
                    <div class="wall-comments-area-<?= $post->id; ?>">
                        <?php $comments = $post->Comments->sortByDesc('created_at'); ?>
                        
                        <?php include('post_comments.php'); ?>
                        
>>>>>>> 1ade925be0b1894514c3b441fb618a11f6506005
                    </div>
                    <div class="wall-write-comment-photo" style="height: 50px;"></div>
                    <div class="wall-write-comment-video" style="height: 50px;"></div>
                </div>
                <div class="wall-comments-area-<?= $post->id; ?>">
                    <?php $comments = $post->Comments->sortByDesc('created_at'); ?>

                    <?php include('post_comments.php'); ?>

                </div>
            </div>
            <div class="wall-seemore-btn" id="see-more-comments-<?= $post->id; ?>" <?php if ($post->comments_count <= 5) { ?> style="display:none" <?php } ?>>
                <input type="hidden" id="skip-comments-<?= $post->id; ?>" value="5" >
                <a href="javascript:void(0)" onclick="moreComments(<?= $post->id; ?>)">See more Comments</a>
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
<<<<<<< HEAD
    </div>
<?php } ?>
=======
    <?php } ?>
  <script>
            $('.post_gallery_thumbs img').click(function(){
                $('#strain-gallery').fadeIn(300);
                setTimeout(function() { initCycleCarousel(); }, 1000);
            });
        </script>
>>>>>>> 1ade925be0b1894514c3b441fb618a11f6506005
