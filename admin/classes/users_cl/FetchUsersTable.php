<?php require_once("../../resources/auth.inc.php"); ?>

<div class="card">
	<!-- Descriptions -->
	<div class="card-body p-4 text-center">
		<div class="table-responsive">
			<table class="table display nowrap dataTable-table table-bordered" id="very_simple_table" cellspacing="0" width="100%">
				<thead>
			        <tr class="headingTr bgLightGrey">
			        	<th><em class="fas fa-check-square"></em></th>
						<th> # </th>
						<th> Profile ID</th>
						<th> Active Status </th>
						<th> Onlie Status </th>
						<th> Full Name</th>
						<th> Email </th>
						<th> Account </th>
						<th> Account type </th>
						<th> Last Seen </th>
						<th> Created At </th>
						<th> Updated At </th>
						<?php if ($neo_user_add == "1" || $neo_user_edit == "1" || $neo_user_delete == "1"): ?>
						<th> Action </th>
						<?php endif ?>
			        </tr>
				</thead>
				<tbody>
					<?php
					     
					    $stmt = $db_connect->prepare("SELECT * FROM users WHERE user_active_status!=3 ORDER BY user_id DESC ");
					    $stmt->execute();
					    if($stmt->rowCount() > 0)
					    {
					    	$counter = 1;
					        while($row=$stmt->fetch(PDO::FETCH_ASSOC))
							{
								extract($row); 
								$user_code01 = $row['user_code'];
								$user_profile_pic = $row['user_profile_pic'];

								if ($row['user_account_type'] == "super") { $new_user_account_type = "Super Admin"; }
								else if ($row['user_account_type'] == "editorial") { $new_user_account_type = "General Editor"; }
								else if ($row['user_account_type'] == "news") { $new_user_account_type = "News Editor"; }
								else if ($row['user_account_type'] == "commercial") { $new_user_account_type = "Commercial Manager"; }
								else if ($row['user_account_type'] == "accountant") { $new_user_account_type = "Accountant"; }

								$user_account = $row['user_account'];
								if ($row['user_account'] == "super") {
									$bg_color = "info";
								} 
								elseif ($row['user_account'] == "user") {
									$bg_color = "primary";
								}
								
								if ($row['user_profile_pic'] != "") {
									$photo_directory = UPLOADS_PATH.'users/'.$user_profile_pic;
								} else {
									$photo_directory = UPLOADS_PATH.'templates/avatar.jpg';
								}

								$user_active_status = $row['user_active_status'];

								// news
								$stmt1 = $db_connect->prepare("SELECT * FROM permissions WHERE perm_page_permitted='news_page' AND perm_user_code='$user_code01' ");
							    $stmt1->execute();
							    if($stmt1->rowCount() > 0)
							    {
							        while($row1=$stmt1->fetch(PDO::FETCH_ASSOC))
							        {
							           	extract($row1); 
							           	$news_permission = $row1["perm_action_permitted"];
							           	$news_add = $row1["perm_add"];
									 	$news_edit = $row1["perm_edit"];
										$news_read = $row1["perm_read"];
										$news_delete = $row1["perm_delete"];
									}
								}else{
									$news_permission = "0";
						           	$news_add = "0";
								 	$news_edit = "0";
									$news_read = "0";
									$news_delete = "0";
								}
								// blogs
				           		$stmt2 = $db_connect->prepare("SELECT * FROM permissions WHERE perm_page_permitted='blog_page' AND perm_user_code='$user_code01' ");
				           	    $stmt2->execute();
				           	    if($stmt2->rowCount() > 0)
				           	    {
				           	        while($row2=$stmt2->fetch(PDO::FETCH_ASSOC))
				           	        {
				           	           	extract($row2); 
				           	           	$blog_permission = $row2["perm_action_permitted"];
				           	           	$blog_add = $row2["perm_add"];
				           			 	$blog_edit = $row2["perm_edit"];
				           				$blog_read = $row2["perm_read"];
										$blog_delete = $row2["perm_delete"];
				           			}
				           		}else{
									$blog_permission = "0";
						           	$blog_add = "0";
								 	$blog_edit = "0";
									$blog_read = "0";
									$blog_delete = "0";
								}
								// users
				           		$stmt4 = $db_connect->prepare("SELECT * FROM permissions WHERE perm_page_permitted='users_page' AND perm_user_code='$user_code01' ");
				           	    $stmt4->execute();
				           	    if($stmt4->rowCount() > 0)
				           	    {
				           	        while($row4=$stmt4->fetch(PDO::FETCH_ASSOC))
				           	        {
				           	           	extract($row4); 
				           	           	$user_permission = $row4["perm_action_permitted"];
				           	           	$user_add = $row4["perm_add"];
				           			 	$user_edit = $row4["perm_edit"];
				           				$user_read = $row4["perm_read"];
										$user_delete = $row4["perm_delete"];
				           			}
				           		}
					           	else
					           	{
									$user_permission = "0";
						           	$user_add = "0";
								 	$user_edit = "0";
									$user_read = "0";
									$user_delete = "0";
								}
								// gallery
				           		$stmt6 = $db_connect->prepare("SELECT * FROM permissions WHERE perm_page_permitted='gallery_page' AND perm_user_code='$user_code01' ");
				           	    $stmt6->execute();
				           	    if($stmt6->rowCount() > 0)
				           	    {
				           	        while($row6=$stmt6->fetch(PDO::FETCH_ASSOC))
				           	        {
				           	           	extract($row6); 
				           	           	$gal_permission = $row6["perm_action_permitted"];
				           	           	$gal_add = $row6["perm_add"];
				           			 	$gal_edit = $row6["perm_edit"];
				           				$gal_read = $row6["perm_read"];
										$gal_delete = $row6["perm_delete"];
				           			}
				           		}
					           	else
					           	{
									$gal_permission = "0";
						           	$gal_add = "0";
								 	$gal_edit = "0";
									$gal_read = "0";
									$gal_delete = "0";
								}
								// settings
				           		$stmt7 = $db_connect->prepare("SELECT * FROM permissions WHERE perm_page_permitted='settings_page' AND perm_user_code='$user_code01' ");
				           	    $stmt7->execute();
				           	    if($stmt7->rowCount() > 0)
				           	    {
				           	        while($row7=$stmt7->fetch(PDO::FETCH_ASSOC))
				           	        {
				           	           	extract($row7); 
				           	           	$set_permission = $row7["perm_action_permitted"];
				           	           	$set_add = $row7["perm_add"];
				           			 	$set_edit = $row7["perm_edit"];
				           				$set_read = $row7["perm_read"];
										$set_delete = $row7["perm_delete"];
				           			}
				           		}
					           	else
					           	{
									$set_permission = "0";
						           	$set_add = "0";
								 	$set_edit = "0";
									$set_read = "0";
									$set_delete = "0";
								}
								// media
				           		$stmt8 = $db_connect->prepare("SELECT * FROM permissions WHERE perm_page_permitted='media_page' AND perm_user_code='$user_code01' ");
				           	    $stmt8->execute();
				           	    if($stmt8->rowCount() > 0)
				           	    {
				           	        while($row8=$stmt8->fetch(PDO::FETCH_ASSOC))
				           	        {
				           	           	extract($row8); 
				           	           	$med_permission = $row8["perm_action_permitted"];
				           	           	$med_add = $row8["perm_add"];
				           			 	$med_edit = $row8["perm_edit"];
				           				$med_read = $row8["perm_read"];
										$med_delete = $row8["perm_delete"];
				           			}
				           		}
					           	else
					           	{
									$med_permission = "0";
						           	$med_add = "0";
								 	$med_edit = "0";
									$med_read = "0";
									$med_delete = "0";
								}
								// events
				           		$stmt9 = $db_connect->prepare("SELECT * FROM permissions WHERE perm_page_permitted='event_page' AND perm_user_code='$user_code01' ");
				           	    $stmt9->execute();
				           	    if($stmt9->rowCount() > 0)
				           	    {
				           	        while($row9=$stmt9->fetch(PDO::FETCH_ASSOC))
				           	        {
				           	           	extract($row9); 
				           	           	$eve_permission = $row9["perm_action_permitted"];
				           	           	$eve_add = $row9["perm_add"];
				           			 	$eve_edit = $row9["perm_edit"];
				           				$eve_read = $row9["perm_read"];
										$eve_delete = $row9["perm_delete"];
				           			}
				           		}
					           	else
					           	{
									$eve_permission = "0";
						           	$eve_add = "0";
								 	$eve_edit = "0";
									$eve_read = "0";
									$eve_delete = "0";
								}
								// adverts
					       		$stmt10 = $db_connect->prepare("SELECT * FROM permissions WHERE perm_page_permitted='advert_page' AND perm_user_code='$user_code01' ");
					       	    $stmt10->execute();
					       	    if($stmt10->rowCount() > 0)
					       	    {
					       	        while($row10=$stmt10->fetch(PDO::FETCH_ASSOC))
					       	        {
					       	           	extract($row10); 
					       	           	$adv_permission = $row10["perm_action_permitted"];
					       	           	$adv_add = $row10["perm_add"];
					       			 	$adv_edit = $row10["perm_edit"];
					       				$adv_read = $row10["perm_read"];
										$adv_delete = $row10["perm_delete"];
					       			}
					       		}
					           	else
					           	{
									$adv_permission = "0";
						           	$adv_add = "0";
								 	$adv_edit = "0";
									$adv_read = "0";
									$adv_delete = "0";
								}
								// sales
					       		$stmt11 = $db_connect->prepare("SELECT * FROM permissions WHERE perm_page_permitted='sales_page' AND perm_user_code='$user_code01' ");
					       	    $stmt11->execute();
					       	    if($stmt11->rowCount() > 0)
					       	    {
					       	        while($row11=$stmt11->fetch(PDO::FETCH_ASSOC))
					       	        {
					       	           	extract($row11); 
					       	           	$sal_permission = $row11["perm_action_permitted"];
					       	           	$sal_add = $row11["perm_add"];
					       			 	$sal_edit = $row11["perm_edit"];
					       				$sal_read = $row11["perm_read"];
										$sal_delete = $row11["perm_delete"];
					       			}
					       		}
					           	else
					           	{
									$sal_permission = "0";
						           	$sal_add = "0";
								 	$sal_edit = "0";
									$sal_read = "0";
									$sal_delete = "0";
								}
								// contacts
					       		$stmt12 = $db_connect->prepare("SELECT * FROM permissions WHERE perm_page_permitted='contacts_page' AND perm_user_code='$user_code01' ");
					       	    $stmt12->execute();
					       	    if($stmt12->rowCount() > 0)
					       	    {
					       	        while($row12=$stmt12->fetch(PDO::FETCH_ASSOC))
					       	        {
					       	           	extract($row12); 
					       	           	$con_permission = $row12["perm_action_permitted"];
					       	           	$con_add = $row12["perm_add"];
					       			 	$con_edit = $row12["perm_edit"];
					       				$con_read = $row12["perm_read"];
										$con_delete = $row12["perm_delete"];
					       			}
					       		}
					           	else
					           	{
									$con_permission = "0";
						           	$con_add = "0";
								 	$con_edit = "0";
									$con_read = "0";
									$con_delete = "0";
								}

					?>
					<tr class="text-uppercase" id="<?php echo $row["user_code"]; ?>">
						<td></td>
						<td><?php echo $counter++; ?></td>
					    <td><a href="<?php echo ADMIN_BASE_PATH.'views/user_management/user_profile?vid='.strtolower($user_code); ?>"><?php echo $row["user_code"]; ?></a></td>
					    <td align="center">
					    	<?php if ($row['user_active_status'] == 1): ?>
						    	<span class='badge bg-success p-2'><small> Active </small></span>
						    <?php else: ?>
						    	<span class='badge bg-danger p-2'><small> Disabled </small></span>
						    <?php endif ?>
					    </td>
						<td align="center">
					    	<?php 
						    	if ($row['user_online_status'] == 1) {
						    	 	echo "<span class='badge bg-success heart_pump p-2'><small> Online </small></span>";
						    	}
						    	else {
						    	 	echo "<span class='badge bg-danger p-2'><small>Offline</small></span>";
						    	}
					    	?>
					    </td>
						
						<!-- Hidden items passed in for editing in user_list -->
						<a id="<?php echo $row['user_code']; ?>ususer_code" style="display: none;"><?php echo $row['user_code']; ?></a>
						<a id="<?php echo $row['user_code']; ?>ususer_fname" style="display: none;"><?php echo $row['user_fname']; ?></a>
						<a id="<?php echo $row['user_code']; ?>ususer_lname" style="display: none;"><?php echo $row['user_lname']; ?></a>
						<a id="<?php echo $row['user_code']; ?>ususer_active_status" style="display: none;"><?php echo $row['user_active_status']; ?></a>
						<a id="<?php echo $row['user_code']; ?>ususer_profile_pic" style="display: none;"><?php echo $row['user_profile_pic']; ?></a>
						<a id="<?php echo $row['user_code']; ?>ususer_img_url" style="display: none;"><?php echo $photo_directory; ?></a>
						<a id="<?php echo $row['user_code']; ?>ususer_email" style="display: none;"><?php echo $row['user_email']; ?></a>
						<a id="<?php echo $row['user_code']; ?>ususer_account_type" style="display: none;"><?php echo $row['user_account_type']; ?></a>
						<a id="<?php echo $row['user_code']; ?>ususer_account" style="display: none;"><?php echo $row['user_account']; ?></a>
						<a id="<?php echo $row['user_code']; ?>uslast_seen_at" style="display: none;"><?php echo $row['last_seen_at']; ?></a>

						<!-- User -->
						<a id="<?php echo $row['user_code']; ?>ususer_permission" style="display: none;"><?php echo $user_permission; ?></a>
						<a id="<?php echo $row['user_code']; ?>ususer_add" style="display: none;"><?php echo $user_add; ?></a>
						<a id="<?php echo $row['user_code']; ?>ususer_edit" style="display: none;"><?php echo $user_edit; ?></a>
						<a id="<?php echo $row['user_code']; ?>ususer_read" style="display: none;"><?php echo $user_read; ?></a>
						<a id="<?php echo $row['user_code']; ?>ususer_delete" style="display: none;"><?php echo $user_delete; ?></a>
						<!-- settings -->
						<a id="<?php echo $row['user_code']; ?>usset_permission" style="display: none;"><?php echo $set_permission; ?></a>
						<a id="<?php echo $row['user_code']; ?>usset_add" style="display: none;"><?php echo $set_add; ?></a>
						<a id="<?php echo $row['user_code']; ?>usset_edit" style="display: none;"><?php echo $set_edit; ?></a>
						<a id="<?php echo $row['user_code']; ?>usset_read" style="display: none;"><?php echo $set_read; ?></a>
						<a id="<?php echo $row['user_code']; ?>usset_delete" style="display: none;"><?php echo $set_delete; ?></a>
						<!-- news -->
						<a id="<?php echo $row['user_code']; ?>usnews_permission" style="display: none;"><?php echo $news_permission; ?></a>
						<a id="<?php echo $row['user_code']; ?>usnews_add" style="display: none;"><?php echo $news_add; ?></a>
						<a id="<?php echo $row['user_code']; ?>usnews_edit" style="display: none;"><?php echo $news_edit; ?></a>
						<a id="<?php echo $row['user_code']; ?>usnews_read" style="display: none;"><?php echo $news_read; ?></a>
						<a id="<?php echo $row['user_code']; ?>usnews_delete" style="display: none;"><?php echo $news_delete; ?></a>
						<!-- blogs -->
						<a id="<?php echo $row['user_code']; ?>usblog_permission" style="display: none;"><?php echo $blog_permission; ?></a>
						<a id="<?php echo $row['user_code']; ?>usblog_add" style="display: none;"><?php echo $blog_add; ?></a>
						<a id="<?php echo $row['user_code']; ?>usblog_edit" style="display: none;"><?php echo $blog_edit; ?></a>
						<a id="<?php echo $row['user_code']; ?>usblog_read" style="display: none;"><?php echo $blog_read; ?></a>
						<a id="<?php echo $row['user_code']; ?>usblog_delete" style="display: none;"><?php echo $blog_delete; ?></a>
						<!-- gallery -->
						<a id="<?php echo $row['user_code']; ?>usgal_permission" style="display: none;"><?php echo $gal_permission; ?></a>
						<a id="<?php echo $row['user_code']; ?>usgal_add" style="display: none;"><?php echo $gal_add; ?></a>
						<a id="<?php echo $row['user_code']; ?>usgal_edit" style="display: none;"><?php echo $gal_edit; ?></a>
						<a id="<?php echo $row['user_code']; ?>usgal_read" style="display: none;"><?php echo $gal_read; ?></a>
						<a id="<?php echo $row['user_code']; ?>usgal_delete" style="display: none;"><?php echo $gal_delete; ?></a>
						<!-- media -->
						<a id="<?php echo $row['user_code']; ?>usmed_permission" style="display: none;"><?php echo $med_permission; ?></a>
						<a id="<?php echo $row['user_code']; ?>usmed_add" style="display: none;"><?php echo $med_add; ?></a>
						<a id="<?php echo $row['user_code']; ?>usmed_edit" style="display: none;"><?php echo $med_edit; ?></a>
						<a id="<?php echo $row['user_code']; ?>usmed_read" style="display: none;"><?php echo $med_read; ?></a>
						<a id="<?php echo $row['user_code']; ?>usmed_delete" style="display: none;"><?php echo $med_delete; ?></a>
						<!-- events -->
						<a id="<?php echo $row['user_code']; ?>useve_permission" style="display: none;"><?php echo $eve_permission; ?></a>
						<a id="<?php echo $row['user_code']; ?>useve_add" style="display: none;"><?php echo $eve_add; ?></a>
						<a id="<?php echo $row['user_code']; ?>useve_edit" style="display: none;"><?php echo $eve_edit; ?></a>
						<a id="<?php echo $row['user_code']; ?>useve_read" style="display: none;"><?php echo $eve_read; ?></a>
						<a id="<?php echo $row['user_code']; ?>useve_delete" style="display: none;"><?php echo $eve_delete; ?></a>
						<!-- adverts -->
						<a id="<?php echo $row['user_code']; ?>usadv_permission" style="display: none;"><?php echo $adv_permission; ?></a>
						<a id="<?php echo $row['user_code']; ?>usadv_add" style="display: none;"><?php echo $adv_add; ?></a>
						<a id="<?php echo $row['user_code']; ?>usadv_edit" style="display: none;"><?php echo $adv_edit; ?></a>
						<a id="<?php echo $row['user_code']; ?>usadv_read" style="display: none;"><?php echo $adv_read; ?></a>
						<a id="<?php echo $row['user_code']; ?>usadv_delete" style="display: none;"><?php echo $adv_delete; ?></a>
						<!-- sales -->
						<a id="<?php echo $row['user_code']; ?>ussal_permission" style="display: none;"><?php echo $sal_permission; ?></a>
						<a id="<?php echo $row['user_code']; ?>ussal_add" style="display: none;"><?php echo $sal_add; ?></a>
						<a id="<?php echo $row['user_code']; ?>ussal_edit" style="display: none;"><?php echo $sal_edit; ?></a>
						<a id="<?php echo $row['user_code']; ?>ussal_read" style="display: none;"><?php echo $sal_read; ?></a>
						<a id="<?php echo $row['user_code']; ?>ussal_delete" style="display: none;"><?php echo $sal_delete; ?></a>
						<!-- contacts -->
						<a id="<?php echo $row['user_code']; ?>uscon_permission" style="display: none;"><?php echo $con_permission; ?></a>
						<a id="<?php echo $row['user_code']; ?>uscon_add" style="display: none;"><?php echo $con_add; ?></a>
						<a id="<?php echo $row['user_code']; ?>uscon_edit" style="display: none;"><?php echo $con_edit; ?></a>
						<a id="<?php echo $row['user_code']; ?>uscon_read" style="display: none;"><?php echo $con_read; ?></a>
						<a id="<?php echo $row['user_code']; ?>uscon_delete" style="display: none;"><?php echo $con_delete; ?></a>
						<!-- Hidden items passed in for editing in user_list -->

					    <td><?php echo $row['user_fname']." ".$row['user_lname']; ?></td>
					    <td><?php echo $row['user_email']; ?></td>
						<td><span class="badge <?php echo 'bg-'.$bg_color; ?>"><?php echo $row['user_account']; ?></span></td>
					    <td><?php echo $user_account_type; ?></td>
					    <td><?php echo $row['last_seen_at']; ?></td>
					    <td><?php echo $row['created_at']; ?></td>
					    <td><?php echo $row['updated_at']; ?></td>
					    <?php if ($neo_user_add == "1" || $neo_user_edit == "1" || $neo_user_delete == "1"): ?>
					    <td>
					    	<div class="dropdown">
					    	    <button class="btn btn-sm btn-info dropdown-toggle dropdown-toggle-split" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >Actions
					    	    <i class="caret"></i></button>
					    	    <ul class="dropdown-menu dropdown-menu-right p-2" >
					    	    	<?php if ($neo_user_edit == "1"): ?>
					    	      	<!-- Update user -->
					    	      	<li class="pb-2">
					    	      		<a type="button" data-id="<?php echo $row['user_code'];?>" data-role="update_user" class="btn btn-sm py-1 btn-block btn-primary font-weight-bold edit_user"><i class="bi bi-pencil-square bi-center"></i> <span class="d-none d-md-inline">Edit</span> </a>
					    	      	</li>
					    	      	<!-- Enable and disable user account -->
					    	      	<li class="pb-2">
					    	      		<!-- Enable or disable user -->
					    	      		<?php if ($row['user_active_status'] == 1): ?>
					    	      		<a type="button" title="click to disable" data-id="<?php echo $row['user_code'];?>" data-status="<?php echo $row['user_active_status'];?>" class="btn btn-sm py-1 btn-block btn-secondary font-weight-bold activate_status"><i class="bi bi-square-fill bi-center"></i> <span class="d-none d-md-inline">Disable</span> </a>
					    	      		<?php else: ?>
					    	      		<a type="button" title="click to enable" data-id="<?php echo $row['user_code'];?>" data-status="<?php echo $row['user_active_status'];?>" class="btn btn-sm py-1 btn-block btn-success font-weight-bold activate_status"><i class="bi bi-check-square-fill bi-center"></i> <span class="d-none d-md-inline">Enable</span> </a>
					    	      		<?php endif ?>
					    	      	</li>
					    	      	<!-- // Enable and disable account -->
					    	      	<?php endif ?>
					    	      	<?php if ($neo_user_delete == "1"): ?>
					    	      	<!-- Delete user -->
					    	      	<li class="pb-1">
					    	      		<a href="#" data-id="<?php echo $row['user_code'];?>" class="btn btn-sm py-1 btn-block btn-danger font-weight-bold delete_user"><i class="bi bi-trash bi-center"></i> <span class="d-none d-md-inline">Delete</span> </a>
					    	      	</li>
					    	      	<?php endif ?>
					    	    </ul>
					    	</div>
					    </td>
					    <?php endif ?>
					</tr>
					<?php  
							}
						} 
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<!-- Settings For tables with ID=very_simple_table -->
<script>
    $(document).ready(function() {
        $.fn.dataTable.ext.errMode = 'throw';
        $('#very_simple_table').DataTable({
        destroy: true,
        paging: true,
        "autoWidth": true,
        "fixedHeader": true,
        "info": false,
        searching: true,
        dom: 'Blfrtip',
        buttons: [
            { extend: 'pdf' , exportOptions: {columns: ':visible', rows: ':visible'}, footer: true, orientation: 'landscape', className: 'btn btn-sm' },
            { extend: 'colvis', collectionLayout: 'three-column', prefixButtons: [{extend: 'colvisGroup', text: 'Show all', show: ':hidden'}, {extend: 'colvisRestore',text: 'Restore'}], className: 'btn btn-sm' } 
        ],
        columnDefs: [ {
                  orderable: false,
                  className: 'select-checkbox',
                  targets:   0
              } ],
              select: {
                  style:    'os',
                  selector: 'td:first-child'
              },

              scrollY: "600px",
              scrollX: true,
              scrollCollapse: true,
              fixedColumns:{ leftColumns: 5 },
              paging: true
        } );
     
    } );
</script>
<!-- // End Settings For tables with ID=very_simple_table -->