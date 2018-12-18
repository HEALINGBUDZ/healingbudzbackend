<!DOCTYPE html>
<html lang="en">
<?php include('includes/top.php');?>
<body>
    <div id="wrapper">
        <?php include('includes/sidebar.php');?>
        <article id="content">
            <?php include('includes/header.php');?>
            <div class="padding-div">
                <ul class="bread-crumbs list-none">
                    <li><a href="<?php echo asset('/') ?>">Home</a></li>
                    <li><a href="<?php echo asset('groups'); ?>">My Groups</a></li>
                    <li>All</li>
                </ul>
              
                <div class="groups no-text-tp">
                    <header class="intro-header no-bg">
                        <h1 class="custom-heading white text-center">
                            <a href="<?php echo asset('create-group') ?>" class="create-group">Create Group</a>
                            <img src="<?php echo asset('userassets/images/side-icon13.svg') ?>" alt="Icon" class="no-margin large-icon">
                            <span class="top-padding">My Groups</span>
                        </h1>
                    </header>
                    <ul class="list-none add cols-view" id="my_groups_listing">
                        <?php if(count($groups) > 0) { ?>

                        <?php foreach ($groups as $group){ 
                            ?>
                        <li>
                            <div class="actions">
                                <?php if($group->user_id == $current_id){ ?>
                                <a href="<?php echo asset('edit-group/'.$group->id) ?>" class="edit"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                <?php } ?>
                                <a href="#" class="lock"><i class="fa fa-lock" aria-hidden="true"></i></a>
                            </div>
                            <a  href="<?= asset('group-chat/'.$group->id) ?>" class="txt">
                                <div class="img-holder">
                                    <img src="<?php echo getGroupImage($group->image);?>" alt="Image" class="img-responsive">
                                    <?php if($group->followDetails->unread_count){ ?>
                                    <span class="counts"><?php echo $group->followDetails->unread_count;?></span>
                                    <?php } ?>
                                </div>
                                <div class="txt">
                                    <div>
                                        <strong><?php echo $group->title;?></strong>
                                        <span><?php echo $group->get_members_count;?> Budz</span>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <?php } ?>
                        <?php }else{ ?>
                        <li>
                        
                        </li>
                        <?php } ?>
                    </ul>
                    <div style="display: none" class="hb_simple_loader" id="loading"><img src="<?php echo asset('userassets/images/new_loadeer.svg') ?>" alt="Loading . . . ." class="post-loader"><span></span></div>
                </div>
            </div>
        </article>
    </div>
    <?php include('includes/footer.php');?>
</body>
<script> 
        var win = $(window);
        var count = 1;
        var ajaxcall = 1;
//        var sorting = '<?php //echo $sorting ?>';
//        var q = '<?php //echo $q ?>';
        win.on('scroll', function() {
            var docheight = parseInt($(document).height());
            var winheight = parseInt(win.height());
            var differnce = (docheight - winheight) - win.scrollTop();
            if (differnce < 100) {
                if (ajaxcall === 1) {
                    $('#loading').show();
                    ajaxcall = 0;
                    $.ajax({
                        url: "<?php echo asset('get-my-groups-loader') ?>",
                        type: "GET",
                        data: {
                            "count": count,
//                            "sorting":sorting,
//                            "q":q
                        },
                        success: function(data) {
                            if (data) {
                                var a = parseInt(1);
                                var b = parseInt(count);
                                count = b + a;
                                $('#my_groups_listing').append(data);
                                $('#loading').hide();
                                ajaxcall = 1;
                            } else {
                                $('#loading').hide();
                                noposts=' <div class="loader hb_not_more_posts_lbl" id="nomoreposts">No More Groups To Show</div> ';
                                $('#my_groups_listing').append(noposts);
                            }
                        }
                    });
                }
                
            }
        });
    </script>
</html>