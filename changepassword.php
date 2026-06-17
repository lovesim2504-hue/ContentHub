<?php
session_start();

if(!isset($_SESSION["pname"])) 
{
    header("location:login.php");
}

if(isset($_POST["btn"]))
{
    require_once("includes/vars.php");

	$currp=$_POST["currpass"];
	$newp=$_POST["newpass"];
	$cnewp=$_POST["cnewpass"];
    $uname=$_SESSION["un"];
    if($newp===$cnewp)
    {
        ini_set('log_errors', 1);
        ini_set('error_log', __DIR__ . '/custom_php_error.log'); // File in same folder as this script
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $conn = null;
        try 
        {
            $conn = mysqli_connect(dbhost,dbuname,dbpass,dbname);
            $q = "update register set password='$newp' where username='$uname' and password='$currp'";
            mysqli_query($conn, $q);
            $qcount=mysqli_affected_rows($conn);//1 or 0
            if($qcount==1)
            {
                $msg="Password changed successfully";
            }
            else
            {
                $msg="Password not changed successfully";
            }
        } 
        catch (Exception $e) 
        {
            error_log("Database error: " . $e->getMessage());
            $msg="An error occurred during login. Please try again later.";
        } 
        finally // it always run, even if there is error in try block or if there is no error
        {
            if ($conn) 
            {
                mysqli_close($conn);
            }
        }
    }
    else
    {
        $msg="New Password and Confirm new password does not match";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <?php
    require_once("includes/headfiles.php");
    ?>
</head>

<body>
    <?php
    require_once("includes/header.php");
    ?>

    <div class="container">
        <div class="account">
            <h1>Change Password</h1>
            <div class="account-pass">
                <div class="col-md-8 account-top">
                    <form name="form1" method="post">
                        <div>
                            <span>Current Password</span>
                            <input type="password" name="currpass">
                        </div>
                        <div>
                            <span>New Password</span>
                            <input type="password" name="newpass">
                        </div>
                        <div>
                            <span>Confirm New Password</span>
                            <input type="password" name="cnewpass">
                        </div>
                        <input type="submit" name="btn" value="Change Password">
                        <?php
                        if(isset($msg))
                        {
                            print $msg;
                        }
                        ?>
                    </form>
                </div>
                <div class="clearfix"> </div>
            </div>
        </div>

    </div>


    <?php
    require_once("includes/footer.php");
    ?>
</body>

</html>