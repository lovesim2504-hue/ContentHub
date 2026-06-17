<?php
session_start();
if(isset($_POST["btn"]))
{
    require_once("includes/vars.php");
	$email=$_POST["uname"];
	$passw=$_POST["pass"];
    ini_set('log_errors', 1);
    ini_set('error_log', __DIR__ . '/custom_php_error.log'); // File in same folder as this script
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $conn = null;
    try 
    {
        $conn = mysqli_connect(dbhost,dbuname,dbpass,dbname);
        $q = "select * from register where username='$email' and password='$passw'";
        $result=mysqli_query($conn, $q);
        $rescount=mysqli_affected_rows($conn);//1 or 0

        if($rescount==1)
        {
            $resarr=mysqli_fetch_array($result);
            $_SESSION["pname"] = $resarr[0];//storing person name into the session
            $_SESSION["un"] = $resarr[2];//storing person username into the session
            $_SESSION["utype"] = $resarr['UserType'];//storing person usertype into the session
            
            if($resarr['UserType']==="admin")
            {
                header("location:adminhome.php");
            }
            else if($resarr['UserType']==="normal")
            {
                header("location:home.php");
            }
        }
        else
        {
            $msg="Incorrect Username/Password";
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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
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
            <h1>Account</h1>
            <div class="account-pass">
                <div class="col-md-8 account-top">
                    <form name="form1" method="post">
                        <div>
                            <span>Email</span>
                            <input type="text" name="uname">
                        </div>
                        <div>
                            <span>Password</span>
                            <input type="password" name="pass">
                        </div>
                        <input type="submit" name="btn" value="Login">
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