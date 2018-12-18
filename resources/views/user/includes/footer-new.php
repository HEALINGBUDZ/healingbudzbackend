<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>-->
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="<?php echo asset('userassets/js/switchery.min.js') ?>" type="text/javascript"></script>
<script src="<?php echo asset('userassets/js/stars.min.js') ?>" type="text/javascript"></script>
<script src="<?php echo asset('userassets/js/jquery.star-rating-svg.js') ?>" type="text/javascript"></script>
<script src="https://netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script> 
<!--<script src="https://cdn.jsdelivr.net/npm/bxslider@4.2.13/dist/jquery.bxslider.min.js"></script>-->
<script src="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.min.js"></script>
<script src="<?php echo asset('userassets/js/chosen.js') ?>"></script>
<script src="<?php echo asset('userassets/js/custom.js') ?>" type="text/javascript"></script>
<script src="<?php echo asset('userassets/js/scroll.js') ?>" type="text/javascript"></script>
<script src="<?php echo asset('userassets/js/jquery.fancybox.min.js') ?>" type="text/javascript"></script>
<script src="<?php echo asset('public/js/share.js') ?>"></script>
<!--<script src="https://wchat.freshchat.com/js/widget.js"></script>-->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.16.0/moment.min.js"></script>
<script>

    $("[data-fancybox]").fancybox({
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
        }
    });
    $(function () {
        $("#slider").slider();
    });
    $(document).ready(function () {
        $('.header-strain-slider').bxSlider({
            auto: true,
            touchEnabled: false,
            swipeThreshold: false

        });
    });
    $(document).ready(function () {
        var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
        elems.forEach(function (html) {
            var switchery = new Switchery(html, {color: '#932a88', secondaryColor: '#6e6e6e', jackColor: '#fff'});
        });

    });
</script>
<script>
    $(".rating-stars").stars({color: '#e070e0',
        click: function (i) {
            alert("Star " + i + " selected.");
        }});
    $(document).on('click', '.keyword_class', function (e) {
        e.preventDefault();
//        var baseUrl = window.location.protocol + "//" + window.location.host + "/<?php echo env('PROJECT_FOLDER'); ?>/";
        var baseUrl = '<?= asset('/') ?>';
        var string_tag = $(this).html();
        var new_tag_String = string_tag.replace('#', '');
        $.ajax({
            type: "GET",
            url: "<?php echo asset('check-keyword-following'); ?>",
            data: {
                "string_tag": string_tag
            },
            success: function (data) {
                if (data.success) {
                    $('#follow_keyword').hide();
                    $('#un_follow_keyword').show();
                    $('#un_follow_keyword').attr('onclick', 'removeTag(' + data.id + ')');
                } else {
                    $('#un_follow_keyword').hide();
                    $('#follow_keyword').show();
                    $('#follow_keyword').attr('onclick', 'addTag(' + data.id + ')');
                }
            }
        });
        $('#show_keyword').html(new_tag_String);

        $('.keyword_url_q').attr('href', baseUrl + 'search-keyword?q=' + new_tag_String + '&type=q&filter=Q+%26amp%3B+A');
        $('.keyword_url_a').attr('href', baseUrl + 'search-keyword?q=' + new_tag_String + '&type=a&filter=Q+%26amp%3B+A');
        $('.keyword_url_g').attr('href', baseUrl + 'search-keyword?q=' + new_tag_String + '&type=g');
        $('.keyword_url_j').attr('href', baseUrl + 'search-keyword?q=' + new_tag_String + '&type=j');
        $('.keyword_url_s').attr('href', baseUrl + 'search-keyword?q=' + new_tag_String + '&type=s&filter=Strain');
        $('.keyword_url_b').attr('href', baseUrl + 'search-keyword?q=' + new_tag_String + '&type=&filter=BUDZ ADZ');
//        $('#follow_keyword').attr('href', baseUrl + 'follow-keyword?q=' + new_tag_String);
        $('#surveyabc').css('display', 'block');
    });

    function removeTag(id) {
        $.ajax({
            type: "GET",
            url: "<?php echo asset('remove-add-tag'); ?>",
            data: {
                "id": id
            },
            success: function (data) {
//                $('#showfollowsuccess').show().html("Keyword Unfollowed Successfully").fadeOut(3000);
                $('#un_follow_keyword').hide();
                $('#follow_keyword').show();
                $('#follow_keyword').attr('onclick', 'addTag(' + id + ')');
            }

        });
    }
    function addTag(id) {
        $.ajax({
            type: "GET",
            url: "<?php echo asset('add-tag'); ?>",
            data: {
                "id": id
            },
            success: function (data) {
//                $('#showfollowsuccess').show().html("Keyword Followed Successfully").fadeOut(3000);
                $('#follow_keyword').hide();
                $('#un_follow_keyword').show();
                $('#un_follow_keyword').attr('onclick', 'removeTag(' + id + ')');
            }

        });
    }

    function followSuggestion(other_id) {
        $('#suggested_user_' + other_id).hide();
        $.ajax({
            type: "GET",
            url: "<?php echo asset('follow'); ?>",
            data: {
                "other_id": other_id
            },
            success: function (data) {
            }
        });
    }

