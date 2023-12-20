<!DOCTYPE html>
<html>
<head>
    <title>Insert Document Writer</title>
    <link rel="stylesheet" href="insert_writer.css">
</head>
<body>
<a href="admin_page.php"><div class="arrow"></div></a>
<h2>Insert Document Writer</h2>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
    Writer ID: <input type="text" name="writerid"><br><br>
    First Name: <input type="text" name="firstname"><br><br>
    Last Name: <input type="text" name="lastname"><br><br>
    Contact Number: <input type="text" name="contactnumber"><br><br>
    Email: <input type="text" name="email"><br><br>
    Specialization: <input type="text" name="specialization"><br><br>
    Writing Genre: <input type="text" name="writinggenre"><br><br>
    Qualifications: <input type="text" name="qualifications"><br><br>
    Address: <input type="text" name="address"><br><br>
    Join Date: <input type="date" name="joindate"><br><br>
    Rating: <input type="number" name="rating"><br><br>
    Fees: <input type="number" name="fees"><br><br>
    Documents Written: <input type="number" name="documentswritten"><br><br>
    Image Blob: <input type="file" name="imageblob"><br><br>

    <input type="submit" name="submit" value="Submit">
</form>

<?php
@include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $writerid = $_POST['writerid'];
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

    $targetDirectory = ""; 
    $targetFile = $targetDirectory . basename($_FILES["imageblob"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    if (move_uploaded_file($_FILES["imageblob"]["tmp_name"], $targetFile)) {
        echo "The file ". basename( $_FILES["imageblob"]["name"]). " has been uploaded.";
        $imagePath = basename($_FILES["imageblob"]["name"]); 

        // SQL query to insert data into the document_writers table
        $query = "INSERT INTO document_writers (writerid, firstname, lastname, contactnumber, email, specialization, writinggenre, qualifications, address, joindate, rating, fees, documentswritten, imageblob) VALUES ('$writerid', '$firstname', '$lastname', '$contactnumber', '$email', '$specialization', '$writinggenre', '$qualifications', '$address', '$joindate', $rating, $fees, $documentswritten, '$imagePath')";

        $result = pg_query($connection, $query);

        if ($result) {
            header("Location: admin_page.php");
            exit();
        } else {
            echo "<br>Error: " . pg_last_error($connection);
        }
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
?>

</body>
</html>
