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
                        <div id="tab-content">
                            
                            <div id="strain-details" class="tab active">
                                <form action="<?php echo asset('save-user-strain'); ?>" class="edit-strain-form" method="POST" enctype="multipart/form-data">
                                    
                                <div class="right_content">
                                    <div class="strain-green-input desk-show">
                                        <input type="submit" class="btn-primary" value="UPDATE">
                                    </div>    
                                    <div class="tab-wid">
                                            <header class="header strain-right-col-type">
                                                <strong class="title">Type: 
<!--                                                    <span class="genetic_title <?php //echo $user_strain->genetics;?>"><?php //echo $user_strain->genetics;?></span>-->
                                                    <span class="tools-holder">
<!--                                                        <img src="<?php echo asset('userassets/images/bg-success.svg') ?>" class="success-img add tool-opener" alt="Image">
                                                        <div class="new-tools">
                                                            <p>Hybrid strains are a cross-breed of Indica and Sativa strains. Due to the plethora of possible combinations, the medical benefits, effects and sensations vary greatly.</p>
                                                            <p>Hybrid are most commonly created to target and treat specific medical conditions and illnesses.</p>
                                                            <a href="#" class="tools-closer"><i class="fa fa-times-circle" aria-hidden="true"></i></a>
                                                        </div>-->
                                                    </span>
                                                </strong>
                                                <div class="strain-right-col-h">
                                            <em class="key Hybrid">H</em>
                                            <span class="genetic_title" style="color: #7CC244"><?php echo $user_strain->genetics;?></span>
                                        </div>
                                            </header>
<!--                                            <div class="range-slider custom-slider">
                                                <input class="range-slider__range" type="range" value="<?php echo $user_strain->indica;?>" min="0" max="100">
                                                <input class="range-slider__value" type="hidden" name="indica">
                                                <span class="range-slider__value">0</span>
                                                <input type="text" class="value_changer_input hidden" value="<?php echo $user_strain->indica;?>" name="indica">
                                                <span class="total-range"><?php echo $user_strain->sativa;?></span>
                                            </div>-->
                                            <div class="range-slider custom-slider">
                                                <!--<input class="range-slider__value" type="hidden" name="indica">-->
                                                <input type="text" class="value_changer_input hidden">
                                                <span class="total-range"><?= $user_strain->indica ?></span>
                                                <input class="range-slider__range" type="range" min="0" max="100"  value="<?php echo $user_strain->sativa;?>" name="sativa">
                                                <span class="range-slider__value">0</span>

                                            </div>
<!--                                            <div class="ui_slider_labels">
                                                <span>Indica</span>
                                                <span>Sativa</span>
                                            </div>-->
                                            <div class="ui_slider_labels">
                                                <span class="tooltip-holder">
                                                    <em class="purple">Indica</em>
                                                    <div class="tools-holder">
<!--                                                        <img src="<?php echo asset('userassets/images/bg-success.svg') ?>" alt="Image" class="tool-opener">
                                                        <div class="new-tools">
                                                            <p>Indica plants typically grow short and wide which makes them better suited for indoor growing. Indica-dominant strains tend to have a strong sweet/sour odor.</p>
                                                            <p>Indicas are very effective for overall pain relief and helpful in treating general anxiety, body pain, and sleeping disorders. It is commonly used in the evening or even right before bed due to it's relaxing effects.</p>
                                                            <strong>Most Commonly Known Benefits:</strong>
                                                            <ol class="custom-benefits">
                                                                <li>Relieves body pain</li>
                                                                <li>Relaxes muscles</li>
                                                                <li>Relieves spasms, reduces seizures</li>
                                                                <li>Relieves headaches and migraines</li>
                                                                <li>Relieves anxiety or stress</li>
                                                            </ol>
                                                            <a href="#" class="tools-closer"><i class="fa fa-times-circle" aria-hidden="true"></i></a>
                                                        </div>-->
                                                    </div>
                                                </span>
                                                <span class="tooltip-holder">
                                                    <em class="red">Sativa</em>
                                                    <div class="tools-holder">
