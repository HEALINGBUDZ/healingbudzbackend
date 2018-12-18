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
                   <h1>Who can Join</h1>
                   <?= $data->description; ?>
<!--                   <p>The app is open to all. All are welcome; patients, care-givers, cannabis enthusiast, activist, support individuals, businesses and anyone in particular curious or having enough information to share with the community.</p>
<p>The app environment offers democratized information for individuals seeking, and a reward system for consistent contributors who offer their wealth of information and direction in respect to how cannabis has helped them or a loved one heal
.</p>-->

                </div>
                </div>
            </article>
        </div>
    </main>
    <?php include 'includes/static_footer.php'; ?>
</body>
</html>