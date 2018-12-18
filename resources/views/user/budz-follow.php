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
                                <p class="no-margin budz-title"> Budz List</p>

                            </div>                  
                        </div>
                        <div class="groups add">

                            <table class="stats" id="user_listing">
                                <tbody>
                                    <?php foreach ($users as $user) { ?>
                                        <tr>

                                            <td class="keyword budz-user">
                                                <div class="wid_info pre-main-image">
                                                    <a href="<?= asset('user-profile-detail/' . $user->id) ?>">
                                                        <img src="<?= getImage($user->image_path, $user->avatar); ?>" width="40px" alt="Icon" class="img-user">
                                                        <?php if ($user->special_icon) { ?>
                                                            <span class="fest-pre-img" style="background-image: url(<?php echo getSpecialIcon($user->special_icon) ?>);"></span>
                                                        <?php } ?>
                                                        <strong class="<?= getRatingClass($user->points); ?>"><?= $user->first_name ?> </strong>
                                                    </a>

                                                </div> 
                                            </td>
                                            <td>
                                                <a onclick="unfollow('<?= $user->id ?>', 'follow_icon<?= $user->id ?>', 'unfollow_icon<?= $user->id ?>')" id="follow_icon<?= $user->id ?>" href="javascript:void(0)" <?php if (!checkIsFolloing($user->id)) { ?> style="display: none" <?php } ?>>
                                                    <button class="follow-btn"><i class="fa fa-user-times"></i> Unfollow</button>
                                                </a>
                                                <a onclick="follow('<?= $user->id ?>', 'unfollow_icon<?= $user->id ?>', 'follow_icon<?= $user->id ?>')" id="unfollow_icon<?= $user->id ?>" href="javascript:void(0)" <?php if (checkIsFolloing($user->id)) { ?> style="display: none" <?php } ?>>
                                                    <button class="follow-btn"><i class="fa fa-user-plus"></i> Follow</button>
                                                </a>
                                            </td>
                                            <td>
                                                <a href="<?= asset('message-user-detail/' . $user->id) ?>">
                                                    <button class="message-btn"><i class="fa fa-comment"></i> Message</button>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>

                            <h3 id="no_record" style="display: none"><center>No More Record Found</center></h3>
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
                        url: "<?php echo asset('budz-follow') ?>",
                        type: "GET",
                        data: {
                            "count": count,
                        },
                        success: function (data) {
                            if (data) {
                                var a = parseInt(1);
                                var b = parseInt(count);
                                count = b + a;
                                $('#user_listing').append(data);
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