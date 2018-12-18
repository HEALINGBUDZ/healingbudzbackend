
<form action="<?php echo asset('search-question');?>" class="search-form" method="get">
    <input name="q" type="search" placeholder="Search" onkeyup="showSpan()" id="qsearch">
    <input id="ser" name="ser" type="submit" value="Submit">
    <span id="searchSpan" style="display: none" onclick="removeText()">x</span>
 </form>
<script>
    function showSpan(){
        if($('#qsearch').val()){
        $('#searchSpan').show();
        $('#ser').hide();
    }else{
        $('#ser').show();
        $('#searchSpan').hide();
    }}
    function removeText(){
       $('#qsearch').val(''); 
       $('#ser').show();
        $('#searchSpan').hide();
    }
    
</script>