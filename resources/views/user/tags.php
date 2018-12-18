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
                        <div class="ask-area keyword-header">
                            <?php // include 'includes/questions_search.php'; ?>  

                            <div class="row">
                                <p class="no-margin budz-title"> Tags List</p>

                            </div>                  
                        </div>
                        <div class="groups add tags-tabl">

                            <table class="stats" id="tags">
                                <tbody id="tag_listing">
                                </tbody>
                            </table>

                            <h3 id="no_record" style="display: none"><center>No more record found</center></h3>
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
        <?php include('includes/footer.php'); ?>
        <?php include('includes/functions.php'); ?>


    </body>
    <script>
        var win = $(window);
        var count = 0;
        var ajaxcall = 1;

        win.on('scroll', function () {
            var docheight = parseInt($(document).height());
            var winheight = parseInt(win.height());
            var differnce = (docheight - winheight) - win.scrollTop();
            if (differnce < 100) {
                if (ajaxcall === 1) {
                    $('#loading').show();
                    ajaxcall = 0;
                    getRecord(count);
                }

            }
        });
        $(document).ready(function () {

            // load posts
            var skip = 0;
            getRecord(skip);
        });
        function getRecord(skip) {
            $.ajax({
                url: "<?php echo asset('get-tags') ?>",
                type: "GET",
                data: {
                    "count": skip,
                },
                success: function (data) {
                    if (data) {
                        var a = parseInt(1);
                        var b = parseInt(count);
                        count = b + a;
                        $('#tag_listing').append(data);
                        $('#loading').hide();
                        ajaxcall = 1;
                    } else {
                        $('#loading').hide();
                        $('#no_record').show();
                    }
                }
            });
        }
        function follow_keyword(tag_id) {
            $('#not_following' + tag_id).hide();
            $('#following' + tag_id).show();
            $.ajax({
                type: "GET",
                url: "<?php echo asset('add-tag'); ?>",
                data: {
                    "id": tag_id
                },
                success: function (data) {
                }

            });
        }
        function removeTag(id) {
            $('#not_following' + id).show();
            $('#following' + id).hide();
            $.ajax({
                type: "GET",
                url: "<?php echo asset('remove-add-tag'); ?>",
                data: {
                    "id": id
                },
                success: function (data) {
//                $('#showfollowsuccess').show().html("Keyword Unfollowed Successfully").fadeOut(3000);
//                    $('#un_follow_keyword').hide();
//                    $('#follow_keyword').show();
//                    $('#follow_keyword').attr('onclick', 'addTag(' + id + ')');
                }

            });
        }

    </script>
</html>