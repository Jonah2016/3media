<?php require_once("../../resources/auth.inc.php"); ?>

<div class="row">
	<?php		
		$stmt = $db_connect->prepare("SELECT * FROM award_performers WHERE awp_active_status!=3 ORDER BY awp_id DESC ");
		$stmt->execute();
		if($stmt->rowCount() > 0)
		{
			$counter = 1;
			while($row=$stmt->fetch(PDO::FETCH_ASSOC))
			{
				extract($row); 
				$awp_image = $row['awp_image'];
				$photo_directory = ($awp_image != "") ? UPLOADS_PATH.'awards/'.$awp_image : UPLOADS_PATH.'templates/no_photo.png';
				$awp_fullname = $row['awp_fullname'];
				$awp_year = $row['awp_year'];
				$awp_description = $row['awp_description'];
	?>
	<div class="col-12 col-lg-3 col-md-3 col-sm-12 mb-2">
		<div class="card">
		    <div class="card-content" align="center">
		        <img class="card-img-top img-fluid" src="<?php echo $photo_directory; ?>" alt="event performer" style="height: 15rem">
		        <span class="badge bg-danger p-3 mt-1 mb-1 ml-3" style="position: absolute; left:0"><?php echo $counter++; ?></span>
		        <div class="card-body">
		            <h4 class="card-title"><?php echo $row['awp_fullname']; ?></h4>
		            <p class="card-text">
		                <div class="mt-3"> 
		                    <button class="btn btn-info btn-sm mb-1" data-name="<?php echo $awp_fullname; ?>" data-desc="<?php echo htmlentities($awp_description); ?>" onclick="PopUpPerformerDesc(this)">View Description</button> 
		                </div>
		                <div class="mt-3 bg-warning text-dark px-2 py-1"><strong>Year: </strong> <?php if($awp_year != ''){ echo $awp_year; }else{ echo '---'; } ?></div>
		                <div class="mt-2"><small><strong>Created at: </strong> <?php if($row['awp_created_at'] !== '0000-00-00 00:00:00'){ echo $row['awp_created_at']; }else{ echo '---'; } ?></small></div>
		                <div class="mt-1"><small><strong>Updated at: </strong> <?php if($row['awp_updated_at'] !== '0000-00-00 00:00:00'){ echo $row['awp_updated_at']; }else{ echo '---'; } ?></small></div>
		            </p>  
		        </div>
		        <!-- Action buttons -->
		        <?php if ($neo_eve_add == "1" || $neo_eve_edit == "1" || $neo_eve_delete == "1"): ?>
		        <div class="card-footer d-flex justify-content-center mx-0">
		            <?php if ($neo_eve_edit == "1"): ?>
		                <!-- Edit award performer -->
		                <a type="button" data-id="<?php echo $row['awp_hashed'];?>" data-role="edit_performer" class="btn mx-auto text-primary font-weight-bold edit_performer"><i class="bi bi-pencil-square bi-center"></i> <span class="d-none d-md-inline">Edit</span> </a>
		                <!-- Enable or disable award performer -->
		                <?php if ($row['awp_active_status'] == 1): ?>
		                <a type="button" title="click to disable" data-id="<?php echo $row['awp_hashed'];?>" data-status="<?php echo $row['awp_active_status'];?>" class="btn mx-auto text-secondary font-weight-bold activate_performer"><i class="bi bi-square-fill bi-center"></i> <span class="d-none d-md-inline">Disable</span> </a>
		                <?php else: ?>
		                <a type="button" title="click to enable" data-id="<?php echo $row['awp_hashed'];?>" data-status="<?php echo $row['awp_active_status'];?>" class="btn mx-auto text-success font-weight-bold activate_performer"><i class="bi bi-check-square-fill bi-center"></i> <span class="d-none d-md-inline">Enable</span> </a>
		                <?php endif ?>
		            <?php endif ?>
		            <!-- Delete award performer -->
		            <?php if ($neo_eve_delete == "1"): ?>
		            <a href="#" data-id="<?php echo $row['awp_hashed'];?>" class="btn mx-auto text-danger font-weight-bold delete_performer"><i class="bi bi-trash bi-center"></i> <span class="d-none d-md-inline">Delete</span> </a>
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


<!-- nominee pop up modal -->
<div class="modal fade popUpPerformerFrame" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-lg" role="document" style="width: 100%;">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" class="weight-700 text-danger">&times;</span></button>
			</div>
			<div class="modal-body">
				<div class="performerDescDisplay"><p class="popUpPerformerDesc"></p></div>
			</div>
			<div class="modal-footer" align="center">
				<h5 class="text-center popUpPerformerTitle"></h5>
			</div>
		</div>
	</div>
</div> 


<script>
	// pop up nominee description
	function PopUpPerformerDesc(property){
		var name = $(property).data('name');
		var description =  $(property).data('desc');
		$('.popUpPerformerDesc').html(description).css({
			'min-width': '50%',
			'min-height': '300px',
			'max-height': '500px',
			'padding': '10px'
		});
		$('.performerDescDisplay').css({
			'display': 'flex',
			'justify-content': 'center',
			'align-items': 'center',
			'overflow-y': 'scroll'
		});
		$('.popUpPerformerTitle').text('Performer name: '+name);
		$('.popUpPerformerFrame').modal('show');
	} 
</script>


