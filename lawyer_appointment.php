<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Slot</title>
    <link rel="stylesheet" href="law_style.css">
    <style>
        .t1{
                border-radius:10px;
                width:80%;
                margin:auto;
                background-color:white;
                padding: 30px;  
                font-size: large;  
            }
            .t6{
                border-radius:10px;
                width:83%;
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
            <li></li>
            <li></li>
            <li></li>
            <li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>

            </div>
        </nav>
        <button><a href="logout.php">Log Out</a></button>
    </header>
    <div class='two'>
        <div class='left_l'>
    <h1>Update Slot</h1><br><div class='t1'>

    <form action="slots_update.php" method="post">
        <label for="slot_date">Select Date:</label>
        <input type="date" id="slot_date" name="slot_date" required><br><br>
        
        <label for="slot_time">Select Time:</label>
        <input type="time" id="slot_time" name="slot_time" required><br><br>
        
        <input class='b1' type="submit" name="submit" value="Update Slot">
    </form></div>
        </div>
        <div class='right_l'>
<?php
session_start();

include 'config.php';
if (isset($_SESSION['lawyer_email'])) {
    $lawyerEmail = $_SESSION['lawyer_email'];
    
} 

$email = $_SESSION['lawyer_email'];

$query = "SELECT appointment.time, appointment.date, appointment.client_id 
          FROM appointment 
          WHERE appointment.service_id = (SELECT lawyers.lawyerid FROM lawyers WHERE lawyers.email = '$email') AND status = 'booked'";

$result = pg_query($connection, $query);
echo "<h1>Booked Appointments</h1><br>";
if ($result) {
    while ($row = pg_fetch_assoc($result)) {
        $clientID = $row['client_id'];

        $clientQuery = "SELECT * FROM clients WHERE clientid = $clientID";
        $clientResult = pg_query($connection, $clientQuery);

        if ($clientResult) {
            $clientDetails = pg_fetch_assoc($clientResult);
            echo "<div class='t1'>Time: " . $row['time'] . "<br>";
            echo "Date: " . $row['date'] . "<br>";
            // echo "Client ID: " . $row['client_id'] . "<br>";
            echo "Client Name: " . $clientDetails['name'] . "<br>";
            echo "Client Email: " . $clientDetails['email'] . "<br>";
            echo "Client Contact: " . $clientDetails['contactnumber'] . "</div><br>";

        } else {
            echo "Error fetching client details: " . pg_last_error($connection);
        }
    }
} else {
    echo "<div class='t1'><p>No slots are booked.</p><div>";
}
pg_close($connection);
?>
</div>
</div>
    <div class='footer'>
    <footer>
        <div class="footerButton" >
            <p>Copyright &copy;2023; Designed by <span class="designer">legalconnectors</span></p>
        </div>
    </footer>
</div>
</body>
</html>