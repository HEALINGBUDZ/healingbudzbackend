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
                        <div class="my-saves">
                            <div class="activity-log-header">
                                <div class="search-area">
                                    <h2 class="hb_page_top_title hb_text_white hb_text_uppercase">Global Search</h2>
                                    <div class="sort-dropdown">
                                        <div class="form-holder">
                                            <form method="get" action="<?php echo asset('globle-search'); ?>" id="filter_search_form">
                                                <input type="hidden" name="q" value="<?= $_GET['q'] ?>">
                                                <fieldset>
                                                    <select name="filter" id="sorting_value" onchange="getSearchFilter()">
                                                        <?php if (isset($_GET['filter'])) { ?>
                                                            <option value="<?php echo $_GET['filter']; ?>" selected="" ><?php echo $_GET['filter']; ?> </option>
                                                        <?php } else { ?>
                                                            <option value="" selected="">Global Search Filter</option>
                                                        <?php } ?>
                                                    </select>
                                                </fieldset>
                                            </form>
                                            <a href="#" class="options-toggler opener gray"><i class="fa fa-caret-down" aria-hidden="true"></i></a>
                                        </div>
                                        <div class="options gray">
                                            <ul class="list-none">
                                                <li>
                                                    <img src="<?php echo asset('userassets/images/QA.png') ?>" alt="Answer">
                                                    <span>Q & A</span>
                                                </li>
                                                <li>
                                                    <img src="<?php echo asset('userassets/images/opt6.png') ?>" alt="Budz adz">
                                                    <span>BUDZ ADZ</span>
                                                </li>
                                                <li>
                                                    <img src="<?php echo asset('userassets/images/men-gray.png') ?>" alt="Users">
                                                    <span>USER</span>
                                                </li>
                                                <li>
                                                    <img src="<?php echo asset('userassets/images/opt7.png') ?>" alt="Strains">
                                                    <span>STRAINS</span>
                                                </li>
                                            </ul>
                                            <a href="#" class="options-toggler closer gray"><i class="fa fa-caret-down" aria-hidden="true"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php if (Session::has('success')) { ?>
                                <h5 class="alert alert-success"><?php echo Session::get('success'); ?></h5>
                            <?php } ?>
                            <ul class="activities list-none" id="seacch_listing">
                                <li>
                                    <div class="filter-bottom budz-fil">
                                                                        <div class="listing-area">
                                                                            <ul class="list-none" id='budz_map_listing'>
                                                                                <?php foreach ($sub_users as $sub_user) { ?>
                                                                                    <li class="subusers <?php if ($sub_user->subscriptions) { ?> filter-black <?php } ?>" data-filter="<?php
                                                                                    if ($sub_user->getBizType) {
                                                                                        echo $sub_user->getBizType->title;
                                                                                    }
                                                                                    ?>">
                                                                                        <div class="listing-txt">
                                                                                            <a href="<?php echo asset('get-budz?business_id=' . $sub_user->id . '&business_type_id=' . $sub_user->business_type_id.'&keyword='.$_GET['q']. '&q=' . $_GET['q']); ?>" class="listing-text image-inner-anch">
                                                                                                <div class="img-holder">
                                                                                                    <img src="<?php echo getSubImage($sub_user->logo, '') ?>" alt="Image" class="img-responsive small-img">
                                                                                                    <!--<img src="<?php //echo asset('userassets/images/' . $sub_user->getBizType->title . '.svg')   ?>" alt="Docter" class="sub-image" />-->
                                                                                                    <img src="<?php echo getBusinessTypeIcon($sub_user->getBizType->title); ?>" alt="Docter" class="sub-image" />
                                                                                                </div>
                                                                                                <span class="name"><?php
                                                                                                    if ($sub_user->getBizType) {
                                                                                                        echo $sub_user->getBizType->title;
                                                                                                    }
                                                                                                    ?></span>
                                                                                                <span class="designation"><?php echo $sub_user->title; ?></span>
                                                                                            </a>
                                                                                            <ul class="features">
                                                                                                <?php if ($sub_user->is_organic) { ?>
                                                                                                    <li><img src="<?php echo asset('userassets/images/icon-plant.svg') ?>" alt="Plant"> Organic</li>
                                                                                                <?php } if ($sub_user->is_delivery) { ?>
                                                                                                    <li><img src="<?php echo asset('userassets/images/icon-van.svg') ?>" alt="Van"> We Deliver</li>
                                                                                                <?php } ?>
                                                                                            </ul>
                                                                                            <div class="listing-info">
                                                                                                <span class="time"><img src="<?php echo asset('userassets/images/pin-pink.png') ?>" alt="Plant"> <?php echo round($sub_user->distance); ?> miles away</span>
                                                                                            </div>
                                                                                            <div class="listing-info li-in-right">
                                                                                                <div class="budz_rating" data-rating="<?php if ($sub_user->ratingSum) echo $sub_user->ratingSum->total; ?>"></div>
                                                                                                <b><?php echo count($sub_user->review); ?></b> Reviews
                                                                                            </div>
                                                                                        </div>
                                                                                    </li>
                                                                                <?php } ?>  
                                                                            </ul>
                                                                            <div style="display: none" class="hb_simple_loader" id="loading"><img src="<?php echo asset('userassets/images/new_loadeer.svg') ?>" alt="Loading . . . ." class="post-loader"><span></span></div>
                                                                        </div>
                                                                    </div>
                                </li>
                                <?php
                                if (count($all_records) > 0) {
                                    foreach ($all_records as $key => $records) {
                                        ?>
                                        <div class="date-main-act">
                                            <i class="fa fa-calendar"></i>
                                            <span><?= $key ?></span>
                                        </div>
                                        <?php
                                        foreach ($records as $record) {

                                            $type = $record->s_type;
                                            $to_show = TRUE;
                                            if ($type == 'u') {
                                                if ($record->id == $current_id) {
                                                    $to_show = '';
                                                }
                                            }
                                            if ($to_show) {
                                                ?>
                                                <li>
                                                    <?php
                                                    if ($type == 's') {
                                                        $url = asset('strain-details/' . $record->id . '?q=' . $_GET['q']);
                                                        $src = asset('userassets/images/icon03.svg');
                                                    }
                                                    ?>
                                                    <?php
                                                    if ($type == 'u') {
                                                        $url  = asset('user-profile-detail/' . $record->id);
                                                        $user = getUser($record->id);
                                                        $src  = getImage($user->image_path, $user->avatar);
                                                    }
                                                    ?>
                                                    <?php
                                                    if ($type == 'a' || $type == 'q') {
                                                        $url = asset('get-question-answers/' . $record->id);
                                                        $src = asset('userassets/images/side-icon12.svg');
                                                    }
                                                    ?>
                                                    <?php
                                                    if ($type == 'bm') {
                                                        $subuser = getSubUser($record->id);
                                                        if (isset($tag)) {
                                                            $url = asset('get-budz?business_id=' . $record->id . '&business_type_id=' . $subuser->business_type_id . '&keyword=' . $tag);
                                                        } else {
                                                            $url = asset('get-budz?business_id=' . $record->id . '&business_type_id=' . $subuser->business_type_id);
                                                        }
                                                        $src = asset('userassets/images/folded-newspaper.svg');
                                                    }
                                                    ?>
                                                    <input type="hidden" class="month_year" value="<?= $record->month_year ?>">
                                                    <div class="icon" style="background-image: url(<?php echo $src ?>)"></div>
                                                    <div class="txt">
                                                        <a href="<?php echo $url ?>"> 
                                                            <div class="title">
                                                                <strong class="dark-blue new-strong-color"><?= preg_replace("/<a[^>]+\>/i", "", $record->title); ?></strong>
                                                                <div class="txt-btn">
                                                                    <span>
                                                                        <i class="fa fa-external-link"></i>
                                                                        <?php
                                                                        if (trim($record->description)) {
                                                                            echo preg_replace("/<a[^>]+\>/i", "", $record->description);
                                                                        } else {
                                                                            ?>
                                                                            No description found.
                <?php } ?>
                                                                    </span>
                                                                </div>
                                                                <em class="time"><?php echo timeago($record->created_at); ?></em>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </li>

                                            <?php
                                            }
                                        }
                                        ?>
                                    <?php }
                                } else {
                                    ?>
                                    <li>
                                        <div class="loader hb_not_more_posts_lbl" id="no_more_search">No search result to show</div>
                                    </li>
                        <?php } ?>
                            </ul>
                            <div style="display: none" class="hb_simple_loader" id="loading"><img src="<?php echo asset('userassets/images/new_loadeer.svg') ?>" alt="Loading . . . ." class="post-loader"><span></span></div>
                        </div>
                    </div>
                    <div class="right_sidebars">
        <?php if($current_user){ include 'includes/rightsidebar.php'; ?>
        <?php include 'includes/chat-rightsidebar.php';} ?>
                    </div>
                </div>
            </article>
        </div>
        <?php
        if (isset($_GET['filter'])) {
            $filter = $_GET['filter'];
        } else {
            $filter = '';
        }
        if (isset($_GET['q'])) {
            $query = $_GET['q'];
        } else {
            $query = '';
        }
        ?>
