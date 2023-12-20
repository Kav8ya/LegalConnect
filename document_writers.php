<?php
session_start();


if (!isset($_SESSION['user_email'])) {
    header('location: login_form.php'); 
    exit();
}

@include 'config.php';


$id = isset($_POST["writerid"]) ? $_POST["writerid"] : "";
$selectedProduct = isset($_POST["specialization"]) ? $_POST["specialization"] : "";
$selectedFees = isset($_POST["Fees"]) ? $_POST["Fees"] : "";
$selectedRating = isset($_POST["rating"]) ? $_POST["rating"] : "";

$query = "SELECT firstname || ' ' || lastname as name,writerid, imageblob, email, contactnumber FROM DocumentWriters WHERE 1=1";

if (!empty($id)) {
    $query .= " AND writerid = '$id'";
}
if (!empty($selectedProduct)) {
    $query .= " AND specialization = '$selectedProduct'";
}

if (!empty($selectedFees)) {
    $query .= " AND fees = '$selectedFees'";
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
    margin-right:10 px;
    margin-left:10 px;

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
                <li <?php if (basename($_SERVER['PHP_SELF']) == 'user.php') echo 'class="active"'; ?>>
                    <a href="user.php">Account</a>
                </li>
            </ul>
        </div>
        </nav>
        <button><a href="logout.php">Log Out</a></button>
    </header>
    <div class="formstyle">
    <form id="myForm" action="document_writers.php" method="post">
        <label for="specialization">Specialization:</label>
        <select id="specialization" name="specialization" onchange="submitFormOnChange()">
            <option value="">all</option>
            <option value="Screenwriting">Screenwriting</option>
            <option value="Academic Writing">Academic Writing</option>
            <option value="Copywriting">Copywriting</option>
            <option value="Legal Writing">Legal Writing</option>
            <option value="Fiction Writing">Fiction Writing</option>
            <option value="Ghostwriting">Ghostwriting</option>
            <option value="Technical Writing">Technical Writing</option> 
        </select>

        <label for="Fees">Fees:</label>
        <select id="Fees" name="Fees" onchange="submitFormOnChange()">
            <option value="">all</option>
            <option value="$180/page">$180/page</option>
            <option value="$120/page">$120/page</option>
            <option value="$150/page">$150/page</option>
            <option value="$200/page">$200/page</option>
            <option value="$300/page">$300/page</option>
            <option value="$220/page">$220/page</option>
            <option value="$250/page">$250/page</option>
            
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
        $lid=$provider['writerid'];
        echo '<div class="provider-card">';
        echo "<a href='document_display.php?id=$lid'><img src='1.png' alt='Provider Image' style='max-width: 100%; height: auto;'></a>";

        echo '<p><span>Name:</span> ' . $provider['name'] . '</p>';
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


