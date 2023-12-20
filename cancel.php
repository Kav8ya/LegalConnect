<?php

@include 'config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $deleteQuery = "update appointment set client_id=NULL, status='free' where app_id=$id";
    $delete=pg_query($connection,$deleteQuery);
    if ($delete) {
        header("Location: user_page.php"); // Redirect back to display page
        exit();
    } else {
        echo "Deletion failed";
    }
} else {
    echo "Invalid request";
}
?>