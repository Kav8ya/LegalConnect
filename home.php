<?php
session_start();

$loggedIn = isset($_SESSION['user_email']);
$userType = $_SESSION['user_type'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="home.css">
</head>
<style>
      .section {
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: space-between;
    max-width: 90%;
    margin: 0 auto;
    padding: 50px; /* Added padding for space */
  }

  .text {
    flex: 1;
    margin-right: 20px;
    font-size: 18px; /* Increased text size */
    line-height: 1.5;
    margin-bottom: 20px; 
    padding-left: 60px; /* Added margin between text and image */
  }

  .image {
    flex: 1;
    text-align: right;
  }

  .image img {
    max-width: 100%;
    height: auto;
    display: block; /* Ensures image does not have extra space below */
    margin-top: 20px; 
    padding-left: 190px; /* Increased space between image and text */
  }

  .text p {
    color: #333; /* Text color */
    transition: color 0.3s ease; 
    /* Smooth color transition on hover */
  }

 

  .text h2 {
    font-size: 24px;
    margin-bottom: 10px;
    color: #000; /* Title color */
  }
  .ya{
    width:14%;
    margin:auto;
    text-align: center;
  }

</style>
<body style="background-color: #e5e6e8;">
    <header>
        <div class="logo">
            <p><img src="Screenshot_2023-12-01_114245-removebg-preview.png" alt="Website logo" width="200" height="80"></p>
        </div>
        <nav>
            <div>
                <li><a href="home.php">Home</a></li>
                <li><a href="#About">About Us</a></li>
                <li><a href="#services">Services</a></li>
                <li><a href="#contact">Contact</a></li>
                <li><a href="#review">Reviews</a></li>
            
                <?php if ($loggedIn) { ?>
                <?php if ($userType === 'admin') { ?>
                    <li><a href="admin_page.php">Admin</a></li>
                <?php } else { ?>
                    <li><a href="user_page.php">Account</a></li>
                <?php } ?>
                <?php } ?>
            </div>
        </nav>
        
        <?php if ($loggedIn) { ?>
        <button><a href="logout.php">Logout</a></button>
        <?php } else { ?>
        <button><a href="login_form.php">Get started</a></button>
        <?php } ?>
    </header>
    <div class='empty'></div>

<div class='i'>

</div>
    <br><br><br><br>

    <div class='s'>
        <center>
            <h1>Shaping India’s legal past, present and future</h1>
        </center>
    </div>
    <br><br><br>
    <div class="section">
  <div id="services" class="text">
    <h2>Lawyers</h2>
    
    <p>Our pillars of success are grounded in our century-old heritage and legacy. Our goodwill and motto to provide pragmatic commercial solutions, and exceptional service, to our clients continually drive us to create meaningful and long-term impact.</p>
    <br>
    <a style="color: #d2652d;font-weight:bolder;" href="lawyer.php">Check it out...</a>
    
  </div>
  <div class="image">
    <img src="https://wallpapercave.com/wp/wp4332844.jpg" alt="Image description" width='650px' height='500px'>
  </div>
</div>

<!-- Additional section -->
<div class="section">
  <div class="image">
    <img src="https://content3.jdmagicbox.com/comp/def_content/document-writers/document-writers-document-writers-2-xemza.jpg?clr=" width='550px;'height='450px' alt="Image description"> <!-- Placeholder image, replace with your image URL -->
  </div>
  <div class="text">
    <h2>Legal Document Drafting</h2>
    
    <p>Our document writers are adept at drafting a wide array of legal documents, including contracts, agreements, legal notices, affidavits, and more. Their meticulous attention to detail ensures that every document aligns with legal standards and effectively represents our clients' interests.</p>
    <br>
    
    <a style="color: #d2652d;font-weight:bolder;"href="document_writers.php">Check it out...</a>
    

    
</div>
</div>
        
        <div class="flex-container">
            <div class="box">
                <pre>🕐
                    <h3> Always On Time</h3></pre>
            </div>
            <span></span><span></span>
            <div class="box">
                <pre>✔️
                    <h3>Hard Working</pre>
            </div>
            <span></span><span></span>
            <div class="box">
                <pre> 📅
                    <h3>24/7 Availability</h3></pre>
            </div>
            <span></span>
        </div>
        <br><br><br>

    </div>
    <hr>
    <br>
    <div id="About">
        <div class='bottom'>
            <div class="q">
                <p>
                    <pre>
                        <h1><center>WE ARE YOUR PROGRESSIVE LAW PATRNER</center></h1><br>
                        <center><p>Our approach to delivering law services is different. We are laser-focused on meeting your need<br> to get results while managing your bottom line.<br>Our modern,streamlined and tech enabled structure is client focused.<br><br><br><h2>Because YOUR BUSINESS IS OUR BUSINESS</h2></p></center>
                </p>
            </div>
        </div>
        <hr>
        <br>
        <br>

    </div>

    <?php
    @include 'config.php';
    $sql = "SELECT client_name, review, rating FROM site_review";

    $result = pg_query($connection, $sql);

    if ($result) {
        
        echo "<div id='review'>";
        echo "<h1>Client Reviews:</h1>";
        while ($row = pg_fetch_assoc($result)) {
            echo "<figure class='snip1533'>";
                echo "<figcaption>";
                    echo "<blockquote>";
                        echo "<p>". $row['review'] ."</p>";
                    echo "</blockquote>";
                        echo "<h3>".$row['client_name']."</h3>";
            
                echo "</figcaption>";
            echo "</figure>";
           
        }
    }
    echo "</div>";


    $avg_sql = "SELECT AVG(rating) AS average_rating FROM site_review ORDER BY random() LIMIT 2;";
    $avg_result = pg_query($connection, $avg_sql);
    

    
    if ($avg_result) {
        $avg_row = pg_fetch_assoc($avg_result);
        $average_rating = round($avg_row['average_rating'], 2);

        echo "<h2>Average Rating: $average_rating</h2>";
    } else {
        echo "Error fetching average rating: " . pg_last_error($connection);
    }


pg_close($connection);
?>
        <br>
        <div class='ya'>
            <button class='review' style="text-align:center" type="submit"><a href='site_review.php'>Give your review :)</a></button><br>
        </div><br> <br>
        <div id="About">       
        

        <footer id="contact">
            <div class="footerNav">
                <ul>
                    <li><a href="home.php">Home</a></li>
                    <li><a href="#About">About Us</a></li>
                <li><a href="#services">Services</a></li>
                    <li><a href="home.php">Get started</a></li>
                    <li><a style ="text-align: center" href="mailto:legalconnect3@gmail.com">Contact Us</a></li>
                </ul>
            </div>
        
        <div class="footerButton">
            <p>Copyright &copy;2023; Designed by <span class="designer">legalconnectors</span></p>
        </div>
        </footer>
    </div>
</body>
</html>
