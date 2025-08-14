<head>
    <meta charset="UTF-8">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="theme-color" content="#ffc107">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo BASE_URL_APP ?>assets/css/reset.css">
    <link rel="shortcut icon" href="<?php echo BASE_URL_APP ?>assets/img/faviconRRGARAGE.svg" type="image/x-icon">
    <link rel="stylesheet" href="<?php echo BASE_URL_APP ?>assets/css/style.css">
    <link rel="manifest" href="manifest.json">

    <link rel="stylesheet" href="<?php echo BASE_URL_APP; ?>assets/css/style.css?v=<?= time() ?>">
    <!-- CSS do GLightbox -->


    <title>rrgarageapp</title>
    <!-- Para o carrossel da pagina inicial -->
    <?php if (!empty($extra_head)) echo $extra_head; ?>
</head>