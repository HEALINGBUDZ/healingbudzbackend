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
                            <li><a href="<?php echo asset('budz-feeds'); ?>">Feeds</a></li>
                            <li>All</li>
                        </ul>
                        <!--<div class="activities-log">-->
                            <h2>NOTIFICATIONS</h2>
                            <div class="activities-log">
                                <?php if ($notification_count) { ?>
                                    <span class="notice-strip"><?php echo $notification_count; ?> new notifications since you last logged in.</span> 
                                <?php } ?>

                                <ul class="activities list-none hb_feed_listing " id="feed_listing" >
                                <?php if (count($budz_feeds) > 0) { ?>
                                <?php /*    
                                <ul class="activities list-none" id="feed_listing"> 
                                    <?php foreach ($budz_feeds as $bfeed) {
                                        $url = 'javascript:void(0)';
                                        if ($bfeed->model == 'Question' || $bfeed->model == 'Answer') {
                                            $url = asset('get-question-answers/' . $bfeed->type_id);
                                            $image_icon = asset('userassets/images/act-q.png');
                                        }
                                        if ($bfeed->model == 'SubUser') {
                                            $subuser = getSubUser($bfeed->type_id);
                                            $url = asset('get-budz?business_id=' . $bfeed->type_id . '&business_type_id=' . $subuser->business_type_id);
                                            $image_icon = asset('userassets/images/folded-newspaper.svg');
                                        }
                                        if ($bfeed->model == 'Strain') {
                                            $url = asset('strain-details/' . $bfeed->type_id);
                                            $image_icon = asset('userassets/images/act-s.png');
                                        }
//                                        if ($bfeed->model == 'Group' || $bfeed->type == 'Groups') {
//                                            $url = asset('group-chat/' . $bfeed->type_id);
//                                            $image_icon = asset('userassets/images/act-s.png');
//                                        }
//                                        if ($bfeed->model == 'GroupInvitation') {
//                                            $url = asset('group-invitation/' . $bfeed->type_sub_id);
//                                            $image_icon = asset('userassets/images/act-s.png');
//                                        }
//                                        if ($bfeed->model == 'Journal') {
//                                            $url = asset('journal-details/' . $bfeed->type_id);
//                                            $image_icon = asset('userassets/images/act-s.png');
//                                        }
//                                        if ($bfeed->model == 'JournalFollowing') {
//                                            $url = asset('journal-details/' . $bfeed->type_id);
//                                            $image_icon = asset('userassets/images/act-s.png');
//                                        }
                                        if ($bfeed->model == 'User') {
                                            $url = asset('user-profile-detail/' . $bfeed->user_id);
                                            $image_icon = asset('userassets/images/default.svg');
                                        }
                                        if ($bfeed->model == 'ChatMessage') {
                                            $url = asset('message-user-detail/' . $bfeed->user_id);
                                            $image_icon = asset('userassets/images/act-c.png');
                                        }
                                        if ($bfeed->model == 'UserStrainLike') {
                                            $url = asset('user-strain-detail?strain_id=' . $bfeed->type_id.'&user_strain_id='. $bfeed->type_sub_id);
                                            $image_icon = asset('userassets/images/act-f.png');
                                        }

                                        if ($bfeed->model == 'Tag') {
                                            $url = 'javascript:void(0)';
                                            $image_icon = asset('userassets/images/act-t.png');
                                        }
                                        if ($bfeed->model == 'Post') {
                                            $url = asset('get-post/' . $bfeed->type_id);
                                            $image_icon = asset('userassets/images/side-social-icon.png');
                                        }
                                        ?>
                                        <li>
                                            <div class="icon"><img src="<?php echo $image_icon; ?>" alt="My Answers"></div>
                                            <div class="txt">
                                                <a href="<?= $url; ?>">
                                                    <div class="title">
                                                        <strong class="green new-strong-color"><?php echo $bfeed->notification_text; ?></strong>
                                                        <div class="txt-btn">
                                                            <span>
                                                                <i class="fa fa-external-link"></i>
                                                                <?= $bfeed->description ?>
                                                            </span>
                                                        </div>
                                                        <span class="bottom-time time"><?php echo timeago($bfeed->created_at); ?>.</span>
                                                    </div>
                                                </a>
                                            </div>
                                        </li>
                                    <?php } ?>
                                </ul> 
                                 */?>
                                <?php foreach($budz_feeds as $key => $values){ ?>
                                    <div class="date-main-act">
                                        <i class="fa fa-calendar"></i>
                                        <span><?= $key ?></span>
                                    </div>
                                    <?php foreach ($values as $budz_feed) {
                                        $url = 'javascript:void(0)';
                                        if ($budz_feed->model == 'Question' || $budz_feed->model == 'Answer') {
                                            $url = asset('get-question-answers/' . $budz_feed->type_id);
                                        }
                                        if ($budz_feed->model == 'Post' || $budz_feed->model == 'UserPost') {
                                            $url = asset('get-post/' . $budz_feed->type_id);
                                        }
                                        if ($budz_feed->model == 'SubUser') {
                                            $subuser = getSubUser($budz_feed->type_id);
                                            if($subuser){
                                            $url = asset('get-budz?business_id=' . $budz_feed->type_id . '&business_type_id=' . $subuser->business_type_id);
                                        }}
                                        if ($budz_feed->model == 'Strain') {
                                            $url = asset('strain-details/' . $budz_feed->type_id);
                                        }
//                                        if ($budz_feed->model == 'Group') {
//                                            $url = asset('group-chat/' . $budz_feed->type_id);
//                                        }
//                                        if ($budz_feed->model == 'GroupMessage') {
//                                            $url = asset('group-chat/' . $budz_feed->type_id);
//                                        }
//                                        if ($budz_feed->model == 'GroupFollower') {
//                                            $url = asset('group-chat/' . $budz_feed->type_id);
//                                        }
//                                        if ($budz_feed->type == 'Journal' || $budz_feed->model == 'JournalFollowing') {
//                                            $url = asset('journal-details/' . $budz_feed->type_id);
//                                        }
                                        if ($budz_feed->model == 'Tag') {
                                            $url = 'javascript:void(0)';
                                        }
                                        if ($budz_feed->model == 'ChatMessage') {
                                            $url = asset('message-user-detail/' . $budz_feed->user_id);
                                            $image_icon = asset('userassets/images/act-c.png');
                                        }
                                        if ($budz_feed->model == 'ShoutOut') {
                                            $url = asset('get-shoutout/' . $budz_feed->type_id);
                                            $image_icon = asset('userassets/images/act-c.png');
                                        }
                                        if ($budz_feed->model == 'ShoutOutLike') {
                                            $url = asset('get-shoutout/' . $budz_feed->type_id);
//                                            $image_icon = asset('userassets/images/act-c.png');
                                        }
                                        if ($budz_feed->model == 'User') {
                                            $url = asset('user-profile-detail/' . $budz_feed->user_id);
                                        }
                                        ?>
                                        <?php if ($budz_feed->type == 'Strains') { ?>
                                            <li>
                                                <input type="hidden" class="month_year" value="<?= $budz_feed->month_year ?>">
                                                <div class="icon"><img src="<?php echo asset('userassets/images/act-s.png') ?>" alt="My Answers"></div>
                                                <div class="txt hb_text_yellow">
                                                    <a href="<?php echo asset('strain-details/' . $budz_feed->type_id); ?>"> 
                                                        <div class="title">
                                                            <strong class="dark-blue new-strong-color"><?= $budz_feed->notification_text ?></strong>
                                                            <div class="txt-btn">
                                                                <span>
                                                                    <i class="fa fa-external-link"></i>
                                                                    <?= $budz_feed->description ?>
                                                                </span>
                                                            </div>
                                                            <em class="time"><?php echo timeago($budz_feed->created_at);?></em>
                                                        </div>
                                                    </a>
                                                </div>
                                            </li>
                                        <?php } if ($budz_feed->type == 'Budz Map') { ?>
                                            <li>
                                                <input type="hidden" class="month_year" value="<?= $budz_feed->month_year ?>">
                                                <div class="icon"> <img src="<?php echo asset('userassets/images/folded-newspaper.svg') ?>" alt="My Answers"></div>
                                                <div class="txt hb_text_pink ">
                                                    <a href="<?php echo asset('get-budz/' . $budz_feed->type_id); ?>"> 
                                                        <div class="title">
                                                            <strong class="dark-blue new-strong-color"><?= $budz_feed->notification_text ?></strong>
                                                            <div class="txt-btn">
                                                                <span>
                                                                    <i class="fa fa-external-link"></i>
                                                                    <?= $budz_feed->description ?>
                                                                </span>
                                                            </div>
                                                            <em class="time"><?php echo timeago($budz_feed->created_at);?></em>
                                                        </div>
                                                    </a>
                                                </div>
                                            </li>
                                        <?php } if ($budz_feed->type == 'Questions') { ?>
                                            <li>
                                                <input type="hidden" class="month_year" value="<?= $budz_feed->month_year ?>">
                                                <div class="icon"><img src="<?php echo asset('userassets/images/act-q.png') ?>" alt="My Answers"></div>
                                                <div class="txt hb_text_blue">
                                                    <a href="<?php echo asset('get-question-answers/' . $budz_feed->type_id); ?>"> 
                                                        <div class="title">
                                                            <strong class="dark-blue new-strong-color"><?= $budz_feed->notification_text ?></strong>
                                                            <div class="txt-btn">
                                                                <span>
                                                                    <i class="fa fa-external-link"></i>
                                                                    <?= $budz_feed->description ?>
                                                                </span>
                                                            </div>
                                                            <em class="time"><?php echo timeago($budz_feed->created_at);?></em>
                                                        </div>
                                                    </a>  
                                                </div>
                                            </li>
                                        <?php } if ($budz_feed->type == 'Answers') { ?>
                                            <li>
                                                <input type="hidden" class="month_year" value="<?= $budz_feed->month_year ?>">
                                                <div class="icon"><img src="<?php echo asset('userassets/images/act-a.png') ?>" alt="My Answers"></div>
                                                <div class="txt hb_text_blue">
                                                    <a href="<?php echo asset('get-question-answers/' . $budz_feed->type_id); ?>"> 
                                                        <div class="title">
                                                            <strong class="dark-blue new-strong-color"><?= $budz_feed->notification_text ?></strong>
                                                            <div class="txt-btn">
                                                                <span>
                                                                    <i class="fa fa-external-link"></i>
                                                                    <?= $budz_feed->description ?>
                                                                </span>
                                                            </div>
                                                            <em class="time"><?php echo timeago($budz_feed->created_at);?></em>
                                                        </div>
                                                    </a>
                                                </div>
                                            </li>
                                        <?php } if ($budz_feed->type == 'Likes') { 
                                            $class_for_like='';
            if($budz_feed->model =='UserPost'){
              $class_for_like='hb_text_green';  
            }
            if($budz_feed->model =='Question' || $budz_feed->model =='Answer'){
                 $class_for_like='hb_text_blue';  
            }
            if($budz_feed->model =='UserStrainLike' || $budz_feed->model =='Strain'){
                 $class_for_like='hb_text_yellow';  
            }
            if($budz_feed->model =='SubUser'){
                 $class_for_like='hb_text_pink';  
            }
            if($budz_feed->model =='ShoutOutLike'){
                 $class_for_like='hb_text_pink';  
            }?>
                                            <li>
                                                <input type="hidden" class="month_year" value="<?= $budz_feed->month_year ?>">
                                                <div class="icon"><img src="<?php echo asset('userassets/images/act-l.png') ?>" alt="My Answers"></div>
                                                <div class="txt <?= $class_for_like?>">
                                                    <a href="<?= $url; ?>">
                                                        <div class="title">
                                                            <strong class="dark-blue new-strong-color"><?= $budz_feed->notification_text ?></strong>
                                                            <div class="txt-btn">
                                                                <span>
                                                                    <i class="fa fa-external-link"></i>
                                                                    <?= $budz_feed->description ?>
                                                                </span>
                                                            </div>
                                                            <em class="time"><?php echo timeago($budz_feed->created_at);?></em>
                                                        </div>
                                                    </a>
                                                </div>
                                            </li>
                                        <?php } if ($budz_feed->type == 'Favorites') { ?>
                                            <li>
                                                <input type="hidden" class="month_year" value="<?= $budz_feed->month_year ?>">
                                                <div class="icon"><img src="<?php echo asset('userassets/images/act-f.png') ?>" alt="My Answers"></div>
                                                <div class="txt">
                                                    <a href="<?= $url; ?>">
                                                        <div class="title">
                                                            <strong class="dark-blue new-strong-color"><?= $budz_feed->notification_text ?></strong>
                                                            <div class="txt-btn">
                                                                <span>
                                                                    <i class="fa fa-external-link"></i>
                                                                    <?= $budz_feed->description ?>
                                                                </span>
                                                            </div>
                                                            <em class="time"><?php echo timeago($budz_feed->created_at);?></em>
                                                        </div>
                                                    </a>
                                                </div>
                                            </li>
                                        <?php } if ($budz_feed->type == 'Tags') { ?>
                                            <li>
                                                <input type="hidden" class="month_year" value="<?= $budz_feed->month_year ?>">
                                                <div class="icon"><img src="<?php echo asset('userassets/images/hash.png') ?>" alt="My Answers"></div>
                                                <a href="<?= $url ?>" >
                                                    <div class="txt">
                                                        <div class="title">
                                                            <strong class="dark-blue new-strong-color"><?= $budz_feed->notification_text ?></strong>
                                                            <div class="txt-btn">
                                                                <span>
                                                                    <i class="fa fa-external-link"></i>
                                                                    <?= $budz_feed->description ?>
                                                                </span>
                                                            </div>
                                                            <em class="time"><?php echo timeago($budz_feed->created_at);?></em>
                                                        </div>
                                                    </div>
                                                </a>
                                            </li>
                                        <?php } if ($budz_feed->type == 'Post') { ?>
                                            <li>
                                                <input type="hidden" class="month_year" value="<?= $budz_feed->month_year ?>">
                                                <div class="icon"><img src="<?php echo asset('userassets/images/side-social-icon.png') ?>" alt="My Posts"></div>
                                                <a href="<?= $url ?>" >
                                                    <div class="txt hb_text_green">
                                                        <div class="title">
                                                            <strong class="dark-blue new-strong-color"><?= $budz_feed->notification_text ?></strong>
                                                            <div class="txt-btn">
                                                                <span>
                                                                    <i class="fa fa-external-link"></i>
                                                                    <?= $budz_feed->description ?>
                                                                </span>
                                                            </div>
                                                            <em class="time"><?php echo timeago($budz_feed->created_at);?></em>
                                                        </div>
                                                    </div>
                                                </a>
                                            </li>

                                        <?php } if ($budz_feed->type == 'Comment') { ?>
                                             <li>
                                                 <input type="hidden" class="month_year" value="<?= $budz_feed->month_year ?>">
                                                <div class="icon"><img src="<?php echo asset('userassets/images/act-c.png') ?>" alt="My Comment"></div>
                                                <div class="txt hb_text_green ">
                                                    <a href="<?= $url ?>"> 
                                                        <div class="title">
                                                            <strong class="dark-blue new-strong-color"><?= $budz_feed->notification_text ?></strong>
                                                            <div class="txt-btn">
                                                                <span>
                                                                    <i class="fa fa-external-link"></i>
                                                                    <?= $budz_feed->description ?>
                                                                </span>
                                                            </div>
                                                            <em class="time"><?php echo timeago($budz_feed->created_at);?></em>
                                                        </div>
                                                    </a>  
                                                </div>
                                            </li>
                                        <?php } if ($budz_feed->type == 'Chat') { ?>
                                            <li>
                                                <input type="hidden" class="month_year" value="<?= $budz_feed->month_year ?>">
                                                <div class="icon"> <img src="<?php echo asset('userassets/images/act-c.png') ?>" alt="My Answers"></div>
                                                <div class="txt">
                                                    <a href="<?php echo asset('message-user-detail/' . $budz_feed->user_id); ?>"> 
                                                        <div class="title">
                                                            <strong class="dark-blue new-strong-color"><?= $budz_feed->notification_text ?></strong>
                                                            <div class="txt-btn">
                                                                <span>
                                                                    <i class="fa fa-external-link"></i>
                                                                    <?= $budz_feed->description ?>
                                                                </span>
                                                            </div>
                                                            <em class="time"><?php echo timeago($budz_feed->created_at);?></em>
                                                        </div>
                                                    </a>
                                                </div>
                                            </li>
                                        <?php }
                                        if ($budz_feed->type == 'Users') { 
                                            $user= getUser($budz_feed->user_id);
                                                        $src = getImage($user->image_path, $user->avatar);
                                            ?>
                                            <li>
                                                <input type="hidden" class="month_year" value="<?= $budz_feed->month_year ?>">
                                                <div class="icon"> <img src="<?php echo $src ?>" alt="My Answers"></div>
                                                <div class="txt">
                                                    <a href="<?php echo asset('user-profile-detail/' . $budz_feed->user_id); ?>"> 
                                                        <div class="title">
                                                            <strong class="dark-blue new-strong-color"><?= $budz_feed->notification_text ?></strong>
                                                            <div class="txt-btn">
                                                                <span>
                                                                    <i class="fa fa-external-link"></i>
                                                                    <?= $budz_feed->notification_text  ?>
                                                                </span>
                                                            </div>
                                                            <em class="time"><?php echo timeago($budz_feed->created_at);?></em>
                                                        </div>
                                                    </a>
                                                </div>
                                            </li>
                                        <?php } if ($budz_feed->type == 'ShoutOut') { ?>
                                            <li>
                                                <input type="hidden" class="month_year" value="<?= $budz_feed->month_year ?>">
                                                <div class="icon"> <img src="<?php echo asset('userassets/images/shoutout.svg') ?>" alt="ShoutOut"></div>
                                                <div class="txt hb_text_pink">
                                                    <a href="<?php echo asset('get-shoutout/' . $budz_feed->type_id); ?>"> 
                                                        <div class="title">
                                                            <strong class="dark-blue new-strong-color"><?= $budz_feed->notification_text ?></strong>
                                                            <div class="txt-btn">
                                                                <span>
                                                                    <i class="fa fa-external-link"></i>
                                                                    <?= $budz_feed->description ?>
                                                                </span>
                                                            </div>
                                                            <em class="time"><?php echo timeago($budz_feed->created_at);?></em>
                                                        </div>
                                                    </a>
                                                </div>
                                            </li>
                                        <?php } if ($budz_feed->type == 'BudzChat') { ?>
                                            <li>
                                                <input type="hidden" class="month_year" value="<?= $budz_feed->month_year ?>">
                                                <div class="icon"> <img src="<?php echo asset('userassets/images/folded-newspaper.svg'); ?>" alt="ShoutOut"></div>
                                                <div class="txt hb_text_pink">
                                                    <a href="<?php echo asset('budz-message-user-detail/' . $budz_feed->type_id); ?>"> 
                                                        <div class="title">
                                                            <strong class="dark-blue new-strong-color"><?= $budz_feed->notification_text ?></strong>
                                                            <div class="txt-btn">
                                                                <span>
                                                                    <i class="fa fa-external-link"></i>
                                                                    <?= $budz_feed->description ?>
                                                                </span>
                                                            </div>
                                                            <em class="time"><?php echo timeago($budz_feed->created_at);?></em>
                                                        </div>
                                                    </a>
                                                </div>
                                            </li>
                                        <?php }  if ($budz_feed->type == 'Admin') { ?>
                                            <li>
                                                <input type="hidden" class="month_year" value="<?= $budz_feed->month_year ?>">
                                                <div class="icon"> <img src="<?php echo asset('userassets/images/admin.png'); ?>" alt="Admin"></div>
                                                <div class="txt">
                                                    <a href="javascript:void(0)"> 
                                                        <div class="title">
                                                            <strong class="dark-blue new-strong-color"><?= $budz_feed->notification_text ?></strong>
                                                            <div class="txt-btn">
                                                                <span>
                                                                    <i class="fa fa-external-link"></i>
                                                                    <?= $budz_feed->description ?>
                                                                </span>
                                                            </div>
                                                            <em class="time"><?php echo timeago($budz_feed->created_at);?></em>
                                                        </div>
                                                    </a>
                                                </div>
                                            </li>
                                        <?php }
                                    } }?>
                                <?php }else{ ?>
                                            <div class="loader hb_not_more_posts_lbl" id="no_more_feeds">No More Feed Show</div>
                                            
                                <?php } ?>
                                </ul>
                                     <div style="display: none" class="hb_simple_loader" id="loading"><img src="<?php echo asset('userassets/images/new_loadeer.svg') ?>" alt="Loading . . . ." class="post-loader"><span></span></div>
                            </div>
                        <!--</div>-->
                    </div>
                    <div class="right_sidebars">
                        <?php include 'includes/rightsidebar.php'; ?>
                        <?php include 'includes/chat-rightsidebar.php';?>
                    </div>
                </div>
            </article>
        </div>
        <?php include('includes/footer.php'); ?>
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
                        url: "<?php echo asset('get-budz-feeds-loader') ?>",
                        type: "GET",
                        data: {
                            "count": count,
                            "last_month" : last_month
                        },
                        success: function (data) {
                            if (data) {
                                var a = parseInt(1);
                                var b = parseInt(count);
                                count = b + a;
                                $('#feed_listing').append(data);
                                $('#loading').hide();
                                ajaxcall = 1;
                            } else {
                                $('#no_more_feeds').hide();
                                $('#loading').hide();
                                noposts = ' <div class="loader hb_not_more_posts_lbl" id="nomoreposts">No More Feed Show</div> ';
                                $('#feed_listing').append(noposts);
                            }
                        }
                    });
                }
                
            }
        });
    </script>

</html>