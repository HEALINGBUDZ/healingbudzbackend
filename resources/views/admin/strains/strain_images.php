<!DOCTYPE html>
<html lang="en">
<?php include resource_path('views/admin/includes/head.php'); ?>
<body>
<?php include resource_path('views/admin/includes/header.php'); ?>
<?php include resource_path('views/admin/includes/sidebar.php'); ?>
<section class="content lifeContent">

    <?php if(\Session::has('success')) { ?>
        <h4 class="alert alert-success fade in">
            <?php echo \Session::get('success') ?>
        </h4>
    <?php } ?>
    <a data-target="#add-modal" data-toggle="modal" class="add_s" href="javascript:void(0)">Add New Images</a>
    <a class="add_s" href="<?php echo asset('strains'); ?>">Back</a>

    <div class="contentPd">
        <h2 class="mainHEading">Strain Images For <?= $strain->title?></h2>
        <table id="tableStyle" class="display" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>Sr.</th>
                <th>Image</th>
                <th>Approve Status</th>
                <th>Actions</th>
                <th>Main Image</th>
            </tr>
            </thead>
            <tbody>
            <?php if(isset($strain_images)){ ?>
                <?php 
                $i = 1;
                foreach($strain_images as $strain_image){ ?>
                    <tr>
                        <td><?php echo $i; $i++; ?></td>
                        <td><img src="<?php echo asset('/public/images'. $strain_image->image_path); ?>" style="width: 100px"></td>
                        <td>
                            <?php if($strain_image->is_approved == 0){ ?>
                                <a href="<?php echo asset('/strain_image_approve_status/1/'. $strain_image->id); ?>">Disapproved</a>
                            
                            <?php } elseif($strain_image->is_approved == 1){ ?>
                                <a href="<?php echo asset('/strain_image_approve_status/0/'. $strain_image->id); ?>">Approved</a>
                            <?php } ?>
                        </td>
                        <td><a data-target="#modal-<?= $strain_image->id ?>" data-toggle="modal" href="#"><i class="fa fa-trash fa-fw"></i></a></td>
                        <td>
                            <?php if($strain_image->is_main == 0) { ?>
                                <a href="<?php echo asset('/main_image/'.$strain_image->strain_id.'/'.$strain_image->id)?>">Make Main Image</a>
                            <?php }else{ ?>
                                Main Image
                            <?php } ?>
                        </td>
                    </tr>
                    <div class="modal fade" id="modal-<?= $strain_image->id ?>" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Delete Image</h4>
                                </div>
                                <div class="modal-body">
                                    <p>Are you sure you want to delete the image ?</p>
                                </div>
                                <div class="modal-footer form-adjust-admin">
                                    <form style="" method="get" action="<?= asset('delete_strain_image_reason/' . $strain_image->id) ?>">
                                                <div class="form-inner-space">
                                                    <label>Reason</label> 
                                                    <input name="id" type="hidden" value="<?= $strain_image->id ?>" >  
                                                    <input type="text" name="message" required="" >  
                                                </div>
                                                <button type="submit" onlick="#" class="gener-delete" value="Confirm">Confirm </button>
                                                
                                            </form>
                                    <!--<button onlick="#"><a href="<?php echo asset('/delete_strain_image/'.$strain_image->id)?>"> Confirm</a></button>-->
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
            
                <?php } ?>
            <?php } ?>
            </tbody>
            <div class="modal fade" id="add-modal" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Add Image</h4>
                        </div>
                        <form style="padding: 0px" action="<?php echo asset('add_strain_image') ?>" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                            <input type="hidden" name="id" value="<?php echo $id; ?>">
                            <div class="modal-body">
                                <label>Image</label>
                                <input required="" multiple="" type="file" name="file[]" accept="image/*">
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-default gener-delete">Submit</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </table>
    </div>
     
</section>
<?php include resource_path('views/admin/includes/footer.php'); ?>
</body>
</html>


