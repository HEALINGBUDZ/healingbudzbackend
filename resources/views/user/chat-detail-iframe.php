<!DOCTYPE html>
<html lang="en">
    <?php include('includes/top.php'); ?>
    <body class="chat">

        <div id="wrapper">
            <?php include('includes/sidebar.php'); ?>
            <article id="content">

                <?php // include('includes/header.php'); ?>

                <div class="padding-div chat-main chat-iframe">
                    <div class="new_container">

                        <div class="chat-top-header">
                            <a href="<?php echo asset('messages'); ?>"><i class="fa fa-arrow-circle-left"></i> Inbox</a>
                            <div class="wid_info header-chat-img">
                                <a class="pre-main-image" href="<?= asset('user-profile-detail/' . $other_user->id) ?>">
                                    <img src="<?php echo getImage($other_user->image_path, $other_user->avatar); ?>" alt="Icon" class="img-user">
                                    <?php if ($other_user->special_icon) { ?>
                                        <span class="fest-pre-img" style="background-image: url(<?php echo asset('public/images' . $other_user->special_icon) ?>);"></span>
                                    <?php } ?>
                                    <strong class="<?= getRatingClass($other_user->points) ?>"><?= $other_user->first_name ?> <span>to me</span></strong>
                                </a>
                            </div>
                        </div>
                        <ul class="bread-crumbs list-none">
                            <li><a href="<?php echo asset('/'); ?>">Home</a></li>
                            <li>Messages</li>
                        </ul>
                        <div class="menu-message-detail">
                            <div class="groups add">
                                <header class="intro-header chat-details">
                                    <img src="<?php echo getImage($other_user->image_path, $other_user->avatar) ?>" alt="" />

                                    <h1 class="custom-heading <?= getRatingClass($other_user->points) ?>"><?= $other_user->first_name ?></h1>
                                </header>
                                <!-- <hr> -->
                                <div class="messages">
                                    <!--<input data-emojiable="true">-->
                                    <span class="msg-time no-margin">Today</span>
                                    <div id="chat_listing" class="scrolled_area">
                                        <?php
                                        foreach ($messages as $message) {
                                            if ($message->receiver_id == $current_id) {
                                                ?>
                                                <div class="cus-msg-left">
                                                    <span class="hb_user_img_wrap">
                                                        <div class="hb_chat_user_name"> <?= $other_user->first_name ?> </div>
                                                        <!--<img class="img-user chat-icon" src="<?php echo getImage($other_user->image_path, $other_user->avatar) ?>">-->
                                                        <div class="profile_pic" style=" background-image: url('<?php echo getImage($other_user->image_path, $other_user->avatar) ?>') "></div>
                                                    </span>
                                                    <div class="inner">
                                                        <?php if ($message->message && $message->site_title == NULL) { ?>
                                                            <p><?= $message->message ?></p>
                                                        <?php } if ($message->site_title) { ?>
                                                            <a href="<?= $message->site_extracted_url; ?>" target="_blank" class="hb_scapping_msg">
                                                                <div class="hb_scrap_box">
                                                                    <div class="hb_scrapping_img" style="background-image: url(<?= $message->site_image ?>)"></div>
                                                                    <div class="hb_scrapping_info">
                                                                        <p class="hb_scp_title"><strong><?= $message->site_title ?></strong></p>
                                                                        <p class="hb_scp_des"><?= $message->site_content; ?></p>
                                                                        <p class="hb_scp_lnk"><strong><?= $message->site_url; ?></strong></p>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                        <?php } if ($message->file_type == 'video') { ?>
                                                            <video controls="" poster="<?php echo asset('public/images' . $message->poster); ?>">
                                                                <source src="<?php echo asset('public/videos' . $message->file_path); ?>" type="video/mp4">
                                                            </video>
                                                        <?php } if ($message->file_type == 'image') { ?>
                                                            <img src="<?php echo asset(image_fix_orientation('public/images' . $message->file_path)); ?>">
                                                        <?php } ?>

                                                    </div>
                                                    <p class="chat-time"><i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo timeago($message->created_at); ?></p>
                                                </div>
                                            <?php } else { ?>
                                                <div class="cus-msg-right">
                                                    <div class="inner">
                                                        <?php if ($message->message && $message->site_title == NULL) { ?>
                                                            <p><?= $message->message ?></p>
                                                        <?php } if ($message->site_title) { ?>
                                                            <a href="<?= $message->site_extracted_url; ?>" target="_blank" class="hb_scapping_msg">
                                                                <div class="hb_scrap_box">
                                                                    <div class="hb_scrapping_img" style="background-image: url(<?= $message->site_image ?>)"></div>
                                                                    <div class="hb_scrapping_info">
                                                                        <p class="hb_scp_title"><strong><?= $message->site_title ?></strong></p>
                                                                        <p class="hb_scp_des"><?= $message->site_content; ?></p>
                                                                        <p class="hb_scp_lnk"><strong><?= $message->site_url; ?></strong></p>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                        <?php } if ($message->file_type == 'video') { ?>
                                                            <video controls="" poster="<?php echo asset('public/images' . $message->poster); ?>">
                                                                <source src="<?php echo asset('public/videos' . $message->file_path); ?>" type="video/mp4">
                                                            </video>
                                                        <?php } if ($message->file_type == 'image') { ?>
                                                            <img src="<?php echo asset(image_fix_orientation('public/images' . $message->file_path)); ?>">
                                                        <?php } ?>

                                                    </div>
                                                    <p class="chat-time"><i class="fa fa-clock-o" aria-hidden="true"></i>  <?php echo timeago($message->created_at); ?></p>
                                                </div>
                                                <?php
                                            }
                                        }
                                        ?>
                                        <div class="bottom-scroll"></div>
                                    </div>
                                    <form action="#" class="message-form">
                                        <fieldset>
                                            <label for="attachment" class="attachment-label">Attachment</label>
                                            <input type="file"  class="hidden" accept="video/*,  video/x-m4v, video/webm, video/x-ms-wmv, video/x-msvideo, video/3gpp, video/flv, video/x-flv, video/mp4, video/quicktime, video/mpeg, video/ogv, .ts, .mkv, image/*" id="attachment">

                                            <input id="messagetext" type="text" placeholder="Write your message..." data-emojiable="true" autocomplete="off">
                                            <label for="youridhere" class="static-value"><i class="fa fa-keyboard-o"></i></label>
                                            <input id="scrape_url" type="hidden">
                                            <div class="emo-holder">
                                                <!--<a href="#" class="btn-emotions"></a>
                                                <input type="submit" value="Submit">-->
                                            </div>
                                            <div class="attach-tile hb_attached_file">
                                                <span id="showErrorAll" class="hb_notify_msg red"  style="display: none;position: relative;    line-height: 3;border-radius: 8px;"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></span>
                                                <div class="tiny-div chat-img">
                                                    <img id="loader_upload" class="attach-loader upload_file_loader" style="display: none" src="<?php echo asset('userassets/images/new_loadeer.svg') ?>">                                                    
                                                    <a href="#" class="file-remover"><i class="fa fa-times-circle" aria-hidden="true"></i></a>
                                                    <!--<img id="tiny-icon" src="#">-->
                                                    <span id="tiny-icon"></span>
                                                    <video id="tiny-video" src="#"></video>
                                                </div>
                                            </div>
                                            <div class="upload-icon">
                                                <input type="text" id="upload-new" hidden="" onclick="sendMessage()"/>
                                                <label for="upload-new"><i class="fa fa-level-up"></i></label>
                                            </div>
                                        </fieldset>
                                    </form>


                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="right_sidebars">
                        <?php include 'includes/rightsidebar.php'; ?>
                        <?php // include 'includes/chat-rightsidebar.php'; ?>
                    </div>
                </div>

            </article>
        </div>
        <!-- Modal -->
        <div id="delete-chat-<?php echo $chat_user_id; ?>" class="popup">
            <div class="popup-holder">
                <div class="popup-area">
                    <div class="text">
                        <div class="edit-holder">
                            <div class="step">
                                <div class="step-header">
                                    <h4>Delete COmment</h4>
                                    <p class="yellow no-margin">Are you sure to delete this comment.</p>
                                </div>
                                <a href="<?php echo asset('delete-chat/' . $chat_user_id); ?>" class="btn-heal">yes</a>
                                <a href="#" class="btn-heal btn-close">No</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal End-->
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
    </body>
    <script>
        $('body').addClass('hide_chat');
        $(function () {
            $(".cus-msg-left .img-user").tooltip({
                show: {
                    effect: "slideDown",
                    delay: 250
                }
            });
        });


        setTimeout(function () {
            $(".scrolled_area").stop().animate({scrollTop: $(".scrolled_area")[0].scrollHeight}, 1000);
        }, 500);
        $('#messagetext').keyup(function () {
            setTimeout(function () {
                $(".scrolled_area").stop().animate({scrollTop: $(".scrolled_area")[0].scrollHeight}, 1000);
            }, 500);
        });


        $(document).ready(function () {
            if (window.top != window) {
                $('#header').hide();
                $('.padding-div').css('padding-top', '0px');
            }
            //url scraping
            var getUrl = $('#messagetext'); //url to extract from text field
            getUrl.keyup(function () { //user types url in text field       
                //url to match in the text field
                var match_url = /\b(https?):\/\/([\-A-Z0-9.]+)(\/[\-A-Z0-9+&@#\/%=~_|!:,.;]*)?(\?[A-Z0-9+&@#\/%=~_|!:,.;]*)?/i;
                //continue if matched url is found in text field
                if (match_url.test(getUrl.val())) {
//                    $('#post_loader').show();//show loading indicator image
//                    $("#submit_post").css( 'pointer-events', 'none'); //disable post button
                    var extracted_url = getUrl.val().match(match_url)[0]; //extracted first url from text filed
                    var www_url = extracted_url.replace(/(^\w+:|^)\/\//, '');
//                    alert(extracted_url);
                    $('#scrape_url').val(extracted_url);
                }
            });
        });


        var files;
//        $('.messages img').click(function () {
        $('.messages').on("click", '.inner img', function () {

            $('#chat-image-popup').show(300);
            var curent_img = $(this).attr('src');
            $('#chat-image-popup .txt img').attr('src', curent_img);
        });

        $('.file-remover').click(function (e) {

            e.preventDefault();

            $('.tiny-div, .upload_file_loader').hide();
            $("#tiny-video").attr("src", '');
//            $("#tiny-icon").attr("src", '');
            $("#tiny-icon").css("backgroundImage", 'url()');

            $("#tiny-video").hide();
            $("#tiny-icon").hide();

            $("#attachment").val('');
            files = '';
        });

        $("#attachment").change(function () {
            $('.tiny-div').show();
            var fileInput = document.getElementById('attachment');
            var fileUrl = window.URL.createObjectURL(fileInput.files[0]);
            var image_type = fileInput.files[0].type;

            if (image_type == "image/png" || image_type == "image/gif" || image_type == "image/jpeg" || image_type == "image/bmp" || image_type == "image/jpg") {

                var file = fileInput.files[0];
                var reader = new FileReader();
                reader.onloadend = function () {
                    getOrientation(file, function (orientation) {
//                            alert(orientation);
                        resetOrientation(reader.result, orientation, function (result) {
                            $("#tiny-video").attr("src", '');
                            $("#tiny-video").hide();
                            $("#tiny-icon").show();
//                            $("#tiny-icon").attr("src", result);

                            $("#tiny-icon").css("backgroundImage", 'url(' + result + ')');
                        });
                    });
                };
                reader.readAsDataURL(file);

//                $("#tiny-video").attr("src", '');
//                $("#tiny-icon").attr("src", fileUrl);
            } else if (fileInput.files[0].type == "video/mp4" || fileInput.files[0].type == "video/quicktime") {

                $("#tiny-video").show();
                $("#tiny-icon").hide();
                $("#tiny-video").attr("src", fileUrl);
                var myVideo = document.getElementById("tiny-video");
                myVideo.addEventListener("loadedmetadata", function ()
                {
                    duration = (Math.round(myVideo.duration * 100) / 100);
                    if (duration >= 21) {
                        $('#showErrorAll').html('<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Video is greater than 20 sec.').show().fadeOut(5000);

                        $("#tiny-video").attr("src", '');
                        $('.tiny-div').hide();
                    }
                });
//                $("#tiny-icon").attr("src", '');
                $("#tiny-icon").css("backgroundImage", 'url()');
                $("#tiny-icon").hide();
            } else {
                files = '';
                $('#showErrorAll').html('<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Please Select a valid image or video').show().fadeOut(5000);
                $("#tiny-icon").hide();
                $(".tiny-div").hide();
            }
        });



        $('#messagetext').keypress(function (e) {
            if (e.which === 13) {
                sendMessage();
            }
        });
        current_id =<?= $current_id ?>;
        other_id =<?= $other_user_chat_id ?>;
        socket.on('message_send', function (data) {

            if (data.user_id == current_id && other_id == data.other_id) {

                if (data.text) {
                    if (data.site_title && data.site_image) {
                        $('#chat_listing .cus-msg-right:last').fadeOut(); //remove url text
                        var chat_message = '<div class="cus-msg-left">' +
                                '<img class="img-user chat-icon" src="<?php echo getImage($other_user->image_path, $other_user->avatar) ?>">' +
                                '<div class="inner">' +
                                '<a href="' + data.site_extracted_url + '" target="_blank" class="hb_scapping_msg">' +
                                '<div class="hb_scrap_box">' +
                                '<div class="hb_scrapping_img" style="background-image: url(' + data.site_image + ')"></div>' +
                                '<div class="hb_scrapping_info">' +
                                '<p class="hb_scp_title"><strong>' + data.site_title + '</strong></p>' +
                                '<p class="hb_scp_des">' + data.site_content + '</p>' +
                                '<p class="hb_scp_lnk"><strong>' + data.site_url + '</strong></p>' +
                                '</div>' +
                                '</div>' +
                                '</a>' +
                                '</div>' +
                                '<p class="chat-time"><i class="fa fa-clock-o" aria-hidden="true"></i> Just Now</p>' +
                                '</div>';
                        $('#chat_listing').append(chat_message);
                        $("html, body").animate({scrollTop: $(document).height()}, "fast");
                    } else {
                        var chat_message = '<div class="cus-msg-left">' +
                                '<img class="img-user chat-icon" src="<?php echo getImage($other_user->image_path, $other_user->avatar) ?>">' +
                                '<div class="inner">' +
                                '<p>' + data.text + '</p>' +
                                '</div>' +
                                '<p class="chat-time"><i class="fa fa-clock-o" aria-hidden="true"></i> Just Now</p>' +
                                '</div>';
                        $('#chat_listing').append(chat_message);
                        $("html, body").animate({scrollTop: $(document).height()}, "fast");
                    }
                }
                if (data.file_type == 'image') {
                    var text_message = '';
                    if (data.text) { // text attach with image
                        $('#chat_listing .cus-msg-left:last').fadeOut(); //remove text dive attach with image first
                        text_message = '<p>' + data.text + '</p>';
                    }
                    var chat_message = '<div class="cus-msg-left">' +
                            '<img class="img-user chat-icon" src="<?php echo getImage($other_user->image_path, $other_user->avatar) ?>">' +
                            '<div class="inner">' + text_message +
                            '<img src="' + data.images_base + data.file + '" alt="" />' +
                            '</div>' +
                            '<p class="chat-time"><i class="fa fa-clock-o" aria-hidden="true"></i> Just Now</p>' +
                            '</div>';
                    $('#chat_listing').append(chat_message);
                    $('.messages img').click(function () {
                        $('#chat-image-popup').show(300);
                        var curent_img = $(this).attr('src');
                        $('#chat-image-popup .txt img').attr('src', curent_img);
                    });
                    $("html, body").animate({scrollTop: $(document).height()}, "fast");
                }
                if (data.file_type == 'video') {
                    var text_message = '';
                    if (data.text) { // text attach with video
                        $('#chat_listing .cus-msg-left:last').fadeOut(); //remove text dive attach with video first
                        text_message = '<p>' + data.text + '</p>';
                    }
                    var chat_message = '<div class="cus-msg-left">' +
                            '<img class="img-user chat-icon" src="<?php echo getImage($other_user->image_path, $other_user->avatar) ?>">' +
                            '<div class="inner">' + text_message +
                            '<video controls="" poster="' + data.images_base + data.file_poster + '">' +
                            '<source src="' + data.video_base + data.file + '" type="video/mp4">' +
                            '</video>' +
                            '</div>' +
                            '<p class="chat-time"><i class="fa fa-clock-o" aria-hidden="true"></i> Just Now</p>' +
                            '</div>';
                    $('#chat_listing').append(chat_message);
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

                $('#showErrorAll').html('<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Please Select a valid image or video').show().fadeOut(5000);
                $('#attachment').val('');
                $('#imagePreview').html('');
                $('.tiny-div').hide();
                files = '';
                return false;
            }
        }

        function sendMessage() {
            $('.hb_attached_file .tiny-div').addClass('hb_img_uplaoding');
            var otherid = <?= $other_user_chat_id ?>;
            var message = $('#messagetext').val();
            var scrape_url = $('#scrape_url').val();
            $('#messagetext').val('');
            $('#scrape_url').val('');
//            $('.tiny-div').hide();
            if (message) {
                $.ajax({
                    type: "get",
                    url: "<?php echo asset('get_url_message'); ?>",
                    data: {
                        "message": message,
                        "scrape_url": scrape_url
                    },
                    success: function (data) {

                        var chat_message = '<div class="cus-msg-right">' +
                                '<div class="inner">' +
                                '<p>' + JSON.parse(data) + '</p>' +
                                '</div>' +
                                '<p class="chat-time"><i class="fa fa-clock-o" aria-hidden="true"></i> Just Now</p>' +
                                '</div>';
                        $('#chat_listing').append(chat_message);
                        $("html, body").animate({scrollTop: $(document).height()}, "fast");
                    }
                });

            }
            if (message || files) {
                if (files) {
                    $('#loader_upload').show();
                }
                var data = new FormData();
                $.each(files, function (key, value)
                {
                    data.append('file', value);
                });
                data.append('message', message);
                data.append('receiver_id', otherid);
                data.append('scrape_url', scrape_url);


                $('#attachment').attr('src', "");
                files = '';
                $.ajax({
                    type: "POST",
                    url: "<?php echo asset('add_message'); ?>",
                    data: data,
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        $('.hb_attached_file .tiny-div').removeClass('hb_img_uplaoding');
                        $('.tiny-div').hide();
                        if (data) {
                            $('#loader_upload').hide();
                            $('#tiny-video').attr('src', "");
//                            $('#tiny-icon').attr('src', "");
                            $("#tiny-icon").css("backgroundImage", 'url()');
                            result = JSON.parse(data);
                            if (result.file_type == 'video') {
                                var text_message = '';
                                if (result.message) { // text attach with video
                                    $('#chat_listing .cus-msg-right:last').fadeOut(); //remove text dive attach with video first
                                    text_message = '<p>' + result.message + '</p>';
                                }
                                var chat_message = '<div class="cus-msg-right">' +
                                        '<div class="inner">' + text_message +
                                        '<video controls="" poster="' + result.image_base + result.poster + '">' +
                                        '<source src="' + result.video_base + result.file_path + '" type="video/mp4">' +
                                        '</video>' +
                                        '</div><p class="chat-time"><i class="fa fa-clock-o" aria-hidden="true"></i> Just Now</p></div>';
                                $('#chat_listing').append(chat_message);
                                $("html, body").animate({scrollTop: $(document).height()}, "fast");
                            }
                            if (result.file_type == 'image') {
                                $('.messages img').on("click", function () {
                                    $('#chat-image-popup').show(300);
                                    var curent_img = $(this).attr('src');
                                    $('#chat-image-popup .txt img').attr('src', curent_img);
                                });
                                var text_message = '';
                                if (result.message) { // text attach with image
                                    $('#chat_listing .cus-msg-right:last').fadeOut(); //remove text dive attach with image first
                                    text_message = '<p>' + result.message + '</p>';
                                }
                                var chat_message = '<div class="cus-msg-right">' +
                                        '<div class="inner">' + text_message +
                                        '<img src="' + result.image_base + result.file_path + '" alt="" />' +
                                        '</div>' +
                                        '<p class="chat-time"><i class="fa fa-clock-o" aria-hidden="true"></i> Just Now</p>' +
                                        '</div>';
                                $('#chat_listing').append(chat_message);
                                $("html, body").animate({scrollTop: $(document).height()}, "fast");
                            }
                            if (result.site_title && result.site_image) {
                                $('#chat_listing .cus-msg-right:last').fadeOut();
                                var chat_message = '<div class="cus-msg-right">' +
                                        '<div class="inner">' +
                                        '<a href="' + result.site_extracted_url + '" target="_blank" class="hb_scapping_msg">' +
                                        '<div class="hb_scrap_box">' +
                                        '<div class="hb_scrapping_img" style="background-image: url(' + result.site_image + ')"></div>' +
                                        '<div class="hb_scrapping_info">' +
                                        '<p class="hb_scp_title"><strong>' + result.site_title + '</strong></p>' +
                                        '<p class="hb_scp_des">' + result.site_content + '</p>' +
                                        '<p class="hb_scp_lnk"><strong>' + result.site_url + '</strong></p>' +
                                        '</div>' +
                                        '</div>' +
                                        '</a>' +
                                        '</div>' +
                                        '<p class="chat-time"><i class="fa fa-clock-o" aria-hidden="true"></i> Just Now</p>' +
                                        '</div>';
                                $('#chat_listing').append(chat_message);
                                $("html, body").animate({scrollTop: $(document).height()}, "fast");
                            }

                            socket.emit('message_get', {
                                "user_id": otherid,
                                "other_id": '<?php echo $current_id; ?>',
                                "other_name": '<?php echo $current_user->first_name; ?>',
                                "photo": '',
                                "text": message,
                                "file": result.file_path,
                                "file_type": result.file_type,
                                "file_poster": result.poster,
                                "images_base": result.image_base,
                                "video_base": result.video_base,
                                "site_extracted_url": result.site_extracted_url,
                                "site_title": result.site_title,
                                "site_image": result.site_image,
                                "site_content": result.site_content,
                                "site_url": result.site_url
                            });
                        }
                    }
                });
            }
        }

    </script>
    <script>
        var body = $("html, body");
        body.animate({scrollTop: 10000}, 3000, 'swing', function () {
        });
    </script>
    <script type="text/javascript">
        var el = document.querySelector('.more');
        var btn = el.querySelector('.more-btn');
        var menu = el.querySelector('.more-menu');
        var visible = false;

        function showMenu(e) {
            e.preventDefault();
            if (!visible) {
                visible = true;
                el.classList.add('show-more-menu');
                menu.setAttribute('aria-hidden', false);
                document.addEventListener('mousedown', hideMenu, false);
            }
        }

        function hideMenu(e) {
            if (btn.contains(e.target)) {
                return;
            }
            if (visible) {
                visible = false;
                el.classList.remove('show-more-menu');
                menu.setAttribute('aria-hidden', true);
                document.removeEventListener('mousedown', hideMenu);
            }
        }

        btn.addEventListener('click', showMenu, false);
    </script>

</html>