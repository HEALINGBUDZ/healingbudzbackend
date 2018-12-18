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
                        <div class="ask-area logtable-header">

                            <div class="row logtable">
                                <div class="logtable-left">
                                    <p class="no-margin color green ">Points Log Table</p>
                                </div>
                                <div class="logtable-right">

                                    <div class="points-box"> 
                                        <img src="<?php echo asset('userassets/img/reward1.png') ?>">
                                    </div>
                                    <div class="points-box">
                                        <p>Your Current Reward Points</p>
                                        <h1><?= $current_user->points - $current_user->point_redeem ?></h1>
                                    </div>


                                </div>


     <!--<input type="submit" class="bg-green buy-btn" value="Buy Keyword">-->
                            </div>                      
                        </div>
                        <div class="groups add">

                            <table class="stats" id="listing_point_log">
                                <thead>
                                <tr>
                                    <th class="color white">DATE</th>
                                    <th class="color white">TASK NAME</th>
                                    <th class="color white">POINTS</th>
                                </tr>
                                </thead>
                                <tbody>

                                <?php foreach ($points as $point) { ?>
                                    <tr>
                                        <td><?= date("d-m-Y", strtotime($point->created_at)); ?></td>
                                        <td class="task-name"><i class="fa fa-star color green"></i> <?= $point->type ?></td>
                                        <td>
                                            <p class="color green">+<?= $point->points ?> pts</p>
                                        </td>
                                    </tr>
                                <?php } ?>
                                </tbody>
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

        <script>

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
                            url: "<?php echo asset('reward-log-loader') ?>",
                            type: "GET",
                            data: {
                                "count": count
                            },
                            success: function (data) {
                                if (data) {
                                    var a = parseInt(1);
                                    var b = parseInt(count);
                                    count = b + a;
                                    $('#loading').hide();
                                    $('#listing_point_log').append(data);
                                    
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
    </body>
</html>