<?php require_once("../../resources/auth.inc.php"); ?>

<div class="row">
	<?php		
		$stmt = $db_connect->prepare("SELECT * FROM award_nominees WHERE awn_active_status!=3 ORDER BY awn_id DESC ");
		$stmt->execute();
		if($stmt->rowCount() > 0)
		{
			$counter = 1;
			while($row=$stmt->fetch(PDO::FETCH_ASSOC))
			{
				extract($row); 
				$awn_cover_image = $row['awn_cover_image'];
				$photo_directory = ($awn_cover_image != "") ? UPLOADS_PATH.'awards/'.$awn_cover_image : UPLOADS_PATH.'templates/no_photo.png';
				$awn_fullname = $row['awn_fullname'];
				$awn_category = $row['awn_category'];
				$awn_year = $row['awn_year'];
				$awn_type = $row['awn_type'];
				$awn_biography = $row['awn_biography'];
	?>
	<div class="col-12 col-lg-3 col-md-3 col-sm-12 mb-2">
		<div class="card">
		    <div class="card-content" align="center">
		        <img class="card-img-top img-fluid" src="<?php echo $photo_directory; ?>" alt="award nominee" style="height: 15rem">
		        <span class="badge bg-danger p-3 mt-1 mb-1 ml-3" style="position: absolute; left:0"><?php echo $counter++; ?></span>
		        <?php if ($row['awn_win_status'] == 1): ?>
		        	<span class="badge bg-success p-3 mt-1 mb-1 mr-3" style="position: absolute; right:0"><i class="bi bi-trophy bi-center"></i></span>
		        <?php endif ?>
		        <div class="card-body">
		            <h4 class="card-title"><?php echo $row['awn_fullname']; ?></h4>
		            <p class="card-text">
		                <div class="mt-3"> 
		                    <button class="btn btn-info btn-sm mb-1" data-name="<?php echo $awn_fullname; ?>" data-bio="<?php echo htmlentities($awn_biography); ?>" onclick="PopUpNomineesDesc(this)">View Biography</button> 
		                    <!-- Toggle award winner -->
		                    <?php if ($row['awn_win_status'] == 1): ?>
		                    <button class="btn btn-secondary btn-sm mb-1 activate_winner" title="click to disable winner" data-id="<?php echo $row['awn_hashed'];?>" data-status="<?php echo $row['awn_win_status'];?>">Disable winner</button> 
		                    <?php else: ?>
		                    <button class="btn btn-success btn-sm mb-1 activate_winner" title="click to enable winner" data-id="<?php echo $row['awn_hashed'];?>" data-status="<?php echo $row['awn_win_status'];?>"> Enable winner</button>
		                    <?php endif ?>
		                </div>
		                <div class="mt-3 bg-warning text-dark px-2 py-1"><strong>Year: </strong> <?php if($awn_year != ''){ echo $awn_year; }else{ echo '---'; } ?></div>
		                <div class="mt-1 bg-faded text-dark px-2 py-1"><strong>Type: </strong> <?php if($awn_type != ''){ echo $awn_type; }else{ echo '---'; } ?></div>
		                <div class="mt-1 bg-faded text-dark px-2 py-1"><strong>Category: </strong> <?php if($awn_category != ''){ echo $awn_category; }else{ echo '---'; } ?></div>
		                <div class="mt-2"><small><strong>Created at: </strong> <?php if($row['awn_created_at'] !== '0000-00-00 00:00:00'){ echo $row['awn_created_at']; }else{ echo '---'; } ?></small></div>
		                <div class="mt-1"><small><strong>Updated at: </strong> <?php if($row['awn_updated_at'] !== '0000-00-00 00:00:00'){ echo $row['awn_updated_at']; }else{ echo '---'; } ?></small></div>
		            </p>  
		        </div>
		        <!-- Action buttons -->
		        <?php if ($neo_eve_add == "1" || $neo_eve_edit == "1" || $neo_eve_delete == "1"): ?>
		        <div class="card-footer d-flex justify-content-center mx-0">
		            <?php if ($neo_eve_edit == "1"): ?>
		                <!-- Edit award nominee -->
		                <a type="button" data-id="<?php echo $row['awn_hashed'];?>" data-role="edit_nominee" class="btn mx-auto text-primary font-weight-bold edit_nominee"><i class="bi bi-pencil-square bi-center"></i> <span class="d-none d-md-inline">Edit</span> </a>
		                <!-- Enable or disable award nominee -->
		                <?php if ($row['awn_active_status'] == 1): ?>
		                <a type="button" title="click to disable" data-id="<?php echo $row['awn_hashed'];?>" data-status="<?php echo $row['awn_active_status'];?>" class="btn mx-auto text-secondary font-weight-bold activate_nominee"><i class="bi bi-square-fill bi-center"></i> <span class="d-none d-md-inline">Disable</span> </a>
		                <?php else: ?>
		                <a type="button" title="click to enable" data-id="<?php echo $row['awn_hashed'];?>" data-status="<?php echo $row['awn_active_status'];?>" class="btn mx-auto text-success font-weight-bold activate_nominee"><i class="bi bi-check-square-fill bi-center"></i> <span class="d-none d-md-inline">Enable</span> </a>
		                <?php endif ?>
		            <?php endif ?>
		            <!-- Delete award nominee -->
		            <?php if ($neo_eve_delete == "1"): ?>
		            <a href="#" data-id="<?php echo $row['awn_hashed'];?>" class="btn mx-auto text-danger font-weight-bold delete_nominee"><i class="bi bi-trash bi-center"></i> <span class="d-none d-md-inline">Delete</span> </a>
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
<div class="modal fade popUpNomineesFrame" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-lg" role="document" style="width: 100%;">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" class="weight-700 text-danger">&times;</span></button>
			</div>
			<div class="modal-body">
				<div class="nomineesDescDisplay"><p class="popUpNomineesDesc"></p></div>
			</div>
			<div class="modal-footer" align="center">
				<h5 class="text-center popUpNomineesTitle"></h5>
			</div>
		</div>
	</div>
</div> 


<script>
	// pop up nominee biography
	function PopUpNomineesDesc(property){
		var name = $(property).data('name');
		var biography =  $(property).data('bio');
		$('.popUpNomineesDesc').html(biography).css({
			'min-width': '50%',
			'min-height': '300px',
			'max-height': '500px',
			'padding': '10px'
		});
		$('.nomineesDescDisplay').css({
			'display': 'flex',
			'justify-content': 'center',
			'align-items': 'center',
			'overflow-y': 'scroll'
		});
		$('.popUpNomineesTitle').text('Nominee name: '+name);
		$('.popUpNomineesFrame').modal('show');
	} 
</script>


