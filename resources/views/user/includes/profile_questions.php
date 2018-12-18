  <div id="proQuestions" class="tab-pane fade in active">
                                        <div class="listing-area">
                                            <div class="journal-set qa-view">
                                                <a href="#" class="journal-opener blue">My Questions</a>
                                                <ul class="journals list-none">
                                                    <?php foreach ($user->getQuestion as $question){ 
                                                   
                                                        ?>
                                                    <li>
                                                        <span class="how-time"><?php echo timeago($question->created_at);?></span>
                                                        <div class="q-txt">
                                                            <a href="<?php echo asset('get-question-answers/'.$question->id) ?>">Q: <?php echo $question->question;?></a>
                                                            <a href="<?php echo asset('get-question-answers/'.$question->id) ?>" class="answer-link"><?php echo count($question->getAnswers);?> ANSWERS</a>
                                                        </div>
                                                    </li>
                                                    <?php } ?>
                                                </ul>
                                            </div>
                                            <div class="journal-set qa-view">
                                                <a href="#" class="journal-opener blue">My Answers</a>
                                                <ul class="journals list-none">
                                                    <?php foreach ($user->getAnswers as $answer){ 

                                                        ?>
                                                    <li>
                                                        <span class="how-time"><?php echo timeago($answer->created_at) ?></span>
                                                        <div class="q-txt">
                                                            <a href="#" class="gray">Q: <?php echo $answer->getAnswerQuestion->question; ?></a>
                                                            <a href="#">A: <?php echo $answer->answer ?></a>
                                                        </div>
                                                    </li>
                                                    <?php } ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>