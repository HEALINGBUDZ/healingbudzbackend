<?php foreach ($journals as $journal) { ?>
    <li>
        <div class="right">
            <span><?php echo $journal->events_count; ?></span>
            <span <?php if ($journal->is_public == 1) echo 'class="active"'; ?>>
                <i class="fa fa-eye-slash" aria-hidden="true"></i>
            </span>
            <span class="dot-options">
                <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                <div class="sort-drop">
                    <div class="sort-item active">
                        <a href="#edit-journal<?php echo $journal->id; ?>" class="btn-popup"><i class="fa fa-pencil" aria-hidden="true"></i> Edit Journal</a>
                    </div>
                    <div class="sort-item">
                        <a href="#" data-toggle="modal" data-target="#delete-journal<?php echo $journal->id; ?>"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete Journal</a>
                    </div>
                </div>
            </span>
        </div>
        <a href="<?php echo asset('journal-details/' . $journal->id); ?>"><strong><?php echo $journal->title; ?></strong></a>
    </li>
    <!-- Modal Add Journal -->
    <div id="edit-journal<?php echo $journal->id; ?>" class="popup">
        <div class="popup-holder">
            <div class="popup-area">
                <div class="text">
                    <header class="header">
                        <strong>EDIT JOURNAL</strong>
                    </header>
                    <div class="padding">
                        <form action="<?php echo asset('update-journal'); ?>" method="post" class="add_journal-form">
                            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                            <input type="hidden" name="journal_id" value="<?php echo $journal->id; ?>">
                            <fieldset>
                                <input type="text" placeholder="Journal Title" name="title" value="<?php echo $journal->title; ?>" required>
                                <div class="fields add">
                                    <input type="radio" id="private" name="is_public" <?php if ($journal->is_public == 0) echo 'checked'; ?> value="0">
                                    <label for="private">Private</label>
                                    <input type="radio" id="public" name="is_public" <?php if ($journal->is_public == 1) echo 'checked'; ?> value="1"> 
                                    <label for="public">Public</label>
                                </div>
                                <input type="submit" value="Submit">
                            </fieldset>
                        </form>
                    </div>
                    <a href="#" class="btn-close">Close</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal End -->
    <!-- Modal Delete Journal -->
    <div class="modal fade" id="delete-journal<?php echo $journal->id; ?>" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Delete Journal </h4>
                </div>
                <div class="modal-body">
                    <p>Are you sure to delete this Journal: <?php echo $journal->title; ?></p>
                </div>
                <div class="modal-footer">
                    <a href="<?php echo asset('delete-journal/' . $journal->id); ?>" type="button" class="btn-heal">yes</a>
                    <button data-dismiss="modal" type="button" class="btn-heal">No</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal End-->
<?php } ?>