<?php 
@include 'config.php';
session_start();

if (!isset($_SESSION['user_email'])) {
    header('location: login_form.php'); 
    exit();
}


$id = isset($_POST["lawyerid"]) ? $_POST["lawyerid"] : "";
$selectedProduct = isset($_POST["specialization"]) ? $_POST["specialization"] : "";
$selectedFees = isset($_POST["Fees"]) ? $_POST["Fees"] : "";
$selectedBarAssociation = isset($_POST["barassociationmembership"]) ? $_POST["barassociationmembership"] : "";
$selectedRating = isset($_POST["rating"]) ? $_POST["rating"] : "";

$query = "SELECT firstname || ' ' || lastname as name, imageblob, email, contactnumber,lawyerid FROM Lawyers WHERE 1=1";

if (!empty($id)) {
    $query .= " AND lawyerid = '$id'";
}

if (!empty($selectedProduct)) {
    $query .= " AND specialization = '$selectedProduct'";
}

if (!empty($selectedFees)) {
    $query .= " AND fees = '$selectedFees'";
}

if (!empty($selectedBarAssociation)) {
    $query .= " AND barassociationmembership = '$selectedBarAssociation'";
}

if (!empty($selectedRating)) {
    $query .= " AND rating >= $selectedRating";
}

$result = pg_query($connection, $query);

if (!$result) {
    die("Query execution failed: " . pg_last_error($connection));
}

$providers = pg_fetch_all($result);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="navbar.css">
    <style>
        .grid-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1.5fr));
            gap: 35px;
            margin: 30px;
            
        }
        .grid-container p{
            font-weight: lighter;
            color:#e04700;
        }
        .grid-container p:hover{
            font-weight: bold;
            color:#e04700;
        }
        .grid-container span{
            font-weight:bold;
            color: #000f23;
        }

        .grid-container img:hover{
            opacity: 0.7;
        }
        .provider-card {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: center;
            background-color: whitesmoke;
            box-shadow: 0 5px 10px #000f23;
        }

        .provider-photo {
            max-width: 100%;
            height: auto;
        }

        body {
    margin: 0;
    padding: 0;
    display: flex;
    flex-direction: column;
    min-height: 100vh; 
}

.main-content {
    flex: 1; 
}
.formstyle{
    width: 100%;
    height: 70px;
    display: flex;
    justify-content: space-around;
    align-items: center;
    padding: 30px 10%;
    background-color:#e04700;
    
    opacity: 0.9;
}
.formstyle option {
    transition: background-color 0.3s ease; 
}

.formstyle option:hover {
    background-color: lightblue; 

}
.formstyle select{
    display: inline-block;
    list-style: none;
    padding: 0px 20px;

 }
 
select {
    padding: 10px; 
    font-size: 16px; 
    border: 1px solid #ccc; 
    border-radius: 5px; 
    background-color: #fff;
    opacity: 0.7; 
    color: #333;
    width: 200px; 
    margin-right:5px;
    margin-left:5 px;

}
select option {
    background-color:#e04700 ; 
    opacity: 0.9;
    color: #333; 
    padding: 8px; 
    
    
}

select option:hover {
    background-color: #f0f0f0; 
    color: #555; 
   
}

/* Style select options when selected */
select option:checked {
    background-color: #e0e0e0; /* Background color when selected */
    color: #000; /* Text color when selected */
    /* Other styles for selected option as desired */
}

    </style>


