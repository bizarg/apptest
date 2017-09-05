<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="http://apptest.loc/css/style.css">
    <script src="http://apptest.loc/js/admin.js"></script>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>


    <title><?=Config::get('site_name')?> - <?=__('panel')?></title>
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
            <a class="navbar-brand" href="/"><?=Config::get('site_name')?> - <?=__('panel')?></a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            <?php if (Session::get('login')) : ?>
            <ul class="nav navbar-nav">
                <li><a <?php if(App::getRouter()->getController() == "AdminPages") {?> class='active' <?php } ;?> href='/admin/pages/'>Pages</a></li>
                <li><a <?php if(App::getRouter()->getController() == "AdminContacts") {?> class='active' <?php } ;?> href="/admin/contacts/">Contacts</a></li>
                <li><a <?php if(App::getRouter()->getController() == "AdminImages") {?> class='active' <?php } ;?> href="/admin/images/">Images</a></li>
                <li><a href="/auth/logout">Logout</a></li>
            </ul>
            <?php endif; ?>
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
            <div class="alert alert-warning" role="alert">
                <?php foreach (Session::get('error') as $error) : ?>
                    <p><?=$error?></p>
                <?php endforeach; ?>
                <?php Session::delete('error') ?>
            </div>
        <?php endif; ?>

        <?=$data['content']?>
    </div>
</div><!-- /.container -->


</body>
</html>