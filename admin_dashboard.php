<?php

error_reporting();
include('config/configpdo.php');

?>
<?php
// Replace these credentials with your actual database credentials
$host = "localhost";
$username = "root";
$password = "";
$dbname = "printopia";
// Fetches the expenditure numbers for the total expenditure button
try {
    // Create a new PDO instance
    $connection = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

    // Set the PDO error mode to exception
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get the filter value
    if (isset($_GET['filter'])) {
        $filter = $_GET['filter'];
    } else {
        $filter = 'day';
    }
    

    // Switch statement to determine the filter
    switch ($filter) {
        case 'week':
            $sql = "SELECT SUM(buying_price * item_quantity) as total_expenditure FROM inventory WHERE WEEK(date_in) = WEEK(CURDATE()) AND YEAR(date_in) = YEAR(CURDATE())";
            break;
        case 'month':
            $sql = "SELECT SUM(buying_price * item_quantity) as total_expenditure FROM inventory WHERE MONTH(date_in) = MONTH(CURDATE()) AND YEAR(date_in) = YEAR(CURDATE())";
            break;
        default:
            $sql = "SELECT SUM(buying_price * item_quantity) as total_expenditure FROM inventory WHERE DATE(date_in) = CURDATE()";
    }

    // Prepare the statement
    $statement = $connection->prepare($sql);

    // Execute the statement
    $statement->execute();

    // Fetch the total cost value
    $totalExpensesData = $statement->fetchColumn();

} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Fetches the sales numbers for the total sales button
try {
    // Create a new PDO instance
    $connection = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

    // Set the PDO error mode to exception
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get the filter value
    if (isset($_GET['filter'])) {
        $filter = $_GET['filter'];
    } else {
        $filter = 'day';
    }
    

    // Switch statement to determine the filter
    switch ($filter) {
        case 'week':
            $sql = "SELECT SUM(selling_price * item_quantity_out) as total_selling_price FROM tbl_sales WHERE WEEK(date_out) = WEEK(CURDATE()) AND YEAR(date_out) = YEAR(CURDATE())";
            break;
        case 'month':
            $sql = "SELECT SUM(selling_price * item_quantity_out) as total_selling_price FROM tbl_sales WHERE MONTH(date_out) = MONTH(CURDATE()) AND YEAR(date_out) = YEAR(CURDATE())";
            break;
        default:
            $sql = "SELECT SUM(selling_price * item_quantity_out) as total_selling_price FROM tbl_sales WHERE DATE(date_out) = CURDATE()";
    }

    // Prepare the statement
    $statement = $connection->prepare($sql);

    // Execute the statement
    $statement->execute();

    // Fetch the total cost value
    $totalSalesData = $statement->fetchColumn();

} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}


// Fetches the category labels for the graph
try {
    // Create a new PDO connection
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Query to fetch data
    $sql = "SELECT inventory_item, date_in, buying_price, SUM(buying_price) as total_price FROM inventory GROUP BY inventory_item";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    // Fetch data into arrays
    $labels = [];


    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $labels[] = $row["inventory_item"];

    }

} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

