<script src="<?php echo url('/'); ?>/adminassets/js/jquery.min.js"></script>
<script src="<?php echo asset('userassets/js/custom.js') ?>"></script>
<script src="<?php echo asset('public/js/share.js') ?>"></script>
<!--<script src="https://wchat.freshchat.com/js/widget.js"></script>-->
<footer>
    <section>
        <div class="ho-foot-left-col">
            <figure>
                <img src="<?php echo asset('userassets/images/home-page-logo.png') ?>" alt="logo" />
            </figure>
            <article>
<!--                <span>123 Main Street, Miami, FL 30000</span>
                <span>888.888.8888</span>-->
                <span class="ho-white">Connect with Us:</span>
                <ul>
                    <li style="margin-right: 5px;">
                        <a href="https://twitter.com/healingbudz?lang=en" target="_new">
                            <img src="<?php echo asset('userassets/images/twitter.png') ?>" alt="icons" />
                        </a>
                    </li>
                    <li style="margin-right: 5px;">
                        <a href="https://www.facebook.com/healingbudz/" target="_new">
                            <img src="<?php echo asset('userassets/images/fb.png') ?>" alt="icons" />
                        </a>
                    </li>
                    <li style="margin-right: 5px;">
                        <a href="https://www.instagram.com/healingbudz/?hl=en" target="_new">
                            <img src="<?php echo asset('userassets/images/insta.png') ?>" alt="icons" />
                        </a>
                    </li>
                    <li style="margin-right: 5px;">
                        <a href="https://www.youtube.com/channel/UCcQUb_JBOCzPItwVA56DNuA?view_as=subscriber" target="_new">
                            <img src="<?php echo asset('userassets/images/you.png') ?>" alt="icons" />
                        </a>
                    </li>
                </ul>
            </article>
        </div>
        <div class="ho-foot-right-col">
            <div class="ho-foot-navi">
                <ul>

                    <li><a href="<?= asset('contact-us') ?>">Contact    </a></li>
                    <li><a href="<?php echo asset('signup-privacy-policy'); ?>">Privacy Policy</a></li>
                    <li><a href="<?php echo asset('signup-terms-conditions'); ?>">Terms of Use</a></li>
                    <li><a href="<?= asset('static-banner') ?>">Commercial Terms of Use</a></li>
                </ul>
                <ul>
                    <li><a href="<?= asset('about-us') ?>">About Us</a></li>
                    <li><a href="<?= asset('careers') ?>">Careers</a></li>
                    <li><a href="<?= asset('home-article-list') ?>">Daily Buzz</a></li>
                    
                </ul>
                <ul>
                    <li><a href="<?= asset('business-services') ?>">Business Services</a></li>
                    <li><a href="<?= asset('business-services') ?>">Advertise on Healing Budz</a></li>
                </ul>
            </div>
            <div class="ho-download">
                <h5 style="margin-top: 0px;">Download the App</h5>
                <div class="ho-dowm-btn">
                    <a href="https://itunes.apple.com/us/app/healing-budz/id1438614769?mt=8"><img src="<?php echo asset('userassets/images/apple.png') ?>" alt="icon" /></a>
                    <a href="https://play.google.com/store/apps/details?id=com.healingbudz.android"><img src="<?php echo asset('userassets/images/android.png') ?>" alt="icon" /></a>
                </div>
            </div>
        </div>
    </section>
    <div class="ho-copy">
        <span>&Copf; <?= date('Y') ?> Healing Budz, All Rights Reserved</span>
    </div>

</footer>
<!--<script>
  window.fcWidget.init({
    token: "968568bc-0b7e-4bb7-b57a-6c8904f2b839",
    host: "https://wchat.freshchat.com"
  });
</script>-->
<?php if (Auth::user()) { ?>

                    <!--<script>
                      // Make sure fcWidget.init is included before setting these values

                      // To set unique user id in your system when it is available
                      window.fcWidget.setExternalId("");

                      // To set user name
                      window.fcWidget.user.setFirstName("");

                      // To set user email
                      window.fcWidget.user.setEmail("");

                      // To set user properties
                      window.fcWidget.user.setProperties({
                        plan: "Estate",                 // meta property 1
                        status: "Active"                // meta property 2
                      });
                    </script>-->
<?php } else { ?>
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

<script>
    function shareInapp(extracted_url, title, image, description) {
//alert('asdasd');
        $('#inAppShare').show();
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
                    if (image) {
                        inc_image = image;
                    }
                    var title = data.title;
                    var content = data.content;
                    var url = data.url;
                    //                    submitSharedPost('', title, content, inc_image, extracted_url, url);
                }
                $('#shareinappimage').attr('src', inc_image);
                $('#shareInAppTitle').html(title);
                $('#shareInDescription').html(content);
                $('#shareInUrl').html(extracted_url);
                $('#in_app_desc').val('');
                $('#in_app_scraped_title').val(title);
                $('#in_app_scraped_content').val(content);
                $('#in_app_scraped_image').val(inc_image);
                $('#in_app_scraped_url').val(extracted_url);
                $('#in_app_site_url').val(url);
                $('#inAppShare').show();
            }
        });
    }

    function submitSharedPost() {
    
        description = $('#in_app_desc').val();
        scraped_title = $('#in_app_scraped_title').val();
        scraped_content = $('#in_app_scraped_content').val();
        scraped_image = $('#in_app_scraped_image').val();
        scraped_url = $('#in_app_scraped_url').val();
        site_url = $('#in_app_site_url').val();
        $('#inAppShare').hide();
//        $(this).parents('html').css('overflow','visible');
//        document.documentElement.style.overflow = "visible";

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
    $('body').on('click', '.artical_class', function (e) {
        $(this).parents('.custom-shares.new-shares').hide();
        $('.popup').hide();
//        id = this.id;
//        $('#share-question-' + id).fadeOut();
    });
</script>

<!--Special Pop ups Alert-->
<!--In app share popup-->
<div id="inAppShare" class="popup inp-pop sho-pop">
    <input type="hidden" id="in_app_desc">
    <input type="hidden" id="in_app_scraped_title">
    <input type="hidden" id="in_app_scraped_content">
    <input type="hidden" id="in_app_scraped_image">
    <input type="hidden" id="in_app_scraped_url">
    <input type="hidden" id="in_app_site_url">
    <div class="popup-holder">
        <div class="popup-area">
            <div class="hb_popup_inner_container">
                <p class="color orange"><strong>Share</strong></p>
                <div class="in_app_share_body">
                    <div class="image">
                        <img id="shareinappimage" src="" alt=""/>
                    </div>
                    <div class="title">
                        <h4 id="shareInAppTitle"></h4>
                    </div>
                    <div class="text_content">
                        <p id="shareInDescription"></p>
                        <a href="#" id="shareInUrl"></a>
                    </div>
                    <div class="in_app_share_btn">
                        <a class="sumbiltsharepost" href="javascript:void(0)" onclick="submitSharedPost()">Share</a>
                    </div>
                </div>
                <a href="#" class="btn-close">x</a>
            </div>
        </div>
    </div>
</div>