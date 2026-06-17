<?php
session_start();
require_once("includes/vars.php");  // Make sure to include your database connection details here

// If the form has been submitted
if (isset($_POST["btn"])) {
    if (isset($_SESSION["un"])) { // Check if the user is logged in
        // Sanitize and retrieve form data
        $cid = $_POST["cat"];
        $scid = $_POST["subcat"];
        $pname = $_POST["pname"];
        $date = date('Y-m-d H:i:s');  // Use the current timestamp
        $hline = $_POST["headline"];
        $descrip = $_POST["description"];
        $fdescrip = $_POST["fulldescription"];
        $feat = $_POST["featured"];
        
        // Handle file upload
        if ($_FILES["picture"]["error"] === UPLOAD_ERR_OK) {
            $uploadDir = 'uploads/';
            $uploadFile = $uploadDir . basename($_FILES["picture"]["name"]);
            $fileTmpName = $_FILES["picture"]["tmp_name"];
            
            // Validate file type (only allow images for security)
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            if (!in_array($_FILES["picture"]["type"], $allowedTypes)) {
                $msg = "Only JPG, PNG, and GIF files are allowed.";
            } else {
                // Move the file to the desired location
                if (move_uploaded_file($fileTmpName, $uploadFile)) {
                    $fn = basename($_FILES["picture"]["name"]);  // Store the file name
                } else {
                    $msg = "There was an error uploading the file.";
                }
            }
        } else {
            $msg = "Error in file upload.";
        }

        // Only proceed with database insertion if there was no file upload error
        if (!isset($msg)) {
            // Create the database connection
            $conn = mysqli_connect(dbhost, dbuname, dbpass, dbname);
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }

            // Prepare the SQL query using a prepared statement
            $stmt = $conn->prepare("INSERT INTO blogs (catid, subcatid, pname, date, headline, description, fulldescription, featured, picture) 
                                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("iisssssss", $cid, $scid, $pname, $date, $hline, $descrip, $fdescrip, $feat, $fn);

            // Execute the query
            $stmt->execute();

            // Check if the insertion was successful
            if ($stmt->affected_rows == 1) {
                header("Location: cart.php");
            } else {
                $msg = "Error while adding to cart, try again.";
            }

            // Close the statement and connection
            $stmt->close();
            mysqli_close($conn);
        }
    } else {
        header("Location: login.php");  // Redirect if the user is not logged in
    }
}
?>
