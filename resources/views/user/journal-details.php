<!DOCTYPE html>
<html lang="en">
    <?php include('includes/top-new.php'); ?>
    <body class="strains-page">
        <div id="wrapper">
            <?php include('includes/sidebar.php'); ?>
            <article id="content">
                <?php include('includes/header.php'); ?>
                <div class="padding-div">
                    <header class="j-lists-header">
                        <strong id="journal_title"><?php echo $journal_folowers->title;?></strong>
                        <?php if($user_id == $current_id){ ?>
                            <a href="<?php echo asset('add-journal-event/'.$journal_id); ?>" class="btn-primary green">
                                <i class="fa fa-plus" aria-hidden="true"></i> Add Entry
                            </a>
                        <?php } ?>
                        <div class="sort">
<!--                            <a href="#" class="btn-primary green-border private-btn">Private <i class="fa fa-eye-slash" aria-hidden="true"></i> <i class="fa fa-angle-down" aria-hidden="true"></i></a>
                            <div class="private-drop sort-drop">
                                <div class="sort-item active"><i class="fa fa-eye" aria-hidden="true"></i> Public</div>
                                <div class="sort-item"><i class="fa fa-eye-slash" aria-hidden="true"></i> Private</div>
                            </div>-->
                            <a href="#" class="dot-options operate-all-btn"><i class="fa fa-ellipsis-v" aria-hidden="true"></i></a>
                            <div class="sort-drop all-options">
                                <div class="sort-item expend-all active"><i class="fa fa-chevron-down" aria-hidden="true"></i> Expand All</div>
                                <div class="sort-item collapse-all"><i class="fa fa-chevron-up" aria-hidden="true"></i> Collapse All</div>
                            </div>
                        </div>
                    </header>
                    <div class="j-follow-heading">
                        <?php if($user_id != $current_id){ ?>
                            <div class="align-right follow_btns">
                                <?php if($is_user_following_journal > 0) { ?>
                                    <a href="<?php echo asset('unfollow-journal/'.$journal_id); ?>">Unfollow <i class="fa fa-minus-circle" aria-hidden="true"></i></a>
                                <?php }else{?>
                                    <a href="<?php echo asset('follow-journal/'.$journal_id); ?>">Follow <i class="fa fa-plus-circle" aria-hidden="true"></i></a>
                                <?php }?>
                            </div>
                        <?php } ?>
                        <strong>Journal Followers: <i class="fa fa-user" aria-hidden="true"></i> 
                            <?php if(count($journal_folowers->getFollowers) > 0){ ?>
                                <a href="#followers" class="btn-popup"><?php echo count($journal_folowers->getFollowers); ?> Budz</a>
                            <?php } else{ ?>
                                <a href="javascript:void(0)" >0 Budz</a>
                            <?php }  ?>
                        </strong>
                    </div>
                    <div class="query add">
                        <?php if($journal_events){ ?>
                            <?php foreach($journal_events as $key => $values){ ?>
                                <article class="query-post">
                                     <a href="#" class="header journal-d-opener">
                                         <span class="active"><?php echo $key; ?></span>
                                         <span class=""><i class="fa fa-chevron-right" aria-hidden="true"></i></span>
                                     </a>
                                    <?php foreach($values as $event){ ?>
                                        <div class="j-details">
                                            <div class="date">
                                                <?php $created_at = timeZoneConversion($event->date, 'Y-m-d h:i A', \Request::ip()); ?>
                                                <strong><?php echo date("D",strtotime($created_at)); ?> <br><span><?php echo date("d",strtotime($created_at)); ?></span><br> <?php echo date("M",strtotime($created_at)); ?></strong>
                                                <em><?php echo date('h:i A', strtotime($created_at));?></em>
                                            </div>
                                            <div class="text">
                                                <?php if(count($event->getImageAttachments) > 0){ ?>
                                                <div class="photo">
                                                    <img src="<?php echo asset('public/images'.$event->getImageAttachments[0]->attachment_path) ?>" alt="icons" />
                                                </div>
                                                <?php } ?>
                                                <div class="txt">
                                                    <a href="<?php echo asset('journal-event-detail/'.$event->id); ?>">
                                                        <strong class="title"><?php echo $event->title; ?></strong>
                                                    </a>
                                                    <p><?php echo $event->description; ?></p>
                                                    <div class="info-icons">
                                                        <div>
                                                            <i class="fa fa-picture-o" aria-hidden="true"></i> 
                                                            <?php echo count($event->getImageAttachments); ?>
                                                        </div>
                                                        <div>
                                                            <i class="fa fa-video-camera" aria-hidden="true"></i>
                                                            <?php echo count($event->getVideoAttachments); ?>
                                                        </div>
                                                        <div>
                                                            <i class="fa fa-tags" aria-hidden="true"></i>
                                                            <?php echo count($event->getTags); ?>
                                                        </div>
                                                        <div>
                                                            <?php echo LaravelEmojiOne::toImage($event->feeling); ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </article>
                            <?php } ?>
                        <?php }else{ ?>
                           
                        <?php } ?>
                   </div>
                </div>
            </article>
        </div>
        <div id="followers" class="popup">
            <div class="popup-holder">
                <div class="popup-area">
                    <div action="#" class="reporting-form add no-border new-popup">
                        <h2 class="white radius">Budz Following this journal</h2>
                        <ul class="list-none popup-list">
                            <?php foreach ($journal_folowers->getFollowers as $follower) { ?>
                                <li>
                                    <?php if(count($follower->getUser->followings) > 0 && $follower->getUser->id != $current_id){ ?>
                                        <a href="<?php echo asset('un-follow-user/'.$follower->getUser->id);?>" class="btn">Unfollow <i class="fa fa-times" aria-hidden="true"></i></a>
                                    <?php } elseif($follower->getUser->id != $current_id){ ?>
                                        <a href="<?php echo asset('follow-user/'.$follower->getUser->id);?>" class="btn follow-btn">Follow <i class="fa fa-plus" aria-hidden="true"></i></a>
                                    <?php } ?> 
                                    <span><?php echo $follower->getUser->first_name; ?></span>
                                </li>
                            <?php } ?> 
                        </ul>
                        <a href="#" class="btn-close">x</a>
                    </div>
                </div>
            </div>
        </div>
        <?php include('includes/footer-new.php'); ?>
    </body>
</html>