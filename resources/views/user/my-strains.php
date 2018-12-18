<!DOCTYPE html>
<html lang="en">
    <?php include('includes/top-new.php'); ?>
    <body class="strains-page">
        <div id="wrapper">
            <?php include('includes/sidebar.php'); ?>
            <article id="content">
                <?php include('includes/header.php'); ?>
                <div class="padding-div">
                    <div class="new_container main-page-yel">
                        <div class="clearfix pd-top hb_heading_bordered">
                            <h2 class="hb_page_top_title hb_text_yellow hb_text_uppercase no-margin">My Strains</h2>
                             <ul class="top_chat_tabs">
                                 <li><a href="<?php echo asset('/save-strains'); ?>">Saved Strains</a></li>
                                <li ><a href="<?php echo asset('/my-strains'); ?>">Edited Strains</a></li>

                                
                            </ul>
                        </div>
<!--                        <div class="date-main-act">
                            <i class="fa fa-calendar"></i>
                            <span>February 2018</span>
                        </div>-->
                        <div class="listing-area">
                            <!--<h1 class="custom-heading white text-center"><img src="<?php // echo asset('userassets/images/icon03.svg') ?>" alt="Icon"><span class="top-padding">My Strains</span></h1>-->

                            <ul class="journals list-none quest" id="strains_listing">
                                <?php if(count($strains) > 0){ ?>
                                <?php foreach($strains as $key => $values){ ?>
                                    <div class="date-main-act">
                                        <i class="fa fa-calendar"></i>
                                        <span><?= $key ?></span>
                                    </div>
                                <?php foreach ($values as $strain){ ?>
                                <li class="strain-fnt-same">
                                    <input type="hidden" class="month_year" value="<?= $strain->month_year ?>">
                                    <div class="q-txt s-txt">
                                        <div class="q-text-a">
                                            <a href="<?php echo asset('user-strain-detail?strain_id='.$strain->strain_id.'&user_strain_id='.$strain->id); ?>">
                                                <span><img src="<?php echo asset('userassets/images/act-s.png') ?>" alt="Icon"></span>
                                                <div class="my_answer">
                                                    <span class="size-key"><?php echo $strain->getStrain->title; ?></span>
                                                    <!--<em class="key Hybrid">H</em>-->
                                                    <em class="key <?= $strain->getStrain->getType->title; ?>"><?= substr($strain->getStrain->getType->title, 0, 1); ?></em>
                                                    <span class="hows-time"><?php echo timeago($strain->created_at); ?></span>
                                                </div>
                                            </a>
                                        </div>
                                            <div class="head-ques" target="_blank">
                                                <?php echo $strain->description; ?>
                                                <span class="descrip"><?php echo $strain->note; ?></span>
                                            </div>
                                        <span class="how-time">
                                            <a href="<?php echo asset('edit-user-strain/'.$strain->id)?>">
                                                <i class="fa fa-pencil" aria-hidden="true"></i> Edit
                                            </a>
                                            <a href="#" data-toggle="modal" data-target="#delete_strain<?php echo $strain->id;?>">
                                                <i class="fa fa-trash-o" aria-hidden="true"></i> Delete
                                            </a>
                                        </span>
                                    </div>
                                </li>
                                <!-- Modal -->
                                <div class="modal fade" id="delete_strain<?php echo $strain->id;?>" role="dialog">
                                    <div class="modal-dialog">
                                      <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title">Delete Strain </h4>
                                            </div>
                                            <div class="modal-body">
                                                <p>Are you sure to delete this Strain: <?php echo $strain->getStrain->title; ?></p>
                                            </div>
                                            <div class="modal-footer">
                                                <a href="<?php echo asset('delete-user-strain/'.$strain->id); ?>" type="button" class="btn-heal">yes</a>
                                                <button data-dismiss="modal" type="button" class="btn-heal">No</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Modal End-->
                                <?php } ?>
                                <?php } }else{ ?>
                                    <div class="loader hb_not_more_posts_lbl" id="no_more_strain">No more strains to show</div>
                                <?php } ?>
                            </ul>
                          <div style="display: none" class="hb_simple_loader" id="loading"><img src="<?php echo asset('userassets/images/new_loadeer.svg') ?>" alt="Loading . . . ." class="post-loader"><span></span></div>

                        </div>
                    </div>
                    <div class="right_sidebars">
                        <?php include 'includes/rightsidebar.php'; ?>
                        <?php include 'includes/chat-rightsidebar.php';?>
                    </div>
                </div>
            </article>
        </div>
        <?php include('includes/footer-new.php'); ?>
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
                    var last_month = $('.month_year').last().val();
                    ajaxcall = 0;
                    $.ajax({
                        url: "<?php echo asset('get-my-strains-loader') ?>",
                        type: "GET",
                        data: {
                            "count": count,
                            "last_month": last_month
//                            "sorting":sorting,
//                            "q":q
                        },
                        beforeSend: function(){
                            $('#loading').show();
                        },
                        success: function(data) {
                            if (data) {
                                var a = parseInt(1);
                                var b = parseInt(count);
                                count = b + a;
                                $('#strains_listing').append(data);
                                $('#loading').hide();
                                ajaxcall = 1;
                            } else {
                                $('#no_more_strain').hide();
                                $('#loading').hide();
                                noposts=' <div class="loader hb_not_more_posts_lbl" id="nomoreposts">No more strains to show</div> ';
                                $('#strains_listing').append(noposts);
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