<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View</title>
    <link rel="stylesheet" href="law_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>
<body style="background-color: #e5e6e8;">
</head>
<body>
    <?php
    @include 'config.php';
    $id=$_GET['id'];
    if($_SERVER["REQUEST_METHOD"]=="POST"){
        $rat=$_POST["rating"];
        $up=pg_query($connection,"select rating from Lawyers where lawyerID=$id");
        $ans=pg_fetch_assoc($up);
        $cur=$ans['rating'];
        //echo "got";
        $query="call ratin($id,$cur,$rat);";
        $result=pg_query($connection,$query);
        //echo "done";
        
        $rev=$_POST["review"];
        $query="insert into Lawyer_review(lawyer_id,rating,review) values($id,$rat,'$rev');";
        $result=pg_query($connection,$query);
    }
    //echo "Connected successfully";
    $query="select * from Lawyers where lawyerID=$id";
    $result=pg_query($connection,$query);
    //echo "got";
    
    $row=pg_fetch_assoc($result);
    $id=$row['lawyerid'];
    $first=$row['firstname'];
    $last=$row['lastname'];
    $contact=$row['contactnumber'];
    $email=$row['email'];
    $specific=$row['specialization'];
    $member=$row['barassociationmembership'];
    $study=$row['qualifications'];
    $address=$row['address'];
    $join=$row['joindate'];
    $rating=$row['rating'];
    $fees=$row['fees'];
    $won=$row['caseswon'];
    $imgUrl=$row['imageblob'];
    //echo "got";    
    ?>
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
    <div class="main">
        <div class="left">
    
            <?php "<img src=".$imgUrl." alt='soon'>"?>
        </div>
        <div class="mid">
            <div class="title">
                <div><b><?php echo $first." ".$last; ?></b></div>   
            </div><br><br>

            <div class="heading">Specialization:</div>
            <div class="space">
                <?php echo $specific; ?>
            </div>
            <div class="heading"> Qualifications: </div>
            <div class="space">
                <?php echo $study;?>
            </div> 

        </div>
        <div class="right">
            <br>           

            <div class="heading"> Bar Member:</div>
            <div class="space">
                <?php echo $member; ?>
            </div> 
              
            <div class="heading">Average fees:</div>
            <div class="space">
                <?php echo $fees; ?>
            </div>  
            
        </div>
    </div>
    <div class="main2">
        <div class="left1">
            <div class="heading">Practicing Since:</div>
                <div class="space">
                    <?php echo $join; ?>
                </div> 
        </div>
        <div class="mid1">
            <div class="heading">Rating:</div>
                <div class="space">
                    <?php echo $rating."/10 "; ?>
                </div> 
        </div>
        <div class="right1">
            <div class="heading">No. of cases won:</div>
                <div class="space">
                    <?php echo $won; ?>
                </div> 
        </div>
    </div><br>
    <div class="contact">
        <div class="left2">
                <div class="space" style="font-size:x-large">
                    <?php echo "CONTACT:" ?>
                </div> 
        </div>
        <div class="mid1">
            <div class="heading">Email:</div>
                <div class="space">
                    <?php echo $email; ?>
                </div> 
        </div>
        <div class="right1">
            <div class="heading">Phone Number:</div>
                <div class="space">
                    <?php echo $contact; ?>
                </div> 
        </div>
    </div><br><br><br>
    <div class="rev">
        <div class="heading1">REVIEWS:</div>
    <?php 
    $query = "SELECT review FROM Lawyer_review WHERE lawyer_id = $id ORDER BY random() LIMIT 2;";
    $result = pg_query($connection, $query);
    while ($row = pg_fetch_assoc($result)) {
        echo "
        $row[review]<br><br>";
    }
    ?>
    <br></div><br>
    <div style="text-align:center">
            <button type="submit"><?php echo "<a href='lawyer_review_form.php?id=$id'>Give your review :)</a>";?></button>
            <button type="submit"><?php echo "<a href='draft1.php?id=$id'>Book Appointment !</a>";?></button>
        </div><br>
    </form>
    <footer> 
        <div class="footerButton">
            <p>Copyright &copy;2023; Designed by <span class="designer">legalconnectors</span></p>
        </div>
    </footer>
</body>
</html>
