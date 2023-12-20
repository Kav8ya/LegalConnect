<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_email'])) {
    header('location: login_form.php');
    exit();
}

@include 'config.php';

// Fetch user details based on the logged-in session data
$userEmail = $_SESSION['user_email']; // Assuming same email for both user types

$query = "SELECT * FROM Clients WHERE email = '$userEmail'";
$result = pg_query($connection, $query);

if (!$result) {
    die("Database query failed");
}

// Initialize variables to hold user details
$name = '';
$email = '';
// Other user details...

if ($row = pg_fetch_assoc($result)) {
    // Assign user details from the database to variables
    $name = $row['name'];
    $email = $row['email'];
    $contact = $row['contactnumber'];
    $address = $row['address'];
    // Assign other user details...

    // Check if the form is submitted for updating user details
    if (isset($_POST['submit'])) {
        // Retrieve updated values from the form
        $newName = pg_escape_string($connection, $_POST['name']);
        $newEmail = pg_escape_string($connection, $_POST['email']);
        $newcontact = pg_escape_string($connection, $_POST['number']);
        $newaddress = pg_escape_string($connection, $_POST['address']);

        // Retrieve other updated user details...

        // Update the user details in the database
        $updateQuery = "UPDATE Clients SET name = '$newName', email = '$newEmail',contactnumber = '$newcontact',address = '$newaddress' WHERE email = '$userEmail'";
        $updateResult = pg_query($connection, $updateQuery);

        if (!$updateResult) {
            die("Update query failed");
        }

        // Redirect to account page to display updated details
        header('location: user_page.php');
        exit();
    }

    // Check if the user wants to delete the account
    if (isset($_POST['delete'])) {
        $deleteQuery = "DELETE FROM Clients WHERE email = '$userEmail'";
        $deleteResult = pg_query($connection, $deleteQuery);

        if (!$deleteResult) {
            die("Delete query failed");
        }

        // Destroy session and redirect to login page after account deletion
        session_unset();
        session_destroy();
        header('location: login_form.php');
        exit();
    }
} else {
    echo "User details not found";
}

// Close the database connection

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Account</title>
   <link rel="stylesheet" href="user_page.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <div class="back">
    <a href="home.php"><div class="arrow"></div></a>
    </div>
    
    <div class="container">
        <h1>User Account Details</h1>
</div><br><br>
    <div class="container">
        <p><strong>Name:</strong> <span><?php echo htmlspecialchars($name); ?></span></p>
        <p><strong>Email:</strong> <span><?php echo htmlspecialchars($email); ?></span></p>
        <p><strong>Contact</strong> <span><?php echo htmlspecialchars($contact); ?></span></p>
        <p><strong>Number:</strong> <span><?php echo htmlspecialchars($address); ?></span></p>
        <form method="post">
            <input type="submit" name="edit" value="Edit">
            <input type="submit" name="delete" value="Delete Account">
    </form>
    <?php if (isset($_POST['edit'])) { ?>
        <div class="edit-container">
            <h2>Edit Account Details</h2>
            <form method="post">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" required>
                <br>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required><br>
                <label for="number">contactnumber:</label>
                <input type="number" id="number" name="number" value="<?php echo htmlspecialchars($contactnumber); ?>" required><br>
                <label for="address">Address:</label>
                <input type="address" id="address" name="address" value="<?php echo htmlspecialchars($address); ?>" required><br>

                <!-- Other input fields for additional user details... -->

                <input type="submit" name="submit" value="Update">
            </form>
        </div>
    <?php } ?>
        <!-- Display other user details... -->
    </div><br>
    
    <?php
    $id = $row['clientid'];
    $fetch="select * from appointment where client_id='$id'";
    $fetchres=pg_query($connection,$fetch);
    //if($fetchres){echo "got";}
    echo "<div class='container'>";
    echo "<table>";
    echo "<table border='1'>";
    echo "<tr>";
    echo "<th>First Name</th>";
    echo "<th>Last Name</th>";
    echo "<th>Time</th>";
    echo "<th>Date</th>";
    echo "<th>Cancel</th>";
    echo "</tr>";

    if($fetchres){
        while($fetchrow=pg_fetch_assoc($fetchres)){
            echo "<tr>";
            $lid=$fetchrow['service_id'];
            $query="select firstname,lastname from Lawyers where lawyerid=$lid";
            $result=pg_query($connection,$query);
            $row1=pg_fetch_assoc($result);
            echo "<td>" . $row1['firstname'] . "</td>";
            echo "<td>" . $row1['lastname'] . "</td>";
            echo "<td>" . $fetchrow['time'] . "</td>";
            echo "<td>" . $fetchrow['date'] . "</td>";
            echo "<td><a href='cancel.php?id=" . $fetchrow['app_id'] . "'>Cancel</a></td>";
            echo "</tr>";
                }
    }else{
        echo "<p>No appointments are booked</p>";
    }
    pg_close($connection);
    ?>
    </div><br><br>
    

</body>
</html>
