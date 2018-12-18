<!DOCTYPE html>
<html lang="en">
    <link href='https://fonts.googleapis.com/css?family=PT+Sans&subset=latin' rel='stylesheet' type='text/css'>
    <link href='<?php echo asset('userassets/css/jquery.mentionsInput.css') ?>' rel='stylesheet' type='text/css'>
    <?php include('includes/top.php'); ?>
    <body>
        <div id="wrapper">
            <?php include('includes/sidebar.php'); ?>
            <article id="content">
                <?php include('includes/header.php'); ?>
                <link rel="stylesheet" href="<?php echo asset('userassets/css/dropzone.css'); ?>">
                <link rel="stylesheet" href="<?php echo asset('userassets/css/custom.css'); ?>">
                <!-- for drop zone -->
                <link rel="stylesheet" href="<?php echo asset('userassets/css/jquery.bxslider.css'); ?>">
                <link rel="stylesheet" href="<?php echo asset('userassets/css/wall.css'); ?>">
                <script src='//cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js' type='text/javascript'></script>
                <div class="padding-div">
                    <div class="new_container">
                        <ul class="bread-crumbs list-none">
                            <li><a href="<?php echo asset('/'); ?>">Home</a></li>
                            <!--<li><a href="<?php // echo asset('questions');         ?>">Q&amp;A</a></li>-->
                            <li>Profile</li>
                        </ul>
                        <div class="profile-area">

                            <?php include 'includes/user-profile-header.php'; ?>
                            <div class="activity-area">
                                <div class="wall-post-single wall-pro" id="user-posts">


                                </div>
                            </div>
                        </div>
                    </div>  <div class="right_sidebars">
                        <?php if ($current_user) {
                            include 'includes/rightsidebar.php'; ?>
    <?php include 'includes/chat-rightsidebar.php';
} ?>
                    </div>
                </div>
            </article>
        </div>
        <?php
        $filters = '';
        if (isset($_GET['sorting'])) {
            $filters = $_GET['sorting'];
        }
        ?>
