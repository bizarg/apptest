<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="<?=PATH_CSS;?>flexslider.css" type="text/css">
    <link rel="stylesheet" href="<?=PATH_CSS;?>style.css">


    <!-- Place somewhere in the <head> of your document -->

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
    <!--    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script src="<?=PATH_JS;?>jquery.flexslider.js"></script>
    <title><?=Config::get('site_name')?></title>
    <script type="text/javascript" charset="utf-8">
        $(window).load(function() {
            $('.flexslider').flexslider({
//                    controlNav: 'thumbnails',
                }
            );

        });
    </script>
</head>
<body>
<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/"><?=Config::get('site_name')?></a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <?php if (Session::get('login')) : ?>
                    <li><a <?php if(App::getRouter()->getController() == "pages") {?> class='active' <?php } ;?> href='/pages/'>Pages</a></li>
                    <li><a <?php if(App::getRouter()->getController() == "contacts") {?> class='active' <?php } ;?> href="/contacts/">Contacts</a></li>
                    <li><a <?php if(App::getRouter()->getController() == "contacts") {?> class='active' <?php } ;?> href="/auth/logout">Logout: <?=Session::get('login')?></a></li>
                    <li><a
                <?php else :?>
                    <li><a <?php if(App::getRouter()->getController() == "pages") {?> class='active' <?php } ;?> href='/pages/'>Pages</a></li>
                    <li><a <?php if(App::getRouter()->getController() == "contacts") {?> class='active' <?php } ;?> href="/contacts/">Contacts</a></li>
                    <li><a <?php if(App::getRouter()->getController() == "auth") {?> class='active' <?php } ;?> href="/auth/login">Sign in</a></li>
                    <li><a <?php if(App::getRouter()->getController() == "auth") {?> class='active' <?php } ;?> href="/auth/register">Sign up</a></li>
                <?php endif?>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>

<div class="container">
    <div class="starter-template">
        <?php if (Session::hasFlash()) : ?>
            <div class="alert alert-info" role="alert">
                <?php Session::flash(); ?>
            </div>
        <?php endif; ?>
        <?php if (Session::has('error')) : ?>
        <div class="alert alert-danger" role="alert">
            <?php foreach (Session::get('error') as $error) : ?>
                <p><?=$error; ?></p>
            <?php endforeach; ?>
            <?php Session::delete('error'); ?>
        </div>
        <?php endif; ?>