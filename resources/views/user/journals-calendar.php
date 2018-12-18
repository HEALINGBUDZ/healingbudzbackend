<!DOCTYPE html>
<html lang="en">
    <?php include('includes/top-new.php'); ?>
    <body class="strains-page">
        <div id="wrapper">
            <?php include('includes/sidebar.php'); ?>
            <article id="content">
                <?php include('includes/header.php'); ?>
                <div class="padding-div">
                    <header class="intro-header no-bg">
                        <h1 class="custom-heading white">MY JOURNAL</h1>
                    </header>
                    <?php include('includes/journal-info.php'); ?>
                   <!--<div id="datepicker" class="full-calendar"></div>-->
                    <?php echo $calendar->calendar(); ?>
                    <?php echo $calendar->script(); ?>
                </div>
            </article>
        </div>
        <?php include('includes/footer-new.php'); ?>
        <!--<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>-->
        <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.js"></script>
    </body>
    <script>
//        $(document).ready(function() {
//            $('#calendar').fullCalendar({
//                events: [
//                    // my event data
//                ],
//                eventColor: '#378006'
//            });
//        });
    </script>
</html>