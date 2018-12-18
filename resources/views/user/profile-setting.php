<!DOCTYPE html>
<html lang="en">
    <link href="<?= asset('userassets/css/jWindowCrop.css') ?>" media="screen" rel="stylesheet" type="text/css" />
        <!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>-->

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    <link href="<?php echo asset('userassets/css/select3.css') ?>" rel="stylesheet">
    <?php include('includes/top.php'); ?>
    <body>
        <div id="wrapper">
            <?php include('includes/sidebar.php'); ?>
            <article id="content">
                <?php include('includes/header.php'); ?>
                <script type="text/javascript" src="<?= asset('userassets/js/jquery.jWindowCrop.js') ?>"></script>
                <div class="padding-div">
                    <div class="new_container">
                        <ul class="bread-crumbs list-none">
                            <li><a href="<?php echo asset('/'); ?>">Home</a></li>
                            <!--<li><a href="#">Q&amp;A</a></li>-->
                            <li>Profile Setting</li>
                        </ul>
                        <header class="intro-header no-bg">
                            <h1 class="custom-heading white">Profile Settings</h1>
                        </header>
                        <div class="profile-area edit-profile-area">
                            <header id="image-bg-upload"  class="profile-header" style="background-image: url('<?php echo asset(image_fix_orientation('public/images/' . $user->cover)); ?>')">
                                <ul class="list-none user-list">
                                    <!--<li class="change-cover"><a href="#update-cover" class="btn-popup">Change Cover Photo <span class="round-edit"><i class="fa fa-pencil" aria-hidden="true"></i></span></a></li>-->
                                    <!--<li><a href="#">Edit My HB Gallery</a></li>-->
                                </ul>
                                <div class="txt">
                                    <div class="user-photo pre-main-image">
                                        <!--<a href="#">Follow</a>-->
                                        <!--<a href="#upload-user-photo" class="round-edit btn-popup"><i class="fa fa-pencil" aria-hidden="true"></i></a>-->
                                        <a href="#upload-user-photo" class="btn-popup">
                                            <div class="user_photo " style="background-image: url(<?= getImage($user->image_path, $user->avatar) ?>)">
                                                <!--<img src="<?= $current_photo ?>" alt="User Photo">-->
                                            </div>
                                            <span class="round-edit">Change Photo</span>
                                        </a>
                                        <?php if ($user->specialUser) { ?>
                                            <a href="#upload-special-photo" class="special-edit btn-popup">
                                                <!--<div class="special-snap-sm">-->
                                                <figure style="background-image: url('<?php echo getSpecialIcon($user->special_icon) ?>')"></figure>
                                                <!--</div>-->
                                            </a>
                                        <?php } ?>
                                    </div>
                                    <div class="text <?= getRatingClass($user->points) ?>">
                                        <h2>
                                            <span id="first_name"><?= $user->first_name; ?></span> 
                                            <!--<a href="#update-name" class="edit-btn btn-popup"><i class="fa fa-pencil" aria-hidden="true"></i></a>-->
                                        </h2>
                                        <div class="txt-holders bg-bl-pro">
                                            <div class="txt-holder">

                                                <img src="<?php echo getRatingImage($user->points) ?>" alt="Leaf">
                                                <span><?= $user->points ?></span>
                                            </div>
                                            <div class="txt-holder add">
                                                <span ><?php //getRatingText($user->points); ?><img src="<?php echo asset('userassets/images/info-black.png') ?>" alt="Exclamation" class="exclamation-sign"></span>

                                                <div class="bud-tooltip rem-sp-tooltip">
                                                    <div class="header">
                                                        <!-- <span>Sprout</span> -->
                                                        <strong class="<?= getRatingClass($user->points) ?>"><?= getRatingText($user->points) ?></strong>
                                                    </div>
                                                    <div class="txt">
                                                        <p>How active is this Bud? Budz get 1 ranking point for every action in the Healing Budz Community.</p>
                                                        <dl>
                                                            <dt>0-99</dt>
                                                            <dd>Sprout</dd>
                                                            <dt class="green">100-199</dt>
                                                            <dd class="green">Seedling</dd>
                                                            <dt class="yellow">200-299</dt>
                                                            <dd class="yellow">Young Bud</dd>
                                                            <dt class="orange">300-399</dt>
                                                            <dd class="orange">Blooming Bud</dd>
                                                            <dt class="pink">400+</dt>
                                                            <dd class="pink">Best Bud</dd>
                                                        </dl>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="cus-btn-pro">
                                        <label for="update-cover">
                                            <form id="update_cover_photo" action="<?php echo asset('update_cover') ?>" method="post" enctype="multipart/form-data" class="reporting-form add no-border new-popup dark-gray">
                                                <input id="x" type="hidden" name="x" value="">
                                                <input id="y" type="hidden" name="y" value="">
                                                <input id="h" type="hidden" name="h" value="">
                                                <input id="w" type="hidden" name="w" value="">
                                                <input id="top" type="hidden" name="top" value="">
                                                <input id="image_croped" type="hidden" name="image_croped" value="">
                                                <input name="cover" type="file" id="update-cover" hidden="" style="display: none;">
                                                <span><img src="<?php echo asset('userassets/images/gallery-black.png') ?>" alt="gallery icon"> Change Cover Photo</span>
                                            </form>
                                        </label>
                                    </div>
                                </div>
                            </header>
                            <header style="display: none" id="cover_image_header" >
                                <div id="capture">  <img class="" id="cover_image"  src="<?php echo asset(image_fix_orientation('public/images/' . $user->cover)) ?>" ></div>
                                <input type="button" value="Save" onclick="saveForm()">
                                <input type="button" value="Cancel" onclick="cancelForm()">
                                <div class="cover_loader" id="cover_loader"><img width="75" src="<?php echo asset('userassets/images/edit_post_loader.svg') ?>"></div>
                            </header>
                            <div class="activity-area edit-area">
                                <div class="edit-pro-form">
                                    <form action="<?= asset('update_profile') ?>" id="update_profile" method="POST">
                                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                        <div class="left_content">
                                            <header class="header">
                                                <strong class="title">Edit Profile</strong>
                                            </header>
                                            <div class="edit-pro-prof">
                                                <fieldset>
                                                    <div class="small-col">
                                                        <label>NICK NAME</label>
                                                        <input type="text" name="user_name" maxlength="20" value="<?php echo $user->first_name; ?>" />
                                                        <span class="error_span"><?php
                                                            if ($errors->has('user_name')) {
                                                                echo $errors->first('user_name');
                                                            }
                                                            ?></span>
                                                    </div>
                                                </fieldset>
                                                <fieldset>
                                                    <div class="small-col">
                                                        <label>EMAIL</label>
                                                        <input type="email" name="email" value="<?= $user->email; ?>" required=""/>
                                                        <span class="error_span"><?php
                                                            if ($errors->has('email')) {
                                                                echo $errors->first('email');
                                                            }
                                                            ?></span>
                                                    </div>
                                                    <div class="small-col">
                                                        <label>ZIPCODE</label>
                                                        <input type="number" name="zip_code" value="<?= $user->zip_code; ?>" required/>
                                                        <span class="error_span"><?php
                                                            if ($errors->has('zip_code')) {
                                                                echo $errors->first('zip_code');
                                                            }
                                                            ?></span>
                                                    </div>
                                                </fieldset>
                                                <fieldset>
                                                    <div class="small-col">
                                                        <label>PASSWORD</label>
                                                        <div class="hb_pass_field">
                                                            <input type="password" name="password" id="password" value="" placeholder="*****" class="input_pass_field"/>
                                                            <span class="icon_show_pass"><i class="fa fa-eye"></i></span>
                                                        </div>

                                                        <span class="error_span"><?php
                                                            if ($errors->has('password')) {
                                                                echo $errors->first('password');
                                                            }
                                                            ?></span>
                                                    </div>
                                                    <div class="small-col">
                                                        <label>CONFIRM PASSWORD</label>
                                                        <div class="hb_pass_field">
                                                            <input type="password" name="confirm_password" value="" placeholder="*****" class="input_pass_field"/>
                                                            <span class="icon_show_pass"><i class="fa fa-eye"></i></span>
                                                        </div>

                                                    </div>
                                                </fieldset>
                                                <fieldset>
                                                    <div class="large-col">
                                                        <label>ADD BIO</label>
                                                        <textarea name="bio" rows="9" placeholder="Add Biography " ><?= $user->bio; ?></textarea>
                                                    </div>
                                                </fieldset>
                                            </div>
                                        </div>
                                        <div class="right_content">
                                            <div class="strain-green-input desk-show">
                                                <input type="submit" class="btn-primary" value="SAVE">
                                            </div>
                                            <div class="edit-pro-exp">
                                                <header class="header">
                                                    <strong class="title">My Experience</strong>
                                                </header>
                                                <h3>Which conditions or ailments have you treated with cannabis?</h3>
                                                <span class="span-white">Add up to 5</span>
                                                <span class="span-gray">Begin typing a medical condition to search</span>
                                                <span>

                                                    <select multiple="multiple" placeholder="Begin typing a medical condition to search" name="medical_uses[]" id="medical_uses" class="chzn-select" tabindex="1" style="display: none;">
                                                        <?php foreach ($all_medical_uses as $medical_use) { ?>
                                                            <option value="<?php echo $medical_use->id; ?>"><?php echo $medical_use->m_condition; ?></option>
                                                        <?php } ?>
                                                    </select>

                                                    <!--                                                    <div id="medical_exp" class="select3-multiple-input-container select3-input cus-style-choose">
                                                                                                            <input type="text" autocomplete="off" autocorrect="off" autocapitalize="off" class="select3-multiple-input" placeholder="" style="width: 20px;"/>
                                                                                                            <span class="select3-multiple-input select3-width-detector"></span>
                                                                                                            <div class="clearfix"></div>
                                                                                                        </div>
                                                                                                        <input type="hidden" id="user_medical_experties" name="medical_uses" >-->


                                            <!--<input type="search" id="experties_question_1" name="medical_uses" placeholder="Begin typing to search">-->

                                                </span>
                                            </div>
                                            <div class="edit-pro-exp">
                                                <header class="header">
                                                    <strong class="title">My Top <?php echo $strain_experties->count(); ?> Strain<?php if($strain_experties->count() !=1){ ?>s <?php } ?></strong>
                                                </header>
                                                <h3>What marijuana strains do you have experience with?</h3>
                                                <span class="span-white">Add up to 5</span>
                                                <span class="span-gray">Begin typing a strain name to search</span>
                                                <span>
                                                    <select multiple="multiple" placeholder="Begin typing a strain name to search" name="strains[]" id="strains" class="chzn-select" tabindex="1" style="display: none;">
                                                        <?php foreach ($all_strains as $strain) { ?>
                                                            <option value="<?php echo $strain->id; ?>"><?php echo $strain->title; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                    <!--<input type="search" id="experties_question_2" name="strains" placeholder="Begin typing to search">-->
                                                    <!--                                                    <div id="strain_exp" class="select3-multiple-input-container select3-input cus-style-choose">
                                                                                                            <input type="text" autocomplete="off" autocorrect="off" autocapitalize="off" class="select3-multiple-input" placeholder="" style="width: 20px;" />
                                                                                                            <span class="select3-multiple-input select3-width-detector"></span>
                                                                                                            <div class="clearfix"></div>
                                                                                                        </div>
                                                                                                        <input type="hidden" id="user_strain_experties" name="strains" >-->

                                                </span>
                                            </div>
                                            <div class="strain-green-input mob-show">
                                                <input type="submit" class="btn-primary" value="SAVE">
                                            </div>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="right_sidebars">
                        <?php include 'includes/rightsidebar.php'; ?>
                        <?php include 'includes/chat-rightsidebar.php'; ?>
                    </div>
                </div>
            </article>
        </div>
        <div id="upload-user-photo" class="popup">
            <div class="popup-holder">
                <div class="popup-area">
                    <form action="<?php echo asset('update_profile_photo') ?>" method="post" enctype="multipart/form-data" class="reporting-form add no-border new-popup dark-gray">
                        <fieldset>
                            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                            <h2 class="white radius">UPDATE PROFILE PHOTO</h2>
                            <div class="current-photo">
                                <input type="hidden" id="user_hidden_image" value="<?php echo $current_photo ?>">
                                <div class="profile_setting_bg" style="background-image:url('<?php echo $current_photo ?>')" id="profile_setting_bg"></div>
                            </div>
                            <div class="form-fields">
                                <label for="cover-photo1" class="cover-photo">Upload</label>
                                <input type="file" name="pic" id="cover-photo1" hidden accept="image/*">
                                <!-- <input type="submit" value="Save" class="btn-primary green"> -->
                            </div>
                            <div class="misc"><span>OR</span></div>
                            <strong class="choose-title">You can choose a different color Icon:</strong>
                            <div class="photos-list">
                                <?php foreach ($user_icons as $user_icon) { ?>
                                    <input type="radio" id="yellow-photo" name="" value="<?= $user_icon->name; ?>">
                                    <label for="yellow-photo"><img class="custom-123" src="<?php echo asset('public/images' . $user_icon->name) ?>" alt="<?php echo $user_icon->name; ?>"></label>
                                <?php } ?>

                            </div>
                            <input type="hidden" id="avatar" name="avatar" value="">
                            <div class="submit-div"><input type="submit" value="Save"></div>
                            <a href="#" class="btn-close">x</a>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
        <div id="upload-special-photo" class="popup">
            <div class="popup-holder">
                <div class="popup-area">
                    <form action="<?php echo asset('update_special_icon') ?>" method="post" enctype="multipart/form-data" class="reporting-form add no-border new-popup dark-gray">
                        <fieldset>
                            <input type="hidden" name="" value="">
                            <h2 class="white radius">UPDATE SPECIAL PHOTO</h2>
                            <div class="currents-photo1"><img src="<?php echo getSpecialIcon($user->special_icon) ?>" alt="icons" /></div>

                            <div class="misc"><span>OR</span></div>
                            <strong class="choose-title">You can choose a different Color Icon:</strong>
                            <div class="special-photos-list">
                                <?php foreach ($special_icons as $special_icon) { ?>
                                    <input type="radio" id="yellow-photo" name="" value="<?= $special_icon->name; ?>">
                                    <label for="yellow-photo"><img src="<?php echo asset('public/images/' . $special_icon->name) ?>" alt="<?php echo $special_icon->name; ?>"></label>
                                <?php } ?>

                            </div>
                            <input type="hidden" id="avatar-special" name="avatar" value="">
                            <div class="submit-div"><input type="submit" value="Save"></div>
                            <a href="#" class="btn-close">x</a>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
        <div id="update-email" class="popup">
            <div class="popup-holder">
                <div class="popup-area">
                    <form action="#" id="email_update" class="reporting-form add no-border new-popup">
                        <fieldset>
                            <h2 class="white radius">EMAIL UPDATE</h2>
                            <div class="form-fields">
                                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                <input type="email" id="email" name="email" class="email" placeholder="<?= $user->email; ?>">
                                <span class="custom-label">Confirm Email</span>
                                <input type="email" name="confirm_email" class="email" placeholder="<?= $user->email; ?>">
                                <h5 class="alert alert-success" style="display: none" id="email_success">Update successfully.</h5>
                                <h5 class="alert alert-danger" style="display: none" id="email_error">Email already exist.</h5>
                                <input type="submit" value="Save" class="btn-primary green">
                            </div>
                            <a href="#" class="btn-close" id="email_update_close">x</a>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
        <?php
//        $user_medical_exp = [];
//        foreach ($medical_use_experties as $medical_use_experty) {
//            if ($medical_use_experty->is_approved == 0) {
//                $user_medical_exp[] = $medical_use_experty->medical->title;
//            }
//            $user_medical_exp[] = $medical_use_experty->experty->title;
//        }
//        
        ?>

        //<?php
//        $user_strain_exp = [];
//        foreach ($strain_experties as $strain_experty) {
//                $strains[] = $strain_experty->strain->title;
//           
//        }
        ?>

        <?php include('includes/footer.php'); ?>
        <?php include('includes/functions.php'); ?>
        <script src="<?php echo asset('userassets/js/select3-full.js') ?>"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/additional-methods.js"></script>
        <script type="text/javascript" src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
        <script>
        $(".custom-123").on("click", function(e) {

            $("#profile_setting_bg").css('background-image','url('+$(this).attr('src')+')');

        });
                                    $(document).ready(function () {

                                        //User Experties
                                        $(".chzn-select").chosen({max_selected_options: 5});

                                        var medical_uses = '<?php echo(implode(',', $medical_use_experties->pluck('medical_use_id')->toarray())); ?>';
                                        var medical_uses_array = medical_uses.split(',');
                                        $('#medical_uses').val(medical_uses_array).trigger('chosen:updated');

                                        var strains = '<?php echo(implode(',', $strain_experties->pluck('strain_id')->toarray())); ?>';
                                        var strains_array = strains.split(',');
                                        
                                        $('#strains').val(strains_array).trigger('chosen:updated');

                                        //End User Experties

                                        var textarea = $("#my_textarea");

                                        textarea.keydown(function (event) {
                                            var numbOfchars = textarea.val();
                                            var len = numbOfchars.length;
                                            $(".chars-counter").text(len);
                                        });
                                        textarea.keypress(function (e) {
                                            var tval = textarea.val(),
                                                    tlength = tval.length,
                                                    set = 300,
                                                    remain = parseInt(set - tlength);
                                            if (remain <= 0 && e.which !== 0 && e.charCode !== 0) {
                                                textarea.val((tval).substring(0, tlength - 1))
                                            }
                                        });

                                        $("#update_profile").validate({
                                            rules: {
                                                user_name: {
                                                    required: true
                                                },
                                                email: {
                                                    required: true,
                                                    email: true
                                                },
                                                confirm_password: {
                                                    equalTo: "#password"
                                                },
                                                zip_code: {
                                                    required: true,
                                                    zipcodeUS: true
                                                },
//                        bio: {
//                            required: true
//                        }
                                            },
                                            messages: {
                                                user_name: {
                                                    required: "Please provide a Name"
                                                },
                                                email: {
                                                    required: "Please provide a email",
                                                    email: "Please provide a correct email"
                                                },
                                                confirm_password: {
                                                    equalTo: "Please enter the same password"
                                                },
                                                zip_code: {
                                                    required: "Please provide a zip code",
                                                    zipcodeUS: "Please provide a valid zip code"
                                                },
//                        bio: {
//                            required: "Please provide a bio"
//                        }
                                            }
                                        });


                                    });
                                    function readURLCover(input) {
                                        if (input.files && input.files[0]) {
                                            var file = input.files[0];
                                            var reader = new FileReader();
                                            reader.onload = function (e) {
                                                getOrientation(file, function (orientation) {


                                                    resetOrientation(reader.result, orientation, function (result) {

                                                        $('#image-bg-upload').hide();
                                                        $('#cover_image_header').show();
                                                        $('.jwc_frame').show();
                                                        $('#cover_image').attr('src', result);
                                                        $('#image-bg-upload').css('background-image', 'url(' + result + ')');

                                                        var width = $(window).width() * 65 / 100;
                                                        $('.crop_me').jWindowCrop({
                                                            targetWidth: width,
                                                            targetHeight: 300,
                                                            loadingText: 'loading',
                                                            onChange: function (result) {
                                                                $('#x').val(result.cropX);
                                                                $('#y').val(result.cropY);
                                                                $('#top').val($('#cover_image')[0].style.top);
                                                                $('#w').val(result.cropW);
                                                                $('#h').val(result.cropH);

                                                            }
                                                        });
                                                    });
                                                });

                                            }

                                            reader.readAsDataURL(file);
                                        }
                                    }
                                    $("#update-cover").change(function () {
                                        readURLCover(this);
                                        $('#cover_image').addClass('crop_me');
//        $('#update_cover_photo').submit();
                                    });
                                    function saveForm() {
                                        $('#cover_loader').css('display', 'flex');
                                        html2canvas(document.querySelector("#capture")).then(canvas => {
//                                            document.body.appendChild(canvas);
                                            dataURL = canvas.toDataURL();
                                            $('#image_croped').val(dataURL);
                                        });
                                        
                                        submitForm();

                                    }
                                    function submitForm() {
                                        setTimeout(function () {
                                            if ($('#image_croped').val()) {
                                                $('#update_cover_photo').submit();
                                            } else {
                                                submitForm();
                                            }
                                        }, 1000);
                                    }
                                    function cancelForm() {
                                        window.location.reload();
                                    }
                                    $(window).on('unload', function () {
                                        $.ajax({
                                            url: "<?php echo asset('log_data_two') ?>",
                                            type: "GET",
                                            data: {
                                                "user_id": '<?= $current_id ?>',
                                            },

                                        });
                                    });
        </script>
        <style type="text/css">
            body {
                font-family:sans-serif;
                font-size:13px;
            }
            #results {
                font-family:monospace;
                font-size:20px;
            }
            /* over ride defaults */
            .jwc_frame {
                border:5px solid black;
            } .jwc_controls {
                height:24px;
            } .jwc_zoom_in, .jwc_zoom_out {
                display:block; background-color:transparent;
                cursor:pointer;
                width:16px; height:16px;
                float:right; margin:4px 4px 0px 0px;
                text-decoration:none; text-align:center;
                font-size:16px; font-weight:bold; color:#000;
            } .jwc_zoom_in {
                /*background-image:url(../userassets/images/round_plus_16.png);*/
            } .jwc_zoom_out {
                /*background-image:url(../userassets/images/round_minus_16.png);*/
            } .jwc_zoom_in::after {
                content:"";
            } .jwc_zoom_out::after {
                content:"";
            }
            /* over ride defaults */
        </style>
    </body>

</html>