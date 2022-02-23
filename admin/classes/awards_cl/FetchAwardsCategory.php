<?php require_once("../../resources/auth.inc.php"); ?>

<div class="row">
	<?php		
		$stmt = $db_connect->prepare("SELECT * FROM award_categories WHERE awc_active_status!=3 ORDER BY awc_title ASC, awc_id DESC ");
		$stmt->execute();
		if($stmt->rowCount() > 0)
		{
			$counter = 1;
			while($row=$stmt->fetch(PDO::FETCH_ASSOC))
			{
				extract($row); 
				$awc_cover_image = $row['awc_cover_image'];
				$photo_directory = ($awc_cover_image != "") ? UPLOADS_PATH.'awards/'.$awc_cover_image : UPLOADS_PATH.'templates/no_photo.png';
				$awc_title = $row['awc_title'];
				$awc_description = $row['awc_description'];
				$awc_years= explode(",", $row['awc_year']);
				sort($awc_years);
	?>
	<div class="col-12 col-lg-3 col-md-3 col-sm-12 mb-2">
		<div class="card ">
		    <div class="card-content" align="center">
		        <img class="card-img-top img-fluid" src="<?php echo $photo_directory; ?>" alt="award category" style="height: 15rem">
		        <span class="badge bg-danger p-2 mt-1 mb-1 ml-3" style="position: absolute; left:0"><?php echo $counter++; ?></span>
		        <div class="card-body">
		        	<?php foreach ($awc_years as $key => $year): ?>
		        	<span class="badge bg-success p-2 mt-1 mb-1 ml-3"><?php echo $year; ?></span>
		        	<?php endforeach ?>
		            <h4 class="card-title"><?php echo $row['awc_title']; ?></h4>
		            <p class="card-text">
		                <div class="mt-3"> 
		                    <button class="btn btn-info btn-sm" data-name='<?php echo $awc_title; ?>' data-bio="<?php echo htmlentities($row['awc_description']); ?>" onclick="PopUpAwardCategoryDesc(this)">View Award Description</button> 
		                </div>
		                <div class="mt-2"><small><strong>Created at: </strong> <?php if($row['awc_created_at'] !== '0000-00-00 00:00:00'){ echo $row['awc_created_at']; }else{ echo '---'; } ?></small></div>
		                <div class="mt-1"><small><strong>Updated at: </strong> <?php if($row['awc_updated_at'] !== '0000-00-00 00:00:00'){ echo $row['awc_updated_at']; }else{ echo '---'; } ?></small></div>
		            </p>  
		        </div>
		        <!-- Action buttons -->
		        <?php if ($neo_eve_add == "1" || $neo_eve_edit == "1" || $neo_eve_delete == "1"): ?>
		        <div class="card-footer d-flex justify-content-center mx-0">
		            <?php if ($neo_eve_edit == "1"): ?>
		                <!-- Edit award category -->
		                <a type="button" data-id="<?php echo $row['awc_hashed'];?>" data-role="edit_award_category" class="btn mx-auto text-primary font-weight-bold edit_award_category"><i class="bi bi-pencil-square bi-center"></i> <span class="d-none d-md-inline">Edit</span> </a>
		                <!-- Enable or disable award category -->
		                <?php if ($row['awc_active_status'] == 1): ?>
		                <a type="button" title="click to disable" data-id="<?php echo $row['awc_hashed'];?>" data-status="<?php echo $row['awc_active_status'];?>" class="btn mx-auto text-secondary font-weight-bold activate_award_category"><i class="bi bi-square-fill bi-center"></i> <span class="d-none d-md-inline">Disable</span> </a>
		                <?php else: ?>
		                <a type="button" title="click to enable" data-id="<?php echo $row['awc_hashed'];?>" data-status="<?php echo $row['awc_active_status'];?>" class="btn mx-auto text-success font-weight-bold activate_award_category"><i class="bi bi-check-square-fill bi-center"></i> <span class="d-none d-md-inline">Enable</span> </a>
		                <?php endif ?>
		            <?php endif ?>
		            <!-- Delete award category -->
		            <?php if ($neo_eve_delete == "1"): ?>
		            <a href="#" data-id="<?php echo $row['awc_hashed'];?>" class="btn mx-auto text-danger font-weight-bold delete_award_category"><i class="bi bi-trash bi-center"></i> <span class="d-none d-md-inline">Delete</span> </a>
		            <?php endif ?>
		        </div>
		        <?php endif ?>
		        <!-- // Action buttons -->
		    </div>
		</div>
	</div>
	<?php  
			}
		} 
	?>
</div>


<!-- video pop up modal -->
<div class="modal fade popUpAwardCategoryFrame" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-lg" role="document" style="width: 100%;">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" class="weight-700 text-danger">&times;</span></button>
			</div>
			<div class="modal-body">
				<div class="awardCategoryDescDisplay"><p class="popUpAwardCategoryDesc"></p></div>
			</div>
			<div class="modal-footer" align="center">
				<h5 class="text-center popUpAwardCategoryTitle"></h5> <!--caption appears under the popup image-->
			</div>
		</div>
	</div>
</div>
<!-- Image pop up modal -->
<div class="modal fade popUpPhotoFrame" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-lg" role="document" style="width: 100%;">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" class="weight-700 text-danger">&times;</span></button>
			</div>
			<div class="modal-body">
				<div class="photoDisplay"><img class="popUpPhoto" src="" alt="video thumbnail" /></div>
			</div>
			<div class="modal-footer" align="center">
				<h5 class="text-center popUpPhotoTitle"></h5> <!--caption appears under the popup image-->
			</div>
		</div>
	</div>
</div>

<!-- Settings for tables with class=simple_table -->
<script>
	// pop up video image
	function PopUpAwardCategoryDesc(property){
		var name = $(property).data('name');
		var video =  $(property).data('bio');
		$('.popUpAwardCategoryDesc').html(video).css({
			'min-width': '50%',
			'min-height': '300px',
			'max-height': '500px',
			'padding': '10px'
		});
		$('.awardCategoryDescDisplay').css({
			'display': 'flex',
			'justify-content': 'center',
			'align-items': 'center',
			'overflow-y': 'scroll'
		});
		$('.popUpAwardCategoryTitle').text('Award name: '+name);
		$('.popUpAwardCategoryFrame').modal('show');
	}
	// pop up video image
	function PopUpImage(property){
		var img_url = property.src;
		var img_title = property.alt;
		$('.popUpPhoto').attr('src', img_url).css({
			'min-width': '50%',
			'min-height': '300px',
			'max-height': '500px'
		});
		$('.photoDisplay').css({
			'display': 'flex',
			'justify-content': 'center',
			'align-items': 'center',
			'overflow': 'hidden'
		});
		$('.popUpPhotoTitle').text(img_title);
		$('.popUpPhotoFrame').modal('show');
	}
</script>
<!-- // End Settings for tables with class=simple_table -->