</script>
<!--<script>
    window.fcWidget.init({
        token: "968568bc-0b7e-4bb7-b57a-6c8904f2b839",
        host: "https://wchat.freshchat.com"
    });
</script>-->
<?php if(Auth::user()){ ?>

<!--<script>
  // Make sure fcWidget.init is included before setting these values

  // To set unique user id in your system when it is available
  window.fcWidget.setExternalId("<?= Auth::user()->id?>");

  // To set user name
  window.fcWidget.user.setFirstName("<?= Auth::user()->first_name?>");

  // To set user email
  window.fcWidget.user.setEmail("<?= Auth::user()->email?>");

  // To set user properties
  window.fcWidget.user.setProperties({
    plan: "Estate",                 // meta property 1
    status: "Active"                // meta property 2
  });
</script>-->
<?php }else{ ?>
<!--<script>
  // Make sure fcWidget.init is included before setting these values

  // To set unique user id in your system when it is available
  window.fcWidget.setExternalId("anonymous");

  // To set user name
  window.fcWidget.user.setFirstName("anonymous");

  // To set user email
  window.fcWidget.user.setEmail("anonymous@anonymous.com");

  // To set user properties
  window.fcWidget.user.setProperties({
    plan: "Estate",                 // meta property 1
    status: "Active"                // meta property 2
  });
</script>-->
<?php } ?>
<div id="surveyabc" class="popup key-pop">
    <div class="popup-holder">
        <div class="popup-area">
            <div class="text">
                <!--<img src="<?php // echo asset('userassets/images/icon-eye.png')           ?>" alt="Icon" class="eye-img">-->
                <header class="header top_padding">
                    <span>Show activity for keyword</span>
                    <span class="alert alert-success" id="showfollowsuccess" style="display: none"></span>
                    <strong id="show_keyword" class="hightlight"></strong>
                    <span class="lo-span">Look activity in:</span>
                </header>
                <div class="txt">
                    <ul class="list-none pop_features">
                        <!--<li><a class="keyword_url_q">Questions</a></li>-->
                        <!--<li><a class="keyword_url_a">Answers</a></li>-->
                        <!--<li><a class="keyword_url_g">Groups</a></li>-->
                        <!--<li><a class="keyword_url_j">Journals</a></li>-->
                        <!--<li><a class="keyword_url_s">Strains</a></li>-->

                        <li><a class="keyword_url_q"><img src="<?php echo asset('userassets/images/ques-img-text.png') ?>" alt="Icon" ></a></li>
                        <li><a class="keyword_url_a"><img src="<?php echo asset('userassets/images/ans-img-text.png') ?>" alt="Icon" ></a></li>
                        <li><a class="keyword_url_s"><img src="<?php echo asset('userassets/images/strain-img-text.png') ?>" alt="Icon" ></a></li>
                        <li><a class="keyword_url_b"><img src="<?php echo asset('userassets/images/budz-img-text.png') ?>" alt="Icon" ></a></li>

                        <!--<li><a class="keyword_url_b">Budz Adz</a></li>-->
                    </ul>
                    <a href="javascript:void(0)" style="display: none" id="follow_keyword" class="btn-primary green">Follow this Keyword</a>
                    <a href="javascript:void(0)" style="display: none" id="un_follow_keyword" class="btn-primary green">Unfollow this Keyword</a>
                </div>
                <a href="#" class="btn-close"></a>
            </div>
        </div>
    </div>
