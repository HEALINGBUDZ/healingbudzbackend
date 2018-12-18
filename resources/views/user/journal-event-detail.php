<!DOCTYPE html>
<html lang="en">
<?php include('includes/top-new.php'); ?>
    <body>
        <div id="wrapper">
            <?php include('includes/sidebar.php'); ?>
            <article id="content">
                <?php include('includes/header.php'); ?>
                <div class="padding-div">
                    <?php include('includes/journal_event_slider.php'); ?>
                    <div class="tabbing">
                        <div id="tab-content">
                            <div id="strain-details" class="tab active">
                                <?php if(count($event->getVideoAttachments) > 0) { ?>
                                    <a href="#video-popup" class="btn-popup video-btn"><i class="fa fa-video-camera" aria-hidden="true"></i></a>
                                <?php } ?>
                                <fieldset>
                                    <header class="date-header">
                                        <div class="left">
                                            <i class="fa fa-calendar-check-o calendar" aria-hidden="true"></i>
                                            <div class="d">
                                                <?php $date = timeZoneConversion($event->date, 'Y-m-d h:i A', \Request::ip())?>
                                                <strong><?php echo date('d', strtotime($date));?></strong>
                                                <span><em class="w-name"><?php echo date('l', strtotime($date));?></em><em><?php echo date('F, Y', strtotime($date));?></em></span>
                                            </div>
                                        </div>
                                    </header>
                                    <div class="adding-list">
                                        <div class="opener">
                                            <div class="left">
                                                <span>How I'm feeling: <b><?php echo str_replace(':', '', $event->feeling);?></b></span>
                                            </div>
                                            <div class="right">
                                                <!--<img src="<?php echo asset('userassets/images/happy.png') ?>"  alt="Image">-->
                                                <?php echo LaravelEmojiOne::toImage($event->feeling); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="adding-txt">
                                        <header class="date-header add">
                                            <div class="left">
                                                <i class="fa fa-address-book" aria-hidden="true"></i>
                                                <span><?php echo $event->getJournal->title;?></span>
                                                <strong id="journal_title" class="new_j_title"><?php echo $event->title; ?></strong>
                                            </div>
