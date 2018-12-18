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
                        <header class="intro-header no-bg">
                            <h1 class="custom-heading white text-center">
                                <img src="<?php echo asset('userassets/images/side-icon15.svg') ?>" alt="Icon" class="no-margin">
                                <span class="top-padding">EDIT BUDZ REVIEW</span>
                            </h1>
                        </header>
                        <div class="bus-rev-bot">
                            <div class="cus-col">
                                <div class="rev-row">                        
                                    <article>
                                        <div class="comment_repeater">
                                            <div class="art-top">
                                                <div class="art-top-row">
                                                <figure class="cir-img" style="background-image: url(<?php echo getImage($review->user->image_path, $review->user->avatar) ?>);"></figure>
                                                    <div class="comment_new_txt">
                                                        <div class="clearfix">
                                                        <span class="rev-title"><a class="<?= getRatingClass($review->user->points) ?>"  href="<?= asset('user-profile-detail/' . $review->user->id) ?>"><?php echo $review->user->first_name; ?></a></span>
                                                        <!--<span class="time"><?php //echo $newDate = date("jS M Y", strtotime($review->created_at));   ?></span>-->

                                                        <span class="time"><?php echo $newDate = timeZoneConversion($review->created_at, 'jS M Y', \Request::ip()); ?></span>
                                                        </div>
                                                        <p><?php echo $review->text; ?></p>
                                                        <div class="videos">
                                                            <?php foreach ($review->attachments as $attachment) { ?>
                                                                <?php if ($attachment->type == 'image') { ?>
                                                                    <img src="<?php echo asset('public/images' . $attachment->attachment); ?>" alt="image"/>
                                                                <?php } else { ?>
                                                                    <video width="320" height="240" poster="<?php echo asset('public/images' . $attachment->poster); ?>" controls>
                                                                        <source src="<?php echo asset('public/videos' . $attachment->attachment); ?>">
                                                                        Your browser does not support the video tag.
                                                                    </video>
                                                                <?php }
                                                            }
                                                            ?>
                                                        </div>
                                                        <?php if ($review->rating > 0) { ?>
                                                            <span class="t-star">
                                                                <i class="fa fa-star"></i> <?php echo number_format((float) $review->rating, 1, '.', ''); ?>
                                                            </span>
                                                        <?php } ?>
                                                        <div class="art-reply">
                                                            <h4>Update Reply</h4>
                                                            <form method="post" action="<?php echo asset('add-budzmap-review-reply'); ?>" id="reply-form" >
                                                                <input type="hidden" name="_token" value="<?= csrf_token() ?>">
                                                                <input type="hidden" name="review_id" value="<?= $review->id ?>">
                                                                <input type="hidden" name="business_id" value="<?= $business_id ?>">
                                                                <input type="hidden" name="business_type_id" value="<?= $business_type_id ?>">
                                                                <div class="bus-txt-area">
                                                                    <div class="label-in-com-rev">
                                                                    <textarea name="reply" maxlength="500" placeholder="Type your reply here.." id="add_reply" required=""><?php echo revertTagSpace($review->reply->reply); ?></textarea>
                                                                    <strong><span class="reply-chars-counter"><?php echo strlen(revertTagSpace($review->reply->reply));?>/500 Characters</span></strong>
                                                                    </div>
                                                                </div>
                                                                <div class="bus-submit">
                                                                    <input type="submit" value="Update Reply" class="new_btn_submit">
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--</div>-->
                                    </article>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="right_sidebars">
                        <?php include 'includes/rightsidebar.php'; ?>
                        <?php include 'includes/chat-rightsidebar.php';?>
                    </div>
                </div>
            </article>
        </div>
        <?php include('includes/footer.php'); ?>
        <script>
            $(document).ready(function(){

                var reply_area = $("#add_reply");
                reply_area.keyup(function (event) {
                    var numbOfchars = reply_area.val();
                    var len = numbOfchars.length;
    //                var show = (500 - len);
                    var show = len;
                    $(".reply-chars-counter").text(show + '/500 Characters ');
                });
                reply_area.keypress(function (e) {
                    var tval = reply_area.val(),
                            tlength = tval.length,
                            set = 500,
                            remain = parseInt(set - tlength);
                    if (remain <= 0 && e.which !== 0 && e.charCode !== 0) {
                        reply_area.val((tval).substring(0, tlength - 1));
                    }
                });

            });

    </script>
    </body>
</html>