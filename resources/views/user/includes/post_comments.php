<?php
if (Auth::user()) {
    $current_user = Auth::user();
    $current_session = getLoginUser();
//dd($current_user);
    $current_id = $current_user->id;
    $current_photo = getImage($current_user->image_path, $current_user->avatar);
    $current_special_image = $current_user->special_icon;
    $group_user_photo = getGroupUserImage($current_user->image_path, $current_user->avatar);
    $current_special_icon_user = '';
    if ($current_special_image) {
        $current_special_icon_user = getSpecialIcon($current_special_image);
    }
} else {
    $current_user = '';
    $current_session = '';
//dd($current_user);
    $current_id = '';
    $current_photo = '';
    $current_special_image = '';
    $group_user_photo = '';
    $current_special_icon_user = '';
}
$segment = Request::segment(1);
?>
<?php foreach ($comments as $comment) { ?>
    <input type="hidden" value='<?= $comment->json_data ?>' id="commet_json_data_<?= $comment->id ?>">
    <input type="hidden" value='<?= json_encode($comment->attachment) ?>' id="comment_attachmnets_<?= $comment->id ?>">
    <li id="post-single-comment-<?= $comment->id; ?>" class="post-single-comment">
        <div class="time_ago">
            <?php if ($comment->created_at != $comment->updated_at) { ?>
                <em>
                    <i class="fa fa-undo" aria-hidden="true"></i>
                    <span class="tooltipp"> Edited  <span class="tooltiptext"><?= timeago($comment->updated_at) ?></span></span>
                </em>  
            <?php } else { ?>
                <span><?= timeago($comment->created_at); ?></span>
            <?php } ?>
            <?php if ($comment->user_id == $current_id) { ?>
                <div class="add-com-toggle">
                    <span class="wall-opt-dots" onclick="com_dot_menu(this)">
                        <img src="<?php echo asset('userassets/images/wall/three-dots.png') ?>" alt="Menu Dots">
                    </span>
                    <div class="wall-post-opt-toggle">
                        <ul>

                        <!--<li><a href="#edit_post_comment-<?php echo $comment->id; ?>" class="btn-popup"><i class="fa fa-pencil"></i> Edit</a></li>-->
                            <li onclick="editComment(this, <?php echo $comment->id; ?>, <?= $post->id; ?>)" class="edit-comment"><a href="javascript:void(0)"><i class="fa fa-pencil"></i> Edit</a></li>
                            <li href="#delete_post_comment-<?php echo $comment->id; ?>" class="btn-popup"><a href="javascript:void(0)"><i class="fa fa-trash"></i> Delete</a></li>
                        </ul>
                    </div>
                </div>
            <?php } ?>
        </div>
        <div class="comments_txt_area">
            <div class="img_holder hb_round_img hb_bg_img" style="background-image: url(<?php echo getImage($comment->User->image_path, $comment->User->avatar) ?>)">
                <?php if ($comment->User->special_icon) { ?>
                    <span class="fest-pre-img" style="background-image: url(<?php echo asset('public/images' . $comment->User->special_icon) ?>);"></span>
                <?php } ?>
            </div>
            <div class="txt">
                <strong class="title"><a href="<?= asset('user-profile-detail/' . $comment->User->id) ?>" class="<?= getRatingClass($comment->User->points); ?>"><?= $comment->User->first_name; ?></a></strong>
                <p><?= showMentionsAndTags($comment->comment, $comment->json_data); ?></p>
                <?php if ($comment->attachment) { ?>
                    <div style="text-align: center;">
                        <?php
                                
                                if ($comment->attachment->type == 'image') {
                                $server_path = explode('/', $comment->attachment->file);
                               $image_path='';
                               if(isset($server_path[2])){
                                $image_path = $server_path[2];
                               }
                                $full_thumb = explode('/', $comment->attachment->thumnail);
                                $full_path = asset('public/images' . $comment->attachment->file);
                                $size = \Illuminate\Support\Facades\File::size('public/images' . $comment->attachment->file);
                               $thumb='';if(isset($full_thumb[3])){
                                $thumb = $full_thumb[3];
                               }
                                $full_thumb_path = asset('public/images' . $comment->attachment->thumnail);
                                
                                ?>
                        <input type="hidden" id="image_path<?= $comment->id ?>" value="<?= $image_path; ?>">
                                <input type="hidden" id="server_path<?= $comment->id ?>" value="<?= $full_path; ?>">
                                <input type="hidden" id="image_size<?= $comment->id ?>" value="<?= $size; ?>">
                                <input type="hidden" id="full_thumb<?= $comment->id ?>" value="<?= $full_thumb_path; ?>">
                                <input type="hidden" id="thumb<?= $comment->id ?>" value="<?= $thumb; ?>">
                                <?php } else{
                                $server_path = explode('/', $comment->attachment->file);
                                $image_path='';if(isset($server_path[2])){
                                $image_path = $server_path[2];
                                }
                                $poster_thumnail = explode('/', $comment->attachment->poster);
                                $poster_show='';
                                if(isset($poster_thumnail[3])){
                                    $poster_show=$poster_thumnail[3];
                                }
                                $full_path = asset('public/images' . $comment->attachment->file);
                                $thumb_path= explode('/',$comment->attachment->thumnail);
                                $thumb_path_show='';
                                if(isset($thumb_path[4])){
                                    $thumb_path_show=$thumb_path[4];
                                }
                                $full_thumb_path = asset('public/images' . $comment->attachment->thumnail);
                                $size = \Illuminate\Support\Facades\File::size('public/videos' . $comment->attachment->file);  
                                ?>
                                <input type="hidden" id="image_path<?= $comment->id ?>" value="<?= $image_path; ?>">
                                <input type="hidden" id="server_path<?= $comment->id ?>" value="<?= $full_path; ?>">
                                <input type="hidden" id="image_size<?= $comment->id ?>" value="<?= $size; ?>">
                                <input type="hidden" id="full_thumb<?= $comment->id ?>" value="<?= $full_thumb_path; ?>">
                                <input type="hidden" id="half_thumb<?= $comment->id ?>" value="<?= $thumb_path_show; ?>">
                                <input type="hidden" id="thumb<?= $comment->id ?>" value="<?= $poster_show; ?>">
                                <?php } 
                                ?>
                                
                        <?php if ($comment->attachment->type == 'image') { ?>
                            <div class="wall_com_imgs_main commet_image<?= $comment->id ?>">
                                <?php $wall_com_imgs = image_fix_orientation('public/images' . $comment->attachment->file); ?>
                                
                                <!--<a href="<?php // echo asset($wall_com_imgs)      ?>" class="" data-fancybox="gallery" >-->
                                <div class="wall_com_imgs" style="background-image: url(<?php echo asset($wall_com_imgs) ?>)">
                                    <div class="fig_overlay">
                                        <a href="<?php echo asset($wall_com_imgs) ?>" data-fancybox="gallery">Open Image</a>                                            
                                    </div>
                                </div>
                                <!--</a>-->
                            </div>
                                <!--<img src="<?php // echo asset('public/images'.$comment->attachment->file)     ?>">-->
                        <?php } ?>
                        <?php if ($comment->attachment->type == 'video') { ?>
                            <video class="wall_com_videos<?= $comment->id ?>" width="400" controls poster="<?php echo asset('public/images' . $comment->attachment->poster) ?>">
                                <source src="<?php echo asset('public/videos' . $comment->attachment->file) ?>" type="video/mp4">
                            </video>
                        <?php } ?>    
                    </div>
                <?php } ?>
                
                <!-- Likes Working -->
                
                <div class="wall-like-inside-com">
                    <div class="wall-dis-like-inside-com">
                        <figure id="wall-post-single-comment-like-<?= $comment->id; ?>" onclick="likeComment('<?= $comment->id; ?>')" <?php if ($comment->liked) { ?> style="display: none" <?php } ?> >
                            <span class="wall-like-inside-com-img"></span>
                            <span>Likes</span>
                        </figure>
                        <figure id="wall-post-single-comment-dislike-<?= $comment->id; ?>" onclick="dislikeComment('<?= $comment->id; ?>')" <?php if (!$comment->liked) { ?> style="display: none" <?php } ?> class="wall-like-com-act">
                            <span class="wall-like-inside-com-img"></span>
                            <span>Likes</span>
                        </figure>
                    </div>
                    <div class="wall-like-inside-com-count">
                        <a href="javascript:void(0)" onclick="openLikes('likes_comments_popup_<?= $comment->id ?>')"  class="total_likes_btn-comment<?= $comment->id ?>"><span id="likes-count-<?= $comment->id?>">(<?= count($comment->likes); ?>)</span></a>
                    </div>
                </div>
                
                <div id="likes_comments_popup_<?= $comment->id ?>" class="likes_img_popup wall-spc-img-adj">
            <div class="d-table">
                <div class="d-inline">
                    <div class="comment_img_holder">
                        <h2>Liked by</h2>
                        <ul class="list-none" id="likes_liksiting_commets<?= $comment->id ?>">
                            <?php
                            if ($comment->likes->count() > 0) {
                                foreach ($comment->likes as $comments_likes) {
                                    ?>
                                    <li id="hide_likes_liksiting_comment<?= $comment->id . $comments_likes->user->id ?>">
                                        <div class="img-holder pre-main-image">
                                            <?php
                                            $s_user_icon = '';
                                            if ($comments_likes->user->special_icon) {
                                                $s_user_icon = getSpecialIcon($comments_likes->user->special_icon);
                                            }
                                            ?>
                                            <span class="hb_round_img hb_bg_img" style="width:35px; height: 35px; display: block; background-image: url(<?php echo getImage($comments_likes->user->image_path, $comments_likes->user->avatar); ?>)"></span>
                                            <span class="fest-pre-img" style="background-image: url(<?php echo $s_user_icon ?>);"></span>
                                        </div>
                                        <div class="txt <?= getRatingClass($comments_likes->user->points); ?>">
                                            <i class="fa fa-thumbs-up" aria-hidden="true"></i>
                                            <span><a class="<?= getRatingClass($comments_likes->User->points); ?>" href="<?= asset('user-profile-detail/' . $comments_likes->user->id) ?>"><?= $comments_likes->user->first_name ?></a> liked this comment</span>
                                        </div>
                                    </li>
                                    <?php
                                }
                            } else {
                                ?>
                                <li id="removed_likes_liksiting_comment<?= $comment->id ?>">Be the first one to like</li>
                            <?php } ?>
                        </ul>
                        <a onclick="closeLikes('likes_comments_popup_<?= $comment->id ?>')" href="javascript:void(0)" class="comment_popup_closer"><i class="fa fa-times-circle" aria-hidden="true"></i></a>
                    </div>
                </div>
            </div>
        </div>
                <!--Like Working Finish-->
                
            </div>
        </div>
    </li>
    <!--Delete Post Comment Popup -->
    <div id="delete_post_comment-<?php echo $comment->id; ?>" class="popup">
        <div class="popup-holder">
            <div class="popup-area">
                <div class="text">
                    <div class="edit-holder">
                        <div class="step">
                            <div class="step-header">
                                <h4>Delete COmment</h4>
                                <p class="yellow no-margin">Are you sure to delete this comment.</p>
                            </div>
                            <a href="javascript:void(0)" onclick="deletePostComment(<?= $comment->id; ?>, <?= $post->id; ?>)" class="btn-heal">yes</a>
                            <a href="#" class="btn-heal btn-close">No</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal End-->
    <script>

        function editComment(obj, comment_id, post_id, attachments) {
            
            var json_data_single_comment = $('#commet_json_data_' + comment_id).val();
            $('#wall_comment_' + post_id).focus();
            json_data = JSON.parse(json_data_single_comment);
            var comment_attachmnets = $('#comment_attachmnets_' + comment_id).val();
            attachment = JSON.parse(comment_attachmnets);
            $.each(json_data, function (key, obj) {
                if (obj.type == 'user') {
                    image = getImage(obj.image_path, obj.avatar);
                    mentionsCollection.push({
                        id: obj.id,
                        type: "user",
                        name: obj.first_name,
                        avatar: image,
                        trigger: "@",
                        value: obj.value
                    });
                }
                if (obj.type == 'budz') {
                    image = getBudzImage(obj.logo);
                    mentionsCollection.push({
                        id: obj.id,
                        type: "budz",
                        name: obj.title,
                        avatar: image,
                        trigger: "@",
                        value: obj.value
                    });
                }
                if (obj.type == 'tag') {
                    image = getImage(obj.image_path, obj.avatar);
                    mentionsCollection.push({
                        id: obj.id,
                        type: "tag",
                        name: obj.title,
                        avatar: '<?= asset('userassets/images/ic_hashtag.png') ?>',
                        trigger: "#",
                        value: obj.value
                    });
                }
            });
    //            var check_class_image=$('#post-single-comment-'+comment_id).hasClass('wall_com_imgs_main');
    //            var check_class_video=$('#post-single-comment-'+comment_id).hasClass('wall_com_videos');
    //            alert(check_class_image);
            if ($(".commet_image" + comment_id)[0]) {
                if (attachment) {
                    if (attachment.type == 'image') {
                        $('#wall-write-comment-photo-edit' + post_id).show();
                        var image_path = $('#image_path' + comment_id).val();
                        var server_path = $('#server_path' + comment_id).val();
                        var image_size = $('#image_size' + comment_id).val();
                        var full_thumb = $('#full_thumb' + comment_id).val();
                        var thumb = $('#thumb' + comment_id).val();
                        var myDropzone = new Dropzone('.comment_image_dropzone_' + post_id);
                        var file = {saved_file_name: image_path, name: image_path, saved_resize_name: thumb, size: image_size};

                        myDropzone.options.addedfile.call(myDropzone, file);
                        myDropzone.options.thumbnail.call(myDropzone, file, full_thumb);
                        myDropzone.files.push(file);
                        myDropzone.emit("complete", file);
                        comment_image_attachments=[];

                        comment_image_attachments.push({
                            "file_name": image_path,
                            "resize_name": thumb,
    //                    "original_name": value.original ,
                            "poster": '',
                            "type": 'image'
                        });
                    }
                }
            }
            if ($(".wall_com_videos" + comment_id)[0]) {
                if (attachment) {
                    if (attachment.type == 'video') {
            $('#wall-write-comment-video-edit' + post_id).show();
             var image_path = $('#image_path'+comment_id).val();
             var server_path = $('#server_path'+comment_id).val();
             var image_size = $('#image_size'+comment_id).val();
             var full_thumb = $('#full_thumb'+comment_id).val();
             var thumb = $('#thumb'+comment_id).val();
              var half_thumb=$('#half_thumb' + comment_id).val();
             var myVideoDropzone = Dropzone.forElement(".comment_video_dropzone_" + post_id);
              myVideoDropzone.emit("resetFiles");
             
              var file = {saved_file_name: image_path, name: image_path, size: image_size};
                myVideoDropzone.options.addedfile.call(myVideoDropzone, file);
                myVideoDropzone.options.thumbnail.call(myVideoDropzone, file, full_thumb);
                myVideoDropzone.emit("complete", file);
                comment_video_attachments=[];
                comment_video_attachments.push({
                    "file_name": image_path,
//                    "original_name": value.original, 

                    "poster": thumb, 
                    "resize_poster": half_thumb ,
                    "type": 'video' });
                
                    }
                }
            }
            var comment_text = $(obj).closest('.time_ago').next('.comments_txt_area').find('.txt').find('p').text();
//            $('.comments-mention').val(comment_text);
            $('#wall_comment_'+post_id).val(comment_text);
            $('.comment_id').val(comment_id);
            $('#post-single-comment-' + comment_id).hide(200);
            $('.add-com-toggle').hide(200);
            //            $('.wall-seemore-btn').hide(200);

            var comment_count = $('#comments-count-' + post_id).text();
            comment_count = parseInt(comment_count) - 1;
            $('#comments-count-' + post_id).text(comment_count);
        }
 function likeComment(comment_id) {
                var current_id = '<?= $current_id ?>';
                $("#wall-post-single-comment-dislike-" + comment_id).css("display", "block");
                $("#wall-post-single-comment-like-" + comment_id).css("display", "none");
                $("#removed_likes_liksiting_comment" + comment_id).hide();
                var_likes_popup='';
                <?php if($current_user){ ?>
                var_likes_popup = '<li id="hide_likes_liksiting_comment' + comment_id + current_id + '"><div class="img-holder pre-main-image"><span class="hb_round_img hb_bg_img" style="width:35px; height: 35px; display: block; background-image: url(<?php echo $current_photo ?>)"></span> <span class="fest-pre-img" style="background-image: url(<?php echo $current_special_icon_user ?>);"></span>' +
                        '</div><div class="txt <?= getRatingClass($current_user->points); ?>"><i class="fa fa-thumbs-up" aria-hidden="true"></i>' +
                        '<span><a  class="<?= getRatingClass($current_user->points); ?>"  href="<?= asset('user-profile-detail/' . $current_id) ?>"><?= $current_user->first_name ?></a> liked this comment</span></div></li>';
                <?php } ?>
                $('#likes_liksiting_commets' + comment_id).prepend(var_likes_popup);
                $.ajax({
                    type: "POST",
                    url: "<?php echo asset('like-comment'); ?>",
                    data: {comment_id: comment_id, is_like: 1},
                    success: function (response) {
                        if (response.message == 'success') {
//                            $("#wall-post-single-dislike-" + post_id).css("display", "block");
//                            $("#wall-post-single-like-" + post_id).css("display", "none");
                            $(".total_likes_btn-comment" + comment_id).find("#likes-count-"+comment_id).text('('+response.likes_count+')');

//                            $("#likes-count-"+post_id).text(response.likes_count);
                        } else {
                            alert('Error.');
                        }
                    }
                });
            }
            function dislikeComment(comment_id) {
                var current_id = '<?= $current_id ?>';
                $("#wall-post-single-comment-like-" + comment_id).css("display", "block");
                $("#wall-post-single-comment-dislike-" + comment_id).css("display", "none");
                $("#hide_likes_liksiting_comment" + comment_id + current_id).hide();
                $.ajax({
                    type: "POST",
                    url: "<?php echo asset('like-comment'); ?>",
                    data: {comment_id: comment_id, is_like: 0},
                    success: function (response) {
                        if (response.message == 'success') {

                            $(".total_likes_btn-comment" + comment_id).find("#likes-count-"+comment_id).text('('+response.likes_count+')');

                            if (response.likes_count == 0) {
                                $("#removed_likes_liksiting_comment" + comment_id).css("display", "block");
                            }
                            //                            $("#likes-count-"+post_id).text(response.likes_count);
                        } else {
                            alert('Error.');
                        }
                    }
                });
            }
    </script>
    <?php if (isset($add_edit)) { ?>
        <script>
            var json_data = '<?= $comment->json_data ?>';
            var post_id = '<?= $comment->post_id ?>';
            json_data = JSON.parse(json_data);
            $.each(json_data, function (key, obj) {
                if (obj.type == 'user') {
                    image = getImage(obj.image_path, obj.avatar);
                    mention_users.push({
                        id: obj.id,
                        type: "user",
                        name: obj.first_name,
                        avatar: image,
                        trigger: "@",
                        value: obj.value
                    });
                }
                if (obj.type == 'budz') {
                    image = getBudzImage(obj.logo);
                    mention_users.push({
                        id: obj.id,
                        type: "budz",
                        name: obj.title,
                        avatar: image,
                        trigger: "@",
                        value: obj.value
                    });
                }
                if (obj.type == 'tag') {
                    image = getImage(obj.image_path, obj.avatar);
                    mention_tags.push({
                        id: obj.id,
                        type: "tag",
                        name: obj.title,
                        avatar: '<?= asset('userassets/images/ic_hashtag.png') ?>',
                        trigger: "#",
                        value: obj.value
                    });
                }
            });
        //                    alert(post_id)
            $('input.show_tag_hash' + post_id).mentionsInput('updateValues');
            
            
           

        </script>
    <?php } ?>
<?php } ?>



