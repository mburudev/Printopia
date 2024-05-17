<?php
// display_data.php

// Connect to the database using PDO
$dsn = 'mysql:host=localhost;dbname=printopia;charset=utf8mb4';
$username = 'root';
$password = '';

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Check if the filter is set and valid
$validFilters = ['day', 'week', 'month'];
$filter = isset($_GET['filter']) && in_array($_GET['filter'], $validFilters) ? $_GET['filter'] : 'day';

// Build the SQL query based on the selected filter
switch ($filter) {
    case 'week':
        $sql = "SELECT * FROM inventory WHERE WEEK(date_in) = WEEK(CURDATE()) AND YEAR(date_in) = YEAR(CURDATE())";
        break;
    case 'month':
        $sql = "SELECT * FROM inventory WHERE MONTH(date_in) = MONTH(CURDATE()) AND YEAR(date_in) = YEAR(CURDATE())";
        break;
    default:
        $sql = "SELECT * FROM inventory WHERE DATE(date_in) = CURDATE()";
}

// Execute the query and fetch data
try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Query failed: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Audit My Day App</title>
       <!-- Custom fonts for this template-->
       <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
       <link
           href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
           rel="stylesheet">
   
       <!-- Custom styles for this template-->
       <link href="css/sb-admin-2.min.css" rel="stylesheet">

       <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

<style>
      .row-number {
      font-weight: bold;
    }
</style>
<style>
        /* Custom styles for responsiveness */
        .search-bar {
            max-width: 100%;
        }
</style>
</head>
<body>
    <div class="container mt-5">
        <h2>Filtered Data</h2>
        <p>Filter: <?php echo ucfirst($filter); ?></p>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Data Value</th>
                    <th>Date Added</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data as $row) : ?>
                    <tr>
                        <td><?php echo $row['inventory_id']; ?></td>
                        <td><?php echo $row['inventory_item']; ?></td>
                        <td><?php echo $row['date_in']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
