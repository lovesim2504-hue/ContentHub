<?php
$cid=$_GET["cid"];
require_once("includes/vars.php");
    ini_set('log_errors', 1);
    ini_set('error_log', __DIR__ . '/custom_php_error.log'); 
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $conn = null;
    try{
    $conn = mysqli_connect(dbhost,dbuname,dbpass,dbname);
        $q="select * from category where catid=$cid";
        $result= mysqli_query($conn,$q);
        $rescount=mysqli_affected_rows($conn);

    if($rescount==1)
    {
        $resarr=mysqli_fetch_array($result);
    }
    else
    {
        $msg="Error while fetching details";
     }
    }
    catch (Exception $e) 
    {
        error_log("Database error: " . $e->getMessage());
        $msg="An error occurred. Please try again later.";
    } 
    finally // it always run, even if there is error in try block or if there is no error
    {
        if ($conn) 
        {
            mysqli_close($conn);
        }
    }
  
    if(isset($_POST["btn"]))
    {
        require_once("includes/vars.php");
   
    $conn = null;
    $conn = mysqli_connect(dbhost,dbuname,dbpass,dbname);

	$cname= mysqli_real_escape_string($conn,$_POST["catname"]);
	$nm= mysqli_real_escape_string($conn,$_POST["aname"]);
	$date= mysqli_real_escape_string($conn,$_POST["date"]);

	$errcode=$_FILES["catpic"]["error"];
    if($errcode==0)//admin has chosen a file and it has been uploaded successfully to temp folder
    {
        $t=time();
        $tname=$_FILES["catpic"]["tmp_name"];
        $fn=$t.$_FILES["catpic"]["name"];//543543245abc.jpg
        if(!move_uploaded_file($tname,"uploads/$fn"))
        {
             $fn=$resarr['catpic'];        }
    }
    else//admin doesnt want to change image
    {
        $fn=$resarr['catpic'];//default image name already stored in uploads folder
    }
    
    $cpos=$_POST["pos"];

    ini_set('log_errors', 1);
    ini_set('error_log', __DIR__ . '/custom_php_error.log'); // File in same folder as this script
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    
    try 
    {
        $q = "update category set catname='$cname',catpic='$fn',catpos='$cpos',aname='$nm',date='$date' where catid='$cid'";
        $result = mysqli_query($conn, $q);//$result is an object of mysqli_result class
        $qcount=mysqli_affected_rows($conn);//1 or 0

        if($qcount==1)
        {
            header("loaction:managecategory.php");
        }
        else
        {
            $msg="Category not updated";
        }
        
    } 
    catch (Exception $e) 
    {
        error_log("Database error: " . $e->getMessage());
        $msg="An error occurred. Please try again later.";
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
    <title>Manage Category</title>
    <?php
    require_once("includes/headfiles.php");
    ?>
</head>

<body>
    <?php
    require_once("includes/adminheader.php");
    ?>

    <div class="container">
        <div class="account">
            <h1>Update Category</h1>
            <div class="account-pass">
                <div class="col-md-8 account-top">
                    <form name="form1" method="post" enctype="multipart/form-data">
                        <div>
                            <span>Category Name</span>
                            <input type="text" name="catname" value="<?php print $resarr['catname'] ?>">
                        </div>
                        <div>
                            <span>Category Picture</span>
                            <?php print "<img src='uploads/$resarr[catpic]' height='75'" ?>
                            Choose new image, if required <br><br>
                            <input type="file" name="catpic">
                        </div>
                        <div>
                            <span>Display Position</span>
                            <input type="text" name="pos" value="<?php print $resarr['catpos'] ?>">
                        </div>
                        <div>
                        <span>Date</span>
                            <input type="date" name="date" value="<?php print $resarr['date'] ?>">
                        </div>
                        <div>
                        <span>name</span>
                            <input type="text" name="aname" value="<?php print $resarr['aname'] ?>">
                        </div>

                        <input type="submit" name="btn" value="Update">
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

       
        <?php
            require_once("includes/vars.php");
            $conn = null;
            $conn = mysqli_connect(dbhost,dbuname,dbpass,dbname);
            ini_set('log_errors', 1);
            ini_set('error_log', __DIR__ . '/custom_php_error.log'); // File in same folder as this script
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
            try 
            {
                $q = "select * from category";
                $result = mysqli_query($conn, $q);
                $rescount=mysqli_affected_rows($conn);
                if($rescount==0)
                {
                    print "No categories added yet";
                }
                else
                {
                    print "<br/><br/><h2>Added Categories</h2><br/>";
                    print "<table class='table table-striped'>
                    <tr>
                      <th>Picture</th>
                    <th>Name</th>
                    <th>Date</th>
                    <th>catname</th>
                    <th>Position</th>
                    <th>Update</th>
                    <th>Delete</th>
                    </tr>";
                    while($resarr=mysqli_fetch_array($result))
                    {
                        print "<tr>
                        <td><img src='uploads/$resarr[catpic]' height='75'></td>
                            <td>$resarr[aname]</td>
                        <td>$resarr[date]</td>
                        <td>$resarr[catname]</td>
                        <td>$resarr[catpos]</td>
                        <td><a href='updatecat.php?cid=$resarr[catid]'>Update</a></td>
                        <td><a href='delcat.php?cid=$resarr[catid]'>Delete</a></td>
                        </tr>";
                    }
                    print "</table>";
                    if($rescount===1)
                    {
                        print "$rescount category found";
                    }
                    else
                    {
                         print "$rescount categories found";
                    }
                }
                
            } 
            catch (Exception $e) 
            {
                error_log("Database error: " . $e->getMessage());
                $msg="An error occurred. Please try again later.";
            } 
            finally // it always run, even if there is error in try block or if there is no error
            {
                if ($conn) 
                {
                    mysqli_close($conn);
                }
            }

        ?>
        
        </div>

    </div>


    <?php
    require_once("includes/footer.php");
    ?>
</body>

</html>
        
        </div>

    </div>


    <?php
    require_once("includes/footer.php");
    ?>
</body>

</html>