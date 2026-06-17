<?php
if(session_status() == PHP_SESSION_NONE)
{
	session_start();
}

if(!isset($_SESSION["pname"]) || $_SESSION["utype"]!=="admin") 
{
    header("location:login.php");
}
?>

<div class="header">
	<div class="header-top">
		<div class="container">
			<div class="search">
					<form>
					<input type="text" value="Search " onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Search';}">
						<input type="submit" value="Go">
					</form>
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
					<a href="adminhome.php"><img src="images/logo.png" alt=""></a>	
				</div>
		  <div class=" h_menu4">
					<ul class="memenu skyblue">
					  <li class="active grid"><a class="color8" href="adminhome.php">Home</a></li>	
				      <li><a class="color1" href="#">Manage</a>
				      	<div class="mepanel">
						<div class="row">
							<div class="col1">
								<div class="h_nav">
									<ul>
										<li><a href="manageblogcategory.php">Categories</a></li>
										<li><a href="manageblogsubcat.php">Sub Category</a></li>
										<li><a href="managesingleblogs.php">Blogs</a></li>
								</div>							
							</div>
						  </div>
						</div>
					</li>
				    <li class="grid"><a class="color2" href="#">View</a>
					  	<div class="mepanel">
						<div class="row">
							<div class="col1">
								<div class="h_nav">
									<ul>
									<li><a href="listofmembers.php">Members</a></li>
								</ul>
								</div>							
							</div>
						  </div>
						</div>
			    </li>
			  </ul> 
			</div>
			</div>
			
			
				<div class="clearfix"> </div>
		</div>
		</div>

	</div>