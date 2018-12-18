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
                    <li><a href="<?php echo asset('groups'); ?>">Groups</a></li>
                    <li>Group Invitation</li>
                </ul>
                <div class="groups">
                    <header class="header no-bg">
                        <strong>Group Invitation</strong>
                    </header>
                    <?php if ($errors->all()) { 
                            $errors= $errors->all();
                            foreach ($errors as $error){ ?>
                            <h5 class="alert alert-danger"><?php echo $error;?></h5>
                            <?php }
                    }
                    ?>
                    <form action="<?php echo asset('group-invitation');?>" method="post" class="create-group-form">
                        <input type="hidden" name="_token" value="<?php echo csrf_token();?>">
                        <input type="hidden" name="invitation_id" value="<?php echo $invitation->id; ?>">
                        <input type="hidden" name="group_id" value="<?php echo $invitation->group_id; ?>">
                        <fieldset>
                            <div class="form-txt">
                                <footer class="form-footer">
                                    <h2><?php echo $invitation->group->title; ?></h2>
                                    <div class="fields">
                                        <div class="pb">
                                            <input type="radio" id="accepted" name="invitation_responce" value="1" checked="">
                                            <label for="accepted"><span>Accept</span></label>
                                            <input type="radio" id="rejected" name="invitation_responce" value="0">
                                            <label for="rejected"><span>Reject</span></label>
                                        </div>
                                    </div>
                                    <input type="submit" value="Submit" class="btn-primary">
                                </footer>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </article>
    </div>
    <?php include('includes/footer.php');?>
</body>
</html>