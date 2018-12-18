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
                            <div class="activity-area">
                                <div class="listing-area">
                            <!--<h1 class="custom-heading white text-center"><img src="<?php // echo asset('userassets/images/icon03.svg')  ?>" alt="Icon"><span class="top-padding">My Strains</span></h1>-->

                                    <ul class="journals list-none quest" id="strains_listing">
                                        <?php if (count($strains) > 0) { ?>
                                            <?php foreach ($strains as $key => $values) { ?>
                                                <div class="date-main-act">
                                                    <i class="fa fa-calendar"></i>
                                                    <span><?= $key ?></span>
                                                </div>
                                                <?php foreach ($values as $strain) { ?>
                                                    <li>
                                                        <input type="hidden" class="month_year" value="<?= $strain->month_year ?>">
                                                        <div class="q-txt">
                                                            <div class="q-text-a">
                                                                <a href="<?php echo asset('user-strain-detail?strain_id=' . $strain->strain_id . '&user_strain_id=' . $strain->id); ?>">
                                                                    <span><img src="<?php echo asset('userassets/images/act-s.png') ?>" alt="Icon"></span>
                                                                    <div class="my_answer">
                                                                        <?php echo $strain->getStrain->title; ?>
                                                                        <!--<em class="key Hybrid">H</em>-->
                                                                        <em class="key <?= $strain->getStrain->getType->title; ?>"><?= substr($strain->getStrain->getType->title, 0, 1); ?></em>
                                                                        <span class="hows-time"><?php echo timeago($strain->created_at); ?></span>
                                                                    </div>
                                                                </a>
                                                            </div>
                                                            <div class="head-ques" target="_blank">
                                                                <?php echo $strain->description; ?>
                                                                <span class="descrip"><?php echo $strain->note; ?></span>
                                                            </div>
                                                            <span class="how-time">
                    <!--                                            <a href="<?php // echo asset('edit-user-strain/'.$strain->id) ?>">
                                                                    <i class="fa fa-pencil" aria-hidden="true"></i> Edit
                                                                </a>-->
                                                                <!--<a href="#" data-toggle="modal" data-target="#delete_strain<?php echo $strain->id; ?>">-->
                                                                    <!--<i class="fa fa-trash-o" aria-hidden="true"></i> Delete-->
                                                                <!--</a>-->
                                                            </span>
                                                        </div>
                                                    </li>
                                                    <!-- Modal -->
                                                    <div class="modal fade" id="delete_strain<?php echo $strain->id; ?>" role="dialog">
                                                        <div class="modal-dialog">
                                                            <!-- Modal content-->
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                    <h4 class="modal-title">Delete Strain </h4>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <p>Are you sure to delete this Strain: <?php echo $strain->getStrain->title; ?></p>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <a href="<?php echo asset('delete-user-strain/' . $strain->id); ?>" type="button" class="btn-heal">yes</a>
                                                                    <button data-dismiss="modal" type="button" class="btn-heal">No</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Modal End-->
                                                <?php } ?>
                                            <?php }
                                        } else { ?>
                                            <div class="loader hb_not_more_posts_lbl" id="loading_strains">No more strains to show</div>
<?php } ?>
                                    </ul>
                                    <div style="display: none" class="hb_simple_loader" id="loading"><img src="<?php echo asset('userassets/images/new_loadeer.svg') ?>" alt="Loading . . . ." class="post-loader"><span></span></div>
                                </div>
                            </div>
                        </div>
                    </div>  <div class="right_sidebars">
                        <?php if(Auth::user()){  include 'includes/rightsidebar.php'; ?>
                        <?php include 'includes/chat-rightsidebar.php';} ?>
                    </div>
                </div>
            </article>
        </div>

        <!--        <div id="followers" class="popup">
                    <div class="popup-holder">
                        <div class="popup-area">
                            <div action="#" class="reporting-form add no-border new-popup">
                                <h2 class="white radius">Follower</h2>
                                <ul class="list-none popup-list">
    
                                </ul>
                                <a href="#" class="btn-close">x</a>
                            </div>
                        </div>
                    </div>
                </div>
        
                <div id="followings" class="popup">
                    <div class="popup-holder">
                        <div class="popup-area">
                            <div action="#" class="reporting-form add no-border new-popup">
                                <h2 class="white radius">Following</h2>
                                <ul class="list-none popup-list">

                                </ul>
                                <a href="#" class="btn-close">x</a>
                            </div>
                        </div>
                    </div>
                </div>-->
        <?php include('includes/footer.php'); ?>
<?php include('includes/functions.php'); ?>
    </body>
    <script>
        var win = $(window);
        var count = 1;
        var ajaxcall = 1;
        win.on('scroll', function () {
            var docheight = parseInt($(document).height());
            var winheight = parseInt(win.height());
            var differnce = (docheight - winheight) - win.scrollTop();
            if (differnce < 100) {
                if (ajaxcall === 1) {
                    $('#loading').show();
                    var last_month = $('.month_year').last().val();
                    ajaxcall = 0;
                    $.ajax({
                        url: "<?php echo asset('get-user-strains-loader/'.$user->id) ?>",
                        type: "GET",
                        data: {
                            "count": count,
                            "last_month": last_month
                        },
                        success: function (data) {
                            if (data) {
                                var a = parseInt(1);
                                var b = parseInt(count);
                                count = b + a;
                                $('#strains_listing').append(data);
                                $('#loading').hide();
                                ajaxcall = 1;
                            } else {
                                $('#loading_strains').hide();
                                $('#loading').hide();
                                noposts = ' <div class="loader hb_not_more_posts_lbl" id="nomoreposts">No more strains to show</div> ';
                                $('#strains_listing').append(noposts);
                            }
                        }
                    });
                }
                
            }
        });
    </script>
</html>