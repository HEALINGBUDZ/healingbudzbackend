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
                            <h1>Business Services</h1>
                            <?= $data->description; ?>
<!--                            <p>Advertising or promoting your business, company or idea on our platform gives you an unparalleled exposure to the customers that truly matter. We give you the power to establish your brand presence and take the market share that you truly deserve.</p>
                                <p> We have created ample avenues for businesses looking to take advantage of the rich market our platform offers. We are the first and only social healing platform dedicated to sharing the healing testimonies of cannabis.</p>
                                <p> We are bringing people together, providing a platform for support, information and healing for millions across the country using cannabis.</p>
                                <p> We are at the prime spot in history, and the emerging cannabis industry supported by millions across the country, puts us at a vantage position to tell your story. </p>
                                <p> It’s your choice… You can become one of our success stories.</p>
                                 <p>There are several ways to get involved:
                            </p>
                            <h2>Ad listings</h2><p>we offer free and paid ad listings in-app and on web. The ad listings gives your brand an unparalleled exposure in chat forums and threads.</p>
                            <h2>Static Banners </h2><p>Make the most of premium ad exposure by subscribing to our static banners. Our static banners are strategically positioned throughout the platform to give your business the right view.</p>
                            <h2>Video </h2><p>Pictures they say tell a thousand tales, imagine the power of videos. We offer video advertising and ad placements for business throughout the platform.</p>-->

                        </div>
                    </div>
                </article>
            </div>
        </main>
       <?php include 'includes/static_footer.php'; ?>
    </body>
</html>