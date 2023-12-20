    
    <?php
    session_start();

    include 'config.php';

    if (isset($_SESSION['lawyer_email'])) {
        $lawyerEmail = $_SESSION['lawyer_email'];
        
        
        $query = "SELECT lawyerid FROM lawyers WHERE email = '$lawyerEmail'";
        $result = pg_query($connection, $query);
        $row = pg_fetch_assoc($result);
        $lawyerId = $row['lawyerid'];

        if (isset($_POST['submit'])) {
            $date = $_POST['slot_date'];
            $time = $_POST['slot_time'];

            $insertQuery = "INSERT INTO appointment (service_id, client_id, time, date, status)
                            VALUES ($lawyerId, NULL, '$time', '$date', 'free')";
            
            $insertResult = pg_query($connection, $insertQuery);
            
            if ($insertResult) {
                echo '<script>alert("Slot updated successfully!");</script>';
                header('location:lawyer_appointment.php');
            } else {
                echo "Error updating slot: " . pg_last_error($connection);
            }
        }
    } else {
        header('location:lawyer_login.php');
    }
    ?>
