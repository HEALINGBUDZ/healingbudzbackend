<!DOCTYPE html>
<html lang="en">
<?php include resource_path('views/admin/includes/head.php'); ?>
<body>
<?php include resource_path('views/admin/includes/header.php'); ?>
<?php include resource_path('views/admin/includes/sidebar.php'); ?>
<section class="content lifeContent">
    <h2>Answer</h2>
    <p><strong>Answer</strong><?= $answer->answer?></p>
    <h4>User</h4>
    <img alt="User Pic" src="<?php echo getImage($answer->getUser->image_path, $answer->getUser->avatar);?>" width="200" height="200">
    <p><a href='<?php echo asset('user_detail/'.$answer->getUser->id); ?>'><?= $answer->getUser->first_name?></a></p>
    
    <h3>Question</h3>
    <p><strong>Question:</strong><?= $answer->getQuestion->question; ?></p>
    <p><strong>Description:</strong><?= $answer->getQuestion->description; ?></p>
    <h4>User</h4>
    <img alt="User Pic" src="<?php echo getImage($answer->getQuestion->getUser->image_path, $answer->getQuestion->getUser->avatar);?>" width="200" height="200">
    <p><a href='<?php echo asset('user_detail/'.$answer->getQuestion->getUser->id); ?>'><?= $answer->getQuestion->getUser->first_name;?></a></p>
    
</section>
<?php include resource_path('views/admin/includes/footer.php'); ?>
</body>
</html>


