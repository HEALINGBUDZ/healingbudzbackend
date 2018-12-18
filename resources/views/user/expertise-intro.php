<!DOCTYPE html>
<html lang="en">
<?php include('includes/top.php');?>

<body>
    <div id="wrapper">
        <?php include('includes/sidebar.php');?>
        <article id="content">
            <?php include('includes/header.php');?>
            <div class="padding-div">
                <ul class="bread-crumbs list-none">
                    <li><a href="<?php echo asset('/'); ?>">Home</a></li>
                    <li><a href="question-answers.html">Q&amp;A</a></li>
                    <li>All</li>
                </ul>
                <div class="groups">
                    <header class="intro-header">
                        <img src="<?php echo asset('userassets/images/img10.png') ?>" alt="Banner Image">
                        <strong class="title">The Healing Budz community is all about budz helping budz.</strong>
                    </header>
                    <div class="intro-txt">
                        <p>A bud asks the community a question...</p>
                        <p>Budz with Experience in that area are notified to supply an answer.</p>
                    </div>
                    <footer class="intro-footer">
                        <p>By indicating your Experience areas. we can notify you via push notifications. when another bud needs your help in that specific area.</p>
                        <p>Be someone's hero.</p>
                        <a href="<?php echo asset('expertise-edit'); ?>" class="btn-primary green">Add Your Experience Areas</a><br>
                        <a href="#" class="btn-remind-later">Remind me later <i class="fa fa-angle-right" aria-hidden="true"></i></a>
                    </footer>
                </div>
            </div>
        </article>
    </div>
    <?php include('includes/footer.php');?>
</body>

</html>