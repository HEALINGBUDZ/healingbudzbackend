<html lang="en">
    <?php include resource_path('views/admin/includes/head.php'); ?>
    <body>
        <?php include resource_path('views/admin/includes/header.php'); ?>
        <?php include resource_path('views/admin/includes/sidebar.php'); ?>
           <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.min.css" />
        <script>
            $(document).ready(function(){
               $("#atricle_type").chosen();
               $("#cat_id").chosen();
               $("#question_select").chosen({
                    width: "178px"
                });
               
               $("#user_strain_id").chosen({
                    width: "178px"
                });
                $("#atricle_type").chosen({
                    width: "178px"
                });
            });
        
        </script>
        <section class="content publicContent loginPage no-top-padding">
            <div class="contentPd">
                <div class="form-area">
                    <div class="form-holder">
                        <div class="userForm">
                            <?php if (\Session::has('success')) { ?>
                                <h4 class="alert alert-success fade in">
                                    <?php echo \Session::get('success') ?>
                                </h4>
                            <?php } ?>
                            <a class="add_s" href="<?php echo asset('admin_articles'); ?>">Back</a>
                            <form action="<?php echo asset('update_article') ?>" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                <input type="hidden" name="article_id" value="<?php echo $article->id; ?>">
                                <div class="modal-body">
                                    <div class="article-headeer article_block_fields">
                                        <label>Title (max 55 char)</label>
                                        <input type="text" name="title" maxlength="55" value="<?php echo $article->title; ?>" required="" classmaxlength="30"="block_field">
                                    </div>
                                    <div class="article-headeer article_block_fields">
                                    <label>Teaser Text</label>
                                    <textarea id="teaser_text" name="teaser_text" maxlength="200" class="block_field"><?php echo $article->teaser_text; ?></textarea>
                                </div>
                                    <div class="article-headeer-textarea">
                                        <label>Description</label>
                                        <textarea id="description" name="description" maxlength="500"><?php echo $article->description; ?></textarea>
                                    </div>
                                    <div class="article-headeer">
                                        <label>Category</label>
                                        <select name="cat_id" id="cat_id">
                                            <option value="">Select Type...</option>
                                            <?php foreach ($cats as $cat){ ?>
                                            <option value="<?= $cat->id?>" <?php
                                            if ($article->cat_id == $cat->id) { ?>
                                                    selected=""                                           <?php }
                                            ?>><?= $cat->title?></option>
                                            <?php  } ?>
                                        </select>
                                    </div>
                                    <div class="article-headeer">
                                        <label>Type</label>
                                        <select name="type" required="" id="atricle_type">
                                            <option value="">Select Type...</option>
                                            <option value="Article" <?php
                                            if ($article->type == 'Article') {
                                                echo 'selected';
                                            }
                                            ?>>Article</option>
                                            <option value="Question" <?php
                                            if ($article->type == 'Question') {
                                                echo 'selected';
                                            }
                                            ?>>Question</option>
                                            <option value="Strain" <?php
                                                    if ($article->type == 'Strain') {
                                                        echo 'selected';
                                                    }
                                            ?>>Strain</option>
                                        </select>
                                    </div>
                                    <div style="display: <?php
                                    if ($article->type == 'Strain') {
                                        echo 'block';
                                    } else {
                                        echo 'none';
                                    }
                                            ?>" id="article_strain">
                                        <div class="article-headeer">
                                            <label>Strain</label>
                                            <select name="user_strain_id" id="user_strain_id">
                                                <option value="">Select Strain...</option>
                                    <?php foreach ($user_strains as $user_strain) { ?>
                                                    <option value="<?php echo $user_strain->id ?>" <?php
                                        if ($article->user_strain_id == $user_strain->id) {
                                            echo 'selected';
                                        }
                                        ?>><?php echo $user_strain->description ?></option>
<?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div style="display: <?php
                                                if ($article->type == 'Question') {
                                                    echo 'block';
                                                } else {
                                                    echo 'none';
                                                }
                                                ?>" id="article_question">
                                        <div class="article-headeer">
                                            <label>Question</label>
                                            <select name="question_id" id="question_select">
                                                <option value="">Select Question...</option>
                                                <?php foreach ($questions as $question) { ?>
                                                    <option value="<?php echo $question->id ?>" <?php
                                                    if ($article->question_id == $question->id) {
                                                        echo 'selected';
                                                    }
                                                    ?>><?php echo $question->question ?></option>
                                                        <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div id="article_date" class="article-headeer">
                                        <label>Display Date</label>
                                        <input value="<?php echo $article->display_date; ?>" type="text" name="display_date" id="display_date" readonly/>
                                    </div>
                                    <div class="article-headeer">
                                        <label>Image </label>
                                        <div class="file btn btn-lg btn-primary">Upload<input type="file" name="image" class="custom_file_button" accept="image/x-png,image/gif,image/jpeg"></div>
                                        <div class="image-previewer" style="margin-top: 10px;">
                                            <img class="changing-image" src="<?php echo asset('public/images' . $article->image); ?>" alt="Image" style="display:block;">
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-default">Submit</button>
                                    <button type="button" class="btn btn-default modal-closer" data-dismiss="modal">Close</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
<?php include resource_path('views/admin/includes/footer.php'); ?>
        <script src="https://cdn.ckeditor.com/4.10.0/standard/ckeditor.js"></script>
        <style> .article-headeer-textarea .cke_contents textarea{
                color: black
            }</style>
        <script>
            CKEDITOR.replace('description', {
                filebrowserUploadUrl: '<?= asset('add_image') ?>',
                filebrowserUploadMethod: 'form'
            });
 
            $('#atricle_type').on('change', function (e) {
                var optionSelected = $("option:selected", this);
                var valueSelected = this.value;
//             alert(valueSelected);
                if (valueSelected === 'Question') {
                    $('#article_question').show();
                    $('#article_strain').hide();
                    $('#article_date').show();

                }
                if (valueSelected === 'Strain') {
                    $('#article_question').hide();
                    $('#article_strain').show();
                    $('#article_date').show();
                }
                if (valueSelected === 'Article') {
                    $('#article_question').hide();
                    $('#article_strain').hide();
                    $('#article_date').show();
                }
            });
        </script>
        <script>
            $("#display_date").datepicker();
        </script>
         <script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.js"></script>
    </body>
</html>