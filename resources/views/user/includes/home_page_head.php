<head>
    <?php
    $shown_title='Healing Budz Home';
    if(isset($title)){
        $shown_title=$title;
    }?>
    <title><?= $shown_title ?></title>
    <meta charset="UTF-8">
    <!--<meta property="og:image" content="<?php // echo asset('userassets/images/logo-for-scrap.png') ?>" />-->
    <?php if (isset($og_image)) { ?>
        <meta property="og:image" content="<?php echo $og_image ?>" />

    <?php } else { ?>
        <meta property="og:image" content="<?php echo asset('userassets/images/logo-for-scrap.png') ?>" />
    <?php } ?>
    <?php if (isset($og_title)) { ?>
        <meta property="og:title" content="<?php echo $og_title ?>" />

    <?php } else { ?>
        <meta property="og:title" content="Healing Budz" />
    <?php } ?>
    <?php if (isset($og_description)) { ?>
        <meta property="og:description" content="<?php echo $og_description ?>" />
    <?php } else { ?>
        <meta property="og:description" content="healing budz" />   
    <?php } ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png" href="<?php echo asset('userassets/images/favicon.jpg') ?>"/>
    <link rel="stylesheet" type="text/css" href="<?php echo asset('userassets/css/home.css') ?>">
    <link href="<?php echo asset('userassets/css/font-awesome.css')?>" media="all" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,400i,700,700i,900" rel="stylesheet">

</head>

