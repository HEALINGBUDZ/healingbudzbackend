<!DOCTYPE html>
<html lang="en">
    <?php include resource_path('views/admin/includes/head.php'); ?>
    <body>
        <?php include resource_path('views/admin/includes/header.php'); ?>
        <?php include resource_path('views/admin/includes/sidebar.php'); ?>
        <section class="content lifeContent">

            <?php if (\Session::has('success')) { ?>
                <h4 class="alert alert-success fade in">
                    <?php echo \Session::get('success'); ?>
                </h4>
            <?php } ?>
            <?php if (\Session::has('error')) { ?>
                <h4 class="alert alert-danger fade in">
                    <?php echo \Session::get('error'); ?>
                </h4>
            <?php } ?>
            <div class="contentPd">
                <h2 class="mainHEading mainsubheading">Add Image or Video</h2>
                <?php if ($errors->any()) { ?>
                    <div class="alert alert-danger">
                        <?php foreach ($errors->all() as $error) { ?>
                            <?= $error ?><br/>
                        <?php } ?>
                    </div>
                <?php } ?>

                <video <?php if ($image->type == 'image') { ?> style="display: none" <?php } ?> id="videoview" width="1000" height="300" controls>
                    <source src="<?= asset('public/images/' . $image->file) ?>" type="video/mp4">
                    <source src="<?= asset('public/images/' . $image->file) ?>" type="video/ogg">
                    Your browser does not support the video tag.
                </video>
                <img <?php if ($image->type == 'video') { ?> style="display: none" <?php } ?> id="imageview" src="<?= asset('public/images/' . $image->file) ?>">

                <form method="post" action="<?= asset('home_image') ?>"enctype="multipart/form-data">
                    <div class="alert alert-success" id="success-msg" style="display:none;">Your request is being processed.</div>
                    <label class="fullField">
                        <span>Select File</span>
                        <input id="file" type="file" accept="image/*,video/*" autocomplete="off" name="image" required="">

                    </label>
                    <input type="hidden" name="file_type" id="file_type">
                    <div class="btnCol radius-btn">
                        <input type="submit" id="submit-btn" name="signIn"  value="Submit">
                        <div style="display: none" class="loader_center text-center" id="loader"><img src="<?php echo asset('userassets/images/loader.gif') ?>" alt="Loading . . . ." ><span></span></div>
                    </div>
                </form>
            </div>
        </section>
        <?php include resource_path('views/admin/includes/footer.php'); ?>
    </body>
</html>
<script>

    function readURL(input) {

        var filePath = input.value;
        var fileUrl = window.URL.createObjectURL(input.files[0]);
        var image_type = input.files[0].type;
        var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif|\.mp4)$/i;
        if (!allowedExtensions.exec(filePath)) {
            alert('Please upload file having extensions .jpeg/.jpg/.png/.gif  only.');
            $('#file').val('');
            return false;
        }

        if (image_type == "image/png" || image_type == "image/jpeg" || image_type == "image/gif" || image_type == "image/bmp" || image_type == "image/jpg") {
            $('#file_type').val('image');
            $('#videoview').hide();
            $('#imageview').show();
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#imageview').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        } else {
            $('#file_type').val('video');
            $('#videoview').show();
            $('#imageview').hide();
            $("#videoview").attr("src", fileUrl);
        }
    }

    $("#file").change(function () {
        readURL(this);
    });
    ;
</script>
