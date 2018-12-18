<!DOCTYPE html>
<html lang="en">
    <?php include('includes/login-register-top.php'); ?>

    <body onLoad="initGeolocation();">

        <div id="wrapper">
            <?php // include('includes/sidebar.php'); ?>
            <div class="login-page">
                <div class="inner-area">
                    <a class="cus-col-form" href="<?php echo asset('/'); ?>">
                        <!--<div>-->
                        <!--<div class="d-table">-->
                        <!--<div class="d-inline">-->
                        <div class="cus-col-logo">
                            <figure>
                                <img src="<?php echo asset('userassets/images/logo.svg') ?>" alt="Logo" />
                            </figure>
                            <span class="com-slogan">The Community for Natural Healing</span>
                        </div>
                        <!--</div>-->
                        <!--</div>--> 
                        <!--</div>-->
                    </a>
                    <div class="cus-col-form">
                        <!--<div class="d-table">-->
                        <!--<div class="d-inline">-->
                        <form method="post" action="<?php echo asset('/'); ?>" id="login_form">
                            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                            <input type="hidden" NAME="lng" ID="lng" VALUE="">
                            <input type="hidden" NAME="lat" ID="lat" VALUE="">
                            <h4>Login</h4>
                            <div class="trans-input">
                                <input required="" type="email" name="email" placeholder="Email" value="<?php echo old('email'); ?>"/>
                                <div class="hb_pass_field">
                                    <input required="" type="password" name="password" placeholder="Password" class="input_pass_field" />
                                    <span class="icon_show_pass"><i class="fa fa-eye"></i></span>
                                </div>
                            </div>
                            <p id="myErrorContainer" class="hb_simple_error_smg"></p>
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
                                <div class="hb_simple_error_smg">
                                    <!--<a href="#" class="close" data-dismiss="alert" aria-label="close">&times</a>-->
                                    <?php echo Session::get('error') ?>
                                </div>
                            <?php } ?>
                            <div class="margin_row">
                                <a href="<?= asset('forget') ?>" class="forgot">Forgot Your Password?</a>
                                <span class="remember">
                                    <input type="checkbox" checked name="remember_me" id="remember_me" class="hidden">
                                    <label for="remember_me" class="keep_signed">Keep me signed in</label>
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
                                <h3 class="member"><a href="<?php echo asset('/'); ?>">Back To Home</a></h3>
                            </div>
                            </fieldset>
                        </form>

                        <!--</div>-->
                        <!--</div>-->
                    </div>
                </div>
            </div>
        </div>

        <?php include('includes/footer-new.php'); ?>
        <script src="     https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/additional-methods.js"></script>
    </body>

    <script type="text/javascript">
        function initGeolocation()
        {
            if (navigator.geolocation)
            {
                // Call getCurrentPosition with success and failure callbacks
                navigator.geolocation.getCurrentPosition(success, fail);
            } else
            {
                alert("Sorry, your browser does not support geolocation services.");
            }
        }

        function success(position)
        {

            document.getElementById('lng').value = position.coords.longitude;
            document.getElementById('lat').value = position.coords.latitude
        }

        function fail()
        {
            // Could not obtain location
        }
        $(document).ready(function () {

            $.validator.setDefaults({
                ignore: [] // DON'T IGNORE PLUGIN HIDDEN SELECTS, CHECKBOXES AND RADIOS!!!
            });

            $("#login_form").validate({
                rules: {
                    email: {
                        required: true,
                        email: true
                    },
                    password: {
                        required: true
                    }
                },
                messages: {
                    email: {
                        required: 'Email is required.',
                        email: 'Email is not valid.'
                    },
                    password: {
                        required: 'Password is required.'
                    },
                },
                showErrors: function (errorMap, errorList) {
                    $("#login_form").find("input").each(function () {
                        $(this).removeClass("error");
                    });
                    $("#myErrorContainer").html("");
                    if (errorList.length) {
                        $("#myErrorContainer").html(errorList[0]['message']);
                        $(errorList[0]['element']).addClass("error");
                    }
                }
            });
        });

    </script> 

    <?php if (isset($_GET['user_id'])) { ?>
        <script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async='async'></script>
        <script>

            OneSignal = window.OneSignal || [];
            OneSignal.push(function () {

                OneSignal.deleteTag("user_id");
            });


        </script>

    <?php } ?>

</html>