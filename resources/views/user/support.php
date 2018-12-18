<!DOCTYPE html>
<html lang="en">
    <?php include('includes/top.php'); ?>
    <body>
        <div id="wrapper">
            <?php include('includes/sidebar.php'); ?>
            <article id="content">
                <?php include('includes/header.php'); ?>
                <div class="padding-div">
                    <div class="new_container">
                        <ul class="bread-crumbs list-none">
                            <li><a href="<?php echo asset('/'); ?>">Home</a></li>
                            <li>Help &amp; Support</li>
                        </ul>

                        <div class="groups add">
                            <header class="intro-header no-bg">
                                <h1 class="custom-heading white">Help &amp; Support</h1>
                            </header>
                            <div class="support-holder">
                                <?php if (Session::has('success')) { ?>
                                    <h5 class="hb_simple_error_smg hb_text_green"> <i class="fa fa-check" style="margin-right: 3px"></i><?php echo Session::get('success'); ?></h5>
                                <?php } if ($current_user) { ?>
                                    <div class="support-contact">
                                        <div class="support-widget">
                                            <div class="text">
                                                <h3>Hi Bud, Need Support ?</h3>

                                                <p>We're always here to help. Please supply as much info as you can and someone will email you back in a jiffy.</p>

                                                <form action="<?php echo asset('support-message'); ?>" class="support-form" method="post">
                                                    <fieldset>
                                                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                                        <select name="option" required="">
                                                            <option value="" disabled selected>Select One Option</option>
                                                            <option  value="u_<?= $current_id ?>"><?= $current_user->first_name ?></option>
                                                            <?php foreach ($current_user->subUser as $subuser) {
                                                                if ($subuser->title != '') {
                                                                    ?>
                                                                    <option value="s_<?= $subuser->id ?>"><?= $subuser->title ?></option>
        <?php }
    } ?>
                                                        </select>
                                                        <textarea required="" placeholder="Enter Message..." name="message"></textarea>
                                                        <input type="submit" value="Submit" class="btn-submit">
                                                    </fieldset>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
<?php } ?>
                                <div class="feedback_support">
                                    <div class="left_bg"></div>
                                    <div class="support-widget">
                                        <div class="text">
                                            <h3>Download </h3>
                                            <h5>Our App Today!</h5>

                                            <div class="apps_imgs">
                                                <a href="https://itunes.apple.com/us/app/healing-budz/id1438614769?mt=8"><img src="<?php echo asset('userassets/images/app-store.png'); ?>" height="70" width="230" ></a>
                                                <a href="https://play.google.com/store/apps/details?id=com.healingbudz.android"><img src="<?php echo asset('userassets/images/android.png'); ?>" height="70" width="230" ></a>
                                            </div>
                                            <!--     <div class="follow">
                                                    <strong>Follow us on:</strong>
                                                    <ul class="list-none custom_socials">
                                                        <li><a href="#">Facebook</a></li>
                                                        <li class="twitter"><a href="#">Twitter</a></li>
                                                        <li class="instagram"><a href="#">Instagram</a></li>
                                                        <li class="google-plus"><a href="#">Google Plus</a></li>
                                                    </ul>
                                                </div> -->
                                           <!--      <form action="<?= asset('send-invitation-mail') ?>" class="invite-friend-form" method="post">
                                                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                                    <fieldset>
                                                        <div class="invite-friend">
                                                            <strong>Invite Friends</strong>
                                                            <p>Invite via email address</p>
                                                            <input name="email" required="" type="email">
                                                            <span class="error_span"><?php if ($errors->has('email')) {
    echo $errors->first('email');
} ?></span>
                                                        </div>
                                                        <div class="invite-friend">
                <!--                                            <span class="or-txt">or</span>
                                                            <strong>Invite via text message</strong>
                                                            <p>Add Phone Number Below</p>
                                                            <input type="email">-->
                                                   <!--          <input type="submit" value="Invite New Bud" class="btn-submit"> -->
                                        </div>
                                        </fieldset>
                                        </form> 
                                    </div>
                                </div>
                            </div>
                            <div class="support-widget invitations">
                                <div class="text">
                                    <form action="<?= asset('send-invitation-mail') ?>" class="invite-friend-form" method="post">
                                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                        <fieldset>
                                            <div class="invite-friend">
                                                <strong>INVITE FRIENDS</strong>
                                                <input name="email" id="scroll-to-field" type="email" required="" placeholder=" Invite via email address">
                                                <label for="youridhere" class="static-icon"></label>
                                                <div class="input-group-addon-left">
                                                    <?php if (Auth::user()) { ?>
                                                        <input  class="btn-submit" type="submit" placeholder="  Invite">
<?php } else { ?>
                                                        <a href="#loginModal" class="btn-submit new_popup_opener"  placeholder="  ">Submit</a>       
<?php } ?>
                                                </div>
                                        <!-- <input name="text_msg" required="" type="text" placeholder="Invite via Text Message">
                                                 <label for="youridhere" class="static-icons"></label>
                                                <div class="input-group-addon">
                                                <button class="invite_text" type="submit">  Invite</button>
                                                </div> -->
                                        <!--         <span class="error_span"><?php if ($errors->has('email')) {
    echo $errors->first('email');
} ?></span>-->
                                            </div>
                                            <!--  <div class="invite-friend">
                                                      <span class="or-txt">or</span>
                                                      <strong>Invite via text message</strong>
                                                      <p>Add Phone Number Below</p>
                                                      <input type="email">
                                                      <input type="submit" value="Invite New Bud" class="btn-submit">
                                                  </div> -->
                                        </fieldset>
                                    </form>
                                </div>
                            </div>
                            <div class="support-widget rights">
                                <div class="text">
                                    <ul class="terms-list list-none">
                                        <li><a href="<?php echo asset('signup-privacy-policy'); ?>" target="_blank">Privacy Policy</a></li>
                                        <li><a href="<?php echo asset('signup-terms-conditions'); ?>" target="_blank">Terms &amp; Conditions</a></li>

                                    </ul>

                                    <em class="version">Version 1.0.17</em>
                                    <p>Copyright Healing Budz, Inc <?= date('Y') ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="right_sidebars">
<?php if ($current_user) {
    include 'includes/rightsidebar.php'; ?>
    <?php include 'includes/chat-rightsidebar.php';
} ?>
                    </div>
                </div>

        </div>
    </article>
</div>
<?php include('includes/footer.php'); ?>
</body>
</html>
<?php if (isset($scroll) && $scroll) { ?>
    <script>
        $('html, body').animate({scrollTop: $("#scroll-to-field").offset().top}, 500);
        $("#scroll-to-field").focus();
    </script>
<?php } ?>

