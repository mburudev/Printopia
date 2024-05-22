<!-- Modal -->
<div class="modal fade" id="editCategoryModal<?php echo $row["id"]; ?>" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Stock</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Edit form -->
                <form method="POST" action="includes/modal_config/edit_category_config.php">
                    <input type="hidden" name="id" value="<?php echo $row["id"]; ?>">
                    <div class="mb-3">
                        <label for="category_name">Product Category</label>
                        <input type="text" class="form-control" name="category_name" value="<?php echo $row["category_name"]; ?>">
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Edit</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
