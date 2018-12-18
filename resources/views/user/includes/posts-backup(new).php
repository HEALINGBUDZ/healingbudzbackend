<?php
if (count($posts) > 0) {
    if (Auth::user()) {
        $current_user = Auth::user();
        $current_id = $current_user->id;
        $current_photo = getImage($current_user->image_path, $current_user->avatar);
        $current_special_image = $current_user->special_icon;
    } else {
        $current_user = '';
        $current_id = '';
        $current_photo = '';
        $current_special_image = '';
    }
    ?>
    <?php foreach ($posts as $key => $post) { ?>
        <div id="single-post-<?= $post->id; ?>">
            <div class="wall-post-single-head">
                <div class="wall-post-single-in-head">
                    <div class="wall-post-single-in-head-img-area">
                        <div class="wall-post-profile-image pre-main-image">
                            <figure class="pre-main-image" style="background-image: url(<?php echo getImage($post->User->image_path, $post->User->avatar) ?>);">
                                <?php if ($post->User->special_icon) { ?>
                                    <span class="fest-pre-img" style="background-image: url(<?php echo asset('public/images' . $post->User->special_icon) ?>);"></span>
                                <?php } ?>
                            </figure>

                        </div>
                        <div class="wall-post-profile-detail text <?= getRatingClass($post->User->points); ?>">
                            <div class="wall-post-profile-detail-in">
                                <h2>
                                    <a href="<?= asset('user-profile-detail/' . $post->user_id) ?>" class="<?= getRatingClass($post->User->points); ?>"><?= $post->User->first_name; ?></a>
                                    <?php if (isset($post->SharedPost->id)) { ?>
                                        <span>
                                            <img src="<?php echo asset('userassets/images/wall/wall-repost.png') ?>"> Reposted 
                                            <strong><a href='<?= asset('user-profile-detail/' . $post->SharedUser->id) ?>' class="<?= getRatingClass($post->SharedUser->points); ?>"><?= $post->SharedUser->first_name; ?></a></strong>'s 
                                            <a style="color:#c6c4c5" href="<?= asset('get-post/' . $post->SharedPost->id) ?>">post</a> ...
                                        </span>
                                    <?php } ?>
                                    <?php if ($post->SubUser) { ?>
                                        <span class="posted_span">
                                            <em>Posted as: <img src="<?php echo asset('userassets/images/wall/bud_icon.png') ?>" alt="icon"> <a href="<?= asset('get-budz?business_id=' . $post->SubUser->id . '&business_type_id=' . $post->SubUser->business_type_id) ?>"><?= $post->SubUser->title ?></a></em>
                                        </span>
                                    <?php } ?>
                                </h2>
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
                    <div class="wall-post-single-in-head-opt-area">
                        <span class="wall-time" id="post-time-<?= $post->id; ?>"> 
                            <?php if ($post->created_at != $post->updated_at) { ?>
                                <em>
                                    <i class="fa fa-undo" aria-hidden="true"></i>
                                    <span class="tooltipp"> Edited  <span class="tooltiptext"><?= timeago($post->updated_at) ?></span></span>
                                </em>  
                            <?php } ?>
                            <?php
                            $server_date = timeZoneConversion($post->created_at, 'd/m/Y', \Request::ip());
                            $time_zone_date = timeZoneConversion($post->created_at, 'F d \a\t h:i A', \Request::ip());
                            $return_date = checkToday($server_date);
                            if ($return_date) {
                                echo $return_date . timeZoneConversion($post->created_at, 'h:i A', \Request::ip());
                            } else {
                                echo $time_zone_date;
                            }
                            ?>
                        </span> 
                        <span class="wall-opt-dots" onclick="dot_menu(this)">
                            <img src="<?php echo asset('userassets/images/wall/three-dots.png') ?>" alt="Menu Dots">
                        </span>
                        <div class="wall-post-opt-toggle">
                            <input type="text" id="post-url-<?= $post->id; ?>" value="<?php echo asset('/get-post/' . $post->id) ?>" style="display:none">
                            <ul>
                                <li onclick="copyPostLink(<?= $post->id; ?>)"><a href="javascript:void(0)"><i class="fa fa-copy"></i> Copy Link</a></li>

                                <li>
                                    <a href="#share-post<?= $post->id ?>" class="flag-icon btn-popup"><i class="fa fa-share-alt"></i> Share</a>
                                </li>

                                <?php
                                if ($current_user) {
                                    if ($current_id != $post->user_id && (!$post->reported)) {
                                        ?>
                                        <li id="report_post_<?= $post->id ?>">
                                            <a href="#report-post-<?= $post->id ?>" class="flag-icon btn-popup" id="report-post<?php echo $post->id; ?>"  class="flag-icon"><i class="fa fa-flag"></i> Report</a>
                                        </li>
                                    <?php } ?>

                                    <li id="reported_post_<?= $post->id ?>" <?php if (!$post->reported) { ?> style="display: none"<?php } ?>>
                                        <a href="javascript:void(0)>" class="flag-icon soc-act" id="reported-post<?php echo $post->id; ?>"><i class="fa fa-flag"></i> Reported</a>
                                    </li>

                                    <li id="single-post-mute-<?= $post->id; ?>" onclick="mutePost(<?= $post->id; ?>)" <?php if ($post->mute_post_by_user_count) { ?> style="display: none" <?php } ?>><a href="javascript:void(0)"><i class="fa fa-bell-slash"></i> Mute</a></li>
                                    <li id="single-post-unmute-<?= $post->id; ?>" onclick="unmutePost(<?= $post->id; ?>)" <?php if (!$post->mute_post_by_user_count) { ?> style="display: none" <?php } ?>><a href="javascript:void(0)"><i class="fa fa-bell"></i> Unmute</a></li>
                                <?php } if ($current_id == $post->user_id) { ?>
                                    <li><a href="<?= asset('post-edit/' . $post->id); ?>"><i class="fa fa-pencil"></i> Edit</a></li>
                                    <li><a href="#delete_post-<?php echo $post->id; ?>" class="btn-popup"><i class="fa fa-trash"></i> Delete</a></li>
                                <?php } ?>

                            </ul>
                        </div>
                    </div>
                </div>
                <div class="wall-post-single-in-body">
                    <?php if ($post->post_added_comment) { ?>
                        <p class="reading-wall" id="post_reposted_comment_<?= $post->id ?>"><?= $post->post_added_comment; ?></p>
                    <?php } ?>
                    <?php if ($post->shared_id) { ?>
                        <div class="hb_repost_comments">
                            <div class="hb_repost_comments_txt">  
                            <?php } ?>
                            <ul class="list-none post_gallery_thumbs <?php if (count($post->files) > 2) { ?> multiple <?php } ?>" >
                                <?php
                                $count = 1;
                                foreach ($post->files as $fileKey => $file) {
                                    ?>
                                    <li <?= (($count > 3) ? 'style="display:none"' : '') ?>>


                                        <?= ($count < 3) ? '<a href="' . (($file->type == 'video') ? '#video_' . $post->id : asset(image_fix_orientation('public/images' . $file->file)) ) . '" data-fancybox="gallery' . $post->id . '" >' : ''; ?>

                                        <figure  <?php
                                        if ($count == 1) {
                                            if ($file->type == 'image') {
                                                $bg_image = asset(image_fix_orientation('public/images' . $file->file));
                                                $play = '';
                                            } else {
                                                $play = '<a href="javascript:void(0)" class="video_player_btn">Play</a>';
                                                $bg_image = asset('public/images' . $file->poster);
                                            }
                                            ?>
                                                style="background-image:url('<?= $bg_image ?>');"    
                                                <?php
                                            } else {
                                                if ($file->type == 'image') {
                                                    $bg_image = asset(image_fix_orientation('public/images' . $file->file));
                                                    $play = '';
                                                } else {
                                                    $play = '<a href="javascript:void(0)" class="video_player_btn">Play</a>';
                                                    $bg_image = asset('public/images' . $file->poster);
                                                }
                                                ?>
                                                style="background-image:url('<?= $bg_image ?>');"
                                                <?php
                                            }
                                            ?>>

                                            <?php if ($count == 3) { ?>
                                                <div class="fig_overlay">
                                                    <?php if ($file->type == 'video') { ?>
                                                        <a class="poster" href='#video_<?= $post->id ?>'data-fancybox="gallery<?= $post->id ?>">View All</a>
                                                    <?php } else { ?>
                                                        <a class="poster" href="<?php echo asset(image_fix_orientation('public/images' . $file->file)); ?>" data-fancybox="gallery<?= $post->id ?>">View All</a>
                                                    <?php } ?>
                                                </div>
                                            <?php } else if ($count > 3) {
                                                ?>
                                                <div class="fig_overlay">

                                                    <?php if ($file->type == 'video') { ?>
                                                        <a href='#video_<?= $post->id ?>' data-fancybox="gallery<?= $post->id ?>">View All</a>
                                                    <?php } else { ?>
                                                        <a href="<?php echo asset(image_fix_orientation('public/images' . $file->file)); ?>" data-fancybox="gallery<?= $post->id ?>">View All</a>       
                                                    <?php } ?>

                                                </div>
                                            <?php } ?>
                                            <?php if ($file->type == 'video') { ?>
                                                <i class="fa fa-play-circle" aria-hidden="true"></i>
                                            <?php } ?>
                                        </figure>
                                        <?= ($count < 3) ? '</a>' : ''; ?>
                                        <?php if ($file->type == 'video') { ?> 
                                            <video class="video" height="100" width="100" poster="<?php echo asset('public/images' . $file->poster) ?>" id="video_<?= $post->id ?>" controls="" style="display: none;">
                                                <source src="<?php echo asset('public/videos' . $file->file) ?>" type="video/mp4">
                                                Your browser does not support the video tag.
                                            </video>  
                                        <?php } ?>
                                    </li>
                                    <?php
                                    $count++;
                                }
                                ?>
                            </ul>
                            <figcaption>

                                <?php if ($post->scrapedUrl && count($post->files) == 0) { ?>
                                    <div class="scraped-data">
                                        <img src="<?= $post->scrapedUrl->image; ?>" alt="">
                                        <h4><a href="<?= $post->scrapedUrl->extracted_url; ?>" target="_blank"><?= $post->scrapedUrl->title ?></a></h4>
                                        <?php if ($post->scrapedUrl->url != 'www.youtube.com') { ?>
                                            <p><?= $post->scrapedUrl->content ?></p>
                                        <?php } ?>
                                    </div>
                                <?php } ?>
                                <?php $post_discription = revertLinkTag($post->description);
                                ?>


                                <p class="reading-wall" id="post_description_<?= $post->id ?>"><?= showMentionsAndTags($post->description, $post->json_data); ?></p>
                                <?php if ($post->shared_id) { ?>        
                            </div>
                        </div>
                    <?php } ?>     
                    <?php if (count($post->Tagged) > 0) { ?>
                        <div class="with_list_tags">
                            <span>-with</span>
                            <ul class="list-none">
                                <?php foreach ($post->Tagged as $tagged_user) { ?>
                                    <li>
                                        <a href="<?= asset('user-profile-detail/' . $tagged_user->user->id) ?>"><?= $tagged_user->user->first_name ?></a>
                                    </li>
                                    <?php
                                }
                            }
                            ?>
                        </ul>
                        <a href="javascript:void(0);" onclick="read_more(this)" class="wall-read-more" id="post_description_more_<?= $post->id ?>">- Read More</a>
                    </div>
                    </figcaption>

                    <div class="wall-post-single-in-foot">
                        <div class="right_likes">
                            <a href="javascript:void(0)" onclick="openLikes('likes_img_popup_<?= $post->id ?>')"  class="total_likes_btn-<?= $post->id ?>"><span id="likes-count"><?= count($post->Likes); ?></span> Likes</a>
                        </div>
                        <?php if ($current_user) { ?>
                            <div class="left_elm">
                                <div>
                                    <div class="wall-post-single-like" id="wall-post-single-like-<?= $post->id; ?>" onclick="like_post(<?= $post->id; ?>)" <?php if ($post->liked_count) { ?> style="display: none" <?php } ?>>
                                        <span class="wall-post-single-like-span"></span>
                                        <span>Likes</span>
                                    </div>
                                    <div class="wall-post-single-like wall-post-like" id="wall-post-single-dislike-<?= $post->id; ?>" onclick="dislike_post(<?= $post->id; ?>)" <?php if (!$post->liked_count) { ?> style="display: none" <?php } ?>>
                                        <span class="wall-post-single-like-span"></span>
                                        <span>Likes</span>
                                    </div>
                                </div>
                                <div class="wall-post-single-comment" onclick="load_comments(<?= $post->id; ?>)">
                                    <span class="wall-post-single-comment-span"></span>
                                    <span><span id="comments-count-<?= $post->id; ?>"><?= $post->comments_count; ?></span> Comments</span>
                                </div>
                                <?php if ($post->allow_repost == 1) { ?>
                                    <div class="wall-post-single-repost">
                                        <span class="wall-post-single-repost-span"></span>
                                        <span><?= ($post->shared_count); ?>  <a <?php if ($post->allow_repost == 1 && $post->user_id != $current_id) { ?> href="#repost_post_<?= $post->id ?>" class="btn-popup gray_link" <?php } else { ?> onclick="showRepostError()" <?php } ?>class="gray_link">Reposts</a></span>
                                    </div>
                                <?php } ?>
                            </div>
                        <?php } else { ?>
                            <div class="left_elm">
                                <div>
                                    <div class="wall-post-single-like">
                                        <a style="color:#c6c4c5" href="#loginModal" class="new_popup_opener"><span class="wall-post-single-like-span"></span>
                                            <span>Likes</span></A>
                                    </div>
                                </div>
                                <div class="wall-post-single-comment">
                                    <a style="color:#c6c4c5" href="#loginModal" class="new_popup_opener"><span class="wall-post-single-comment-span"></span>
                                        <span><span id="comments-count-<?= $post->id; ?>"><?= $post->comments_count; ?></span> Comments</span></a>
                                </div>
                                <?php if ($post->allow_repost == 1) { ?>
                                    <div class="wall-post-single-repost">
                                        <span class="wall-post-single-repost-span"></span>
                                        <span><?= ($post->shared_count); ?>  <a href="#loginModal" class="new_popup_opener gray_link" class="gray_link">Reposts</a></span>
                                    </div>
                                <?php } ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="wall-post-single-body" id="wall-post-single-body-<?= $post->id; ?>">
                <!-- <div class="wall-post-write-text">
                    <textarea rows="1" placeholder="Start an article..." class="mention" id="description"></textarea>
                </div> -->
                <div class="wall-post-single-body-in">
                    <div class="wall-comments-write">
                        <div class="wall-write-comment">
                            <div class="wall-post-profile-image pre-main-image">
                                <figure style="background-image: url(<?php echo $current_photo ?>);"></figure>
                                <?php if ($current_special_image) { ?>
                                    <span class="fest-pre-img" style="background-image: url(<?php echo asset('public/images' . $current_special_image) ?>);"></span>
                                <?php } ?>
                            </div>
                            <div id="wall-comment-textarea" class="wall-post-write-textarea">
                                <div class="comment_area_holder">
                                    <div class="comment_text_holder">
                                        <div style="width:100%;">
                                            <div class="right_elems">
                                                <div class="wall-post-write-photo" id="wall-post-comment-image-<?= $post->id ?>" onclick="comment_image_attachment(this)">
                                                    <span class="wall-post-write-photo-span"></span>
                                                </div>
                                                <span class="wall-mid-border"></span>
                                                <div class="wall-post-write-video" id="wall-post-comment-video-<?= $post->id ?>" onclick="comment_video_attachment(this)">
                                                    <span class="wall-post-write-video-span"></span>
                                                </div>
                                            </div>
                                            <input id="wall_comment_<?= $post->id ?>" type="text" name="" class="comments-mention show_tag_hash<?= $post->id ?>" onkeyup="postComment(event, this, <?= $post->id; ?>)" placeholder="Write a Comment..." />
                                            <input type="hidden" name="comment_id" class="comment_id" />
                                        </div>
                                    </div>
                                    <span class="wall-post-enter">Press enter to post</span>
                                </div>
                                <ul class="list-none" id="uploaded_images"></ul>
                                <div id="img-previews"></div>
                            </div>
                            <div class="wall-write-comment-photo " id="wall-write-comment-photo-edit<?= $post->id ?>">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-sm-10 offset-sm-1">
                                            <!--<h2 class="page-heading">Upload your Images <span id="image-counter"></span></h2>-->
                                            <form method="post" action="<?php echo asset('/images-save'); ?>" enctype="multipart/form-data" class="dropzone comment_image_dropzone_<?= $post->id; ?>" id="comment-dropzone-image">
                                                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                                <!-- <div class="dz-message-image">
                                                     <div class="col-xs-8">
                                                         <div class="message">
                                                             <p>Drop image file here or Click to Upload</p>
                                                         </div>
                                                     </div>
                                                 </div>-->
                                                <div class="fallback">
                                                    <input type="file" name="file" multiple>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div id="comment-image-preview-<?= $post->id; ?>" style="display: none;">
                                        <div class="dz-preview dz-file-preview ">
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
                            <div class="wall-write-comment-video" id="wall-write-comment-video-edit<?= $post->id ?>">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-sm-10 offset-sm-1">
                                            <!--<h2 class="page-heading">Upload your Video <span id="video-counter"></span></h2>-->
                                            <form method="post" action="<?php echo asset('/video-save'); ?>" enctype="multipart/form-data" class="dropzone comment_video_dropzone_<?= $post->id; ?>" id="comment-dropzone-video">
                                                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                                <div class="dz-message dz-default">
                                                    <span>Drop video file here or Click to Upload</span>
                                                    <!--                                                    <div class="col-xs-8">
                                                                                                            <div class="message">
                                                                                                                <p>Drop video file here or Click to Upload</p>
                                                                                                            </div>
                                                                                                        </div>-->
                                                </div>
                                                <div class="fallback">
                                                    <input type="file" name="file" multiple>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div id="comment-video-preview" style="display: none;">
                                        <div class="dz-preview dz-file-preview delete_preview_<?= $post->id ?>">
                                            <div class="dz-image commet-video-poster"><img data-dz-thumbnail /></div>
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
                        <div class="new_ul_list">
                            <ul class="list-none inner_comments wall-comments-area-<?= $post->id; ?>">
                                <?php $comments = $post->Comments->sortByDesc('created_at')->take(5); ?>
                                <?php include('post_comments.php'); ?>
                            </ul>
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
        </div>

        <div id="share-post<?= $post->id ?>" class="popup">
            <div class="popup-holder">
                <div class="popup-area">
                    <div class="reporting-form">
                        <h2>Select an option</h2>
                        <div class="custom-shares custom_style">
                            <?php
                            echo Share::page(asset('get-post/' . $post->id), $post->description, ['class' => 'posts_class', 'id' => $post->id])
                                    ->facebook($post->description)
                                    ->twitter($post->description)
                                    ->googlePlus($post->description);
                            ?>
                        </div>
                        <a href="javascript:void(0)" class="btn-close"><i class="fa fa-times-circle-o" aria-hidden="true"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <?php if ($current_user) { ?>
            <div id="repost_post_<?= $post->id ?>" class="popup sharing_popup">
                <div class="popup-holder">
                    <div class="popup-area">
                        <div class="reporting-form">
                            <h3>Share post</h3>
                            <div class="share_popup_text">
                                <div class="hb_repost_comments">
                                    <input maxlength="150" id="post_added_comment<?= $post->id ?>" type="text" name="comment" placeholder="Write Somethings...">
                                    <div class="hb_repost_comments_txt">
                                        <div class="share_img_holder">
                                            <?php
                                            if (count($post->files) > 0) {
                                                foreach ($post->files->take(1) as $file) {
                                                    ?>
                                                    <?php if ($file->type == 'image') { ?>
                                                                                                                                                                    <!--<img src="<?php // echo asset('public/images' . $file->file)          ?>" alt="Image" class="img-responsive">-->
                                                        <figure class="wall-repost-pop-img" style="background-image: url(<?php echo asset('public/images' . $file->file) ?>);"></figure>

                                                    <?php } else { ?>
                                                                                                                                                                                                                                                        <!--<img src="<?php // echo asset('public/images' . $file->poster)        ?>" alt="Image" class="img-responsive">-->
                                                        <figure class="wall-repost-pop-img" style="background-image: url(<?php echo asset('public/images' . $file->poster) ?>);"></figure>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            <?php } ?>
                                            <?php if ($post->scrapedUrl && count($post->files) == 0) { ?>
                                                <div class="scraped-data">
                                                    <h4><?= $post->scrapedUrl->title ?></h4>
                                                    <?php if ($post->scrapedUrl->url != 'www.youtube.com') { ?>
                                                        <p><?= $post->scrapedUrl->content ?></p>
                                                    <?php } ?>
                                                    <?php /* <img src="<?= $post->scrapedUrl->image; ?>" alt=""> */ ?>
                                                    <figure class="wall-repost-pop-img" style="background-image: url(<?= $post->scrapedUrl->image; ?>);"></figure>
                                                </div>
                                            <?php } ?>
                                        </div>


                                        <p><?= showMentionsAndTags($post->description, $post->json_data); ?></p>
                                    </div>
                                </div>  </div>
                            <div class="to_whom">
                                <div class="wall-post-write-tag-view">
                                    <span class="wall-with-span">with</span>
                                    <?php $all_users = json_decode($followers); ?>
                                    <select class="js-example-basic-multiple tagged-budz" name="users[]" multiple="multiple" id="tagged_users_<?= $post->id ?>">
                                        <?php foreach ($all_users as $user) { ?>
                                            <option value="<?= $user->id ?>"><?= $user->first_name ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="sharing_footer">
                                <a href="#" class="hb_tag_btn"><i class="hb_icon_tag"></i> Tag Peoples</a>
                                <div class="post_as">
                                    <!--<span>Post as</span>-->
                                    <select class="wall-post-profile-btn" id="posting_user_<?= $post->id ?>">
                                        <option value="u_<?= $current_user->id ?>"><?= $current_user->first_name ?></option>
                                        <?php foreach ($subusers as $subuser) { ?>
                                            <option value="s_<?= $subuser->id ?>"><?= $subuser->title ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <a href="javascript:void(0)" class="submit_btn" onclick="sharePost('<?= $post->id ?>')">Share Post</a>
                            </div>
                            <a href="javascript:void(0)" class="btn-close"><i class="fa fa-times-circle-o" aria-hidden="true"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
        <div id="report-post-<?= $post->id ?>" class="popup">
            <div class="popup-holder">
                <div class="popup-area">
                    <form action="<?php echo asset('report-single-post'); ?>" class="reporting-form" method="post" >
                        <input type="hidden" value="<?php echo $post->id; ?>" name="post_id">
                        <input type="hidden" value="<?php echo csrf_token(); ?>" name="_token">
                        <fieldset>
                            <h2>Reason For Reporting</h2>
                            
                             <input type="radio" name="reason" id="sexual<?= $post->id ?>"  value="Nudity or sexual content">
                            <label for="sexual<?= $post->id ?>">Nudity or sexual content</label>

                            <input type="radio" name="reason" id="harasssment<?= $post->id ?>"  value="Harassment or hate speech">
                            <label for="harasssment<?= $post->id ?>">Harassment or hate speech</label>

                            <input type="radio" name="reason" id="threatening<?= $post->id ?>"  value="Threatening, violent, or concerning">
                            <label for="threatening<?= $post->id ?>">Threatening, violent, or concerning</label>
                            
                            <input class="<?= 'reason_' . $post->id ?>" type="radio" name="reason" id="abused<?= $post->id ?>"  value="offensive">
                            <label for="abused<?= $post->id ?>">Post is offensive</label>
                            <input class="<?= 'reason_' . $post->id ?>" type="radio" name="reason" id="spam<?= $post->id ?>" value="Spam">
                            <label for="spam<?= $post->id ?>">Spam</label>
                            <input class=" <?= 'reason_' . $post->id ?>" type="radio" name="reason" id="unrelated<?= $post->id ?>" value="Unrelated">
                            <label for="unrelated<?= $post->id ?>">Unrelated</label>
                            <input onclick="report_post('<?= $post->id ?>')" type="button" value="Report Post" onclick="report_post(this)">

                            <a href="javascript:void(0)" class="btn-close">x</a>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
        <?php /*    <div id="gallery_images_<?= $post->id ?>" class="popup strain-gallery-images" >
          <div class="popup-holder">
          <div class="popup-area">
          <div class="text">
          <div class="gallery">
          <div class="mask">
          <div class="slideset">
          <?php foreach ($post->files as $file) { ?>
          <div class="slide">
          <?php if ($file->type == 'image') { ?>
          <img src="<?php echo asset('public/images' . $file->file) ?>" alt="Image" class="img-responsive">
          <?php } else { ?>
          <video controls poster="<?php echo asset('public/images' . $file->poster) ?>">
          <source src="<?php echo asset('public/videos' . $file->file) ?>" type="video/mp4">
          Your browser does not support the video tag.
          </video>
          <?php } ?>
          </div>
          <?php } ?>
          </div>
          <?php if (count($post->files) > 1) { ?>
          <a href="javascript:void(0)" class="btn-prev"><i class="fa fa-angle-left" aria-hidden="true"></i></a>
          <a href="javascript:void(0)" class="btn-next"><i class="fa fa-angle-right" aria-hidden="true"></i></a>
          <?php } ?>
          <a href="javascript:void(0)" class="btn-close yellow"></a>
          <!-- <div class="pagination"></div> -->
          </div>
          </div>
          </div>
          </div>
          </div>
          </div>
         */ ?>
        <div id="likes_img_popup_<?= $post->id ?>" class="likes_img_popup wall-spc-img-adj">
            <div class="d-table">
                <div class="d-inline">
                    <div class="comment_img_holder">
                        <h2>Likes by</h2>
                        <ul class="list-none" id="likes_liksiting_<?= $post->id ?>">
                            <?php
                            if ($post->likes->count() > 0) {
                                foreach ($post->likes as $likes) {
                                    ?>
                                    <li id="hide_likes_liksiting_<?= $post->id . $likes->User->id ?>">
                                        <div class="img-holder pre-main-image">
                                            <?php
                                            $s_user_icon = '';
                                            if ($likes->user->special_icon) {
                                                $s_user_icon = getSpecialIcon($likes->user->special_icon);
                                            }
                                            ?>
                                            <span class="hb_round_img hb_bg_img" style="width:35px; height: 35px; display: block; background-image: url(<?php echo getImage($likes->User->image_path, $likes->User->avatar); ?>)"></span>
                                            <span class="fest-pre-img" style="background-image: url(<?php echo $s_user_icon ?>);"></span>
                                        </div>
                                        <div class="txt <?= getRatingClass($likes->User->points); ?>">
                                            <i class="fa fa-thumbs-up" aria-hidden="true"></i>
                                            <span><a class="<?= getRatingClass($likes->User->points); ?>" href="<?= asset('user-profile-detail/' . $likes->user->id) ?>"><?= $likes->user->first_name ?></a> liked this post</span>
                                        </div>
                                    </li>
                                    <?php
                                }
                            } else {
                                ?>
                                <li id="removed_likes_liksiting_<?= $post->id ?>">Be the first one to like</li>
                            <?php } ?>
                        </ul>
                        <a onclick="closeLikes('likes_img_popup_<?= $post->id ?>')" href="javascript:void(0)" class="comment_popup_closer"><i class="fa fa-times-circle" aria-hidden="true"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <!--Delete Post Popup -->
        <div id="delete_post-<?php echo $post->id; ?>" class="popup">
            <div class="popup-holder">
                <div class="popup-area">
                    <div class="text">
                        <div class="edit-holder">
                            <div class="step">
                                <div class="step-header">
                                    <h4>Delete Post</h4>
                                    <p class="yellow no-margin">Are you sure to delete this post.</p>
                                </div>
                                <a href="javascript:void(0)" onclick="deletePost(<?= $post->id; ?>)" class="btn-heal">yes</a>
                                <a href="#" class="btn-close">No</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal End-->

        <script>
            $("[data-fancybox='gallery<?= $post->id ?>']").fancybox({
                share: {
                    tpl:
                            '<div class="fancybox-share">' +
                            "<h1>SELECT AN OPTION</h1>" +
                            "<div id='social-links'><ul>" +
                            '<li><a class="social-button social-facebook posts_class" href="https://www.facebook.com/sharer/sharer.php?u=' + window.location + '">' +
                            '<span class="fa fa-facebook"></span></a></li>' +
                            '<li><a class="social-button social-twitter posts_class" href="https://twitter.com/intent/tweet?url=' + window.location + '">' +
                            '<span class="fa fa-twitter"></span></a></li>' +
                            '<li><a class="social-button social-gplus posts_class" href="https://plus.google.com/share?url=' + window.location + '">' +
                            '<span class="fa fa-google-plus"></span></a></li>' +
                            "<ul></div>" +
                            "</div>"
                },
                afterShow: function () {
                    if ($(this)[0].type != "image") {
                        var vid = document.getElementById("video_" + <?= $post->id ?>);
                        vid.play();
                        this.content.find("video_" + <?= $post->id ?>).on('ended', function () {
                            $.fancybox.next();
                        });
                    }
                }
            });
            $(document).ready(function () {
                var height = $('#post_description_<?= $post->id ?>').height();

                if (height < 65) {
                    $('#post_description_more_<?= $post->id ?>').hide();
                }
            });

            function openLikes(id) {
                $('#' + id).show();
            }
            function closeLikes(id) {
                $('#' + id).hide();
            }

            function read_more(obj) {
                // alert($(obj).html())
                //                if ($(obj).html() == '- Read Text') {
                if ($(obj).html() == '- Read More') {
                    $(obj).html('- Read Less');
                } else {
                    //                    $(obj).html('- Read Text');
                    $(obj).html('- Read More');
                }
                $(obj).toggleClass('read_less');
                //                $(obj).closest('figcaption').find('p').slideToggle();
                $(obj).closest('.wall-post-single-in-body').find('.reading-wall').toggleClass('read-wall');
            }
            $('figcaption').find('.read_less').text("- Read Less");

            $('.wall-post-opt-toggle').find('li').click(function () {
                $('.wall-post-opt-toggle').hide();
            });
        </script>
        <script>
            var comment_image_attachments = [];

            $('.comment_image_dropzone_' +<?= $post->id; ?>).dropzone({
                uploadMultiple: false,
                parallelUploads: 1,
                maxFilesize: 12,
                addRemoveLinks: true,
                dictRemoveFile: 'x',
                dictFileTooBig: 'Image is larger than 4MB',
                timeout: 10000000,
                acceptedFiles: 'image/jpg,image/png,image/gif,image/jpeg,image/bmp',
                maxFiles: 1,
                renameFile: function (file) {
                    name = new Date().getTime() + Math.floor((Math.random() * 100) + 1) + '_' + file.name;
                    return name;
                },

                init: function () {
                    this.on("error", function (file, response) {
                        var errMsg = response;
                        if (response.message)
                            errMsg = response.message;
                        if (response.file)
                            errMsg = response.file[0];

                        $('#showError').html('<i class="fa fa-exclamation-triangle" aria-hidden="true"></i>' + errMsg).show().fadeOut(5000);
                        $('#post_loader').hide();
                        $("#submit_post").css('pointer-events', 'auto');
                        //            if(errMsg != 'You can not upload any more files.'){
                        this.removeFile(file);
                    });
                    this.on("removedfile", function (file) {

                        $.post({
                            url: '/healingbudz/images-delete',
                            data: {file_name: file.saved_file_name, file_type: file.saved_file_type, _token: $('[name="_token"]').val()},
                            dataType: 'json',
                            success: function (data) {
                                //                    total_photos_counter--;
                                //                    $("#image-counter").text("# " + total_photos_counter);
                                $.each(comment_image_attachments, function (i) {
                                    if (comment_image_attachments[i].file_name === file.saved_file_name) {
                                        comment_image_attachments.splice(i, 1);
                                        return false;
                                    }
                                });
                                //Show video upload
                                $('#wall-post-comment-video-' +<?= $post->id ?>).css('cssText', 'display: inline-block !important');

                              }
                        });
                    });
                    this.on('resetFiles', function () {
                        if (this.files.length != 0) {
                            for (i = 0; i < this.files.length; i++) {
                                this.files[i].previewElement.remove();
                            }
                            this.files.length = 0;
                        }
                    });

                },

                success: function (file, done) {
                    file["customName"] = name;
                    file["saved_file_name"] = done.file_name;
                    file["saved_resize_name"] = done.resize_name;
                    file["saved_file_type"] = done.type;
                    comment_image_attachments.push({"file_name": done.file_name, "poster": '', "resize_name": done.resize_name, "type": done.type});
                    
                    this.emit("thumbnail", file, done.thumnail_path);
                    //hide video upload
                    $('#wall-post-comment-video-' +<?= $post->id ?>).css('cssText', 'display: none !important');
                    //Focus on input field
                    $(".comments-mention").focus();
                 
                },

                accept: function (file, done) {
                    
                    done();
                },
            });


            //comment video upload
            var comment_video_attachments = [];
            $('.comment_video_dropzone_' +<?= $post->id; ?>).dropzone({
                uploadMultiple: false,
                parallelUploads: 1,
                maxFilesize: 20,
                previewTemplate: document.querySelector('#comment-video-preview').innerHTML,
                addRemoveLinks: true,
                dictRemoveFile: 'x',
                dictFileTooBig: 'Video is larger than 20MB',
                timeout: 10000000,
                acceptedFiles: 'video/*',
                maxFiles: 1,
                renameFile: function (file) {
                    name = new Date().getTime() + Math.floor((Math.random() * 100) + 1) + '_' + file.name;
                    return name;
                },

                init: function () {
                    this.on("error", function (file, response) {
                        var errMsg = response;
                        if (response.message)
                            errMsg = response.message;
                        if (response.file)
                            errMsg = response.file[0];

                        $('#showError').html('<i class="fa fa-exclamation-triangle" aria-hidden="true"></i>' + errMsg).show().fadeOut(5000);
                        $('#post_loader').hide();
                        $("#submit_post").css('pointer-events', 'auto');
                        this.removeFile(file);
                    });


                    this.on("removedfile", function (file) {
                        $.post({
                            url: '/healingbudz/video-delete',
                            data: {file_name: file.saved_file_name, poster_name: file.saved_file_poster, file_type: file.saved_file_type, _token: $('[name="_token"]').val()},
                            dataType: 'json',
                            success: function (data) {
                                //                    total_videos_counter--;
                                //                    $("#video-counter").text("# " + total_videos_counter);
                                $.each(comment_video_attachments, function (i) {
                                    if (comment_video_attachments[i].file_name === file.saved_file_name) {
                                        comment_video_attachments.splice(i, 1);
                                        return false;
                                    }
                                });
                                //Show image upload
                                $('#wall-post-comment-image-' +<?= $post->id; ?>).css('cssText', 'display: inline-block !important');
                          
                            }
                        });
                    });

                    this.on('resetFiles', function () {
                        if (this.files.length != 0) {
                            for (i = 0; i < this.files.length; i++) {
                                this.files[i].previewElement.remove();
                            }
                            this.files.length = 0;
                        }
                    });
                },
                success: function (file, done) {

                    if (Date.parse('01/01/2011 ' + done.duration) > Date.parse('01/01/2011 00:00:20')) {
                        alert('Maximum of 20 sec video is allowded');
                        file["saved_file_name"] = done.file_name;
                        file["saved_file_poster"] = done.poster_name;
                        file["saved_file_type"] = done.type;
                        file["poster_path"] = done.poster_path;
                        file["resize_poster"] = done.resize_poster;
                        file["resize_poster_path"] = done.resize_poster_path;
                        this.removeFile(file);
                        return;
                    }

                    file["customName"] = name;
                    file["saved_file_name"] = done.file_name;
                    file["saved_file_poster"] = done.poster_name;
                    file["saved_file_type"] = done.type;
                    file["poster_path"] = done.poster_path;
                    file["resize_poster"] = done.resize_poster;
                    file["resize_poster_path"] = done.resize_poster_path;
                    comment_video_attachments.push({"file_name": done.file_name, "poster": done.poster_name, "resize_poster": done.resize_poster, "type": done.type});

                    $(".commet-video-poster img").attr("src", done.resize_poster_path);

                    //hide image upload
                    $('#wall-post-comment-image-' +<?= $post->id; ?>).css('cssText', 'display: none !important');
                    //Focus on input field
                    $(".comments-mention").focus();
                },

                accept: function (file, done) {
                    done();
                },
            });
            addTags();
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
            function addTags() {
                var post_id = '<?= $post->id ?>';
                $('input.show_tag_hash' + post_id).mentionsInput({
                    onDataRequest: function (mode, query, triggerChar, callback) {
                        if (triggerChar == "@") {
                            var data = mention_users;
                        } else {
                            var data = mention_tags;
                        }
                        data = _.filter(data, function (item) {
                            if (item.name) {
                                return item.name.toLowerCase().indexOf(query.toLowerCase()) > -1
                            }
                        });
                        callback.call(this, data);
                    }
                });
            }
        </script>
    <?php } ?>

    <script>
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
        //            $('.post_gallery_thumbs img').click(function(){
        //                $('#strain-gallery').fadeIn(300);
        //                setTimeout(function() { initCycleCarousel(); }, 1000);
        //            });
        function showpopup(id) {

            $('#gallery_images_' + id).fadeIn(300);
            setTimeout(function () {
                initCycleCarousel();
            }, 1000);
        }


        function sharePost(post_id) {
            var tagged_users = $('#tagged_users_' + post_id).val();
            var posting_user = $('#posting_user_' + post_id).val();
            var post_added_comment = $('#post_added_comment' + post_id).val();

           
            $.ajax({
                type: "POST",
                url: "<?php echo asset('repost'); ?>",
                data: {
                    tagged_users: tagged_users,
                    posting_user: posting_user,
                    post_id: post_id,
                    post_added_comment: post_added_comment,
                    _token: '<?= csrf_token() ?>'
                },
                success: function (response) {
                    $('#repost_post_' + post_id).fadeOut();
                    $('#sharedThanks').fadeIn().fadeOut(5000);
                }
            });

        }

        function comment_image_attachment(param) {
            $(param).parents('.wall-write-comment').find('.wall-write-comment-photo').toggle();
            $(param).parents('.wall-write-comment').find('.wall-write-comment-video').css('display', 'none');
        }
        function comment_video_attachment(param) {
            $(param).parents('.wall-write-comment').find('.wall-write-comment-video').toggle();
            $(param).parents('.wall-write-comment').find('.wall-write-comment-photo').css('display', 'none');
        }
        $('.posts_class').unbind().click(function () {
            count = 0;

            if (count === 0) {
                count = 1;
                id = this.id;
                $('#share-post' + id).fadeOut();
                $.ajax({
                    url: "<?php echo asset('add_question_share_points') ?>",
                    type: "GET",
                    data: {
                        "id": id, "type": "Post"
                    },
                    success: function (data) {
                        count = 0;
                    }
                });
            }
        });
        function showRepostError() {
            $('#showError').html('<i class="fa fa-exclamation-triangle" aria-hidden="true"></i>You can not repost you own post').show().fadeOut(5000);
        }

    </script>
<?php } ?>