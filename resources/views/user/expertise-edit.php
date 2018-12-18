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
                        <h1 class="custom-heading">Your Experience</h1>
                        <div class="edit-holder">
                            <div class="step">
                                <div class="step-header">
                                    <h4>Question 1/2</h4>
                                    <p>Which conditions or ailments have you treated with cannabis?</p>
                                </div>
                                <form action="#" class="edit-search-form">
                                    <fieldset>
                                        <h3><span>Add up to 5</span></h3>
                                        <ul class="condition-list list-none">
                                            <li>Anxiety</li>
                                        </ul>
                                        <div class="edit-search-area">
                                            <span>Begin typing a medical condition to search</span>
                                            <input type="search">
                                        </div>
                                    </fieldset>
                                </form>
                            </div>
                            <div class="step">
                                <div class="step-header">
                                    <h4>Question 2/2</h4>
                                    <p>Which conditions or ailments have you treated with cannabis?</p>
                                </div>
                                <form action="#" class="edit-search-form">
                                    <fieldset>
                                        <h3><span>Add up to 5</span></h3>
                                        <ul class="condition-list list-none">
                                            <li>Anxiety</li>
                                        </ul>
                                        <div class="edit-search-area">
                                            <span>Begin typing a medical condition to search</span>
                                            <input type="search">
                                        </div>
                                    </fieldset>
                                </form>
                            </div>
                            <a href="complete-profile.html" class="btn-primary green">Add Your Experience Areas</a><br>
                            <a href="#" class="btn-remind-later">Remind me later <i class="fa fa-angle-right" aria-hidden="true"></i></a>
                        </div>
                    </header>
                </div>
            </div>
        </article>
    </div>
    <?php include('includes/footer.php');?>
</body>

</html>