</head>
<body style="background-color: #e5e6e8;">
    <div class="main-content">
    <header>
        <div class="logo">
            <p><img src="Screenshot_2023-12-01_114245-removebg-preview.png" alt="Website logo" width="200" height="80"></p>
        </div>
        <nav >
        <div>
            <ul>
                <li <?php if (basename($_SERVER['PHP_SELF']) == 'index.php') echo 'class="active"'; ?>>
                    <a href="home.php">Home</a>
                </li>
                <li <?php if (basename($_SERVER['PHP_SELF']) == 'about.php') echo 'class="active"'; ?>>
                    <a href="home.php?id=About">About Us</a>
                </li>
                <li <?php if (basename($_SERVER['PHP_SELF']) == 'display.php') echo 'class="active"'; ?>>
                    <a href="home.php?id=law">Services</a>
                </li>
                <li <?php if (basename($_SERVER['PHP_SELF']) == 'contact.php') echo 'class="active"'; ?>>
                    <a href="home.php?id=contact">Contact</a>
                </li>
                <li <?php if (basename($_SERVER['PHP_SELF']) == 'reviews.php') echo 'class="active"'; ?>>
                    <a href="reviews.php">Reviews</a>
                </li>
                <li <?php if (basename($_SERVER['PHP_SELF']) == 'user_page.php') echo 'class="active"'; ?>>
                    <a href="user">Account</a>
                </li>
            </ul>
        </div>
        </nav>
        <button><a href="logout.php">Log Out</a></button>
    </header>
    <div class="formstyle">
    <form id="myForm" action="lawyer.php" method="post">
        <label for="specialization">Specialization:</label>
        <select id="specialization" name="specialization" onchange="submitFormOnChange()">
            <option value="">all</option>
            <option value="Civil Rights Law">Civil Rights Law</option>
            <option value="Immigration Law">Immigration Law</option>
            <option value="Corporate Law">Corporate Law</option>
            <option value="Intellectual Property">Intellectual Property</option>
            <option value="Criminal Defense">Criminal Defense</option>
            <option value="Real Estate Law">Real Estate Law</option>
            <option value="Bankruptcy Law">Bankruptcy Law</option>
            <option value="Healthcare Law">Healthcare Law</option>
            <option value="Family Law">Family Law</option>
            <option value="Environmental Law">Environmental Law</option>
            
        </select>
        <label for="Fees">Fees:</label>
        <select id="Fees" name="Fees" onchange="submitFormOnChange()">
            <option value="">all</option>
            <option value="$260/hour">$260/hour</option>
            <option value="$250/hour">$250/hour</option>
            <option value="$300/hour">$300/hour</option>
            <option value="$320/hour">$320/hour</option>
            <option value="$280/hour">$280/hour</option>
            <option value=" $350/hour"> $350/hour</option>
            <option value="$380/hour">$380/hour</option>
            
        </select>
        <label for="barassociationmembership">barassociation:</label>
        <select id="barassociationmembership" name="barassociationmembership" onchange="submitFormOnChange()">
            <option value="">all</option>
            <option value="JKL Bar Association"> JKL Bar Association</option>
            <option value="DEF Bar Association">DEF Bar Association</option>
            <option value="KLM Bar Association">KLM Bar Association</option>
            <option value="UVW Bar Association">STU Bar Association</option>
            <option value="STU Bar Association">STU Bar Association</option>
            <option value="GHI Bar Association">GHI Bar Association</option>
            <option value="XYZ Bar Association">XYZ Bar Association</option>
            <option value="HIJ Bar Association">HIJ Bar Association</option>
            <option value="ABC Bar Association">ABC Bar Association</option>
            <option value="MNO Bar Association">MNO Bar Association</option>
            <option value="PQR Bar Association">PQR Bar Association</option>
            <option value="NOP Bar Association">NOP bar Association</option>
            
        </select>
        <label for="rating">Rating:</label>
        <select id="rating" name="rating" onchange="submitFormOnChange()">
            <option value="">all</option>
            <option value=9>9</option>
            <option value=8>8</option>
            <option value=7>7</option>
            <option value=6>6</option>
            <option value=5>5</option>
            <option value=4>4</option>
            <option value=3>3</option>
    
        </select>
       
    </form>
    </div>
    
    <script>
        
        function submitFormOnChange() {
        document.getElementById("myForm").submit();
        }

        window.onload = function() {
        var specialization1 = '<?php echo $selectedProduct; ?>';
        var fees1 = '<?php echo $selectedFees; ?>';
        var barAssociation1 = '<?php echo $selectedBarAssociation; ?>';
        var rating1 = '<?php echo $selectedRating; ?>';

        document.getElementById('specialization').value = specialization1;
        document.getElementById('Fees').value = fees1;
        document.getElementById('barassociationmembership').value = barAssociation1;
        document.getElementById('rating').value = rating1;
    }
    </script>

    
    <?php
if (isset($providers) && is_array($providers) && !empty($providers)) {
    echo '<div class="grid-container">';
    foreach ($providers as $provider) {
        $lid=$provider['lawyerid'];
        echo '<div class="provider-card">';

        echo "<a href='law_display.php?id=" . $provider['lawyerid'] . "'><img src='" . $provider['imageblob'] . "' alt='Provider Image' style='max-width: 100%; height: auto;'></a>";

        // echo "<a href='law_display.php?id=" . $provider['lawyerid'] . "'><img src='1.png' alt='Provider Image' style='max-width: 100%; height: auto;'></a>";

        // echo "<a href='law_display.php?id=$lid'><img src='1.png' alt='Provider Image' style='max-width: 100%; height: auto';></a>";
        //echo '<p><span>Id:</span> ' . $provider['lawyerid'] . '</p>';
        echo "<p><span>Name:</span>".$provider['name']."</a></p>";
        echo '<p><span>Email:</span> ' . $provider['email'] . '</p>';
        echo '<p><span>Number: </span>' . $provider['contactnumber'] . '</p>';


        echo '</div>';
    }
    echo '</div>';
} else {
    echo "OOPS! None of them are under this condition";
}
?>


<?php
pg_close($connection);
?>
</div>
<footer>
    <div class="footerButton">
        <p>Copyright &copy;2023; Designed by <span class="designer">legalconnectors</span></p>
    </div>
</footer>

</body>
</html>


