<!DOCTYPE html>
<html lang="en">
    <?php include('includes/top-new.php'); ?>
    <body class="strains-page">
        <div id="wrapper">
            <?php include('includes/sidebar.php'); ?>
            <article id="content">
                <?php include('includes/header.php'); ?>
                <div class="padding-div">
                    <header class="intro-header no-bg">
                        <h1 class="custom-heading white">MY JOURNAL</h1>
                    </header>
                   <?php include('includes/journal-info.php'); ?>
                   <ul class="j-tags list-none">
                       <?php foreach ($journals_tags as $journals_tag){ ?>
                       <li><?php echo $journals_tag->title;?> <em><?php echo $journals_tag->tagCount->count();?></em></li>
                       <?php } ?>
                   </ul>
                   <div class="query">
                       <header class="header">
                           <span class="active"><i class="fa fa-tag" aria-hidden="true"></i> cannabis oil</span>
                           <span><i class="fa fa-pencil" aria-hidden="true"></i> 3</span>
                       </header>
<!--                       <article class="query-post">
                           <div class="date">
                               <strong>WE <br><span>01</span><br> FEB</strong>
                               <em>05:30 PM</em>
                           </div>
                           <div class="text">
                               <div class="photo"><img src="<?php echo asset('userassets/images/photo.png') ?>" alt="icons" /></div>
                               <div class="txt">
                                   <strong class="title">First Day of Treatment</strong>
                                   <p>Today I started using Cannabis as a treatment</p>
                                   <div class="info-icons">
                                       <div><i class="fa fa-picture-o" aria-hidden="true"></i> 2</div>
                                       <div><i class="fa fa-video-camera" aria-hidden="true"></i> 1</div>
                                       <div><i class="fa fa-tags" aria-hidden="true"></i> 5</div>
                                   </div>
                               </div>
                           </div>
                       </article>-->
                   </div>
                </div>
            </article>
        </div>
        <?php include('includes/footer-new.php'); ?>
    </body>
</html>