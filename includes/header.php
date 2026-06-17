<?php
if(session_status() == PHP_SESSION_NONE)
{
	session_start();
}
?>

<div class="header">
	<div class="header-top">
		<div class="container">
			<div class="search">
					
			</div>
			<div class="header-left">
						
					<ul>
						<?php 
						if(isset($_SESSION["pname"])) 
						{
							print '<li><a>Welcome ' . $_SESSION["pname"] . '</a></li>
							<li><a class="lock"  href="changepassword.php">Change Password</a></li>
							<li><a class="lock" href="logout.php">Logout</a></li>';
						}
						else
						{
							print '<li><a>Welcome Guest</a></li>
							<li><a class="lock"  href="login.php">Login</a></li>
							<li><a class="lock" href="register.php">Register</a></li>';
						}
						
						?>	
					</ul>
					
					<div class="clearfix"> </div>
			</div>
				<div class="clearfix"> </div>
		</div>
		</div>
		<div class="container">
			<div class="head-top">
				<div class="logo">
					<a href="home.php"><h2>Blogee</h2></a>	
				</div>
		  <div class=" h_menu4">
					<ul class="memenu skyblue">
					  <li class="active grid"><a class="color8" href="home.php">Home</a></li>	
				<li><a class="color4" href="categories.php">Blog</a></li>							
				<li><a class="color6" href="contactus.php">Contact</a></li>
			  </ul> 
			</div>
							<div class="clearfix"> </div>
		</div>
		</div>

	</div>