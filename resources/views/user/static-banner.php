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
                   <h1>STATIC BANNER & VIDEO COMMERCIAL AD PLACEMENT FOR YOUR BUSINESS</h1>
                   <?= $data->description; ?>
                   <!--<p>To have one of our Marketing Budz send you more information, click the link below or send us an email at <a href="mailto:info@healingbudz.com"> info@healingbudz.com </a> and we will get back to you.</p>-->

                </div>
                </div>
            </article>
        </div>
    </main>
    <?php include 'includes/static_footer.php'; ?>
</body>
</html>