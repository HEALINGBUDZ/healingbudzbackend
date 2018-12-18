<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Healing Budz Home</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" type="image/png" href="<?php echo asset('userassets/images/favicon.jpg') ?>"/>
        <link rel="stylesheet" type="text/css" href="<?php echo asset('userassets/css/home.css') ?>">
    </head>
    <body>
        <?php include 'includes/static_header.php'; ?>

        <div class="privacy_container">
            <div class="header">
                <h1 style="margin-bottom: 0px;">HEALING BUDZ</h1>
                <h4 style="color: #f4c62c; margin-top: 5px;">PRIVACY POLICY</h4>
            </div>
            <div class="policy-body">
                <?= $data->description; ?>
            </div>
        </div>

        <?php include 'includes/static_footer.php'; ?>
    </body>
</html>