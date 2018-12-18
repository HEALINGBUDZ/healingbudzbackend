<!DOCTYPE html>
<html lang="en">
    <?php include('includes/top-new.php'); ?>
    <body class="settings-page">
        <div id="wrapper">
            <?php include('includes/sidebar.php'); ?>
            <article id="content">
                <?php include('includes/header.php'); ?>
                <div class="padding-div">
                    <div class="new_container">
                        <header class="intro-header no-bg">
                            <h1 class="custom-heading white">Settings</h1>
                        </header>
                        <div class="set-main-ul">
                        <ul>
                            <li>
                                <a href="<?php echo asset('profile-setting');?>">Profile Settings</a>
                            </li>
                            <li>
                                <a href="<?php echo asset('business-settings')?>">Business Listing Settings</a>
                            </li>
<!--                            <li>
                                <a href="<?php // echo asset('journal-settings')?>">Journal Settings</a>
                            </li>-->
                            <li>
                                <a href="<?php echo asset('notifications-settings')?>">Notifications & Alerts</a>
                            </li>
<!--                            <li>
                                <span class="set-onoff-left">Enable First Launch Overview Screens
                                    <span class="set-onoff-in">On next app launch. requires app restart.</span>
                                </span>
                                <div class="onoff">
                                    <label for="onOff">
                                        <input type="checkbox" value="None" id="onOff" name="check" />
                                        <span></span>
                                    </label>
                                </div>
                            </li>-->
                        </ul>
                    </div>
                    </div>
                    <div class="right_sidebars">
                        <?php include 'includes/rightsidebar.php'; ?>
                        <?php include 'includes/chat-rightsidebar.php';?>
                    </div>
                </div>
            </article>
        </div>
        <?php include('includes/footer-new.php'); ?>

    </body>

</html>