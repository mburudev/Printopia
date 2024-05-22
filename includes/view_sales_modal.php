<div class="modal fade" id="viewSalesModal" tabindex="-1" aria-labelledby="viewSalesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewSalesModalLabel">View Sales</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Date Out</th>
                            <th>Item</th>
                            <th>Quantity</th>
                            <th>Selling Price per Item</th>
                            <th>Total selling Price</th>
                            <th>Printing style</th>
                            <th>Mode Of Payment</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody id="salesTableBody">
                        <!-- Data to be populated here -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const table = document.getElementById('myTable');
    const footerRow = table.querySelector('tfoot tr'); // Get the footer row if it exists

    if (footerRow) {
        footerRow.style.display = (table.tBodies[0].rows.length > 0) ? 'table-row' : 'none';
    }

    const viewSalesButtons = document.querySelectorAll('.view-sales-btn');
    const salesTableBody = document.getElementById('salesTableBody');

    viewSalesButtons.forEach(button => {
        button.addEventListener('click', function () {
            const category = button.getAttribute('data-category');

            // Make an AJAX call to fetch sales data for the selected category
            fetch('includes/get_sales_data.php?category=' + encodeURIComponent(category))
                .then(response => {
                    console.log('Response:', response);
                    return response.json();
                })
                .then(data => {
                    console.log('Fetched Data:', data);

                    // Populate the modal with fetched sales data
                    salesTableBody.innerHTML = '';
                    data.forEach(sale => {
                        const row = document.createElement('tr');
                        row.setAttribute('data-sales-id', sale.id); // Set the id as a data attribute
                        row.innerHTML = `
                            <td>${sale.date_out}</td>
                            <td>${sale.item}</td>
                            <td>${sale.item_quantity_out} ${sale.quantity_type}</td>
                            <td>${sale.selling_price}</td>
                            <td>${sale.total_selling_price}</td>
                            <td>${sale.printing_style}</td>
                            <td>${sale.mode_of_payment}</td>
                            <td><button class="btn btn-primary edit-sales-btn" data-bs-target="#editSalesModal" data-bs-dismiss="modal">Edit</button></td>
                            <td><button type="button" class="btn btn-danger delete-sales-btn" data-bs-toggle="modal" data-bs-target="#deleteSalesModal">Delete</button></td>
                        `;
                        salesTableBody.appendChild(row);

                        // Add an event listener to the "Edit" button in each row
                        const editButton = row.querySelector('.edit-sales-btn');
                        editButton.addEventListener('click', function () {
                            // Open the edit modal when the "Edit" button is clicked
                            const SalesId = row.getAttribute('data-sales-id');
                            $('#editSalesModal' + SalesId).modal('show');
                        });
                    });
                })
                .catch(error => {
                    console.error('Error fetching sales data:', error);
                });
        });
    });
});

</script>

<?php
    include('edit_sales_modal.php');
    include('delete_sales_modal.php');
?>


