<?php 

 $journals_count = journalsCount($current_id);
 $tags_count = journalsTagCount($current_id);
 $entries_count = todayJournalsEntries($current_id);
 
?>
<div class="j-header">
    <div class="img-holder"><img src="<?php echo $current_photo; ?>" alt="icons" /></div>
    <dl class="list-right list-none">
        <dt>Total Journals: </dt>
        <dd><i class="fa fa-address-book" aria-hidden="true"></i> <?php echo $journals_count;?></dd>
        <dt>Total Tags: </dt>
        <dd><i class="fa fa-tags" aria-hidden="true"></i> <?php echo $tags_count;?></dd>
        <dt>Total Entries Today: </dt>
        <dd><i class="fa fa-pencil" aria-hidden="true"></i> <?php echo $entries_count;?></dd>
    </dl>
</div>
<ul class="j-pages list-none">
   <li <?php if($title == 'Journal Calender') echo 'class="active"'; ?>>
       <a href="<?php echo asset('journals-calendar');?>"><i class="fa fa-calendar" aria-hidden="true"></i><span>Mood Calendar</span></a>
   </li>
   <li <?php if($title == 'My Journals') echo 'class="active"'; ?>>
       <a href="<?php echo asset('my-journals');?>"><i class="fa fa-address-book-o" aria-hidden="true"></i><span>Journals</span></a>
   </li>
   <li <?php if($title == 'Journal Tags') echo 'class="active"'; ?>>
       <a href="<?php echo asset('journal-tags');?>"><i class="fa fa-tags" aria-hidden="true"></i><span>Tags</span></a>
   </li>
</ul>