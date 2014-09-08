<!DOCTYPE html>
<?php

session_start();
error_reporting(0);
$_SESSION['page'] = "staffroster";
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
                <?php
                $stmt = $db->prepare('SELECT * FROM accounts WHERE AdminLevel>=:alvl ORDER BY AdminLevel DESC');
                $stmt->execute(array(':alvl' => 2));

                echo "<center><table class='table table-bordered' style='background-color: #ffffff;'>
                <thead>
                    <th>Name</th>
                    <th>Rank</th>
                </thead><tbody>";

                while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {   
                    if($row['AdminLevel'] == 2)
                    {
                        $accttype = "<font color='lime'><b>Junior Admin</b></font>";
                    }
                    else if($row['AdminLevel'] == 3)
                    {
                        $accttype = "<font color='lime'><b>General Admin</b></font>";
                    }
                    else if($row['AdminLevel'] == 4)
                    {
                        $accttype = "<font color='sandybrown'><b>Senior Admin</b></font>";
                    }
                    else if($row['AdminLevel'] == 1337)
                    {
                        $accttype = "<font color='red'><b>Head Admin</b></font>";
                    }
                    else if($row['AdminLevel'] == 1338)
                    {
                        $accttype = "<font color='#6495ED'><b>Lead Head Admin</b></font>";
                    }
                    else if($row['AdminLevel'] >= 99999)
                    {
                        $accttype = "<font color='#6495ED'><b>Executive Admin</b></font>";
                    }
                    echo "<tr><td><b>" . $row['Username'] . "</b></td> <td>" . $accttype . "</td> </tr>";
                }
                echo "</tbody></table></center>"
                ?>
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
