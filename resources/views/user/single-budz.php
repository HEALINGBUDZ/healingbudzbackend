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

                            <div class="row shoutout">
                                <p class="no-margin color green buy-key"> Budz Adz Stats</p>
                                <div  class="select-budz">
                                    <label class="color white">Select Budz Adz </label>
                                    <form action="" id="change_single">
                                        <select onchange="submitForm(this)">
                                            <?php foreach ($budzs as $budz) { ?>
                                                <option value="<?= $budz->id ?>" <?php if ($id == $budz->id) { ?> selected="" <?php } ?>><?= $budz->title ?></option>
                                            <?php } ?>
                                        </select>
                                    </form>
                                </div>
                            </div>

                            <div class="wid_info single-user-info">
                                <a href="<?= asset('get-budz?business_id=' . $stats->id . '&business_type_id=' . $stats->business_type_id) ?>">
                                    <div class="pre-main-image"> 
                                        <img src="<?= getSubImage($stats->logo, '') ?>" alt="Icon" class="budz-map-user">
                                        <strong class="budz-user-name"><span class="color white"><?= $stats->title ?></span>
                                        <span><?= $stats->location ?></span></strong>
                                        <?php //if ($post->User->special_icon) { ?>
<!--                                <span class="fest-pre-img" style="background-image: url(<?php //echo asset('public/images' . $post->User->special_icon)  ?>);"></span>-->

                                        <?php //} ?>
                                    </div>
                                </a>
                            </div>                      
                        </div>

                        <div class="budz-stats">
                            <div class="single-budz-map">
                                <h1>
                                    <strong class="search-count">
                                        <i style="" class="fa fa-eye"></i>
                                        <?= $stats->bud_feed_views_count ?>
                                    </strong>
                                </h1>
                                <p class="lable1">View</p>
                            </div>
                            <div class="single-budz-map">
                                <h1>
                                    <strong class="search-count">
                                        <i style="color:red;" class="fa fa-heart"></i>
                                        <?= $stats->get_user_save_count ?>
                                    </strong>
                                </h1>
                                <p class="lable1">Favorites</p>
                            </div>
                            <div class="single-budz-map">
                                <h1>
                                    <strong class="search-count">
                                        <i style="color:purple;" class="fa fa-share-alt"></i>
                                        <?= $stats->bud_feed_share_count ?>
                                    </strong>
                                </h1>
                                <p class="lable1">Shares</p>
                            </div>
                            <div class="single-budz-map">
                                <h1>
                                    <strong class="search-count">
                                        <img src="<?php echo asset('userassets/img/keyword-blue.png') ?>"  width="17px">
                                        <?= $stats->bud_feed_views_by_tag_count ?>
                                    </strong>
                                </h1>
                                <p class="lable1">Keywords</p>
                            </div>
                            <div class="single-budz-map">
                                <h1>
                                    <strong class="search-count">
                                        <i style="color:yellow;" class="fa fa-star"></i>
                                        <?= $stats->all_reviews_count ?>
                                    </strong>
                                </h1>
                                <p class="lable1">Reviews</p>
                            </div>
                            <div class="single-budz-map">
                                <h1>
                                    <strong class="search-count">
                                        <i style="color:#1079be;" class="fa fa-phone"></i>
                                        <?= $stats->bud_feed_click_to_call_count ?>
                                    </strong>
                                </h1>
                                <p class="lable1">Call clicks</p>
                            </div>
                            <div class="single-budz-map">
                                <h1>
                                    <strong class="search-count">
                                        <img src="<?php echo asset('userassets/img/icon-circle.png') ?>"  width="17px">
                                        <?= $stats->bud_feed_click_to_ticket_count ?>
                                    </strong>
                                </h1>
                                <p class="lable1">Tab/Ticket Views</p>
                            </div>
                        </div>

                        <div class="groups add">
                            <p class="color green title-single-budz">Activity on Budz Adz</p><br>
                            <table class="single-budz" id="budz_feed">
                                <?php
                                if (count($activities) > 0) {
                                    foreach ($activities as $activity) {
                                        $text = '';
                                        if ($activity->review_id) {
                                            $text = 'Add Review on your Budz Adz';
                                        }
                                        if ($activity->my_save_id) {
                                            $text = 'Add your Budz Adz to Favorites';
                                        }
                                        if ($activity->share_id) {
                                            $text = 'Shared your Budz Adz';
                                        }
                                        if ($activity->click_to_call) {
                                            $text = 'Click to Call on your Budz Adz';
                                        }
//                                    if ($activity->cta) {
//                                        $text = 'Click on ticket on your Budz Adz';
//                                    }
                                        if ($text) {
                                            ?>
                                            <tr>

                                                <td class="keyword">
                                                    <a href="<?= asset('user-profile-detail/' . $activity->user->id) ?>"><img src="<?php echo getImage($activity->user->image_path, $activity->user->avatar) ?>" width="20px" /> 
                                                        <strong class=" <?= getRatingClass($activity->user->points) ?>"><?= $activity->user->first_name ?></strong> 
                                                    </a>
                                                    <span><?= $text ?></span></td>
                                                <td> 
                                                    <div class="wid_info expire">

                                                        <strong><?= timeago($activity->created_at) ?><span></span></strong>

                                                    </div>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                } else {
                                    ?>
                                    <tr>

                                        <td class="keyword">
                                            <a href=""><img src="" width="20px" /> 
                                                <strong class=" "></strong> 
                                            </a>
                                            <strong>No Record Found</strong></td>

                                    </tr>   
<?php } ?>
                            </table>
                            <h3 id="no_record" style="display: none"><center>No More Record Founded</center></h3>
                            <div style="display: none" class="hb_simple_loader" id="loading"><img src="<?php echo asset('userassets/images/new_loadeer.svg') ?>" alt="Loading . . . ." class="post-loader"><span></span></div>

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
    </body>

    <script>
        function submitForm(ele) {
            url = '<?= asset('single-budz-stats') ?>';
//            change_single
            id = ($(ele).val());
            $('#change_single').attr('action', url + '/' + id);
            $('#change_single').submit();
        }
        var win = $(window);
        var count = 1;
        var ajaxcall = 1;
        win.on('scroll', function () {
            var docheight = parseInt($(document).height());
            var winheight = parseInt(win.height());
            var differnce = (docheight - winheight) - win.scrollTop();
            if (differnce < 100) {
                if (ajaxcall === 1) {
                    $('#loading').show();
                    ajaxcall = 0;
                    $.ajax({
                        url: "<?php echo asset('single-budz-stats/' . $id) ?>",
                        type: "GET",
                        data: {
                            "count": count,
                        },
                        success: function (data) {
                            if (data) {
                                var a = parseInt(1);
                                var b = parseInt(count);
                                count = b + a;
                                $('#budz_feed').append(data);
                                $('#loading').hide();
                                ajaxcall = 1;
                            } else {
                                $('#loading').hide();
                                $('#no_record').show();
                            }
                        }
                    });
                }

            }
        });
    </script>
</html>