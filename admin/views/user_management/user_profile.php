<?php 
	// load up system core files (config and authentication)
	require_once("../../resources/config.inc.php");
	require_once("../../resources/auth.inc.php");
	// Set page title
	$title = 'User Profile';
	$userprofile_active = "active";
	// Include template files from resources (header and Navigations)
	require_once(LAYOUT_PATH . "/header.php");

    require_once(LAYOUT_PATH . "/sideBar.php");
    require_once(LAYOUT_PATH . "/topBar.php");

    if (isset($_GET['vid'])) { 
    	$get_user_code = strtoupper($_GET['vid']); 
    	// User details
	    $sql001 = $db_connect->prepare("SELECT * FROM users WHERE user_active_status!=3 AND user_code=:xuser_code ORDER BY user_id DESC ");
	    $sql001->execute(array(':xuser_code' => $get_user_code));
	    if($sql001->rowCount() > 0)
	    {
	    	$counter = 1;
	        while($row001=$sql001->fetch(PDO::FETCH_ASSOC))
			{
				extract($row001); 
				$us_code = $row001['user_code'];
				$us_fname = $row001['user_fname'];
				$us_lname = $row001['user_lname'];
				$us_active_status = $row001['user_active_status'];
				$us_email = $row001['user_email'];
				$us_account_type = $row001['user_account_type'];
				$us_account = $row001['user_account'];
				$last_login_at = $row001['last_seen_at'];

				$us_profile_pic = $row001['user_profile_pic'];

				if ($row001['user_profile_pic'] != "") {
					$photo_directory00 = UPLOADS_PATH.'users/'.$user_profile_pic;
				} else {
					$photo_directory00 = UPLOADS_PATH.'templates/avatar.jpg';
				}
			}
		}

	} else { 
		$get_user_code = ""; 
		$user_code = "";
	}
    
?>
<style>

	/*------------------------------------------------*/
	/*    Profile Page
	/*------------------------------------------------*/
	.user-profile {
	  padding-bottom: 30px;
	}
	.profile-header-background {
	  width: 100%;
	  height: 310px;
	}
	.profile-header-background img {
	  width: 100%;
	  height: 100%;
	  object-fit: cover;
	  object-position: center;
	}

	.profile-info-left {
	  position: relative;
	  top: -92px;
	}
	.profile-info-left img.avatar {
	  border: 2px solid #fff;
	}


	.profile-info-right .tab-content {
	  padding: 30px 0;
	  background-color: transparent;
	}
	@media screen and (max-width: 768px) {
	  .profile-info-right {
	    position: relative;
	    top: -70px;
	  }
	}


	.activity-item {
	  overflow: visible;
	  position: relative;
	  margin: 15px 0;
	  border-top: 1px dashed #ccc;
	  padding-top: 15px;
	}
	.activity-item:first-child {
	  border-top: none;
	}
	.activity-item .media-body {
	  position: relative;
	}
	.activity-item .activity-title {
	  margin-bottom: 0;
	  line-height: 1.3;
	}
