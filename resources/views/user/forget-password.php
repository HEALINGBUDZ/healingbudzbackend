<!DOCTYPE html>
<html lang="en">
    <?php include('includes/login-register-top.php'); ?>
    <body onLoad="initGeolocation();">
        <div id="wrapper">
            <?php // include('includes/sidebar.php'); ?>
            <div class="login-page">
                <div class="inner-area">
                    <a class="cus-col-form" href="<?php echo asset('/');?>">
                        <div>
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
                        </div>
                    </a>
                    <div class="cus-col-form">
                    <!--<div class="d-table">-->
                        <!--<div class="d-inline">-->
                            <div class="cus-col-logo forget_wrapper">
                                <h2 class="forgot_pass">Forget Password</h2>
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
                            if (Session::has('error')) { ?>
                                <div class="alert alert-danger">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times</a>
                                    <?php echo Session::get('error') ?>
                                </div>
                                <?php } if (Session::has('success')) { ?>
                                    <div class="alert alert-success">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times</a>
                                        <?php echo Session::get('success') ?>
                                    </div>
                                <?php } ?>
                                        <form method="post" action="<?php echo asset('/forget'); ?>" id="forget_password">
                                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                    <fieldset class="trans-input">
                                        <input type="email" name="email" placeholder="Email" />
                                    </fieldset>
                                    <fieldset class="submit-area">
                                        <input type="submit" value="RESET PASSWORD" />
                                    </fieldset>
                                </form>
                            </div>
                        <!--</div>-->
                    <!--</div>-->
                </div>
            </div>
        </div>
        <?php include('includes/footer-new.php'); ?>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/additional-methods.js"></script>
    </body>

    <script type="text/javascript">
        $(document).ready(function() {

            $("#forget_password").validate({
                rules: {
                    email: {
                        required: true,
                        email: true
                    }
                },
                 messages: {
                     email: {
                         required: "Please provide an Email",
                         email: "Please provide a correct email"
                     }
                }
            });
        });
        
        
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

    </script> 
</html>