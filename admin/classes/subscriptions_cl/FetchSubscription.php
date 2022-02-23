<?php require_once("../../resources/auth.inc.php"); ?>

<table class="table display nowrap dataTable-table table-bordered simple_table" cellspacing="0" width="100%">
	<thead>
        <tr class="headingTr">
        	<th><i class="fas fa-check-square fa-2x"></i></th>
        	<th>#</th>
        	<th> SUB ID</th>
			<th> Email Address </th>
			<th> IP Address </th>
        	<th> Email Count </th>
        	<th> Status </th>
        	<th> Created At </th>
        	<th> Action </th>
        </tr>
	</thead>
	<tbody>
		<?php
		     
		    $stmt = $db_connect->prepare("SELECT * FROM subscriptions WHERE subs_active_status!=3 ORDER BY subs_created_at DESC ");
		    $stmt->execute();
		    if($stmt->rowCount() > 0)
		    {
		    	$counter = 1;
		        while($row=$stmt->fetch(PDO::FETCH_ASSOC))
		        {
		           extract($row); 
		           $subs_active_status = $row['subs_active_status'];
		?>
		<tr class="text-uppercase" id="<?php echo $row["subs_id"]; ?>">
			<td></td>
			<td><?php echo $counter++; ?></td>
		    <td><?php echo $row['subs_id']; ?></td>
		    <td class="text-lowercase"><?php echo strtolower($row['subs_email']); ?></td>
			<td><?php echo $row['subs_ip']; ?></td>
			<td><?php echo $row['subs_email_count']; ?></td>
		    <td>
		    	<?php 
			    	if ($row['subs_active_status'] == 1) { echo "<span class='badge bg-success p-2'><small>Active</small></span>"; }
			    	else { echo "<span class='badge bg-secondary p-2'><small>Suspended</small></span>"; }
		    	?>
		    </td>
		    <td><?php echo $row['subs_created_at']; ?></td>
		    <td>
		    	<div class="dropdown">
		    	    <button class="btn btn-sm btn-primary dropdown-toggle dropdown-toggle-split" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >Actions
		    	    <i class="caret"></i></button>
		    	    <ul class="dropdown-menu dropdown-menu-right p-2" >
		    	      	<!-- Enable and disable subscription account -->
		    	      	<?php if ($neo_con_edit == 1): ?>
		    	      	<li class="pb-2">
							<?php if ($subs_active_status == 1): ?>
								<button data-id="<?php echo $row['subs_id'];?>" data-status="<?php echo $subs_active_status;?>" class="btn btn-sm btn-secondary btn-block text-capitalize px-1 py-1 activate_subscription"><i class="bi bi-square-fill bi-center"> </i> Suspend </button>
							<?php elseif ($subs_active_status == 0): ?>
								<button data-id="<?php echo $row['subs_id'];?>" data-status="<?php echo $subs_active_status;?>" class="btn btn-sm btn-success btn-block text-capitalize px-1 py-1 activate_subscription"><i class="bi bi-check2-square bi-center"> </i> Activate </button>
		    	      		<?php endif ?>
		    	      	</li>
		    	      	<?php endif ?>
		    	      	<!-- // Enable and disable account -->
						<!-- Delete subscription -->
						<?php if ($neo_con_delete == 1): ?>
						<li class="pb-1">
							<button data-id="<?php echo $row['subs_id'];?>" class="btn btn-sm btn-danger btn-block text-capitalize px-1 py-1 delete_subscription"><i class="bi bi-trash"> </i> Delete </button>
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


<!-- Settings For tables with class=simple_table -->
<script>
	$(document).ready(function() {

		document.title='List of all subscriptions';
		$.fn.dataTable.ext.errMode = 'throw';
		$('.simple_table').DataTable({
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
		      paging: true
		} );

	});
</script>
<!-- // End Settings For tables with ID=very_simple_table -->