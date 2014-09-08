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
                if($username && $admrank)
                {?>
                    <?php
                    if($page == "staffdashboard")
                    {?>
                        <li class='sidebar-active'>
                            <a href="./staff.php"><span class="glyphicon glyphicon-list-alt"></span> Staff Dashboard</a>
                        </li><?php
                    }?>
                    <?php
                    if($page != "staffdashboard")
                    {?>
                        <li>
                            <a href="./staff.php"><span class="glyphicon glyphicon-list-alt"></span> Staff Dashboard</a>
                        </li><?php
                    }?>
                    <?php
                    if($page == "punish")
                    {?>
                        <li class='sidebar-active'>
                            <a href="./punish.php"><span class="glyphicon glyphicon-warning-sign"></span> Punishments</a>
                        </li><?php
                    }?>
                    <?php
                    if($page != "punish")
                    {?>
                        <li>
                            <a href="./punish.php"><span class="glyphicon glyphicon-warning-sign"></span> Punishments</a>
                        </li><?php
                    }?>
                    <?php
                    if($page == "searchu")
                    {?>
                        <li class='sidebar-active'>
                            <a href="./search.php"><span class="glyphicon glyphicon-map-marker"></span> Search Players</a>
                        </li><?php
                    }?>
                    <?php
                    if($page != "searchu")
                    {?>
                        <li>
                            <a href="./search.php"><span class="glyphicon glyphicon-map-marker"></span> Search Players</a>
                        </li><?php
                    }?>
					<?php
                    if($page == "shifts")
                    {?>
                        <li class='sidebar-active'>
                            <a href="./shifts.php"><span class="glyphicon glyphicon-calendar"></span> Book Shift</a>
                        </li><?php
                    }?>
                    <?php
                    if($page != "shifts")
                    {?>
                        <li>
                            <a href="./shifts.php"><span class="glyphicon glyphicon-calendar"></span> Book Shift</a>
                        </li><?php
                    }?>
					<?php
					if($admrank >= 3)
					{
						if($page == "flags")
						{?>
							<li class='sidebar-active'>
								<a href="./flags.php"><span class="glyphicon glyphicon-flag"></span> Flag Database</a>
							</li><?php
						}?>
						<?php
						if($page != "flags")
						{?>
							<li>
								<a href="./flags.php"><span class="glyphicon glyphicon-flag"></span> Flag Database</a>
							</li><?php
						}
					}?>
					<?php
					if($admrank >= 4)
					{
						if($page == "mshifts")
						{?>
							<li class='sidebar-active'>
								<a href="./manageshift.php"><span class="glyphicon glyphicon-bullhorn"></span> Shift Management</a>
							</li><?php
						}?>
						<?php
						if($page != "mshifts")
						{?>
							<li>
								<a href="./manageshift.php"><span class="glyphicon glyphicon-bullhorn"></span> Shift Management</a>
							</li><?php
						}
					}?>
					<?php
					if($admrank >= 1338)
					{
						if($page == "madmins")
						{?>
							<li class='sidebar-active'>
								<a href="./admins.php"><span class="glyphicon glyphicon-certificate"></span> Manage Administrators</a>
							</li><?php
						}?>
						<?php
						if($page != "madmins")
						{?>
							<li>
								<a href="./admins.php"><span class="glyphicon glyphicon-certificate"></span> Manage Administrators</a>
							</li><?php
						}
						if($page == "mpanel")
						{?>
							<li class='sidebar-active'>
								<a href="./managepanel.php"><span class="glyphicon glyphicon-off"></span> Panel Settings (MASTER)</a>
							</li><?php
						}?>
						<?php
						if($page != "mpanel")
						{?>
							<li>
								<a href="./managepanel.php"><span class="glyphicon glyphicon-off"></span> Panel Settings (MASTER)</a>
							</li><?php
						}
					}?>
                    <br><br><li>
						<a href='./dashboard.php'><span class="glyphicon glyphicon-arrow-left"></span> Back to User panel</a>
					</li>
					<li>
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
