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

            <div class="contentPd">
                <h2 class="mainHEading mainsubheading">Send Notification </h2>
                <?php if ($errors->any()) { ?>
                    <div class="alert alert-danger">
                        <?php foreach ($errors->all() as $error) { ?>
                            <?= $error ?><br/>
                        <?php } ?>
                    </div>
                <?php } ?>

                <form>
                    <div class="alert alert-success" id="success-msg" style="display:none;">Your request is being processed.</div>
                    <label class="fullField">
                        <span>Title</span>
                        <input type="text" autocomplete="off" name="title" required="">
                        <span>Description</span>
                        <textarea name="message" autocomplete="off" class="wh-speaker" required=""></textarea>
                        <?php if ($errors->has('message')) { ?>
                            <div class="alert alert-danger">
                                <?php foreach ($errors->get('description') as $message) { ?>
                                    <?= $message ?><br>
                                <?php } ?>
                            </div>
                        <?php } ?>
                    </label>

                    <div class="btnCol radius-btn">
                        <input type="submit" id="submit-btn" name="signIn"  value="Submit">
                        <div style="display: none" class="loader_center text-center" id="loader"><img src="<?php echo asset('userassets/images/loader.gif') ?>" alt="Loading . . . ." ><span></span></div>
                    </div>
                </form>
            </div>
        </section>
        <?php include resource_path('views/admin/includes/footer.php'); ?>
        <script src="//cdn.ckeditor.com/4.5.5/standard/ckeditor.js"></script>
    </body>
</html>
<script>
    $('form').submit(function(e) {
        e.preventDefault();
        var title = $('input[name=title]').val();
        var message = $('textarea[name=message]').val();
        if(title && message){
            $('input[type=submit]').attr('disabled', 'disabled');
            $('#loader').show();
            setTimeout(function(){
                $('#loader').hide();
            }, 5000);
            $.ajax({
                type: 'POST',
                url: '<?= asset("send_to_all") ?>',
                data: {title: title, message: message},
                beforeSend: function (request) {
                    return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
                }
            });  
            $('#success-msg').fadeIn('slow');
            setTimeout(function(){
                $('#loader').hide();
            }, 5000);
            setTimeout(function(){
                window.location.reload();
            }, 5000);
        }
    });
</script>
