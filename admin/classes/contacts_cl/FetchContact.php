<?php require_once("../../resources/auth.inc.php"); ?>

<table class="table display nowrap dataTable-table table-bordered simple_table" cellspacing="0" width="100%">
	<thead>
        <tr class="headingTr">
        	<th><i class="fas fa-check-square fa-2x"></i></th>
        	<th>#</th>
        	<th> MSG ID</th>
        	<th> Full Name</th>
			<th> Email Address </th>
			<th> Subject </th>
        	<th> Message </th>
        	<th> Status </th>
        	<th> Created At </th>
        	<th> Action </th>
        </tr>
	</thead>
	<tbody>
		<?php
		     
		    $stmt = $db_connect->prepare("SELECT * FROM contacts WHERE con_active_status!=3 ORDER BY con_created_at DESC ");
		    $stmt->execute();
		    if($stmt->rowCount() > 0)
		    {
		    	$counter = 1;
		        while($row=$stmt->fetch(PDO::FETCH_ASSOC))
		        {
		           extract($row); 
		           $con_active_status = $row['con_active_status'];
		?>
		<tr class="text-uppercase" id="<?php echo $row["con_id"]; ?>">
			<td></td>
			<td><?php echo $counter++; ?></td>
		    <td><?php echo $row['con_id']; ?></td>
			<td><?php echo $row['con_sender']; ?></td>
		    <td><?php echo $row['con_sender_email']; ?></td>
			<td><?php echo $row['con_message_title']; ?></td>
		    <td><button class="btn btn-info btn-sm" data-name="<?php echo $row['con_sender']; ?>" data-bio="<?php echo $row['con_message_body']; ?>" onclick="PopUpMessage(this)">View Message</button></td>
		    <td>
		    	<?php 
			    	if ($row['con_active_status'] == 1) {
			    	 	echo "<span class='badge bg-success p-2'><small>Active</small></span>";
			    	}
			    	else {
			    	 	echo "<span class='badge bg-secondary p-2'><small>Suspended</small></span>";
			    	}
		    	?>
		    </td>
		    <td><?php echo $row['con_created_at']; ?></td>
		    <td>
		    	<div class="dropdown">
		    	    <button class="btn btn-sm btn-primary dropdown-toggle dropdown-toggle-split" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >Actions
		    	    <i class="caret"></i></button>
		    	    <ul class="dropdown-menu dropdown-menu-right p-2" >
		    	      	<!-- Enable and disable contact account -->
		    	      	<?php if ($neo_con_edit == 1): ?>
		    	      	<li class="pb-2">
							<?php if ($con_active_status == 1): ?>
								<button data-id="<?php echo $row['con_id'];?>" data-status="<?php echo $con_active_status;?>" class="btn btn-sm btn-secondary btn-block text-capitalize px-1 py-1 activate_contact"><i class="bi bi-square-fill bi-center"> </i> Disable </button>
							<?php elseif ($con_active_status == 0): ?>
								<button data-id="<?php echo $row['con_id'];?>" data-status="<?php echo $con_active_status;?>" class="btn btn-sm btn-success btn-block text-capitalize px-1 py-1 activate_contact"><i class="bi bi-check2-square bi-center"> </i> Enable </button>
		    	      		<?php endif ?>
		    	      	</li>
		    	      	<?php endif ?>
		    	      	<!-- // Enable and disable account -->
						<!-- Delete contact -->
						<?php if ($neo_con_delete == 1): ?>
						<li class="pb-1">
							<button data-id="<?php echo $row['con_id'];?>" class="btn btn-sm btn-danger btn-block text-capitalize px-1 py-1 delete_contact"><i class="bi bi-trash"> </i> Delete </button>
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


<!-- Message pop up modal -->
<div class="modal fade popUpMessageFrame" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-xl" role="document" style="width: 100%;">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" class="weight-700 text-danger">&times;</span></button>
			</div>
			<div class="modal-body">
				<div class="messageDisplay"><pre><p class="popUpMessage"></p></pre></div>
			</div>
			<div class="modal-footer" align="center">
				<h5 class="text-center popUpMessageTitle"></h5> <!--caption appears under the popup image-->
			</div>
		</div>
	</div>
</div>

<!-- Settings For tables with class=simple_table -->
<script>
	$(document).ready(function() {

		document.title='List of all contacts';
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

	// pop up Contact Message
	function PopUpMessage(property){
		var name = $(property).data('name');
		var message =  $(property).data('bio');
		$('.popUpMessage').html(message).css({
			'min-width': '50%',
			'min-height': '300px',
			'max-height': '500px',
			'padding': '10px'
		});
		$('.messageDisplay').css({
			'display': 'flex',
			'justify-content': 'center',
			'align-items': 'center',
			'overflow-y': 'scroll'
		});
		$('.popUpMessageTitle').text('Contacted by '+name);
		$('.popUpMessageFrame').modal('show');
	}
</script>
<!-- // End Settings For tables with ID=very_simple_table -->