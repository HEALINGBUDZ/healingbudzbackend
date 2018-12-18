<?php foreach($answers as $key => $values){ ?>
    <?php if($last_month != $key){ ?>
        <div class="date-main-act">
            <i class="fa fa-calendar"></i>
            <span><?= $key ?></span>
        </div>
    <?php } ?>
<?php foreach ($values as $answer) { ?>
    <li>
        <input type="hidden" class="month_year" value="<?= $answer->month_year ?>">
        <div class="q-txt">
            <div class="q-text-a">
                <a href="<?php echo asset('get-question-answers/'.$answer->question_id); ?>">
                    <span><img src="<?php echo asset('userassets/images/act-a.png') ?>" alt="Icon" class="small-q"></span>
                    <div class="my_answer">
                        You answered on a question
                        <span class="hows-time"><?php echo timeago($answer->created_at); ?></span>
                    </div>
                </a>
            </div>
            <div class="head-ques">
                <!--<a href="<?php // echo asset('get-question-answers/'.$answer->question_id); ?>" class="head-ques">-->
                <!--<div class="head-ques-a">-->
                <div class="">
                    <i class="fa fa-external-link"></i>
                    <span class="add">Q:</span><?php echo $answer->getAnswerQuestion->question; ?>
                    <div class="icons-a-blues">
                        <span>A:</span>
                        <?php echo $answer->answer; ?>
                    </div>
                    <?php if(count($answer->attachments) > 0){ ?>
                    <div class="att-link-blue">
                        <i class="fa fa-link"></i> Attachment
                    </div>
                    <?php } ?>
                </div>
            </div>


            <!--<span class="how-time"><span><?php // echo timeago($answer->created_at); ?></span>-->
            <span class="how-time">
                <?php // if(count($answer->AnswerLike) <= 0 && count($answer->Flag) <= 0){ ?>
                    <a href="<?php echo asset('edit-answer/'.$answer->id)?>">
                        <i class="fa fa-pencil" aria-hidden="true"></i>
                        Edit
                    </a>
                <?php // } ?>
                <a href="#" data-toggle="modal" data-target="#delete_answer<?php echo $answer->id;?>">
                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                    Delete
                </a>
                <a href="<?php echo asset('get-question-answers/'.$answer->question_id); ?>" class="answer-link">
                    <span><i class="fa fa-eye"></i></span>View Answer
                </a>
            </span>
        </div>

    </li>
    <!-- Modal -->
    <div class="modal fade" id="delete_answer<?php echo $answer->id;?>" role="dialog">
        <div class="modal-dialog">
          <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Delete Answer </h4>
                </div>
                <div class="modal-body">
                    <p>Are you sure to delete this Answer: <?php echo $answer->answer; ?></p>
                </div>
                <div class="modal-footer">
                    <a href="<?php echo asset('delete-answer/'.$answer->id); ?>" type="button" class="btn-heal">yes</a>
                    <button data-dismiss="modal" type="button" class="btn-heal">No</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal End-->
<?php }} ?>