<?php

// Fetches the sales and expenditure number for the buttons
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
                        SUM(item_quantity_out) AS total_quantity_out,
                        SUM(selling_price * item_quantity_out) AS total_selling_price
                    FROM
                        tbl_sales
                    GROUP BY
                        cid
                ) s ON c.id = s.cid
            GROUP BY
                c.category_name WHERE WEEK(date_in) = WEEK(CURDATE()) AND YEAR(date_in) = YEAR(CURDATE())";
            break;
        case 'month':
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
                                SUM(item_quantity_out) AS total_quantity_out,
                                SUM(selling_price * item_quantity_out) AS total_selling_price
                            FROM
                                tbl_sales
                            GROUP BY
                                cid
                        ) s ON c.id = s.cid
                    GROUP BY
                        c.category_name WHERE MONTH(date_in) = MONTH(CURDATE()) AND YEAR(date_in) = YEAR(CURDATE())";
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
                                SUM(item_quantity_out) AS total_quantity_out,
                                SUM(selling_price * item_quantity_out) AS total_selling_price
                            FROM
                                tbl_sales
                            GROUP BY
                                cid
                        ) s ON c.id = s.cid
                    GROUP BY
                        c.category_name FROM inventory WHERE DATE(date_in) = CURDATE()";
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

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Step 2: Query the database to retrieve buying prices from the "inventory" table
    $stmt = $pdo->prepare("
    SELECT
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
                SUM(item_quantity_out) AS total_quantity_out,
                SUM(selling_price * item_quantity_out) AS total_selling_price
            FROM
                tbl_sales
            GROUP BY
                cid
        ) s ON c.id = s.cid
    GROUP BY
        c.category_name");
    $stmt->execute();
    $buyingPrices = $stmt->fetchAll(PDO::FETCH_COLUMN);

    // Step 3: Store the buying prices in an array
    $buyingPriceArray = $buyingPrices;
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

// Step 3: Store the buying prices in an array
$buyingPriceArray = $buyingPrices;

?>