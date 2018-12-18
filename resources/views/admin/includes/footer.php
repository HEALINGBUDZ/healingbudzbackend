<script src="<?php echo url('/');?>/adminassets/js/jquery.min.js"></script>
<script src="<?php echo url('/'); ?>/adminassets/js/bootstrap.min.js"></script>
<script src="<?php echo url('/'); ?>/adminassets/js/jquery.dataTables.js"></script>

<script src="<?php echo asset('/'); ?>/adminassets/js/jquery.mCustomScrollbar.concat.min.js"></script>
<script src="<?php echo url('/'); ?>/adminassets/js/mian.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script src="https://jqueryvalidation.org/files/dist/jquery.validate.min.js"></script>
<script src="https://jqueryvalidation.org/files/dist/additional-methods.min.js"></script>


<script type="text/javascript" src="<?php echo url('/'); ?>/adminassets/js/multi_select.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
        /**********Sidebar Scrol in admin panel********/
		var parent , child ,c, yOffset , yOffset_parent , total_offset , href ,home1;
		href = $(location).attr('href');
    	home1 = href.replace(base_url+'/','')
    	parent = document.getElementById('leftmenuinnerinner'); 
		child = document.getElementById(home1);
		//console.log(child);
		yOffset = child.offsetTop;
		yOffset_parent = parent.offsetTop;
        total_offset = yOffset + yOffset_parent;
        if (total_offset > 0)
        $(child).mCustomScrollbar("scrollTo",child);
    });
</script>

