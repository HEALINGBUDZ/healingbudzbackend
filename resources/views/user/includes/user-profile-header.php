<link href="<?= asset('userassets/css/jWindowCrop.css') ?>" media="screen" rel="stylesheet" type="text/css" />
        <!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>-->
<script type="text/javascript" src="<?= asset('userassets/js/jquery.jWindowCrop.js') ?>"></script>
<header class="profile-header" id="image-bg-upload" style=" background-image: url('<?php echo asset(image_fix_orientation('public/images/' . $user->cover)) ?>')">
    
    <div class="txt">
        <div class="user-photo pre-main-image">
            <a <?php if ($user->id == $current_id) { ?> href="#upload-user-photo" class="btn-popup" <?php } else { ?> href="javascript:void(0)" <?php } ?> >
                <?php if ($user->id == $current_id) { ?>
                    <span class="round-edit">Change Photo</span>
                <?php } ?>
                <div class="user_photo" style="background-image: url(<?= getImage($user->image_path, $user->avatar) ?>)"></div> 
            </a>
            <div class="">
                <?php if ($user->special_icon) { ?>
                    <a <?php if (Auth::user()) { ?> href="#upload-special-photo" <?php } ?> class="special-edit btn-popup">
                        <span class="fest-pre-img" style="background-image: url(<?php echo asset('public/images' . $user->special_icon) ?>);"></span>
                    </a>
                <?php } ?>
                <?php if ($user->id != $current_id) { ?>
                <?php } ?>
            </div>
        </div>

        <div class="text <?= getRatingClass($user->points) ?>">
            <h2 class="<?= getRatingClass($user->points) ?>"><?= $user->first_name; ?> <a href="#" class="edit-btn" style="display: none;"></a></h2>
            <div class="txt-holders bg-bl-pro">
                <div class="txt-holder">
                    <img src="<?php echo getRatingImage($user->points) ?>" alt="Leaf">
                    <span><?= $user->points ?></span>
                </div>
                <div class="txt-holder add">
                    <span ><?php //getRatingText($user->points);               ?> <img src="<?php echo asset('userassets/images/info-black.png') ?>" alt="Exclamation" class="exclamation-sign" id="exclamation-sign"></span>


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
            <div class="txt-holders follow-sim-pro">
                <ul class="followers list-none">
                    <li>
                        <a <?php if ($user->is_followed_count > 0 && $user->id == $current_id) { ?> href="#followings" <?php } ?> class="btn-popup">
                            <em><?php echo $user->is_followed_count; ?></em>
                            <span>Following</span>
                        </a>
                    </li>
                    <li>
                        <a <?php if ($user->is_following_count > 0 && $user->id == $current_id) { ?> href="#followers" <?php } ?> class="btn-popup">
                            <em><?php echo $user->is_following_count; ?></em>
                            <span>Follower</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <?php
        if ($user->id != $current_id) {
            if (Auth::user()) {
                ?>
                <div class="cus-btn-pro">
                    <a onclick="unfollow('<?= $user->id ?>', 'unfollow_icon<?= $user->id ?>', 'follow_icon<?= $user->id ?>')" id="unfollow_icon<?= $user->id ?>" <?php if (!checkIsFolloing($user->id)) { ?> style="display: none" <?php } ?> href="#" class="yellow-bg">
                        <i class="fa fa-user-times"></i> Unfollow
                    </a>
                    <a onclick="follow('<?= $user->id ?>', 'follow_icon<?= $user->id ?>', 'unfollow_icon<?= $user->id ?>')" id="follow_icon<?= $user->id ?>" <?php if (checkIsFolloing($user->id)) { ?> style="display: none" <?php } ?> href="#">
                        <i class="fa fa-user"></i> Follow
                    </a>
                    <a href="<?= asset('message-user-detail/' . $user->id) ?>">
                        <i class="fa fa-comment"></i> Message
                    </a>
                </div>
            <?php } else { ?>
                <div class="cus-btn-pro">

                    <a   href="#loginModal" class="new_popup_opener">
                        <i class="fa fa-user"></i> Follow
                    </a>
                    <a href="#loginModal" class="new_popup_opener">
                        <i class="fa fa-comment"></i> Message
                    </a>
                </div>
            <?php } ?>
    <!--                                        <a href="<?= asset('hb-gallery/' . $user->id) ?>">
            <img src="<?php echo asset('userassets/images/gallery-black.png') ?>" alt="gallery icon" /> Gallery
        </a>-->
        <?php } if ($user->id == $current_id) { ?>
            <div class="cus-btn-pro profile_edit_pro">
                <a href="<?= asset('profile-setting')?>" class="edi_btn"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit Profile</a>
                <label for="update-cover">
                    <form id="update_cover_photo" action="<?php echo asset('update_cover') ?>" method="post" enctype="multipart/form-data" class="reporting-form add no-border new-popup dark-gray">
                        <input id="x" type="hidden" name="x" value="">
                        <input id="y" type="hidden" name="y" value="">
                        <input id="h" type="hidden" name="h" value="">
                        <input id="w" type="hidden" name="w" value="">
                        <input id="image_croped" type="hidden" name="image_croped" value="">
                        <input id="top" type="hidden" name="top" value="">
                        <input name="cover" type="file" id="update-cover" hidden="" style="display: none;">
                        <span><img src="<?php echo asset('userassets/images/gallery-black.png') ?>" alt="gallery icon"> Change Cover Photo</span>
                    </form>
                </label>
                 
            </div>

        <?php } ?>