</div>

<script>
    $('.log_out').click(function (evt) {
        OneSignal = window.OneSignal || [];
        OneSignal.push(function () {
            OneSignal.deleteTags(["user_id"]);
            window.location.href = '<?php echo asset('userlogout'); ?>';
        });
    });

    $(function () {
        //$( "#datepicker" ).datepicker();
        $("#datepicker").datepicker({
            dateFormat: "MM dd, yy",
            showOtherMonths: true,
            selectOtherMonths: true,
            onSelect: function () {
                var selectedDate = $.datepicker.formatDate("M yy", $(this).datepicker('getDate'));
                //alert(date);
                $("#month").text(selectedDate);
            }
        });

    });
    $(function () {
        $("div#calendar-area").datepicker();
    });
    $(function () {
        $("#popup-datepicker").datepicker();
    });
    $(function () {
        $(".popup-datepicker").datepicker({
            minDate: 0
        });
    });
    function shareInapp(extracted_url, title, image, description) {
        $.ajax({
            url: "<?php echo asset('scrape-url') ?>",
            data: {'url': extracted_url},
            type: "POST",

            success: function (responseData) {
                if (responseData[0] == false) {
                    var inc_image = image;
                    var data = JSON.parse(responseData);
                    var title = title;
                    var content = description;
                    var url = extracted_url;
//                    submitSharedPost('', title, content, inc_image, extracted_url, url);
                } else {

                    var data = JSON.parse(responseData);
                    inc_image = image;
                    if (data.images[0]) {
                        inc_image = data.images[0];
                    }
                    var title = data.title;
                    var content = data.content;
                    var url = data.url;
//                    submitSharedPost('', title, content, inc_image, extracted_url, url);
                }
            }
        });
    }

    function submitSharedPost(description, scraped_title, scraped_content, scraped_image, scraped_url, site_url) {

        var description_data = '';
        var post_description = description;
        var repost_to_wall = 1;
        var posting_user = '';
        var tagged_users = '';
        var images = '';
        var video = '';
        $.ajax({
            type: "POST",
            url: "<?php echo asset('add_shared_url_post'); ?>",
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
                _token: '<?= csrf_token() ?>'
            },
            success: function (response) {
                $('#shareInApp').fadeIn().fadeOut(5000);
            }
        });


    }
</script>
<!--Special Pop ups Alert-->
<div id="erroralert" class="popup alert">
    <div class="popup-holder">
        <div class="popup-area">
            <div class="text">
                <header class="header">
                    <span>Alert</span>
                    <strong><img src="<?php echo asset('userassets/images/error.svg') ?>" alt="Alert" /><span id="erroralertmessage"></span></strong>
                </header>
                <div class="txt">
                    <a href="#" class="btn-primary btn-close">Ok</a>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="" class="popup success">
    <div class="popup-holder">
        <div class="popup-area">
            <div class="text">
                <header class="header">
                    <span>Alert</span>
                    <strong><img src="<?php echo asset('userassets/images/successfully.svg') ?>" alt="Alert" />Your edit accepted and successfully submitted</strong>
                </header>
                <div class="txt">
                    <a href="#" class="btn-primary btn-close">Done</a>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="loginModal" class="login-modal home-pg-login">
    <!-- Modal content -->
    <div class="login-content">
        <span class="close" onclick="closModal('loginModal')" >&times;</span>
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
<!--Special Pop ups Alert-->