<?php include('includes/footer.php'); ?>
<?php include('includes/functions.php'); ?>
        <script src="<?php echo asset('userassets/js/dropzone.js'); ?>"></script>
        <script src="<?php echo asset('userassets/js/image-dropzone-config.js'); ?>"></script>
        <script src="<?php echo asset('userassets/js/video-dropzone-config.js'); ?>"></script>
        <script src='<?php echo asset('userassets/js/jquery.events.input.js') ?>' type='text/javascript'></script>
        <script src='<?php echo asset('userassets/js/jquery.elastic.js') ?>' type='text/javascript'></script>
        <script src='<?php echo asset('userassets/js/jquery.mentionsInput.js') ?>' type='text/javascript'></script>
        <script src='<?php echo asset('userassets/js/jquery.bxslider.min.js') ?>' type='text/javascript'></script>
    </body>
    <script>
        $(document).ready(function () {

            $('.scroller').scroll(function (e) {
                $('.scroller').scrollTop(e.target.scrollTop);
            });
        });

        var char_div = $('.wall-post-single-head');
        char_div.text(char_div.text().substring(0, 40));
        $('.wall-read-more').click(function (e) {
            alert();
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


//        $("input[type=file]").bind('change', handleFileSelect);



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
            var_likes_popup = '';
<?php if ($current_user) { ?>
                var_likes_popup = '<li id="hide_likes_liksiting_' + post_id + current_id + '"><div class="img-holder pre-main-image"><span class="hb_round_img hb_bg_img" style="width:35px; height: 35px; display: block; background-image: url(<?php echo $current_photo ?>)"></span><span class="fest-pre-img" style="background-image: url(<?php echo $current_special_icon_user ?>);"></span>' +
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
            $(param).parents('.wall-post-single-in-head-opt-area').find('.wall-post-opt-toggle').toggle();
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
                         $('#delete_post-'+post_id).hide();
//                                                            
                    } else {
                        alert('Error.');
                    }
                }
            });
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
            filters = '<?= $filters ?>';
            var loader = '<div class="loader" id="loaderposts" ><img src="<?php echo asset('userassets/images/edit_post_loader.svg') ?>"></div>';
            $('#user-posts').append(loader);
            $.ajax({
                type: "GET",
                url: "<?php echo asset('get-user-profile-posts/' . $user->id); ?>",
                data: {skip: skip, take: take, filters: filters},
                success: function (response) {
                    $('#loaderposts').remove();
                    if (response) {
                      $("#user-posts").css("display", "block");
                        $('#user-posts').append(response);
                        addTags();
                        $('.js-example-basic-multiple').select2();
                        ajaxcall = 1;
                        var a = parseInt(1);
                        var b = parseInt(count);
                        count = b + a;
                        return true;
                    } else {

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
            getUrl.keyup(function () { //user types url in text field       
                //url to match in the text field
                var match_url = /\b(https?):\/\/([\-A-Z0-9.]+)(\/[\-A-Z0-9+&@#\/%=~_|!:,.;]*)?(\?[A-Z0-9+&@#\/%=~_|!:,.;]*)?/i;
                //continue if matched url is found in text field
                if (match_url.test(getUrl.val())) {
                    $('#post_loader').show();//show loading indicator image
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
                                    img = '<img src="' + inc_image + '" alt="Image" class="img-responsive">';
                                } else {
                                    img = '';
                                }

                                var content = img + '<div class="quick_show quick_show_post">\
                    <div class="quick_show_preview"><button class="quick_remove"><i class="fa fa-times"\ aria-hidden="true"></i></button><a href="' + extracted_url + '" target="_blank"><div id="extracted_thumb" class="quick_pic_review extracted_thumb" style="background-image:url(' + inc_image + '); background-size:cover; background-position:center;"></div><div class="quick_content"><a href="' + extracted_url + '">' + data.title + '</a></div><div class="quick_content">' + data.content + '</div><div class="quick_content"><a href="' + data.url + '">' + data.url + '</a></div></div></a>\
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

        var ajax_post_comment = 0;
        function postComment(e, obj, post_id) {
            if (e.keyCode === 13) {
                if (ajax_post_comment == 0) {
                    ajax_post_comment = 1;
                    var comment = $(obj).val().trim();
                    //empty comment area
                    $(obj).val('');
                    $(obj).parents('.mentions-input-box').find('.mentions').find('div').html('');
                    var description_data = '';
                    $('input.comments-mention').mentionsInput('getMentions', function (data) {
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
                                setTimeout(function () {
                                    ajax_post_comment = 0;
                                }, 700);
                                if (response) {
                                    $('.wall-comments-area-' + post_id).prepend(response);
                                    $(obj).val('');
                                    comment_count = parseInt(comment_count) + 1;
                                    $('#comments-count-' + post_id).text(comment_count);

                                    //clear attachments
                                    var objDZ = Dropzone.forElement(".comment_image_dropzone_" + post_id);
                                    objDZ.emit("resetFiles");
                                    var objDZ = Dropzone.forElement(".comment_video_dropzone_" + post_id);
                                    objDZ.emit("resetFiles");
                                    $('.delete_preview_' + post_id).remove();
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
                                    ajax_post_comment = 0;
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
                }
            }
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
                            //  $("#user-posts").css("display", "block");
                            $('.wall-comments-area-' + post_id).append(response);

                            $("#skip-comments-" + post_id).val(parseInt(skip) + parseInt(take));
                            var proceed = (parseInt(total_comments)) - (parseInt(skip) + parseInt(take));
                            if (proceed <= 0) {
                                $("#see-more-comments-" + post_id).css("display", "none");
                            }
                        } else {
                            noposts = ' <div class="loader" id="nomoreposts">No More Comments To Show</div> ';
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
        function showRepostError() {
            $('#showError').html('You can not repost you own post').show().fadeOut(5000);
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
        function getBudzImage(logo) {
            if (!logo) {
                return '<?= asset('userassets/images/budz-adz-thumbnail.svg') ?>';
            } else {
                return '<?= asset('public/images') ?>' + logo;
            }
        }
    </script>
</html>