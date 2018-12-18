<!DOCTYPE html>
<html lang="en">
    <?php include('includes/login-register-top.php'); ?>
    <body>
        <div id="wrapper">
            <?php // include('includes/sidebar.php'); ?>
            <div class="sign-page">
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

                        <form action="register" method="post" enctype="multipart/form-data" id="register">
                            <fieldset class="trans-input">
                                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                <input type="hidden" name="lng" id="lng" value="">
                                <input type="hidden" name="lat" id="lat" value="">
                                <h4>Signup</h4>
                                <div class="form_cols">
                                    <div class="form_cols_col fluid">
                                        <input type="email" name="email" value="<?php echo old('email'); ?>" placeholder="*Email" id="email">
                                        <span class="error validation"><?php
                                            if ($errors->has('email')) {
                                                echo $errors->first('email');
                                            }
                                            ?></span>
                                    </div>
                                </div>
                                <div class="form_cols">                                    
                                    <div class="form_cols_col">
                                        <div class="hb_pass_field">
                                            <input type="password" name="password" value="<?php echo old('password'); ?>" id="password" placeholder="*Password" class="input_pass_field">
                                            <span class="icon_show_pass"><i class="fa fa-eye"></i></span>
                                        </div>
                                        <span class="error validation"><?php
                                            if ($errors->has('password')) {
                                                echo $errors->first('password');
                                            }
                                            ?></span>
                                    </div>
                                    <div class="form_cols_col">
                                        <div class="hb_pass_field">
                                            <input type="password" name="confirm_password" placeholder="*Confirm Password" class="input_pass_field">
                                            <span class="icon_show_pass"><i class="fa fa-eye"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset class="trans-input">
                                <div class="form_cols">
                                    <div class="form_cols_col fluid">
                                        <input type="text" name="user_name" maxlength="20" value="<?php echo old('user_name'); ?>" placeholder="*Enter a nickname">
                                        <span class="error validation"><?php
                                            if ($errors->has('user_name')) {
                                                echo $errors->first('user_name');
                                            }
                                            ?></span>
                                    </div>
                            </fieldset>
                            <fieldset class="trans-input">
                                <div class="form_cols">
                                    <div class="form_cols_col">
                                        <input type="text" name="zip_code" value="<?php echo old('zip_code'); ?>" placeholder="*Enter your Zipcode">
                                        <span class="error validation"><?php
                                            if ($errors->has('zip_code')) {
                                                echo $errors->first('zip_code');
                                            }
                                            ?></span>
                                    </div>
                                    <div class="form_cols_col">
                                        <input type="text" name="city" value="<?php echo old('city'); ?>" placeholder="*Enter city name" />
                                        <span class="error validation"><?php
                                            if ($errors->has('city')) {
                                                echo $errors->first('city');
                                            }
                                            ?></span>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset class="trans-input">
                                <div class="form_cols">
                                    <div class="form_cols_col fluid">
                                        <select name="state" >
                                            <option value="">*Select state name</option>
                                            <?php foreach ($states as $state) { ?>
                                                <option value="<?= $state->id; ?>" <?php
                                                if (old('state') == $state->id) {
                                                    echo 'selected';
                                                }
                                                ?>><?= $state->state; ?></option>
                                                    <?php } ?>
                                        </select>
                                        <span class="error validation"><?php
                                            if ($errors->has('state')) {
                                                echo $errors->first('state');
                                            }
                                            ?></span>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset class="img-section">
                                <div class="signup_img">
                                    <fieldset class="upload-or">
                                        <label for="login-new">
                                            <div id="pic_pro" style="background-image: url(<?php echo asset('userassets/images/green-user.png'); ?>)"></div>
