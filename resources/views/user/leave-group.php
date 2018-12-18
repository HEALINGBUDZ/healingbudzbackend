<!DOCTYPE html>
<html lang="en">
    <?php include('includes/top-new.php'); ?>
    <body class="strains-page">
        <div id="wrapper">
            <?php include('includes/sidebar.php'); ?>
            <article id="content">
                <?php include('includes/header-journal.php'); ?>
                <div class="padding-div">
                    <div class="groups add">
                        <header class="intro-header">
                            <h1 class="custom-heading orange no-margin">California Healing</h1>
                            <h2>Settings</h2>
                        </header>
                        <form action="#" class="chat-setting">
                            <fieldset>
                                <div class="on-off">
                                    <span>Mute Notifications</span>
                                    <div class="onoff right">
                                        <label for="onOff">
                                            <input type="checkbox" value="None" id="onOff" name="check">
                                            <span></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="checks">
                                    <span>Mute for...</span>
                                    <div class="row">
                                        <input type="radio" id="1hr" name="group2">
                                        <label for="1hr">1 hour</label>
                                    </div>
                                    <div class="row">
                                        <input type="radio" id="2hr" name="group2">
                                        <label for="2hr">2 hours</label>
                                    </div>
                                    <div class="row">
                                        <input type="radio" id="3hr" name="group2">
                                        <label for="3hr">3 hours</label>
                                    </div>
                                    <div class="row">
                                        <input type="radio" id="mute-untill" name="group2">
                                        <label for="mute-untill">Mute Until 8 AM</label>
                                    </div>
                                    <div class="row">
                                        <input type="radio" id="mute-forever" name="group2">
                                        <label for="mute-forever">Mute Forever</label>
                                    </div>
                                </div>
                                <input type="submit" class="btn-primary orange" value="Leave Group">
                            </fieldset>
                        </form>
                    </div>
                </div>
            </article>
        </div>
        <?php include('includes/footer-new.php'); ?>
    </body>
</html>