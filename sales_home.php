<?php include('includes/modal_config/edit_inventory_config.php');?> 

<?php

error_reporting();
include('config/config.php');

?>

<?php
//Fetch user data from the database
$sql = "SELECT
    c.category_name,
    i.quantity_type,
    SUM(i.item_quantity) AS total_quantity_in,
    COALESCE(s.total_quantity_out, 0) AS total_quantity_out,
    COALESCE(s.total_selling_price, 0) AS total_selling_price,
    SUM(i.item_quantity) - COALESCE(s.total_quantity_out, 0) AS quantity_in_stock
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
    c.category_name";
$result = $conn->query($sql);

// Variable to store the running total
$total_cost_sum = 0;
?>

<!DOCTYPE html>
<?php include('includes/topbar.php');?> 

<div class="row p-4">
      <div class="col-4">
        
      </div>

      <div class="col-4">
        <input type="text" id="searchInput" class="form-control search-bar rounded-pill" placeholder="Search">
      </div>

      <div class="col-4 text-end">
           <!-- Button trigger modal -->
            <button type="button" href="#addsalesModal" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addsalesModal">
                Make Sale
            </button>
      </div>
</div>

<!-- Add category modal -->
<?php include('includes/add_sales_modal.php');?> 



             <div class="row p-5 pt-4">
                
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Sales:</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive table-striped table-hover">

                        <table id="myTable" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Category</th>
                <th>Total Quantity</th>
                <th>Total Quantity Out</th>
                <th>Quantity In Stock</th>
                <th>Total Selling Price</th>
                <th>View Sales</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $total_cost_sum += $row["total_selling_price"];
            ?>
            <tr>
                <td class="row-number"></td>
                <td><?php echo $row['category_name']; ?></td>
                <td><?php echo $row["total_quantity_in"] . " " . $row["quantity_type"]; ?></td>
                <td><?php echo $row["total_quantity_out"] . " " . $row["quantity_type"]; ?></td>
                <td><?php echo $row["quantity_in_stock"] . " " . $row["quantity_type"]; ?></td>
                <td><?php echo $row["total_selling_price"] . " " . "Kshs"; ?></td>
                <td>
                    <button type="button" class="btn btn-primary view-sales-btn" data-bs-toggle="modal" data-bs-target="#viewSalesModal" data-category="<?php echo $row['category_name']; ?>">
                        View
                    </button>

                </td>
            </tr>
            <?php } ?>
            <tr class="hide-row-number">
                <td></td>
                <th colspan="4" class="text-end">Sum total:</th>
                <th><?php echo $total_cost_sum . " " . "Kshs"; ?></th>
                <th></th>
                <th></th>
            </tr>
        </tbody>
    </table>
                        <!-- Include the view sales modal code -->
                        <?php include('includes/view_sales_modal.php'); ?>

                    <nav aria-label="Table pagination">
                        <ul id="pagination" class="pagination justify-content-end">
                        <li class="page-item"><a class="page-link" href="#" data-page="prev">Previous</a></li>
                        <li class="page-item"><a class="page-link" href="#" data-page="next">Next</a></li>
                        </ul>
                    </nav>

                        </div>
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
        // Check if the table has any rows, and show/hide the footer row accordingly
        document.addEventListener('DOMContentLoaded', function () {
            const table = document.getElementById('myTable');
            const footerRow = table.querySelector('tfoot tr');
            footerRow.style.display = (table.tBodies[0].rows.length > 0) ? 'table-row' : 'none';
        });
    </script>
    
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
	 

</body>
</html>