<?php include('includes/footer-new.php'); ?>

    </body>
    <script>

        var win = $(window);
        var count = 1;
        var filter = '<?= $filter ?>';
        var query = '<?= $query ?>';
        var ajaxcall = 1;
//        var counter = 1;
        win.on('scroll', function () {
            var docheight = parseInt($(document).height());
            var winheight = parseInt(win.height());
            var differnce = (docheight - winheight) - win.scrollTop();

            if (differnce < 100) {
                if (ajaxcall === 1) {
//                    alert(differnce)
                    $('#loading').show();
                    ajaxcall = 0;
                    $.ajax({
                        url: "<?php echo asset('get-global-search-loader') ?>",
                        type: "GET",
                        data: {
                            "count": count,
                            "filter": filter,
                            "q": query
                        },
                        success: function (data) {
                            if (data) {
                                var a = parseInt(1);
                                var b = parseInt(count);
                                count = b + a;
                                $('#seacch_listing').append(data);
                                $('#loading').hide();
                                ajaxcall = 1;
                            } else {
                                $('#no_more_search').hide();
                                $('#loading').hide();
                                noposts = ' <div class="loader hb_not_more_posts_lbl" id="nomoreposts">No more search result to show</div> ';
                                $('#seacch_listing').append(noposts);
                            }
                        }
                    });
                }

            }
        });

//        function getSearchFilter(){
//        alert('ssssss')
////            if (ele.checked) {
////                var qval=$(ele).val();
////                if(qval == 'q'){
////
////                $('#answer_checkbox').prop('checked', true);     
////                }
////            }else{
////               var qval=$(ele).val();
////                if(qval == 'q'){
////                 $('#answer_checkbox').prop('checked', false); 
////                } 
////            }
//            $('#filter_search_form').submit();
//
//        } 
        $('.options ul li').click(function () {
            var old_value = $('#sorting_value').val();
            var current_value = $(this).find('span').html();
            var select = $(this).closest('.sort-dropdown').find('option');
            $(select).text(current_value);
            $(select).val(current_value);
            $(select).prop('selected', 'selected');
            $('.sort-dropdown').removeClass('active');
            $('.sort-dropdown .options ul').hide();
            if (old_value != current_value) {
                $('#filter_search_form').submit();
            }
        });
    </script>
</html>