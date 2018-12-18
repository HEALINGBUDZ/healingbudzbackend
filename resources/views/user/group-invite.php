<!DOCTYPE html>
<html lang="en">
    <?php include('includes/top-new.php'); ?>
    <body id="body">
        <div id="wrapper">
        <?php include('includes/sidebar.php'); ?>
            <article id="content">
                <?php include('includes/header.php'); ?>
                <div class="padding-div">
                    <ul class="bread-crumbs list-none">
                        <li><a href="<?php echo asset('/'); ?>">Home</a></li>
                        <li>Invite bud to group</li>
                    </ul>
                    <form action="#" class="invite-group">
                        <fieldset>
                            <h2>Invite bud to group</h2>
                            <strong>Begin typing a Budz Name or Email to search</strong>
                            <input type="text">
                            <div class="or-row"><span>or</span></div>
                            <strong>Invite  via email address</strong>
                            <input type="text">
                            <div class="or-row"><span>or</span></div>
                            <strong>Invite via text message</strong>
                            <p>Add Phone Number Below</p>
                            <input type="text">
                            <input type="submit" value="Invite new bud">
                        </fieldset>
                    </form>
                </div>
            </article>
        </div>

        <?php include('includes/footer-new.php'); ?>
    </body>

</html>