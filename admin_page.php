<?php

@include 'config.php';

session_start();

if (!isset($_SESSION['user_email'])) {
    header('location: login_form.php'); 
    exit();
}?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="admin.css">
</head>
<body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('.counter').each(function () {
            $(this).prop('Counter', 0).animate({
                Counter: $(this).text()
            }, {
                duration: 4000,
                easing: 'swing',
                step: function (now) {
                    $(this).text(Math.ceil(now));
                }
            });
        });
    });
</script>
    <nav class="menu" tabindex="0">
	<div class="smartphone-menu-trigger"></div>
  <header class="avatar">
    <h2>LEGAL CONNECT</h2>
    <h4>CONNECT !HARD </h4>
  </header>
	<ul>
    <li tabindex="0" class="icon-users"><span><a href="home.php">Home</a></span></li>

    <li tabindex="0" class="icon-users"><span><a href="lawyer_rud.php">Lawyer - RUD</a></span></li>
    <li tabindex="0" class="icon-users"><span><a href="insert_lawyer.php">Insert Lawyer</a></span></li>
    <li tabindex="0" class="icon-users"><span><a href="writer_rud.php">writer - RUD</a></span></li>
    <li tabindex="0" class="icon-users"><span><a href="insert_writer.php">Insert Document Writer</a></span></li>
    
  </ul>
</nav>

<main>
  <div class="helper">
    
 
    <?php
    $current_date = date("Y-m-d"); 

    $queryLoggedInClients = "SELECT c.*, l.login_time 
            FROM Clients c
            JOIN loginuser l ON c.clientid = l.clientid
            WHERE DATE(l.login_time) = '$current_date'";
    $resultLoggedInClients = pg_query($connection, $queryLoggedInClients);

if (!$resultLoggedInClients) {
    die("Database query failed");
}

$queryCustomersCount = "SELECT COUNT(*) AS customer_count FROM site_review";
$resultCustomersCount = pg_query($connection, $queryCustomersCount);
$rowCustomersCount = pg_fetch_assoc($resultCustomersCount);
$customerCount = $rowCustomersCount['customer_count'];

$queryRegisteredLawyersCount = "SELECT COUNT(*) AS registered_lawyer_count FROM registeredlawyer";
$resultRegisteredLawyersCount = pg_query($connection, $queryRegisteredLawyersCount);
$rowRegisteredLawyersCount = pg_fetch_assoc($resultRegisteredLawyersCount);
$registeredLawyerCount = $rowRegisteredLawyersCount['registered_lawyer_count'];

$queryLawyersCount = "SELECT COUNT(*) AS lawyer_count FROM lawyers";
$resultLawyersCount = pg_query($connection, $queryLawyersCount);
$rowLawyersCount = pg_fetch_assoc($resultLawyersCount);
$lawyerCount = $rowLawyersCount['lawyer_count'];

$queryWritersCount = "SELECT COUNT(*) AS writer_count FROM documentwriters";
$resultWritersCount = pg_query($connection, $queryWritersCount);
$rowWritersCount = pg_fetch_assoc($resultWritersCount);
$writerCount = $rowWritersCount['writer_count'];

echo '<div class="containercount">';
    echo '<div class="row">';
        
        echo '<div class="four col-md-3">';
        echo '<div class="counter-box colored">';
        echo '<i class="fa fa-thumbs-o-up"></i>';
        echo '<span class="counter">' . $customerCount . '</span>';
        echo '<p>Happy Customers</p>';
        echo '</div>';
        echo '</div>';
        
        echo '<div class="four col-md-3">';
        echo '<div class="counter-box colored">';
        echo '<i class="fa fa-group"></i>';
        echo '<span class="counter">' . $registeredLawyerCount. '</span>';
        echo '<p>Registered Lawyers</p>';
        echo '</div>';
        echo '</div>';
        
        echo '<div class="four col-md-3">';
        echo '<div class="counter-box colored">';
        echo '<i class="fa fa-shopping-cart"></i>';
        echo '<span class="counter">' . $lawyerCount . '</span>';
        echo '<p>Experienced Lawyers</p>';
        echo '</div>';
        echo '</div>';
        
        echo '<div class="four col-md-3">';
        echo '<div class="counter-box colored">';
        echo '<i class="fa fa-user"></i>';
        echo '<span class="counter">' . $writerCount . '</span>';
        echo '<p>Document Writers</p>';
        echo '</div>';
        echo '</div>';
        
    echo '</div>';
echo '</div>';



echo "<h3>Clients those who are logged in Today</h3>";
echo "<div class='container'>";
echo "<ul class='responsive-table'>";
echo "<li class='table-header'>";
echo "<div class='col col-1'>Client Name</div>";
echo "<div class='col col-2'>Email</div>";
echo "<div class='col col-3'>Contact</div>";
echo "<div class='col col-4'>Logged</div>";
echo "</li>";


while ($row = pg_fetch_assoc($resultLoggedInClients)) {
    echo "<li class='table-row'>";
    echo "<div class='col col-1' data-label='Job Id'>" . $row['name'] . "</div>"; 
    echo "<div class='col col-2' data-label='Customer Name'>" . $row['email'] . "</div>"; 
    echo "<div class='col col-3' data-label='Amount'>" . $row['contactnumber'] . "</div>";  
    echo "<div class='col col-4' data-label='Payment Status'>" . $row['login_time'] . "</div>";
    echo " </li>";
    
    
}

echo "</ul></div>";

?>
 </div>
</main>
</body>
</html>


   