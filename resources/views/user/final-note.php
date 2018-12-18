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
                   <h1>Final Note</h1>
                   <?= $data->description; ?>
<!--                   <p>Healing Budz is a community unlike Facebook or Instagram. It is a niche platform developed solely for the purposes of learning how to heal with cannabis.</p>
<p>Our platform will connect people for the purpose of healing, but we feel our users will create lifelong relationships with other "Budz" in the community. After all, we’re just Budz helping Budz.
</p>-->

                </div>
                </div>
            </article>
        </div>
    </main>
    <?php include 'includes/static_footer.php'; ?>
</body>
</html>