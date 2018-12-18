<html lang="en">
    <?php include resource_path('views/admin/includes/head.php'); ?>
    <body>
        <?php include resource_path('views/admin/includes/header.php'); ?>
        <?php include resource_path('views/admin/includes/sidebar.php'); ?>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.min.css" />
        <script>
            $(document).ready(function(){
                 $("#cat_id").chosen({
                    width: "178px"
                });
               $("#user_strain_select").chosen({
                    width: "178px"
                });
               
               $("#article_question_dropdown").chosen({
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
                        <div class="userForm upload-forms">
                            <?php if(\Session::has('success')){ ?>
                                <h4 class="alert alert-success fade in">
                                    <?php echo \Session::get('success') ?>
                                </h4>
                            <?php } ?>
                            <a class="add_s" href="<?php echo asset('admin_articles'); ?>">Back</a>
                            <form action="<?php echo asset('add_article')?>" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                <div class="modal-body">
                                    
                                <div class="article-headeer article_block_fields">
                                    <label>Title (max 55 char)</label>
                                    <input type="text" value="" name="title" maxlength="55" value="<?php echo old('title'); ?>" required="" class="block_field">
                                </div>
                                    <div class="article-headeer article_block_fields">
                                    <label>Teaser Text</label>
                                    <textarea id="teaser_text" name="teaser_text" maxlength="200" class="block_field"><?php echo old('teaser_text'); ?></textarea>
                                </div>
                                  <div class="article-headeer-textarea">
                                    <label>Description</label>
                                    <textarea id="description" name="description" maxlength="500"><?php echo old('description'); ?></textarea>
                                </div>
                                    <div class="article-headeer">
                                        <label>Category</label>
                                        <select name="cat_id" id="cat_id">
                                            <option value="">Select Type...</option>
                                            <?php foreach ($cats as $cat){ ?>
                                            <option value="<?= $cat->id?>"><?= $cat->title?></option>
                                            <?php  } ?>
                                        </select>
                                    </div>
                                  <div class="article-headeer">
                                    <label>Type</label>
                                    <select name="type" required="" id="atricle_type">
                                        <option value="">Select Type...</option>
                                        <option value="Article">Article</option>
                                        <option value="Question">Question</option>
                                        <option value="Strain">Strain</option>
                                    </select>
                                   </div>
                                   <div  style="display: none" id="article_date" class="article-headeer">
                                        <label>Display Date</label>
                                        <input type="text" name="display_date" id="display_date" readonly/>
                                   </div>
                                    <div style="display: none" id="article_strain">
                                         <div class="article-headeer">
                                        <label>Strain</label>
                                        <select name="user_strain_id" id="user_strain_select">
                                            <option value="">Select Strain...</option>
                                            <?php foreach($user_strains as $user_strain){ ?>
                                            <option value="<?php echo $user_strain->id?>"><?php echo $user_strain->description?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                    <div style="display: none" id="article_question">
                                         <div class="article-headeer">
                                        <label>Question</label>
                                        <select name="question_id" id="article_question_dropdown">
                                            <option value="">Select Question...</option>
                                            <?php foreach($questions as $question){ ?>
                                            <option value="<?php echo $question->id?>"><?php echo $question->question?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                    <div class="article-headeer">
                                    <label>Image </label>
                                    <div class="file btn btn-lg btn-primary">Upload<input type="file" name="image" class="custom_file_button" accept="image/x-png,image/gif,image/jpeg" required=""></div></div>
                                    <div class="article-headeer">
                                    <div class="image-previewer"><img class="changing-image" src="#" alt="Image"></div>
                                </div>
                                 <div class="modal-footer">
                                    <button type="submit" class="btn btn-default">Submit</button>
                                    <button type="button" class="btn btn-default modal-closer" data-dismiss="modal">Close</button>
                                </div>
                                </div>
                               
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <?php include resource_path('views/admin/includes/footer.php'); ?>
        <script src="https://cdn.ckeditor.com/4.10.0/standard/ckeditor.js"></script>
        <style>
            .article-headeer-textarea .cke_contents textarea{
                color: black
            }
        </style>
        <script>
            CKEDITOR.replace( 'description', {
    filebrowserUploadUrl: '<?= asset('add_image')?>',
    filebrowserUploadMethod :'form'
});
            
            
        $('#atricle_type').on('change', function (e) {
            var optionSelected = $("option:selected", this);
            var valueSelected = this.value;
//            alert(valueSelected);
            if(valueSelected === 'Question'){
                $('#article_question').show();
                $('#article_strain').hide();
                $('#article_date').show();
            }
            if(valueSelected === 'Strain'){
                $('#article_question').hide();
                $('#article_strain').show();
                $('#article_date').show();
            }
            if(valueSelected === 'Article'){
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