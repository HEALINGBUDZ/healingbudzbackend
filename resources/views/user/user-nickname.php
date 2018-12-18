<!DOCTYPE html>
<html lang="en">
    <?php include('includes/login-register-top.php'); ?>
    <body>
        <div id="wrapper">
            <div class="login-page">
                <div class="inner-area">
                    <!--<a href="<?php echo asset('/'); ?>">-->
                    <div class="cus-col-form">
                        <div class="d-table">
                            <div class="d-inline">
                                <div class="cus-col-logo">
                                    <figure>
                                        <img src="<?php echo asset('userassets/images/logo.svg') ?>" alt="Logo" />
                                    </figure>
                                    <span class="com-slogan">The Community for Natural Healing</span>
                                </div>
                            </div>
                        </div> 
                    </div>
                    <!--</a>-->
                    <div class="cus-col-form">
                        <div class="d-table">
                            <div class="d-inline">
                                <form method="post" action="<?php echo asset('/update_username'); ?>" id="nickname">
                                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                    <h4>Choose a Nickname</h4>
                                    <div class="trans-input">
                                        <input maxlength="20" type="text" name="nick_name" placeholder="Enter Nickname" value="<?php echo old('nick_name'); ?>"/>
                                        <input type="text" name="zip_code" placeholder="Enter Zip code" value="<?php echo old('zip_code'); ?>"/>
                                    </div>
                                    <span class="error_span" id="question_error"><?php
                                        if ($errors->has('nick_name')) {
                                            echo $errors->first('nick_name');
                                        }
                                        ?></span>
                                        <?php if (Session::has('error')) { ?>
                                        <div class="alert alert-danger">
                                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times</a>
                                        <?php echo Session::get('error') ?>
                                        </div>
<?php } ?>
                                    <div class="submit-area">
                                        <div class="misc_holder">
                                            <input type="submit" value="Continue">
                                            <!--<span class="or"><em>OR</em></span>-->
                                        </div>

                                        
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<?php include('includes/footer-new.php'); ?>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/additional-methods.js"></script>
    </body>
    <script>
        $(document).ready(function () {

            $("#nickname").validate({
                rules: {
                    nick_name: {
                        required: true
                    },
                    zip_code: {
                        required: true
                    }
                },
                messages: {
                    nick_name: {
                        required: ""
                    },
                    zip_code: {
                        required: ""
                    }
                }
            });
        });
    </script>
</html>