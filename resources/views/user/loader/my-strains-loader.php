<?php foreach($strains as $key => $values){ ?>
    <?php if($last_month != $key){ ?>
        <div class="date-main-act">
            <i class="fa fa-calendar"></i>
            <span><?= $key ?></span>
        </div>
    <?php } ?>
<?php foreach ($values as $strain) { ?>
    <li>
        <input type="hidden" class="month_year" value="<?= $strain->month_year ?>">
        <div class="q-txt">
            <div class="q-text-a">
                <a href="<?php echo asset('user-strain-detail?strain_id='.$strain->strain_id.'&user_strain_id='.$strain->id); ?>">
                    <span><img src="<?php echo asset('userassets/images/act-s.png') ?>" alt="Icon"></span>
                    <div class="my_answer">
                        <?php echo $strain->getStrain->title; ?>
                        <!--<em class="key Hybrid">H</em>-->
                        <em class="key <?= $strain->getStrain->getType->title; ?>"><?= substr($strain->getStrain->getType->title, 0, 1); ?></em>
                        <span class="hows-time"><?php echo timeago($strain->created_at); ?></span>
                    </div>
                </a>
            </div>
                <div class="head-ques" target="_blank">
                    <?php echo $strain->description; ?>
                    <span class="descrip"><?php echo $strain->note; ?></span>
                </div>
            <span class="how-time">
                <a href="<?php echo asset('edit-user-strain/'.$strain->id)?>">
                    <i class="fa fa-pencil" aria-hidden="true"></i> Edit
                </a>
                <a href="#" data-toggle="modal" data-target="#delete_strain<?php echo $strain->id;?>">
                    <i class="fa fa-trash-o" aria-hidden="true"></i> Delete
                </a>
            </span>
        </div>
    </li>
    <!-- Modal -->
    <div class="modal fade" id="delete_strain<?php echo $strain->id;?>" role="dialog">
        <div class="modal-dialog">
          <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Delete Strain </h4>
                </div>
                <div class="modal-body">
                    <p>Are you sure to delete this Strain: <?php echo $strain->getStrain->title; ?></p>
                </div>
                <div class="modal-footer">
                    <a href="<?php echo asset('delete-user-strain/'.$strain->id); ?>" type="button" class="btn-heal">yes</a>
                    <button data-dismiss="modal" type="button" class="btn-heal">No</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal End-->
<?php } }?>