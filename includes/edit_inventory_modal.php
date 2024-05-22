<!-- Edit Inventory Modal -->
<div class="modal fade" id="editInventoryModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Stock</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Edit form -->
                <form method="POST" action="includes/modal_config/edit_inventory_config.php">
                    <input type="hidden" name="inventory_id" value="<?php echo $row["inventory_id"]; ?>">
                    <div class="mb-3">
                        <label for="date_In">Date In</label>
                        <input type="date" class="form-control" name="date_in" value="<?php echo $row["date_in"]; ?>">
                    </div>

                    <div class="mb-3">
                        <label for="inventory_item">Item</label>
                        <input type="text" class="form-control" name="inventory_item" value="<?php echo $row["inventory_item"]; ?>">
                    </div>

                    <div class="mb-3">
                        <label for="item_quantity">Quantity</label>
                        <input type="number" class="form-control" name="item_quantity" value="<?php echo $row["item_quantity"]; ?>">
                    </div>

                    <div class="mb-3">
                        <label for="quantity_type">Quantity Type</label>
                        <input type="text" class="form-control" name="quantity_type" value="<?php echo $row["quantity_type"]; ?>">
                    </div>

                    <div class="mb-3">
                        <label for="buying_price">Buying price per item</label>
                        <input type="number" class="form-control" name="buying_price" value="<?php echo $row["buying_price"]; ?>">
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Edit</button>
                        <!-- Close the edit modal and open the view modal -->
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#viewInventoryModal">Back to View inventory</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // ... (your existing code)

    // Add an event listener to the "Edit" buttons using a common class
    inventoryTableBody.addEventListener('click', function (event) {
        if (event.target.classList.contains('edit-inventory-btn')) {
            // Find the closest row to the clicked button
            const row = event.target.closest('tr');

            // Extract the inventory ID from a data attribute in the row
            const inventoryId = row.getAttribute('data-inventory-id');

            // Make an AJAX call to fetch the inventory data for editing
            fetch('includes/edit_inventory_data.php?inventory_id=' + encodeURIComponent(inventoryId))
                .then(response => response.json())
                .then(data => {
                    // Populate the edit modal with the fetched data
                    const editModal = document.querySelector('#editInventoryModal');
                    editModal.querySelector('[name="inventory_id"]').value = data.inventory_id;
                    editModal.querySelector('[name="date_in"]').value = data.date_in;
                    editModal.querySelector('[name="inventory_item"]').value = data.inventory_item;
                    editModal.querySelector('[name="item_quantity"]').value = data.item_quantity;
                    editModal.querySelector('[name="quantity_type"]').value = data.quantity_type;
                    editModal.querySelector('[name="buying_price"]').value = data.buying_price;

                    // Show the edit modal
                    $('#editInventoryModal').modal('show');
                })
                .catch(error => {
                    console.error('Error fetching inventory data:', error);
                });
        }
    }); 
});
</script>
