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
                            <div class="sav-header">
                                <div class="activity-log-header">
                                    <div class="clearfix pd-top hb_heading_bordered">
                            <h2 class="hb_page_top_title hb_text_yellow hb_text_uppercase no-margin">My Strains</h2>
                             <ul class="top_chat_tabs">
                                  <li><a href="<?php echo asset('/save-strains'); ?>">Saved Strains</a></li>
                                <li ><a href="<?php echo asset('/my-strains'); ?>">Edited Strains</a></li>
                               
                            </ul>
                        </div>
                                </div>
                                
                            </div>
                            <?php if (Session::has('success')) { ?>
                                <h5 class="alert alert-success"><?php echo Session::get('success'); ?></h5>
                            <?php } ?>

                            <ul class="saves-table activities quest" id="my_saves_listing">
                                <?php if (count($mysaves) > 0) { ?>
                                    <?php foreach ($mysaves as $key => $values) { ?>
                                        <div class="date-main-act">
                                            <i class="fa fa-calendar"></i>
                                            <span><?= $key ?></span>
                                        </div>
                                        <?php foreach ($values as $mysave) { ?>
                                            <li class="">
                                                <input type="hidden" class="month_year" value="<?= $mysave->month_year ?>">
                                                <div class="q-txt">
                                                    <div class="q-text-a">
                                                        <?php
                                                        if ($mysave->type_id == 7) {
                                                            $message = 'You save a strain';
                                                            $url = asset('strain-details/' . $mysave->type_sub_id);
                                                            $image_url = asset('userassets/images/act-s.png');
                                                        }
                                                        ?>
                                                        <?php
                                                        if ($mysave->type_id == 4) {
                                                            $message = 'You save a question';
                                                            $url = asset('get-question-answers/' . $mysave->type_sub_id);
                                                            $image_url = asset('userassets/images/act-q.png');
                                                        }
                                                        ?>
                                                        <?php
                                                        if ($mysave->type_id == 8) {
                                                            $message = 'You save Budz Adz';
                                                            $subuser = getSubUser($mysave->type_sub_id);
                                                            if ($subuser) {
                                                                $url = asset('get-budz?business_id=' . $mysave->type_sub_id . '&business_type_id=' . $subuser->business_type_id);
                                                                $image_url = asset('userassets/images/folded-newspaper.svg');
                                                            } else {
                                                                $url = '';
                                                            }
                                                        }
                                                        ?>
                                                        <?php
                                                        if ($mysave->type_id == 10) {
                                                            $message = 'You save Seach';
                                                            $subuser = getSubUser($mysave->type_sub_id);

                                                            $image_url = asset('userassets/images/act-s.png');
                                                            $filter = json_decode($mysave->description);
                                                            $url = asset('strains-filter' . $filter->search_data);
                                                        }
                                                        ?>
                                                        <?php
                                                        if ($mysave->type_id == 11) {
                                                            $message = 'You save Special';
                                                            $subuser = getSubUser($mysave->type_sub_id);

                                                            $image_url = asset('userassets/images/speaker-icon1.png');

                                                            $url = asset('get-budz?' . $mysave->description);
                                                        }
                                                        ?>
                                                        <a href="<?= $url ?>">
                                                            <span>
                                                                <img src="<?php echo $image_url; ?>" alt="Icon" class="small-q">
                                                            </span>
                                                            <div class="my_answer">
                                                                <?= $message ?>
                                                                <span class="hows-time"><?= timeago($mysave->created_at); ?></span>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div class="head-ques anc-spec" >
                                                        <i class="fa fa-external-link"></i><a class="q-text-a" href="<?= $url ?>"> <?= $mysave->title; ?> </a>
                                                    </div>
                                                    <span class="how-time">
                                                        <a href="#delete-saves<?= $mysave->id ?>" class="btn-popup">
                                                            <i class="fa fa-minus-circle" aria-hidden="true"></i> Unsave
                                                        </a>
                                                    </span>
                                                </div>
                                            </li>
                                            <div id="delete-saves<?= $mysave->id ?>" class="popup delete-popps">
                                                <div class="popup-holder">
                                                    <div class="popup-area">
                                                        <div class="reporting-form">
                                                            <h3>Delete Saves</h3>
                                                            <p>Are you sure to delete this saves</p>
                                                            <div class="btns-del">
                                                                <a href="<?php echo asset('delete-mysave/' . $mysave->id); ?>" class="btn-yes">Yes</a>
                                                                <a href="#" class="btn-close">No</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>
                                <?php } else { ?>
                                    <div class="loader hb_not_more_posts_lbl" id="no_more_saves">No more saves to show</div>
                                <?php } ?>
                            </ul>
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
        <?php
        if (isset($_GET['sorting'])) {
            $filter = $_GET['sorting'];
        } else {
            $filter = '';
        }
        ?>

        <?php include('includes/footer-new.php'); ?>

    </body>
    <script>
        function getMySave() {
            $('#filter_my_save').submit();
        }
    </script>

    <script>
        var win = $(window);
        var count = 1;
        var ajaxcall = 1
        //var sorting = new Array();
<?php //if($filter != ''){ foreach($filter as $key => $val){     ?>
        //sorting.push('<?php //echo $val;     ?>');
<?php //}}     ?>

        var sorting = '<?php echo $filter; ?>';
        win.on('scroll', function () {
            var docheight = parseInt($(document).height());
            var winheight = parseInt(win.height());
            var differnce = (docheight - winheight) - win.scrollTop();
            if (differnce < 100) {
                if (ajaxcall === 1) {
                    $('#loading').show();
                    var last_month = $('.month_year').last().val();
                    ajaxcall = 0;
                    $.ajax({
                        url: "<?php echo asset('save-strains-loader') ?>",
                        type: "GET",
                        data: {
                            "count": count,
                            "last_month": last_month,
                            "sorting": sorting
                        },
                        beforeSend: function () {
                            $('#loading').show();
                        },
                        success: function (data) {
                            if (data) {
                                var a = parseInt(1);
                                var b = parseInt(count);
                                count = b + a;
                                $('#my_saves_listing').append(data);
                                $('#loading').hide();
                                ajaxcall = 1;
                            } else {
                                $('#no_more_saves').hide();
                                $('#loading').hide();
                                noposts = ' <div class="loader hb_not_more_posts_lbl" id="nomoreposts">No more saves to show</div> ';
                                $('#my_saves_listing').append(noposts);
                            }
                        }
                    });
                }
//                setTimeout(function(){$('#post_loader').hide();},1000);
//                $('#loading').hide();
            }
        });
    </script>
</html>