<div class="modal fade" id="addsalesModal" tabindex="-1" aria-labelledby="addsalesModallabel" aria-hidden="true">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="addsalesModallabel">New Sale</h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
									<form method="POST" action="includes/modal_config/add_sales_config.php">
                                    <div class="form-floating pb-2">
                                      <input type="date" name="date_out" class="form-control" required="required" id="floatingText" placeholder="Date Out">

                                      <label for="floatingText">Date Out</label>
                                    </div>
									
                                    <div class="form-floating pb-2">
                                      <input type="text" name="receipt_no" class="form-control" required="required" id="floatingText" placeholder="Receipt No">

                                      <label for="floatingText">Receipt No</label>
                                    </div>

                                    <div class="form-floating pb-2">
                                      <input type="text" name="item" class="form-control" required="required" id="floatingText" placeholder="Item">

                                      <label for="floatingText">Item</label>
                                    </div>

                                    <div class="form-floating pb-2">
                                      <input type="number" name="item_quantity_out" class="form-control" required="required" id="floatingText" placeholder="Quantity Out">

                                      <label for="floatingText">Quantity</label>
                                    </div>

                                    <div class="form-floating pb-2">
                                      <input type="text" name="quantity_type" class="form-control" required="required" id="floatingText" placeholder="Quantity Type">

                                      <label for="floatingText">Quantity type</label>
                                    </div>

                                    <div class="form-floating pb-2">
                                      <input type="number" name="selling_price" class="form-control" required="required" id="floatingText" placeholder="Selling price">

                                      <label for="floatingText">Selling price per item</label>
                                    </div>

                                    <div class="form-floating pb-2">
                                        <select class="form-select" id="selectCategory" name="cid" aria-label="Category">
                                            <?php include 'includes/get_category_options.php'; ?>
                                        </select>
                                        <label for="selectCategory">Category</label>
                                    </div>

                                    <div class="form-floating pb-2">
                                      <input type="text" name="printing_style" class="form-control" required="required" id="floatingText" placeholder="Printing style">

                                      <label for="floatingText">Printing style</label>
                                    </div>

                                    <div class="form-floating pb-2">
                                      <input type="text" name="mode_of_payment" class="form-control" required="required" id="floatingText" placeholder="Mode of Payment">

                                      <label for="floatingText">Mode of Payemnt</label>
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
						  
