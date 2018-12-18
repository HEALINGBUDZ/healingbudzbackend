<div class="visual">
    <div class="gallery">
        <div class="mask">
            <div class="slideset">
                <?php if (count($strain->getImages) > 0) { ?>
                    <?php foreach ($strain->getImages as $image) { ?>
                        <div class="slide">
                            <img src="<?php echo asset('public/images/' . $image->image_path) ?>" alt="Image" class="img-responsive">
                            <footer class="footer">
                                <div class="align-left">
                                    <span>Photo Uploaded by:</span>
                                    <strong><?php echo $image->getUser->first_name; ?></strong><br>
                                    <span class="date"><i class="fa fa-calendar" aria-hidden="true"></i><?php echo date("jS M Y", strtotime($image->created_at)); ?></span>
                                </div>
                            </footer>
                        </div>
                    <?php } ?>
                <?php } else { ?>
                    <div class="slide">
                        <img src="<?php echo asset('userassets/images/placeholder.jpg') ?>" alt="Image" class="img-responsive">    
                    </div>
                <?php } ?>
            </div>
            <a href="#" class="btn-prev"><i class="fa fa-angle-left" aria-hidden="true"></i></a>
            <a href="#" class="btn-next"><i class="fa fa-angle-right" aria-hidden="true"></i></a>
            <!-- <div class="pagination"></div> -->
            <div class="share-strip">
                <ul class="list-none">
                    <li>
                        <a href="#" class="share-icon"><i class="fa fa-share-alt" aria-hidden="true"></i></a>
                        <div class="custom-shares custom_style">
                            <?php
                            echo Share::page(asset('strain-details/' . $strain->id), $strain->title, ['class' => 'strain_class','id'=>$strain->id])
                                    ->facebook($strain->title)
                                    ->twitter($strain->title)
                                    ->googlePlus($strain->title);
                            ?>
                            <?php if(Auth::user()){ ?>
                      <div class="strain_class in_app_button" onclick="shareInapp('<?= asset('strain-details/'.$strain->id) ?>', '<?php echo trim(revertTagSpace($strain->title)); ?>', '<?= asset('userassets/images/logo-for-scrap.png') ?>')"> <span class="hb_icon_repost"></span> In App</div>
                            <?php } ?></div>
                    </li>
                    <li>
                        <a <?php if (checkMySaveSetting('save_strain')) { ?> href="javascript:void(0)" <?php } else { ?> href="#saved-strain" <?php } ?> <?php if ($strain->is_saved_count > 0) { ?> style="display: none"<?php } ?> class="btn-popup" onclick="addStrainMySave('<?php echo $strain->id; ?>')" id="addStrainFav<?php echo $strain->id; ?>">
                            <i class="fa fa-heart-o" aria-hidden="true"></i>
                        </a>
                        <a href="#" <?php if ($strain->is_saved_count == 0) { ?> style="display: none"<?php } ?> class="btn-popup active" onclick="removeStrainMySave('<?php echo $strain->id; ?>')" id="removeStrainFav<?php echo $strain->id; ?>">
                            <i class="fa fa-heart-o" aria-hidden="true"></i>
                        </a>
                    </li>
                </ul>
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
                                <a href="<?php if ($strain->get_review_count > 0) {
                                echo asset('strain-review-listing/' . $strain->id);
                            } else {
                                echo 'javascript:void(0)';
                            } ?>">
                                    <img src="<?php echo asset('userassets/images/chat.png') ?>" alt="Image" class="img-responsive">
                                    <span><?= $strain->get_review_count; ?> Reviews</span>
                                </a>
                            </div>
                        </div>
                        <footer class="footer">
                            <div class="align-right">
                                <ul class="list-none">
                                    <li>
                                        <a <?php if ($strain->is_liked) { ?> style="display: none"<?php } ?> href="javascript:void(0)" id="strain_like" class="white thumb ">
                                            <i class="fa fa-thumbs-up" aria-hidden="true"></i>
                                        </a>
                                        <a <?php if (!$strain->is_liked) { ?> style="display: none"<?php } ?> href="javascript:void(0)" id="strain_like_revert" class="white thumb active">
                                            <i class="fa fa-thumbs-up" aria-hidden="true"></i>
                                        </a>
                                        <span id="strain_like_count"><?= $strain->get_likes_count; ?></span>
                                    </li>
                                    <li>
                                        <a <?php if ($strain->is_disliked) { ?> style="display: none"<?php } ?> href="javascript:void(0)" id="strain_dislike" class="white thumb ">
                                            <i class="fa fa-thumbs-down" aria-hidden="true"></i>
                                        </a>
                                        <a <?php if (!$strain->is_disliked) { ?> style="display: none"<?php } ?> href="javascript:void(0)" id="strain_dislike_revert" class="white thumb active">
                                            <i class="fa fa-thumbs-down" aria-hidden="true"></i>
                                        </a>
                                        <span id="strain_dislike_count"><?= $strain->get_dislikes_count; ?></span>
                                    </li>
                                    <li>
                                        <a <?php if ($strain->is_flaged) { ?> style="display: none"<?php } ?>   class="white flag report btn-popup" href="#strain-flag<?= $strain->id ?>">
                                            <i class="fa fa-flag" aria-hidden="true"></i>
                                        </a>
                                        <a <?php if (!$strain->is_flaged) { ?> style="display: none"<?php } ?>  href="javascript:void(0)"  class="white flag active">
                                            <i class="fa fa-flag yellow-active" aria-hidden="true"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <form action="<?php echo asset('upload_strain_image') ?>"  id="upload_image" method="POST" enctype="multipart/form-data">
                                            <input type="file" name="image" id="gal-img">
                                            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                            <input type="hidden" name="strain_id" value="<?= $strain->id; ?>">
                                            <label for="gal-img"><i class="fa fa-upload" aria-hidden="true"></i></label>
                                        </form>
                                    </li>
                                    <li><a href="<?php echo asset('strain-gallery/' . $strain->id); ?>"><img src="<?php echo asset('userassets/images/galleryY.svg') ?>" alt="Image" class="img-responsive"></a></li>
                                </ul>
                            </div>
                        </footer>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="strain-flag<?= $strain->id ?>" class="popup">
    <div class="popup-holder">
        <div class="popup-area">
            <form action="<?php echo asset('strain_flag'); ?>" class="reporting-form" method="post">

                <input type="hidden" value="<?php echo $strain->id; ?>" name="strain_id">

                <input type="hidden" value="<?php echo csrf_token(); ?>" name="_token">
                <fieldset>
                    <h2>Reason For Reporting</h2>
                    
                    <input type="radio" name="group" id="sexual<?= $strain->id ?>" checked value="Nudity or sexual content">
                            <label for="sexual<?= $strain->id ?>">Nudity or sexual content</label>

                            <input type="radio" name="group" id="harasssment<?= $strain->id ?>"  value="Harassment or hate speech">
                            <label for="harasssment<?= $strain->id ?>">Harassment or hate speech</label>

                            <input type="radio" name="group" id="threatening<?= $strain->id ?>"  value="Threatening, violent, or concerning">
                            <label for="threatening<?= $strain->id ?>">Threatening, violent, or concerning</label>
                            
                    
                    <input type="radio" name="group" id="abused<?= $strain->id ?>"  value="offensive">
                    <label for="abused<?= $strain->id ?>">Strain is offensive</label>
                    <input type="radio" name="group" id="spam<?= $strain->id ?>" value="Spam">
                    <label for="spam<?= $strain->id ?>">Spam</label>
                    <input type="radio" name="group" id="unrelated<?= $strain->id ?>" value="Unrelated">
                    <label for="unrelated<?= $strain->id ?>">Unrelated</label>
                    <input type="submit" value="Send">
                    <a href="#" class="btn-close">x</a>
                </fieldset>
            </form>
        </div>
    </div>
</div>

<div id="saved-strain" class="popup light-brown">
    <div class="popup-holder">
        <div class="popup-area">
            <div class="text">
                <header class="header no-padding add">
                    <strong>Saved Strain</strong>
                </header>
                <div class="padding">
                    <p><img src="<?php echo asset('userassets/images/bg-success.svg')?>" alt="Icon">Strain saved in the app menu under My Saves</p>
                    <div class="check">
                        <input type="checkbox" id="check" onchange="addSaveSetting('save_strain',this)">
                        <label for="check">Got it! Do not show again for Strain | Save</label>
                    </div>
                </div>
                <a href="#" class="btn-close">Close</a>
            </div>
        </div>
    </div>
</div>

<script> 
         
    $('.strain_class').click(function(){
//            alert(this.id);
        $(this).parents('.custom-shares.custom_style').hide();
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
</script>