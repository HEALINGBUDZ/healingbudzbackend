<?php /* <aside class="bottom-sidebar">
    <ul class="list-none mobile-fixed">
        <li>
            <a href="<?php echo asset('questions'); ?>">
                <img src="<?php echo asset('userassets/images/side-icon12.svg2.svg') ?>" alt="Icon">
                <span>Q&amp;A</span>
            </a>
        </li>
        <li>
            <a href="<?php echo asset('groups'); ?>">
                <img src="<?php echo asset('userassets/images/group-icon.png') ?>" alt="Icon">
                <span>Groups</span>
            </a>
        </li>
        <li>
            <a href="<?php echo asset('journals'); ?>">
                <img src="<?php echo asset('userassets/images/file-icon.png') ?>" alt="Icon">       
                <span>Journals</span>
            </a>
        </li>
        <li>
            <a href="<?php echo asset('strains'); ?>">
                <img src="<?php echo asset('userassets/images/icon03.svg') ?>" alt="Icon">
                <span>Strains</span>
            </a>
        </li>
        <li>
            <a href="<?php echo asset('budz-map'); ?>">
                <img src="<?php echo asset('userassets/images/folded-newspaper.svg') ?>" alt="Icon">
                <span>Bud Maps</span>
            </a>
        </li>
    </ul>
</aside>
*/ ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="<?php echo asset('userassets/js/switchery.min.js') ?>" type="text/javascript"></script>
<script src="<?php echo asset('userassets/js/stars.min.js') ?>" type="text/javascript"></script>
<script src="<?php echo asset('userassets/js/bootstrap.min.js') ?>" type="text/javascript"></script>
<script src="<?php echo asset('userassets/js/custom.js') ?>" type="text/javascript"></script>
<script src="<?php echo asset('public/js/share.js') ?>"></script>
<script>
    $(function () {
        $("#slider").slider();
    });
    $(document).ready(function () {
        var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
        elems.forEach(function (html) {
            var switchery = new Switchery(html, {color: 'rgba(255,255,255,0.5)', secondaryColor: '#bcbcbc', jackColor: '#fff'});
        });
        $('.filter-open').click(function () {
            $('.filter-ul').slideToggle();
            $(this).toggleClass('fil-close');
        });
    });
</script>
<script>
    $(".rating-stars").stars({color: '#e070e0',
        click: function (i) {
            alert("Star " + i + " selected.");
        }});
//    $(".demo").stars({text: ["Bad", "Not so bad", "hmmm", "Good", "Perfect"]});

//    $(".more-stars").stars({stars: 20});
//    $(".font-size").stars();
//    $(".value-set").stars({value: 4});
//    $(".green-color").stars({color: '#73AD21'});
//    $(".icon-change").stars({
//        emptyIcon: 'fa-thumbs-o-up',
//        filledIcon: 'fa-thumbs-up'
//    });
//    $(".text").stars({
//        text: ["1 star", "2 star", "3 star", "4 star", "5 star"]
//    });
//    $(".click-callback").stars({
//        click: function (i) {
//            alert("Star " + i + " selected.");
//        }
//    });
</script>
