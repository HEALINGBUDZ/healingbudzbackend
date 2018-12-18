<!DOCTYPE html>
<html lang="en">
<?php include resource_path('views/admin/includes/head.php'); ?>
<body>
<?php include resource_path('views/admin/includes/header.php'); ?>
<?php include resource_path('views/admin/includes/sidebar.php'); ?>
<section class="content lifeContent">
    <h2>Question</h2>
    <p><strong>Question</strong><?= $question->question?></p>
    <p><strong>Description</strong><?= $question->description?></p>
    <h4>User</h4>
    <img alt="User Pic" src="<?php echo getImage($question->getUser->image_path, $question->getUser->avatar);?>" width="200" height="200">
    <p><a href='<?php echo asset('user_detail/'.$question->getUser->id); ?>'><?= $question->getUser->first_name?></a></p>
    
    <h3>Answers</h3>
    <?php if(count($question->getAnswers) > 0){ ?>
        <?php foreach($question->getAnswers as $answer){ ?>
            <p><strong>Answer:</strong><?= $answer->answer?></p>
            <h4>User</h4>
            <img alt="User Pic" src="<?php echo getImage($answer->getUser->image_path, $answer->getUser->avatar);?>" width="200" height="200">
            <p><a href='<?php echo asset('user_detail/'.$answer->getUser->id); ?>'><?= $answer->getUser->first_name;?></a></p>
        <?php } ?>
    <?php }else{ ?>
            <span>no any answer yet</span>
    <?php } ?>
    
</section>
<?php include resource_path('views/admin/includes/footer.php'); ?>
</body>
</html>


