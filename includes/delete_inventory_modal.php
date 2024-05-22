                        <!--Delete Inventory Modal -->
                        <div class="modal fade" id="deleteInventoryModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editModalLabel">Delete Stock</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Edit form -->
                                        <form method="POST" action = "includes/modal_config/delete_inventory_config.php">
                                            <input type="hidden" name="inventory_id" value="<?php echo $row["inventory_id"]; ?>">

                                            <p>
                                              Are you sure you want to delete this entry?
                                            </p>

                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <script>
document.addEventListener('DOMContentLoaded', function () {
    // ... (your existing code)

    // Add an event listener to the "Delete" buttons using a common class
    inventoryTableBody.addEventListener('click', function (event) {
        if (event.target.classList.contains('delete-inventory-btn')) {
            // Find the closest row to the clicked button
            const row = event.target.closest('tr');

            // Extract the inventory ID from a data attribute in the row
            const inventoryId = row.getAttribute('data-inventory-id');

            // Make an AJAX call to fetch the inventory data for editing
            fetch('includes/delete_inventory_data.php?inventory_id=' + encodeURIComponent(inventoryId))
                .then(response => response.json())
                .then(data => {
                    // Populate the edit modal with the fetched data
                    const editModal = document.querySelector('#deleteInventoryModal');
                    editModal.querySelector('[name="inventory_id"]').value = data.inventory_id;

                    // Show the edit modal
                    $('#deleteInventoryModal').modal('show');
                })
                .catch(error => {
                    console.error('Error fetching inventory data:', error);
                });
        }
    }); 
});
</script>