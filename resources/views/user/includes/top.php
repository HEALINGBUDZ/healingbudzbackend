<?php
if (Auth::user()) {
    $current_user = Auth::user();
    $current_session = getLoginUser();
//dd($current_user);
    $current_id = $current_user->id;
    $current_photo = getImage($current_user->image_path, $current_user->avatar);
    $current_special_image = $current_user->special_icon;
    $group_user_photo = getGroupUserImage($current_user->image_path, $current_user->avatar);
    $current_special_icon_user = '';
    if ($current_special_image) {
        $current_special_icon_user = getSpecialIcon($current_special_image);
    }
} else {
    $current_user = '';
    $current_session = '';
//dd($current_user);
    $current_id = '';
    $current_photo = '';
    $current_special_image = '';
    $group_user_photo = '';
    $current_special_icon_user = '';
}
$segment = Request::segment(1);
?>
<head>
    <?php if (isset($og_title)) { ?>
        <title><?= $og_title ?></title>
    <?php } else { ?>
        <title>Healing Budz</title>
    <?php } ?>
    <meta charset="UTF-8">
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
    <?php if (isset($og_description)) { ?>
        <meta name="description" content="<?php echo $og_description ?>" />
    <?php } else { ?>
        <meta property="description" content="healing budz" />   
    <?php } ?>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta charset="character_set">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous"> -->
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" media="all" rel="stylesheet">
    <link rel="shortcut icon" type="image/png" href="<?php echo asset('userassets/images/favicon.jpg') ?>"/>
    <link href="<?php echo asset('userassets/css/emoji.css') ?>" rel="stylesheet">
    <link href="<?php echo asset('userassets/css/jquery.ui.css') ?>" media="all" rel="stylesheet">
    <link href="<?php echo asset('userassets/css/chosen.css') ?>" media="all" rel="stylesheet">
    <link href="<?php echo asset('userassets/css/switchery.min.css') ?>" media="all" rel="stylesheet">
    <link href="<?php echo asset('userassets/css/star-rating-svg.css') ?>" media="all" rel="stylesheet">
    <!--<link href="https://cdn.jsdelivr.net/npm/bxslider@4.2.13/dist/jquery.bxslider.min.css" rel="stylesheet" />-->
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.css">

    <link href="<?php echo asset('userassets/css/chat.css') ?>" media="all" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />

    <!--    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="/resources/demos/style.css">-->

    <link href="<?php echo asset('userassets/css/font-awesome.css') ?>" media="all" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,400i,700,700i,900" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>    
    <link href="<?php echo asset('userassets/css/jquery.fancybox.min.css') ?>" media="all" rel="stylesheet">
    <link href="<?php echo asset('userassets/css/intro-css.css') ?>" media="all" rel="stylesheet">
    <link href="<?php echo asset('userassets/css/all.css') ?>" media="all" rel="stylesheet">
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <link href="<?php echo asset('userassets/css/loginmodalStyle.css') ?>" media="all" rel="stylesheet">
    <link rel="manifest" href="/manifest.json" />
    <script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async='async'></script>
    

    <script>
        OneSignal = window.OneSignal || [];

        OneSignal.push(function () {

//            OneSignal.log.setLevel('trace');

            OneSignal.init({
                appId: "<?= env('OneSignal_appId') ?>",
                safari_web_id: '<?= env('OneSignal_Safari_Web_ID') ?>',
                autoRegister: true,
                allowLocalhostAsSecureOrigin: true,
                notifyButton: {
                    enable: true, /* Required to use the notify button */
                    size: 'small', /* One of 'small', 'medium', or 'large' */
                    theme: 'default', /* One of 'default' (red-white) or 'inverse" (white-red) */
                    position: 'bottom-left', /* Either 'bottom-left' or 'bottom-right' */
                    offset: {
                        bottom: '10px',
                        left: '10px', /* Only applied if bottom-left */
                        right: '0px' /* Only applied if bottom-right */
                    },
                    prenotify: false, /* Show an icon with 1 unread message for first-time site visitors */
                    showCredit: false, /* Hide the OneSignal logo */
                    text: {
                        'tip.state.unsubscribed': 'Subscribe to notifications',
                        'tip.state.subscribed': "You're subscribed to notifications",
                        'tip.state.blocked': "You've blocked notifications",
                        'message.prenotify': 'Click to subscribe to notifications',
                        'message.action.subscribed': "Thanks for subscribing!",
                        'message.action.resubscribed': "You're subscribed to notifications",
                        'message.action.unsubscribed': "You won't receive notifications again",
                        'dialog.main.title': 'Manage Site Notifications',
                        'dialog.main.button.subscribe': 'SUBSCRIBE',
                        'dialog.main.button.unsubscribe': 'UNSUBSCRIBE',
                        'dialog.blocked.title': 'Unblock Notifications',
                        'dialog.blocked.message': "Follow these instructions to allow notifications:"
                    }
                }

            });

            OneSignal.sendTags({
                user_id: '<?php echo $current_id; ?>',
                device_type: 'web'
            });

            OneSignal.isPushNotificationsEnabled(function (isEnabled) {
                if (isEnabled) {
                } else {
                    OneSignal.showHttpPrompt();
                }
            });

            OneSignal.getUserId(function (userId) {  
            });

            OneSignal.getTags().then(function (tags) {
                
            });



        });


        /* Turn on the Slidedown Permission Message */
//        OneSignal.push(function() {
//            OneSignal.showHttpPrompt();
//        });

    </script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/1.5.1/socket.io.min.js"></script> 

    <script>

        var socket = io('<?php echo env('SOCKETS'); ?>');
        //   var socket = io('http://localhost:3000');
    </script>
    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <script>
        (adsbygoogle = window.adsbygoogle || []).push({
            google_ad_client: "ca-pub-3414425585257101",
            enable_page_level_ads: true
        });
    </script>


</head>

<!--<div class="loader-hb-wrapper">
    <div class="loader-hb-preloader">
        <img src="<?php echo asset('userassets/images/new_loadeer.svg') ?>" alt="Loader">
    </div>
</div>-->
