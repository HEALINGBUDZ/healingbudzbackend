<!DOCTYPE html>
<html lang="en">
<?php include resource_path('views/admin/includes/head.php'); ?>
<body>
<?php include resource_path('views/admin/includes/header.php'); ?>
<?php include resource_path('views/admin/includes/sidebar.php'); ?>
<section class="content lifeContent">
    <div class="container container-width">
        <div class="row">
            <div class="col-md-3 col-sm-4">
                <div class="statbox tabs tabe-margin">
                    <div class="stat-title">Total Articles: <?= count($articles); ?></div>
                </div>
            </div>
            <div class="col-md-3 col-sm-4">
                <div class="statbox tabs tabe-margin">
                    <div class="stat-title">Total Strains Articles:<?= $strain_articles_count; ?></div>
                </div>
            </div>
            <div class="col-md-3 col-sm-4">
                <div class="statbox tabs tabe-margin">
                    <div class="stat-title">Total Question Articles:<?= $question_articles_count; ?></div>
                </div>
            </div>
        </div>
    </div>
    <?php if(\Session::has('success')) { ?>
        <h4 class="alert alert-success fade in">
            <?php echo \Session::get('success'); ?>
        </h4>
    <?php } ?>
    <!--<a data-target="#add-modal" data-toggle="modal" class="add_s" href="#">Add New Product</a>-->
    <a class="add_s" href="<?php echo asset('add_article')?>">Add Article</a>
    <!--<a data-target="#add-modal" data-toggle="modal" class="add_s" href="#">Add Article</a>-->
    <a class="add_s" href="<?php echo asset('admin_articles')?>">View All</a>
    <a class="add_s" href="<?php echo asset('admin_articles?type=Article')?>">View Articles</a>
    <a class="add_s" href="<?php echo asset('admin_articles?type=Strain')?>">View Strain Articles</a>
    <a class="add_s" href="<?php echo asset('admin_articles?type=Question')?>">View Question Articles</a>
    <a class="add_s" href="<?php echo asset('admin_articles_categories')?>">Categories</a>
    <div class="contentPd">
        <h2 class="mainHEading mainsubheading">Articles</h2>
        
        <?php if($errors->any()) { ?>
            <div class="alert alert-danger">
                <?php foreach ($errors->all() as $error) { ?>
                    <?= $error ?><br/>
                <?php } ?>
            </div>
        <?php } ?>
        <table id="tableStyle" class="display" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th width="100">Sr.</th>
                <th>Type</th>
                <th>Title</th>
                <th>Teaser Text</th>
                <th>Category</th>
               <!--<th>Is Displayed</th>-->
                <th>Display Date</th>
                <th width="120">Actions</th>
            </tr>
            </thead>
            <tbody>
                <?php if(count($articles) > 0){ ?>
                    <?php 
                    $i = 1;
                    foreach($articles as $article){  ?>
                    <tr>
                        <td><?php echo $i; $i++; ?></td>
                        <td><?= $article->type; ?></td>
                        <td><?= $article->title; ?></td>
                       <td><?= $article->teaser_text; ?></td>
                       <td><?php if($article->category){echo $article->category->title ;} ?></td>
                        <td>
                            <?php 
                                if(empty($article->display_date)){
                                    echo '';
                                }else{
                                    echo date("m-d-Y", strtotime($article->display_date));
                            }
                            ?>
                        </td>
                        <td>
                            <a href="<?php echo asset('edit_article_view/'.$article->id)?>">
                                <i class="fa fa-pencil-square-o fa-fw"></i>
                            </a>
                            <a data-target="#delete-modal-<?= $article->id;?>" data-toggle="modal" href="#">
                                <i class="fa fa-trash fa-fw"></i>
                            </a>
                        </td>
                    </tr>
                    <!--Delete Model--> 
                    <div class="modal fade" id="delete-modal-<?= $article->id;?>" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Delete Article</h4>
                                </div>
                                <div class="modal-body">
                                    <p>Are you sure you want to delete the Article ?</p>
                                </div>
                                <div class="modal-footer">
                                    <button onlick="#" class="gener-delete"><a href="<?php echo asset('delete_article/'.$article->id); ?>">Confirm</a></button>
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Delete Model -->
                    <?php } ?>
                <?php } ?>
            </tbody>
        </table>
    </div>

</section>
<?php include resource_path('views/admin/includes/footer.php'); ?>
</body>
</html>