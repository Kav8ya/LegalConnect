<?php 
@include 'config.php';
session_start();

if (!isset($_SESSION['user_email'])) {
    header('Location: login_form.php');

    exit();
}

$user_email = $_SESSION['user_email'];

$sql = "SELECT clientid, name FROM Clients WHERE email = '$user_email'"; 

$result = pg_query($connection, $sql);

if ($result) {
    
    $row = pg_fetch_assoc($result);
    $user_id = $row["clientid"];
    $user_name = $row["name"];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $review = $_POST['review'];
        $rating = $_POST['rating'];

        $insert_sql = "INSERT INTO site_review (client_id, client_name, review, rating) VALUES ($user_id, '$user_name', '$review', $rating)";

        $insert_result = pg_query($connection, $insert_sql);
        if ($insert_result) {
            header('Location: login_form.php');
        } else {
            echo "Error: " . pg_last_error($conn);
        }
    }
} else {
    echo "User not found";
}

pg_close($connection);
?>


<!DOCTYPE html>
<html>
    <head>
        <title>Lawyer Review Form</title>
        <link rel="stylesheet" href="law_style.css">
        <style>
            .t1{
                border-radius:10px;
                width:47%;
                margin:auto;
                background-color:white;
                padding: 30px;  
                font-size: large;  
            }
            .t5{text-align:center;}
            body{
                background-color: #e5e6e8;
            }
            h1,button{text-align:center;}
            label{margin-left:80px;}
            input{margin-left:80px;text-align:center;}
            .input-box {
                width: 300px;
                height: 50px;
            }
            .footer {
                position: fixed;
                left: 0;
                bottom: 0;
                width: 100%;
            }
        </style>
</head>
<body>
    <header>
        <div class="logo">
            <p><img src="Screenshot_2023-12-01_114245-removebg-preview.png" alt="Website logo" width="200" height="80"></p>
        </div>
        <nav >
            <div>
                <li><a href="home.php">Home</a></li>
                <li><a href="home.php?id=About">About Us</a></li>
                <li><a href="home.php?id=law">Services</a></li>
                <li><a href="home.php?id=contact">Contact</a></li>
                <li><a href="home.php?id=review">Reviews</a></li>
                <li><a href="user_page.php">Account</a></li>

            </div>
        </nav>
        <button><a href="#">Log Out</a></button>
    </header>
    <h1>Give us your reviews :)</h1><br>
    <form action='' method='POST' >
        <div class='t1'>
            <label for='review'>REVIEW :</label>
			<input class='input-box' type='text' id='review' name='review' placeholder='Your review' required>
        </div><br>
        <div class='t1'>
            <label for='rating'>RATING :</label>
			<input class='input-box' type='number' id='rating' name='rating' placeholder='Your rating' min='1' max='10' required>
        </div><br><br>
        <div class='t5'>
            <button type='submit'>Done!</button>
        </div>
    </form>
    <div class="footer">
    <footer>
        <div class="footerButton" >
            <p>Copyright &copy;2023; Designed by <span class="designer">legalconnectors</span></p>
        </div>
    </footer>
    </div>

</body>
</html>