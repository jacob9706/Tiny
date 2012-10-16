<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title><?php echo (empty($title) ? "" : $title); ?></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">

        <?php echo $html->create_link('static/css/bootstrap.min.css'); ?>
        <style>
            body {
                padding-top: 60px;
                padding-bottom: 40px;
            }
        </style>
        <?php echo $html->create_link('static/css/bootstrap-responsive.min.css'); ?>
        <?php echo $html->create_link('static/css/main.css'); ?>

        <?php echo $html->create_script('static/js/vendor/modernizr-2.6.1-respond-1.1.0.min.js'); ?>
    </head>
    <body>