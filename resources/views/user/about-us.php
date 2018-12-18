<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Healing Budz Home</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" type="image/png" href="<?php echo asset('userassets/images/favicon.jpg') ?>"/>
        <link rel="stylesheet" type="text/css" href="<?php echo asset('userassets/css/home.css') ?>">
    </head>
    <body class="term-pri">
        <?php include 'includes/static_header.php'; ?>
        <main>
            <div id="wrapper">
                <article id="content">
                    <div class="padding-div">
                        <div class="privacy-holder">
                            <h1>About Us</h1>
                            <?= $data->description; ?>
<!--                            <p>Healing Budz is a social healing platform created with the purpose of spreading love and healing through sharing of the knowledge of cannabis’s healing powers.</p>
                               <p>Our platform is built on the foundations of the mantra “Sharing is Caring” and we echo this in all of our activities. </p>
                                <p>We have developed an app and a web based platform that creates a welcoming environment for people and their loved ones dealing with traumatic conditions that have defied conventional medicine. Our platform offers “Budz” the opportunity to share their experience using cannabis as a therapeutic alternative to healing for conditions such as Cancer, Multiple Sclerosis (MS), Crohn’s disease, Epilepsy, Severe Seizures; Druvet Syndrome, Anxiety, Depression, Fibromyalgia, Rheumatoid  Arthritis and lots more.</p>
                                <p>Healing Budz is a passion borne out of a personal experience and the desire to help people get better. We connect you with people that have years of first-hand knowledge on how to use the amazing plant Cannabis to heal.</p>-->

                        </div>
                    </div>
                </article>
            </div>
        </main>
        <?php include 'includes/static_footer.php'; ?>


    </body>
</html>