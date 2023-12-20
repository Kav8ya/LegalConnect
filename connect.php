<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP PostgreSQL OOP Example</title>
    <style>
        p{
            text-align: center;
        }
    </style>
</head>
<body>

<?php

class DatabaseConnection {
    private $pdo;

    public function __construct($host, $port, $dbname, $user, $password) {
        $dsn = "pgsql:host=$host;port=$port;dbname=$dbname;user=$user;password=$password";
        try {
            $this->pdo = new PDO($dsn);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function executeQuery($query) {
        try {
            $statement = $this->pdo->query($query);
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Query execution failed: " . $e->getMessage());
        }
    }
}

// class DataDisplay {
//     public static function displayResults($results) {
//         echo "<h2>Results:</h2>";
//         echo "<table border='1'>";
//         // echo "<tr><th>Column1</th><th>Column2</th><th>Column3</th></tr>"; // Replace with your actual column names

//         foreach ($results as $row) {
//             echo "<p>{$row['brand']}</p>";
//             // Replace 'column1', 'column2', 'column3' with your actual column names
//         }

//         echo "</table>";
//     }
// }

// Replace with your actual database credentials
$host = "localhost";
$port = "5432";
$dbname = "postgres";
$user = "postgres";
$password = "postgres";

// Replace with your actual SELECT query
$query = "insert into cars(brand,model,year) values('audi','190',1990);";

// Create a DatabaseConnection instance
$databaseConnection = new DatabaseConnection($host, $port, $dbname, $user, $password);

// Execute the SELECT query
$results = $databaseConnection->executeQuery($query);

// Display results using DataDisplay class
// DataDisplay::displayResults($results);
?>

</body>
</html>