<!--                                            <img id="pic_pro" src="<?php echo asset('userassets/images/green-user.png') ?>" alt="icon">-->
                                            <input type="file" name="pic" id="login-new" class="hidden" onchange="readURL(this);" accept="image/*"/>
                                            <span>Upload a profile photo</span>
                                        </label>
                                    </fieldset>
                                </div>
                                <div class="images-set">
                                    <?php foreach ($user_icons as $user_icon) { ?>
                                        <label for="icon5"><img src="<?php echo asset('public/images' . $user_icon->name) ?>" alt="<?php echo $user_icon->name; ?>" /></label>
                                        <input type="radio" id="icon5" name="" value="<?= $user_icon->name; ?>" class="hidden" />
                                    <?php } ?>
                                    <input type="hidden" id="avatar" name="avatar" value="">
                                    <span class="error validation"><?php
                                        if ($errors->has('avatar')) {
                                            echo $errors->first('avatar');
                                        }
                                        ?></span>
                                </div>
                            </fieldset>
                            <fieldset class="img-section" id="special_icons" style="display: none;">
                                <div class="signup_img">
                                    <img id="icon_pro" src="<?php echo asset('userassets/images/ch.png') ?>" alt="icon">
                                    <fieldset class="upload-or">
                                        <label for="login-new1">
                                            <input type="file" name="special_icon" id="login-new1" class="hidden" onchange="readURL1(this);"/>
                                            <span>Profile Icon</span>
                                            <p>Set by event</p>
                                        </label>
                                    </fieldset>
                                </div>
                                <div class="images-set1">
                                    <div id="after_added_icon">
                                        <?php foreach ($special_icons as $special_icon) { ?>
                                            <label for="icon8"><img src="<?php echo asset('public/images' . $special_icon->name) ?>" alt="<?php echo $special_icon->name; ?>" /></label>
                                            <input type="radio" id="icon8" name="" value="<?= $special_icon->name; ?>" class="hidden" />
                                        <?php } ?>
                                    </div>
                                    <input type="hidden" id="special_icon" name="special_icon" value="">
                                    <span class="error validation"><?php
                                        if ($errors->has('special_icon')) {
                                            echo $errors->first('special_icon');
                                        }
                                        ?></span>
                                </div>
                            </fieldset>
                            <fieldset class="submit-area">
                                <div class="form_cols yes-no-checks">
                                    <div class="form_cols_col">
                                        <span class="remember">
                                            <label for="verify_age">
                                                <input type="checkbox" name="age_verify" id="verify_age" class="hidden">
                                                <span class="rem-lab-chan">I verify I am 21 years of age or older.</span>
                                            </label>
                                        </span>
                                    </div>
                                    <div class="form_cols_col auto">
                                        <span class="text-right">
                                            <?php /* <label for="terms">I agree to the <a href="<?= asset('signup-terms-conditions'); ?>" target="_blank">terms and conditions</a></label> */ ?>
                                            <label for="terms">
                                                <input type="checkbox" name="terms_conditions" value="" id="terms" class="hidden">
                                                <span class="rem-lab-chan">I agree to the 
                                                    <a id="pop_to_close_anchor" href="#terms-pop"  class="btn-popup">terms and conditions</a>
                                                </span>
                                            </label>
                                        </span>
                                    </div>
                                    <!--                                        <div class="form_cols_col">
                                                                                <span class="remember">
                                                                                    <input type="checkbox" name="age_verify" id="verify_age" class="hidden">
                                                                                    <label for="verify_age">verify your Age</label>
                                                                                </span>
                                                                            </div>-->
                                    <!--                                        <div class="form_cols_col auto">
                                                                                <span class="text-right">
                                    <?php /* <label for="terms">I agree to the <a href="<?= asset('signup-terms-conditions'); ?>" target="_blank">terms and conditions</a></label> */ ?>
                                                                                    <input type="checkbox" name="terms_conditions" value="" id="terms" class="hidden">
                                                                                    <label for="terms">I agree to the <a href="#terms-pop" target="_blank" class="btn-popup">terms and conditions</a></label>
                                                                                </span>
                                                                            </div>-->
                                </div>
                                <span id="myErrorContainer" style="color: #a94442 !important;"></span>
                                <div class="misc_holder">
                                    <input type="submit" value="SIGN UP" class="no-margin">
                                </div>
                                <span class="member">Already a Member? <a href="<?php echo asset('/login'); ?>">Log In</a></span>
                                <h3 class="member"><a href="<?php echo asset('/'); ?>">Back To Home</a></h3>
                            </fieldset>
                        </form>
                        <!--</div>-->
                        <!--</div>-->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="terms-pop" class="popup terms-popup">
        <div class="popup-holder">
            <div class="popup-area">
                <div class="text" id="pop_to_close">
                    <article id="pop_to_close_art">
                        <div class="privacy-holder" id="pop_to_close_div">
                            <?php echo $term_coditions->description; ?>
                        </div>
                    </article>
                    <a href="#" class="btn-close"></a>
                </div>
            </div>
        </div>
    </div>

    <?php include('includes/footer-new.php'); ?>
<!--        <script src="<?php //echo asset('userassets/js/jquery.validate.js')       ?>"></script>-->
    <script src="     https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/additional-methods.js"></script>


