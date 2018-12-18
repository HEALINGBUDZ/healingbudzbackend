<!DOCTYPE html>
<html lang="en">
    <?php include('includes/top.php'); ?>
    <body>
        <div id="wrapper">
            <?php include('includes/sidebar.php'); ?>
            <article id="content">
                <?php include('includes/header.php'); ?>
                <div class="padding-div">
                    <div class="visual add">
                        <div class="gallery">
                            <div class="mask">
                                <div class="slideset">
                                </div>
                                <div class="caption">
                                    <div class="caption-area">
                                        <div class="caption-holder">
                                            <h2><?= $strain->title; ?></h2>
                                            <span><?= $strain->getType->title; ?></span>
                                            <div class="caption-reviews">
                                                <div class="txt">
                                                    <img src="<?php echo asset('userassets/images/leaf-' . floorToFraction(number_format((float) $strain->ratingSum['total'], 1, '.', ''), 2) . '.svg') ?>" alt="Image" class="img-responsive">
                                                    <span><?= number_format((float) $strain->ratingSum['total'], 1, '.', ''); ?></span>
                                                </div>
                                                <div class="txt">
                                                    <img src="<?php echo asset('userassets/images/chat.png') ?>" alt="Image" class="img-responsive">
                                                    <span><?= $strain->get_review_count; ?> Reviews</span>
                                                </div>
                                                <!--                                                <form action="#" class="upload-form">
                                                                                                    <input type="file" id="gal-img">
                                                                                                    <label for="gal-img"><i class="fa fa-upload" aria-hidden="true"></i></label>
                                                                                                </form>-->
                                                <form action="<?php echo asset('upload_strain_image') ?>" class="upload-form" id="upload_image" method="POST" enctype="multipart/form-data">
                                                    <input type="file" name="image" id="gal-img">
                                                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                                    <input type="hidden" name="strain_id" value="<?= $strain->id; ?>">
                                                    <label for="gal-img"><i class="fa fa-upload" aria-hidden="true"></i></label>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="visual slide-likes">
                        <div class="gallery">
                            <div class="mask add">
                                <div class="slideset">
                                    <?php foreach ($strain->getImages as $image) { ?>
                                        <div class="slide">
                                            <img src="<?php echo asset('public/images' . $image->image_path) ?>" alt="Image" class="img-responsive">
                                            <div class="caption">
                                                <div class="caption-area">
                                                    <div class="caption-holder">
                                                        <footer class="footer">
                                                            <div class="align-left">
                                                                <span>Photo Uploaded by:</span>
                                                                <strong> <a class="<?= getRatingClass($image->getUser->points) ?>" href="<?= asset('user-profile-detail/' . $image->getUser->id) ?>"><?= $image->getUser->first_name ?></a></strong>
                                                                <span class="date"><i class="fa fa-calendar" aria-hidden="true"></i> <?= date("dS M Y", strtotime($image->created_at)); ?></span>
                                                            </div>
                                                            <div class="align-right">
                                                                <ul class="list-none">
                                                                    <li>
                                                                        <a <?php if ($image->liked) { ?> style="display: none"<?php } ?> href="javascript:void(0)" id="strain_like_<?= $image->id ?>" class="white thumb " onclick="addRemoveLike('<?= $image->id ?>', '1')">
                                                                            <i class="fa fa-thumbs-up" aria-hidden="true"></i>
                                                                        </a>
                                                                        <a <?php if (!$image->liked) { ?> style="display: none"<?php } ?> href="javascript:void(0)" id="strain_like_revert_<?= $image->id ?>" class="white thumb active" onclick="addRemoveLike('<?= $image->id ?>', '0')">
                                                                            <i class="fa fa-thumbs-up" aria-hidden="true"></i>
                                                                        </a>
                                                                        <span id="strain_like_count_<?= $image->id ?>"><?= $image->likeCount->count(); ?></span>
                                                                    </li>
                                                                    <li>
                                                                        <a <?php if ($image->disliked) { ?> style="display: none"<?php } ?> href="javascript:void(0)" id="strain_dislike_<?= $image->id ?>" class="white thumb " onclick="addRemoveDisLike('<?= $image->id ?>', '1')">
                                                                            <i class="fa fa-thumbs-down" aria-hidden="true"></i>
                                                                        </a>
                                                                        <a <?php if (!$image->disliked) { ?> style="display: none"<?php } ?> href="javascript:void(0)" id="strain_dislike_revert_<?= $image->id ?>" class="white thumb active" onclick="addRemoveDisLike('<?= $image->id ?>', '0')">
                                                                            <i class="fa fa-thumbs-down" aria-hidden="true"></i>
                                                                        </a>
                                                                        <span id="strain_dislike_count_<?= $image->id ?>"><?= $image->disLikeCount->count(); ?></span>
                                                                    </li>
                                                                    <li>
                                                                        <a <?php if ($image->flagged) { ?> style="display: none"<?php } ?>   id="strain_flag_<?= $image->id ?>" class="white flag report btn-popup" href="#strain-image-flag<?= $image->id ?>" >
                                                                            <i class="fa fa-flag report btn-popup" aria-hidden="true"></i>
                                                                        </a>
                                                                        <a <?php if (!$image->flagged) { ?> style="display: none"<?php } ?>  href="javascript:void(0)" id="strain_flag_revert_<?= $image->id ?>" class="white flag active">
                                                                            <i class="fa fa-flag" aria-hidden="true"></i>
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </footer>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="strain-image-flag<?= $image->id ?>" class="popup">
                                            <div class="popup-holder">
                                                <div class="popup-area">
                                                    <form action="<?php echo asset('save-strain-image-flag'); ?>" class="reporting-form" method="post">
                                                        <input type="hidden" value="<?php echo $image->id; ?>" name="id">
                                                        <input type="hidden" value="<?php echo csrf_token(); ?>" name="_token">
                                                        <fieldset>
                                                            <h2>Reason For Reporting</h2>


                                                            <input checked="" type="radio" name="group" id="harasssment<?= $image->id ?>"  value="Harassment or hate speech">
                                                            <label for="harasssment<?= $image->id ?>">Harassment or hate speech</label>

                                                            <input type="radio" name="group" id="threatening<?= $image->id ?>"  value="Threatening, violent, or concerning">
                                                            <label for="threatening<?= $image->id ?>">Threatening, violent, or concerning</label>

                                                            <input type="radio" name="group" id="abused<?= $image->id ?>"  value="offensive">
                                                            <label for="abused<?= $image->id ?>">Strain image is offensive</label>
                                                            <input type="radio" name="group" id="spam<?= $image->id ?>" value="Spam">
                                                            <label for="spam<?= $image->id ?>">Spam</label>
                                                            <input type="radio" name="group" id="unrelated<?= $image->id ?>" value="Unrelated">
                                                            <label for="unrelated<?= $image->id ?>">Unrelated</label>
                                                            <input type="submit" value="Report Strain Image">
                                                            <a href="#" class="btn-close">x</a>
                                                        </fieldset>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                                <a href="#" class="btn-prev"><i class="fa fa-angle-left" aria-hidden="true"></i></a>
                                <a href="#" class="btn-next"><i class="fa fa-angle-right" aria-hidden="true"></i></a>
                                <!-- <div class="pagination"></div> -->

                            </div>
                        </div>
                    </div>
                </div>
            </article>
        </div>
        <?php include('includes/footer.php'); ?>


        <script>
            $(document).ready(function () {
                $('input[type=file]').on('change', function () {
                    $("#upload_image").submit();
                });
            });
            function addRemoveLike(id, val) {
                if (val == 1) {
                    $('#strain_like_' + id).hide();
                    $('#strain_like_revert_' + id).show();
                    $('#strain_dislike_' + id).show();
                    $('#strain_dislike_revert_' + id).hide();
                } else {
                    $('#strain_like_' + id).show();
                    $('#strain_like_revert_' + id).hide();
                }
                $.ajax({
                    type: "GET",
                    url: "<?php echo asset('save-strain-image-like'); ?>",
                    data: {
                        "id": id, "val": val
                    },
                    success: function (data) {
                        $('#strain_like_count_' + id).html(data.like_count);
                        $('#strain_dislike_count_' + id).html(data.dislike_count);
                    }
                });
            }

            function addRemoveDisLike(id, val) {
                if (val == 1) {
                    $('#strain_dislike_' + id).hide();
                    $('#strain_dislike_revert_' + id).show();
                    $('#strain_like_' + id).show();
                    $('#strain_like_revert_' + id).hide();
                } else {
                    $('#strain_dislike_' + id).show();
                    $('#strain_dislike_revert_' + id).hide();
                }
                $.ajax({
                    type: "GET",
                    url: "<?php echo asset('save-strain-image-dislike'); ?>",
                    data: {
                        "id": id, "val": val
                    },
                    success: function (data) {
                        $('#strain_like_count_' + id).html(data.like_count);
                        $('#strain_dislike_count_' + id).html(data.dislike_count);
                    }
                });
            }

            function addRemoveFlag(id, val) {
                if (val == 1) {
                    $('#strain_flag_' + id).hide();
                    $('#strain_flag_revert_' + id).show();
                } else {
                    $('#strain_flag_' + id).show();
                    $('#strain_flag_revert_' + id).hide();
                }
                $.ajax({
                    type: "GET",
                    url: "<?php echo asset('save-strain-image-flag'); ?>",
                    data: {
                        "id": id, "val": val
                    },
                    success: function (data) {

                    }
                });
            }
        </script>
    </body>
</html>