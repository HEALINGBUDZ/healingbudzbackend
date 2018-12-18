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
                                <span class="set-onoff-left">Entry Reminder</span>
                                <div class="onoff">
                                    <label for="onOff">
                                        <input type="checkbox" value="None" id="onOff" name="check" checked="" />
                                        <span></span>
                                    </label>
                                </div>
                            </li>
                            <li>
                                Select time and days when you want to notified to write in your Journal.
                                <span class="big-time">08:00 PM</span>
                                <div class="days">
                                    <span>SUN</span>
                                    <span class="active">MON</span>
                                    <span class="active">TUE</span>
                                    <span class="active">WED</span>
                                    <span class="active">THU</span>
                                    <span>FRI</span>
                                    <span>SAT</span>
                                </div>
                            </li>
                            <li>
                                <span class="set-onoff-left">Mute sound</span>
                                <div class="onoff">
                                    <label for="onOff">
                                        <input type="checkbox" value="None" id="onOff" name="check" />
                                        <span></span>
                                    </label>
                                </div>
                            </li>
                            <li>
                                <span class="set-onoff-left">Don't notify if entry was created on the same day</span>
                                <div class="onoff">
                                    <label for="onOff">
                                        <input type="checkbox" value="None" id="onOff" name="check" checked="" />
                                        <span></span>
                                    </label>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </article>
        </div>
        <?php include('includes/footer-new.php'); ?>

    </body>

</html>