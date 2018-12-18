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
                    <li><a href="<?php echo asset('/'); ?>">Home</a></li>
                    <li>Journals</li>
                </ul>
                <?php if(isset($_GET['sorting'])) { 
                    $sorting=$_GET['sorting'];
                }else{
                    $sorting='';
                }
                if(isset($_GET['q'])) {
                    $q=$_GET['q'];
                }else{
                    $q='';
                }?>
                <header class="intro-header no-bg">
                        <h1 class="custom-heading white text-center">
                            <img src="userassets/images/side-icon16.svg" alt="Icon" class="no-margin">
                            <span class="top-padding">JOURNALS</span>
                        </h1>
                    </header>

                <div class="search-area">
                    <form action="<?php echo asset('journal-search');?>" class="search-form" method="get">
                        <input name="q" type="search" placeholder="Search">
                        <input name="ser" type="submit" value="Submit">
                    </form>
                    <div class="sort-dropdown">
                        <div class="form-holder">
                            <form action="<?php echo asset('journal-sorting');?>" id="q_sorting" class="green-border">
                                <fieldset>
                                    <select name="sorting" id="sorting_value">
                                        <?php if(isset($_GET['sorting'])) { ?>
                                        <option value="<?php echo $_GET['sorting'];?>" selected=""><?php echo $_GET['sorting'];?> </option>
                                        <?php } else { ?>
                                        <option value="" selected="">Journals</option>
                                        <?php } ?>
                                    </select>
                                </fieldset>
                            </form>
                            <a href="#" class="options-toggler opener green">
                                <i class="fa fa-caret-down" aria-hidden="true"></i>
                            </a>
                        </div>
                        <div class="options">
                            <ul class="green list-none">
                                <li>
                                    <i class="fa fa-sort-alpha-asc green add" aria-hidden="true"></i> <span>Alphabetical</span>
                                </li>
                                <li>
                                    <img src="<?php echo asset('userassets/images/new-green.svg')?>" alt="Newest">
                                    <span>Newest</span>
                                </li>
                                <li>
                                    <i class="fa fa-heart green add" aria-hidden="true"></i>
                                    <span>Favorites</span>
                                </li>
                            </ul>
                            <a href="#" class="options-toggler closer green"><i class="fa fa-caret-up" aria-hidden="true"></i></a>
                        </div>
                    </div>
                    <a href="#add-journal" class="btn-popup">
                        <img src="<?php echo asset('userassets/images/journal-icon.svg')?>" alt="Newest" class="journal-icon">
                    </a>
                </div>
                <?php if ($errors->has('title')) { ?>
                    <div class="alert alert-danger">
                        <?php foreach ($errors->get('title') as $message) { ?>
                            <?php echo $message; ?><br>
                        <?php } ?>
                    </div>
                <?php } ?>
                <div class="med-reactions" id="journals_listing">
                <div class="med-posts-area">
                    <?php if($journals && count($journals) > 0){ ?>
                        <?php foreach ($journals as $journal) { ?>
                            <div class="med-post">
                                <div class="img">
                                    <?php if($journal->getUser->image_path) { ?>
                                        <img src="<?php echo asset('public/images'.$journal->getUser->image_path)?>" alt="User" class="img-responsive">
                                    <?php } else{ ?>
                                        <img src="<?php echo asset('public/images'.$journal->getUser->avatar)?>" alt="User" class="img-responsive">
                                    <?php } ?>
                                </div>
                                <div class="txt">
                                    <header class="header">
                                        <div class="left">
                                            <?php if(count($journal->events) > 0) { ?>
                                                <a href="<?php echo asset('journal-details/'.$journal->id); ?>"><strong><?php echo $journal->title ?></strong></a>
                                            <?php }else{ ?>
                                                <strong><?php echo $journal->title ?></strong>
                                            <?php } ?>
                                            <em><?php echo $journal->getUser->first_name; ?></em>
                                        </div>
                                        <ul class="right list-none">
                                            <li>
                                                <a <?php if (checkMySaveSetting('save_journal')) { ?> href="javascript:void(0)" <?php } else { ?> href="#saved-journal" <?php } ?> <?php if($journal->get_user_favorites_count) { ?> style="display: none"<?php } ?> class="btn-popup green-border" onclick="addJournalMySave('<?php echo $journal->id;?>')" id="addJournalFav<?php echo $journal->id;?>">
                                                    <i class="fa fa-heart-o" aria-hidden="true"></i>
                                                </a>
                                                <a href="#" <?php if(!$journal->get_user_favorites_count) { ?> style="display: none"<?php } ?> class="btn-popup active" onclick="removeJournalMySave('<?php echo $journal->id;?>')" id="removeJounalFav<?php echo $journal->id;?>">
                                                    <i class="fa fa-heart-o" aria-hidden="true"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#" class="share-icon"><i class="fa fa-share-alt" aria-hidden="true"></i></a>
                                                <div class="custom-shares">
                                                    <?php echo Share::page( asset('journal-details/'.$journal->id), $journal->title, ['class' => 'journal_class','id'=>$journal->id])
                                                        ->facebook($journal->title)
                                                        ->twitter($journal->title)
                                                        ->googlePlus($journal->title);
                                                    ?>
                                                </div>
                                            </li>
                                            <?php if(count($journal->events) > 0) { ?>
                                                <li><a href="#" class="opener"><i class="fa fa-chevron-right" aria-hidden="true"></i></a></li>
                                            <?php } ?>
                                        </ul>
                                    </header>
                                    <div class="items">
                                        <?php foreach ($journal->events as $event) { ?>
                                            <div class="item">
                                                <div class="left">
                                                    <a href="<?php echo asset('journal-event-detail/'.$event->id); ?>"><h4><?php echo $event->title; ?></h4></a>
                                                    <span class="date">
                                                        <i class="fa fa-calendar" aria-hidden="true"></i>
                                                        <?php echo timeZoneConversion($event->date, 'D d M y, h:i A', \Request::ip());?>
                                                          <?php //echo date('D d M y, h:i A', strtotime($event->created_at));?>  
                                                    </span>
                                                </div>
                                                <span class="right-smily"><?php echo LaravelEmojiOne::toImage($event->feeling); ?></span>
                                                <!--<img src="<?php //echo asset('userassets/images/happy.png')?>" alt="Happy" class="right-smily">-->
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    <?php }else{ ?>
                        <div id="loading"> No record found. </div>
                    <?php } ?>
                </div>
                <div style="display: none" id="loading"> Loading . . . . </div>
                </div>
            </div>
        </article>
    </div>
    <div id="saved-journal" class="popup light-brown">
        <div class="popup-holder">
            <div class="popup-area">
                <div class="text">
                    <header class="header no-padding add">
                        <strong>Saved Journal</strong>
                    </header>
                    <div class="padding">
                        <p><img src="<?php echo asset('userassets/images/bg-success.svg')?>" alt="Icon">Journal saved in the app menu under My Saves</p>
                        <div class="check">
                            <input type="checkbox" id="check" onchange="addSaveSetting('save_journal',this)">
                            <label for="check">Got it! Do not show again for Journal | Save</label>
                        </div>
                    </div>
                    <a href="#" class="btn-close">Close</a>
                </div>
            </div>
        </div>
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
    <?php include('includes/footer.php');?>
    <?php include 'includes/functions.php';?>
    <script>
        function removeJournalMySave(id) {
            $.ajax({
                url: "<?php echo asset('journal-remove-favorit') ?>",
                type: "POST",
                data: {"journal_id": id, "_token": "<?php echo csrf_token(); ?>"},
                success: function (response) {
                    if (response.status == 'success') {
                        $('#removeJounalFav' + id).hide();
                        $('#addJournalFav' + id).show();
                    }
                }
            });
        }
        
        function addJournalMySave(id) {
            $.ajax({
                url: "<?php echo asset('journal-add-favorit') ?>",
                type: "POST",
                data: {"journal_id": id, "_token": "<?php echo csrf_token(); ?>"},
                success: function (response) {
                    if (response.status == 'success') {
                        $('#addJournalFav' + id).hide();
                        $('#removeJounalFav' + id).show();
                    }
                }
            });
        }
    </script>
    
     <script> 
         
        $('.journal_class').click(function(){
//            alert(this.id);
            $(this).parents('.custom-shares').hide();
//            question_id = this.id;
//            $.ajax({
//                url: "<?php echo asset('add_question_share_points') ?>",
//                type: "GET",
//                data: {
//                    "question_id": question_id
//                },
//                success: function(data) {
//                }
//            });  
        });
         
        var win = $(window);
        var count = 1;
        var ajaxcall = 1;
        var sorting = '<?= $sorting ?>';
         var q = '<?= $q ?>';
        win.on('scroll', function() {
            var docheight = parseInt($(document).height());
            var winheight = parseInt(win.height());
            var differnce = (docheight - winheight) - win.scrollTop();
            if (differnce < 100) {
                if (ajaxcall === 1) {
                    $('#loading').show();
                    ajaxcall = 0;
                    $.ajax({
                        url: "<?php echo asset('get-journal-loader') ?>",
                        type: "GET",
                        data: {
                            "count": count,
                            "sorting":sorting,
                            "q":q
                        },
                        success: function(data) {
                            if (data) {
                                var a = parseInt(1);
                                var b = parseInt(count);
                                count = b + a;
                                $('#journals_listing').append(data);
                                $('#loading').hide();
                                ajaxcall = 1;
                            } else {
                                $('#loading').hide();
                                noposts=' <div class="loader hb_not_more_posts_lbl" id="nomoreposts">No More Journals To Show</div> ';
                                $('#journals_listing').append(noposts);
                            }
                        }
                    });
                }
                
            }
        });
</script>
</body>
</html>