try {
    // Create a new PDO instance
    $connection = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

    // Set the PDO error mode to exception
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get the filter value
    if (isset($_GET['filter'])) {
        $filter = $_GET['filter'];
    } else {
        $filter = 'day';
    }
    

    // Switch statement to determine the filter
    switch ($filter) {
        case 'week':
            $sql = "SELECT
            (total_selling_price - SUM(i.buying_price * i.item_quantity)) AS total_profit,
            COALESCE(s.total_selling_price, 0) AS total_selling_price
        FROM
            tbl_category c
        LEFT JOIN
            inventory i ON c.id = i.category_id
        LEFT JOIN
            (
                SELECT
                    cid,
                    SUM(selling_price * item_quantity_out) AS total_selling_price,
                    date_out
                FROM
                    tbl_sales
                WHERE
                    WEEK(date_out) = WEEK(CURDATE()) AND YEAR(date_out) = YEAR(CURDATE())
                GROUP BY
                    cid
            ) s ON c.id = s.cid
        
        GROUP BY
            c.category_name;";
            break;

        case 'month':
            $sql = "SELECT
            (total_selling_price - SUM(i.buying_price * i.item_quantity)) AS total_profit,
            COALESCE(s.total_selling_price, 0) AS total_selling_price
        FROM
            tbl_category c
        LEFT JOIN
            inventory i ON c.id = i.category_id
        LEFT JOIN
            (
                SELECT
                    cid,
                    SUM(selling_price * item_quantity_out) AS total_selling_price,
                    date_out
                FROM
                    tbl_sales
                WHERE
                    MONTH(date_out) = MONTH(CURDATE()) AND YEAR(date_out) = YEAR(CURDATE())
                GROUP BY
                    cid
            ) s ON c.id = s.cid
        GROUP BY
            c.category_name;
        ";
        break;

        default:
            $sql = "SELECT (total_selling_price - SUM(i.buying_price * i.item_quantity)) AS total_profit,
                    COALESCE(s.total_selling_price, 0) AS total_selling_price
                    FROM
                        tbl_category c
                    LEFT JOIN
                        inventory i ON c.id = i.category_id
                    LEFT JOIN
                        (
                            SELECT
                                cid,
                                SUM(selling_price * item_quantity_out) AS total_selling_price,
                                date_out
                            FROM
                                tbl_sales
                            WHERE
                                    DATE(date_out) = CURDATE()
                            GROUP BY
                                cid
                        ) s ON c.id = s.cid
                    GROUP BY
                        c.category_name";
                }

    // Prepare the statement
    $statement = $connection->prepare($sql);

    // Execute the statement
    $statement->execute();

    // Fetch the total_profit values
    $buyingPrices = $statement->fetchAll(PDO::FETCH_COLUMN);

    // Store the total_profit values in an array
    $buyingPriceArray = $buyingPrices;

} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

?>

