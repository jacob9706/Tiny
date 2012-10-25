<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title><?php echo (empty($title) ? "" : $title) ?></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width">

    <?php echo $html->create_link('static/css/bootstrap.css'); ?>
    <style>
    body {
        padding-top: 60px;
        padding-bottom: 40px;
    }
    </style>
    <?php echo $html->create_link('static/css/bootstrap-responsive.css'); ?>
    <?php echo $html->create_link('static/css/main.css'); ?>

    <?php echo $html->create_script('static/js/vendor/modernizr-2.6.1-respond-1.1.0.min.js'); ?>
</head>
<body>
    <div class="container">
        <?php include 'nav.php'; ?>

        <ul class="nav nav-pills">
            <li <?php echo $GLOBALS['page'] == 'index' ? 'class="active"' : ''; ?>><?php echo $html->create_a('index', 'index', 'Home'); ?></li>
            <li <?php echo $GLOBALS['page'] == 'about' ? 'class="active"' : ''; ?>><?php echo $html->create_a('index', 'about', 'About'); ?></li>
            <li <?php echo $GLOBALS['page'] == 'search' ? 'class="active"' : ''; ?>><?php echo $html->create_a('search', 'search', 'Search'); ?></li>
            <!-- Test Dropdown -->
            <!--<li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li <?php echo $GLOBALS['page'] == 'index' ? 'class="active"' : ''; ?>><a href="#">Action</a></li>
                    <li><a href="#">Another action</a></li>
                    <li><a href="#">Something else here</a></li>
                    <li class="divider"></li>
                    <li class="nav-header">Nav header</li>
                    <li><a href="#">Separated link</a></li>
                    <li><a href="#">One more separated link</a></li>
                </ul>
            </li>-->
        </ul>
        
        <div style="height: 6px; background-color: #000000;"></div>
        <br>