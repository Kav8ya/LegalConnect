<?php

@include 'config.php';



$searchQuery = '';

if (isset($_GET['search'])) {
    $searchQuery = $_GET['search'];
    $queryWriters = "SELECT * FROM documentwriters WHERE firstname LIKE '%$searchQuery%'";
} else {
    $queryWriters = "SELECT * FROM documentwriters";
}

$resultWriters = pg_query($connection, $queryWriters);

if (!$resultWriters) {
    die("Database query failed");

}
echo "<table>";
echo "<h2>Document Writers</h2>";

?>
<div style="text-align: right;">
<form id="searchForm" action="" method="GET">
    <label for="search">Search Writer:</label>
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
echo "<th>Writing Genre</th>";
echo "<th>Qualifications</th>";
echo "<th>Address</th>";
echo "<th>Join Date</th>";
echo "<th>Fees</th>";
echo "<th>Documents Written</th>";

echo "</tr>";

while ($row = pg_fetch_assoc($resultWriters)) {
    echo "<tr>";
    echo "<td>" . $row['writerid'] . "</td>";
    echo "<td>" . $row['firstname'] . "</td>";
    echo "<td>" . $row['lastname'] . "</td>";
    echo "<td>" . $row['contactnumber'] . "</td>";
    echo "<td>" . $row['email'] . "</td>";
    echo "<td>" . $row['specialization'] . "</td>";
    echo "<td>" . $row['writinggenre'] . "</td>";
    echo "<td>" . $row['qualifications'] . "</td>";
    echo "<td>" . $row['address'] . "</td>";
    echo "<td>" . $row['joindate'] . "</td>";
    
    echo "<td>" . $row['fees'] . "</td>";
    echo "<td>" . $row['documentswritten'] . "</td>";
    echo "<td><a href='update_writer.php?id=" . $row['writerid'] . "'>Update</a></td>";
    echo "<td><a href='delete_writer.php?id=" . $row['writerid'] . "'>Delete</a></td>";
    echo "</tr>";
}

echo "</table>";
?>



