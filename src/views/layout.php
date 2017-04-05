<!-- filename: layout.php -->
<!-- authors: Will Alley -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>K-Town Car Share</title>

    <!-- Bootstrap Core CSS -->
    <link href="./public/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="./public/vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="./public/css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="./public/vendor/morrisjs/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="./public/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

</head>

<body>
    <div id="wrapper">
        <!-- Navigation -->
        <nav class="navbar navbar-static-top navbar-inverse" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/KTCS/src">K-Town Car Share</a>
            </div>
            <!-- /.navbar-header -->
            <?php 
                if (isset($_SESSION['user_info'])) {
                    $user_info = $_SESSION['user_info'];
                    echo 
                    '<ul class="nav navbar-top-links navbar-right">
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="fa fa-user fa-fw"></i>'. $user_info['name'] .' <i class="fa fa-caret-down"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-user">
                                <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
                                </li>
                                <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                                </li>
                            </ul>
                        </li>
                    </ul>'; //end echo
                }
            ?>

                <!-- /.navbar-top-links -->
            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li>
                            <a href="/KTCS/src"><i class="fa fa-home fa-fw"></i> Home</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-car fa-fw"></i> Car Lots<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="<?php echo '?' . htmlspecialchars(SID) ?>">Foo</a>
                                </li>
                                <li>
                                    <a href="<?php echo '?' . htmlspecialchars(SID) ?>">Bar</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-car fa-fw"></i> Administrator Actions<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="?controller=pages&action=fleet">Fleet Maintenance</a>
                                </li>
                                <li>
                                    <a href="?controller=pages&action=records">Records</a>
                                </li>
                                <li>
                                    <a href="?controller=pages&action=customer">Customer Service</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <?php
                                // if a user is logged in, display a link to logout
                                if (isset($_SESSION['user_info'])) {
                                    echo '<a href="?'.htmlspecialchars(SID).'&controller=pages&action=logout"><i class="fa fa-files-o fa-fw"></i>Logout</a>';
                                }
                                else {
                                    echo '<a href="?'.htmlspecialchars(SID).'&controller=pages&action=login"><i class="fa fa-files-o fa-fw"></i>Login/Register</a>';
                                }
                            ?>
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <div id="page-wrapper">
            <?php 
                require_once('routes.php');
            ?>
        </div>

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="./public/vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="./public/vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="./public/vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="./public/vendor/raphael/raphael.min.js"></script>
    <script src="./public/vendor/morrisjs/morris.min.js"></script>
    <script src="./public/data/morris-data.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="./public/js/sb-admin-2.js"></script>
</body>

</html>