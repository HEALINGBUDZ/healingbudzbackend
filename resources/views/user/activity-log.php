<!DOCTYPE html>
<html lang="en">
    <?php include('includes/top.php'); ?>
    <body>
        <div id="wrapper">
            <?php include('includes/sidebar.php'); ?>
            <article id="content">
                <?php include('includes/header.php'); ?>
                <div class="padding-div">
                    <div class="new_container">
                        <ul class="bread-crumbs list-none">
                            <li><a href="<?php echo asset('/'); ?>">Home</a></li>
                            <li>Activity Log</li>
                        </ul>
                        <div class="activity-log-header">
                            <div class="search-area">
                                <h2 class="hb_page_top_title hb_text_blue hb_text_uppercase">Your Activity Log</h2>
                                <div class="sort-dropdown">
                                    <div class="form-holder">
                                        <form action="<?php echo asset('sort-activity'); ?>" id="sort_activity">
                                            <fieldset>
                                                <select name="sorting" id="sorting_value">
                                                    <?php if (isset($_GET['sorting'])) { ?>
                                                        <option value="<?php echo $_GET['sorting']; ?>" selected=""><?php echo $_GET['sorting']; ?> </option>
                                                    <?php } else { ?>
                                                        <option value="" selected="">Activity Log Filter</option>
                                                    <?php } ?>
                                                </select>
                                            </fieldset>
                                        </form>
                                        <a href="#" class="options-toggler opener gray"><i class="fa fa-caret-down" aria-hidden="true"></i></a>
                                    </div>
                                    <div class="options gray">
                                        <ul class="list-none">
                                            <!--                                            <li>
                                                                                            <img src="<?php echo asset('userassets/images/opt1.png') ?>" alt="Question">
                                                                                            <span>Questions</span>
                                                                                        </li>-->
                                            <li>
                                                <img src="<?php echo asset('userassets/images/opt2.png') ?>" alt="Answer">
                                                <span>Answers</span>
                                            </li>
                                            <li>
                                                <img src="<?php echo asset('userassets/images/opt3.png') ?>" alt="Unanswered">
                                                <span>Favorites</span>
                                            </li>
                                            <li>
                                                <img src="<?php echo asset('userassets/images/opt4.png') ?>" alt="Likes">
                                                <span>Likes</span>
                                            </li>
                                            <li>
                                                <img src="<?php echo asset('userassets/images/com-icon.png') ?>" alt="Comment">
                                                <span>Comments</span>
                                            </li>
                                            <li>
                                                <img src="<?php echo asset('userassets/images/post-icon.png') ?>" alt="Post">
                                                <span>Posts</span>
                                            </li>
                                            <!--                                    <li>
                                                                                    <img src="<?php echo asset('userassets/images/opt5.png') ?>" alt="My Answers">
                                                                                    <span>GROUPS</span>
                                                                                </li>-->
                                            <!--                                            <li>
                                                                                            <img src="<?php echo asset('userassets/images/icon04.png') ?>" alt="My Answers">
                                                                                            <span>JOURNAL</span>
                                                                                        </li>-->
                                            <!--                                            <li>
                                                                                            <img src="<?php echo asset('userassets/images/opt5.png') ?>" alt="My Answers">
                                                                                            <span>Tags</span>
                                                                                        </li>-->
                                            <!--                                            <li>
                                                                                            <img src="<?php echo asset('userassets/images/opt6.png') ?>" alt="My Answers">
                                                                                            <span>BUDZ ADZ</span>
                                                                                        </li>-->
                                            <li>
                                                <img src="<?php echo asset('userassets/images/opt7.png') ?>" alt="Strains">
                                                <span>Strains</span>
                                            </li>
                                        </ul>
                                        <a href="#" class="options-toggler closer gray"><i class="fa fa-caret-down" aria-hidden="true"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="activities-log">
                            <!--                            <div class="date-main-act">
                                                            <i class="fa fa-calendar"></i>
                                                            <span>February 2018</span>
                                                        </div>-->
                            <ul class="activities list-none sp-ab" id="activity_logs">
                                <?php if (count($activities) > 0) { ?>
                                    <?php foreach ($activities as $key => $values) { ?>
                                        <div class="date-main-act">
                                            <i class="fa fa-calendar"></i>
                                            <span><?= $key ?></span>
                                        </div>
                                        <?php
                                        foreach ($values as $activity) {
                                            $url = 'javascript:void(0)';
                                            if ($activity->model == 'Question' || $activity->model == 'Answer') {
                                                $url = asset('get-question-answers/' . $activity->type_id);
                                            }
                                            if ($activity->model == 'UserPost') {
                                                $url = asset('get-post/' . $activity->type_id);
                                            }
                                            if ($activity->model == 'SubUser') {
                                                $subuser = getSubUser($activity->type_id);
                                                if($subuser){
                                                    $url = asset('get-budz?business_id=' . $activity->type_id . '&business_type_id=' . $subuser->business_type_id);
                                                }
                                            }
                                            if ($activity->model == 'Strain') {
                                                $url = asset('strain-details/' . $activity->type_id);
                                            }
                                            if ($activity->model == 'Group') {
                                                $url = asset('group-chat/' . $activity->type_id);
                                            }
                                            if ($activity->model == 'GroupMessage') {
                                                $url = asset('group-chat/' . $activity->type_id);
                                            }
                                            if ($activity->model == 'GroupFollower') {
                                                $url = asset('group-chat/' . $activity->type_id);
                                            }
                                            if ($activity->type == 'Journal' || $activity->model == 'JournalFollowing') {
                                                $url = asset('journal-details/' . $activity->type_id);
                                            }
//                                if ($activity->model == 'Tag') {
//                                    $url = 'javascript:void(0)';
//                                }
//                                if ($activity->model == 'ShoutOutLike') { 
//                                    $business_id = $activity->type_id;
//                                    $business_type_id = getBusinessTypeId($activity->type_id);
//                                    $url = asset('get-budz?business_id=' . $business_id.'&business_type_id='.$business_type_id);
//                                }
                                            if ($activity->model == 'UserStrainLike') {
                                                $url = asset('user-strain-detail?strain_id=' . $activity->type_id . '&user_strain_id=' . $activity->type_sub_id);
                                            }
                                            ?>
                                            <?php if ($activity->type == 'Strains') { ?>
                                                <li>
                                                    <input type="hidden" class="month_year" value="<?= $activity->month_year ?>">
                                                    <div class="icon"><img src="<?php echo asset('userassets/images/act-s.png') ?>" alt="My Answers"></div>
                                                    <div class="txt">
                                                        <a href="<?php echo asset('strain-details/' . $activity->type_id); ?>"> 
                                                            <div class="title">
                                                                <strong class="dark-blue new-strong-color"><?= $activity->text ?></strong>
                                                                <div class="txt-btn">
                                                                    <span>
                                                                        <i class="fa fa-external-link"></i>
                                                                  <?php $des=preg_replace("/<a[^>]+\>/i", "", $activity->description);echo str_replace('</a>','',$des); ?>
                                                                    </span>
                                                                </div>
                                                                <em class="time"><?php echo timeago($activity->created_at); ?></em>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </li>
                                            <?php } if ($activity->type == 'Budz Map') { ?>
                                                <!--                                    <li>
                                                                                        <input type="hidden" class="month_year" value="<?= $activity->month_year ?>">
                                                                                        <div class="icon"> <img src="<?php echo asset('userassets/images/folded-newspaper.svg') ?>" alt="My Answers"></div>
                                                                                        <div class="txt">
                                                                                            <a href="<?php echo asset('get-budz/' . $activity->type_id); ?>"> 
                                                                                                <div class="title">
                                                                                                    <strong class="dark-blue new-strong-color"><?= $activity->text ?></strong>
                                                                                                    <div class="txt-btn">
                                                                                                        <span>
                                                                                                            <i class="fa fa-external-link"></i>
                                                <?php $des=preg_replace("/<a[^>]+\>/i", "", $activity->description);echo str_replace('</a>','',$des); ?>
                                                                                                        </span>
                                                                                                    </div>
                                                                                                    <em class="time"><?php echo timeago($activity->created_at); ?></em>
                                                                                                </div>
                                                                                            </a>
                                                                                        </div>
                                                                                    </li>-->
                                            <?php } if ($activity->type == 'Questions') { ?>
                                                <!--                                    <li>
                                                                                        <input type="hidden" class="month_year" value="<?= $activity->month_year ?>">
                                                                                        <div class="icon"><img src="<?php echo asset('userassets/images/act-q.png') ?>" alt="My Answers"></div>
                                                                                        <div class="txt">
                                                                                            <a href="<?php echo asset('get-question-answers/' . $activity->type_id); ?>"> 
                                                                                                <div class="title">
                                                                                                    <strong class="dark-blue new-strong-color"><?= $activity->text ?></strong>
                                                                                                    <div class="txt-btn">
                                                                                                        <span>
                                                                                                            <i class="fa fa-external-link"></i>
                                                <?php $des=preg_replace("/<a[^>]+\>/i", "", $activity->description);echo str_replace('</a>','',$des); ?>
                                                                                                        </span>
                                                                                                    </div>
                                                                                                    <em class="time"><?php echo timeago($activity->created_at); ?></em>
                                                                                                </div>
                                                                                            </a>  
                                                                                        </div>
                                                                                    </li>-->
                                            <?php } if ($activity->type == 'Answers') { ?>
                                                <li>
                                                    <input type="hidden" class="month_year" value="<?= $activity->month_year ?>">
                                                    <div class="icon"><img src="<?php echo asset('userassets/images/act-a.png') ?>" alt="My Answers"></div>
                                                    <div class="txt">
                                                        <a href="<?php echo asset('get-question-answers/' . $activity->type_id); ?>"> 
                                                            <div class="title">
                                                                <strong class="dark-blue new-strong-color"><?= $activity->text ?></strong>
                                                                <div class="txt-btn">
                                                                    <span>
                                                                        <i class="fa fa-external-link"></i>
                                                                        <?php   $des=preg_replace("/<a[^>]+\>/i", "", $activity->description);echo str_replace('</a>','',$des); ?>
                                                                    </span>
                                                                </div>
                                                                <em class="time"><?php echo timeago($activity->created_at); ?></em>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </li>
                                            <?php } if ($activity->type == 'Likes') { ?>
                                                <li>
                                                    <input type="hidden" class="month_year" value="<?= $activity->month_year ?>">
                                                    <div class="icon"><img src="<?php echo asset('userassets/images/act-l.png') ?>" alt="My Answers"></div>
                                                    <div class="txt">
                                                        <a href="<?= $url; ?>">
                                                            <div class="title">
                                                                <strong class="dark-blue new-strong-color"><?= $activity->text ?></strong>
                                                                <div class="txt-btn">
                                                                    <span>
                                                                        <i class="fa fa-external-link"></i>
                                                                        <?php if($activity->description){  echo preg_replace("/<a[^>]+\>/i", "", $activity->description);}else{echo 'No like description found';} ?>
                                                                    </span>
                                                                </div>
                                                                <em class="time"><?php echo timeago($activity->created_at); ?></em>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </li>
                                            <?php } if ($activity->type == 'Favorites') { ?>
                                                <li>
                                                    <input type="hidden" class="month_year" value="<?= $activity->month_year ?>">
                                                    <div class="icon"><img src="<?php echo asset('userassets/images/act-f.png') ?>" alt="My Answers"></div>
                                                    <div class="txt">
                                                        <a href="<?= $url; ?>">
                                                            <div class="title">
                                                                <strong class="dark-blue new-strong-color"><?= $activity->text ?></strong>
                                                                <div class="txt-btn">
                                                                    <span>
                                                                        <i class="fa fa-external-link"></i>
                                                                        <?=   preg_replace("/<a[^>]+\>/i", "", $activity->description); ?>
                                                                    </span>
                                                                </div>
                                                                <em class="time"><?php echo timeago($activity->created_at); ?></em>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </li>
                                                <?php //} if ($activity->type == 'Journal') { ?>
                                                <!--                                    <li>
                                                                                        <div class="icon"><img src="<?php echo asset('userassets/images/icon04.png') ?>" alt="My Answers"></div>
                                                                                        <div class="txt">
                                                                                            <a href="<?= $url ?>" >
                                                                                                <div class="title">
                                                                                                    <em class="time"><?php //echo date('m.d.y h:i A', strtotime($activity->created_at));  ?></em>
                                                                                                    <em class="time"><?php echo timeago($activity->created_at); ?></em>
                                                                                                    <strong class="green"><?= $activity->text ?></strong>
                                                                                                </div>
                                                                                                <div class="txt-btn">
                                                                                                    <span><?=   preg_replace("/<a[^>]+\>/i", "", $activity->description); ?></span>
                                                                                                </div>
                                                                                            </a>
                                                                                        </div>
                                                                                    </li>-->
                                                <?php //} if ($activity->type == 'Groups') { ?>
                                                <!--                                    <li>
                                                                                        <div class="icon"><img src="<?php echo asset('userassets/images/icon02.png') ?>" alt="My Answers"></div>
                                                                                        <a href="<?= $url ?>" >
                                                                                            <div class="txt">
                                                                                                <div class="title">
                                                                                                    <em class="time"><?php //echo date('m.d.y h:i A', strtotime($activity->created_at));  ?></em>
                                                                                                    <em class="time"><?php echo timeago($activity->created_at); ?></em>
                                                                                                    <strong class="yellow"><?= $activity->text ?></strong>
                                                                                                </div>
                                                                                                <div class="txt-btn">
                                                                                                    <span><?=   preg_replace("/<a[^>]+\>/i", "", $activity->description); ?></span>
                                                                                                </div>
                                                                                            </div>
                                                                                        </a>
                                                                                    </li>-->
                                            <?php } if ($activity->type == 'Tags') { ?>
                                                <!--                                    <li>
                                                                                        <input type="hidden" class="month_year" value="<?= $activity->month_year ?>">
                                                                                        <div class="icon"><img src="<?php echo asset('userassets/images/hash.png') ?>" alt="My Answers"></div>
                                                                                        <a href="<?= $url ?>" >
                                                                                            <div class="txt">
                                                                                                <div class="title">
                                                                                                    <strong class="dark-blue new-strong-color"><?= $activity->text ?></strong>
                                                                                                    <div class="txt-btn">
                                                                                                        <span>
                                                                                                            <i class="fa fa-external-link"></i>
                                                <?=   preg_replace("/<a[^>]+\>/i", "", $activity->description); ?>
                                                                                                        </span>
                                                                                                    </div>
                                                                                                    <em class="time"><?php echo timeago($activity->created_at); ?></em>
                                                                                                </div>
                                                                                            </div>
                                                                                        </a>
                                                                                    </li>-->
                                            <?php } if ($activity->type == 'Post') { ?>
                                                <li>
                                                    <input type="hidden" class="month_year" value="<?= $activity->month_year ?>">
                                                    <div class="icon"><img src="<?php echo asset('userassets/images/side-social-icon.png') ?>" alt="My Posts"></div>
                                                    <a href="<?= $url ?>" >
                                                        <div class="txt">
                                                            <div class="title">
                                                                <strong class="dark-blue new-strong-color"><?= $activity->text ?></strong>
                                                                <div class="txt-btn">
                                                                    <span>
                                                                        <i class="fa fa-external-link"></i>
                                                                        <?php   $des=preg_replace("/<a[^>]+\>/i", "", $activity->description);echo str_replace('</a>','',$des); ?>
                                                                    </span>
                                                                </div>
                                                                <em class="time"><?php echo timeago($activity->created_at); ?></em>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </li>

                                            <?php } if ($activity->type == 'Comment') { ?>
                                                <li>
                                                    <input type="hidden" class="month_year" value="<?= $activity->month_year ?>">
                                                    <div class="icon"><img src="<?php echo asset('userassets/images/act-c.png') ?>" alt="My Comment"></div>
                                                    <div class="txt">
                                                        <a href="<?= $url ?>"> 
                                                            <div class="title">
                                                                <strong class="dark-blue new-strong-color"><?= $activity->text ?></strong>
                                                                <div class="txt-btn">
                                                                    <span>
                                                                        <i class="fa fa-external-link"></i>
                                                                        <?php  if($activity->description){ $des= preg_replace("/<a[^>]+\>/i", "", $activity->description );echo str_replace('</a>','',$des);}else{ echo 'No comment description found';} ?>
                                                                    </span>
                                                                </div>
                                                                <em class="time"><?php echo timeago($activity->created_at); ?></em>
                                                            </div>
                                                        </a>  
                                                    </div>
                                                </li>
                                            <?php }
                                        }
                                    }
                                    ?>
                                <?php } else { ?>
                                    <div class="loader hb_not_more_posts_lbl" id="no_more_log">No more activity to show</div>
<?php } ?>

 
                            </ul>
                           <div style="display: none" class="hb_simple_loader" id="loading"><img src="<?php echo asset('userassets/images/new_loadeer.svg') ?>" alt="" class="post-loader"><span></span></div>
                        </div>
                    </div>
                    <div class="right_sidebars">