</header>
<header style="display: none" id="cover_image_header" >
    <div id="capture"><img class="" id="cover_image"  src="<?php echo asset(image_fix_orientation('public/images/' . $user->cover_full)) ?>" ></div>
    <img id="show_image" src="">
    <input type="button" value="Save" onclick="saveForm()">
    <input type="button" value="Cancel" onclick="cancelForm()">
    <div class="cover_loader" id="cover_loader"><img width="75" src="<?php echo asset('userassets/images/edit_post_loader.svg') ?>"></div>
</header>
<div class="pro-main-tabbing">
    <a  href="<?= asset('user-profile-detail/' . $user->id) ?>" class="pro-soc-a <?php if ($segment == 'user-profile-detail') { ?> active  <?php } ?>"><span>The Buzz</span></a>
    <a href="<?= asset('user-profile-questions/' . $user->id) ?>" class="pro-qa-a <?php if ($segment == 'user-profile-questions') { ?> active  <?php } ?>"><span>Q&A</span></a>
    <a  href="<?= asset('user-strains/' . $user->id) ?>" class="pro-str-a <?php if ($segment == 'user-strains') { ?> active  <?php } ?>"><span>Strains</span></a>
    <a  href="<?= asset('user-budzmap/' . $user->id) ?>" class="pro-bud-a <?php if ($segment == 'user-budzmap') { ?> active  <?php } ?>"><span>Budz Adz</span></a>
    <a href="<?= asset('user-reviews/' . $user->id) ?>" class="pro-rev-a <?php if ($segment == 'user-reviews') { ?> active  <?php } ?>"><span>Reviews</span></a>
    <a href="<?= asset('hb-gallery/' . $user->id) ?>" class="pro-gal-a <?php if ($segment == 'hb-gallery') { ?> active  <?php } ?>"><span>Gallery</span></a>
    <a href="<?= asset('about-user/' . $user->id) ?>" class="pro-ab-a <?php if ($segment == 'about-user') { ?> active  <?php } ?>"><span>About</span></a>
</div>