<?php
$dsn = 'mysql:host=localhost;dbname=printopia;charset=utf8mb4';
$username = 'root';
$password = '';
// fetches the data in the filtered data table(Below the graph)
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
        $sql = "SELECT 
                category_name,
                SUM(i.buying_price * i.item_quantity) AS total_buying_price,
                (total_selling_price - SUM(i.buying_price * i.item_quantity)) AS total_profit,
                COALESCE(s.total_selling_price, 0) AS total_selling_price
                FROM
                    tbl_category c
                LEFT JOIN
                    inventory i ON c.id = i.category_id
                LEFT JOIN
                    (
                        SELECT
                            cid,
                            SUM(selling_price * item_quantity_out) AS total_selling_price,
                            date_out
                        FROM
                            tbl_sales
                        WHERE
                            WEEK(date_out) = WEEK(CURDATE()) AND YEAR(date_out) = YEAR(CURDATE())
                        GROUP BY
                            cid
                    ) s ON c.id = s.cid
    
                GROUP BY
                    c.category_name";
        break;
    case 'month':
        $sql = "SELECT 
        category_name,
        SUM(i.buying_price * i.item_quantity) AS total_buying_price,
        (total_selling_price - SUM(i.buying_price * i.item_quantity)) AS total_profit,
        COALESCE(s.total_selling_price, 0) AS total_selling_price
        FROM
            tbl_category c
        LEFT JOIN
            inventory i ON c.id = i.category_id
        LEFT JOIN
            (
                SELECT
                    cid,
                    SUM(selling_price * item_quantity_out) AS total_selling_price,
                    date_out
                FROM
                    tbl_sales
                WHERE
                    MONTH(date_out) = MONTH(CURDATE()) AND YEAR(date_out) = YEAR(CURDATE())
                GROUP BY
                    cid
            ) s ON c.id = s.cid

        GROUP BY
            c.category_name";
        break;
    default:
    $sql = "SELECT 
    category_name,
    SUM(i.buying_price * i.item_quantity) AS total_buying_price,
    (total_selling_price - SUM(i.buying_price * i.item_quantity)) AS total_profit,
    COALESCE(s.total_selling_price, 0) AS total_selling_price
    FROM
        tbl_category c
    LEFT JOIN
        inventory i ON c.id = i.category_id
    LEFT JOIN
        (
            SELECT
                cid,
                SUM(selling_price * item_quantity_out) AS total_selling_price,
                date_out
            FROM
                tbl_sales
            WHERE
                DATE(date_out) = CURDATE()
            GROUP BY
                cid
        ) s ON c.id = s.cid

    GROUP BY
        c.category_name";
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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Printopia</title>
       <!-- Custom fonts for this template-->
       <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
       <link
           href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
           rel="stylesheet">
   
       <!-- Custom styles for this template-->
       <link href="css/sb-admin-2.min.css" rel="stylesheet">

       <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

        <!-- Include Chart.js -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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

    <section class = "bg-secondary p-3 ">
        <div class="container-lg mt-3 bg-secondary rounded ">
            <div class="row justify-content-center">
                <span><img src="images/logo.svg" class="rounded mx-auto d-block" alt="" /></span>
                <h1 class ="text-center text-light fw-light">Information Management System</h1>
            </div>
        </div>

        <div class="container-lg mt-5 bg-light rounded">
            <div class="row p-3">
                <div class="text-center">

                    <nav class="navbar navbar-expand-lg navbar-light bg-light rounded">
                        <div class="container-fluid">
                          
                          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                          </button>
                          <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                        <span class="border-bottom border-dark border-2">
                            <ul class="navbar-nav">

                              <li class="nav-item">
                                <a class="nav-link mx-3" aria-current="page" href="admin_dashboard.php">Dashboard</a>
                              </li>

                              <li class="nav-item">
                                <a class="nav-link mx-3" aria-current="page" href="product_categories_home.php">Products</a>
                              </li>

                              <li class="nav-item">
                                <a class="nav-link mx-3" aria-current="page" href="inventory_home.php">Inventory</a>
                              </li>

                              <li class="nav-item">
                                <a class="nav-link mx-3" aria-current="page" href="sales_home.php">Sales</a>
                              </li>

                              <li class="nav-item">
                                <a class="nav-link mx-3" aria-current="page" href="audit_index.php">Transactions</a>
                              </li>
                            </ul>
                        </span>
                          </div>
                        </div>
                      </nav>
                      
                </div>
            </div>


            <div class="row p-5 pt-4">
                
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <p>
                            Good morning here is what is going on with your business
                        </p>
                    </div>

                    <div class="container mt-3">
                        <div class="row m-3">

                            <div class="col-4">
                                <div class="card">
                                    <div class="card-body text-center bg-danger">
                                        <h5 class="card-title">Total expenditure</h5>
                                        <p class="card-text" id="totalOrders"><?php echo $totalExpensesData; ?></p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-4">
                                <div class="card">
                                    <div class="card-body text-center bg-success">
                                        <h5 class="card-title">Total Sales</h5>
                                        <p class="card-text" id="totalOrders"><?php echo $totalSalesData; ?></p>
                                    </div>
                                </div>
                            </div>


   
                            <div class="col-4 mt-4 ps-5">
                                <div style="display: flex; justify-content: center;">
                                    <nav aria-label="Toggle navigation">
                                        <ul class="pagination">
                                            <li class="page-item"><a class="page-link" href="admin_dashboard.php?filter=day">Day</a></li>
                                            <li class="page-item"><a class="page-link" href="admin_dashboard.php?filter=week">Week</a></li>
                                            <li class="page-item"><a class="page-link" href="admin_dashboard.php?filter=month">Month</a></li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>


                        </div>
                     </div>

                     <div class="container mt-4">
                        <!-- Add a container for the line chart -->
                        <canvas id="lineChart" width="400" height="200"></canvas>
                    </div>

                    <div class="container mt-5">
                        <p><b>Current <?php echo ucfirst($filter); ?>:</b></p>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Category</th>
                                    <th>Total Selling price</th>
                                    <th>Total Buying Price</th>
                                    <th>Total Profit</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($data as $row) : ?>
                                    <tr>
                                        <td><?php echo $row['category_name']; ?></td>
                                        <td><?php echo $row['total_selling_price']; ?></td>
                                        <td><?php echo $row['total_buying_price']; ?></td>
                                        <td><?php echo $row['total_profit']; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
 
    </section>

	<script src="edit/js/jquery.min.js"></script>
	<script src="edit/js/bootstrap-select.min.js"></script>
	<script src="edit/js/bootstrap.min.js"></script>
	<script src="edit/js/jquery.dataTables.min.js"></script>
	<script src="edit/js/dataTables.bootstrap.min.js"></script>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    <script>
      const tooltips = document.querySelectorAll('.tt')
      tooltips.forEach(t => {
        new bootstrap.Tooltip(t)
      })
    </script>
    
	     <!-- Bootstrap core JavaScript-->
     <script src="vendor/jquery/jquery.min.js"></script>
     <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
 
     <!-- Core plugin JavaScript-->
     <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
 
     <!-- Custom scripts for all pages-->
     <script src="js/sb-admin-2.min.js"></script>
 
     <!-- Page level plugins -->
     <script src="vendor/datatables/jquery.dataTables.min.js"></script>
     <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
 
     <!-- Page level custom scripts -->
     <script src="edit/js/datatables-demo.js"></script>
	 
	 <script src="jquery.min.js"></script>
     <script src="bootstrap/js/bootstrap.min.js"></script>
	 
     <script>
    const searchInput = document.getElementById('searchInput');
    const table = document.getElementById('myTable');
    const rows = table.getElementsByTagName('tr');
    const pageSize = 10; // Number of rows per page

    let currentPage = 1;
    const pagination = document.getElementById('pagination');
    const pageLinks = pagination.getElementsByTagName('a');
    const totalPages = Math.ceil((rows.length - 1) / pageSize);

    function applyPagination() {
      // Generate pagination links
      let paginationHTML = '';
      paginationHTML += `<li class="page-item"><a class="page-link" href="#" data-page="prev">Previous</a></li>`;

      for (let i = 1; i <= totalPages; i++) {
        paginationHTML += `<li class="page-item"><a class="page-link" href="#" data-page="${i}">${i}</a></li>`;
      }

      paginationHTML += `<li class="page-item"><a class="page-link" href="#" data-page="next">Next</a></li>`;
      pagination.innerHTML = paginationHTML;

      // Add click event listener to pagination links
      for (let i = 0; i < pageLinks.length; i++) {
        pageLinks[i].addEventListener('click', function (e) {
          e.preventDefault();
          const targetPage = this.getAttribute('data-page');

          if (targetPage === 'prev') {
            currentPage = Math.max(currentPage - 1, 1);
          } else if (targetPage === 'next') {
            currentPage = Math.min(currentPage + 1, totalPages);
          } else {
            currentPage = parseInt(targetPage);
          }

          updateTable();
        });
      }

      updateTable();
    }

    function updateTable() {
      // Calculate the start and end index of the rows for the current page
      const startIndex = (currentPage - 1) * pageSize + 1;
      const endIndex = Math.min(startIndex + pageSize - 1, rows.length - 1);

      // Show/hide rows based on the current page
      for (let i = 1; i < rows.length; i++) {
        if (i >= startIndex && i <= endIndex) {
          rows[i].style.display = '';
          rows[i].cells[0].textContent = i;
        } else {
          rows[i].style.display = 'none';
        }
      }
    }

    searchInput.addEventListener('keyup', function () {
      const searchText = searchInput.value.toLowerCase();

      for (let i = 1; i < rows.length; i++) {
        const cells = rows[i].getElementsByTagName('td');
        let foundMatch = false;

        for (let j = 1; j < cells.length; j++) {
          const cellText = cells[j].textContent || cells[j].innerText;

          if (cellText.toLowerCase().indexOf(searchText) > -1) {
            foundMatch = true;
            break;
          }
        }

        rows[i].style.display = foundMatch ? '' : 'none';
      }
    });

    applyPagination();
  </script>

<script>
        // PHP data to JavaScript variables
        var labels = <?php echo json_encode($labels); ?>;
        var data = <?php echo json_encode($buyingPriceArray); ?>;

        // Debug: Print data to console
        console.log("Labels:", labels);
        console.log("Data:", data);

        // Get the canvas element
        var ctx = document.getElementById('lineChart').getContext('2d');

        // Create the line chart
        var lineChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Profit',
                    data: data,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 2,
                    fill: false
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true, // Start y-axis from zero
                        min: 0, // Minimum value for y-axis
                        max: 50000, // Maximum value for y-axis
                        stepSize: 15000, // Step size between ticks on the y-axis
                        ticks: {
                            // Format the tick values (optional)
                            callback: function(value, index, values) {
                                return value + ' Kshs';
                            }
                        }
                    }
                }
            }
        });
    </script>

</body>
</html>