<?php include 'includes/rightsidebar.php'; ?>
<?php include 'includes/chat-rightsidebar.php'; ?>
                    </div>
                </div>
            </article>
            <!--<div style="display: none" id="loading"> Loading . . . . </div>-->

        </div>
        <div id="keyword-list" class="popup">
            <div class="popup-holder">
                <div class="popup-area">
                    <div class="text">
                        <header class="header">
                            <img src="<?php echo asset('userassets/images/icon-eye.png') ?>" alt="Eye" class="eye-icon">
                            <strong>Saved Discussion</strong>
                        </header>
                        <ul class="list-none keywords-list">
                            <li><a href="#">Questions</a></li>
                            <li><a href="#">Answers</a></li>
                            <li><a href="#">Groups</a></li>
                            <li><a href="#">Journals</a></li>
                            <li><a href="#">Strains</a></li>
                            <li><a href="#">Budz Adz</a></li>
                        </ul>
                        <a href="#" class="btn-follow btn-primary">Follow this keyword</a>
                        <a href="#" class="btn-close">Close</a>
                    </div>
                </div>
            </div>
        </div>

        <div id="saved-discuss" class="popup light-brown">
            <div class="popup-holder">
                <div class="popup-area">
                    <div class="text">
                        <header class="header no-padding add">
                            <strong>Saved Discussion</strong>
                        </header>
                        <div class="padding">
                            <p><img src="<?php echo asset('userassets/images/bg-success.svg') ?>" alt="Icon">Q's &amp; A's are saved in the app menu under My Saves</p>
                            <div class="check">
                                <input type="checkbox" id="check">
                                <label for="check">Got it! Do not show again for Q's &amp; A's | Save</label>
                            </div>
                        </div>
                        <a href="#" class="btn-close">Close</a>
                    </div>
                </div>
            </div>
        </div>
    <?php include('includes/footer.php'); ?>

    </body>
    <?php
    if (isset($_GET['sorting'])) {
        $sorting = $_GET['sorting'];
    } else {
        $sorting = '';
    }
    ?>
    <script>

        var win = $(window);
        var count = 1;
        var ajaxcall = 1;
        var sorting = '<?= $sorting; ?>';
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
                        url: "<?php echo asset('get-activity-loader') ?>",
                        type: "GET",
                        data: {
                            "count": count,
                            "sorting": sorting,
                            "last_month": last_month
                        },
                        beforeSend: function () {
                            $('#loading').show();
                        },
                        success: function (data) {
                            if (data) {
                                var a = parseInt(1);
                                var b = parseInt(count);
                                count = b + a;
                                $('#activity_logs').append(data);
                                $('#loading').hide();
                                ajaxcall = 1;
                            } else {
                                $('#no_more_log').hide();
                                 $('#loading').hide();
                                noposts = ' <div class="loader hb_not_more_posts_lbl" id="nomoreposts">No more activity to show</div> ';
                                $('#activity_logs').append(noposts);
                               
                            }
                        }
                    });
                }
         
               
            }
        });
    </script>
</html>