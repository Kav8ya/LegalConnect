<?php

@include 'config.php';

if (isset($_POST['submit'])) {
    $name = pg_escape_string($connection, $_POST['name']);
    $email = pg_escape_string($connection, $_POST['email']);
    $pass = md5($_POST['password']);
    $cpass = md5($_POST['cpassword']);
    $number = pg_escape_string($connection, $_POST['number']);
    $address = pg_escape_string($connection, $_POST['address']);

    $user_type = $_POST['user_type'];

    $select = "SELECT * FROM Clients WHERE email = '$email' AND password = '$pass'";
    $result = pg_query($connection, $select);

    if ($result) {
        $num_rows = pg_num_rows($result);

        if ($num_rows > 0) {
            $error[] = 'User already exists!';
        } else {
            if ($pass != $cpass) {
                $error[] = 'Passwords do not match!';
            } else {
                $insert = "INSERT INTO Clients(name, email, password,contactnumber, address, user_type) 
                           VALUES('$name','$email','$pass','$number','$address','$user_type')";
                $insert_result = pg_query($connection, $insert);

                if ($insert_result) {
                    header('location:login_form.php');
                    exit;
                } else {
                    $error[] = 'Error in inserting user data!';
                }
            }
        }
    } else {
        $error[] = 'Query execution error!';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Form</title>

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">

</head>

<body>

    <div class="form-container">

        <form action="" method="post">
            <h3>Register Now</h3>
            <?php
            if (isset($error)) {
                foreach ($error as $error_msg) {
                    echo '<span class="error-msg">' . $error_msg . '</span>';
                };
            };
            ?>
            <input type="text" name="name" required placeholder="Enter your name">
            <input type="email" name="email" required placeholder="Enter your email">
            <input type="password" name="password" required placeholder="Enter your password">
            <input type="password" name="cpassword" required placeholder="Confirm your password">
            <input type="number" name="number" required placeholder="Enter your number">
            <input type="text" name="address" required placeholder="Enter your address">
            <select name="user_type">
                <option value="user">User</option>
                <!-- <option value="admin">Admin</option> -->
            </select>
            <input type="submit" name="submit" value="Register Now" class="form-btn">
            <p>Already have an account? <a href="login_form.php">Login Now</a></p>
        </form>

    </div>

</body>

</html>
