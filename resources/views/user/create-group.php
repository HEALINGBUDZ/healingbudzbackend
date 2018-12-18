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
                    <li>Create Group</li>
                </ul>
                <div class="groups">
                    <header class="header no-bg">
                        <strong class="no-pl">Groups</strong>
                    </header>
                    <?php if ($errors->all()) { 
                            $errors= $errors->all();
                            foreach ($errors as $error){ ?>
                    <h5 class="alert alert-danger"><?php echo $error;?></h5>
                            <?php }
                    }
                    ?>
                    <form action="<?php echo asset('create-group');?>" method="post" enctype="multipart/form-data"class="create-group-form">
                        <input type="hidden" name="_token" value="<?php echo csrf_token();?>">
                        <fieldset>
                            <div class="header" style="background-image: url(); background-size:cover; background-repeat:no-repeat;">
                                <input name="image" type="file" id="feature-image" class="hidden">
                                <label for="feature-image" class="custom-label">Upload a group featured image</label>
                            </div>
                            <div class="form-txt">
                                <input type="text"  name="title" placeholder="Add Group Name" class="input-title">
                                <textarea  name="description" placeholder="Add Group Description"></textarea>
                                <h5>Add Group Tags</h5>
                                <!-- <strong class="title">Search Tag Keywords</strong> -->
                                <div class="genetic-txt fluid">
                                    <strong class="title">
                                        <select  multiple="" data-placeholder="Search Tag Keywords" name="tags[]" class="chosen-select" tabindex="1">
                                            <option value=""></option>
                                            <?php foreach ($tags as $tag){ ?>
                                            <option value="<?php echo $tag->id;?>"><?php echo $tag->title;?></option>
                                            <?php } ?>
                                        </select>
                                    </strong>
                                </div>
                                <footer class="form-footer">
                                    <strong>Group Visibility</strong>
                                    <div class="fields">
                                        <div class="pb">
                                            <input type="radio" id="private" name="pb-group" checked>
                                            <label for="private"><span>Private</span></label>
                                            <input type="radio" id="public" name="pb-group">
                                            <label for="public"><span>Public</span></label>
                                        </div>
                                    </div>
                                    <input type="submit" value="Create Group" class="btn-primary">
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
<script>  
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('.header').css('background-image', 'url(' + e.target.result + ')');
            //$('#showgroupimage').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

$("#feature-image").change(function(){
    readURL(this);
});
</script>
</html>