<!--                                                        <img src="<?php echo asset('userassets/images/bg-success.svg') ?>" alt="Image" class="tool-opener">
                                                        <div class="new-tools add">
                                                            <p>Sativa plants grow tall and thin, making them better suited for outdoor growing-some strains can reach over 25 ft, in height. Sativa-dominant strains tend to have a more grassy-type odor.</p>
                                                            <p>Sativa effects are known to spark creativity and produce energetic and uplifting sensations. It is commonly used in the daytime due to its cerebral stimulation.</p>
                                                            <strong>Most Commonly Known Benefits:</strong>
                                                            <ol class="custom-benefits">
                                                                <li>Produces feelings of well-being</li>
                                                                <li>Uplifting and cerebral thoughts</li>
                                                                <li>Stimulates and energizes</li>
                                                                <li>Increases focus and creativity</li>
                                                                <li>Fights depression</li>
                                                            </ol>
                                                            <a href="#" class="tools-closer"><i class="fa fa-times-circle" aria-hidden="true"></i></a>
                                                        </div>-->
                                                    </div>
                                                </span>
                                            </div>
                                        </div>
                                          <div class="tab-wid genetics no-border strain-parent-sec hb_strain_search_field_bg <?php if($user_strain->cross_breed == NULL){ echo 'hidden'; }?>">
                                            <header class="header">
                                                <strong class="title">Parentage / Genetics:</strong>
                                            </header>
                                            <div class="genetics">
                                                <img src="<?php echo asset('userassets/images/parentage.svg') ?>" alt="Image">
                                                
                                                <div class="genetic-txt add black-color">
                                                    <?php
                                                    if($user_strain->cross_breed){
                                                        $cross_breed = explode(',', $user_strain->cross_breed);
                                                        $breed1 = $cross_breed[0];
                                                        $breed2 = $cross_breed[1];
                                                    }
                                                    
                                                    ?>
                                                    <em>Cross-Breed of</em>
                                                    <span>
                                                        <select data-placeholder="Durban Poison" name="breed1" class="chosen-select" tabindex="1">
                                                            <option value=""></option>
                                                            <?php foreach ($strains as $strain){ ?>
                                                                <?php if(isset($cross_breed)){?>
                                                                    <option value="<?php echo $strain->title; ?>" <?php if($strain->title == $cross_breed[0]){ echo 'selected';}?>><?php echo $strain->title; ?></option>
                                                                <?php } ?> 
                                                                <option value="<?php echo $strain->title; ?>"><?php echo $strain->title; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </span>
                                                    <em class="margin">and</em>
                                                    <span>
                                                        <select data-placeholder="OG Kush" name="breed2" class="chosen-select" tabindex="2">
                                                            <option value=""></option>
                                                            <?php foreach ($strains as $strain){ ?>
                                                            <?php if(isset($cross_breed)){?>
                                                                    <option value="<?php echo $strain->title; ?>" <?php if($strain->title == $cross_breed[1]){ echo 'selected';}?>><?php echo $strain->title; ?></option>
                                                                <?php } ?> 
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
                                                    <input type="radio" value="low" id="low-check" name="yield" <?php if($user_strain->yeild == 'low'){ echo 'checked';}?>>
                                                    <label for="low-check">Low</label>
                                                    <input type="radio" value="medium" id="medium-check" name="yield" <?php if($user_strain->yeild == 'medium'){ echo 'checked';}?>>
                                                    <label for="medium-check">Medium</label>
                                                    <input type="radio" value="high" id="high-check" name="yield" <?php if($user_strain->yeild == 'high'){ echo 'checked';}?>>
                                                    <label for="high-check">High</label>
                                                    <span class="error_span"><?php if ($errors->has('Yield')) { echo $errors->first('Yield'); }?></span>
                                                </dd>
                                                
                                                <dt>Climate:</dt>
                                                <dd>
                                                    <input type="radio" value="indoor" id="indoor-check" name="climate" <?php if($user_strain->climate == 'indoor'){ echo 'checked';}?>>
                                                    <label for="indoor-check">Indoor</label>
                                                    <input type="radio" value="outdoor" id="outdoor-check" name="climate" <?php if($user_strain->climate == 'outdoor'){ echo 'checked';}?>>
                                                    <label for="outdoor-check">Outdoor</label>
                                                    <input type="radio" value="greenhouse" id="green-check" name="climate" <?php if($user_strain->climate == 'greenhouse'){ echo 'checked';}?>>
                                                    <label for="green-check">Greenhouse</label>
                                                    <span class="error_span"><?php if ($errors->has('climate')) { echo $errors->first('climate'); }?></span>
                                                </dd>
                                                
                                                <dt>Notes:</dt>
                                                <dd class="notes">
                                                   <!-- <input type="text" name="note" value="<?php echo $user_strain->note;?>" placeholder="Prefers moderate amounts of fertilizer. Average Yield falls between 25-30 grams per plant. May express fruity or diesel-smelling phenotypes">-->
                                                     <textarea name="note" placeholder="Add note..."><?php echo $user_strain->note;?></textarea>
                                                </dd>
                                                <span class="error_span"><?php if ($errors->has('note')) { echo $errors->first('note'); }?></span>
                                            </dl>
                                    
                                    </div>
                                <div class="left_content">           
                                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                    <input type="hidden" name="strain_id" value="<?= $user_strain->strain_id; ?>">
                                    <input type="hidden" name="user_strain_id" value="<?= $user_strain->id; ?>">
                                    <fieldset>
<!--                                        <div class="tab-wid input-file cover-banner">
                                            <img src="<?php echo asset('userassets/images/yello-banner.png') ?>"  alt="Image" class="img-responsive changer_img">
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
                                            <textarea name="description" placeholder="Optional..."><?php echo ltrim(revertTagSpace($user_strain->description)); ?></textarea>
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
                                                        <input type="number" step="any" min="0" max="100" placeholder="0.1%" name="min_CBD" value="<?=$user_strain->min_CBD?>"/>
                                                        <span class="chem-to">to</span>
                                                        <input type="number" step="any" min="0" max="100" placeholder="0.2%" name="max_CBD" value="<?=$user_strain->max_CBD?>"/>

                                                    </div>
                                                    <span class="error_span"><?php if ($errors->has('min_CBD')) { echo $errors->first('min_CBD'); }?></span>
                                                    <span class="error_span"><?php if ($errors->has('max_CBD')) { echo $errors->first('max_CBD'); }?></span>
                                                    <div class="chem-row">
                                                        <span>THC</span>
                                                        <input type="number" step="any" min="0" max="100" placeholder="1.9%" name="min_THC" value="<?=$user_strain->min_THC?>"/>
                                                        <span class="chem-to">to</span>
                                                        <input type="number" step="any" min="0" max="100" placeholder="2.4%" name="max_THC" value="<?=$user_strain->max_THC?>"/>

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
                                                   
                                                    <strong> <span class="yellow">Select</span> Difficulty Level</strong>
                                                </div>
                                                <div class="diff-col">
                                                    <input type="radio" value="easy" id="easy" name="growing" <?php if($user_strain->growing == 'easy'){ echo 'checked';}?>>
                                                    <label for="easy"><img src="<?php echo asset('userassets/images/easy.svg') ?>">Easy</label>
                                                </div>
                                                <div class="diff-col">
                                                    <input type="radio" value="moderate" id="moderate" name="growing" <?php if($user_strain->growing == 'moderate'){ echo 'checked';}?>>
                                                    <label for="moderate"><img src="<?php echo asset('userassets/images/moderate.svg') ?>">Moderate</label>
                                                </div>
                                                <div class="diff-col">
                                                    <input type="radio" value="hard" id="hard" name="growing" <?php if($user_strain->growing == 'hard'){ echo 'checked';}?>>
                                                    <label for="hard"><img src="<?php echo asset('userassets/images/hard.svg') ?>">Hard</label>
                                                </div>
                                                <span class="error_span"><?php if ($errors->has('growing')) { echo $errors->first('growing'); }?></span>
                                            </div>
                                                    </li>
                                                    <li class="inline">
                                                        <strong><span class="yellow">Enter</span>Mature Height</strong>
                                                        <img src="<?php echo asset('userassets/images/tree.png') ?>" alt="Image">
                                                        <span><input autocomplete="off"  type="text" name="plant_height" placeholder="12" value="<?php echo round($user_strain->plant_height); ?>"> "</span>
                                                        <span class="error_span"><?php if ($errors->has('plant_height')) { echo $errors->first('plant_height'); }?></span>
                                                    </li>
                                                    
                                                    <li>
                                                        <strong><span class="yellow">Enter</span>Flowering Time</strong>
                                                        <div class="flowering-time">
                                                        <input autocomplete="off"  type="text" name="flowering_time" placeholder="60" class="big" value="<?php echo $user_strain->flowering_time; ?>">
                                                        <span>days</span>
                                                        <span class="error_span"><?php if ($errors->has('flowering_time')) { echo $errors->first('flowering_time'); }?></span>
                                                        </div>
                                                        </li>
                                                    
                                                    <li class="inline">
                                                        <strong><span class="yellow">Enter</span> Hardness Zones</strong>
                                                        <img src="<?php echo asset('userassets/images/temperature.png') ?>" class="img-temp" alt="Image">
                                                        <span class="text-white">
                                                            <b>
                                                                <input autocomplete="off" type="text" name="min_fahren_temp" placeholder="30" value="<?php echo round($user_strain->min_fahren_temp); ?>"> to <input autocomplete="off"  type="text" name="max_fahren_temp" placeholder="30" value="<?php echo round($user_strain->max_fahren_temp); ?>"> °F
                                                            </b>
                                                            <b>
                                                                <input autocomplete="off"  type="text" name="min_celsius_temp" placeholder="20" value="<?php echo round($user_strain->min_celsius_temp); ?>"> to <input autocomplete="off"  type="text" name="max_celsius_temp" placeholder="40" value="<?php echo round($user_strain->max_celsius_temp); ?>"> °C
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
                                    <div class="strain-green-input mob-show">
                                        <input type="submit" class="btn-primary" value="UPDATE">
                                    </div>
                                </div>
                         
                                </form>
                            </div>
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