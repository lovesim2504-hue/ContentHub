<?php
if(isset($_POST["btn"]))
{
	require_once("includes/vars.php");
	$pn=$_POST["pname"];
	$phone=$_POST["ph"];
	$email=$_POST["em"];
	$passw=$_POST["pass"];
	$cpassw=$_POST["cpass"];
	if($passw===$cpassw)
	{
		ini_set('log_errors', 1);
		ini_set('error_log', __DIR__ . '/custom_php_error.log'); // File in same folder as this script
		mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
		$conn = null;
		try 
		{
			$conn = mysqli_connect(dbhost,dbuname,dbpass,dbname);
			$q = "INSERT INTO register(name,phone,username,password) VALUES ('$pn','$phone','$email','$passw')";
			$success=mysqli_query($conn, $q);
			
			if($success==true)
			{
				header("location:home.php");
			}
			else
			{
				$msg="An error occurred during registration. Please try again later.";
			}
			
		} 
		catch (Exception $e) 
		{
			error_log("Database error: " . $e->getMessage());
			$msg="An error occurred during registration. Please try again later.";
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
		$msg="Password and confirm password doesn';'t match";
	}
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Page</title>
    <?php
    require_once("includes/headfiles.php");
    ?>
</head>

<body>
    <?php
    require_once("includes/header.php");
    ?>

<div class=" container">
<div class=" register">
	<h1>Register</h1>
		  	  <form name="form1" method="post"> 
				 <div class="col-md-6 register-top-grid">
					<h3>Personal infomation</h3>
					 <div>
						<span>Name</span>
						<input type="text" name="pname"> 
					 </div>
					 <div>
						<span>Phone</span>
						<input type="number" name="ph"> 
					 </div>
					 <div>
						 <span>Email Address(Username)</span>
						 <input type="email" name="em"> 
					 </div>
					 
					 </div>
				     <div class="col-md-6 register-bottom-grid">
						    <h3>Login information</h3>
							 <div>
								<span>Password</span>
								<input type="password" name="pass">
							 </div>
							 <div>
								<span>Confirm Password</span>
								<input type="password" name="cpass">
							 </div>
							 <input type="submit" value="Submit" name="btn">
							 <?php
							 if(isset($msg))
							 {
								print $msg;
							 }
							 ?>
					 </div>
					 <div class="clearfix"> </div>
				</form>
			</div>
</div>


    <?php
    require_once("includes/footer.php");
    ?>
</body>

</html>