<?php
require_once("includes/vars.php");
$cid=$_GET["cid"];
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/custom_php_error.log'); // File in same folder as this script
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$conn = null;
try 
{
    $conn = mysqli_connect(dbhost,dbuname,dbpass,dbname);
    $q = "delete from category where catid='$cid'";
    mysqli_query($conn, $q);
    $qcount=mysqli_affected_rows($conn);
    if($qcount==1)
    {
       header("location:manageblogcategory.php");
    }
    else
    {
        print "Error while deleting the record";
    }
    
} 
catch (Exception $e) 
{
    error_log("Database error: " . $e->getMessage());
    $msg="Error while deleting";
} 
finally // it always run, even if there is error in try block or if there is no error
{
    if ($conn) 
    {
        mysqli_close($conn);
    }
}
if(isset($msg))
print $msg;
?>
