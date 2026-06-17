<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories</title>
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
            <h1>Category of Blogs</h1>
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
                $conn = mysqli_connect(dbhost,dbuname,dbpass,dbname);
                $q = "select * from category order by catpos";
                $result = mysqli_query($conn, $q);//$result is an object of mysqli_result class
                $rescount=mysqli_affected_rows($conn);//1 or 0

                if($rescount==0)
                {
                    print "No categories found";
                }
                else
                {
                    while($resarr=mysqli_fetch_array($result))
                    {
                        print "<div class='col-md-3 col-sm-6 col-xs-12 mb-4 '>
						<div class='product-at '>
						<a href='blogssubcat.php?cid=$resarr[0]' style='text-decoration:none;' color='black'>
                            <img class='img-responsive' src='uploads/$resarr[2]' height='100px' alt=''>
                            <p class='tun'>$resarr[1]</p>
                            
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
                    mysqli_close($conn);
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