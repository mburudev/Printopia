<!-- Include jQuery and Bootstrap's JavaScript files -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

<!-- Delete Sales Modal -->
<div class="modal fade" id="deleteSalesModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Delete Sales</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Edit form -->
                <form method="POST" action="includes/modal_config/delete_sales_config.php">
                    <input type="hidden" name="id" value="">

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
    const salesTableBody = document.getElementById('salesTableBody');
    console.log('Sales table body:', salesTableBody);  // Check if salesTableBody is defined

    if (salesTableBody) {
        salesTableBody.addEventListener('click', function (event) {
            if (event.target.classList.contains('delete-sales-btn')) {
                const row = event.target.closest('tr');
                console.log('Clicked row:', row);  // Check if row is found

                const salesId = row.getAttribute('data-sales-id');
                console.log('Sales ID:', salesId);  // Check if salesId is correct

                if (salesId) {
                    fetch('includes/delete_sales_data.php?id=' + encodeURIComponent(salesId))
                        .then(response => response.json())
                        .then(data => {
                            console.log('Fetched data:', data);  // Check fetched data

                            const deleteModal = document.querySelector('#deleteSalesModal');
                            deleteModal.querySelector('[name="id"]').value = data.id;

                            $('#deleteSalesModal').modal('show');
                        })
                        .catch(error => {
                            console.error('Error fetching sales data:', error);
                        });
                } else {
                    console.error('Sales ID is undefined.');
                }
            }
        });
    } else {
        console.error('salesTableBody is not found.');
    }
});
</script>
