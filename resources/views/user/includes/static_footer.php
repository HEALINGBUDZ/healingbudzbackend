<script src="<?php echo url('/');?>/adminassets/js/jquery.min.js"></script>
<script src="<?php echo asset('userassets/js/custom.js') ?>" type="text/javascript">
</script>
<!--<script src="https://wchat.freshchat.com/js/widget.js"></script>-->
<footer>
        <section>
            <div class="ho-foot-left-col">
                <figure>
                    <img src="<?php echo asset('userassets/images/home-page-logo.png') ?>" alt="logo" />
                </figure>
                <article>
<!--                    <span>123 Main Street, Miami, FL 30000</span>
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

                        <li><a href="<?= asset('contact-us')?>">Contact</a></li>
                        <li><a href="<?php echo asset('signup-privacy-policy'); ?>">Privacy Policy</a></li>
                        <li><a href="<?php echo asset('signup-terms-conditions'); ?>">Terms of Use</a></li>
                        <li><a href="<?= asset('static-banner')?>">Commercial Terms of Use</a></li>
                    </ul>
                    <ul>
                        <li><a href="<?= asset('about-us')?>">About Us</a></li>
                        <li><a href="<?= asset('careers')?>">Careers</a></li>
                        <li><a href="<?= asset('home-article-list')?>">Daily Buzz</a></li>                        
                    </ul>
                    <ul>
                        <li><a href="<?= asset('business-services')?>">Business Services</a></li>
                        <li><a href="<?= asset('business-services')?>">Advertise on Healing Budz</a></li>
                    </ul>
                </div>
                <div class="ho-download">
                    <h5>Download the App</h5>
                    <div class="ho-dowm-btn">
                        <a href="https://itunes.apple.com/us/app/healing-budz/id1438614769?mt=8"><img src="<?php echo asset('userassets/images/apple.png') ?>" alt="icon" /></a>
                        <a href="https://play.google.com/store/apps/details?id=com.healingbudz.android"><img src="<?php echo asset('userassets/images/android.png') ?>" alt="icon" /></a>
                    </div>
                </div>
            </div>
        </section>
        <div class="ho-copy">
            <span>&Copf; <?= date('Y')?> Healing Budz, All Rights Reserved</span>
        </div>
    </footer>
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
<!--    <script>
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