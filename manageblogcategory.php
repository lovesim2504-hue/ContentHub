<?php
if(isset($_POST["btn"]))
{
    require_once("includes/vars.php");
    
    $conn = null;
    $conn =new mysqli(dbhost,dbuname,dbpass,dbname);
    
	$cname= mysqli_real_escape_string($conn,$_POST["catname"]);

	$errcode=$_FILES["catpic"]["error"];
    if($errcode==0)//admin has chosen a file and it has been uploaded successfully to temp folder
    {
        $t=time();
        $tname=$_FILES["catpic"]["tmp_name"];
        $fn=$t.$_FILES["catpic"]["name"];
        if(!move_uploaded_file($tname,"uploads/$fn"))
        {
             $fn="nopic.jpeg";//default image name already stored in uploads folder
        }
    }
    else
    {
        $fn="nopic.jpeg";//default image name already stored in uploads folder
    }

    $cpos=$_POST["pos"];
   
    $nm=$_POST["aname"];
    $date=$_POST["date"];
    ini_set('log_errors', 1);
    ini_set('error_log', __DIR__ . '/custom_php_error.log'); // File in same folder as this script
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    
    try 
    {
        $q = "insert into category(catname,catpic,catpos,aname,date) values('$cname','$fn','$cpos','$nm','$date')";
        $result = mysqli_query($conn, $q);//$result is an object of mysqli_result class
        $qcount=mysqli_affected_rows($conn);//1 or 0

        if($qcount==1)
        {
            $msg="Category added successfully";
        }
        else
        {
            $msg="Category not added";
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
           $conn->close();
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
            <h1>Manage Category</h1>
            <div class="account-pass">
                <div class="col-md-8 account-top">
                    <form name="form1" method="post" enctype="multipart/form-data">
                        <div>
                            <span>Category Name</span>
                            <input type="text" name="catname">
                        </div>
                        <div>
                            <span>Category Picture</span>
                            <input type="file" name="catpic">
                        </div>
                        <div>
                            <span>Display Position</span>
                            <input type="text" name="pos">
                        </div>
   <div>
                            <span>Name</span>
                            <input type="text" name="aname">
                        </div>
                        <div>
                            <span>Date</span>
                            <input type="date" name="date">
                        </div>
                        <input type="submit" name="btn" value="Add">
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