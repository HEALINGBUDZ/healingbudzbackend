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
                <h2 class="mainHEading mainsubheading">Import Strain</h2>
                <?php if ($errors->any()) { ?>
                    <div class="alert alert-danger">
                        <?php foreach ($errors->all() as $error) { ?>
                            <?= $error ?><br/>
                        <?php } ?>
                    </div>
                <?php } ?>

                <form method="post" action="<?= asset('add_strain_from_csv')?>"enctype="multipart/form-data">
                    <div class="alert alert-success" id="success-msg" style="display:none;">Your request is being processed.</div>
                    <label class="fullField">
                        <span>CSV File</span>
                        <input type="file" accept=".csv" autocomplete="off" name="csv_file" required="">
                        
                    </label>

                    <div class="btnCol radius-btn">
                        <input type="submit" id="submit-btn" name="signIn"  value="Submit">
                        <div style="display: none" class="loader_center text-center" id="loader"><img src="<?php echo asset('userassets/images/loader.gif') ?>" alt="Loading . . . ." ><span></span></div>
                    </div>
                </form>
            </div>
            <div class="contentPd">
                <h2 class="mainHEading mainsubheading">Import Business Profile</h2>
                <form method="post" action="<?= asset('add_budz_from_csv')?>"enctype="multipart/form-data">
                    <div class="alert alert-success" id="success-msg" style="display:none;">Your request is being processed.</div>
                    <label class="fullField">
                        <span>CSV File</span>
                        <input type="file" accept=".csv" autocomplete="off" name="csv_file" required="">
                        
                    </label>

                    <div class="btnCol radius-btn">
                        <input type="submit" id="submit-btn" name="signIn"  value="Submit">
                        <div style="display: none" class="loader_center text-center" id="loader"><img src="<?php echo asset('userassets/images/loader.gif') ?>" alt="Loading . . . ." ><span></span></div>
                    </div>
                </form>
            </div>
        </section>
        <?php include resource_path('views/admin/includes/footer.php'); ?>
        <script src="https//cdn.ckeditor.com/4.5.5/standard/ckeditor.js"></script>
    </body>
</html>
<script>
//    $('form').submit(function(e) {
//        e.preventDefault();
//        var title = $('input[name=title]').val();
//        var message = $('textarea[name=message]').val();
//        if(title && message){
//            $('input[type=submit]').attr('disabled', 'disabled');
//            $('#loader').show();
//            setTimeout(function(){
//                $('#loader').hide();
//            }, 5000);
//            $.ajax({
//                type: 'POST',
//                url: '<?= asset("send_to_all") ?>',
//                data: {title: title, message: message},
//                beforeSend: function (request) {
//                    return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
//                }
//            });  
//            $('#success-msg').fadeIn('slow');
//            setTimeout(function(){
//                $('#loader').hide();
//            }, 5000);
//            setTimeout(function(){
//                window.location.reload();
//            }, 5000);
//        }
//    });
</script>
