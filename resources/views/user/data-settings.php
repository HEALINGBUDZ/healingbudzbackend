<!DOCTYPE html>
<html lang="en">
    <?php include('includes/top-new.php'); ?>
    <body class="settings-page">
        <div id="wrapper">
            <?php include('includes/sidebar.php'); ?>
            <article id="content">
                <?php include('includes/header.php'); ?>
                <div class="padding-div">
                    <div class="set-main-ul">
                        <ul>
                            <li>
                                <span class="set-onoff-left">Wifi only
                                    <span class="set-onoff-in">Sync only when connected to Wi-fi</span>
                                </span>
                                <div class="onoff">
                                    <label for="onOff">
                                        <input type="checkbox" value="None" id="onOff" name="check" checked="" />
                                        <span></span>
                                    </label>
                                </div>
                            </li>
                            <li>
                                <span class="set-onoff-left">Show sync notification
                                    <span class="set-onoff-in">Show sync notification when the app is in background</span>
                                </span>
                                <div class="onoff">
                                    <label for="onOff">
                                        <input type="checkbox" value="None" id="onOff" name="check" checked="" />
                                        <span></span>
                                    </label>
                                </div>
                            </li>
                            <li>
                                Data Backup & restore
                                <a href="#" class="dropbox"><img src="<?php echo asset('userassets/images/dropbox.png') ?>" alt="dropbox" /></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </article>
        </div>
        <?php include('includes/footer-new.php'); ?>

    </body>

</html>