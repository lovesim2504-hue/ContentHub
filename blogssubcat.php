<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sub Categories</title>
    <?php
    require_once("includes/headfiles.php");
    ?>
</head>

<body>
    <?php
    require_once("includes/header.php");
    ?>
<div class="accsb">
    <div class="container">
        <div class="account >
            <h1>Sub Categories</h1>
            <div class="col-md-12 product1">
                <div class=" bottom-product">
                    
            <?php
            require_once("includes/vars.php");
            ini_set('log_errors', 1);
            ini_set('error_log', __DIR__ . '/custom_php_error.log'); 
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
            $conn = null;
            try 
            {
                $cid=$_GET["cid"];
                $conn = mysqli_connect(dbhost,dbuname,dbpass,dbname);
                $q = "select * from subcategory where catid='$cid'";
                $result = mysqli_query($conn, $q);
                $rescount=mysqli_affected_rows($conn);

                if($rescount==0)
                {
                    print "No Sub Categories found";
                }
                else
                {
                    while($resarr=mysqli_fetch_array($result))
                    {
                        print "<div class='col-md-8 bottom-cd simpleCart_shelfItem'>
                        <div class='product-at divsb'>
                        <a href='singleblog.php?scid=$resarr[0]'>
                            <h2 class='tun'>$resarr[2]</h2>   
                            <img class='img-responsive sct' src='uploads/$resarr[5]' alt=''>
                            <p class='tun'>$resarr[3]</p>  
                            <p class='tuncat'>$resarr[4]</p> 
                       
                        </a>    
                        </div></div>
                        ";
                    }
                   print "<div class='col-md-3'> </div>";
                }
                
            } 
            catch (Exception $e) 
            {
                error_log("Database error: " . $e->getMessage());
                $msg="An error occurred during fetching records. Please try again later.";
            } 
            finally
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

</div>
    <?php
    require_once("includes/footer.php");
    ?>
</body>

</html>

