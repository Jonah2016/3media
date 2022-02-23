<!-- Modal -->
<div class="modal modal-blur fade noselect" id="addNewUserModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<!-- modal-dialog -->
	<div class="modal-dialog modal-lg" role="document" style="width: 100%;">
		<!-- modal-content -->
		<div class="modal-content">

			<div class="modal-body mx-auto text-left">
				<form method="post" id="add_user_form" novalidate enctype="multipart/form-data">
                    <div class="card-header mb-4">
                        <h4 class="weight-700">User Registration Form</h4>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="user_image" class="form-control-label">Profile Photo</label>
                                <p><img src="" class="display_img" height="100" width="100" /></p>
                                <input id="user_image" class="input-group form-control form-control-sm" type="file" name="user_image" accept="image/*" onchange="previewImage(event)">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="user_fname" class="form-control-label">First name<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="user_fname" id="user_fname" placeholder="First name" required="required">
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="user_lname" class="form-control-label">Last name<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="user_lname" id="user_lname" placeholder="Last name" required="required">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="user_account" class="form-control-label">Account <span class="text-danger">*</span></label>
                                <select name="user_account" id="user_account" required="required" class="form-control form-select">
                                    <option value="">Select one</option>
                                    <option value="super">Super Account</option>
                                    <option value="user">User Account</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 showAccountType">
                            <div class="form-group">
                                <label for="user_account_type" class="form-control-label">Account type<span class="text-danger">*</span></label>
                                <select name="user_account_type" id="user_account_type" required="required" class="form-control form-select">
                                    <option value="">Select one</option>
                                    <option value="editorial">General Editor</option>
                                    <option value="news">News Editor</option>
                                    <option value="commercial">Commercial Manager</option>
                                    <option value="accountant">Accountant</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <label for="user_email" class="form-control-label">Email<span class="text-danger">*</span></label>
                                <input type="email" class="form-control" name="user_email" id="user_email" placeholder="Email address" required="required">
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <label for="user_password" class="form-control-label">Password<span class="text-danger">*</span></label>
                                <input type="password" class="form-control" name="user_password" id="user_password" placeholder="Password" required="required">
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <label for="confirm_user_password" class="form-control-label">Confirm password<span class="text-danger">*</span></label>
                                <input type="password" class="form-control" name="confirm_user_password" id="confirm_user_password" placeholder="Confirm password" required="required">
                            </div>
                        </div>
                    </div>

                    <!-- Authorizations -->
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Page</th>
                                        <th>Permission</th>
                                        <th>Add</th>
                                        <th>Edit</th>
                                        <th>Read</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- users -->
                                    <tr>
                                        <td>Users Page</td>
                                        <td>
                                            <label class="check_container p-2">
                                                <input type="checkbox" class="user_permission" name="user_permission" value="1">
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <label class="check_container p-2">
                                                <input type="checkbox" class="user_add" name="user_add" value="1">
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <label class="check_container p-2">
                                                <input type="checkbox" class="user_edit" name="user_edit" value="1">
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <label class="check_container p-2">
                                                <input type="checkbox" class="user_read" name="user_read" value="1">
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <label class="check_container p-2">
                                                <input type="checkbox" class="user_delete" name="user_delete" value="1">
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                    </tr>
                                    <!-- settings -->
                                    <tr>
                                        <td>Settings Page</td>
                                        <td>
                                            <label class="check_container p-2">
                                                <input type="checkbox" class="set_permission" name="set_permission" value="1">
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <label class="check_container p-2">
                                                <input type="checkbox" class="set_add" name="set_add" value="1">
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <label class="check_container p-2">
                                                <input type="checkbox" class="set_edit" name="set_edit" value="1">
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <label class="check_container p-2">
                                                <input type="checkbox" class="set_read" name="set_read" value="1">
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <label class="check_container p-2">
                                                <input type="checkbox" class="set_delete" name="set_delete" value="1">
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                    </tr>
                                    <!-- News -->
                                    <tr>
                                        <td>News Page</td>
                                        <td>
                                            <label class="check_container p-2">
                                                <input type="checkbox" class="news_permission" name="news_permission" value="1">
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <label class="check_container p-2">
                                                <input type="checkbox" class="news_add" name="news_add" value="1">
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <label class="check_container p-2">
                                                <input type="checkbox" class="news_edit" name="news_edit" value="1">
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <label class="check_container p-2">
                                                <input type="checkbox" class="news_read" name="news_read" value="1">
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <label class="check_container p-2">
                                                <input type="checkbox" class="news_delete" name="news_delete" value="1">
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                    </tr>
                                    <!-- Blog -->
                                    <tr>
                                        <td>Blog Page</td>
                                        <td>
                                            <label class="check_container p-2">
                                                <input type="checkbox" class="blog_permission" name="blog_permission" value="1">
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <label class="check_container p-2">
                                                <input type="checkbox" class="blog_add" name="blog_add" value="1">
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <label class="check_container p-2">
                                                <input type="checkbox" class="blog_edit" name="blog_edit" value="1">
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <label class="check_container p-2">
                                                <input type="checkbox" class="blog_read" name="blog_read" value="1">
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <label class="check_container p-2">
                                                <input type="checkbox" class="blog_delete" name="blog_delete" value="1">
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                    </tr>
                                    <!-- Gallery -->
                                    <tr>
                                        <td>Gallery Page</td>
                                        <td>
                                            <label class="check_container p-2">
                                                <input type="checkbox" class="gal_permission" name="gal_permission" value="1">
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <label class="check_container p-2">
                                                <input type="checkbox" class="gal_add" name="gal_add" value="1">
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <label class="check_container p-2">
                                                <input type="checkbox" class="gal_edit" name="gal_edit" value="1">
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <label class="check_container p-2">
                                                <input type="checkbox" class="gal_read" name="gal_read" value="1">
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <label class="check_container p-2">
                                                <input type="checkbox" class="gal_delete" name="gal_delete" value="1">
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                    </tr>
                                    <!-- Media -->
                                    <tr>
                                        <td>Media Page</td>
                                        <td>
                                            <label class="check_container p-2">
                                                <input type="checkbox" class="med_permission" name="med_permission" value="1">
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <label class="check_container p-2">
                                                <input type="checkbox" class="med_add" name="med_add" value="1">
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <label class="check_container p-2">
                                                <input type="checkbox" class="med_edit" name="med_edit" value="1">
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <label class="check_container p-2">
                                                <input type="checkbox" class="med_read" name="med_read" value="1">
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <label class="check_container p-2">
                                                <input type="checkbox" class="med_delete" name="med_delete" value="1">
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                    </tr>
                                    <!-- Events -->
                                    <tr>
                                        <td>Events Page</td>
                                        <td>
                                            <label class="check_container p-2">
                                                <input type="checkbox" class="eve_permission" name="eve_permission" value="1">
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <label class="check_container p-2">
                                                <input type="checkbox" class="eve_add" name="eve_add" value="1">
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <label class="check_container p-2">
                                                <input type="checkbox" class="eve_edit" name="eve_edit" value="1">
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <label class="check_container p-2">
                                                <input type="checkbox" class="eve_read" name="eve_read" value="1">
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <label class="check_container p-2">
                                                <input type="checkbox" class="eve_delete" name="eve_delete" value="1">
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                    </tr>
                                    <!-- Adverts -->
                                    <tr>
                                        <td>Adverts Page</td>
                                        <td>
                                            <label class="check_container p-2">
                                                <input type="checkbox" class="adv_permission" name="adv_permission" value="1">
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <label class="check_container p-2">
                                                <input type="checkbox" class="adv_add" name="adv_add" value="1">
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <label class="check_container p-2">
                                                <input type="checkbox" class="adv_edit" name="adv_edit" value="1">
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <label class="check_container p-2">
                                                <input type="checkbox" class="adv_read" name="adv_read" value="1">
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <label class="check_container p-2">
                                                <input type="checkbox" class="adv_delete" name="adv_delete" value="1">
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                    </tr>
                                    <!-- Sales -->
                                    <tr>
                                        <td>Sales Page</td>
                                        <td>
                                            <label class="check_container p-2">
                                                <input type="checkbox" class="sal_permission" name="sal_permission" value="1">
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <label class="check_container p-2">
                                                <input type="checkbox" class="sal_add" name="sal_add" value="1">
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <label class="check_container p-2">
                                                <input type="checkbox" class="sal_edit" name="sal_edit" value="1">
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <label class="check_container p-2">
                                                <input type="checkbox" class="sal_read" name="sal_read" value="1">
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <label class="check_container p-2">
                                                <input type="checkbox" class="sal_delete" name="sal_delete" value="1">
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                    </tr>
                                    <!-- Contacts -->
                                    <tr>
                                        <td>Contacts & Subscriptions Page</td>
                                        <td>
                                            <label class="check_container p-2">
                                                <input type="checkbox" class="con_permission" name="con_permission" value="1">
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <label class="check_container p-2">
                                                <input type="checkbox" class="con_add" name="con_add" value="1">
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <label class="check_container p-2">
                                                <input type="checkbox" class="con_edit" name="con_edit" value="1">
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <label class="check_container p-2">
                                                <input type="checkbox" class="con_read" name="con_read" value="1">
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <label class="check_container p-2">
                                                <input type="checkbox" class="con_delete" name="con_delete" value="1">
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- // End Authorizations -->
                                    
                    <div class="row mb-3 mt-3">
			            <div class="col-md-4 offset-md-2">
                            <input type="hidden" value="1" name="user_active_status" id="user_active_status">
                            <button type="submit" class="btn btn-lg btn-primary btn-block"><i class="bi bi-save2 bi-center"></i> Save</button>
                        </div>
                        <div class="col-md-4">
                            <button type="button" class="btn btn-lg btn-block btn-danger" data-bs-dismiss="modal"><i class="bi bi-x-square bi-center"></i> Close</button>
                        </div>
                    </div>
		            
		        </form>
			</div>

		</div>
		<!-- // modal-content -->
	</div>
	<!--// modal-dialog -->
</div>
<!-- // modal -->


<script>
    //hide of unhide user_account_type when 'user_account' is chosen 
    $(document).on('change', '#user_account', function(event) {
        event.preventDefault();
        var ctrl = $(this);
        var dataValue  = ctrl.find(':selected').val();

        if (dataValue == "super") { $('.showAccountType').hide(); }  else{ $('.showAccountType').show(); }
    });
</script>