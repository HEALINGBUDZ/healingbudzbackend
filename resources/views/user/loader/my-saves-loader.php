<?php foreach($mysaves as $key => $values){ ?>
    <?php if($last_month != $key){ ?>
        <div class="date-main-act">
            <i class="fa fa-calendar"></i>
            <span><?= $key ?></span>
        </div>
    <?php } ?>
<?php foreach ($values as $mysave) { ?>
    <li class="">             
        <input type="hidden" class="month_year" value="<?= $mysave->month_year ?>">
        <div class="q-txt">
            <div class="q-text-a">
                <?php if($mysave->type_id == 7) { 
                    $message = 'You save a strain';
                    $url= asset('strain-details/'.$mysave->type_sub_id);
                    $image_url = asset('userassets/images/act-s.png');
                  } ?>
                <?php if($mysave->type_id == 4) { 
                    $message = 'You save a question';
                    $url= asset('get-question-answers/'.$mysave->type_sub_id);
                    $image_url = asset('userassets/images/act-q.png'); 

                } ?>
                <?php if($mysave->type_id == 8) {
                    $message = 'You save Budz Adz';
                    $subuser= getSubUser($mysave->type_sub_id);
                    if($subuser) {
                        $url= asset('get-budz?business_id='.$mysave->type_sub_id.'&business_type_id='.$subuser->business_type_id);
                        $image_url = asset('userassets/images/folded-newspaper.svg'); 
                    }
                    else{
                      $url='';
                    }
                } ?>
                <?php if($mysave->type_id == 10) {
                    $message = 'You save Seach';
                    $subuser= getSubUser($mysave->type_sub_id);

                        $image_url = asset('userassets/images/act-s.png');
                        $filter = json_decode($mysave->description);
                        $url=  asset('strains-filter'.$filter->search_data);

                } ?>
                <?php if($mysave->type_id == 11) {
                    $message = 'You save special';
                    $subuser= getSubUser($mysave->type_sub_id);

                        $image_url = asset('userassets/images/speaker-icon1.png');

                        $url=  asset('get-budz?'.$mysave->description);
                } ?>

                <a href="<?= $url ?>" target="_blank">
                    <span>
                        <img src="<?php echo $image_url; ?>" alt="Icon" class="small-q">
                    </span>
                    <div class="my_answer">
                        <?= $message ?>
                        <span class="hows-time"><?= timeago($mysave->created_at); ?></span>
                    </div>
                </a>
            </div>
                <div class="head-ques" target="_blank">
                    <?= $mysave->title; ?>
                </div>
            <span class="how-time">
                <a href="#" data-toggle="modal" data-target="#delete-saves<?= $mysave->id?>">
                    <i class="fa fa-minus-circle" aria-hidden="true"></i> Unsave
                </a>
            </span>
        </div>
    </li>
    <!-- Modal -->
    <div class="modal fade" id="delete-saves<?= $mysave->id?>" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Delete Saves</h4>
                </div>
                <div class="modal-body">
                    <p>Are you sure to delete this Saves </p>
                </div>
                <div class="modal-footer">
                    <a href="<?php echo asset('delete-mysave/'.$mysave->id);?>" type="button" class="btn-heal">yes</a>
                    <button data-dismiss="modal" type="button" class="btn-heal">No</button>
                </div>
            </div>

        </div>
    </div>
    <!-- Modal End-->
<?php } }?>