<head>
    <meta charset="UTF-8">
    <meta name="robots" content="noindex, nofollow" />
    <meta name="csrf_token" content="<?php echo csrf_token(); ?>" />
    <?php if(isset($title)){ ?>
        <title><?= $title ?></title>
    <?php }else{ ?>
        <title>Healing Budz Admin</title>
    <?php } ?>
        <link rel="shortcut icon" type="image/png" href="<?php echo asset('userassets/images/favicon.jpg') ?>"/>
    <meta name="viewport" content="public/width=device-width">
    <link rel="stylesheet" href="<?php echo asset('adminassets/css/bootstrap.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo asset('adminassets/css/font-awesome.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo asset('adminassets/css/jquery.dataTables.css'); ?>">
    <link rel="stylesheet" href="<?php echo asset('adminassets/css/jquery.mCustomScrollbar.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo asset('adminassets/css/normalize.css'); ?>">
    <link rel="stylesheet" href="<?php echo asset('adminassets/css/theme.css'); ?>">
    
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css"/>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="<?php echo asset('adminassets/css/multi_select.css'); ?>">
</head>
<div class="preloader-wrapper">
    <div class="preloader">
        <img src="<?php echo asset('userassets/images/edit_post_loader.svg'); ?>" alt="NILA">
    </div>
</div>
