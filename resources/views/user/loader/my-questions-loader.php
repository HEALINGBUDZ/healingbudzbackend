<?php foreach($questions as $key => $values){ ?>
    <?php if($last_month != $key){ ?>
        <div class="date-main-act">
            <i class="fa fa-calendar"></i>
            <span><?= $key ?></span>
        </div>
    <?php } ?>
<?php foreach ($values as $question) { ?>
    <li>
        <input type="hidden" class="month_year" value="<?= $question->month_year ?>">
        <div class="q-txt">
            <div class="q-text-a">
                <a href="<?php echo asset('get-question-answers/' . $question->id); ?>">
                    <span><img src="<?php echo asset('userassets/images/act-q.png') ?>" alt="User Image" class="small-q"></span>
                    <div class="my_answer">You asked a question.
                    <span class="hows-time"><?php echo timeago($question->created_at); ?></span>
                    </div>
                </a>
            </div>
            <div class="head-ques">
                <div class="my_qs">
                    <span class="add">Q:</span>
                    <div class="my_qs_txt">
                        <?php echo $question->question; ?>
                        <span class="descrip"><?php echo $question->description; ?></span>
                    </div>
                </div>
            </div>
            <span class="how-time">
                <!--<span><?php // echo timeago($question->created_at); ?></span>-->
                <?php if ($question->getAnswers->count() == 0) { ?>
                    <a href="<?php echo asset('update-question/' . $question->id); ?>" ><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>
                <?php } ?>
                <a href="#" data-toggle="modal" data-target="#delete_question<?php echo $question->id; ?>"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</a>
                <a href="<?php echo asset('get-question-answers/' . $question->id); ?>" class="answer-link">
                    <span><i class="fa fa-exchange"></i> <?php echo $question->getAnswers->count(); ?></span>ANSWERS
                </a>
            </span>
        </div>
    </li>

<!--<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#delete_question<?php echo $question->id; ?>">Open Modal</button>-->

    <!-- Modal -->
    <div class="modal fade" id="delete_question<?php echo $question->id; ?>" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Delete Question </h4>
                </div>
                <div class="modal-body">
                    <p>Are you sure to delete this question <?php echo $question->question; ?></p>
                </div>
                <div class="modal-footer">
                    <a href="<?php echo asset('delete-question/' . $question->id); ?>" type="button" class="btn-heal">yes</a>
                    <button data-dismiss="modal" type="button" class="btn-heal">No</button>
                </div>
            </div>

        </div>
    </div>
    <!-- Modal End-->
<?php } }?>