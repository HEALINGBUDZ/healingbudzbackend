<!DOCTYPE html>
<html lang="en">
    <?php include('includes/top.php'); ?>
    <body class="chat">
        <div id="wrapper">
            <?php include('includes/sidebar.php'); ?>
            <article id="content">
                <?php include('includes/header.php'); ?>
                <div class="padding-div">
                    <ul class="bread-crumbs list-none">
                        <li><a href="<?php echo asset('/'); ?>">Home</a></li>
                        <li><a href="<?php echo asset('/groups'); ?>">Group</a></li>
                        <li>Messages</li>
                    </ul>
                    <div class="groups add">
                        <div class="messages">
                            <div class="fixed-block">
                                <header class="intro-header  pr">
                                    <h1 class="custom-heading orange"><?= $group->title ?></h1>
                                    <a href="#" class="sort-droper"><i class="fa fa-sort-desc" aria-hidden="true"></i></a>
                                </header>
                                <div class="healing-droper-area">
                                    <div class="d-table">
                                        <div class="d-inline">
                                            <div class="healing-droper">
                                                <?php if ($group->image) { ?>
                                                    <img src="<?php echo asset('public/images' . $group->image) ?>" class="img-responsive">
                                                <?php } else { ?>
                                                    <img src="<?php echo asset('userassets/images/img2.png') ?>" alt="Image" class="img-responsive">   
                                                <?php } ?>
                                                <div class="droper-holder">
                                                    <div class="droper-header">
                                                        <!--<a href="#"><i class="fa fa-share-alt" aria-hidden="true"></i></a>-->
                                                        <a href="#" class="share-icon"><i class="fa fa-share-alt" aria-hidden="true"></i></a>
                                                        <div class="custom-shares chat-shares">
                                                            <?php
                                                            echo Share::page(asset('group-chat/' . $group->id), $group->title, ['class' => 'group_class','id'=>$group->id])
                                                                    ->facebook($group->description)
                                                                    ->twitter($group->description)
                                                                    ->googlePlus($group->description);
                                                            ?>
                                                        </div>
                                                        <strong><?= $group->title ?></strong>
                                                    </div>
                                                    <div class="txt">
                                                        <p><?= $group->description ?></p>
                                                        <dl>
                                                            <dt>Group Owner:</dt>
                                                            <dd><?= $group->getAdmin->user->first_name ?></dd>
                                                        </dl>
                                                        <p class="small-tags">Tags: <em><?php
                                                                foreach ($group->getTags as $tags) {
                                                                    echo $tags->getTag->title . ' ,';
                                                                }
                                                                ?></em></p>
                                                        <?php if ($group->getAdmin->user->id == $current_id) { ?>
                                                            <a href="<?= asset('edit-group/' . $group->id); ?>" class="page-link"><?= $group->isFollowing->count() ?> Budz <i class="fa fa-angle-right" aria-hidden="true"></i></a>
                                                            <a href="<?= asset('edit-group/' . $group->id); ?>" class="page-link">Settings <i class="fa fa-angle-right" aria-hidden="true"></i></a>
                                                            <a href="#" class="popup-closer orange"><i class="fa fa-angle-up" aria-hidden="true"></i></a>
                                                        <?php } ?>
                                                        <?php if (!isGroupFollowing($current_id, $group->id)) { ?>
                                                            <a href="javascript:void(0)" onclick="addFollow('<?= $group->id ?>')"class="btn-primary yellow block" id="followgroup">JOIN GROUP</a>
                                                        <?php } ?>
                                                        <a href="#" class="popup-closer orange"><i class="fa fa-angle-up" aria-hidden="true"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="msgs-area scrolled_area" id="group_messgaes_listing">
                                <?php
                                foreach ($group_messages as $message) {
                                    if ($message->type == 'joined') {
                                        ?>
                                        <div class="joined-notice"><span><?= $message->text ?></span></div>
                                    <?php }else{ ?>
                                        <div class="msg">
                                            <div class="<?php if ($message->user->id == $current_id) { ?> msg-right <?php } else { ?> msg-left <?php } ?> ">

                                                <a onclick="addMessageLike('<?= $message->id ?>')" id="group_message_not_like<?= $message->id ?>" href="javascript:void(0)" <?php if ($message->is_liked_count) { ?> style="display: none" <?php } ?> class="likes"><i class="fa fa-heart-o custom-heart" aria-hidden="true"></i> <span id="like_count1<?= $message->id ?>"><?php echo $message->likes_count; ?></span></a>

                                                <a onclick="removeMessageLike('<?= $message->id ?>')" id="group_message_liked<?= $message->id ?>" href="javascript:void(0)" <?php if (!$message->is_liked_count) { ?> style="display: none" <?php } ?> class="likes"><i class="fa fa-heart custom-heart" aria-hidden="true"></i> <span id="like_count2<?= $message->id ?>"><?php echo $message->likes_count; ?></span></a>

                                                <div class="img-holder"><img src="<?= getImage($message->user->image_path, $message->user->avatar) ?>" alt="Image"></div>
                                                <div class="txt">
                                                    <strong>
                                                        <a class="<?= getRatingClass($message->user->points) ?>"  href="<?= asset('user-profile-detail/' . $message->user->id) ?>"><?= $message->user->first_name ?></a>
                                                    </strong>
                                                    <?php if ($message->type != 'joined' && $message->text) { ?>
                                                        <p><?= $message->text ?></p>
                                                    <?php } ?>
                                                </div>
                                                <?php if ($message->type == 'image') { ?>
                                                    <img src="<?php echo asset('public/images' . $message->file_path) ?>" alt="Image">
                                                <?php } ?>
                                                <?php if ($message->type == 'video') { ?>
                                                    <video controls="" poster="<?php echo asset('public/images' . $message->poster) ?>"> 
                                                        <source src="<?php echo asset('public/videos' . $message->file_path) ?>" type="video/mp4">
                                                    </video>
                                                <?php } ?>
                                                    <span class="chat-time"><?php echo timeago($message->created_at); ?></span>
                                            </div>
                                        </div>
                                    <?php } ?>
                                <?php } ?>
                                <form action="#" class="message-form">
                                    <fieldset>
                                        <label for="attachment" class="attachment-label">Attachment</label>
                                        <input type="file" id="attachment" class="hidden" accept="video/*,  video/x-m4v, video/webm, video/x-ms-wmv, video/x-msvideo, video/3gpp, video/flv, video/x-flv, video/mp4, video/quicktime, video/mpeg, video/ogv, .ts, .mkv, image/*">

                                        <input autocomplete="off" id="messagetext" type="text" placeholder="Type message..." data-emojiable="true">
                                        <div class="emo-holder">
                                        </div>
                                        <div class="attach-tile">
                                            <img id="loader_upload" style="display: none" class="attach-loader" src="<?php echo asset('userassets/images/attach-loader.gif') ?>">
                                            <div class="tiny-div">
                                                <a href="#" class="file-remover"><i class="fa fa-times-circle" aria-hidden="true"></i></a>
                                                <img id="tiny-icon" src="#">
                                                <video id="tiny-video" src="#"></video>
                                            </div>
                                        </div>
                                        <div class="upload-icon">
                                            <input type="text" id="upload-new" hidden="" onclick="uploadFile()" autocomplete="off"/>
                                            <label for="upload-new"><i class="fa fa-arrow-circle-up"></i></label>
                                        </div>
                                    </fieldset>
                                </form>
                            </div>
                    </div>
                </div>
            </article>
        </div>
        <?php include('includes/footer.php'); ?>
        <div id="chat-image-popup" class="popup">
            <div class="popup-holder">
                <div class="popup-area">
                    <div class="text">
                        <div class="txt">
                            <img src="" class="img-responsive">
                        </div>
                        <a href="#" class="btn-close"></a>
                    </div>
                </div>
            </div>
        </div>
        <script>
           setTimeout(function(){ $(".scrolled_area").stop().animate({ scrollTop: $(".scrolled_area")[0].scrollHeight}, 1000); }, 500);
        $('#messagetext').keyup(function(){
            setTimeout(function(){ $(".scrolled_area").stop().animate({ scrollTop: $(".scrolled_area")[0].scrollHeight}, 1000); }, 500);
        });


            $('.group_class').click(function(){
//                alert(this.id);
                $(this).parents('.custom-shares.chat-shares').hide();
//                question_id = this.id;
//                $.ajax({
//                    url: "<?php echo asset('add_question_share_points') ?>",
//                    type: "GET",
//                    data: {
//                        "question_id": question_id
//                    },
//                    success: function(data) {
//                    }
//                });  
            });
            
            
            var files;
            $('.msg img').click(function () {
                $('#chat-image-popup').show(300);
                var curent_img = $(this).attr('src');
                $('#chat-image-popup .txt img').attr('src', curent_img);
            });
            var group_id = '<?= $group_id ?>';
            $('.file-remover').click(function (e) {
                e.preventDefault();
                $('.tiny-div').hide();
                $("#tiny-video").attr("src", '');
                $("#tiny-icon").attr("src", '');
                $("#attachment").val('');
                files = '';
                
            });
            $("#attachment").change(function () {
                $('.tiny-div').show();
                var fileInput = document.getElementById('attachment');
                var fileUrl = window.URL.createObjectURL(fileInput.files[0]);
                var image_type = fileInput.files[0].type;

                if (image_type == "image/png" || image_type == "image/gif" ||  image_type == "image/jpeg" || image_type == "image/bmp" || image_type == "image/jpg") {
                    $("#tiny-video").attr("src", '');
                    $("#tiny-icon").attr("src", fileUrl);
                } else if (fileInput.files[0].type == "video/mp4") {
                    $("#tiny-video").attr("src", fileUrl);
                    $("#tiny-icon").attr("src", '');
                }
            });
            $("html, body").animate({scrollTop: $(document).height() + $(window).height()});

            $('#messagetext').keypress(function (e) {
                if (e.which === 13) {
                    var message = $('#messagetext').val();
                    $('#messagetext').val('');
                    $('.tiny-div').hide();
                    if (message || files) {
                        var data = new FormData();
                        if (files) {
                            $('#loader_upload').show();
                        }
                        $.each(files, function (key, value)
                        {
                            data.append('file', value);
                        });
                        data.append('message', message);
                        data.append('group_id', group_id);
                        if (message) {

                            $('.msg img').click(function () {
                                $('#chat-image-popup').show(300);
                                var curent_img = $(this).attr('src');
                                $('#chat-image-popup .txt img').attr('src', curent_img);
                            });
                            $("html, body").animate({scrollTop: $(document).height()}, "fast");
                        }
                        $('#tiny-icon').attr('src', "");
                        $('#attachment').attr('src', "");
                        files = '';
                        $.ajax({
                            type: "POST",
                            url: "<?php echo asset('add-group-message'); ?>",
                            data: data,
                            processData: false,
                            contentType: false,
                            success: function (data) {
                                $('#loader_upload').hide();
                                if (data) {
                                    result = JSON.parse(data);
                                    if (result.type == 'video') {
                                        $('.msg img').click(function () {
                                            $('#chat-image-popup').show(300);
                                            var curent_img = $(this).attr('src');

                                            $('#chat-image-popup .txt img').attr('src', curent_img);
                                        });
                                        var chat_message = '<div class="msg">' +
                                                '<div class="msg-right">' +
                                                '<a onclick="addMessageLike(' + result.id + ')" id="group_message_not_like' + result.id + '" href="javascript:void(0)" class="likes"><i class="fa fa-heart-o custom-heart" aria-hidden="true"></i> <span id="like_count1' + result.id + '">0</span></a>' +
                                                '<a onclick="removeMessageLike(' + result.id + ')" id="group_message_liked' + result.id + '" href="javascript:void(0)" style="display: none"  class="likes"><i class="fa fa-heart custom-heart" aria-hidden="true"></i> <span id="like_count2' + result.id + '">0</span></a>' +
                                                '<div class="img-holder"><img src="<?php echo $current_photo ?>" alt="Image"></div>' +
                                                '<div class="txt">' +
                                                '<strong><a href="<?= asset('user-profile-detail/' . $current_id) ?>"><?php echo $current_user->first_name ?></a></strong>' +
                                                '</div>' +
                                                '<video controls="" poster="' + result.image_base + result.poster + '">' +
                                                '<source src="' + result.video_base + result.file_path + '" type="video/mp4">' +
                                                '</video>' +
                                                '<span class="chat-time">Just Now</span>'+
                                                '</div>' +
                                                '</div>';
                                        $('#group_messgaes_listing').append(chat_message);
                                        $("html, body").animate({scrollTop: $(document).height()}, "fast");
                                    }
                                    if (result.type == 'image') {
                                        var chat_message = '<div class="msg">' +
                                                '<div class="msg-right">' +
                                                '<a onclick="addMessageLike(' + result.id + ')" id="group_message_not_like' + result.id + '" href="javascript:void(0)" class="likes"><i class="fa fa-heart-o custom-heart" aria-hidden="true"></i> <span id="like_count1' + result.id + '">0</span></a>' +
                                                '<a onclick="removeMessageLike(' + result.id + ')" id="group_message_liked' + result.id + '" href="javascript:void(0)" style="display: none"  class="likes"><i class="fa fa-heart custom-heart" aria-hidden="true"></i> <span id="like_count2' + result.id + '">0</span></a>' +
                                                '<div class="img-holder"><img src="<?php echo $current_photo ?>" alt="Image"></div>' +
                                                '<div class="txt">' +
                                                '<strong><a href="<?= asset('user-profile-detail/' . $current_id) ?>"><?php echo $current_user->first_name ?></a></strong>' +
                                                '</div>' +
                                                '<img src="' + result.image_base + result.file_path + '" alt="Image">' +
                                                '<span class="chat-time">Just Now</span>'+
                                                '</div>' +
                                                '</div>';
                                        $('#group_messgaes_listing').append(chat_message);
                                        $("html, body").animate({scrollTop: $(document).height()}, "fast");
                                    }
                                    if (result.type == 'text') {
                                        var chat_message = '<div class="msg">' +
                                                '<div class="msg-right">' +
                                                '<a onclick="addMessageLike(' + result.id + ')" id="group_message_not_like' + result.id + '" href="javascript:void(0)" class="likes"><i class="fa fa-heart-o custom-heart" aria-hidden="true"></i> <span id="like_count1' + result.id + '">0</span></a>' +
                                                '<a onclick="removeMessageLike(' + result.id + ')" id="group_message_liked' + result.id + '" href="javascript:void(0)" style="display: none"  class="likes"><i class="fa fa-heart custom-heart" aria-hidden="true"></i> <span id="like_count2' + result.id + '">0</span></a>' +
                                                '<div class="img-holder"><img src="<?php echo $current_photo ?>" alt="Image"></div>' +
                                                '<div class="txt">' +
                                                '<strong><a href="<?= asset('user-profile-detail/' . $current_id) ?>"><?php echo $current_user->first_name ?></a></strong>' +
                                                '<p>' + result.text + '</p>' +
                                                '<span class="chat-time">Just Now</span>'+
                                                '</div>' +
                                                '</div>' +
                                                '</div>';
                                        $('#group_messgaes_listing').append(chat_message);
                                    }
                                    socket.emit('group_message_get', {
                                        "group_id": result.group_id,
                                        "other_id": '<?php echo $current_id; ?>',
                                        "other_name": '<?php echo $current_user->first_name; ?>',
                                        "photo": '<?php echo $group_user_photo; ?>',
                                        "text": result.text,
                                        "file": result.file_path,
                                        "type": result.type,
                                        "file_poster": result.poster,
                                        "images_base": result.image_base,
                                        "video_base": result.video_base,
                                        "message_id": result.id
                                    });
                                }
                            }
                        });
                    }
                }
            });
            var group_id =<?= $group_id ?>;
            var current_user_id =<?= $current_id ?>;
            socket.on('group_message_send', function (data) {
                if (data.group_id == group_id && current_user_id != data.other_id) {
                    var profile = '<?= asset("user-profile-detail/") ?>';
                    if (data.text) {
                        var chat_message = '<div class="msg">' +
                                '<div class="msg-left">' +
                                '<a onclick="addMessageLike(' + data.message_id + ')" id="group_message_not_like' + data.message_id + '" href="javascript:void(0)" class="likes"><i class="fa fa-heart-o custom-heart" aria-hidden="true"></i> <span id="like_count1' + data.message_id + '">0</span></a>' +
                                '<a onclick="removeMessageLike(' + data.message_id + ')" id="group_message_liked' + data.message_id + '" href="javascript:void(0)" style="display: none"  class="likes"><i class="fa fa-heart custom-heart" aria-hidden="true"></i> <span id="like_count2' + data.message_id + '">0</span></a>' +
                                '<div class="img-holder"><img src="' + data.images_base + data.photo + '" alt="Image"></div>' +
                                '<div class="txt">' +
                                '<strong><a href="' + profile + data.other_id + '">' + data.other_name + '</a></strong>' +
                                '<p>' + data.text + '</p>' +
                                '<span class="chat-time">Just Now</span>'+
                                '</div>' +
                                '</div>' +
                                '</div>';
                        $('#group_messgaes_listing').append(chat_message);
                        $("html, body").animate({scrollTop: $(document).height()}, "fast");
                    }
                    if (data.file_type == 'image') {
                        var chat_message = '<div class="msg">' +
                                '<div class="msg-left">' +
                                '<a onclick="addMessageLike(' + data.message_id + ')" id="group_message_not_like' + data.message_id + '" href="javascript:void(0)" class="likes"><i class="fa fa-heart-o custom-heart" aria-hidden="true"></i> <span id="like_count1' + data.message_id + '">0</span></a>' +
                                '<a onclick="removeMessageLike(' + data.message_id + ')" id="group_message_liked' + data.message_id + '" href="javascript:void(0)" style="display: none"  class="likes"><i class="fa fa-heart custom-heart" aria-hidden="true"></i> <span id="like_count2' + data.message_id + '">0</span></a>' +
                                '<div class="img-holder"><img src="' + data.images_base + data.photo + '" alt="Image"></div>' +
                                '<div class="txt">' +
                                '<strong><a href="' + profile + data.other_id + '">' + data.other_name + '</a></strong>' +
                                '</div>' +
                                '<img src="' + data.images_base + data.file + '" alt="Image">' +
                                '<span class="chat-time">Just Now</span>'+
                                '</div>' +
                                '</div>';
                        $('#group_messgaes_listing').append(chat_message);
                        $("html, body").animate({scrollTop: $(document).height()}, "fast");
                    }
                    if (data.file_type == 'video') {
                        var chat_message = '<div class="msg">' +
                                '<div class="msg-left">' +
                                '<a onclick="addMessageLike(' + data.message_id + ')" id="group_message_not_like' + data.message_id + '" href="javascript:void(0)" class="likes"><i class="fa fa-heart-o custom-heart" aria-hidden="true"></i> <span id="like_count1' + data.message_id + '">0</span></a>' +
                                '<a onclick="removeMessageLike(' + data.message_id + ')" id="group_message_liked' + data.message_id + '" href="javascript:void(0)" style="display: none"  class="likes"><i class="fa fa-heart custom-heart" aria-hidden="true"></i> <span id="like_count2' + data.message_id + '">0</span></a>' +
                                '<div class="img-holder"><img src="' + data.images_base + data.photo + '" alt="Image"></div>' +
                                '<div class="txt">' +
                                '<strong><a href="' + profile + data.other_id + '">' + data.other_name + '</a></strong>' +
                                '</div>' +
                                '<video controls="" poster="' + data.images_base + data.file_poster + '">' +
                                '<source src="' + data.video_base + data.file + '" type="video/mp4">' +
                                '</video>' +
                                '<span class="chat-time">Just Now</span>'+
                                '</div>' +
                                '</div>';
                        $('#group_messgaes_listing').append(chat_message);
                        $("html, body").animate({scrollTop: $(document).height()}, "fast");
                    }
                }
            });
            $('#attachment').on('change', prepareUpload);
            function prepareUpload(event)
            {
                files = event.target.files;
                var input = document.getElementById('attachment');
                var filePath = input.value;
                var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif|\.mp4|\.mkv|\.mov|\.flv|\.mpeg|\.webm|\.mpeg|\.avi|\.ts|\.ogv)$/i;
                if (!allowedExtensions.exec(filePath)) {
                    alert('Please upload file having extensions .jpeg/.jpg/.png/.gif/.mp4/.mkv/.mov/.3gp/.flv/.mpeg/.webm/.mpeg/.avi/.ts/.ogv/bm  only.');
                    $('#attachment').val('');
                    $('#imagePreview').html('');
                    $('.tiny-div').hide();
                    return false;
                    files = '';
                }
            }
            function uploadFile() {
                var message = $('#messagetext').val();
                $('#messagetext').val('');
                $('.tiny-div').hide();
                if (message || files) {
                    var data = new FormData();
                    if (files) {
                        $('#loader_upload').show();
                    }
                    $.each(files, function (key, value)
                    {
                        data.append('file', value);
                    });
                    data.append('message', message);
                    data.append('group_id', group_id);
                    if (message) {
                        $("html, body").animate({scrollTop: $(document).height()}, "fast");
                    }
                    $('#tiny-icon').attr('src', "");
                    $('#attachment').attr('src', "");
                    files = '';
                    $.ajax({
                        type: "POST",
                        url: "<?php echo asset('add-group-message'); ?>",
                        data: data,
                        processData: false,
                        contentType: false,
                        success: function (data) {
                            $('#loader_upload').hide();
                            if (data) {
                                result = JSON.parse(data);
                                if (result.type == 'video') {
                                    var chat_message = '<div class="msg">' +
                                            '<div class="msg-right">' +
                                            '<a onclick="addMessageLike(' + result.id + ')" id="group_message_not_like' + result.id + '" href="javascript:void(0)" class="likes"><i class="fa fa-heart-o custom-heart" aria-hidden="true"></i> <span id="like_count1' + result.id + '">0</span></a>' +
                                            '<a onclick="removeMessageLike(' + result.id + ')" id="group_message_liked' + result.id + '" href="javascript:void(0)" style="display: none"  class="likes"><i class="fa fa-heart custom-heart" aria-hidden="true"></i> <span id="like_count2' + result.id + '">0</span></a>' +
                                            '<div class="img-holder"><img src="<?php echo $current_photo ?>" alt="Image"></div>' +
                                            '<div class="txt">' +
                                            '<strong><a href="<?= asset('user-profile-detail/' . $current_id) ?>"><?php echo $current_user->first_name ?></a></strong>' +
                                            '</div>' +
                                            '<video controls="" poster="' + result.image_base + result.poster + '">' +
                                            '<source src="' + result.video_base + result.file_path + '" type="video/mp4">' +
                                            '</video>' +
                                            '<span class="chat-time">Just Now</span>'+
                                            '</div>' +
                                            '</div>';
                                    $('#group_messgaes_listing').append(chat_message);
                                    $("html, body").animate({scrollTop: $(document).height()}, "fast");
                                }
                                if (result.type == 'image') {
                                    var chat_message = '<div class="msg">' +
                                            '<div class="msg-right">' +
                                            '<a onclick="addMessageLike(' + result.id + ')" id="group_message_not_like' + result.id + '" href="javascript:void(0)" class="likes"><i class="fa fa-heart-o custom-heart" aria-hidden="true"></i> <span id="like_count1' + result.id + '">0</span></a>' +
                                            '<a onclick="removeMessageLike(' + result.id + ')" id="group_message_liked' + result.id + '" href="javascript:void(0)" style="display: none"  class="likes"><i class="fa fa-heart custom-heart" aria-hidden="true"></i> <span id="like_count2' + result.id + '">0</span></a>' +
                                            '<div class="img-holder"><img src="<?php echo $current_photo ?>" alt="Image"></div>' +
                                            '<div class="txt">' +
                                            '<strong><a href="<?= asset('user-profile-detail/' . $current_id) ?>"><?php echo $current_user->first_name ?></a></strong>' +
                                            '</div>' +
                                            '<img src="' + result.image_base + result.file_path + '" alt="Image">' +
                                            '<span class="chat-time">Just Now</span>'+
                                            '</div>' +
                                            '</div>';
                                    $('#group_messgaes_listing').append(chat_message);
                                    $("html, body").animate({scrollTop: $(document).height()}, "fast");
                                }
                                if (result.type == 'text') {
                                    var chat_message = '<div class="msg">' +
                                            '<div class="msg-right">' +
                                            '<a onclick="addMessageLike(' + result.id + ')" id="group_message_not_like' + result.id + '" href="javascript:void(0)" class="likes"><i class="fa fa-heart-o custom-heart" aria-hidden="true"></i> <span id="like_count1' + result.id + '">0</span></a>' +
                                            '<a onclick="removeMessageLike(' + result.id + ')" id="group_message_liked' + result.id + '" href="javascript:void(0)" style="display: none"  class="likes"><i class="fa fa-heart custom-heart" aria-hidden="true"></i> <span id="like_count2' + result.id + '">0</span></a>' +
                                            '<div class="img-holder"><img src="<?php echo $current_photo ?>" alt="Image"></div>' +
                                            '<div class="txt">' +
                                            '<strong><a href="<?= asset('user-profile-detail/' . $current_id) ?>"><?php echo $current_user->first_name ?></a></strong>' +
                                            '<p>' + result.text + '</p>' +
                                            '<span class="chat-time">Just Now</span>'+
                                            '</div>' +
                                            '</div>' +
                                            '</div>';
                                    $('#group_messgaes_listing').append(chat_message);
                                }
                                socket.emit('group_message_get', {
                                    "group_id": result.group_id,
                                    "other_id": '<?php echo $current_id; ?>',
                                    "other_name": '<?php echo $current_user->first_name; ?>',
                                    "photo": '<?php echo $group_user_photo; ?>',
                                    "text": result.text,
                                    "file": result.file_path,
                                    "type": result.type,
                                    "file_poster": result.poster,
                                    "images_base": result.image_base,
                                    "video_base": result.video_base
                                });
                            }
                        }
                    });
                }
            }

        </script>

        <script>
            function addMessageLike(id)
            {
                count = parseInt($('#like_count1' + id).html());

                $('#like_count1' + id).html(count + 1);
                $('#like_count2' + id).html(count + 1);
                $('#group_message_not_like' + id).hide();
                $('#group_message_liked' + id).show();
                $.ajax({
                    type: "GET",
                    url: "<?php echo asset('add-group-message-like'); ?>",
                    data: {"id": id},
                    success: function () {

                    }
                });
            }
            function removeMessageLike(id) {
                count = parseInt($('#like_count1' + id).html());
                if (count != 0) {
                    $('#like_count1' + id).html(count - 1);
                    $('#like_count2' + id).html(count - 1);
                }
                $('#group_message_not_like' + id).show();
                $('#group_message_liked' + id).hide();
                $.ajax({
                    type: "GET",
                    url: "<?php echo asset('remove-group-message-like'); ?>",
                    data: {"id": id},
                    success: function () {

                    }
                });
            }
            function addFollow(group_id) {
                $('#followgroup').hide();
                $.ajax({
                    type: "GET",
                    url: "<?php echo asset('add-to-follow'); ?>",
                    data: {"group_id": group_id},
                    success: function () {

                    }});
            }
        </script>
    </body>


</html>