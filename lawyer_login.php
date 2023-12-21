<?php
session_start();
if (isset($_SESSION['lawyer_email'])) { 
    header('location: lawyer_appointment.php');
    exit();
}

@include 'config.php';

if (isset($_POST['submit'])) {
    $email = pg_escape_string($connection, $_POST['email']);
    $pass = md5($_POST['password']); 

    $select = "SELECT * FROM registeredlawyer WHERE email_id = '$email' AND password = '$pass'";
    $result = pg_query($connection, $select);
   

    if ($result) {
        $num_rows = pg_num_rows($result);
        if ($num_rows > 0) {

            $row = pg_fetch_assoc($result);
            $result1 = pg_query($connection, $insert);
            $_SESSION['lawyer_email'] = $row['email_id'];
            
            header('location:lawyer_appointment.php');
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

    <!-- custom css file link  -->
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            background-image: url("bgimg.png");
            
        }
    </style>
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
            <p>Don't have an account? <a href="lawyer_register_form.php">Register Now</a></p>
        </form>

    </div>

</body>

</html>
