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
                        <div class="ask-area key-form-filt">
                            <?php // include 'includes/questions_search.php'; ?>
                            <form action="" method="get" class="filter_form">
                                <fieldset>   
                                    <div class="row analytics-header">
                                        <p class="no-margin color green" style="padding:0px;"><i class="fa fa-bar-chart-o"></i> Keywords Analytics</p><br><br>
                                        <a  href="<?php echo asset('list-user-keywords') ?>"><i class="fa fa-long-arrow-left"></i> Back to your Keywords List</a>
                                    </div>

                                </fieldset>
                            </form>                            
                        </div>
                        <div class="key-analy">
                            <div class="overview-title">
                                <div class="analytics-left"> <h4><img src="<?php echo asset('userassets/img/overview.png') ?>" /> OVERVIEW</h4></div>
                                <div class="analytics-right pd-right"> 
                                    <form class="datepicker-form" id="stats" method="get" action="<?= asset('date-keyword-analytics/' . $keyword_id . '/' . $zip_code) ?>">
                                        <input class="daterange-input" <?php if (isset($_GET['date'])) { ?> value="<?= $_GET['date'] ?>" <?php } ?> name="date"  id="daterange" size="40" value="" placeholder="Click to select Range" readonly="">
                                    </form> 
                                    <a href="<?= asset('filter-keyword-analytics/' . $keyword_id . '/' . $zip_code . '/' . 'weekly') ?>" class="filter-by <?php if ($_GET['filter'] == 'weekly') {
                                echo 'all-time';
                            } ?>"> This Week</a>
                                    <a href="<?= asset('filter-keyword-analytics/' . $keyword_id . '/' . $zip_code . '/' . 'monthly') ?>" class="filter-by <?php if ($_GET['filter'] == 'monthly') {
                                echo 'all-time';
                            } ?>"> This Month</a>
                                    <a href="<?= asset('keyword-analytics/' . $keyword_id . '/' . $zip_code) ?>" class="filter-by <?php if (!$_GET['filter']) {
                                echo 'all-time';
                            } ?>">All Time</a></div>
                            </div>
                        </div>
                        <div class="groups add key-overview">
                            <div class="overview">
                                <div class="analytics-left">
                                    <p class="keyword-text">Insight of Keyword:</p>
                                    <h3><strong class="color white">‘<?= $key_word->getTag->title; ?>’</strong></h3>
                                </div>
                                <div class="analytics-right send-email">
                                    <p class="keyword-text"><img src="<?php echo asset('userassets/img/mail.png') ?>" width="25px" />Want to generate email to show weekly report <br>at the end of week?</p>
                                    <form method="post" action="<?php echo asset('keywords-stats-mail'); ?>">
                                        <input type="hidden" name="keyword_id"  value="<?= $keyword_id ?>" >
                                        <input type="hidden" name="zip_code"  value="<?= $zip_code ?>" >
                                        <input type="hidden" name="date" <?php if (isset($_GET['date'])) { ?> value="<?= $_GET['date'] ?>" <?php } ?>>
                                        <input type="hidden" name="filter" <?php if (isset($_GET['filter'])) { ?> value="<?= $_GET['filter'] ?>" <?php } ?>>
                                        <input type="submit" class="send-btn" >
                                    </form>
                                    <!--<button class="send-btn">Send Now</button>-->
                                </div>
                            </div>
                            <div class="overview-analytics">
<?php if ($key_word->zip_code_searches_count) { ?>
                                    <div class="analytics-left">
                                        <h1><strong class="search-count"> <?= $key_word->zip_code_searches_count ?></strong></h1>
                                        <p class="keyword-text">Searched in specific zip code</p>
                                    </div>
                                <?php } else { ?>
                                    <div class="analytics-left data-collected">
                                        <p class="keyword-text"><img src="<?php echo asset('userassets/img/img12.png') ?>" width="25px"/>&nbsp; &nbsp; No data collected</p>
                                        <p class="keyword-text">Searched in specific zip code</p>
                                    </div>
                                <?php } ?>
<?php if ($key_word->budz_feed_count) { ?>
                                    <div class="analytics-right">
                                        <h1><strong class="search-count"> <?= $key_word->budz_feed_count; ?></strong></h1>
                                        <p class="keyword-text">Rented keyword lead to budz adz</p>
                                    </div>
                                <?php } else { ?>
                                    <div class="analytics-right data-collected">
                                        <p class="keyword-text"><img src="<?php echo asset('userassets/img/img12.png') ?>" width="25px"/>&nbsp; &nbsp; No data collected</p>
                                        <p class="keyword-text">Rented keyword lead to budz adz</p>
                                    </div>
                                <?php } ?>
<?php if ($key_word->click_to_tab_count) { ?>
                                    <div class="analytics-left">
                                        <h1><strong class="search-count"> <?= $key_word->click_to_tab_count; ?></strong></h1>
                                        <p class="keyword-text">CTA has been taped on budz adz</p>
                                    </div>
                                <?php } else { ?>
                                    <div class="analytics-left data-collected">
                                        <p class="keyword-text"><img src="<?php echo asset('userassets/img/img12.png') ?>" width="25px" />&nbsp; &nbsp; No data collected</p>
                                        <p class="keyword-text"> CTA has been taped on budz adz</p>
                                    </div>
                                <?php } ?>
                                <?php $featured_searched = $key_word->budzFeed->where('subUser', '!=', '')->count();
                                if ($featured_searched) {
                                    ?>
                                    <div class="analytics-right">
                                        <h1><strong class="search-count"> <?= $featured_searched; ?></strong></h1>
                                        <p class="keyword-text">Featured Business has been viewed</p>
                                    </div>
<?php } else { ?>
                                    <div class="analytics-right data-collected">
                                        <p class="keyword-text"><img src="<?php echo asset('userassets/img/img12.png') ?>" width="25px" />&nbsp; &nbsp; No data collected</p>
                                        <p class="keyword-text">Featured Business has been viewed</p>
                                    </div>
<?php } ?>
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
<?php include('includes/footer-new.php'); ?>
        <link rel="stylesheet" href="<?php echo asset('userassets/css/daterangepicker.min.css') ?>">

        <script type="text/javascript" src="<?php echo asset('userassets/js/jquery.daterangepicker.min.js') ?>"></script>
        <script type="text/javascript">
            var today = new Date();
            var dd = today.getDate();
            var mm = today.getMonth() + 1; //January is 0!
            var yyyy = today.getFullYear();

            if (dd < 10) {
                dd = '0' + dd
            }

            if (mm < 10) {
                mm = '0' + mm
            }

            today = yyyy + '-' + mm + '-' + dd;
            $('#daterange')
                    .dateRangePicker({minDate: 0,endDate : today}).bind('datepicker-change', function (event, obj)
            {
                $('#daterange').val(obj.value);
                $('#stats').submit();
            });
        </script>
    </body>
</html>