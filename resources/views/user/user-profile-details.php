<!DOCTYPE html>
<html lang="en">
    <?php include('includes/top-new.php'); ?>
    <body>
        <div id="wrapper">
            <?php include('includes/sidebar.php'); ?>
            <article id="content">
                <?php include('includes/header.php'); ?>
                <div class="padding-div">
                    <div class="new_container">
                        <ul class="bread-crumbs list-none">
                            <li><a href="<?php echo asset('/'); ?>">Home</a></li>
                            <!--<li><a href="<?php // echo asset('questions');     ?>">Q&amp;A</a></li>-->
                            <li>Profile</li>
                        </ul>
                        <div class="profile-area">
                            
                            <?php include 'includes/user-profile-header.php'; ?>
                            <div class="activity-area edit-area">
                                <div class="edit-pro-form">
                                    <input type="hidden" name="_token" value="">
                                    <div class="right_content">
                                        <div class="edit-pro-exp">
                                            <header class="header">
                                                <strong class="title">My Experience</strong>
                                            </header>
                                            <ul class="ab-exp-ul">
                                                <?php
                                                if(count($medical_use_experties) > 0 ){ 
                                                foreach ($medical_use_experties as $experty) { ?>
                                                    <li>
                                                        <?php if($experty->is_approved == 0) { ?>
                                                            <i class="fa fa-exclamation-triangle" title="Submitted for approval" style="color: #f4c42f;"></i>
                                                        <?php } ?>
                                                        <span><?php echo $experty->medical->m_condition ?></span>
                                                    </li>
                                                <?php }}else{  ?>
                                                    <li>None listed.</li>
                                                <?php } ?>
                                            </ul>
                                        </div>
                                        <div class="edit-pro-exp">
                                            <header class="header">
                                                <strong class="title">My Top <?= $strain_experties->count()?> Strain<?php if($strain_experties->count() !=1){ ?>s <?php } ?></strong>
                                            </header>
                                            <ul class="ab-exp-ul">
                                                <?php
                                                if(count($strain_experties) > 0 ){ 
                                                foreach ($strain_experties as $s_experty) { ?>
                                                    <li>
                                                        <?php if($s_experty->is_approved == 0) { ?>
                                                            <i class="fa fa-exclamation-triangle" title="Submitted for approval" style="color: #f4c42f;"></i>
                                                        <?php } ?>
                                                        <span><?php echo $s_experty->strain->title ?></span>
                                                    </li>
                                                <?php }}else{  ?>
                                                    <li>None listed.</li>
                                                <?php } ?>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="left_content">
                                        <header class="header">
                                            <strong class="title">About</strong>
                                        </header>
                                        <div class="edit-pro-prof">
                                            <?php if($user->bio) { ?>
                                            <div>
                                                <pre style="background: transparent; color: white; border: none; white-space: pre-line;"><p><?= $user->bio ?></p></pre></div>
                                            <?php } else { ?>
                                            <span>No biography available.</span>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div> </div>
                    <div class="right_sidebars">
                        <?php if($current_user){ include 'includes/rightsidebar.php'; ?>
                        <?php include 'includes/chat-rightsidebar.php';} ?>
                    </div>
            </article>
        </div>


        <?php include('includes/footer.php'); ?>
        <?php include('includes/functions.php'); ?>
    </body>
    <script>
        $(document).ready(function () {
            $(".budz_rating").starRating({
                totalStars: 5,
                emptyColor: '#1e1e1e',
                hoverColor: '#e070e0',
                activeColor: '#e070e0',
                strokeColor: "#e070e0",
                strokeWidth: 20,
                useGradient: false,
                readOnly: true,
                useFullStars:true,
                    initialRating:5,
                callback: function (currentRating, $el) {
                    alert('rated ' + currentRating);
                }
            });
        });


    </script>
</html>