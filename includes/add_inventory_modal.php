<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
?>

<div class="modal fade" id="categoryModal" tabindex="-1" aria-labelledby="categoryModallabel" aria-hidden="true">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="categoryModallabel">New Stock</h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
									<form method="POST" action="includes/modal_config/add_inventory_config.php">
                                    <div class="form-floating pb-2">
                                      <input type="date" name="date_in" class="form-control" required="required" id="floatingText" placeholder="Date In">

                                      <label for="floatingText">Date In</label>
                                    </div>
									
                                    <div class="form-floating pb-2">
                                      <input type="text" name="inventory_item" class="form-control" required="required" id="floatingText" placeholder="Item">

                                      <label for="floatingText">Item</label>
                                    </div>

                                    <div class="form-floating pb-2">
                                      <input type="number" name="item_quantity" class="form-control" required="required" id="floatingText" placeholder="Quantity">

                                      <label for="floatingText">Quantity</label>
                                    </div>

                                    <div class="form-floating pb-2">
                                      <input type="text" name="quantity_type" class="form-control" required="required" id="floatingText" placeholder="Quantity Type">

                                      <label for="floatingText">Quantity type</label>
                                    </div>

                                    <div class="form-floating pb-2">
                                        <select class="form-select" id="selectCategory" name="category_id" aria-label="Category">
                                            <?php include 'includes/get_category_options.php'; ?>
                                        </select>
                                        <label for="selectCategory">Category</label>
                                    </div>
                                    
                                    <div class="form-floating pb-2">
                                      <input type="number" name="buying_price" class="form-control" required="required" id="floatingText" placeholder="Buying price">

                                      <label for="floatingText">Buying price per item</label>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                  <button type="submit" name="submit" class="btn btn-primary">Add</button>
                                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
								</form>
								
                              </div>
                            </div>
                          </div>
						  
