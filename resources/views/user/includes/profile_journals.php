<div id="proJournals" class="tab-pane fade">
    <div class="listing-area">
        <div class="journal-set">
            <a href="#" class="journal-opener">My Journals</a>
            <ul class="journals list-none" style="display: block;">
                <?php foreach ($user->getJournal as $journal){ ?>
                <li><a href="<?php echo asset('journal-details/'.$journal->id);?>"><?php echo $journal->title; ?></a></li>
                <?php } ?>
            </ul>
        </div>
        <div class="journal-set">
            <a href="#" class="journal-opener">Journals | Follow</a>
            <ul class="journals list-none">
                <?php foreach ($user->getJornalFollowers as $journal_follow){ ?>
                <li><a href="<?php echo asset('journal-details/'.$journal_follow->getJournal->id);?>" class="white"><?php echo $journal_follow->getJournal->title;?></a></li>
                <?php } ?>
            </ul>
        </div>
    </div>
</div>