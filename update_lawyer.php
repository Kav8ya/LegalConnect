<?php
@include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $lawyerid = $_GET['id'];

    // Query to select the specific lawyer details based on the lawyerid
    $query = "SELECT * FROM lawyers WHERE lawyerid = $lawyerid";
    $result = pg_query($connection, $query);

    if (pg_num_rows($result) > 0) {
        $lawyer = pg_fetch_assoc($result); // Fetch the lawyer details
    } else {
        echo "Lawyer not found";
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
    $barassociationmembership = $_POST['barassociationmembership'];
    $qualifications = $_POST['qualifications'];
    $address = $_POST['address'];
    $joindate = $_POST['joindate'];
    $rating = $_POST['rating'];
    $fees = $_POST['fees'];
    $caseswon = $_POST['caseswon'];
    // Extract other fields here...

    // Query to update lawyer details
    $updateQuery = "UPDATE lawyers SET firstname = '$firstname', lastname = '$lastname', contactnumber = '$contactnumber', email = '$email', specialization = '$specialization', barassociationmembership = '$barassociationmembership', qualifications = '$qualifications', address = '$address', joindate = '$joindate', rating = '$rating', fees = '$fees', caseswon = '$caseswon' WHERE lawyerid = $lawyerid";
    $updateResult = pg_query($connection, $updateQuery);

    if ($updateResult) {
        echo "Lawyer details updated successfully";
        // Redirect or perform actions after update
    } else {
        echo "Error updating lawyer details: " . pg_last_error($connection);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Lawyer</title>
</head>
<body>

<h2>Edit Lawyer</h2>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?id=<?php echo $lawyerid; ?>" method="post">
    First Name: <input type="text" name="firstname" value="<?php echo $lawyer['firstname']; ?>"><br><br>
    Last Name: <input type="text" name="lastname" value="<?php echo $lawyer['lastname']; ?>"><br><br>
    Contact Number: <input type="text" name="contactnumber" value="<?php echo $lawyer['contactnumber']; ?>"><br><br>
    Email: <input type="text" name="email" value="<?php echo $lawyer['email']; ?>"><br><br>
    Specialization: <input type="text" name="specialization" value="<?php echo $lawyer['specialization']; ?>"><br><br>
    Bar Association Membership: <input type="text" name="barassociationmembership" value="<?php echo $lawyer['barassociationmembership']; ?>"><br><br>
    Qualifications: <input type="text" name="qualifications" value="<?php echo $lawyer['qualifications']; ?>"><br><br>
    Address: <input type="text" name="address" value="<?php echo $lawyer['address']; ?>"><br><br>
    Join Date: <input type="date" name="joindate" value="<?php echo $lawyer['joindate']; ?>"><br><br>
    Rating: <input type="number" name="rating" value="<?php echo $lawyer['rating']; ?>"><br><br>
    Fees: <input type="number" name="fees" value="<?php echo $lawyer['fees']; ?>"><br><br>
    Cases Won: <input type="number" name="caseswon" value="<?php echo $lawyer['caseswon']; ?>"><br><br>
    <!-- Other fields to edit... -->

    <input type="submit" name="submit" value="Update">
</form>

</body>
</html>
