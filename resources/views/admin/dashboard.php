<!DOCTYPE html>
<html lang="en">
    <?php include resource_path('views/admin/includes/head.php'); ?>
    <body>
        <?php include resource_path('views/admin/includes/header.php'); ?>
        <?php include resource_path('views/admin/includes/sidebar.php'); ?>
        <section class="content lifeContent">
            <div class="">
                <div class="row">
                    <div class="col-md-3 col-sm-6">
                        <a href="<?php echo asset('show_users') ?>">
                            <div class="statbox info statisticsbox">
                                <div class="row">
                                    <div class="col-md-8 col-sm-8 col-xs-12"><span class="stat-heading">Users</span></div>
                                    <div class="col-md-4 col-sm-4 col-xs-12 stat-icon"><i class="fa fa-user" aria-hidden="true"></i></div>
                                </div>
                                <div class="stat-title">Total User: <?= $users_count ?></div>
                                <div class="stat-info">Web: <?= $web_users_count ?></div>
                                <div class="stat-info">Mobile: <?= $mobile_users_count ?></div>
                                <div class="stat-info">Social: <?= $social_users_count ?></div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <a href="#">
                            <div class="statbox info statisticsbox">
                                <div class="row">
                                    <div class="col-md-8 col-sm-8 col-xs-12"><span class="stat-heading">Groups</span></div>
                                    <div class="col-md-4 col-sm-4 col-xs-12 stat-icon"><i class="fa fa-users" aria-hidden="true"></i></div>
                                </div>
                                <div class="stat-title">Total Groups: <?= $groups_count ?></div>
                                <div class="stat-info">Public: <?= $public_groups_count ?></div>
                                <div class="stat-info">Private: <?= $private_groups_count ?></div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <a href="<?php echo asset('user_questions') ?>">
                            <div class="statbox info statisticsbox">
                                <div class="row">
                                    <div class="col-md-8 col-sm-8 col-xs-12"><span class="stat-heading">Questions</span></div>
                                    <div class="col-md-4 col-sm-4 col-xs-12 stat-icon"><i class="fa fa-question" aria-hidden="true"></i></div>
                                </div>
                                <div class="stat-title">Total Questions: <?= $questions_count ?></div>
                                <div class="stat-info">Answered: <?= $answered_questions_count ?></div>
                                <div class="stat-info">Unanswered: <?= $unanswered_questions_count ?></div>
                            </div>
                        </a>
                    </div>
                    <!--            <div class="col-md-3 col-sm-6">
                                    <a href="<?php echo asset('admin_journals') ?>">
                                        <div class="statbox info statisticsbox">
                                            <div class="row">
                                                <div class="col-md-8 col-sm-8 col-xs-12"><span class="stat-heading">Journals</span></div>
                                                <div class="col-md-4 col-sm-4 col-xs-12 stat-icon"><i class="fa fa-calendar-check-o" aria-hidden="true"></i></div>
                                            </div>
                                            <div class="stat-title">Total Journals: <?= $journals_count ?></div>
                                            <div class="stat-info">Public: <?= $public_journals_count ?></div>
                                            <div class="stat-info">Private: <?= $private_journals_count ?></div>
                                        </div>
                                    </a>
                                </div>-->
                    <!--        </div>
                            <hr>
                            <div class="row">-->
                    <div class="col-md-3 col-sm-6">
                        <a href="<?php echo asset('strains') ?>">
                            <div class="statbox info statisticsbox">
                                <div class="row">
                                    <div class="col-md-8 col-sm-8 col-xs-12"><span class="stat-heading">Strains</span></div>
                                    <div class="col-md-4 col-sm-4 col-xs-12 stat-icon"><i class="fa fa-leaf" aria-hidden="true"></i></div>
                                </div>
                                <div class="stat-title">Total Strains: <?= $strains_count ?></div>
                                <!--<div class="stat-info">User Strains: 50</div>-->
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <a href="<?php echo asset('strains') ?>">
                            <div class="statbox info statisticsbox">
                                <div class="row">
                                    <div class="col-md-8 col-sm-8 col-xs-12"><span class="stat-heading">Approval</span></div>
                                    <div class="col-md-4 col-sm-4 col-xs-12 stat-icon"><i class="fa fa-leaf" aria-hidden="true"></i></div>
                                </div>
                                <div class="stat-title">Strain Images: <span <?php if($not_approved){ ?> style="color:red" <?php } ?>><?= $not_approved ?></span></div>
                                <!--<div class="stat-info">User Strains: 50</div>-->
                            </div>
                        </a>
                    </div>
                    
                    <div class="col-md-3 col-sm-6">
                        
                            <div class="statbox info statisticsbox">
                                <div class="row">
                                    <div class="col-md-8 col-sm-8 col-xs-12"><span class="stat-heading">Flagged</span></div>
                                    <div class="col-md-4 col-sm-4 col-xs-12 stat-icon"><i class="fa fa-question" aria-hidden="true"></i></div>
                                </div>
                                <div class="stat-title">Total Flagged: <?= getFlagCountSubUserReviews()+ getFlagCountSubUser()+ getFlagCountPosts()+ getFlagCountQuestion()+ getFlagCountAnswers()+ getFlagCountStainReviews()+ getFlagCountStainImages() ?></div>
                                <a href="<?= asset('/flagged_business_reviews')?>"><div class="stat-info" style="color: white">Business Reviews:<span <?php if(getFlagCountSubUserReviews()){ ?> style="color:red" <?php } ?>> <?= getFlagCountSubUserReviews() ?></span></div></a>
                                <a href="<?= asset('/flagged_business')?>"><div class="stat-info" style="color: white">Business: <span  <?php if(getFlagCountSubUser()){ ?> style="color:red" <?php } ?>> <?= getFlagCountSubUser() ?></span></div></a>
                                <a href="<?= asset('/flagged_posts')?>"><div class="stat-info" style="color: white">Posts:<span <?php if(getFlagCountPosts()){ ?> style="color:red" <?php } ?>>  <?= getFlagCountPosts() ?></span></div></a>
                                <a href="<?= asset('/flagged_questions')?>"><div class="stat-info" style="color: white">Questions:<span <?php if(getFlagCountQuestion()){ ?> style="color:red" <?php } ?>>  <?= getFlagCountQuestion() ?></span></div></a>
                                <a href="<?= asset('/flagged_answers')?>"><div class="stat-info" style="color: white">Answers:<span  <?php if(getFlagCountAnswers()){ ?> style="color:red" <?php } ?>>  <?= getFlagCountAnswers() ?></span></div></a>
                                <a href="<?= asset('/strain_flagged_reviews')?>"><div class="stat-info" style="color: white">Strain Reviews:<span  <?php if(getFlagCountStainReviews()){ ?> style="color:red" <?php } ?>>  <?= getFlagCountStainReviews() ?></span></div></a>
                                <a href="<?= asset('/strain_flagged_images')?>"><div class="stat-info" style="color: white">Strain Images:<span  <?php if(getFlagCountStainImages()){ ?> style="color:red" <?php } ?>>  <?= getFlagCountStainImages() ?></span></div></a>
                            </div>
                       
                    </div>
                </div> 
            </div>
        </section>
        <?php include resource_path('views/admin/includes/footer.php'); ?>


    </body>
</html>