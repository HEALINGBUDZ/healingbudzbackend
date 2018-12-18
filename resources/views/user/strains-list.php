<!DOCTYPE html>
<html lang="en">
    <?php include('includes/top.php'); ?>
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
                                        <select data-placeholder="Medical Use" name="medical_use" class="chosen-select" tabindex="1" id="m_use" onchange="checkIfvalue()">
                                            <option value=""></option>
                                            <?php foreach ($madical_conditions as $madical_condition) { ?>
                                                <option value="<?php echo $madical_condition->m_condition; ?>"><?php echo $madical_condition->m_condition; ?></option>
                                            <?php } ?>
                                        </select>
                                        <select data-placeholder="Disease Prevention" name="disease_prevention" class="chosen-select" tabindex="2" id="disease" onchange="checkIfvalue()"> 
                                            <option value=""></option>
                                            <?php foreach ($preventions as $prevention) { ?>
                                                <option value="<?php echo $prevention->prevention; ?>"><?php echo $prevention->prevention; ?></option>
                                            <?php } ?>
                                        </select>
                                        <select data-placeholder="Mood & Sensation" name="mood_sensation" class="chosen-select" tabindex="3" id="mood" onchange="checkIfvalue()">
                                            <option value=""></option>
                                            <?php foreach ($sensations as $sensation) { ?>
                                                <option value="<?php echo $sensation->sensation; ?>"><?php echo $sensation->sensation; ?></option>
                                            <?php } ?>
                                        </select>
                                        <select data-placeholder="Flavor Profile" name="flavor" class="chosen-select" tabindex="4" id="flav" onchange="checkIfvalue()">
                                            <option value=""></option>
                                            <?php foreach ($flavors as $flavor) { ?>
                                                <option value="<?php echo $flavor->flavor; ?>"><?php echo $flavor->flavor; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="row">
                                        <p>Match suggestions are calculated by feedback and experience shared by the<br> healing budz community.</p>
                                        <input id="filter_record" type="submit" class="yellow" value="Show Best Match" disabled="">
                                    </div>
                                </fieldset>
                            </form>                            
                        </div>
                        <div class="groups add">
                            <header class="intro-header no-bg text-center">
                                <h1 class="custom-heading white border-bottom yellow padding-bottom text-center"> <img src="<?php echo asset('userassets/images/side-icon14.svg') ?>" alt="icon" class="small-icon"> STRAINS</h1>
                                <div class="strains-search">
                                    <a href="#" class="strains-search-opener">Strain Search <i class="fa fa-angle-down" aria-hidden="true"></i></a>
                                    <div class="strains-filter toggle-strain">
                                        <h3>Search by:</h3>
                                        <form action="<?php echo asset('strains-search'); ?>" method="get">
                                            <fieldset>
                                                <input type="search" placeholder="Name or keyword" name="title">
                                                <button type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
                                            </fieldset>
                                        </form>
                                        <span class="else">or</span>
                                        <h3>Strain Matching</h3>
                                        <p>Use our advanced filtering to find strain matches based on medical use, disease prevention, sensation and/or flavor profile.</p>
                                        <div class="custom-txt">
                                            <span>Match suggestions are calculated by feedback and experience shared by the Healing Budz community.</span>
                                        </div>
                                        <a href="#" class="btn-primary matches-opener">Help me find matches</a>
                                        <span class="closer"><i class="fa fa-angle-up" aria-hidden="true"></i></span>
                                    </div>
                                    <div class="strains-filter matches">
                                        <h3>Filter by:</h3>
                                        <form action="<?php echo asset('strains-filter'); ?>" method="get">
                                            <fieldset>
                                                <strong>Enter a search term for one or all.</strong>
                                                <h4>Medical Use:</h4>
                                                <select data-placeholder="Begin typing search term" name="medical_use" class="chosen-select" tabindex="1">
                                                    <option value=""></option>
                                                    <?php foreach ($madical_conditions as $madical_condition) { ?>
                                                        <option value="<?php echo $madical_condition->m_condition; ?>"><?php echo $madical_condition->m_condition; ?></option>
                                                    <?php } ?>
                                                </select>
                                                <h4>Disease Prevention:</h4>
                                                <select data-placeholder="Begin typing search term" name="disease_prevention" class="chosen-select" tabindex="2">
                                                    <option value=""></option>
                                                    <?php foreach ($preventions as $prevention) { ?>
                                                        <option value="<?php echo $prevention->prevention; ?>"><?php echo $prevention->prevention; ?></option>
                                                    <?php } ?>
                                                </select>
                                                <h4>Mood &amp; Sensation:</h4>
                                                <select data-placeholder="Begin typing search term" name="mood_sensation" class="chosen-select" tabindex="3">
                                                    <option value=""></option>
                                                    <?php foreach ($sensations as $sensation) { ?>
                                                        <option value="<?php echo $sensation->sensation; ?>"><?php echo $sensation->sensation; ?></option>
                                                    <?php } ?>
                                                </select>
                                                <h4>Flavor Profile:</h4>
                                                <select data-placeholder="Begin typing search term" name="flavor" class="chosen-select" tabindex="4">
                                                    <?php foreach ($flavors as $flavor) { ?>
                                                        <option value="<?php echo $flavor->flavor; ?>"><?php echo $flavor->flavor; ?></option>
                                                    <?php } ?>
                                                </select>
                                                <input type="submit" value="Show Matches">
                                            </fieldset>
                                        </form>
                                        <span class="closer"><i class="fa fa-angle-up" aria-hidden="true"></i></span>
                                    </div>
                                </div>
                                <!--                                <ul class="list-none strains-stats">
                                                                    <li>
                                                                        <img src="<?php echo asset('userassets/images/bars.png') ?>">
                                                                        <span><a href="<?php echo asset('strains-list?filter=alphabetically'); ?>">Listed Alphabetically</a></span>
                                                                    </li>
                                                                    <li><a href="<?php echo asset('strains-search-type/2'); ?>"><em class="indica">I</em> <span>= Indica</span></a></li>
                                                                    <li><a href="<?php echo asset('strains-search-type/3'); ?>"><em class="sativa">S</em> <span>= Sativa</span></a></li>
                                                                    <li><a href="<?php echo asset('strains-search-type/1'); ?>"><em class="hybrid">H</em> <span>= Hybrid</span></a></li>
                                                                </ul>-->
                            </header>
                            <div class="strain-btn-alpha">
                                <img src="<?php echo asset('userassets/images/alpha.png') ?>">

                                <?php if (isset($_GET['filter']) && $_GET['filter'] == 'alphabetically') { ?>
                                    <a href="<?php echo asset('strains-list'); ?>">List Newest</a>
                                <?php } else { ?>
                                    <a href="<?php echo asset('strains-list?filter=alphabetically'); ?>">List Alphabetically</a>
                                <?php } ?>
                            </div>
                            <ul class="list-none strains-list add" id="strains_listing">
                                <li class="list_header">
                                    <span class="fluid">Strain Name</span>
                                    <span>Type</span>
                                    <span class="right">Reviews</span>
                                </li>
                                <?php if (count($strains) != 0) { ?>
                                    <?php foreach ($strains as $strain) { ?>
                                        <li>
                                            <div class="reviews">
                                                <a href="<?= asset('strains-list?filter=alphabetically&typeid='.$strain->type_id)?>"><em class="key <?= $strain->getType->title; ?>"><?= substr($strain->getType->title, 0, 1); ?></em></a>
                                                <div class="custom">
                                                    <div class="custom-txt-holder no-float">
                                                        <img src="<?php echo asset('userassets/images/leaf-' . floorToFraction(number_format((float) $strain->ratingSum['total'], 1, '.', ''), 2) . '.svg'); ?>" alt="Img">
                                                        <div class="review-rating">
                                                            <em class="rate-fraction"><?= number_format((float) $strain->ratingSum['total'], 1, '.', ''); ?></em>
                                                            <span><?= $strain->get_review_count; ?> Reviews</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="link">
                                                <img src="<?php echo asset('userassets/images/side-icon14.svg') ?>" alt="icon">
                                                <a href="<?php echo asset('strain-details/' . $strain->id); ?>"><?= $strain->title; ?></a>
                                            </div>
                                        </li>
                                    <?php } ?>

                                <?php } else { ?>
                                    <div class="loader hb_not_more_posts_lbl" id="no_more_strain">No More Strains To Show</div>
                                <?php } ?>

                                <div style="display: none" class="hb_simple_loader" id="loading"><img src="<?php echo asset('userassets/images/new_loadeer.svg') ?>" alt="Loading . . . ." class="post-loader"><span></span></div>
                            </ul>
                        </div>
                    </div>
                    <div class="right_sidebars">
                        <?php if(Auth::user()){ include 'includes/rightsidebar.php'; ?>
                        <?php include 'includes/chat-rightsidebar.php';} ?>
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
        if (isset($typeid)) {
            $typeid = $typeid;
        } else {
            $typeid = '';
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

        if (isset($_GET['filter'])) {
            $filter = $_GET['filter'];
        } else {
            $filter = '';
        }
        if (isset($_GET['type_id'])) {
            $type_id = $_GET['type_id'];
        } else {
            $type_id = '';
        }
        ?>
        <?php include('includes/footer-new.php'); ?>
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>-->
        <script>

            var win = $(window);
            var count = 1;
            var ajaxcall = 1;
            var title = '<?= $title ?>';
            var type_id = '<?= $type_id ?>';
            var medical_use = '<?= $medical_use ?>';
            var disease_prevention = '<?= $disease_prevention ?>';
            var mood_sensation = '<?= $mood_sensation ?>';
            var flavor = '<?= $flavor ?>';
            var filter = '<?= $filter ?>';
            var typeid = '<?= $typeid ?>';
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
                                "flavor": flavor,
                                "filter": filter,
                                "typeid":typeid
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
                                    $('#no_more_strain').hide();
                                    $('#loading').hide();
                                    noposts = ' <div class="loader hb_not_more_posts_lbl" id="nomoreposts">No More Strains To Show</div> ';
                                    $('#strains_listing').append(noposts);
                                }
                            }
                        });
                    }

                }
            });
            function checkIfvalue() {
                var m_use = $('#m_use').val();
                var disease = $('#disease').val();
                var mood = $('#mood').val();
                var flav = $('#flav').val();
                if (m_use || disease || mood || flav) {
                    $('#filter_record').prop("disabled", false);
                } else {
                    $('#filter_record').prop("disabled", true);
                }
            }
        </script>

    </body>

</html>