<!DOCTYPE html>
<html lang="en">
    <style>
        .aclass{    
            position: absolute;
            right: 17px;
            z-index: 10;
            font-size: 23px;
            color: white;
            cursor: pointer;
        }
    </style>
    <?php include('includes/top-new.php'); ?>
    <body>
        <div id="wrapper">
            <?php include('includes/sidebar.php'); ?>
            <article id="content">
                <?php include('includes/header.php'); ?>
                <div class="padding-div">
                    <div class="new_container">
                        <ul class="bread-crumbs list-none">
                            <li><a href="<?php echo asset('/'); ?>">Home</a></li>
                            <!--<li><a href="<?php // echo asset('questions');           ?>">Q&amp;A</a></li>-->
                            <li>Profile</li>
                        </ul>
                        <div class="profile-area">

                            <?php include 'includes/user-profile-header.php'; ?>
                            <?php if($user->id == $current_id) { ?>
                            <div class="gallery-upload-btn">
                                <form action="<?php echo asset('add-hb-mdeia') ?>" class="upload-form" id="upload_image_gallery" method="POST" enctype="multipart/form-data">
                                    <input type="file" name="image" id="gal-img" accept="image/*">
                                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">

 <!--<label for="gal-img"><i class="fa fa-upload" aria-hidden="true"></i></label>-->
                                    <label for="gal-img">
                                        <img src="<?php echo asset('userassets/images/gallery-big.png') ?>" alt="Gallery Icon" />
                                        <span>Upload Photo</span>
                                    </label>
                                </form>
                            </div>
                            <?php  } ?>
                            <!--<div class="activity-area">-->
                            <ul class="strain-gallery list-none">
                                <?php if (count($images) > 0) { ?>
                                    <?php foreach ($images as $image) { ?>
                                        <li>
                                            <?php
                                            if ($image->type == 'image') {
                                                if ($image->user_id == $current_id) {
                                                    ?>
                                                    <a class="aclass" href="<?= asset('delete-hb-gallery/' . $image->id) ?>">x</a>
                                                <?php } ?>
                                                    <a href="<?php echo asset('public/images' . $image->path) ?>" data-fancybox="gallery"><figure class="hb-gallery-img" style="background-image: url(<?php echo asset('public/images' . $image->path) ?>);"></figure></a>
                                            <!--<img src="<?php // echo asset('public/images' . $image->path)     ?>" class="img-responsive" alt="Image">-->
                                                <?php
                                            } else if ($image->type == 'video') {
                                                if ($image->user_id == $current_id) {
                                                    ?>
                                                    <a class="aclass" href="<?= asset('delete-hb-gallery/' . $image->id) ?>">x</a>
                                                <?php } ?> <video controls width="100%" height="100%"  poster="<?php echo asset('public/images' . $image->poster) ?>">
                                                    <source src="<?php echo asset('public/videos' . $image->path) ?>" type="video/mp4" />
                                                </video>​
                                            <?php } ?>
                                        </li>
                                    <?php } ?>
                                <?php } else { ?>
                                    <li class="hb_not_more_posts_lbl">No record found</li>
                                <?php } ?>
                            </ul>
                            <!--</div>-->
                        </div>
                    </div> <div class="right_sidebars">
                        <?php if($current_user){ include 'includes/rightsidebar.php'; ?>
                        <?php include 'includes/chat-rightsidebar.php';} ?>
                    </div>
                </div>
            </article>
        </div>

        <div id="followers" class="popup">
            <div class="popup-holder">
                <div class="popup-area">
                    <div action="#" class="reporting-form add no-border new-popup">
                        <h2 class="white radius">Follower</h2>
                        <ul class="list-none popup-list">
                            <?php foreach ($user->is_following as $following) { ?>
                                <li>
                                    <?php if($current_user){ ?>
                                    <a onclick="unfollow('<?= $following->user->id ?>', 'unfollowing_<?= $following->user->id ?>', 'following_<?= $following->user->id ?>')"  <?php if (!checkIsFolloing($following->user->id)) { ?> style="display: none" <?php } ?> id="unfollowing_<?= $following->user->id ?>"  href="#" class="btn">Unfollow <i class="fa fa-times" aria-hidden="true"></i></a>
                                    <a onclick="follow('<?= $following->user->id ?>', 'following_<?= $following->user->id ?>', 'unfollowing_<?= $following->user->id ?>')" <?php if (checkIsFolloing($following->user->id)) { ?> style="display: none" <?php } ?>  id="following_<?= $following->user->id ?>" href="#" class="btn follow-btn">Follow <i class="fa fa-times" aria-hidden="true"></i></a>
                                    <?php } else{ ?>
                                    <a  href="#loginModal" class="btn follow-btn new_popup_opener">Follow <i class="fa fa-times" aria-hidden="true"></i></a>
                                    <?php } ?>
                                    <span><?php echo $following->user->first_name; ?></span>
                                </li>
                            <?php } ?>     
                        </ul>
                        <a href="#" class="btn-close">x</a>
                    </div>
                </div>
            </div>
        </div>

        <div id="followings" class="popup">
            <div class="popup-holder">
                <div class="popup-area">
                    <div action="#" class="reporting-form add no-border new-popup">
                        <h2 class="white radius">Following</h2>
                        <ul class="list-none popup-list">
                            <?php foreach ($user->is_followed as $follower) { ?>
                                <li>
                                    <?php if($current_user){ ?>
                                    <a onclick="unfollow('<?= $follower->getUser->id ?>', 'unfollow_<?= $follower->getUser->id ?>', 'follow_<?= $follower->getUser->id ?>')" <?php if (!checkIsFolloing($follower->getUser->id)) { ?> style="display: none" <?php } ?>id="unfollow_<?= $follower->getUser->id ?>" href="javascript:void(0)" class="btn">Unfollow <i class="fa fa-times" aria-hidden="true"></i></a>
                                    <a onclick="follow('<?= $follower->getUser->id ?>', 'follow_<?= $follower->getUser->id ?>', 'unfollow_<?= $follower->getUser->id ?>')" <?php if (checkIsFolloing($follower->getUser->id)) { ?> style="display: none" <?php } ?>  id="follow_<?= $follower->getUser->id ?>" href="javascript:void(0)" class="btn follow-btn">Follow <i class="fa fa-plus" aria-hidden="true"></i></a>
                                    <?php } else{ ?>
                                    <a  href="#loginModal" class="btn follow-btn new_popup_opener">Follow <i class="fa fa-times" aria-hidden="true"></i></a>
                                    <?php } ?>
                                    <span><?php echo $follower->getUser->first_name; ?></span>
                                </li>
                            <?php } ?> 
                        </ul>
                        <a href="#" class="btn-close">x</a>
                    </div>
                </div>
            </div>
        </div>
        <?php include('includes/footer.php'); ?>
        <?php include('includes/functions.php'); ?>
        <script>

            $('#gal-img').on('change', function () {
                $('#gal-img').attr("src", '');
                imagesPreview(this);
            });


            function imagesPreview(input) {
                if (input.files) {
                    for (var x = 0; x < input.files.length; x++) {
                        var filePath = input.value;
                        var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif|\.svg)$/i;
                        if (!allowedExtensions.exec(filePath)) {

                            $('#showError').html('Please upload file having extensions .jpeg/.jpg/.png/.gif  only.').show().fadeOut(3000);

                            $('#gal-img').val('');
                            return false;
                        } else {
                            $("#upload_image_gallery").submit();
                        }
                    }
                }

            }
        </script> 
    </body>

</html>