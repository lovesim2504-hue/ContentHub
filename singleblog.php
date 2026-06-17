<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blogs</title>
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
            <h1>All Blogs</h1>
            <div class="col-md-12 product1">
				<div class=" bottom-product">
					
            <?php
            require_once("includes/vars.php");
            ini_set('log_errors', 1);
            ini_set('error_log', __DIR__ . '/custom_php_error.log'); // File in same folder as this script
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
            $conn = null;
            try 
            {
                $scid=$_GET["scid"];
                $conn =new mysqli(dbhost,dbuname,dbpass,dbname);
                $q = "select * from blogs where subcatid='$scid'";
                $result = $conn->query($q);//$result is an object of mysqli_result class
                $rescount=mysqli_affected_rows($conn);//1 or 0

                if($rescount==0)
                {
                    print "Not any blog";
                }
                else
                {
                    while($resarr=mysqli_fetch_array($result))
                    {
                        print "<div class='col-md-4 bottom-cd simpleCart_shelfItem'>
						<div class='product-at  pd' style='background-color:lightgrey; padding:20px; border-radius:10px; '>
						<a href='details.php?pid=$resarr[0]'>
                            <img class='img-responsive' src='uploads/$resarr[9]' height='125' alt=''>
                            <li class='tun tunsb'  ;>$resarr[3]
                            ($resarr[4])</li>
                            <p class='tun'>$resarr[5]</p>
						</a>	
						</div>
					    </div>";
                    }
                }
                
            } 
            catch (Exception $e) 
            {
                error_log("Database error: " . $e->getMessage());
                $msg="An error occurred during fetching records. Please try again later.";
            } 
            finally // it always run, even if there is error in try block or if there is no error
            {
                if ($conn) 
                {
                 $conn->close();
                }
            }
            ?>

                 
					
					<div class="clearfix"> </div>
				</div>
				
			</div>
            
        </div>

    </div>


    <?php
    require_once("includes/footer.php");
    ?>
</body>

</html>