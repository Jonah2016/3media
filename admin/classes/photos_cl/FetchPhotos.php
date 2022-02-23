<?php require_once("../../resources/config.inc.php"); ?>

<table class="table table-striped table-hover display simple_table" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th> <i class="fa fa-check-square"> </i> </th>
            <th> # </th>
            <th> Image </th>
			<th> Photo title </th>
			<th> Date </th>
			<th> Status </th>
			<th> Created at </th>
			<th> Updated at </th>
			<th> Action </th>
		</tr>
	</thead>
	<tbody>
		<?php		
			$stmt = $db_connect->prepare("SELECT * FROM photos WHERE photo_active_status!=3 ORDER BY photo_id DESC ");
			$stmt->execute();
			if($stmt->rowCount() > 0)
			{
				$counter = 1;
				while($row=$stmt->fetch(PDO::FETCH_ASSOC))
				{
					extract($row); 
					$photo_image = $row['photo_image'];
					$photo_link = $row['photo_link'];
					$photo_directory =  UPLOADS_PATH.'gallery_photos/'.$photo_image;
		?>
		<tr>
			<td></td>
			<td><?php echo $counter++; ?></td>
			<td class="py-1">
				<?php if ($photo_image != "") : ?>
					<img width="50px" onclick="PopUpImage(this)"  alt="<?php echo $row['photo_img_caption']; ?>" src="<?php echo $photo_directory; ?>">
				<?php else:  ?>
					<img width="50px" onclick="PopUpImage(this)" alt="<?php echo $row['photo_title']; ?>" src="<?php echo $photo_link; ?>">
				<?php endif ?>
			</td>
			<td><?php echo $row['photo_title']; ?></td>
			<td><?php echo $row['photo_date']; ?></td>
			<!-- status -->
			<td>
				<?php 
					if ($row['photo_active_status'] == 1) {
						echo "<span class='badge bg-success p-2'><small>Active</small></span>";
					}
					else {
						echo "<span class='badge bg-danger p-2'><small>Disabled</small></span>";
					}
				?>
			</td>
			<td class="text-center"><?php if($row['photo_created_at'] !== '0000-00-00 00:00:00'){ echo $row['photo_created_at']; }else{ echo '---'; } ?></td>
			<td class="text-center"><?php if($row['photo_updated_at'] !== '0000-00-00 00:00:00'){ echo $row['photo_updated_at']; }else{ echo '---'; } ?></td>
			<!-- actions -->
			<td>
				<div class="dropdown">
					<button class="btn btn-primary btn-sm dropdown-toggle dropdown-toggle-split px-1 py-1" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" > <i class="fa fa-ellipsis-v"> </i> <i class="caret"></i></button>
					<ul class="dropdown-menu dropdown-menu-right p-2" style="min-width: 6rem" >
						<!-- Enable and disable user account -->
						<li class="pb-1">
							<?php if ($row['photo_active_status'] == 1): ?>
								<button data-id="<?php echo $row['photo_id'];?>" data-status="<?php echo $row['photo_active_status'];?>" class="btn btn-sm btn-dark btn-block text-capitalize px-1 py-1 activate_photos"><i class="fa fa fa-square-o"> </i> Disable</button>
							<?php else: ?>
								<button data-id="<?php echo $row['photo_id'];?>" data-status="<?php echo $row['photo_active_status'];?>" class="btn btn-sm btn-success btn-block text-capitalize px-1 py-1 activate_photos"><i class="fa fa-check-square-o"> </i> Enable </button>
							<?php endif ?>
						</li>
						<!-- // Enable and disable account -->
						<!-- Delete user -->
						<li class="pb-1">
						<button data-id="<?php echo $row['photo_id'];?>" class="btn btn-sm btn-danger btn-block text-capitalize px-1 py-1 delete_photos"><i class="fa fa-trash"> </i> Delete </button>
						</li>
					</ul>
				</div>
			</td>
		</tr>
		<?php  
				}
			} 
		?>
	</tbody>
</table>

<!-- image pop up modal -->
<div class="modal fade popUpPhotoFrame" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-lg" role="document" style="width: 100%;">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" class="weight-700 text-danger">&times;</span></button>
			</div>
			<div class="modal-body">
				<div class="photoDisplay"><img class="popUpPhoto" src="" alt="gallery photo" /></div>
			</div>
			<div class="modal-footer" align="center">
				<h5 class="text-center popUpPhotoTitle"></h5> <!--caption appears under the popup image-->
			</div>
		</div>
	</div>
</div>


<!-- Settings for tables with class=simple_table -->
<script>
	$(document).ready(function() {

		document.title='List of All Gallery';
		$.fn.dataTable.ext.errMode = 'throw';
		$('.simple_table').DataTable({
			destroy: true,
			paging: true,
			"autoWidth": true,
			"fixedHeader": true,
			"info": true,
			searching: true,
			colReorder: true,
			dom: 'lfrtip', 
			columnDefs: [ {
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
			deferRender:    true,
			scroller:       true,
			fixedColumns:{ leftColumns: 0 },
			paging: true
		} );
 
	});

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
