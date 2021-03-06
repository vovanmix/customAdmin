<?php
/**
 * @var $content
 */
?><!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
    <head lang="en">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="/vendor/bootstrap/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="/vendor/bootstrap/dist/css/bootstrap-theme.min.css">

        <title></title>
    </head>
    <body>

    <header class="navbar navbar-static-top " id="top" role="banner">
        <div class="container">
            <nav class="collapse navbar-collapse bs-navbar-collapse">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="/"><span class="glyphicon glyphicon-tree-deciduous" aria-hidden="true"></span><b>Simple Admin</b></a>
                    </li>
                    <li>
                        <a href="/category/">Categories</a>
                    </li>
                    <li>
                        <a href="/product/">Products</a>
                    </li>
                </ul>
            </nav>
        </div>
    </header>

    <div class="container">

        <?php $flash = getFlash(); ?>
        <?php if(!empty($flash)){ ?>
            <div class="alert alert-success" role="alert"><?=$flash?></div>
        <?php } ?>

        <?php $flash = getFlashError(); ?>
        <?php if(!empty($flash)){ ?>
            <div class="alert alert-danger" role="alert"><?=$flash?></div>
        <?php } ?>

        <div class="row">
            <?=$content?>
        </div>
    </div>


    <script src="/vendor/jquery/dist/jquery.min.js"></script>
    <script src="/vendor/bootstrap/dist/js/bootstrap.min.js"></script>

    </body>
</html>
