<!DOCTYPE html>
<html lang="en">
    <?php include('includes/top-new.php'); ?>
    <body id="body">
        <div id="wrapper">
        <?php include('includes/sidebar.php'); ?>
            <article id="content">
                <?php include('includes/header.php'); ?>
                <div class="padding-div">
                    <ul class="bread-crumbs list-none">
                        <li><a href="<?php echo asset('/'); ?>">Home</a></li>
                        <li>Strains</li>
                    </ul>
                    <div class="new_container">
                        <div class="ask-area">
                            <?php // include 'includes/questions_search.php'; ?>
                            <form action="<?php echo asset('strains-filter'); ?>" method="get" class="filter_form">
                                <fieldset>
                                    <h2 class="no-margin yellow">Advanced Strain Matching</h2>
                                    <div class="filter-space-strain" style="display: none;">
                                        <select data-placeholder="Begin typing search term" name="medical_use" class="chosen-select" id="medical_condition" tabindex="1">
                                            <option value=""></option>
                                            <?php foreach ($medical_conditions as $medical_condition) { ?>
                                                <option value="<?php echo $medical_condition->m_condition; ?>"><?php echo $medical_condition->m_condition; ?></option>
                                            <?php } ?>
                                        </select>
                                        <select data-placeholder="Begin typing search term" name="disease_prevention" class="chosen-select" id="prevention" tabindex="2">
                                            <option value=""></option>
                                            <?php foreach ($preventions as $prevention) { ?>
                                                <option value="<?php echo $prevention->prevention; ?>"><?php echo $prevention->prevention; ?></option>
                                            <?php } ?>
                                        </select>
                                        <select data-placeholder="Begin typing search term" name="mood_sensation" class="chosen-select" id="sensation" tabindex="3">
                                            <option value=""></option>
                                            <?php foreach ($sensations as $sensation) { ?>
                                                <option value="<?php echo $sensation->sensation; ?>"><?php echo $sensation->sensation; ?></option>
                                            <?php } ?>
                                        </select>
                                        <select data-placeholder="Begin typing search term" name="flavor" class="chosen-select" id="flavor" tabindex="4">
                                            <option value=""></option>
                                            <?php foreach ($flavors as $flavor) { ?>
                                                <option value="<?php echo $flavor->flavor; ?>"><?php echo $flavor->flavor; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="row">
                                        <p>Match suggestions are calculated by feedback and experience shared by the<br> healing budz community.</p>
                                        <input type="submit" class="yellow" value="Show Best Match">
                                    </div>
                                </fieldset>
                            </form>                            
                        </div>
                        <div class="strain-search search-area updated">
                            <div class="clear_filter">
                                <div>
                                    <div class="search-strain-text">
                                        <strong>Your Matches</strong>
                                        <span>Based on your search criteria</span>
                                    </div>
                                    <div class="search-strain-save">
                                        <?php if(Auth::user()){ ?>
                                        <a href="#savesearch" class="btn-primary green btn-popup"><i class="fa fa-save"></i>Save Search</a>
                                        <?php } else{ ?>
                                        <a href="#loginModal" class="btn-primary green thumb new_popup_opener be-btn"><i class="fa fa-save"></i>Save Search</a>
                                        <?php } ?>
                                    </div>
                                </div>
                                <a href="<?php echo asset('strains-list'); ?>" class="filter_clear_btn"><i class="fa fa-times" aria-hidden="true"></i> Clear Search Filters</a>
                            </div>
                          
                        </div>
                        <div class="groups add">
                            <header class="intro-header">
                                <h1 class="custom-heading white border-bottom yellow padding-bottom">STRAINS</h1>

                                <ul class="list-none strains-stats">
                                    <li>
                                        <img src="<?php echo asset('userassets/images/bars.png') ?>">
                                        <span style="display:none;"><a href="<?php echo asset('strains-list'); ?>">Listed Alphabetically</a></span>
                                        <span class="matched">Your Matches<i>Based on your search criteria</i></span>
                                    </li>
                                    <li><a href="<?php echo asset('strains-search-type/2'); ?>"><em class="indica">I</em> <span>= Indica</span></a></li>
                                    <li><a href="<?php echo asset('strains-search-type/3'); ?>"><em class="sativa">S</em> <span>= Sativa</span></a></li>
                                    <li><a href="<?php echo asset('strains-search-type/1'); ?>"><em class="hybrid">H</em> <span>= Hybrid</span></a></li>
                                </ul>
                            </header>
                             <!--<div class="clear-filters"><a href="<?php // echo asset('strains-list'); ?>">Clear Search Filters <i class="fa fa-times"></i></a></div>--> 
                            <!-- <div class="relevance">
                                <span><em>Match Relevance</em></span>
                                <span><em>Match Relevance</em></span>
                            </div> -->
                            <ul class="list-none strains-list str-filt" id="strains_listing">
                                <?php if (count($strains) != 0) { ?>
                                    <?php foreach ($strains as $strain) { ?>
                                        <li>
                                            <div class="reviews">
                                                <em class="key <?= $strain->getStrain->getType->title; ?>"><?= substr($strain->getStrain->getType->title, 0, 1); ?></em>
                                                <div class="custom">
                                                    <div class="custom-txt-holder">
                                                    <div class="review-rating">
                                                        <img src="<?php echo asset('userassets/images/leaf-' . floorToFraction(number_format((float) $strain->getStrain->ratingSum['total'], 1, '.', ''), 2) . '.svg'); ?>" alt="Img">
                                                        <em><?= number_format((float) $strain->getStrain->ratingSum['total'], 1, '.', ''); ?></em>
                                                    </div>
                                                    <span><?= count($strain->getStrain->getReview); ?> Reviews</span>
                                                    </div>
                                                    <div class="out-of"><?php echo $strain->matched; ?> of 4</div>
                                                </div>
                                            </div>
                                            <div class="link">
                                                <a href="<?php echo asset('strain-details/'.$strain->getStrain->id); ?>"><?= $strain->getStrain->title; ?></a>
                                            </div>
                                        </li>
                                    <?php } ?>
                                <?php }else{ ?>
                                    <div>No result found </div>
                                <?php } ?>
                            </ul>
                            <div style="display: none" class="hb_simple_loader" id="loading"><img src="<?php echo asset('userassets/images/new_loadeer.svg') ?>" alt="Loading . . . ." class="post-loader"><span></span></div>
                        </div>
                    </div>
                    <div class="right_sidebars">
                    <?php if(Auth::user()){ include 'includes/rightsidebar.php'; ?>
                    <?php include 'includes/chat-rightsidebar.php'; } ?>
                    </div>
                </div>
            </article>
        </div>
        <?php
            if (isset($_GET['title'])) {
                $title = $_GET['title'];
            } else {
                $title = '';
            }
            if (isset($type_id)) {
                $type_id = $type_id;
            } else {
                $type_id = '';
            }
            if (isset($_GET['medical_use'])) {
                $medical_use = $_GET['medical_use'];
            } else {
                $medical_use = '';
            }
            if (isset($_GET['disease_prevention'])) {
                $disease_prevention = $_GET['disease_prevention'];
            } else {
                $disease_prevention = '';
            }
            if (isset($_GET['mood_sensation'])) {
                $mood_sensation = $_GET['mood_sensation'];
            } else {
                $mood_sensation = '';
            }
            if (isset($_GET['flavor'])) {
                $flavor = $_GET['flavor'];
            } else {
                $flavor = '';
            }
        ?>
        <!-- Delete Review Modal -->
        <div id="savesearch" class="popup save-popup">
            <div class="popup-holder">
                <div class="popup-area">
                    <div class="text">
                        <div class="edit-holder">
                            <div class="step">
                                <div class="step-header">
                                    <h4>Save Search </h4>
                                </div>
                                <form method="post" action="<?= asset('save-strain-search')?>" >
                                    <input autocomplete="off" type="text" required="" name="title" placeholder="Name your search..."> 
                                    <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                    <input type="hidden" name="medical_use" value="<?= $_GET['medical_use']?>">
                                    <input type="hidden" name="disease_prevention" value="<?= $_GET['disease_prevention']?>">
                                    <input type="hidden" name="mood_sensation" value="<?= $_GET['mood_sensation']?>">
                                    <input type="hidden" name="flavor" value="<?= $_GET['flavor']?>">
                                    <div class="cus-row">
                                        <div class="cus-col">
                                            <img src="<?php echo asset('userassets/images/i-green.png') ?>" alt="" />
                                            <span>Searches are saved in My Save</span>
                                        </div>
                                        <input type="submit" class="btn-heal" value="Save search">
                                    </div>
<!--                                <a href="#" class="btn-heal">save</a>-->
                                </form>
                            </div>
                        </div>
                        <a href="#" class="btn-close"></a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal End-->
        <?php include('includes/footer-new.php'); ?>
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>-->
        <script>
            $(document).ready(function() {

                $('#medical_condition').val("<?= $medical_use ?>").trigger('chosen:updated');
                $('#prevention').val("<?= $disease_prevention ?>").trigger('chosen:updated');
                $('#sensation').val("<?= $mood_sensation ?>").trigger('chosen:updated');
                $('#flavor').val("<?= $flavor ?>").trigger('chosen:updated');

            });

            var win = $(window);
            var count = 1;
            var ajaxcall = 1;
            var title = '<?= $title ?>';
            var type_id = '<?= $type_id ?>';
            var medical_use = '<?= $medical_use ?>';
            var disease_prevention = '<?= $disease_prevention ?>';
            var mood_sensation = '<?= $mood_sensation ?>';
            var flavor = '<?= $flavor ?>';

            win.on('scroll', function () {
                var docheight = parseInt($(document).height());
                var winheight = parseInt(win.height());
                var differnce = (docheight - winheight) - win.scrollTop();
                if (differnce < 100) {
                    if (ajaxcall === 1) {
                        $('#loading').show();
                        ajaxcall = 0;
                        $.ajax({
                            url: "<?php echo asset('get-strain-loader') ?>",
                            type: "GET",
                            data: {
                                "count": count,
                                "title": title,
                                "type_id": type_id,
                                "medical_use": medical_use,
                                "disease_prevention": disease_prevention,
                                "mood_sensation": mood_sensation,
                                "flavor": flavor
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
                                    $('#loading').hide();
                                    noposts = ' <div class="loader hb_not_more_posts_lbl" id="nomoreposts">No More Strains To Show</div> ';
                                    $('#strains_listing').append(noposts);
                                }
                            }
                        });
                    }
                    
                }
            });
        </script>
    </body>

</html>