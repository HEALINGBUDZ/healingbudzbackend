<!DOCTYPE html>
<html lang="en">
    <?php include('includes/top-new.php'); ?>
    <body class="strains-page">
        <div id="wrapper">
            <?php include('includes/sidebar.php'); ?>
            <article id="content">
                <?php include('includes/header.php'); ?>
                <div class="padding-div">
                    <header class="intro-header no-bg">
                        <h1 class="custom-heading white text-center">
                            <img src="userassets/images/side-icon16.svg" alt="Icon" class="no-margin">
                            <span class="top-padding">JOURNALS</span>
                        </h1>
                    </header>
                    <?php include('includes/journal-info.php'); ?>
                    <header class="j-lists-header">
                        <?php if ($errors->has('title')) { ?>
                            <div class="alert alert-danger">
                                <?php foreach ($errors->get('title') as $message) { ?>
                                    <?php echo $message; ?><br>
                                <?php } ?>
                            </div>
                        <?php } ?>
                        <a href="#add-journal" class="btn-primary green btn-popup">
                            <i class="fa fa-plus" aria-hidden="true"></i> Add Journal
                        </a>
                        <div class="sort">
                            <a href="#" class="sorter">SORT <i class="fa fa-angle-down" aria-hidden="true"></i></a>
                            <div class="sort-drop">
                                <div class="sort-item active">
                                    <a href="<?php echo asset('my-journal-sorting?sorting=Newest');?>">
                                        <i class="fa fa-calendar-check-o" aria-hidden="true"></i> Newest First
                                    </a>
                                </div>
                                <div class="sort-item">
                                    <a href="<?php echo asset('my-journal-sorting?sorting=Alphabetical');?>">
                                        <i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Alphabetically
                                    </a>
                                </div>
                                <div class="sort-item">
                                    <a href="<?php echo asset('my-journal-sorting?sorting=No_Of_Entries');?>"><i class="fa fa-sort-amount-asc" aria-hidden="true"></i> No. Of Entries</a>
                                </div>
                            </div>
                        </div>
                    </header>
                    <ul class="j-lists list-none" id="journal_listing">
                        <?php if(count($journals) > 0){ ?>
                        <?php foreach ($journals as $journal){ ?>
                            <li>
                                <div class="right">
                                     <span><?php echo $journal->events_count;?></span>
                                     <span <?php if($journal->is_public == 1) echo 'class="active"';?>>
                                         <i class="fa fa-eye-slash" aria-hidden="true"></i>
                                     </span>
                                     <span class="dot-options">
                                         <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                        <div class="sort-drop">
                                             <div class="sort-item active">
                                                 <a href="#edit-journal<?php echo $journal->id;?>" class="btn-popup"><i class="fa fa-pencil" aria-hidden="true"></i> Edit Journal</a>
                                             </div>
                                             <div class="sort-item">
                                                 <a href="#" data-toggle="modal" data-target="#delete-journal<?php echo $journal->id;?>"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete Journal</a>
                                             </div>
                                         </div>
                                     </span>
                                </div>
                                <a href="<?php echo asset('journal-details/'.$journal->id);?>"><strong><?php echo $journal->title;?></strong></a>
                             </li>
                             <!-- Modal Add Journal -->
                             <div id="edit-journal<?php echo $journal->id;?>" class="popup">
                                 <div class="popup-holder">
                                     <div class="popup-area">
                                         <div class="text">
                                             <header class="header">
                                                 <strong>EDIT JOURNAL</strong>
                                             </header>
                                             <div class="padding">
                                                 <form action="<?php echo asset('update-journal'); ?>" method="post" class="add_journal-form">
                                                     <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                                     <input type="hidden" name="journal_id" value="<?php echo $journal->id;?>">
                                                     <fieldset>
                                                         <input type="text" placeholder="Journal Title" name="title" value="<?php echo $journal->title;?>" required>
                                                         <div class="fields add block">
                                                             <input type="radio" id="private" name="is_public" <?php if($journal->is_public == 0) echo 'checked'; ?> value="0">
                                                             <label for="private" class="border-bottom">Private</label>
                                                             <input type="radio" id="public" name="is_public" <?php if($journal->is_public == 1) echo 'checked'; ?> value="1"> 
                                                             <label for="public">Public</label>
                                                         </div>
                                                         <input type="submit" value="Submit">
                                                     </fieldset>
                                                 </form>
                                             </div>
                                             <a href="#" class="btn-close">Close</a>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                            <!-- Modal End -->
                            <!-- Modal Delete Journal -->
                             <div class="modal fade" id="delete-journal<?php echo $journal->id;?>" role="dialog">
                                 <div class="modal-dialog">
                                   <!-- Modal content-->
                                     <div class="modal-content">
                                         <div class="modal-header">
                                             <button type="button" class="close" data-dismiss="modal">&times;</button>
                                             <h4 class="modal-title">Delete Journal </h4>
                                         </div>
                                         <div class="modal-body">
                                             <p>Are you sure to delete this Journal: <?php echo $journal->title; ?></p>
                                         </div>
                                         <div class="modal-footer">
                                             <a href="<?php echo asset('delete-journal/'.$journal->id); ?>" type="button" class="btn-heal">yes</a>
                                             <button data-dismiss="modal" type="button" class="btn-heal">No</button>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                        <!-- Modal End-->
                       <?php } ?>
                       <?php }else{ ?>
                            <li><div> No record found. </div></li>
                        <?php } ?>
                   </ul>
                    <div style="display: none" class="hb_simple_loader" id="loading"><img src="<?php echo asset('userassets/images/new_loadeer.svg') ?>" alt="Loading . . . ." class="post-loader"><span></span></div>
                </div>
            </article>
        </div>
        <div id="add-journal" class="popup">
            <div class="popup-holder">
                <div class="popup-area">
                    <div class="text">
                        <header class="header">
                            <strong>ADD JOURNAL</strong>
                        </header>
                        <div class="padding">
                            <form action="<?php echo asset('create-journal'); ?>" method="post" class="add_journal-form">
                                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                <fieldset>
                                    <input type="text" placeholder="Journal Title" name="title" required>
                                    <div class="fields add radios">
                                        <input type="radio" id="is_private" name="is_public" value="0">
                                        <label for="is_private" class="border-bottom">Private</label>
                                        <input type="radio" id="is_public" name="is_public" checked="" value="1">
                                        <label for="is_public">Public</label>
                                    </div>
                                    <input type="submit" value="Submit" class="green">
                                </fieldset>
                            </form>
                        </div>
                        <a href="#" class="btn-close">Close</a>
                    </div>
                </div>
            </div>
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
                    ajaxcall = 0;
                    $.ajax({
                        url: "<?php echo asset('get-my-journal-loader') ?>",
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
                                $('#journal_listing').append(data);
                                $('#loading').hide();
                                ajaxcall = 1;
                            } else {
                                $('#loading').hide();
                                noposts=' <div class="loader hb_not_more_posts_lbl" id="nomoreposts">No More Journals To Show</div> ';
                                $('#journal_listing').append(noposts);
                            }
                        }
                    });
                }
                
            }
        });
    </script>
</html>