<!--                                            <div class="right">
                                                <?php //if(count($event->getLikes) > 0){ ?>
                                                    <i class="fa fa-thumbs-up active" aria-hidden="true"></i> <em><?php //echo $event->get_likes_count; ?></em>
                                                <?php //}else{ ?>
                                                    <i class="fa fa-thumbs-up journal_event_like" aria-hidden="true"></i> <em id="like_count"><?php//echo $event->get_likes_count; ?></em>
                                                <?php //} ?>
                                                <?php //if(count($event->getDisLikes) > 0){ ?>
                                                    <i class="fa fa-thumbs-down active" aria-hidden="true"></i> <em id="dislike_count"><?php //echo $event->get_dis_likes_count; ?></em>
                                                <?php //}else{ ?>
                                                    <i class="fa fa-thumbs-down journal_event_dislike" aria-hidden="true"></i> <em id="dislike_count"><?php //echo $event->get_dis_likes_count; ?></em>
                                                <?php //} ?>
                                            </div>-->

                                            <div class="right">
                                                    <i <?php if (!$event->is_liked_count) { ?> style="display: none"<?php } ?> class="fa fa-thumbs-up active" id="journal_event_like_revert" aria-hidden="true"></i> 
                                                
                                                    <i <?php if ($event->is_liked_count) { ?> style="display: none"<?php } ?> class="fa fa-thumbs-up" id="journal_event_like" aria-hidden="true"></i> 
                                                    <em id="like_count"><?php echo $event->get_likes_count; ?></em>
                                                
                                                
                                                    <i <?php if (!$event->is_dis_liked_count) { ?> style="display: none"<?php } ?> class="fa fa-thumbs-down active" id="journal_event_dislike_revert" aria-hidden="true"></i> 
                                                
                                                    <i <?php if ($event->is_dis_liked_count) { ?> style="display: none"<?php } ?> class="fa fa-thumbs-down" id="journal_event_dislike" aria-hidden="true"></i>
                                                    <em id="dislike_count"><?php echo $event->get_dis_likes_count; ?></em>
                                                
                                            </div>
                                        </header>
                                        <div class="details-div">
                                            <p><?php echo $event->description; ?></p>
                                        </div>
                                        <header class="date-header add">
                                            <div class="left">
                                                <i class="fa fa-tags" aria-hidden="true"></i>
                                                <span>Tags:</span>
                                            </div>
                                        </header>
                                        <ul class="common-tags list-none">
                                            <?php foreach ($event->getTags as $tag){ ?>
                                            <li><?php echo $tag->tagDetail->title; ?> <em><?php echo $tag->tagCount->count(); ?></em></li>
                                            <?php } ?>
                                        </ul>
                                        <?php if($event->getStrain){ ?>
                                        <header class="date-header add">
                                            <div class="left">
                                            <img src="<?php echo asset('userassets/images/side-icon14.svg') ?>"  alt="Image" class="icon-img">
                                                <span>Tagged Strain: <b><?php echo $event->getStrain->title; ?></b></span>
                                            </div>
                                        </header>
                                        <a href="<?php echo asset('strain-details/'.$event->getStrain->id); ?>" class="btn-primary yellow center">More About This Strain <i class="fa fa-angle-right" aria-hidden="true"></i></a>
                                        <?php } ?>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                    </div>
                </div>
            </article>
        </div>
        <div id="video-popup" class="popup">
            <div class="popup-holder">
                <div class="popup-area">
                    <div class="text">
                        <div class="gallery">
                            <div class="mask">
                                <div class="slideset">
                                    <?php foreach($event->getVideoAttachments as $video) { ?>
                                        <div class="slide">
                                            <!--<iframe src="<?php echo asset('public/videos'.$video->attachment_path) ?>" frameborder="0" allowfullscreen></iframe>-->
                                            <video higth='70' width='130' class="video-use" controls class="video" poster="<?php echo asset('public/images'.$video->poster) ?>" id="video">
                                                <source src="<?php echo asset('public/videos'.$video->attachment_path) ?>" type="video/mp4">
                                            </video>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="pagination"></div>
                            </div>
                        </div>
                        <a href="#" class="btn-close"></a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Modal Delete Journal -->
        <div class="modal fade" id="delete-journal-event" role="dialog">
            <div class="modal-dialog">
              <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Delete Journal </h4>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure to delete this Journal: <?php echo $event->title; ?></p>
                    </div>
                    <div class="modal-footer">
                        <a href="<?php echo asset('delete-journal-event/'.$event->id); ?>" type="button" class="btn-heal">yes</a>
                        <button data-dismiss="modal" type="button" class="btn-heal">No</button>
                    </div>
                </div>
            </div>
        </div>
       <!-- Modal End-->
        <?php include('includes/footer.php'); ?>
    </body>
    <script>
        
        $('.journal_class').click(function(){
//            alert(this.id);
            $(this).parents('.custom-shares').hide();
//            question_id = this.id;
//            $.ajax({
//                url: "<?php echo asset('add_question_share_points') ?>",
//                type: "GET",
//                data: {
//                    "question_id": question_id
//                },
//                success: function(data) {
//                }
//            });  
        });
      
        $(document).ready(function () {
            
            $('#journal_event_dislike').click(function (e) {
                var event_id = '<?php echo $event->id?>'; 
                
                $.ajax({
                    url: "<?php echo asset('journal-event-dislike') ?>",
                    type: "POST",
                    data: {"event_id": event_id, "_token": "<?php echo csrf_token(); ?>"},
                    success: function (response) {
                        if (response.status == 'success') {
                            $('#dislike_count').html(parseInt(response.dislike_count));
                            $('#like_count').html(parseInt(response.like_count));
                            $('#journal_event_dislike').hide();
                            $('#journal_event_dislike_revert').show();
                            $('#journal_event_like').show();
                            $('#journal_event_like_revert').hide();
                        }
                    }
                });
            });
            
            
            $('#journal_event_dislike_revert').click(function (e) {
                var event_id = '<?php echo $event->id?>'; 
                
                $.ajax({
                    url: "<?php echo asset('journal-event-dislike-revert') ?>",
                    type: "POST",
                    data: {"event_id": event_id, "_token": "<?php echo csrf_token(); ?>"},
                    success: function (response) {
                        if (response.status == 'success') {
                            $('#dislike_count').html(parseInt(response.dislike_count));
                            $('#like_count').html(parseInt(response.like_count));
                            $('#journal_event_dislike').show();
                            $('#journal_event_dislike_revert').hide();
                        }
                    }
                });
            });
            
            
            $('#journal_event_like').click(function (e) {
                var event_id = '<?php echo $event->id?>'; 
                
                $.ajax({
                    url: "<?php echo asset('journal-event-like') ?>",
                    type: "POST",
                    data: {"event_id": event_id, "_token": "<?php echo csrf_token(); ?>"},
                    success: function (response) {
                        if (response.status == 'success') {
                            $('#like_count').html(parseInt(response.like_count));
                            $('#dislike_count').html(parseInt(response.dislike_count));
                            $('#journal_event_like').hide();
                            $('#journal_event_like_revert').show();
                            $('#journal_event_dislike').show();
                            $('#journal_event_dislike_revert').hide();
                        }
                    }
                });
            });
            
            $('#journal_event_like_revert').click(function (e) {
                var event_id = '<?php echo $event->id?>'; 
                
                $.ajax({
                    url: "<?php echo asset('journal-event-like-revert') ?>",
                    type: "POST",
                    data: {"event_id": event_id, "_token": "<?php echo csrf_token(); ?>"},
                    success: function (response) {
                        if (response.status == 'success') {
                            $('#like_count').html(parseInt(response.like_count));
                            $('#dislike_count').html(parseInt(response.dislike_count));
                            $('#journal_event_like').show();
                            $('#journal_event_like_revert').hide();
                        }
                    }
                });
            });
            
        });
    </script>
</html>