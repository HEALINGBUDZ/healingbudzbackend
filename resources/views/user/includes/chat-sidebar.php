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
                    <li><a href="<?php echo asset('/questions'); ?>">Q&amp;A</a></li>
                    <li>Questions</li>
                </ul>
                <?php
                    if(isset($_GET['sorting'])) { 
                        $sorting=$_GET['sorting'];
                    }else{
                        $sorting='';
                    }
                    if(isset($_GET['q'])) { 
                        $q=$_GET['q'];
                    }else{
                        $q='';
                    }
                ?>
                <header class="intro-header no-bg">
                    <h1 class="custom-heading white text-center">
                        <img src="userassets/images/side-icon12.svg" alt="Icon" class="no-margin">
                        <span class="top-padding">Q&A</span>
                    </h1>
                </header>
                <div class="new_container">
                   
                    <div class="search-area updated">
                        <!-- <a href="<?php //echo asset('ask-questions'); ?>" class="btn-ask">Ask Q</a> -->
                        <div class="sort-dropdown new_dropdown">
                        
                            <div class="options">
                                <ul class="list-none">
                                    
                                    <li>
                                        <img src="<?php echo asset('userassets/images/heart-icon.svg')?>" alt="Favorites">
                                        <span>Favorites</span>
                                        <?php if(isset($_GET['sorting'])) { 
                                            if($_GET['sorting'] == 'Favorites'){
                                            ?>
                                        <a href="<?= asset('questions')?>"><i class="fa fa-times" aria-hidden="true"></i></a>
                                        <?php }} ?>
                                    </li>
                                    <li>
                                        <img src="<?php echo asset('userassets/images/new-icon.svg')?>" alt="Newest">
                                        <span>Newest</span>
                                        <?php if(isset($_GET['sorting'])) { 
                                            if($_GET['sorting'] == 'Newest'){
                                            ?>
                                        <a href="<?= asset('questions')?>"><i class="fa fa-times" aria-hidden="true"></i></a>
                                        <?php }} ?>
                                    </li>
                                    <li>
                                        <img src="<?php echo asset('userassets/images/question-icon2.svg')?>" alt="Unanswered">
                                        <span>Unanswered</span>
                                        <?php if(isset($_GET['sorting'])) { 
                                            if($_GET['sorting'] == 'Unanswered'){
                                            ?>
                                        <a href="<?= asset('questions')?>"><i class="fa fa-times" aria-hidden="true"></i></a>
                                        <?php }} ?>
                                    </li>
                                    <li>
                                        <img src="<?php echo asset('userassets/images/question-icon.svg')?>" alt="Unanswered">
                                        <span>My Questions</span>
                                        <?php if(isset($_GET['sorting'])) { 
                                            if($_GET['sorting'] == 'My Questions'){
                                            ?>
                                        <a href="<?= asset('questions')?>"><i class="fa fa-times" aria-hidden="true"></i></a>
                                        <?php }} ?>
                                    </li>
                                    <li>
                                        <img src="<?php echo asset('userassets/images/answer-icon.svg')?>" alt="My Answers">
                                        <span>My Answers</span>
                                        <?php if(isset($_GET['sorting'])) { 
                                            if($_GET['sorting'] == 'My Answers'){
                                            ?>
                                        <a href="<?= asset('questions')?>"><i class="fa fa-times" aria-hidden="true"></i></a>
                                        <?php }} ?>
                                    </li>
                                </ul>
                                <a href="#" class="options-toggler closer"><i class="fa fa-caret-up" aria-hidden="true"></i></a>
                            </div>
                        </div>
                    </div>
              
                </div>
               <?php include 'includes/chat-rightsidebar.php';?>
            </div>
        </article>
    </div>
   
    <div id="saved-discuss" class="popup light-brown">
        <div class="popup-holder">
            <div class="popup-area">
                <div class="text">
                    <header class="header no-padding add">
                        <strong>Saved Discussion</strong>
                    </header>
                    <div class="padding">
                        <p><img src="<?php echo asset('userassets/images/bg-success.svg')?>" alt="Icon">Q's &amp; A's are saved in the app menu under My Saves</p>
                        <div class="check">
                            <input type="checkbox" id="check" onchange="addSaveSetting('save_question',this)">
                            <label for="check">Got it! Do not show again for Q's &amp; A's | Save</label>
                        </div>
                    </div>
                    <a href="#" class="btn-close purple">Close</a>
                </div>
            </div>
        </div>
    </div>
    <?php include('includes/footer.php');?>
    <?php include 'includes/functions.php';?>
    
    <script> 
        
        $('.questions_class').click(function(){
            $(this).parents('.custom-shares.new-shares').hide();
            question_id = this.id;
            $.ajax({
                url: "<?php echo asset('add_question_share_points') ?>",
                type: "GET",
                data: {
                    "question_id": question_id
                },
                success: function(data) {
                }
            });  
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
                        url: "<?php echo asset('get-question-loader') ?>",
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
                                $('#questions_listing').append(data);
                                $('#loading').hide();
                                ajaxcall = 1;
                            } else {
                                 $('#loading').hide();
                                noposts='<div class="loader hb_not_more_posts_lbl" id="nomoreposts">No More Questions To Show</div>';
                                $('#questions_listing').append(noposts);
                            }
                        }
                    });
                }
               
            }
        });
    </script>
</body>

</html>