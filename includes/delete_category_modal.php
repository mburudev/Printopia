<!-- Modal -->
<div class="modal fade" id="deleteCategoryModal<?php echo $row["id"]; ?>" tabindex="-1" aria-labelledby="deleteCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteCategoryModalLabel">Delete Product Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Edit form -->
                <form method="POST" action = "includes/modal_config/delete_category_config.php">
                    <input type="hidden" name="id" value="<?php echo $row["id"]; ?>">

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