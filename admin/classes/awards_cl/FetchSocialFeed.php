<?php require_once("../../resources/auth.inc.php"); ?>

<table class="table table-striped table-hover display nowrap table-bordered" id="simple_table" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th> <i class="fa fa-check-square"> </i> </th>
            <th> # </th>
            <th> Platform </th>
			<th> Url </th>
			<th> Created at </th>
			<th> Updated at </th>
			<th> Action </th>
		</tr>
	</thead>
	<tbody>
		<?php		
			$stmt = $db_connect->prepare("SELECT * FROM award_social_feed ORDER BY awsoc_id DESC ");
			$stmt->execute();
			if($stmt->rowCount() > 0)
			{
				$counter = 1;
				while($row=$stmt->fetch(PDO::FETCH_ASSOC))
				{
					extract($row); 
					$awsoc_url = $row['awsoc_url'];
					$awsoc_type = $row['awsoc_type'];
		?>
		<tr>
			<td></td>
			<td><?php echo $counter++; ?></td>
			<td><?php echo $row['awsoc_type']; ?></td>
			<td><a href="<?php echo $row['awsoc_url']; ?>" target="__blank"><?php echo $row['awsoc_url']; ?></a></td>
			<td class="text-center"><?php if($row['awsoc_created_at'] !== '0000-00-00 00:00:00'){ echo $row['awsoc_created_at']; }else{ echo '---'; } ?></td>
			<td class="text-center"><?php if($row['awsoc_updated_at'] !== '0000-00-00 00:00:00'){ echo $row['awsoc_updated_at']; }else{ echo '---'; } ?></td>
			<!-- actions -->
			<td>
				<div class="dropdown">
					<button class="btn btn-primary btn-sm dropdown-toggle dropdown-toggle-split px-1 py-1" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" > <i class="fa fa-ellipsis-v"> </i> <i class="caret"></i></button>
					<ul class="dropdown-menu dropdown-menu-right p-2" style="min-width: 6rem" >
						<!-- Update video -->
						<?php if ($neo_med_edit == 1): ?>
						<li class="pb-1">
							<button data-id="<?php echo $row['awsoc_id'];?>" class="btn btn-sm btn-info btn-block text-capitalize px-1 py-1 edit_social_feedback"><i class="fa fa-edit"> </i> Edit</button>
						</li>
						<?php endif ?>
						<!-- Delete video -->
						<?php if ($neo_med_delete == 1): ?>
						<li class="pb-1">
							<button data-id="<?php echo $row['awsoc_id'];?>" class="btn btn-sm btn-danger btn-block text-capitalize px-1 py-1 delete_social_feedback"><i class="fa fa-trash"> </i> Delete </button>
						</li>
						<?php endif ?>
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


<!-- Settings for tables with class=simple_table -->
<script>
	$(document).ready(function() {

		document.title='List of All Videos';
		$.fn.dataTable.ext.errMode = 'throw';
		$('#simple_table').DataTable({
			destroy: true,
			paging: true,
			"autoWidth": true,
			"fixedHeader": true,
			"info": false,
			searching: true,
			colReorder: true,
			dom: 'Blfrtip',
			buttons: [
				{ extend: 'pdf' , exportOptions: {columns: ':visible', rows: ':visible'}, footer: true, orientation: 'landscape', className: 'btn btn-sm' },
				{ extend: 'colvis', collectionLayout: 'three-column', prefixButtons: [{extend: 'colvisGroup', text: 'Show all', show: ':hidden'}, {extend: 'colvisRestore',text: 'Restore'}], className: 'btn btn-sm' } 
			],
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
</script>
<!-- // End Settings for tables with class=simple_table -->


