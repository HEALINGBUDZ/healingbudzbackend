<!DOCTYPE html>
<html lang="en">
    <?php include('includes/top.php'); ?>
    <body>
        <div id="wrapper">
            <?php include('includes/sidebar.php'); ?>
            <article id="content">
                <?php include('includes/header.php'); ?>
                <div class="padding-div">
                    <ul class="bread-crumbs list-none">
                        <li><a href="<?php echo asset('/'); ?>">Home</a></li>
                    </ul>
                    <div class="search-sec">
                        <form action="#">
                            <fieldset>
                                <div  class="ui-widget">
                                    <input id="searchquestion" type="search" placeholder="Type your question" id="tags">
                                </div>
                            </fieldset>
                        </form>
                        <div class="suggestions">
                            <header class="header">
                                <strong>BUDZ Q’s</strong>
                                <strong>BUDZ A’s</strong>
                            </header>
                            <ul class="list-none" id="appenda_complete">
<!--                                <li>
                                    <span><a href="#">20</a></span>
                                    <p><strong>Q :</strong><a href="questions.html">Should I smoke it?</a></p>
                                </li>
                                <li>
                                    <span><a href="#">11</a></span>
                                    <p><strong>Q :</strong><a href="questions.html">Should I bake it at home?</a></p>
                                </li>
                                <li>
                                    <span><a href="#">17</a></span>
                                    <p><strong>Q :</strong><a href="questions.html">Should I use it in an infuser?</a></p>
                                </li>
                                <li>
                                    <span><a href="#">102</a></span>
                                    <p><strong>Q :</strong><a href="questions.html">Should I eat it with other greens?</a></p>
                                </li>-->
                            </ul>
                            <footer class="footer">
                                <span><a href="#" style="cursor: text">Didn’t find your Q?</a></span>
                                <span><a href="<?php echo asset('ask-questions');?>" class="btn">ASK YOUR BUDZ</a></span>
                            </footer>
                        </div>
                    </div>
                </div>
                <section class="articles">
                    <article class="article">
                        <div class="img-holder">
                            <img src="<?php echo asset('userassets/images/img1.jpg') ?>" alt="Image" class="img-responsive">
                        </div>
                        <div class="caption">
                            <h4>Healing Buzz:</h4>
                            <div class="txt">
                                <strong class="title">Lung Cancer Survivors</strong>
                                <p>Meet the women who beat lung cancer with Cannabis Oil</p>
                                <span>
                                    <a href="#" class="more"><i class="fa fa-angle-right" aria-hidden="true"></i> READ BUZZ</a>
                                    <em>Provided by: <a href="#">medicaljane.com</a></em>
                                </span>
                            </div>
                        </div>
                    </article>
                
                    <article class="article">
                        <div class="img-holder">
                        </div>
                        <div class="caption">
                            <h4>Healing Buzz:</h4>
                            <div class="txt">
                                <strong class="title">Lung Cancer Survivors</strong>
                                <p>Meet the women who beat lung cancer with Cannabis Oil</p>
                                <span>
                                    <a href="#" class="more">> READ MORE</a>
                                    <em>Provided by: <a href="#">medicaljane.com</a></em>
                                </span>
                            </div>
                        </div>
                    </article>
                </section>
            </article>
        </div>
        <?php include('includes/footer.php'); ?>
       </body>
    <?php $allquestions =  json_encode($questions)?>
    <script>
    $(function () {
        var result  = <?php echo $allquestions; ?>;
                 var allquestions = [];
                $.each(result, function (i, item) {
                    allquestions.push(item.question +"question_id" + item.get_answers_count + "question_id"+item.id);
                });
                $("#searchquestion").autocomplete({
                    source: function (request, response) {
                        var results = $.ui.autocomplete.filter(allquestions, request.term);
                       
                        results=results.slice(0, 10);
                       
                        var htmlli='';
                        if(results.length){
                         $.each(results, function (i, item) {
                             var explode_result = item.split('question_id');
                             htmlli+='<a href=question/'+explode_result[2]+'><li><span>'+explode_result[1]+'</span><p><strong>Q :</strong>'+explode_result[0]+'</p></li></a>';
                });
                }else{
                htmlli+='<li><span></span><p><strong>Sorry No Record Found</strong></p></li>';
               
                }
                      $('#appenda_complete').html(htmlli);
                    },
                    appendTo: "#appenda_complete"
                });
                
//                        .data( "ui-autocomplete" )._renderItem = function( ul, item ) {
//  return $( "<li>" )
//    .data( "ui-autocomplete-item", allquestions.question )
//    .append( "<a>" + allquestions.question + " <br> " + allquestions.question + "</a>" )
//    .appendTo( "#appenda_complete");
//};
            

    });
    </script>
</html>