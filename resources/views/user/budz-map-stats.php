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
                        <div class="map-stats-header">
                            <?php // include 'includes/questions_search.php'; ?>
                            <form action="" method="get" class="filter_form">
                                <fieldset>
                                    <h2 class="hb_page_top_title hb_text_green hb_text_uppercase">Budz Adz Stats</h2>
                                </fieldset>
                            </form>                            
                        </div>
                        <div class="budz-sts-overview">
                            <div class="overview-title">
                                <div class="analytics-right pd-right"> 
                                    <form class="datepicker-form" id="stats" method="get" action="<?= asset('date-budz-map-stats') ?>">
                                        <input class="daterange-input" <?php if (isset($_GET['date'])) { ?> value="<?= $_GET['date'] ?>" <?php } ?>name="date" id="daterange" size="40" value="" placeholder="Click to select Range" readonly="">
                                    </form>
                                    <a href="<?= asset('filter-budz-map-stats/weekly') ?>" class="filter-by <?php if(isset($_GET['filter']) && $_GET['filter'] == 'weekly'){ echo 'all-time';}?>"> This Week</a>
                                    <a href="<?= asset('filter-budz-map-stats/monthly') ?>" class="filter-by <?php if(isset($_GET['filter']) && $_GET['filter'] == 'monthly'){ echo 'all-time';}?>"> This Month</a>
                                    <a href="<?= asset('budz-map-stats') ?>" class="filter-by <?php if(!isset($_GET['filter']) ){ echo 'all-time';}?>">All Time</a></div>
                            </div>
                        </div>
                        <div class="groups add">
                            <div class="budz-stats">
                                <div class="analytics-left budz-map">
                                    <h1>
                                        <strong class="search-count">
                                            <i style="" class="fa fa-eye"></i>
                                            <?= $view_count ?>
                                        </strong>
                                    </h1>
                                    <p class="lable1">View</p>
                                </div>
                                <div class="analytics-left budz-map">
                                    <h1>
                                        <strong class="search-count">
                                            <i style="color:red;" class="fa fa-heart"></i>
                                            <?= $save_count ?>
                                        </strong>
                                    </h1>
                                    <p class="lable1">Favorites</p>
                                </div>
                                <div class="analytics-left budz-map">
                                    <h1>
                                        <strong class="search-count">
                                            <i style="color:purple;" class="fa fa-share-alt"></i>
                                            <?= $share_count ?>
                                        </strong>
                                    </h1>
                                    <p class="lable1">Shares</p>
                                </div>
                                <div class="analytics-left budz-map">
                                    <h1>
                                        <strong class="search-count">
                                            <img class="analytics-icon" src="<?= asset('/userassets/img/keyword-blue.png') ?>" width="27px">
                                            <?= $tag_search ?>
                                        </strong>
                                    </h1>
                                    <p class="lable1">Keywords</p>
                                </div>
                                <div class="analytics-left budz-map">
                                    <h1>
                                        <strong class="search-count">
                                            <i style="color:yellow;" class="fa fa-star"></i>
                                            <?= $reviews_count ?>
                                        </strong>
                                    </h1>
                                    <p class="lable1">Reviews</p>
                                </div>
                            </div>
                            <table id="data-table" class="display" style="width:100%">
                                <div class="list-stats-title">
                                    <br><p class="color green">Budz List Stats</p><br>
                                </div>
                                <thead>
                                    <tr>
                                        <th>Budz Adz Name & Type</th>
                                        <th>Views</th>
                                        <th>Favorites</th>
                                        <th>Shares</th>
                                        <th>Reviews</th>
                                        <th>Keywords</th>
                                        <th>Call Clicks</th>
                                        <th>Tab/Ticket Views</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($budzs as $budz) { ?>
                                        <tr class="data-tr">
                                            <td data-res="Budz Adz Name & Type">
                                                <div class="wid_info">
                                                    <a href="<?= asset('single-budz-stats/' . $budz->id) ?>">
                                                        <img src="<?php echo getSubImage($budz->logo, '') ?>" alt="Icon" class="img-user">
                                                        <strong class="color purple hb_no_toppadding">
                                                            <?php if($budz->getBizType){ 
                                                                echo $budz->getBizType->title; 
                                                            }else{  
                                                                echo "Pendding";
                                                            } ?> 
                                                            <span><?= $budz->title ?></span>
                                                        </strong>
                                                    </a>
                                                </div>
                                            </td>
                                            <td data-res="Views"><?= $budz->bud_feed_views_count ?></td>
                                            <td data-res="Favorites"><?= $budz->get_user_save_count ?></td>
                                            <td data-res="Shares"><?= $budz->bud_feed_share_count ?></td>
                                            <td data-res="Reviews"><?= $budz->all_reviews_count ?></td>
                                            <td data-res="Keywords"><?= $budz->bud_feed_views_by_tag_count ?></td>
                                            <td data-res="Call Clicks"><?= $budz->bud_feed_click_to_call_count ?></td>
                                            <td data-res="Tab/Ticket Views"><?= $budz->bud_feed_click_to_ticket_count ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
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
        <script type="text/javascript" src="<?php echo asset('userassets/js/jquery.dateRangePicker.min.js') ?>"></script>
        <script type="text/javascript">
            $('#data-table').DataTable({
                columnDefs: [{
                        targets: [0],
                        orderData: [0, 1]
                    }, {
                        targets: [1],
                        orderData: [1, 0]
                    }, {
                        targets: [4],
                        orderData: [4, 0]
                    }]
            });

            var today = new Date();
            var dd = today.getDate();
            var mm = today.getMonth() + 1; //January is 0!
            var yyyy = today.getFullYear();

            if(dd<10) {
                dd = '0'+dd
            } 

            if(mm<10) {
                mm = '0'+mm
            } 

            today = yyyy+'-'+mm+'-'+dd;

            $('#daterange').dateRangePicker({minDate: 0,endDate : today}).bind('datepicker-change', function (event, obj)
            {
                $('#daterange').val(obj.value);
                $('#stats').submit();
            });
        </script>
    </body>


</html>