</style>

	<div class="page-heading noselect">
	    <div class="page-title">
	        <div class="row">
	            <div class="col-12 col-md-6 order-md-1 order-first">
	                <h3>User Profile</h3>
	                <?php if(!empty($us_code)): ?>
	                	<p class="text-subtitle text-muted">Hello <?php echo $us_fname; ?>, this is your profile.</p>
	                <?php endif ?>
	            </div>
	            <div class="col-12 col-md-6 order-md-2 order-last">
	            	<div class="float-start float-lg-end">            	
		                <?php if ($neo_user_permission == "1"): ?>
		                <a class="btn btn-md btn-primary mr-1 mb-1" href="<?php echo ADMIN_BASE_PATH.'views/user_management/users'; ?>"><span class="bi bi-grid bi-center"> </span> Manage Users </a>
		                <?php endif ?>
		                <a href="javascript:history.go(-1)" title="return to the previous page" class="btn btn-md btn-dark mb-1"><i class="bi bi-arrow-left-square bi-center"></i> <span class="d-none d-sm-inline-block">Back</span> </a>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>

	<section class="section noselect">
		<?php if(!empty($us_code)): ?>
	    <div class="row">
	        <div class="card">

	            <div class="user-profile px-4 py-5">
	                <div class="profile-header-background"><img src="<?php echo ASSETS_PATH.'/img/bg/profile_bg.jpg'; ?>" alt="Profile Header Background"></div>
	                <div class="row">
	                    <div class="col-12 col-lg-4 col-md-4 col-sm-12">
	                        <div class="profile-info-left">
	                            <div class="text-center">
	                                <img width="60%" src="<?php echo $photo_directory00; ?>" alt="Avatar" class="avatar img-fluid">
	                                <h2 class="py-3"><?php echo $us_fname.' '.$us_lname; ?></h2>
	                            </div>
	                            <div class="action-buttons">
	                                <div class=" d-flex align-items-center">
                                		<?php if ($neo_user_edit == "1"): ?>
                                	  	<!-- Update user -->
                                        <a type="button" data-id="<?php echo $us_code;?>" data-role="update_user" class="btn btn-md m-1 py-1 btn-block btn-primary font-weight-bold edit_user"><i class="bi bi-pencil-square bi-center"></i> <span class="d-none d-md-inline">Edit</span> </a>
                                        <!-- Enable and disable user account -->
                                        	<!-- Enable or disable user -->
                                        	<?php if ($us_active_status == 1): ?>
                                        	<a type="button" title="click to disable" data-id="<?php echo $us_code;?>" data-status="<?php echo $us_active_status;?>" class="btn btn-md m-1 py-1 btn-block btn-secondary font-weight-bold activate_status"><i class="bi bi-square-fill bi-center"></i> <span class="d-none d-md-inline">Disable</span> </a>
                                        	<?php else: ?>
                                        	<a type="button" title="click to enable" data-id="<?php echo $us_code;?>" data-status="<?php echo $us_active_status;?>" class="btn btn-md m-1 py-1 btn-block btn-success font-weight-bold activate_status"><i class="bi bi-check-square-fill bi-center"></i> <span class="d-none d-md-inline">Enable</span> </a>
                                        	<?php endif ?>
                                        <!-- // Enable and disable account -->
                                        <?php endif ?>
	                                </div>
	                            </div>
	                            <div class="section pt-4">
	                                <h4>Info</h4>
                                    <p><strong>Full Name:</strong> <?php echo $us_fname." ".$us_lname; ?></p>
                                    <p><strong>Email:</strong> <?php echo $us_email; ?></p>
                                	<p><strong>Account:</strong> <span class="badge <?php echo 'bg-'.$bg_color; ?>"><?php echo $us_account; ?></span></p>
                                    <p><strong>Account Type:</strong> <?php echo $us_account_type; ?></p>
                                    <p><strong>Last Login:</strong> <?php echo $last_login_at; ?></p>
	                            </div>
	                        </div>
	                    </div>
	                    <div class="col-12 col-lg-8 col-md-8 col-sm-12">

	                    	<?php 
            					// news
            					$stmt1 = $db_connect->prepare("SELECT * FROM permissions WHERE perm_page_permitted='news_page' AND perm_user_code='$us_code' ");
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
            	           		$stmt2 = $db_connect->prepare("SELECT * FROM permissions WHERE perm_page_permitted='blog_page' AND perm_user_code='$us_code' ");
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
            					// gallery
            	       			$stmt3 = $db_connect->prepare("SELECT * FROM permissions WHERE perm_page_permitted='gallery_page' AND perm_user_code='$us_code' ");
            	       		    $stmt3->execute();
            	       		    if($stmt3->rowCount() > 0)
            	       		    {
            	       		        while($row3=$stmt3->fetch(PDO::FETCH_ASSOC))
            	       		        {
            	       		           	extract($row3); 
            	       		           	$gal_permission = $row3["perm_action_permitted"];
            	       		           	$gal_add = $row3["perm_add"];
            	       				 	$gal_edit = $row3["perm_edit"];
            	       					$gal_read = $row3["perm_read"];
            							$gal_delete = $row3["perm_delete"];
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
            					// users
            	           		$stmt4 = $db_connect->prepare("SELECT * FROM permissions WHERE perm_page_permitted='users_page' AND perm_user_code='$us_code' ");
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
            	           		$stmt6 = $db_connect->prepare("SELECT * FROM permissions WHERE perm_page_permitted='gallery_page' AND perm_user_code='$us_code' ");
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
            	           		$stmt7 = $db_connect->prepare("SELECT * FROM permissions WHERE perm_page_permitted='settings_page' AND perm_user_code='$us_code' ");
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
            	           		$stmt8 = $db_connect->prepare("SELECT * FROM permissions WHERE perm_page_permitted='media_page' AND perm_user_code='$us_code' ");
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
            	           		$stmt9 = $db_connect->prepare("SELECT * FROM permissions WHERE perm_page_permitted='event_page' AND perm_user_code='$us_code' ");
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
            		       		$stmt10 = $db_connect->prepare("SELECT * FROM permissions WHERE perm_page_permitted='advert_page' AND perm_user_code='$us_code' ");
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
            		       		$stmt11 = $db_connect->prepare("SELECT * FROM permissions WHERE perm_page_permitted='sales_page' AND perm_user_code='$us_code' ");
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
					       		$stmt12 = $db_connect->prepare("SELECT * FROM permissions WHERE perm_page_permitted='contacts_page' AND perm_user_code='$us_code' ");
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

	                    	<!-- Hidden items passed in for editing in user_list -->
	                    		<a id="<?php echo $us_code; ?>ususer_code" style="display: none;"><?php echo $us_code; ?></a>
	                    		<a id="<?php echo $us_code; ?>ususer_fname" style="display: none;"><?php echo $us_fname; ?></a>
	                    		<a id="<?php echo $us_code; ?>ususer_lname" style="display: none;"><?php echo $us_lname; ?></a>
	                    		<a id="<?php echo $us_code; ?>ususer_active_status" style="display: none;"><?php echo $us_active_status; ?></a>
	                    		<a id="<?php echo $us_code; ?>ususer_profile_pic" style="display: none;"><?php echo $us_profile_pic; ?></a>
	                    		<a id="<?php echo $us_code; ?>ususer_img_url" style="display: none;"><?php echo $photo_directory00; ?></a>
	                    		<a id="<?php echo $us_code; ?>ususer_email" style="display: none;"><?php echo $us_email; ?></a>
	                    		<a id="<?php echo $us_code; ?>ususer_account_type" style="display: none;"><?php echo $us_account_type; ?></a>
	                    		<a id="<?php echo $us_code; ?>ususer_account" style="display: none;"><?php echo $us_account; ?></a>
	                    		<a id="<?php echo $us_code; ?>uslast_seen_at" style="display: none;"><?php echo $last_login_at; ?></a>

	                    		<!-- User -->
	                    		<a id="<?php echo $us_code; ?>ususer_permission" style="display: none;"><?php echo $user_permission; ?></a>
	                    		<a id="<?php echo $us_code; ?>ususer_add" style="display: none;"><?php echo $user_add; ?></a>
	                    		<a id="<?php echo $us_code; ?>ususer_edit" style="display: none;"><?php echo $user_edit; ?></a>
	                    		<a id="<?php echo $us_code; ?>ususer_read" style="display: none;"><?php echo $user_read; ?></a>
	                    		<a id="<?php echo $us_code; ?>ususer_delete" style="display: none;"><?php echo $user_delete; ?></a>
	                    		<!-- settings -->
	                    		<a id="<?php echo $us_code; ?>usset_permission" style="display: none;"><?php echo $set_permission; ?></a>
	                    		<a id="<?php echo $us_code; ?>usset_add" style="display: none;"><?php echo $set_add; ?></a>
	                    		<a id="<?php echo $us_code; ?>usset_edit" style="display: none;"><?php echo $set_edit; ?></a>
	                    		<a id="<?php echo $us_code; ?>usset_read" style="display: none;"><?php echo $set_read; ?></a>
	                    		<a id="<?php echo $us_code; ?>usset_delete" style="display: none;"><?php echo $set_delete; ?></a>
	                    		<!-- news -->
	                    		<a id="<?php echo $us_code; ?>usnews_permission" style="display: none;"><?php echo $news_permission; ?></a>
	                    		<a id="<?php echo $us_code; ?>usnews_add" style="display: none;"><?php echo $news_add; ?></a>
	                    		<a id="<?php echo $us_code; ?>usnews_edit" style="display: none;"><?php echo $news_edit; ?></a>
	                    		<a id="<?php echo $us_code; ?>usnews_read" style="display: none;"><?php echo $news_read; ?></a>
	                    		<a id="<?php echo $us_code; ?>usnews_delete" style="display: none;"><?php echo $news_delete; ?></a>
	                    		<!-- blogs -->
	                    		<a id="<?php echo $us_code; ?>usblog_permission" style="display: none;"><?php echo $blog_permission; ?></a>
	                    		<a id="<?php echo $us_code; ?>usblog_add" style="display: none;"><?php echo $blog_add; ?></a>
	                    		<a id="<?php echo $us_code; ?>usblog_edit" style="display: none;"><?php echo $blog_edit; ?></a>
	                    		<a id="<?php echo $us_code; ?>usblog_read" style="display: none;"><?php echo $blog_read; ?></a>
	                    		<a id="<?php echo $us_code; ?>usblog_delete" style="display: none;"><?php echo $blog_delete; ?></a>
	                    		<!-- gallery -->
	                    		<a id="<?php echo $us_code; ?>usgal_permission" style="display: none;"><?php echo $gal_permission; ?></a>
	                    		<a id="<?php echo $us_code; ?>usgal_add" style="display: none;"><?php echo $gal_add; ?></a>
	                    		<a id="<?php echo $us_code; ?>usgal_edit" style="display: none;"><?php echo $gal_edit; ?></a>
	                    		<a id="<?php echo $us_code; ?>usgal_read" style="display: none;"><?php echo $gal_read; ?></a>
	                    		<a id="<?php echo $us_code; ?>usgal_delete" style="display: none;"><?php echo $gal_delete; ?></a>
	                    		<!-- media -->
	                    		<a id="<?php echo $us_code; ?>usmed_permission" style="display: none;"><?php echo $med_permission; ?></a>
	                    		<a id="<?php echo $us_code; ?>usmed_add" style="display: none;"><?php echo $med_add; ?></a>
	                    		<a id="<?php echo $us_code; ?>usmed_edit" style="display: none;"><?php echo $med_edit; ?></a>
	                    		<a id="<?php echo $us_code; ?>usmed_read" style="display: none;"><?php echo $med_read; ?></a>
	                    		<a id="<?php echo $us_code; ?>usmed_delete" style="display: none;"><?php echo $med_delete; ?></a>
	                    		<!-- events -->
	                    		<a id="<?php echo $us_code; ?>useve_permission" style="display: none;"><?php echo $eve_permission; ?></a>
	                    		<a id="<?php echo $us_code; ?>useve_add" style="display: none;"><?php echo $eve_add; ?></a>
	                    		<a id="<?php echo $us_code; ?>useve_edit" style="display: none;"><?php echo $eve_edit; ?></a>
	                    		<a id="<?php echo $us_code; ?>useve_read" style="display: none;"><?php echo $eve_read; ?></a>
	                    		<a id="<?php echo $us_code; ?>useve_delete" style="display: none;"><?php echo $eve_delete; ?></a>
	                    		<!-- adverts -->
	                    		<a id="<?php echo $us_code; ?>usadv_permission" style="display: none;"><?php echo $adv_permission; ?></a>
	                    		<a id="<?php echo $us_code; ?>usadv_add" style="display: none;"><?php echo $adv_add; ?></a>
	                    		<a id="<?php echo $us_code; ?>usadv_edit" style="display: none;"><?php echo $adv_edit; ?></a>
	                    		<a id="<?php echo $us_code; ?>usadv_read" style="display: none;"><?php echo $adv_read; ?></a>
	                    		<a id="<?php echo $us_code; ?>usadv_delete" style="display: none;"><?php echo $adv_delete; ?></a>
	                    		<!-- sales -->
	                    		<a id="<?php echo $us_code; ?>ussal_permission" style="display: none;"><?php echo $sal_permission; ?></a>
	                    		<a id="<?php echo $us_code; ?>ussal_add" style="display: none;"><?php echo $sal_add; ?></a>
	                    		<a id="<?php echo $us_code; ?>ussal_edit" style="display: none;"><?php echo $sal_edit; ?></a>
	                    		<a id="<?php echo $us_code; ?>ussal_read" style="display: none;"><?php echo $sal_read; ?></a>
	                    		<a id="<?php echo $us_code; ?>ussal_delete" style="display: none;"><?php echo $sal_delete; ?></a>
	                    		<!-- contacts -->
	                    		<a id="<?php echo $us_code; ?>uscon_permission" style="display: none;"><?php echo $con_permission; ?></a>
	                    		<a id="<?php echo $us_code; ?>uscon_add" style="display: none;"><?php echo $con_add; ?></a>
	                    		<a id="<?php echo $us_code; ?>uscon_edit" style="display: none;"><?php echo $con_edit; ?></a>
	                    		<a id="<?php echo $us_code; ?>uscon_read" style="display: none;"><?php echo $con_read; ?></a>
	                    		<a id="<?php echo $us_code; ?>uscon_delete" style="display: none;"><?php echo $con_delete; ?></a>
	                    	<!-- Hidden items passed in for editing in user_list -->

	                    	<div class="add_modal_container">
	                    		<!-- form-modals/add-modals/add_user -->
	                    	</div>
	                    	<div class="edit_modal_container">
	                    		<!-- form-modals/edit-modals/edit_user -->
	                    	</div>

	                        <div class="mx-3">
	                            <div class="text-uppercase font-weight-heavy mt-5"><h5><strong>Activities</strong></h5> </div>
	                            <div class="content">
	                                <!-- activities -->
	                                <div class="tab-pane active" id="activities">
	                                	<?php 
                                	    	// User details
                                		    $sql002 = $db_connect->prepare("SELECT act_sess_user_code, act_sess_action, act_sess_time, act_sess_status, act_sess_created_at FROM history_logs WHERE act_sess_user_code=:xact_sess_user_code ORDER BY act_sess_id DESC ");
                                		    $sql002->execute(array(':xact_sess_user_code' => $us_code));
                                		    if($sql002->rowCount() > 0)
                                		    {
                                		    	$counter = 1;
                                		        while($row002=$sql002->fetch(PDO::FETCH_ASSOC))
                                				{
                                					extract($row002); 
	                                	?>
	                                    <div class="media activity-item">
	                                        <div class="media-body">
	                                            <p class="activity-title">
	                                            	<a href="#"><?php echo $act_sess_status; ?></a> : <?php echo $act_sess_action; ?> - 
	                                            	<small class="text-muted"><em><?php echo date('l, dS F Y', strtotime($act_sess_created_at))." at ".date('H.i.s A', strtotime($act_sess_created_at)); ?></em></small> 
	                                        	</p>
	                                        </div>
	                                    </div>
	                                    <?php 
                                				}
                                			}
                                			else {
	                                	?>
	                                	<div class="row mt-3">
                            		        <div class="col-md-12 col-12 col-lg-12 col-sm-12">
                            		        	<div class="alert alert-warning"><strong><i class="bi bi-exclamation-triangle bi-center"></i> There is no activity history to display.</strong></div>
                            		        </div>
	                                	</div>
	                                    <?php 
                                			}
	                                	?> 
	                                </div>
	                                <!-- // activities -->
	                            </div>
	                        </div>
	                    </div>
	                </div>
	            </div>

	        </div>
	    </div>
	    <?php endif ?>
	</section>

	<!-- Logout modaly is loaded here -->
	<div id="signOut">
		
	</div>


<script>
	var us_url = "./Users.js";
	$.getScript(us_url);
</script>

<?php 
	// Include header
	require_once(LAYOUT_PATH . "/footer.php");  
?>