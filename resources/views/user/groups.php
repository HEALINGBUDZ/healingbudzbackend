<!DOCTYPE html>
<html lang="en">

    <?php include('includes/top.php'); ?>
    <body>
        <div id="wrapper">
            <?php include('includes/sidebar.php'); ?>
            <article id="content">
                <?php include('includes/header.php'); ?>
                <div class="padding-div">
                    <ul class="bread-crumbs list-none">
                        <li><a href="<?php echo asset('/'); ?>">Home</a></li>
                        <li><a href="<?php echo asset('groups'); ?>">Groups</a></li>
                        <li>All</li>
                    </ul>
                    <header class="intro-header no-bg">
                        <h1 class="custom-heading white text-center">
                            <img src="<?php echo asset('userassets/images/side-icon13.svg') ?>" alt="Icon" class="no-margin large-icon">
                            <span class="top-padding">GROUPS</span>
                        </h1>
                    </header>
                    <div class="search-area">
                        <form action="<?php echo asset('search-group'); ?>" class="search-form">
                            <input type="search" placeholder="Search" name="q">
                            <input type="submit" value="Submit">
                        </form>
                        <div class="sort-dropdown orange">
                            <div class="form-holder">
                                <form action="<?php echo asset('group-sorting'); ?>" id="g_sorting">
                                    <fieldset>
                                        <select name="sorting" id="sorting_value_group" onchange="onchange()">
                                            <?php if (isset($_GET['sorting'])) { ?>
                                                <option value="<?php echo $_GET['sorting']; ?>" selected=""><?php echo $_GET['sorting']; ?> </option>
                                            <?php } else { ?>
                                                <option value="" selected="">Groups</option>
                                            <?php } ?>
                                        </select>
                                    </fieldset>
                                </form>
                                <a href="#" class="options-toggler opener"><i class="fa fa-caret-down" aria-hidden="true"></i></a>
                            </div>
                            <div class="options">
                                <ul class="list-none">
                                    <li>
                                        <img src="<?php echo asset('userassets/images/alphabeticaly.svg') ?>" alt="Newest">
                                        <span>ALPHABETICAL</span>
                                    </li>
                                    <li>
                                        <img src="<?php echo asset('userassets/images/new1.svg') ?>" alt="Newest">
                                        <span>NEWEST</span>
                                    </li>
                                    <li>
                                        <img src="<?php echo asset('userassets/images/joined.svg') ?>" alt="Unanswered" class="small-join-icon">
                                        <span>JOINED</span>
                                    </li>
                                </ul>
                                <a href="#" class="options-toggler closer"><i class="fa fa-caret-up" aria-hidden="true"></i></a>
                            </div>
                        </div>
                        <a href="<?php echo asset('create-group') ?>" class="create-group">Create Group</a>
                    </div>
                    <div class="groups">
                        <?php if (Session::has('success')) {  ?>
                            <h5 class="alert alert-success"><?php echo Session::get('success');?></h5>
                        <?php  } ?>
                        <?php if (Session::has('error')) {  ?>
                            <h5 class="alert alert-danger"><?php echo Session::get('error');?></h5>
                        <?php  } ?>
                        <ul class="list-none cols-view" id="groups_listing">
                            <?php if(count($groups) > 0){ foreach ($groups as $group) { ?>
                                <li>

                                    <div class="actions">
                                        <?php if (!$group->userFollowing) { ?>
                                        <a  href="#" onclick="addFollow('<?=$group->id?>')" id="followgroup<?=$group->id?>" class="how-time orange add no-bg"><i class="fa fa-plus-circle orange-plus" aria-hidden="true"></i></a>
                                        <?php } ?>
                                    </div>

                                    <div class="txt">
                                        <?php if($group->image) { ?>
                                            <div class="img-holder">
                                                <img src="<?php echo asset('public/images'.$group->image) ?>" alt="Image" class="img-responsive">
                                            </div>
                                        <?php }else{ ?>
                                            <div class="img-holder">
                                                <img src="<?php echo asset('userassets/images/img2.png') ?>" alt="Image" class="img-responsive">
                                            </div>
                                        <?php } ?>
                                        <div class="text add white-links">
                                            <a href="<?= asset('group-chat/' . $group->id) ?>">
                                                <strong><?php echo $group->title; ?></strong>
                                                <span><?php echo $group->get_members_count; ?> Budz</span>
                                            </a>
                                        </div>
                                    </div>
                                </li>
                            <?php }} else { ?>
                                No Group Found
                            <?php } ?>
                            <div style="display: none" id="loading">Loading . . . . </div>
                        </ul>
                    </div>
                </div>
            </article>
        </div>
        <?php
        if (isset($_GET['sorting'])) {
            $sorting = $_GET['sorting'];
        } else {
            $sorting = '';
        }
        if (isset($_GET['q'])) {
            $q = $_GET['q'];
        } else {
            $q = '';
        }
        ?>
        <?php include('includes/footer.php'); ?>
    </body>
    <script>

        var win = $(window);
        var count = 1;
        var ajaxcall = 1;
        var q = '<?= $q ?>';
        var sorting = '<?= $sorting ?>';
        win.on('scroll', function () {
            var docheight = parseInt($(document).height());
            var winheight = parseInt(win.height());
            var differnce = (docheight - winheight) - win.scrollTop();
            if (differnce < 100) {
                if (ajaxcall === 1) {
                    $('#loading').show();
                    ajaxcall = 0;
                    $.ajax({
                        url: "<?php echo asset('get-group-loader') ?>",
                        type: "GET",
                        data: {
                            "count": count,
                            "q": q,
                            "sorting": sorting
                        },
                        success: function (data) {
                            if (data) {
                                var a = parseInt(1);
                                var b = parseInt(count);
                                count = b + a;
                                $('#groups_listing').append(data);
                                $('#loading').hide();
                                ajaxcall = 1;
                            } else {
                                $('#loading').hide();
                                noposts = ' <div class="loader hb_not_more_posts_lbl" id="nomoreposts">No More Groups To Show</div> ';
                                $('#groups_listing').append(noposts);
                            }
                        }
                    });
                }
            }
        });
        function addFollow(group_id){
            $('#followgroup'+group_id).hide();
            $.ajax({
                    type: "GET",
                    url: "<?php echo asset('add-to-follow'); ?>",
                    data:{"group_id":group_id},
                    success: function () {

                    }});
            }
    </script>
</html>