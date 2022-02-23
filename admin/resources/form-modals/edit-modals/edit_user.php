<!-- Modal -->
<div class="modal modal-blur fade noselect editUserModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<!-- modal-dialog -->
	<div class="modal-dialog modal-lg" role="document" style="width: 100%;">
		<!-- modal-content -->
		<div class="modal-content">

			<div class="modal-body mx-auto mt-xl-3 mt-lg-3 mt-md-3 mt-sm-3 text-left">
				<form method="post" class="edit_user_form" novalidate enctype="multipart/form-data">
                    <div class="card-header mb-4">
                        <h4 class="weight-700">User Update Form</h4>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="ed_user_code" class="form-control-label">Profile ID</label>
                                <input type="text" class="form-control ed_user_code" name="ed_user_code" placeholder="Profile ID" required readonly>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="ed_user_image" class="form-control-label">Profile Photo</label>
                                <p><img src="" id="display_img" class="display_img" height="100" width="100" /></p>
                                <input class="input-group form-control ed_user_image" type="file" name="ed_user_image" onchange="previewImage(event)" accept="image/*" >
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="ed_user_fname" class="form-control-label">First name<span class="text-danger">*</span></label>
                                <input type="text" class="form-control ed_user_fname" name="ed_user_fname" placeholder="First name" required="required">
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="ed_user_lname" class="form-control-label">Last name<span class="text-danger">*</span></label>
                                <input type="text" class="form-control ed_user_lname" name="ed_user_lname" placeholder="Last name" required="required">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="ed_user_account" class="form-control-label">Account <span class="text-danger">*</span></label>
                                <select name="ed_user_account" required="required" class="form-control form-select ed_user_account">
                                    <option value="">Select one</option>
                                    <option value="super">Super Account</option>
                                    <option value="user">User Account</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 edShowAccountType">
                            <div class="form-group">
                                <label for="ed_user_account_type" class="form-control-label">Account type<span class="text-danger">*</span></label>
                                <select name="ed_user_account_type" required="required" class="form-control form-select ed_user_account_type">
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
                                <label for="ed_user_email" class="form-control-label">Email<span class="text-danger">*</span></label>
                                <input type="email" class="form-control ed_user_email" autocomplete="off" name="ed_user_email" placeholdr="Email address">
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <label for="ed_user_password" class="form-control-label">Password</label>
                                <input type="password" class="form-control ed_user_password" autocomplete="off" name="ed_user_password" placeholder="Password">
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <label for="ed_confirm_user_password" class="form-control-label">Confirm password</label>
                                <input type="password" class="form-control ed_confirm_user_password" autocomplete="off" name="ed_confirm_user_password" placeholder="Confirm password" >
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
                                                <input type="checkbox" class="user_permission" name="ed_user_permission" value="1">
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <label class="check_container p-2">
                                                <input type="checkbox" class="user_add" name="ed_user_add" value="1">
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <label class="check_container p-2">
                                                <input type="checkbox" class="user_edit" name="ed_user_edit" value="1">
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <label class="check_container p-2">
                                                <input type="checkbox" class="user_read" name="ed_user_read" value="1">
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <label class="check_container p-2">
                                                <input type="checkbox" class="user_delete" name="ed_user_delete" value="1">
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                    </tr>
                                    <!-- settings -->
                                    <tr>
                                        <td>Settings Page</td>
                                        <td>
                                            <label class="check_container p-2">
                                                <input type="checkbox" class="set_permission" name="ed_set_permission" value="1">
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <label class="check_container p-2">
                                                <input type="checkbox" class="set_add" name="ed_set_add" value="1">
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <label class="check_container p-2">
                                                <input type="checkbox" class="set_edit" name="ed_set_edit" value="1">
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <label class="check_container p-2">
                                                <input type="checkbox" class="set_read" name="ed_set_read" value="1">
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <label class="check_container p-2">
                                                <input type="checkbox" class="set_delete" name="ed_set_delete" value="1">
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                    </tr>
                                    <!-- News -->
                                    <tr>
                                        <td>News Page</td>
                                        <td>
                                            <label class="check_container p-2">
                                                <input type="checkbox" class="news_permission" name="ed_news_permission" value="1">
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <label class="check_container p-2">
                                                <input type="checkbox" class="news_add" name="ed_news_add" value="1">
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <label class="check_container p-2">
                                                <input type="checkbox" class="news_edit" name="ed_news_edit" value="1">
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <label class="check_container p-2">
                                                <input type="checkbox" class="news_read" name="ed_news_read" value="1">
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <label class="check_container p-2">
                                                <input type="checkbox" class="news_delete" name="ed_news_delete" value="1">
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                    </tr>
                                    <!-- Blog -->
                                    <tr>
                                        <td>Blog Page</td>
                                        <td>
                                            <label class="check_container p-2">
                                                <input type="checkbox" class="blog_permission" name="ed_blog_permission" value="1">
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <label class="check_container p-2">
                                                <input type="checkbox" class="blog_add" name="ed_blog_add" value="1">
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <label class="check_container p-2">
                                                <input type="checkbox" class="blog_edit" name="ed_blog_edit" value="1">
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <label class="check_container p-2">
                                                <input type="checkbox" class="blog_read" name="ed_blog_read" value="1">
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <label class="check_container p-2">
                                                <input type="checkbox" class="blog_delete" name="ed_blog_delete" value="1">
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                    </tr>
                                    <!-- Gallery -->
                                    <tr>
                                        <td>Gallery Page</td>
                                        <td>
                                            <label class="check_container p-2">
                                                <input type="checkbox" class="gal_permission" name="ed_gal_permission" value="1">
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <label class="check_container p-2">
                                                <input type="checkbox" class="gal_add" name="ed_gal_add" value="1">
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <label class="check_container p-2">
                                                <input type="checkbox" class="gal_edit" name="ed_gal_edit" value="1">
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <label class="check_container p-2">
                                                <input type="checkbox" class="gal_read" name="ed_gal_read" value="1">
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <label class="check_container p-2">
                                                <input type="checkbox" class="gal_delete" name="ed_gal_delete" value="1">
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                    </tr>
                                    <!-- Media -->
                                    <tr>
                                        <td>Media Page</td>
                                        <td>
                                            <label class="check_container p-2">
                                                <input type="checkbox" class="med_permission" name="ed_med_permission" value="1">
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <label class="check_container p-2">
                                                <input type="checkbox" class="med_add" name="ed_med_add" value="1">
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <label class="check_container p-2">
                                                <input type="checkbox" class="med_edit" name="ed_med_edit" value="1">
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <label class="check_container p-2">
                                                <input type="checkbox" class="med_read" name="ed_med_read" value="1">
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <label class="check_container p-2">
                                                <input type="checkbox" class="med_delete" name="ed_med_delete" value="1">
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                    </tr>
                                    <!-- Events -->
                                    <tr>
                                        <td>Events Page</td>
                                        <td>
                                            <label class="check_container p-2">
                                                <input type="checkbox" class="eve_permission" name="ed_eve_permission" value="1">
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <label class="check_container p-2">
                                                <input type="checkbox" class="eve_add" name="ed_eve_add" value="1">
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <label class="check_container p-2">
                                                <input type="checkbox" class="eve_edit" name="ed_eve_edit" value="1">
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <label class="check_container p-2">
                                                <input type="checkbox" class="eve_read" name="ed_eve_read" value="1">
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <label class="check_container p-2">
                                                <input type="checkbox" class="eve_delete" name="ed_eve_delete" value="1">
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                    </tr>
                                    <!-- Adverts -->
                                    <tr>
                                        <td>Adverts Page</td>
                                        <td>
                                            <label class="check_container p-2">
                                                <input type="checkbox" class="adv_permission" name="ed_adv_permission" value="1">
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <label class="check_container p-2">
                                                <input type="checkbox" class="adv_add" name="ed_adv_add" value="1">
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <label class="check_container p-2">
                                                <input type="checkbox" class="adv_edit" name="ed_adv_edit" value="1">
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <label class="check_container p-2">
                                                <input type="checkbox" class="adv_read" name="ed_adv_read" value="1">
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <label class="check_container p-2">
                                                <input type="checkbox" class="adv_delete" name="ed_adv_delete" value="1">
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                    </tr>
                                    <!-- Sales -->
                                    <tr>
                                        <td>Sales Page</td>
                                        <td>
                                            <label class="check_container p-2">
                                                <input type="checkbox" class="sal_permission" name="ed_sal_permission" value="1">
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <label class="check_container p-2">
                                                <input type="checkbox" class="sal_add" name="ed_sal_add" value="1">
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <label class="check_container p-2">
                                                <input type="checkbox" class="sal_edit" name="ed_sal_edit" value="1">
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <label class="check_container p-2">
                                                <input type="checkbox" class="sal_read" name="ed_sal_read" value="1">
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <label class="check_container p-2">
                                                <input type="checkbox" class="sal_delete" name="ed_sal_delete" value="1">
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                    </tr>
                                    <!-- Contacts -->
                                    <tr>
                                        <td>Contacts & Subscriptions Page</td>
                                        <td>
                                            <label class="check_container p-2">
                                                <input type="checkbox" class="con_permission" name="ed_con_permission" value="1">
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <label class="check_container p-2">
                                                <input type="checkbox" class="con_add" name="ed_con_add" value="1">
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <label class="check_container p-2">
                                                <input type="checkbox" class="con_edit" name="ed_con_edit" value="1">
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <label class="check_container p-2">
                                                <input type="checkbox" class="con_read" name="ed_con_read" value="1">
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <label class="check_container p-2">
                                                <input type="checkbox" class="con_delete" name="ed_con_delete" value="1">
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- // End Authorizations -->
                    
                    <div class="row my-4">
			            <div class="col-md-4 offset-md-2">
                            <input type="hidden" name="ed_user_active_status" class="ed_user_active_status">
                            <input type="hidden" name="ed_hidden_user_pic" class="ed_hidden_user_pic">
                            <input type="hidden" name="ed_hidden_user_id" class="ed_hidden_user_id">
                            <button type="submit" class="btn btn-lg btn-primary btn-block"><i class="bi bi-save2 bi-center"></i> Update</button>
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
    $(document).on('change', '.ed_user_account', function(event) {
        event.preventDefault();
        var ctrl = $(this);
        var dataValue  = ctrl.find(':selected').val();

        if (dataValue == "super") { $('.edShowAccountType').hide(); }  else{ $('.edShowAccountType').show(); }
    });
</script>
