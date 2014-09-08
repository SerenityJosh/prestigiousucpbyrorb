<!DOCTYPE html>
<?php

session_start();
error_reporting(0);
$username = $_SESSION['username'];
$admrank = $_SESSION['admrank'];
$banned = $_SESSION['banned'];
$uid = $_SESSION['usernameid'];
$page = $_SESSION['page'];
include("connection.php");

$stmt = $db->prepare('SELECT * FROM bans WHERE ip_address=:ipa AND user_id=:uid');
$stmt->execute(array(':ipa' => $_SERVER['REMOTE_ADDR'], ':uid' => $uid));
$row_count = $stmt->rowCount();

if($row_count)
{
    $_SESSION['banned'] = 1;
}


if($_SESSION['banned'])
{
    session_destroy();
}

?>

<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/simple-sidebar.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div id="wrapper">

        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <ul class="sidebar-nav">
                <li class="sidebar-brand">
                    <a href="http://prestigiousgaming.net/forums">
                        PRESTIGIOUS™
                    </a>
                </li>
                <?php
                if(!$username)
                {?>
                    <li>
                        <a href="#"><span class="glyphicon glyphicon-lock"></span> Login</a>
                    </li>
                <?php
                }  
                ?>
                <?php
                if($username)
                {?>
                    <?php
                    if($page == "dashboard")
                    {?>
                        <li class='sidebar-active'>
                            <a href="./dashboard.php"><span class="glyphicon glyphicon-list-alt"></span> Dashboard</a>
                        </li><?php
                    }?>
                    <?php
                    if($page != "dashboard")
                    {?>
                        <li>
                            <a href="./dashboard.php"><span class="glyphicon glyphicon-list-alt"></span> Dashboard</a>
                        </li><?php
                    }?>
                    <li>
                        <a href="#"><span class="glyphicon glyphicon-user"></span> Profile</a>
                    </li>
                    <li>
                        <a href="#"><span class="glyphicon glyphicon-lock"></span> Account Settings</a>
                    </li>
                    <?php
                    if($page == "staffroster")
                    {?>
                        <li class='sidebar-active'>
                            <a href="./roster.php"><span class="glyphicon glyphicon-list"></span> Staff Roster</a>
                        </li><?php
                    }?>
                    <?php
                    if($page != "staffroster")
                    {?>
                        <li>
                            <a href="./roster.php"><span class="glyphicon glyphicon glyphicon-list"></span> Staff Roster</a>
                        </li><?php
                    }?>
                    <?php
                    if($username && $admrank >= 2)
                    {?>
                        <li>
                            <a href="#"><span class="glyphicon glyphicon-star"></span> Administrator Panel</a>
                        </li>
                    <?php
                    }
                    ?>
                    <li>
                        <a href="#"><span class="glyphicon glyphicon-bullhorn"></span> Faction Leader Panel</a>
                    </li>
                    <br><br><li>
                        <a href="./dashboard.php?action=logout"><span class="glyphicon glyphicon-lock"></span> Logout</a>
                    </li>
                <?php
                }  
                ?>
            </ul>
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <!-- /#page-content-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery Version 1.11.0 -->
    <script src="js/jquery-1.11.0.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Menu Toggle Script -->
    <script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
    </script>

    <?php
    ?>

</body>

</html>
