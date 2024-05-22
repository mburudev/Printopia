<div class="modal fade" id="categoryModal" tabindex="-1" aria-labelledby="categoryModallabel" aria-hidden="true">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="categoryModallabel">New Category</h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
									<form method="POST" action="includes/modal_config/add_category_config.php">

                                    <div class="form-floating pb-2">
                                      <input type="text" name="category_name" class="form-control" required="required" id="floatingText" placeholder="Category Name">

                                      <label for="floatingText">Product Category</label>
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
						  
