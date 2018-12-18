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
                        <li><a href="<?php echo asset('/') ?>">Home</a></li>
                        <li><a href="<?php echo asset('groups') ?>">Groups</a></li>
                        <li>Edit Group</li>
                    </ul>
                    <div class="groups">
                        <header class="header">
                            <a href="<?php echo asset('create-group') ?>" class="create-group">Create Group</a>
                            <strong>Edit Group</strong>
                        </header>
                        <ul class="list-none fluid">
                            <li>
                                <div class="list-holder">
                                    <div class="actions">
                                        <a href="#" class="lock"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                        <a href="#invite-member-popup" class="btn-primary btn-popup">Invite A Bud</a>
                                        <a href="#delete-group" class="btn-primary btn-popup">Close Group</a>
                                    </div>
                                    <div class="txt">
                                        <div class="img-holder">
                                            <img src="<?php echo asset('public/images'.$group->image) ?>" alt="Image" class="img-responsive">
                                            <?php // if ($group->unread_count_count) { ?>
                                                <!--<span class="counts"><?php // echo $group->unread_count_count; ?></span>-->
                                            <?php // } ?>
                                        </div>
                                        <div class="text fluid">
                                            <strong class="orange-text"><?php ?></strong>
                                            <span><?php echo $group->get_members_count; ?> Budz</span>
                                        </div>
                                    </div>
                                </div>
                                <form action="<?php echo asset('update-group'); ?>" method="post" class="setting-form">
                                    <strong class="form-title">Group Name</strong>
                                    <input type="hidden" name="_token" value="<?= csrf_token() ?>">
                                    <input type="hidden" name="id" value="<?= $group->id ?>">
                                    <fieldset>
                                        <input name="title" type="text" placeholder="" value="<?= $group->title ?>">
                                        <strong class="form-title">Group Description</strong>
                                        <textarea name="description" placeholder="Edit Group Description"><?= revertTagSpace($group->description) ?></textarea>
                                        <strong class="form-title">Tags</strong>
                                        <select id="tags" multiple="" placeholder="Edit Tags" name="tags[]" class="chosen-select" tabindex="1">
                                            <?php foreach ($tags as $tag) { ?>
                                                <option value="<?php echo $tag->id; ?>"><?php echo $tag->title; ?></option>
                                            <?php } ?>
                                        </select>
                                        <!-- <input type="text" placeholder="Member Details" class="disabled"> -->
                                        <strong class="form-title">Member Details</strong>
                                        <div class="cols">
                                            <div class="row">
                                                <?php foreach ($group->getMembers as $members) { ?>
                                                    <div class="col">
                                                        <img src="<?php echo getImage($members->user->image_path, $members->user->avatar) ?>" alt="Image">
                                                        <span><?php echo $members->user->first_name; ?></span>
                                                        <a href="#warning-popup<?= $members->id?>" class="btn-warning btn-popup"></a>
                                                    </div>
                                                    <div id="warning-popup<?= $members->id?>" class="popup">
                                                        <div class="popup-holder">
                                                            <div class="popup-area">
                                                                <div class="text">
                                                                    <div class="edit-holder">
                                                                        <div class="step">
                                                                            <div class="step-header">
                                                                                <h4>Confirmation</h4>
                                                                                <p>Are you sure to delete ?</p>
                                                                            </div>
                                                                            <div class="txt">
                                                                                <a href="<?php echo asset('remove-member/'.$members->id);?>" class="btn-primary block">Delete</a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <a href="#" class="btn-close orange"></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <input type="submit" value="Submit">
                                    </fieldset>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </article>
        </div>

        <div id="delete-group" class="popup">
            <div class="popup-holder">
                <div class="popup-area">
                    <div class="text">
                        <div class="edit-holder">
                            <div class="step">
                                <div class="step-header">
                                    <h4>Delete Group</h4>
                                    <p>Are you sure to delete the group permanently ?</p>
                                </div>
                                <div class="txt">
                                    <a href="<?php echo asset('remove-group/'.$group->id);?>" class="btn-primary block">Delete Group</a>
                                </div>
                            </div>
                        </div>
                        <a href="#" class="btn-close orange"></a>
                    </div>
                </div>
            </div>
        </div>
        <div id="invite-member-popup" class="popup">
            <div class="popup-holder">
                <div class="popup-area">
                    <div class="text">
                        <div class="edit-holder">
                            <div class="step">
                                <div class="step-header">
                                    <h4>INVITE MEMBER TO GROUP</h4>
                                </div>
                                
                                <form onsubmit="return checkValidation(this)"  action="<?php echo asset('invite-bud');?>" id="medical_suggestion" class="edit-search-form" method="post">
                                    <input type="hidden" name="group_id" value="<?= $group->id?>">
                                    <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                    <input type="hidden" name="previous" value="previous">
                                    
                                    <fieldset>
                                        <div class="edit-search-area">
                                            <span>Begin typing a Bud Name or Email to search</span>
                                            <h5 class="alert alert-danger" id="errors" style="display: none">Please Select One</h5>
                                            <span>
                                                <select id="followerstags" placeholder="Begin typing search term" name="friends[]" multiple="" class="chosen-select" tabindex="-1" style="display: none;">
                                                    <?php foreach ($followings as $following) { ?>
                                                    <option value="<?= $following->user->id?>"><?= $following->user->first_name?></option>
                                                    <?php } ?>
                                                    
                                                </select>                                                                                            
                                            </span>
                                            <div class="misc"><span>or</span></div>
                                            <strong class="misc-title">Invite via email address</strong>
                                            <span>
                                                <input id="invite_email" type="email" class="bud_email" name="email">
                                            </span>
                                            <input onClick="return checkValidation()" type="submit" value="INVITE NEW MEMBER"  class="btn-primary orange fluid">
                    
                                        </div>
                                    </fieldset>
                                </form>
                            </div>
                        </div>
                        <a href="#" class="btn-close orange"><i class="fa fa-times-circle" aria-hidden="true"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <?php include('includes/footer.php'); ?>
    </body>
    <script>
        $(document).ready(function () {
            var tags_id = '<?php echo(implode(',', $group->getTags->pluck('tag_id')->toarray())); ?>';
            var tags_id_array = tags_id.split(',');
            $('#tags').val(tags_id_array).trigger('chosen:updated');
            
            var users_id = '<?php echo(implode(',', $group->getMembers->pluck('user_id')->toarray())); ?>';
           
    var user_id_array = users_id.split(',');
                $('#followerstags').val(user_id_array).trigger('chosen:updated');

        });
        function checkValidation(){
         users=$('#followerstags').val();
         email=$('#invite_email').val();
         if( (email !== '') || (users.length  !== 0)){
             $('#errors').hide();
             return true;
         }else{
             $('#errors').show();
             return false;
         }
        };
    </script>
</html>