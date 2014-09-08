<!DOCTYPE html>
<?php
include("header.php");
include("connection.php");

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
    <link href="css/style.css" rel="stylesheet">

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
                <div class="row">
                    <div class="col-lg-12">
                        <center><div id="login">
                          <h1>Panel Login</h1>
                          <form method='post' action='./index.php'>
                            <input name='charname' type="text" placeholder="Character Name (John_Doe)" />
                            <input type="password" name='charpass' placeholder="Password" />
                            <input type="submit" name='loginbtn' value="Log in" />
                          </form>
                        </div></center>
                        
                    </div>
                </div>
            </div>
            <?php
                if($_POST['loginbtn'])
                {
                    if($_POST['charname'] && $_POST['charpass'])
                    {
                        $cuser = htmlspecialchars($_POST['charname']);
                        $cpass = hash("whirlpool", $_POST['charpass']);
                        $cpassu = strtoupper($cpass);
                        $stmt = $db->prepare("SELECT `Username` FROM accounts WHERE Username=:user");
                        $stmt->execute(array(':user' => $cuser));
                        $row_count = $stmt->rowCount();
                        if($row_count == 1)
                        {
                            $stmt3 = $db->prepare('SELECT * FROM accounts WHERE Username=:usern');
                            $stmt3->execute(array(':usern' => $cuser));
     
                            while($arow = $stmt3->fetch(PDO::FETCH_ASSOC)) {
                                $apass = $arow['Key'];
                                if($cpassu == $apass)
                                {
                                    $stmt2 = $db->prepare('SELECT * FROM bans WHERE ip_address=:ipa AND user_id=:uid');
                                    $stmt2->execute(array(':ipa' => $_SERVER['REMOTE_ADDR'], ':uid' => $arow['id']));
                                    $row_count2 = $stmt2->rowCount();

                                    while($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
                                        echo "<center><div class='alert alert-danger alert-dismissible' style='width: 350px;' role='alert'>
  <button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span></button>
  <strong>Error!</strong> Account <b>BANNED</b>!
</div></center>";           
                                        return 1;
                                    }
                                    $_SESSION['username'] = $cuser;
                                    $_SESSION['usernameid'] = $arow['id'];

                                    if($arow['AdminLevel'] >= 1)
                                    {
                                        if($arow['SecureIP'] != $_SERVER['REMOTE_ADDR'])
                                        {
                                            $_SESSION['admrank'] = $arow['AdminLevel'];
                                        }
                                    }
                                    echo "<center><div class='alert alert-success alert-dismissible' style='width: 350px;' role='alert'>
  <button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span></button>
  <strong>Success!</strong> Logging you in!
</div></center>";?>
                                    <META http-equiv="refresh" content="2;URL=./dashboard.php"><?php
                                }
                                else if($cpassu != $apass || $arow['PermBand'] == 0)
                                {
                                    echo "<center><div class='alert alert-danger alert-dismissible' style='width: 350px;' role='alert'>
  <button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span></button>
  <strong>Error!</strong> Invalid Credentials!
</div></center>";
                                }
                                else if($row['PermBand'] != 0)
                                {
                                    echo "<center><div class='alert alert-danger alert-dismissible' style='width: 350px;' role='alert'>
  <button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span></button>
  <strong>Error!</strong> Account <b>BANNED</b>!
</div></center>";
                                }
                            }
                        }
                        else
                        {
                            echo "<center><div class='alert alert-danger alert-dismissible' style='width: 350px;' role='alert'>
  <button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span></button>
  <strong>Error!</strong> Invalid Credentials!
</div></center>";
                        }
                    }
                    else
                    {
                        echo "<center><div class='alert alert-danger alert-dismissible' style='width: 350px;' role='alert'>
  <button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span></button>
  <strong>Error!</strong> Incomplete Fields!
</div></center>";
                    }
                }
            ?>
            <a href="#menu-toggle" class="btn btn-default" id="menu-toggle">Toggle Menu</a>

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

</body>

</html>
