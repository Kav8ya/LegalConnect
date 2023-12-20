<?php
@include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $writerid = $_GET['id'];

    // Query to select the specific writer details based on the writerid
    $query = "SELECT * FROM documentwriters WHERE writerid = $writerid";
    $result = pg_query($connection, $query);

    if (pg_num_rows($result) > 0) {
        $writer = pg_fetch_assoc($result); // Fetch the writer details
    } else {
        echo "Writer not found";
        exit();
    }
} else {
    echo "Invalid request";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Extract data from the form
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $contactnumber = $_POST['contactnumber'];
    $email = $_POST['email'];
    $specialization = $_POST['specialization'];
    $writinggenre = $_POST['writinggenre'];
    $qualifications = $_POST['qualifications'];
    $address = $_POST['address'];
    $joindate = $_POST['joindate'];
    $rating = $_POST['rating'];
    $fees = $_POST['fees'];
    $documentswritten = $_POST['documentswritten'];
    $imageblob = $_POST['imageblob']; // Assuming you handle file uploads appropriately

    // Query to update writer details
    $updateQuery = "UPDATE documentwriters SET 
                    firstname = '$firstname',
                    lastname = '$lastname',
                    contactnumber = '$contactnumber',
                    email = '$email',
                    specialization = '$specialization',
                    writinggenre = '$writinggenre',
                    qualifications = '$qualifications',
                    address = '$address',
                    joindate = '$joindate',
                    rating = '$rating',
                    fees = '$fees',
                    documentswritten = '$documentswritten',
                    imageblob = '$imageblob'
                    WHERE writerid = $writerid";
    $updateResult = pg_query($connection, $updateQuery);

    if ($updateResult) {
        echo "Writer details updated successfully";
        // Redirect or perform actions after update
    } else {
        echo "Error updating writer details: " . pg_last_error($connection);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Writer</title>
</head>
<body>

<h2>Edit Writer</h2>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?id=<?php echo $writerid; ?>" method="post">
    First Name: <input type="text" name="firstname" value="<?php echo $writer['firstname']; ?>"><br><br>
    Last Name: <input type="text" name="lastname" value="<?php echo $writer['lastname']; ?>"><br><br>
    Contact Number: <input type="text" name="contactnumber" value="<?php echo $writer['contactnumber']; ?>"><br><br>
    Email: <input type="text" name="email" value="<?php echo $writer['email']; ?>"><br><br>
    Specialization: <input type="text" name="specialization" value="<?php echo $writer['specialization']; ?>"><br><br>
    Writing Genre: <input type="text" name="writinggenre" value="<?php echo $writer['writinggenre']; ?>"><br><br>
    Qualifications: <input type="text" name="qualifications" value="<?php echo $writer['qualifications']; ?>"><br><br>
    Address: <input type="text" name="address" value="<?php echo $writer['address']; ?>"><br><br>
    Join Date: <input type="date" name="joindate" value="<?php echo $writer['joindate']; ?>"><br><br>
    Rating: <input type="number" name="rating" value="<?php echo $writer['rating']; ?>"><br><br>
    Fees: <input type="number" name="fees" value="<?php echo $writer['fees']; ?>"><br><br>
    Documents Written: <input type="number" name="documentswritten" value="<?php echo $writer['documentswritten']; ?>"><br><br>
    Image Blob: <input type="text" name="imageblob" value="<?php echo $writer['imageblob']; ?>"><br><br>
    <!-- Other fields to edit... -->

    <input type="submit" name="submit" value="Update">
</form>

</body>
</html>
