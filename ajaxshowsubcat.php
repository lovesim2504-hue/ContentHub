<?php
require_once("includes/vars.php");
$conn = mysqli_connect(dbhost, dbuname, dbpass, dbname);

$cid = $_POST['cid'];

$q = "SELECT subcatid, subcatname FROM subcategory WHERE catid='$cid' ORDER BY subcatname";
$result = mysqli_query($conn, $q);

echo "<option value=''>Choose Subcategory</option>";
while($res = mysqli_fetch_assoc($result)) {
    echo "<option value='{$res['subcatid']}'>{$res['subcatname']}</option>";
}

mysqli_close($conn);
?>
