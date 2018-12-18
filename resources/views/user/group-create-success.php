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
                        <li>Congratulations!</li>
                    </ul>
                    <div class="congrts">
                        <h4>Congratulations!<span>Your New Group</span></h4>
                        <strong>Smoking'da bud</strong>
                        <p>has successfully been created.</p>
                        <a href="#" class="btn-primary">Invite bud</a>
                    </div>
                </div>
            </article>
        </div>

        <?php include('includes/footer-new.php'); ?>
    </body>

</html>