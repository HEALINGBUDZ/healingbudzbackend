<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Healing Budz</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous"> -->
        <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" media="all" rel="stylesheet">
        <link rel="shortcut icon" type="image/png" href="<?php echo asset('userassets/images/favicon.jpg') ?>"/>
        <link href="<?php echo asset('userassets/css/emoji.css') ?>" rel="stylesheet">
        <link href="<?php echo asset('userassets/css/jquery.ui.css') ?>" media="all" rel="stylesheet">
        <link href="<?php echo asset('userassets/css/chosen.css') ?>" media="all" rel="stylesheet">
        <link href="<?php echo asset('userassets/css/switchery.min.css') ?>" media="all" rel="stylesheet">
        <link href="<?php echo asset('userassets/css/star-rating-svg.css') ?>" media="all" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bxslider@4.2.13/dist/jquery.bxslider.min.css" rel="stylesheet" />

        <link href="<?php echo asset('userassets/css/all.css') ?>" media="all" rel="stylesheet">
        <link href="<?php echo asset('userassets/css/chat.css') ?>" media="all" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />


        <link href="<?php echo asset('userassets/css/font-awesome.css') ?>" media="all" rel="stylesheet">

    </head>
    <body>
        <main class="error-404-page">
            <div class="error-404-bg">
                <div class="hb_illegal_state">
                    <div class="hb_illegal_state_inner_wrap">
                        <img src='<?php echo asset('userassets/images/error.svg') ?>' alt='Error' />
                        <h2>Stop</h2>
                        <p>You are not in legal state for medical use.</p>
                        <a href='<?php echo $previous_url?>'>Go Back</a>
                    </div>
                </div>
            </div>
        </main>
        <?php //include('user/includes/footer.php'); ?>
    </body>
</html>