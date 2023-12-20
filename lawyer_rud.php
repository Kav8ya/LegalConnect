<?php


@include 'config.php';

$searchQuery = '';

if (isset($_GET['search'])) {
    $searchQuery = $_GET['search'];
    $queryLawyers = "SELECT * FROM lawyers WHERE firstname LIKE '%$searchQuery%'";
} else {
    $queryLawyers = "SELECT * FROM lawyers";
}

$resultLawyers = pg_query($connection, $queryLawyers);

if (!$resultLawyers) {
    die("Database query failed");

}
echo "<table>";
echo "<h2>Lawyers</h2>";

?>
<div style="text-align: right;">
<form id="searchForm" action="" method="GET">
    <label for="search">Search Lawyers:</label>
    <input type="text" id="search" name="search" value="<?php echo htmlentities($searchQuery); ?>">
</form>
</div>

<script>
    // JavaScript code to submit the form when input value changes
    document.getElementById('search').addEventListener('input', function() {
        document.getElementById('searchForm').submit();
    });
</script>
<?php
echo "<br>";
echo "<table border='1'>";
echo "<tr>";
echo "<th>ID</th>";
echo "<th>First Name</th>";
echo "<th>Last Name</th>";
echo "<th>Contact Number</th>";
echo "<th>Email</th>";
echo "<th>Specialization</th>";
echo "<th>Bar Association Membership</th>";
echo "<th>Qualifications</th>";
echo "<th>Address</th>";
echo "<th>Join Date</th>";
echo "<th>Fees</th>";
echo "<th>Cases Won</th>";
echo "</tr>";


while ($row = pg_fetch_assoc($resultLawyers)) {
    echo "<tr>";
    echo "<td>" . $row['lawyerid'] . "</td>";
    echo "<td>" . $row['firstname'] . "</td>";
    echo "<td>" . $row['lastname'] . "</td>";
    echo "<td>" . $row['contactnumber'] . "</td>";
    echo "<td>" . $row['email'] . "</td>";
    echo "<td>" . $row['specialization'] . "</td>";
    echo "<td>" . $row['barassociationmembership'] . "</td>";
    echo "<td>" . $row['qualifications'] . "</td>";
    echo "<td>" . $row['address'] . "</td>";
    echo "<td>" . $row['joindate'] . "</td>";
  
    echo "<td>" . $row['fees'] . "</td>";
    echo "<td>" . $row['caseswon'] . "</td>";
    echo "<td><a href='update_lawyer.php?id=" . $row['lawyerid'] . "'>Update</a></td>";

    echo "<td><a href='delete_lawyer.php?id=" . $row['lawyerid'] . "'>Delete</a></td>";
    echo "</tr>";
}

?>



