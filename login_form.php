<?php
session_start();

// Redirect if the user is already logged in
if (isset($_SESSION['user_email'])) {
    header('location: home.php');
    exit();
}

@include 'config.php';

if (isset($_POST['submit'])) {
    $email = pg_escape_string($connection, $_POST['email']);
    $pass = md5($_POST['password']); // Hashing password for comparison

    $select = "SELECT * FROM Clients WHERE email = '$email' AND password = '$pass'";
    $result = pg_query($connection, $select);
   

    if ($result) {
        $num_rows = pg_num_rows($result);
        if ($num_rows > 0) {

            $row = pg_fetch_assoc($result);
            $insert="INSERT INTO loginuser (clientid, login_time, username) SELECT clientid, CURRENT_TIMESTAMP, name FROM Clients WHERE email = '$email'";
            $result1 = pg_query($connection, $insert);
            $_SESSION['user_email'] = $row['email'];
            $_SESSION['user_type'] = $row['user_type'];

            
            header('location: home.php');
            exit;
        } else {
            $error[] = 'Incorrect email or password!';
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
    <title>Login Form</title>

    <link rel="stylesheet" href="css/style.css">
   
</head>

<body>

    <div class="form-container">

        <form action="" method="post">
            <h3>Login Now</h3>
            <?php
            if (isset($error)) {
                foreach ($error as $error_msg) {
                    echo '<span class="error-msg">' . $error_msg . '</span>';
                };
            };
            ?>
            <input type="email" name="email" required placeholder="Enter your email">
            <input type="password" name="password" required placeholder="Enter your password">
            <input type="submit" name="submit" value="Login Now" class="form-btn">
            <p>Are you a lawyer? <a href="lawyer_login.php">Login as lawyer</a></p>
            <p>Don't have an account? <a href="register_form.php">Register Now</a></p>
        </form>

    </div>

</body>

</html>