<div id="followers" class="popup foll-pop">
    <div class="popup-holder">
        <div class="popup-area">
            <div action="#" class="reporting-form add no-border new-popup">
                <h2 class="radius">Follower</h2>
                <ul class="list-none popup-list">
                    <?php foreach ($user->is_following as $following) { ?>
                        <li>
                            <figure style="background-image: url('<?php echo getImage($following->user->image_path, $following->user->avatar) ?>');"></figure>
                            <div class="txti">
                                <a class="pop-list-follow-anc" href="<?php echo asset('user-profile-detail/' . $following->user->id); ?>"><?php echo $following->user->first_name; ?></a>
                                <strong><?php echo $following->user->location; ?></strong>
                            </div>
                            <?php if (Auth::user()) { ?>
                                <a onclick="unfollow('<?= $following->user->id ?>', 'unfollowing_<?= $following->user->id ?>', 'following_<?= $following->user->id ?>')"  <?php if (!checkIsFolloing($following->user->id)) { ?> style="display: none" <?php } ?> id="unfollowing_<?= $following->user->id ?>"  href="#" class="btn"><i class="fa fa-user-times" aria-hidden="true"></i> Unfollow</a>
                                <a onclick="follow('<?= $following->user->id ?>', 'following_<?= $following->user->id ?>', 'unfollowing_<?= $following->user->id ?>')" <?php if (checkIsFolloing($following->user->id)) { ?> style="display: none" <?php } ?>  id="following_<?= $following->user->id ?>" href="#" class="btn follow-btn"><i class="fa fa-user-plus" aria-hidden="true"></i> Follow</a>
                            <?php } else { ?>
                                <a  href="#loginModal" class="btn follow-btn new_popup_opener"><i class="fa fa-user-plus" aria-hidden="true"></i> Follow</a>
                            <?php } ?>
                        </li>
                    <?php } ?>     
                </ul>
                <a href="#" class="btn-close">x</a>
            </div>
        </div>
    </div>
</div>

<div id="followings" class="popup foll-pop">
    <div class="popup-holder">
        <div class="popup-area">
            <div action="#" class="reporting-form add no-border new-popup">
                <h2 class="radius">Following</h2>
                <ul class="list-none popup-list">
                    <?php foreach ($user->is_followed as $follower) { ?>
                        <li>
                            <figure style="background-image: url('<?php echo getImage($follower->getUser->image_path, $follower->getUser->avatar) ?>');"></figure>
                            <div class="txti">
                                <a class="pop-list-follow-anc" href="<?php echo asset('user-profile-detail/' . $follower->getUser->id); ?>"><?php echo $follower->getUser->first_name; ?></a>
                                <strong><?php echo $follower->getUser->location; ?></strong>
                            </div>
                            <?php if ($current_id) { ?>
                                <a onclick="unfollow('<?= $follower->getUser->id ?>', 'unfollow_<?= $follower->getUser->id ?>', 'follow_<?= $follower->getUser->id ?>')" <?php if (!checkIsFolloing($follower->getUser->id)) { ?> style="display: none" <?php } ?>id="unfollow_<?= $follower->getUser->id ?>" href="javascript:void(0)" class="btn"><i class="fa fa-user-times" aria-hidden="true"></i> Unfollow</a>
                                <a onclick="follow('<?= $follower->getUser->id ?>', 'follow_<?= $follower->getUser->id ?>', 'unfollow_<?= $follower->getUser->id ?>')" <?php if (checkIsFolloing($follower->getUser->id)) { ?> style="display: none" <?php } ?>  id="follow_<?= $follower->getUser->id ?>" href="javascript:void(0)" class="btn follow-btn"><i class="fa fa-user-plus" aria-hidden="true"></i> Follow</a>
                            <?php } else { ?>
                                <a  href="#loginModal" class="btn follow-btn new_popup_opener"><i class="fa fa-user-plus" aria-hidden="true"></i> Follow</a>
                            <?php } ?>
                        </li>
                    <?php } ?> 
                </ul>
                <a href="#" class="btn-close">x</a>
            </div>
        </div>
    </div>
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
                        <div class="profile_setting_bg" id="profile_setting_bg" style="background-image:url('<?php echo $current_photo ?>')"></div>
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
                            <label for="yellow-photo"><img class="custom-123" src="<?php echo asset('public/images/' . $special_icon->name) ?>" alt="<?php echo $special_icon->name; ?>"></label>
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
<script type="text/javascript" src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
<script>

    $(".custom-123").on("click", function(e) {

        $("#profile_setting_bg").css('background-image','url('+$(this).attr('src')+')');

    });

                            $('body').click(function (evt) {
                                if (evt.target.id == "exclamation-sign") {

                                } else {
                                    $('.bud-tooltip').hide();
                                }
                            })
                            function readURLCover(input) {
                                if (input.files && input.files[0]) {
                                    var file = input.files[0];
                                    var reader = new FileReader();
                                    reader.onload = function (e) {
                                        getOrientation(file, function (orientation) {

//                            alert(orientation);
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
                                                        $('#top').val($('#cover_image')[0].style.top);
                                                        $('#y').val(result.cropY);
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
//                                    document.body.appendChild(canvas);
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