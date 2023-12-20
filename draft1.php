<!DOCTYPE html>
<html lang="en">
<head>
    <title>Appointment</title>
    <link rel="stylesheet" href="law_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
            .t1{
                border-radius:10px;
                width:41%;
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
            /*.footer {
                position: fixed;
                left: 0;
                bottom: 0;
                width: 100%;
            }*/
        </style>
</head>
<body>
    <?php
    @include 'config.php';
    $id= $_GET["id"];
    $query="select firstname,lastname from Lawyers where lawyerID=$id";
    $result=pg_query($connection,$query);
    //echo "got";
    
    $row=pg_fetch_assoc($result);
    $first=$row['firstname'];
    $last=$row['lastname'];?>
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
    </header>
    <h1><?php echo $first." ".$last;?><br><br>
    <div class='t1'>
            AVAILABLE APPOINTMENTS          
            </div><br>
    <?php
    $query="select * from appointment where service_id=$id and status='free'";
    $result=pg_query($connection,$query);
    while($row=pg_fetch_assoc($result)){
        echo "<div class='t1'>
            <table width=100%>
            <tr>
                <td>$row[date]</td><td>$row[time]</td>
            </tr>
            </table>            
            </div><br>";
    }
    echo "
    <form action='draft2.php?id=$id' method='POST' >
        <div class='t6'>
            <label for='review'>DATE :</label>
			<input class='input-box' type='date' id='date' name='date' placeholder='Enter date:' required>
            <label for='rating'>TIMING :</label>
			<input class='input-box' type='time' id='time' name='time' placeholder='Enter timing:' required>
        </div><br>
        <div class='t5'>
            <button type='submit'>Book Appointment !</button>
        </div><br><br>
    </form>";
    ?>
    <div class="footer">
    <footer>
        <div class="footerButton" >
            <p>Copyright &copy;2023; Designed by <span class="designer">legalconnectors</span></p>
        </div>
    </footer>
    </div>
</body>
</html>
