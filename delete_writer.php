<?php
// Establish connection (if not already done)
// ...
@include 'config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $deleteQuery = "DELETE FROM documentwriters WHERE writerid = $id";
    $deleteResult = pg_query($connection, $deleteQuery);

    if ($deleteResult) {
        header("Location: admin_page.php"); // Redirect back to display page
        exit();
    } else {
        echo "Deletion failed";
    }
} else {
    echo "Invalid request";
}
?>