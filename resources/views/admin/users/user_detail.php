<html lang="en">
<?php include resource_path('views/admin/includes/head.php'); ?>
    <body>
    <?php include resource_path('views/admin/includes/header.php'); ?>
    <?php include resource_path('views/admin/includes/sidebar.php'); ?>
        <section class="content publicContent">
            <div class="container container-width">
                <div class="row">
                    <div class="col-md-9">
                        <a class="add_s" href="<?php echo asset('show_users');?>">Back</a>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4>User Profile</h4>
                                <?php if(\Session::has('success')) {?>
                                    <h4 class="alert alert-success fade in">
                                        <?php echo \Session::get('success'); ?>
                                    </h4>
                                <?php } ?>
                                <?php if ($errors->has('first_name')) {?>
                                    <div class="alert alert-danger">
                                        <?php foreach ($errors->get('first_name') as $message) {?>
                                            <?php echo $message ?><br>
                                        <?php } ?>
                                    </div>
                                <?php } ?>
                                <?php if ($errors->has('last_name')) {?>
                                    <div class="alert alert-danger">
                                        <?php foreach ($errors->get('last_name') as $message) {?>
                                            <?php echo $message ?><br>
                                        <?php } ?>
                                    </div>
                                <?php } ?>
                                <?php if ($errors->has('email')) {?>
                                    <div class="alert alert-danger">
                                        <?php foreach ($errors->get('email') as $message) {?>
                                            <?php echo $message ?><br>
                                        <?php } ?>
                                    </div>
                                <?php } ?>
                                <?php if ($errors->has('password')) {?>
                                    <div class="alert alert-danger">
                                        <?php foreach ($errors->get('password') as $message) {?>
                                            <?php echo $message ?><br>
                                        <?php } ?>
                                    </div>
                                <?php } ?>
                                <?php if ($errors->has('zip_code')) {?>
                                    <div class="alert alert-danger">
                                        <?php foreach ($errors->get('zip_code') as $message) {?>
                                            <?php echo $message ?><br>
                                        <?php } ?>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="panel-body">
                                <div class="box box-info">
                                    <div class="box-body">
                                        <div class="col-sm-5">
                                            <?php 
                                                $current_photo = getImage($user->image_path, $user->avatar);
                                            ?>
                                            <div  align="">
                                                <div class="profile-background" style="background-image: url('<?php echo $current_photo; ?>')" id="profile-image1"></div>
                                               <!--  <img alt="User Pic" src="<?php echo $current_photo;?>" id="profile-image1" class="img-circle img-responsive"> -->
                                                <input name="pic" id="pic" type="file" style="display: none;">
                                            </div>
                                            <br>
                                        </div>
                                        <div class="col-sm-7">
                                            <h4 style="color: #7cc044;"><?php echo $user->first_name.' '.$user->last_name ?></h4></span>
                                            <span><p><?php echo $user->email ?></p></span>            
                                        </div>
                                        <div class="clearfix"></div>
                                        <hr style="margin:5px 0 5px 0;">

                                        <div class="col-sm-5 col-xs-6 tital " >Nick Name:</div>
                                        <div class="col-sm-4"><?php echo $user->first_name ?></div>
                                        <div class="col-sm-3">
                                            <a data-target="#modal_first_name" data-toggle="modal" href="#">
                                                <i class="fa fa-edit fa-fw"></i>
                                            </a>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="bot-border"></div>

<!--                                        <div class="col-sm-5 col-xs-6 tital " >Last Name:</div>
                                        <div class="col-sm-4"><?php echo $user->last_name ?></div>
                                        <div class="col-sm-3">
                                            <a data-target="#modal_last_name" data-toggle="modal" href="#">
                                                <i class="fa fa-edit fa-fw"></i>
                                            </a>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="bot-border"></div>-->

                                        <div class="col-sm-5 col-xs-6 tital " >Email:</div>
                                        <div class="col-sm-4"><?php echo $user->email ?></div>
                                        <div class="col-sm-3">
                                            <a data-target="#modal_email" data-toggle="modal" href="#">
                                                <i class="fa fa-edit fa-fw"></i>
                                            </a>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="bot-border"></div>

                                        <div class="col-sm-5 col-xs-6 tital " >Password:</div>
                                        <div class="col-sm-4">******</div>
                                        <div class="col-sm-3">
                                            <a data-target="#modal_password" data-toggle="modal" href="#">
                                                <i class="fa fa-edit fa-fw"></i>
                                            </a>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="bot-border"></div>

                                        <div class="col-sm-5 col-xs-6 tital " >Zip Code:</div>
                                        <div class="col-sm-4"><?php echo $user->zip_code ?></div>
                                        <div class="col-sm-3">
                                            <a data-target="#modal_zip_code" data-toggle="modal" href="#">
                                                <i class="fa fa-edit fa-fw"></i>
                                            </a>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="bot-border"></div>

                                        <div class="col-sm-5 col-xs-6 tital " >Business Profiles:</div>
                                        <div class="col-sm-7"><a href="<?php if($user->sub_user_count) { echo asset('user_business_profiles/'.$user->id); } else { echo 'javascript:void(0)'; }?>"><?= $user->sub_user_count;?></a></div>
                                        <div class="clearfix"></div>
                                        <div class="bot-border"></div>
                                    </div>
                                </div>
                            </div> 
                        </div>
                    </div>  
                </div>
            </div>
            <!-- Update First Name -->
            <div class="modal fade" id="modal_first_name" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Update Nick Name</h4>
                        </div>
                        <div class="modal-body">
                            <form action="<?php echo asset('update_user_first_name')?>" method="POST" id="loginform">
                                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                <input type="hidden" name="user_id" value="<?php echo $user->id; ?>">
                                <label class="fullField">
                                    <!--<span>First Name</span>-->
                                    <input maxlength="20" type="text" name="first_name" value="<?php echo $user->first_name ?>" placeholder="Nick Name">

                                </label>
                                <!--<div class="btnCol">-->
                                    <input type="submit" name="signIn"  value="Update">
                                <!--</div>-->
                            </form>
                        </div>
        <!--                <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>-->
                    </div>
                </div>
            </div>
            <!-- Model End -->
            <!-- Update Last Name -->
            <div class="modal fade" id="modal_last_name" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <form action="<?php echo asset('update_user_last_name')?>" method="POST" id="loginform">
                                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                <input type="hidden" name="user_id" value="<?php echo $user->id; ?>">
                                <label class="fullField">
                                    <!--<span>Last Name</span>-->
                                    <input type="text" name="last_name" value="<?php echo $user->last_name ?>" placeholder="Last Name">

                                </label>
                                <!--<div class="btnCol">-->
                                    <input type="submit" name="signIn"  value="Update">
                                <!--</div>-->
                            </form>
                        </div>
        <!--                <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>-->
                    </div>
                </div>
            </div>
            <!-- Model End -->

            <!-- Update Email -->
            <div class="modal fade" id="modal_email" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Update Email</h4>
                        </div>
                        <div class="modal-body">
                            <form action="<?php echo asset('update_user_email')?>" method="POST" id="loginform">
                                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                <input type="hidden" name="user_id" value="<?php echo $user->id; ?>">
                                <label class="fullField">
                                    <!--<span>Last Name</span>-->
                                    <input type="text" name="email" value="<?php echo $user->email ?>" placeholder="Email">

                                </label>
                                <!--<div class="btnCol">-->
                                    <input type="submit" name="signIn"  value="Update">
                                <!--</div>-->
                            </form>
                        </div>
        <!--                <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>-->
                    </div>
                </div>
            </div>
            <!-- Model End -->

            <!-- Update Password -->
            <div class="modal fade" id="modal_password" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Update Password</h4>
                        </div>
                        <div class="modal-body">
                            <form action="<?php echo asset('update_user_password')?>" method="POST" id="loginform">
                                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                <input type="hidden" name="user_id" value="<?php echo $user->id; ?>">
                                <label class="fullField">
                                    <!--<span>Last Name</span>-->
                                    <input type="text" name="password" value="" placeholder="New Password">

                                </label>
                                <!--<div class="btnCol">-->
                                    <input type="submit" name="signIn"  value="Update">
                                <!--</div>-->
                            </form>
                        </div>
        <!--                <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>-->
                    </div>
                </div>
            </div>
            <!-- Model End -->

            <!-- Update Zip Code -->
            <div class="modal fade" id="modal_zip_code" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Update Zip Code</h4>
                        </div>
                        <div class="modal-body">
                            <form action="<?php echo asset('update_user_zip_code')?>" method="POST" id="loginform">
                                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                <input type="hidden" name="user_id" value="<?php echo $user->id; ?>">
                                <label class="fullField">
                                    <!--<span>Last Name</span>-->
                                    <input type="text" name="zip_code" value="<?php echo $user->zip_code ?>" placeholder="Zip Code">

                                </label>
                                <!--<div class="btnCol">-->
                                    <input type="submit" name="signIn"  value="Update">
                                <!--</div>-->
                            </form>
                        </div>
        <!--                <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>-->
                    </div>
                </div>
            </div>
            <!-- Model End -->

        </section>
    <?php include resource_path('views/admin/includes/footer.php'); ?>
    <script>
        $('#profile-image1').on('click', function() {
            $('#pic').click();
        });   
        $('#pic').change(handleCoverPicSelect);
        function handleCoverPicSelect(event)
        {
            var input = this;
            var filename = $("#pic").val();
            var fileType = filename.replace(/^.*\./, '');
            var ValidImageTypes = ["jpg", "jpeg", "png", "bmp"];
            if ($.inArray(fileType, ValidImageTypes) < 0) {
                alert("The file does not match the upload conditions, You can only upload jpg/jpeg/png/bmp files");
                event.preventDefault();
                $('#pic').val('');
                return;
            }
                if (input.files && input.files[0])
                {
                    var reader = new FileReader();
                    reader.onload = (function (e)
                    {
                        $('#profile-image1').css("background-image", "url(" + e.target.result + ")");
                    });
                    reader.readAsDataURL(input.files[0]);
                    var image = $('#pic')[0].files[0];
                    var form = new FormData();
                    form.append('pic', image);
                    form.append('user_id', <?=$user->id?>);
                    $.ajax({
                        type: 'POST',
                        contentType: false,
                        cache: false,
                        processData: false,
                        url: '<?=asset("upload_user_image")?>',
                        enctype: 'multipart/form-data',
                        data: form,
                        beforeSend: function (request) {
                            return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
                        },
                        success: function (data) {
                        }
                    });
                }
        }
    </script> 
    </body>
</html>