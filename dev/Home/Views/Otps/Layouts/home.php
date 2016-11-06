<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Popular php framework, framework phổ biến">
    <meta name="author" content="PHP framework - overfull framework, special framework">

    <title>PHP framework - Overfull framework</title>

    <!-- Bootstrap Core CSS -->
    <link href="<?php echo URL::asset('/plugins/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="<?php echo URL::asset('/plugins/font-awesome/css/font-awesome.min.css') ?>" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>

    <!-- Plugin CSS -->
    <link href="<?php echo URL::asset('/plugins/magnific-popup/magnific-popup.css') ?>" rel="stylesheet">

    <!-- Theme CSS -->
    <link href="<?php echo URL::asset('/plugins/theme/css/creative.min.css') ?>" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body id="page-top">

    <nav id="mainNav" class="navbar navbar-default navbar-fixed-top">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span> Menu <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand page-scroll" href="<?php echo URL::to('/') ?>">Overfull.net</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a class="page-scroll" href="<?php echo URL::to('/docs/1.x/index.html') ?>">Docs</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="<?php echo URL::to('/install.html') ?>">Install</a>
                    </li>
                    
                    <li>
                        <a class="page-scroll" href="<?php echo URL::to('/packages/1.x/index.html') ?>">Packages</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="<?php echo URL::to('/weights/1.x/index.html') ?>">Weights</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="<?php echo URL::to('/patterns/1.x/index.html') ?>">Patterns</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="<?php echo URL::to('/services.html') ?>">Services</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>

    <?php echo $this->content(); ?>

    <footer>
        <?php echo $this->render('Elements/footer'); ?>
    </footer>

    <!-- jQuery -->
    <script src="<?php echo URL::asset('/plugins/jquery/jquery.min.js') ?>"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo URL::asset('/plugins/bootstrap/js/bootstrap.min.js') ?>"></script>

    <!-- Plugin JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
    <script src="<?php echo URL::asset('/plugins/scrollreveal/scrollreveal.min.js') ?>"></script>
    <script src="<?php echo URL::asset('/plugins/magnific-popup/jquery.magnific-popup.min.js') ?>"></script>

    <!-- Theme JavaScript -->
    <script src="<?php echo URL::asset('/plugins/theme/js/creative.min.js') ?>"></script>

</body>

</html>
