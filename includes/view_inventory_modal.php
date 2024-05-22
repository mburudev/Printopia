<div class="modal fade" id="viewInventoryModal" tabindex="-1" aria-labelledby="viewInventoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewInventoryModalLabel">View Inventory</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Date In</th>
                            <th>Item</th>
                            <th>Quantity</th>
                            <th>Buying Price per Item</th>
                            <th>Total Buying Price</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody id="inventoryTableBody">
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

    const viewInventoryButtons = document.querySelectorAll('.view-inventory-btn');
    const inventoryTableBody = document.getElementById('inventoryTableBody');

    viewInventoryButtons.forEach(button => {
        button.addEventListener('click', function () {
            const category = button.getAttribute('data-category');

            // Make an AJAX call to fetch sales data for the selected category
            fetch('includes/get_inventory_data.php?category=' + encodeURIComponent(category))
                .then(response => {
                    console.log('Response:', response);
                    return response.json();
                })
                .then(data => {
                    console.log('Fetched Data:', data);

                    // Populate the modal with fetched sales data
                    inventoryTableBody.innerHTML = '';
                    data.forEach(inventory => {
                        const row = document.createElement('tr');
                        row.setAttribute('data-inventory-id', inventory.inventory_id); // Set the inventory_id as a data attribute
                        row.innerHTML = `
                            <td>${inventory.date_in}</td>
                            <td>${inventory.inventory_item}</td>
                            <td>${inventory.item_quantity} ${inventory.quantity_type}</td>
                            <td>${inventory.buying_price}</td>
                            <td>${inventory.total_buying_price}</td>
                            <td><button class="btn btn-primary edit-inventory-btn" data-bs-target="#editInventoryModal" data-bs-dismiss="modal">Edit</button></td>
                            <td><button type="button" class="btn btn-danger delete-inventory-btn" data-bs-toggle="modal" data-bs-target="#deleteInventoryModal">Delete</button></td>
                        `;
                        inventoryTableBody.appendChild(row);

                        // Add an event listener to the "Edit" button in each row
                        const editButton = row.querySelector('.edit-inventory-btn');
                        editButton.addEventListener('click', function () {
                            // Open the edit modal when the "Edit" button is clicked
                            const inventoryId = row.getAttribute('data-inventory-id');
                            $('#editInventoryModal' + inventoryId).modal('show');
                        });
                    });
                })
                .catch(error => {
                    console.error('Error fetching inventory data:', error);
                });
        });
    });
});

</script>

<?php
    include('edit_inventory_modal.php');
    include('delete_inventory_modal.php');
?>


