<!DOCTYPE html>
<html>
<head>
    <title>Insert Lawyer</title>
    <link rel="stylesheet" href="insert_writer.css">

</head>
<body>
    
    <a href="admin_page.php"><div class="arrow"></div></a>
    

<h2>Insert Lawyer</h2>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    First Name: <input type="text" name="firstname"><br><br>
    Last Name: <input type="text" name="lastname"><br><br>
    Contact Number: <input type="text" name="contactnumber"><br><br>
    Email: <input type="text" name="email"><br><br>
    Specialization: <input type="text" name="specialization"><br><br>
    Bar Association Membership: <input type="text" name="barassociationmembership"><br><br>
    Qualifications: <input type="text" name="qualifications"><br><br>
    Address: <input type="text" name="address"><br><br>
    Join Date: <input type="date" name="joindate"><br><br>
    Rating: <input type="number" name="rating"><br><br>
    Fees: <input type="number" name="fees"><br><br>
    Cases Won: <input type="number" name="caseswon"><br><br>
    Image Blob: <input type="file" name="imageblob"><br><br> 

    <input type="submit" name="submit" value="Submit">
</form>

<?php
@include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $contactnumber = $_POST['contactnumber'];
    $email = $_POST['email'];
    $specialization = $_POST['specialization'];
    $barassociationmembership = $_POST['barassociationmembership'];
    $qualifications = $_POST['qualifications'];
    $address = $_POST['address'];
    $joindate = $_POST['joindate'];
    $rating = $_POST['rating'];
    $fees = $_POST['fees'];
    $caseswon = $_POST['caseswon'];

    
    $imagePath = ''; 

    // SQL query to insert data into the lawyers table
    $query = "INSERT INTO lawyers (firstname, lastname, contactnumber, email, specialization, barassociationmembership, qualifications, address, joindate, rating, fees, caseswon, imageblob) VALUES ('$firstname', '$lastname', '$contactnumber', '$email', '$specialization', '$barassociationmembership', '$qualifications', '$address', '$joindate', $rating, $fees, $caseswon, '$imagePath')";

    $result = pg_query($connection, $query);

    if ($result) {
        header("Location: admin_page.php");
        exit();
        } else {
        echo "Error: " . pg_last_error($connection);
    }
}
?>

</body>
</html>
