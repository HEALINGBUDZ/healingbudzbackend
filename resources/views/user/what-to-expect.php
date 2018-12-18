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
                   <h1>What to Expect</h1>
                   <?= $data->description; ?>
<!--                   <p>Knowledge shared freely and first-hand information on how to use cannabis as a therapeutic medication to find healing from Cancer, Multiple Sclerosis (MS), Crohn’s disease, Arthritis, Epilepsy, Severe Seizures; Druvet Syndrome, Anxiety, Depression, Lennox-Gastaut syndrome, and lots more.</p>
<p>Information on the latest cannabis news, question and answer, and unlimited personal testimonies on the healing potency of cannabis, how to apply it to your situation and the benefits it holds. You will also find information on new strains and their health benefits, a geo-location guide to medical cannabis “Adz” for dispensaries, physicians, shops, quality cannabis products, services and lots more. We also built a reward system for consistent quality performers.
</p>-->

                </div>
                </div>
            </article>
        </div>
    </main>
    <?php include 'includes/static_footer.php'; ?>
</body>
</html>