<!DOCTYPE html>
<html lang="en">
    <?php include('includes/top-new.php'); ?>
    <body>
        <div id="wrapper">
            <?php include('includes/sidebar.php'); ?>
            <article id="content">
                <?php include('includes/header.php'); ?>
                <div class="padding-div">
                    <div class="messages-screen">
                        <form action="<?php echo asset('search-user');?>" method="get">
                            <fieldset>
                                <input type="search" placeholder="Search User" name="search">
                                <button type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
                            </fieldset>
                        </form>
                        <ul class="messages-table">
                            <?php if(isset($users[0])){  foreach ($users as $user){ 
                                $user_image= getImage($user->image_path, $user->avatar);
                            ?>
                            <li class="">
                                <a href="<?= asset('message-detail/'.$user->id)?>">
                                <div class="tab-cell cus-img">
                                    <figure>
                                        <img src="<?php echo $user_image; ?>" alt="Icon">
                                        <!--<span>5</span>-->
                                    </figure>
                                </div>
                                <div class="tab-cell cus-text">
                                    <span><?php echo $user->first_name ?></span>
                                </div>
                                </a>
                                <div class="tab-cell cus-icon">
                                    <span><?php //echo timeago($chat->lastMessage->created_at) ?></span>
                                    <!--<a href="#" data-toggle="modal" data-target="#delete-chat<?php echo $user->id?>"><i class="fa fa-trash"></i></a>-->
                                </div>
                            </li>
                            <!-- Modal -->
                            <div class="modal fade" id="delete-chat<?php echo $user->id?>" role="dialog">
                                <div class="modal-dialog">
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">Delete Chat</h4>
                                        </div>
                                        <div class="modal-body">
                                            <p>Are you sure to delete this Chat </p>
                                        </div>
                                        <div class="modal-footer">
                                            <a href="<?php //echo asset('delete-chat/'.$chat->id);?>" type="button" class="btn-heal">yes</a>
                                            <button data-dismiss="modal" type="button" class="btn-heal">No</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Modal End-->
                            <?php } }else{ ?>
                            <span class="no-records">No Record Found</span>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </article>
        </div>
        <?php include('includes/footer-new.php'); ?>
    </body>
</html>