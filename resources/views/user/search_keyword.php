<!DOCTYPE html>
<html lang="en">
    <?php include('includes/top-new.php'); ?>
    <body>
        <div id="wrapper">
            <?php include('includes/sidebar.php'); ?>
            <article id="content">
                <?php include('includes/header.php'); ?>
                <div class="padding-div">
                    <div class="my-saves">

                        <?php if (Session::has('success')) { ?>
                            <h5 class="alert alert-success"><?php echo Session::get('success'); ?></h5>
                        <?php } ?>
                        <ul class="saves-table" id="seacch_listing">
                            <?php if(count($records) > 0){ ?>
                                <?php foreach ($records as $record) {
                                    $type = explode('_', $record->v_pk); ?>
                                    <li class="">
                                        <div class="tab-cell cus-img">
                                            <?php
                                            if ($type[1] == 's') {
                                                $url = asset('strain-details/' . $record->id);
                                                ?>
                                                <a href="<?= $url ?>">
                                                    <img src="<?php echo asset('userassets/images/icon03.svg') ?>" alt="Icon" />
                                                </a>
                                            <?php } ?>
                                            <?php
                                            if ($type[1] == 'a' || $type[1] == 'q') {
                                                $url = asset('get-question-answers/' . $record->id);
                                                ?>
                                                <a href="<?= $url ?>">
                                                    <img src="<?php echo asset('userassets/images/side-icon12.svg') ?>" alt="Icon" />
                                                </a>
                                            <?php } ?>
                                            <?php
                                            if ($type[1] == 'bm') {
                                                $subuser = getSubUser($record->id);
                                                $url = asset('get-budz?business_id=' . $record->id . '&business_type_id=' . $subuser->business_type_id . '&keyword='.$keyword);
                                                ?>
                                                <a href="<?= $url ?>">
                                                    <img src="<?php echo asset('userassets/images/folded-newspaper.svg') ?>" alt="Icon" />
                                                </a>
                                                <?php } ?>
                                                <?php if ($type[1] == 'j') { $url = asset('journal-details/' . $record->id); ?>
                                                <a href="<?= $url ?>">
                                                    <img src="<?php echo asset('userassets/images/icon04.png') ?>" alt="Icon" />
                                                </a>
                                            <?php } ?>
                                            <?php
                                            if ($type[1] == 'g') {
                                                $url = asset('group-chat/' . $record->id);
                                                ?>
                                                <a href="<?= $url ?>">
                                                    <img src="<?php echo asset('userassets/images/icon02.png') ?>" alt="Icon" />
                                                </a>
                                            <?php } ?>
                                        </div>
                                        <a href="<?= $url ?>">
                                            <div class="tab-cell cus-text ">
                                                <span class="yellow"><?= $record->title; ?></span>
                                                <p><?= $record->description; ?></p>
                                            </div>
                                        </a>
                                    </li>
                                <?php } ?>
                            <?php }else{ ?>
                             
                                    <div class="loader hb_not_more_posts_lbl" id="no_more_serach">No More Search Result To Show</div>
                               
                            <?php } ?>
                        </ul>
                            <div style="display: none" class="hb_simple_loader" id="loading"><img src="<?php echo asset('userassets/images/new_loadeer.svg') ?>" alt="Loading . . . ." class="post-loader"><span></span></div>
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
        if (isset($_GET['type'])) {
            $type = $_GET['type'];
        } else {
            $type = '';
        }
        ?>
<?php include('includes/footer-new.php'); ?>

    </body>
    <script>

        var win = $(window);
        var count = 1;
        var filter = '<?= $type ?>';
        var query = '<?= $query ?>';
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
                        url: "<?php echo asset('get-keyword-search-loader') ?>",
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
                                $('#no_more_serach').hide();
                                
                                $('#loading').hide();
                                noposts = ' <div class="loader hb_not_more_posts_lbl" id="nomoreposts">No More Search Result To Show</div> ';
                                $('#seacch_listing').append(noposts);
                            }
                        }
                    });
                }
                
            }
        });

        function getSearchFilter(ele) {
            if (ele.checked) {
                var qval = $(ele).val();
                if (qval == 'q') {

                    $('#answer_checkbox').prop('checked', true);
                }
            } else {
                var qval = $(ele).val();
                if (qval == 'q') {
                    $('#answer_checkbox').prop('checked', false);
                }
            }
            $('#filter_search_form').submit();

        }
    </script>
</html>