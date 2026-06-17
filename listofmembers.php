<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Member</title>
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
            <h1>List of Members</h1>
            <?php
            require_once("includes/vars.php");
            ini_set('log_errors', 1);
            ini_set('error_log', __DIR__ . '/custom_php_error.log'); // File in same folder as this script
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
            $conn = null;
            try 
            {
                $conn = mysqli_connect(dbhost,dbuname,dbpass,dbname);
                $q = "select * from register";
                $result = mysqli_query($conn, $q);//$result is an object of mysqli_result class
                $rescount=mysqli_affected_rows($conn);//1 or 0

                if($rescount==0)
                {
                    print "No members found";
                }
                else
                {
                    print "<table class='table table-striped'>
                    <tr>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Username</th>
                    <th>Delete</th>
                    </tr>";
                    while($resarr=mysqli_fetch_array($result))
                    {
                        print "<tr>
                        <td>$resarr[Name]</td>
                        <td>$resarr[Phone]</td>
                        <td>$resarr[Username]</td>
                        <td><a href='delmember.php?un=$resarr[Username]'>Delete</a></td>
                        </tr>";
                    }
                    print "</table>
                    $rescount member(s) found";
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
        </div>

    </div>


    <?php
    require_once("includes/footer.php");
    ?>
</body>

</html>