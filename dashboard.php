<!DOCTYPE html>
<?php

session_start();
error_reporting(0);
$_SESSION['page'] = "dashboard";
include("header.php");
include("connection.php");
$username = $_SESSION['username'];

$action = $_GET['action'];

if(!$username)
{
    echo "<div id='wrapper'><div id='page-content-wrapper'>You're not logged in. Redirecting to login!</div></div>";?>
    <META http-equiv="refresh" content="3;URL=./index.php"><?php
    return 1;
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
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <center><div class="panel panel-default" style='width: 1200px;'>
                  <div class="panel-heading">
                    <h3 class="panel-title">Current News</h3>
                  </div>
                  <div class="panel-body">
                    <?php
                    $stmt = $db->query('SELECT * FROM cp_news ORDER BY id DESC LIMIT 5');
                    $dtime = date("m-d-y h:i:s", time());
        
                    echo "<hr />";

                    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
						nl2br($row['body']);
                        echo "<div class='notice'><blockquote><b>" . $row['title'] . "</b><br /><br />" . $row['body'] . "<br /><br /><small> by " . $row['author'] . " on " . $row['date'] . "</small></blockquote></div><hr>"; //etc...
                    }


                    ?> 
                  </div>
                </div></center>
                <center><div class="panel panel-default" style='width: 1200px;'>
                  <div class="panel-heading">
                    <h3 class="panel-title">Account Summary</h3>
                  </div>
                  <div class="panel-body">
                    <?php
                    $stmt2 = $db->prepare('SELECT * FROM accounts WHERE Username=:uname');
                    $stmt2->execute(array(':uname' => $username));

                    if($admrank == 1)
                    {
                        $accttype = "<font color='slateblue'><b>Retired Admin</b></font>";
                    }
                    else if($admrank == 2)
                    {
                        $accttype = "<font color='lime'><b>Junior Admin</b></font>";
                    }
                    else if($admrank == 3)
                    {
                        $accttype = "<font color='lime'><b>General Admin</b></font>";
                    }
                    else if($admrank == 4)
                    {
                        $accttype = "<font color='sandybrown'><b>Senior Admin</b></font>";
                    }
                    else if($admrank == 1337)
                    {
                        $accttype = "<font color='red'><b>Head Admin</b></font>";
                    }
                    else if($admrank == 1338)
                    {
                        $accttype = "<font color='#6495ED'><b>Lead Head Admin</b></font>";
                    }
                    else if($admrank >= 99999)
                    {
                        $accttype = "<font color='#6495ED'><b>Executive Admin</b></font>";
                    }
                    else
                    {
                        $accttype = "<b>Standard Account</b>";
                    }

                    while($arow = $stmt2->fetch(PDO::FETCH_ASSOC)) {
                        echo "Your I.P. Address: " . $_SERVER['REMOTE_ADDR'] . " • Account Type: " . $accttype . " • Registration Date: <b>" . $arow['RegiDate'] . "</b> • Last Seen In Game: <b>" . $arow['UpdateDate'] ."</b> ";
                    }


                    ?> 
                  </div>
                </div></center>
            </div>
        </div>
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
    if($action == "logout")
    {
        session_destroy();
        ?>
        <META http-equiv="refresh" content="0;URL=./index.php"><?php
    }
    ?>

</body>

</html>