</body>
<script>
                                                $('.images-set img').click(function () {
                                                    $("#login-new").val('');
//                                                    $('#pic_pro').attr('src', '');
//                                                    $('#pic_pro').attr('src', $(this).attr('src'));
                                                    $('#pic_pro').css({
                                                        backgroundImage: 'url(' + $(this).attr('src') + ')'
                                                    });
                                                    $('#avatar').val($(this).attr('alt'));
                                                });
                                                $(document).on('click', '.images-set1 img', function () {
                                                    $("#login-new1").val('');
                                                    $('#icon_pro').attr('src', '');
                                                    $('#icon_pro').attr('src', $(this).attr('src'));
                                                    $('#special_icon').val($(this).attr('alt'));

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
                                                    document.getElementById('lat').value = position.coords.latitude;
                                                }

                                                function fail()
                                                {
                                                    // Could not obtain location
                                                }


                                                $(document).ready(function () {
                                                    $("#email").focusout(function () {
                                                        var email = $("#email").val();
                                                        $.ajax({
                                                            type: "POST",
                                                            url: "<?php echo asset('check_special_email'); ?>",
                                                            data: {email: email},
                                                            success: function (response) {
                                                                if (response) {
                                                                    if (response != 1) {
                                                                        $('#after_added_icon').append(response);
                                                                    }
                                                                    $('#special_icons').show(200);
                                                                } else {
                                                                    $('#special_icons').hide(200);
                                                                }
                                                            }
                                                        });
                                                    });

                                                    $.validator.setDefaults({
                                                        ignore: [] // DON'T IGNORE PLUGIN HIDDEN SELECTS, CHECKBOXES AND RADIOS!!!
                                                    });

                                                    $("#register").validate({
                                                        rules: {
                                                            email: {
                                                                required: true,
                                                                email: true
                                                            },
                                                            password: {
                                                                required: true
                                                            },
                                                            confirm_password: {
                                                                required: true,
                                                                equalTo: "#password"
                                                            },
                                                            zip_code: {
                                                                required: true,
                                                                zipcodeUS: true
                                                            },
                                                            user_name: {
                                                                required: true
                                                            },
                                                            city: {
                                                                required: true
                                                            },
                                                            state: {
                                                                required: true
                                                            },
                                                            terms_conditions: {
                                                                required: true
                                                            },
                                                            age_verify: {
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
                                                            confirm_password: {
                                                                required: 'Confirm password is required.',
                                                                equalTo: "Password doesn't match."
                                                            },
                                                            zip_code: {
                                                                required: 'Zip code is required.',
                                                                zipcodeUS: 'Zip code is not valid.'
                                                            },
                                                            user_name: {
                                                                required: 'Nickname is required.'
                                                            },
                                                            city: {
                                                                required: 'City is required.'
                                                            },
                                                            state: {
                                                                required: 'State is required'
                                                            },
                                                            terms_conditions: {
                                                                required: 'Terms and conditions are required.'
                                                            },
                                                            age_verify: {
                                                                required: 'Age verification is required.'
                                                            }
                                                        },
                                                        showErrors: function (errorMap, errorList) {
                                                            $("#register").find("input").each(function () {
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
                                                function readURL(input) {
//            $('#pic').show();
                                                    if (input.files && input.files[0]) {
                                                        var file = input.files[0];
                                                        var reader = new FileReader();

                                                        reader.onload = function (e) {
                                                            getOrientation(file, function (orientation) {

                                                                resetOrientation(reader.result, orientation, function (result) {

                                                                    $('#pic_pro').show();
//                                                                    $('#pic_pro').attr('src', '');
//                                                                    $('#pic_pro').attr('src', result);
                                                                    $('#pic_pro').css({
                                                                        backgroundImage: 'url(' + result + ')'
                                                                    });

                                                                });
                                                            });

//                    $('#pic_pro').show(); 
//                    $('#pic_pro').attr('src',''); 
//                    $('#pic_pro').attr('src', e.target.result);
                                                        };

                                                        reader.readAsDataURL(file);
                                                    }
                                                }
                                                function readURL1(input) {
//            $('#pic').show();
                                                    if (input.files && input.files[0]) {
                                                        var reader = new FileReader();

                                                        reader.onload = function (e) {

                                                            $('#icon_pro').show();
                                                            $('#icon_pro').attr('src', '');
                                                            $('#icon_pro').attr('src', e.target.result);
                                                        };

                                                        reader.readAsDataURL(input.files[0]);
                                                    }
                                                }

                                                $("#login-new").change(function () {
                                                    readURL(this);
                                                });
                                                $("#login-new1").change(function () {
                                                    readURL1(this);
                                                });
</script>
<script>
    $('body').click(function (evt) {
        if (evt.target.id == "pop_to_close") {

        } else if (evt.target.id == "pop_to_close_div") {

        } else if (evt.target.id == "pop_to_close_art") {

        } else if (evt.target.id == "pop_to_close_anchor") {

        } else {
            $('#terms-pop').hide();
        }
    })
</script>

</html>