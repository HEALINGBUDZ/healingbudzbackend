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
                        <div class="tabbing str-tb-up">
                            <?php include 'includes/strain-header.php'; ?>
                            <ul class="tabs list-none">
                                <li class="first"><a href="<?php echo asset('strain-details/'.$strain->id); ?>">Strain Overview</a></li>
                                <li class="active second"><a href="<?php echo asset('user-strains-listing/'.$strain->id); ?>">Strain Details</a></li>
                                <!--<li class="third"><a href="#strain-overview">Gallery</a></li>-->
                                <li class="third"><a href="<?php echo asset('strain-gallery/' . $strain->id); ?>">Gallery</a></li>
                                <li class="fourth"><a href="<?php echo asset('strain-product-listing/'.$strain->id); ?>">Locate This</a></li>
                            </ul>
                        <?php /*
                        <header class="intro-header no-bg">
                            <h1 class="custom-heading white">CACTUS</h1>
                        </header>
                            <div class="strain_info_header">
                                <div class="share-strip">
                                    <ul class="list-none">
                                        <li>
                                            <form action="<?php echo asset('upload_strain_image') ?>"  id="upload_image" method="POST" enctype="multipart/form-data">
                                                <input type="file" name="image" id="gal-img">
                                                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                                <input type="hidden" name="strain_id" value="<?= $strain->id; ?>">
                                                <label for="gal-img"><i class="fa fa-upload" aria-hidden="true"></i></label>
                                            </form>
                                        </li>
                                        <li>
                                            <a href="#" class="share-icon"><i class="fa fa-share-alt" aria-hidden="true"></i></a>
                                            <div class="custom-shares custom_style">
                                                <?php
                                                echo Share::page(asset('strain-details/' . $strain->id), $strain->title, ['class' => 'strain_class','id'=>$strain->id])
                                                        ->facebook($strain->title)
                                                        ->twitter($strain->title)
                                                        ->googlePlus($strain->title);
                                                ?>
                                            </div>
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
                                <span class="dot-options">
                                    <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                    <div class="sort-drop">
                                        <div class="sort-item active">
                                            <a href="<?php echo asset('strain-gallery/' . $strain->id); ?>"><img src="<?php echo asset('userassets/images/galleryY.svg') ?>" alt="Image" class="img-responsive"> <span>Gallery</span></a>
                                        </div>
                                        <div class="sort-item">
                                            <a <?php if ($strain->is_flaged) { ?> style="display: none"<?php } ?>   class="white flag report btn-popup" href="#strain-flag<?= $strain->id ?>">
                                                <i class="fa fa-flag" aria-hidden="true"></i><span>Report</span>
                                            </a>
                                        </div>
                                        <div class="sort-item">
                                                <a <?php if (!$strain->is_flaged) { ?> style="display: none"<?php } ?>  href="javascript:void(0)"  class="white flag active">
                                                <i class="fa fa-flag yellow-active" aria-hidden="true"></i><span>Report</span>
                                            </a>
                                        </div>
                                    </div>
                                </span> 
                                <div class="align_left">
                                    <h2><?= $strain->title; ?></h2>
                                    <span class="text_middle"><?= $strain->getType->title; ?></span>
                                    <div class="rate_span text_middle">
                                        <img src="<?php echo asset('userassets/images/leaf-' . floorToFraction(number_format((float) $strain->ratingSum['total'], 1, '.', ''), 2) . '.svg') ?>" alt="Image" class="img-responsive">
                                        <span>
                                            <em><?= number_format((float) $strain->ratingSum['total'], 1, '.', ''); ?></em>
                                            <a href="<?php if ($strain->get_review_count > 0) {
                                            echo asset('strain-review-listing/' . $strain->id);
                                            } else {
                                                echo 'javascript:void(0)';
                                            } ?>"> (<?= $strain->get_review_count; ?> Reviews)
                                        </div>
                                    </span>
                                    <div class="txt">
                                        <ul class="list-none custom_likes">
                                            <li class="active">
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
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        */ ?>
                        <div class="tabbing">
                            <form action="<?php echo asset('save-user-strain'); ?>" class="edit-strain-form" method="POST" enctype="multipart/form-data">
                            <div class="right_content">
                                <div class="strain-green-input desk-show">
                                    <input type="submit" class="btn-primary" value="SUBMIT">
                                </div>
                                <div class="tab-wid">
                                    <header class="header strain-right-col-type">
                                        <strong class="title">Type: </strong>
                                        <div class="strain-right-col-h">
                                            <em class="key Hybrid">H</em>
                                            <span class="genetic_title" style="color: #7CC244">Hybrid</span>
                                        </div>
                                    </header>
                                    <div class="range-slider custom-slider">
                                        <!--<input class="range-slider__value" type="hidden" name="indica">-->
                                        <input type="text" class="value_changer_input hidden">
                                        <span class="total-range">30</span>
                                        <input class="range-slider__range" type="range" value="70" min="0" max="100"  value="<?= old('sativa')?>" name="sativa">
                                        <span class="range-slider__value">0</span>

                                    </div>
                                    <div class="ui_slider_labels">
                                        <span class="purple">Indica</span>
                                        <span class="red">Sativa</span>
                                    </div>
                                </div>
                                <div class="tab-wid genetics no-border strain-parent-sec hb_strain_search_field_bg">
                                    <header class="header">
                                        <strong class="title">Parentage / Genetics:</strong>
                                    </header>
                                    <div class="genetics">
                                        <img src="<?php echo asset('userassets/images/parentage.svg') ?>" alt="Image">
                                        <div class="genetic-txt add black-color">
                                            <em>Cross-Breed of</em>
                                            <span>
                                                <select data-placeholder="Durban Poison" name="breed1" class="chosen-select" tabindex="1">
                                                    <option value=""></option>
                                                    <?php foreach ($strains as $strain){ ?>
                                                    <option value="<?php echo $strain->title; ?>"><?php echo $strain->title; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </span>
                                            <em class="margin">and</em>
                                            <span>
                                                <select data-placeholder="OG Kush" name="breed2" class="chosen-select" tabindex="2">
                                                    <option value=""></option>
                                                    <?php foreach ($strains as $strain){ ?>
                                                    <option value="<?php echo $strain->title; ?>"><?php echo $strain->title; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <dl class="details btns">
                                    <dt>Yield:</dt>
                                    <dd>
                                        <input checked="" type="radio" value="low" id="low-check" name="yield" <?php if(old('yield') == 'low'){ echo 'checked'; }?>>
                                        <label for="low-check">Low</label>
                                        <input type="radio" value="medium" id="medium-check" name="yield" <?php if(old('yield') == 'medium'){ echo 'checked'; }?>>
                                        <label for="medium-check">Medium</label>
                                        <input type="radio" value="high" id="high-check" name="yield" <?php if(old('yield') == 'high'){ echo 'checked'; }?>>
                                        <label for="high-check">High</label>
                                        <span class="error_span"><?php if ($errors->has('yield')) { echo $errors->first('yield'); }?></span>
                                    </dd>

                                    <dt>Climate:</dt>
                                    <dd>
                                        <input checked="" type="radio" value="indoor" id="indoor-check" name="climate" <?php if(old('climate') == 'indoor'){ echo 'checked'; }?>>
                                        <label for="indoor-check">Indoor</label>
                                        <input type="radio" value="outdoor" id="outdoor-check" name="climate" <?php if(old('climate') == 'outdoor'){ echo 'checked'; }?>>
                                        <label for="outdoor-check">Outdoor</label>
                                        <input type="radio" value="greenhouse" id="green-check" name="climate" <?php if(old('climate') == 'greenhouse'){ echo 'checked'; }?>>
                                        <label for="green-check">Greenhouse</label>
                                        <span class="error_span"><?php if ($errors->has('climate')) { echo $errors->first('climate'); }?></span>
                                    </dd>

                                    <dt>Notes:</dt>
                                    <dd class="notes">
                                    <?php /*    <input type="text" name="note" placeholder="Add notes" value="<?= old('note'); ?>"> */ ?>
                                        <textarea name="note" placeholder="Add note..."></textarea>
                                    </dd>
                                    <span class="error_span"><?php if ($errors->has('note')) { echo $errors->first('note'); }?></span>
                                </dl>
                            </div>
                            <div class="left_content">
                                <div id="tab-content">
                                    <div id="strain-details" class="tab active">
                                        <div>
                                            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                            <input type="hidden" name="strain_id" value="<?= $strain_id; ?>">
                                            <fieldset>
        <!--                                        <div class="tab-wid input-file cover-banner no-border">
                                                    <img src="<?php //echo asset('userassets/images/yello-banner.png') ?>"  alt="Image" class="img-responsive changer_img">
                                                    <div class="input-caption">
                                                        <div class="d-table">
                                                            <div class="d-inline">
                                                                <input type="file" name="image" id="banner-uploader">
                                                                <label for="banner-uploader"><i class="fa fa-upload" aria-hidden="true"></i> Upload Photos</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>-->
                                                <div class="tab-wid no-border strain-des-sec">
                                                    <header class="header">
                                                        <strong class="title">Full Description:</strong>
                                                    </header>
                                                    <textarea name="description" placeholder="Optional...."><?= old('description')?></textarea>
                                                    <span class="error_span"><?php if ($errors->has('description')) { echo $errors->first('description'); }?></span>
                                                </div>
                                                <div class="tab-wid no-border strain-des-sec">
                                                    <header class="header">
                                                        <strong class="title">Chemistry:</strong>
                                                    </header>
                                                    <div class="chemist-box">
                                                        <div class="chem-img">
                                                            <img src="<?php echo asset('userassets/images/chemist.png') ?>" alt="Image">
                                                        </div>
                                                        <div class="chem-row-main">
                                                            <div class="chem-row">
                                                                <span>CBD</span>
                                                                <input type="number" step="any" min="0" value="0.1" max="100" placeholder="0.1%" required name="min_CBD"/>
                                                                <span class="chem-to">to</span>
                                                                <input type="number" step="any" min="0" value="0.2" max="100" placeholder="0.2%" required name="max_CBD"/>
                                                                
                                                            </div>
                                                            <span class="error_span"><?php if ($errors->has('min_CBD')) { echo $errors->first('min_CBD'); }?></span>
                                                            <span class="error_span"><?php if ($errors->has('max_CBD')) { echo $errors->first('max_CBD'); }?></span>
                                                            <div class="chem-row">
                                                                <span>THC</span>
                                                                <input type="number" step="any" min="0" value="1.9" max="100" placeholder="1.9%" required name="min_THC"/>
                                                                <span class="chem-to">to</span>
                                                                <input type="number" step="any" min="0"  value="2.4"max="100" placeholder="2.4%" required name="max_THC"/>
                                                                
                                                            </div>
                                                            <span class="error_span"><?php if ($errors->has('min_THC')) { echo $errors->first('min_THC'); }?></span>
                                                            <span class="error_span"><?php if ($errors->has('max_THC')) { echo $errors->first('max_THC'); }?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-wid no-border strain-des-sec">
                                                    <header class="header">
                                                        <strong class="title">Growing &amp; Care:</strong>
                                                    </header>
                                                    <div class="tab-wid">
                                                        <ul class="growing-list inputs list-none strain-two-col">
                                                            <li>
                                                                <div class="diff-levels">
                                                                    <div class="diff-col">
                                                                        <strong>
                                                                            <span class="yellow">Select</span>
                                                                            Difficulty Level</strong>
                                                                    </div>
                                                                    <div class="diff-col">
                                                                        <input checked="" type="radio" value="easy" id="easy" name="growing" <?php if(old('growing') == 'easy'){ echo 'checked'; }?>>
                                                                        <label for="easy"><img src="<?php echo asset('userassets/images/easy.svg') ?>">Easy</label>
                                                                    </div>
                                                                    <div class="diff-col">
                                                                        <input type="radio" value="moderate" id="moderate" name="growing" <?php if(old('growing') == 'moderate'){ echo 'checked'; }?>>
                                                                        <label for="moderate"><img src="<?php echo asset('userassets/images/moderate.svg') ?>">Moderate</label>
                                                                    </div>
                                                                    <div class="diff-col">
                                                                        <input type="radio" value="hard" id="hard" name="growing" <?php if(old('growing') == 'hard'){ echo 'checked'; }?>>
                                                                        <label for="hard"><img src="<?php echo asset('userassets/images/hard.svg') ?>">Hard</label>
                                                                    </div>
                                                                    <span class="error_span"><?php if ($errors->has('growing')) { echo $errors->first('growing'); }?></span>
                                                                </div>
                                                            </li>
                                                            <li class="inline">
                                                                <strong>
                                                                    <span class="yellow">Enter</span>
                                                                    Mature Height
                                                                </strong>
                                                                <img src="<?php echo asset('userassets/images/tree.svg') ?>" alt="Image">
                                                                <span><input autocomplete="off" type="text" required name="plant_height"  placeholder="12" value="<?php if(old('plant_height')){echo (old('plant_height'));}else{echo '12';} ?>"></span>
                                                                <span class="error_span"><?php if ($errors->has('plant_height')) { echo $errors->first('plant_height'); }?></span>
                                                            </li>

                                                            <li>
                                                                <strong>
                                                                    <span class="yellow">Enter</span>
                                                                    Flowering Time
                                                                </strong>
                                                                <div class="flowering-time">
                                                                    <input autocomplete="off" type="text" required name="flowering_time" placeholder="60" class="big" value="<?php if(old('plant_height')){echo (old('flowering_time'));}else{echo '60';} ?>">
                                                                    <span>days</span>
                                                                    <span class="error_span"><?php if ($errors->has('flowering_time')) { echo $errors->first('flowering_time'); }?></span>
                                                                </div>
                                                            </li>

                                                            <li class="inline">
                                                                <strong>
                                                                    <span class="yellow">Enter</span>
                                                                    Hardness Zones</strong>
                                                                <img src="<?php echo asset('userassets/images/temperature.svg') ?>" class="img-temp" alt="Image">
                                                                <span class="text-white">
                                                                    <b>
                                                                        <input autocomplete="off" type="text" required name="min_fahren_temp" placeholder="30" value="<?php if(old('plant_height')){echo (old('min_fahren_temp'));}else{echo '30';} ?>"> to <input autocomplete="off"  type="text" required name="max_fahren_temp" placeholder="30" value="<?php if(old('plant_height')){echo (old('max_fahren_temp'));}else{echo '30';} ?>"> °F
                                                                    </b>
                                                                    <b>
                                                                        <input autocomplete="off"  type="text" required name="min_celsius_temp" placeholder="20" value="<?php if(old('plant_height')){echo (old('min_celsius_temp'));}else{echo '20';} ?>"> to <input autocomplete="off"  type="text" required name="max_celsius_temp" placeholder="40" value="<?php if(old('plant_height')){echo (old('max_celsius_temp'));}else{echo '40';} ?>"> °C
                                                                    </b>
                                                                </span>
                                                                <span class="error_span"><?php if ($errors->has('min_fahren_temp')) { echo $errors->first('min_fahren_temp'); }?></span>
                                                                <span class="error_span"><?php if ($errors->has('max_fahren_temp')) { echo $errors->first('max_fahren_temp'); }?></span>
                                                                <span class="error_span"><?php if ($errors->has('min_celsius_temp')) { echo $errors->first('min_celsius_temp'); }?></span>
                                                                <span class="error_span"><?php if ($errors->has('max_celsius_temp')) { echo $errors->first('max_celsius_temp'); }?></span>
                                                            </li>

                                                        </ul>
                                                    </div>
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div>
                                </div>
                                <div class="strain-green-input mob-show">
                                    <input type="submit" class="btn-primary" value="SUBMIT">
                                </div>
                            </div>
                                </form>
                        </div>
                    </div>
                    </div>
                    <div class="right_sidebars">
                        <?php include 'includes/rightsidebar.php'; ?>
                        <?php include 'includes/chat-rightsidebar.php'; ?>
                    </div>
                </div>
            </article>
        </div>
        <?php include('includes/footer.php'); ?>
    </body>
</html>
           <script src="     https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/additional-methods.js"></script>
<script>

            $(".edit-strain-form").validate({
                showErrors: function (errorMap, errorList) {
                    $(".edit-strain-form").find("input").each(function () {
                        $(this).removeClass("error");
                    });
                    if (errorList.length) {
                        $(errorList[0]['element']).addClass("error");
                    }
                }
            });
</script>