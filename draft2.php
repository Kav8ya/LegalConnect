<!DOCTYPE html>
<html lang="en">
<head>
    <title>Acknowledgement</title>
    <link rel="stylesheet" href="law_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
                text-align:center;
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

                </div>
            </nav>
            <button><a href="#">Log Out</a></button>
        </header><br><br>
        <div class="footer">
        <footer>
            <div class="footerButton" >
                <p>Copyright &copy;2023; Designed by <span class="designer">legalconnectors</span></p>
            </div>
        </footer>
        </div>
    <?php
    session_start();

    include 'config.php';
    if (isset($_SESSION['user_email'])) {
        $email = $_SESSION['user_email'];
        
    } 
    

    $cid1="SELECT clientid FROM clients WHERE email = '$email'";
    $res1=pg_query($connection,$cid1);
    $cid=pg_fetch_assoc($res1);
    $client=$cid['clientid'];
    $id= $_GET["id"];
    if($_SERVER["REQUEST_METHOD"]=="POST"){
        $date=$_POST["date"];
        $time=$_POST['time'];
        $check=pg_query($connection,"select count(status) from appointment where service_id=$id and date='$date' and time='$time' and status='free'");
        $check1=pg_fetch_assoc($check);
        if($check1['count']==0){
            echo "<div class='t1'>Opps! Booking failed!<br>Try entering valid date and time :(</div><br>";
            echo "<button><a href='draft1.php?id=$id'> BACK</a></button>";
        }else{
            $up=pg_query($connection,"update appointment set status='booked',client_id=$client where service_id=$id and date='$date' and time='$time'");
            //echo "done";
            $query="select firstname,lastname from Lawyers where lawyerID=$id";
            $result=pg_query($connection,$query);
            //echo "got";
            $row=pg_fetch_assoc($result);
            $first=$row['firstname'];
            $last=$row['lastname'];
            echo "<div class='t1'>Lawyer:  $first $last</div><br>";
            echo "<div class='t1'>Date and Time:<br>$date<br>$time</div><br>";
            echo "<div class='t1'>Appointment Booked !</div><br>";  
            echo "<button><a href='draft.php?id=$id'> BACK</a></button>";
        } 
    }
    ?>
</body>
</html>