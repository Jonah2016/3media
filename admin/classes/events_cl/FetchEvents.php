<?php require_once("../../resources/auth.inc.php"); ?>

<table class="table table-striped table-hover display nowrap table-bordered" id="simple_table" cellspacing="0" width="100%">
	<thead>
		<tr>
            <th> # </th>
            <th> Ref. </th>
            <th> Status </th>
			<th> Category </th>
            <th> Image </th>
			<th> Details </th>
			<th> Full Details </th>
			<th> Created by </th>
			<th> Created at </th>
			<th> Updated at </th>
			<th> Action </th>
		</tr>
	</thead>
	<tbody>
		<?php		
			$stmt = $db_connect->prepare("SELECT * FROM event_posts WHERE eve_active_status!=3 ORDER BY eve_id DESC ");
			$stmt->execute();
			if($stmt->rowCount() > 0)
			{
				$counter = 1;
				while($row=$stmt->fetch(PDO::FETCH_ASSOC))
				{
					extract($row); 
					$eve_organiser_logo = $row['eve_organiser_logo'];
					$eve_banner = $row['eve_banner'];
					$eve_image1 = $row['eve_image1'];
					$eve_image2 = $row['eve_image2'];
					$eve_ticket_image = $row['eve_ticket_image'];
					$photo_directory1 =  ($eve_organiser_logo != "") ? UPLOADS_PATH.'events/'.$eve_organiser_logo : UPLOADS_PATH.'templates/no_photo.png';
					$photo_directory2 =  ($eve_banner != "") ? UPLOADS_PATH.'events/'.$eve_banner : UPLOADS_PATH.'templates/no_photo.png';
					$photo_directory3 =  ($eve_image1 != "") ? UPLOADS_PATH.'events/'.$eve_image1 : UPLOADS_PATH.'templates/no_photo.png';
					$photo_directory4 =  ($eve_image2 != "") ? UPLOADS_PATH.'events/'.$eve_image2 : UPLOADS_PATH.'templates/no_photo.png';
					$photo_directory5 =  ($eve_ticket_image != "") ? UPLOADS_PATH.'tickets/'.$eve_ticket_image : UPLOADS_PATH.'templates/no_photo.png';

					$eve_enable_ticket_sales = ($row['eve_enable_ticket_sales'] == "" || $row['eve_enable_ticket_sales'] == 0) ? "No" : "Yes";
					$eve_show_attendees = ($row['eve_show_attendees'] == "" || $row['eve_show_attendees'] == 0) ? "No" : "Yes";
					$eve_enable_reviews = ($row['eve_enable_reviews'] == "" || $row['eve_enable_reviews'] == 0) ? "No" : "Yes";
					$eve_status = ($row['eve_active_status'] == "" || $row['eve_active_status'] == 0) ? "No" : "Yes";
		?>
		<tr>
			<td><?php echo $counter++; ?></td>
			<td><?php echo $row['eve_hashed']; ?></td>
		    <td>
		    	<?php 
			    	if ($row['eve_active_status'] == 1) {
			    	 	echo "<span class='badge bg-success p-2'><small>Active</small></span>";
			    	}
			    	else {
			    	 	echo "<span class='badge bg-secondary p-2'><small>Suspended</small></span>";
			    	}
		    	?>
		    </td>
			<td class="text-uppercase"><?php echo $row['eve_category']; ?></td>
			<td class="py-1"><img width="50px" onclick="PopUpImage(this)"  alt="<?php echo $eve_name; ?>" src="<?php echo $photo_directory2; ?>"></td>
			<td><?php echo $row['eve_organiser']."<b> >> </b>".$row['eve_name']."<b> >> </b> From ".$row['eve_start_date']." to ".$row['eve_end_date']."<b> >> </b>Time: ".$row['eve_start_time']." - ".$row['eve_end_time']; ?></td>

			<td>
				<button class="btn btn-info btn-sm" 
					data-hashed = '<?php echo $eve_hashed;?>'
					data-name = '<?php echo $eve_name; ?>'
					data-category = '<?php echo $eve_category; ?>'
					data-description = '<?php echo htmlentities($eve_description); ?>'
					data-location = '<?php echo $eve_location; ?>'
					data-map_location = '<?php echo $eve_map_location; ?>'
					data-venue = '<?php echo $eve_venue; ?>'
					data-rating = '<?php echo $eve_rating; ?>'
					data-organiser = '<?php echo $eve_organiser; ?>'
					data-organiser_logo = '<?php echo $photo_directory1; ?>'
					data-fb_link = '<?php echo $eve_fb_link; ?>'
					data-twitter_link = '<?php echo $eve_twitter_link; ?>'
					data-ig_link = '<?php echo $eve_ig_link; ?>'
					data-tags = '<?php echo $eve_tags; ?>'
					data-banner = '<?php echo $photo_directory2; ?>'
					data-image1 = '<?php echo $photo_directory3; ?>'
					data-image2 = '<?php echo $photo_directory4; ?>'
					data-yt_video_link = '<?php echo $eve_yt_video_link; ?>'
					data-start_date = '<?php echo $eve_start_date; ?>'
					data-end_date = '<?php echo $eve_end_date; ?>'
					data-start_time = '<?php echo $eve_start_time; ?>'
					data-end_time = '<?php echo $eve_end_time; ?>'
					data-enable_ticket_sales = '<?php echo $eve_enable_ticket_sales; ?>'
					data-ticket_hashed = '<?php echo $eve_ticket_hashed; ?>'
					data-ticket_image = '<?php echo $photo_directory5; ?>'

					data-ticket_name1 = '<?php echo $eve_ticket_name1; ?>'
					data-ticket_desc1 = '<?php echo $eve_ticket_desc1; ?>'
					data-ticket_price1 = '<?php echo $eve_ticket_price1; ?>'
					data-ticket_quantity1 = '<?php echo $eve_ticket_quantity1; ?>'

					data-ticket_name2 = '<?php echo $eve_ticket_name2; ?>'
					data-ticket_desc2 = '<?php echo $eve_ticket_desc2; ?>'
					data-ticket_price2 = '<?php echo $eve_ticket_price2; ?>'
					data-ticket_quantity2 = '<?php echo $eve_ticket_quantity2; ?>'

					data-ticket_name3 = '<?php echo $eve_ticket_name3; ?>'
					data-ticket_desc3 = '<?php echo $eve_ticket_desc3; ?>'
					data-ticket_price3 = '<?php echo $eve_ticket_price3; ?>'
					data-ticket_quantity3 = '<?php echo $eve_ticket_quantity3; ?>'

					data-ticket_name4 = '<?php echo $eve_ticket_name4; ?>'
					data-ticket_desc4 = '<?php echo $eve_ticket_desc4; ?>'
					data-ticket_price4 = '<?php echo $eve_ticket_price4; ?>'
					data-ticket_quantity4 = '<?php echo $eve_ticket_quantity4; ?>'

					data-start_sales_on = '<?php echo $eve_start_sales_on; ?>'
					data-ends_sales_on = '<?php echo $eve_ends_sales_on; ?>'
					data-show_attendees = '<?php echo $eve_show_attendees; ?>'
					data-enable_reviews = '<?php echo $eve_enable_reviews; ?>'
					data-audience = '<?php echo $eve_audience; ?>'
					data-active_status = '<?php echo $eve_status; ?>'
					onclick="PopUpEvent(this)">
					View Full Details
				</button>
			</td>
			<td><?php echo $row['eve_created_by']; ?></td>
			<td class="text-center"><?php if($row['eve_created_at'] !== '0000-00-00 00:00:00'){ echo $row['eve_created_at']; }else{ echo '---'; } ?></td>
			<td class="text-center"><?php if($row['eve_updated_at'] !== '0000-00-00 00:00:00'){ echo $row['eve_updated_at']; }else{ echo '---'; } ?></td>
			<!-- actions -->
			<td>
				<div class="dropdown">
					<button class="btn btn-primary btn-sm dropdown-toggle dropdown-toggle-split px-1 py-1" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" > <i class="fa fa-ellipsis-v"> </i> <i class="caret"></i></button>
					<ul class="dropdown-menu dropdown-menu-right p-2" style="min-width: 6rem" >
						<!-- Update event -->
						<?php if ($neo_eve_edit == 1): ?>
						<li class="pb-1">
							<button data-id="<?php echo $row['eve_hashed'];?>" class="btn btn-sm btn-info btn-block text-capitalize px-1 py-1 edit_event"><i class="fa fa-edit"> </i> Edit</button>
						</li>
		    	      	<!-- Enable and disable event account -->
		    	      	<li class="pb-2">
							<?php if ($eve_active_status == 1): ?>
								<button data-id="<?php echo $row['eve_hashed'];?>" data-status="<?php echo $eve_active_status;?>" class="btn btn-sm btn-secondary btn-block text-capitalize px-1 py-1 activate_event"><i class="bi bi-square-fill bi-center"> </i> Disable </button>
							<?php elseif ($eve_active_status == 0): ?>
								<button data-id="<?php echo $row['eve_hashed'];?>" data-status="<?php echo $eve_active_status;?>" class="btn btn-sm btn-success btn-block text-capitalize px-1 py-1 activate_event"><i class="bi bi-check2-square bi-center"> </i> Enable </button>
		    	      		<?php endif ?>
		    	      	</li>
		    	      	<?php endif ?>
						<!-- Delete event -->
						<?php if ($neo_eve_delete == 1): ?>
						<li class="pb-1">
							<button data-id="<?php echo $row['eve_hashed'];?>" class="btn btn-sm btn-danger btn-block text-capitalize px-1 py-1 delete_event"><i class="fa fa-trash"> </i> Delete </button>
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

		document.title='List of All Events';
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



<!-- eveent pop up modal -->
<div class="modal modal-blur  fade popUpEventFrame" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-dialog-centered modal-xl" role="document" style="width: 100%;">
		<div class="modal-content">
			<div class="modal-body fullPageDisplay">
				<div class="eve_hashed d-flex">Event Reference Code: <p class="xeve_hashed pl-2 pr-2"> </p></div>
				<div class="row mb-3">
					<div class="col-6 col-lg-4 col-md-4 col-sm-6"><img src="" class="xeve_banner" width="100%" height="100%" alt="event banner"></div>
					<div class="col-6 col-lg-4 col-md-4 col-sm-6"><img src="" class="xeve_image1" width="100%" height="100%" alt="event image one"></div>
					<div class="col-6 col-lg-4 col-md-4 col-sm-6"><img src="" class="xeve_image2" width="100%" height="100%" alt="event image 2"></div>
					<div class="col-6 col-lg-4 col-md-4 col-sm-6"><img src="" class="xeve_organiser_logo" width="100%" height="100%" alt="organisation logo"></div>
				</div>
				<ul class="list-group">
					<li class="row d-flex list-group-item">
						<div class="col-12 col-lg-4 col-md-4 col-sm-12 list-item"><strong> Event Organiser: </strong><span class="xeve_organiser"></span></div>
						<div class="col-12 col-lg-4 col-md-4 col-sm-12 list-item"><strong> Event Name: </strong><span class="xeve_name"></span></div>
						<div class="col-12 col-lg-4 col-md-4 col-sm-12 list-item"><strong> Event Category: </strong><span class="xeve_category"></span></div>
					</li>
					<li class="row d-flex list-group-item">
						<div class="col-12 col-lg-12 col-md-12 col-sm-12 list-item"><strong> Event Description: </strong><span class="eve_description"></span></div>
					</li>
					<li class="row d-flex list-group-item">
						<div class="col-12 col-lg-4 col-md-4 col-sm-12 list-item"><strong> Location: </strong><span class="xeve_location"></span></div>
						<div class="col-12 col-lg-4 col-md-4 col-sm-12 list-item"><strong> Map Location: </strong><span class="xeve_map_location"></span></div>
						<div class="col-12 col-lg-4 col-md-4 col-sm-12 list-item"><strong> Venue: </strong><span class="xeve_venue"></span></div>
					</li>
					<li class="row d-flex list-group-item">
						<div class="col-12 col-lg-6 col-md-6 col-sm-12 list-item"><strong> FB Link: </strong><span class="xeve_fb_link"></span></div>
						<div class="col-12 col-lg-6 col-md-6 col-sm-12 list-item"><strong> Twitter Link: </strong><span class="xeve_twitter_link"></span></div>
						<div class="col-12 col-lg-6 col-md-6 col-sm-12 list-item"><strong> IG Link: </strong><span class="xeve_ig_link"></span></div>
						<div class="col-12 col-lg-6 col-md-6 col-sm-12 list-item"><strong> Youtube Video Link: </strong><span class="xeve_yt_video_link"></span></div>
					</li>
					<li class="row d-flex list-group-item">
						<div class="col-12 col-lg-3 col-md-3 col-sm-12 list-item"><strong> Event Start date: </strong><span class="xeve_start_date"></span></div>
						<div class="col-12 col-lg-3 col-md-3 col-sm-12 list-item"><strong> Event End date: </strong><span class="xeve_end_date"></span></div>
						<div class="col-12 col-lg-3 col-md-3 col-sm-12 list-item"><strong> Event Start Time: </strong><span class="xeve_start_time"></span></div>
						<div class="col-12 col-lg-3 col-md-3 col-sm-12 list-item"><strong> Event Closing Time: </strong><span class="xeve_end_time"></span></div>
					</li>
					<li class="row d-flex list-group-item pt-5 pb-2"><h4>Ticket Details</h4></li>
					<li class="row d-flex list-group-item">
						<div class="col-12 col-lg-6 col-md-6 col-sm-12 list-item"><strong> Ticket Sales Enabled: </strong><span class="xeve_enable_ticket_sales"></span></div>
						<div class="col-12 col-lg-6 col-md-6 col-sm-12 list-item"><strong> Ticket ID: </strong><span class="xeve_ticket_hashed"></span></div>
					</li>
					<li class="row d-flex list-group-item">
						<div class="col-12 col-lg-12 col-md-12 col-sm-12 p-2"><img src="" class="xeve_ticket_image" width="100%" height="100%" alt="organisation logo"></div>
					</li>
					<?php for ($i=1; $i < 5; $i++) { ?>
					<div class="row d-flex list-group-item">
						<div class="col-12 col-lg-12 col-md-12 col-sm-12 list-item"><strong> Ticket Description<?php echo $i; ?>: </strong><span class="xeve_ticket_desc<?php echo $i; ?>"></span></div>
					</div>
					<li class="row d-flex list-group-item">
						<div class="col-12 col-lg-3 col-md-3 col-sm-12 list-item"><strong> Ticket Price<?php echo $i; ?>: </strong><span class="xeve_ticket_price<?php echo $i; ?>"></span></div>
						<div class="col-12 col-lg-3 col-md-3 col-sm-12 list-item"><strong> Ticket Quantity<?php echo $i; ?>: </strong><span class="xeve_ticket_quantity<?php echo $i; ?>"></span></div>
					</li>
					<?php } ?>
					<li class="row d-flex list-group-item">
						<div class="col-12 col-lg-3 col-md-3 col-sm-12 list-item"><strong> Ticket Sales Starts On: </strong><span class="xeve_start_sales_on"></span></div>
						<div class="col-12 col-lg-3 col-md-3 col-sm-12 list-item"><strong> Ticket Sales Ends On: </strong><span class="xeve_ends_sales_on"></span></div>
					</li>
					<li class="row d-flex list-group-item">
						<div class="col-12 col-lg-6 col-md-6 col-sm-12 list-item"><strong> Show Attendees: </strong><span class="xeve_show_attendees"></span></div>
						<div class="col-12 col-lg-6 col-md-6 col-sm-12 list-item"><strong> Enable Reviews: </strong><span class="xeve_enable_reviews"></span></div>
						<div class="col-12 col-lg-6 col-md-6 col-sm-12 list-item"><strong> Audience/Target Group: </strong><span class="xeve_audience"></span></div>
						<div class="col-12 col-lg-6 col-md-6 col-sm-12 list-item"><strong> Active Status: </strong><span class="xeve_active_status"></span></div>
					</li>
					<li class="row d-flex list-group-item ">
						<div class="col-12 col-lg-6 col-md-6 col-sm-12 list-item"><strong> Event Rating: </strong><span class="xeve_rating"></span></div>
						<div class="col-12 col-lg-6 col-md-6 col-sm-12 list-item"><strong> Event Tags: </strong><span class="xeve_tags"></span></div>
						<div class="col-12 col-lg-6 col-md-6 col-sm-12 list-item"><strong> Active status: </strong><span class="xeve_active_status"></span></div>
					</li>
				</ul>

				<div class="eventtDisplay mt-3"><p class="popUpEvent"></p></div>
			</div>
			<div class="modal-footer" align="center">
				<h5 class="text-center popUpEventName"></h5>
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
				<div class="photoDisplay"><img class="popUpPhoto" src="" alt="News photo" /></div>
			</div>
			<div class="modal-footer" align="center">
				<h5 class="text-center popUpPhotoTitle"></h5> <!--caption appears under the popup image-->
			</div>
		</div>
	</div>
</div>

<script>
	// pop up news image
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

    // pop up product description
    function PopUpEvent(property){
    	var name = $(property).data('name');
    	var hashed = $(property).data('hashed');
    	var name = $(property).data('name');
    	var category = $(property).data('category');
    	var description = $(property).data('description');
    	var location = $(property).data('location');
    	var map_location = $(property).data('map_location');
    	var venue = $(property).data('venue');
    	var rating = $(property).data('rating');
    	var organiser = $(property).data('organiser');
    	var organiser_logo = $(property).data('organiser_logo');
    	var fb_link = $(property).data('fb_link');
    	var twitter_link = $(property).data('twitter_link');
    	var ig_link = $(property).data('ig_link');
    	var tags = $(property).data('tags');
    	var banner = $(property).data('banner');
    	var image1 = $(property).data('image1');
    	var image2 = $(property).data('image2');
    	var yt_video_link = $(property).data('yt_video_link');
    	var start_date = $(property).data('start_date');
    	var end_date = $(property).data('end_date');
    	var start_time = $(property).data('start_time');
    	var end_time = $(property).data('end_time');
    	var enable_ticket_sales = $(property).data('enable_ticket_sales');
    	var ticket_hashed = $(property).data('ticket_hashed');
    	var ticket_image = $(property).data('ticket_image');

    	var ticket_name1 = $(property).data('ticket_name1');
    	var ticket_desc1 = $(property).data('ticket_desc1');
    	var ticket_price1 = $(property).data('ticket_price1');
    	var ticket_quantity1 = $(property).data('ticket_quantity1');
    	var ticket_name2 = $(property).data('ticket_name2');
    	var ticket_desc2 = $(property).data('ticket_desc2');
    	var ticket_price2 = $(property).data('ticket_price2');
    	var ticket_quantity2 = $(property).data('ticket_quantity2');
    	var ticket_name3 = $(property).data('ticket_name3');
    	var ticket_desc3 = $(property).data('ticket_desc3');
    	var ticket_price3 = $(property).data('ticket_price3');
    	var ticket_quantity3 = $(property).data('ticket_quantity3');
    	var ticket_name4 = $(property).data('ticket_name4');
    	var ticket_desc4 = $(property).data('ticket_desc4');
    	var ticket_price4 = $(property).data('ticket_price4');
    	var ticket_quantity4 = $(property).data('ticket_quantity4');

    	var start_sales_on = $(property).data('start_sales_on');
    	var ends_sales_on = $(property).data('ends_sales_on');
    	var show_attendees = $(property).data('show_attendees');
    	var enable_reviews = $(property).data('enable_reviews');
    	var audience = $(property).data('audience');
    	var active_status = $(property).data('active_status');

    	$('.popUpEvent').html(description).css({
    		'min-width': '60%',
    		'min-height': '300px',
    		'max-height': '350px',
    		'padding': '10px'
    	});
    	$('.eventtDisplay').css({
    		'display': 'flex',
    		'justify-content': 'center',
    		'align-items': 'center',
    		'overflow-y': 'scroll'
    	});
    	$('.fullPageDisplay').css({
    		'min-width': '100%',
    		'min-height': '60%',
    		'max-height': '60%',
    		'padding': '10px'
    	});

    	$('.popUpEventName').text('Product name:  '+name);
    	$('.xeve_hashed').text(hashed);
    	$('.xeve_name').text(name);
    	$('.xeve_category').text(category);
    	$('.xeve_description').text(description);
    	$('.xeve_location').text(location);
    	$('.xeve_map_location').text(map_location);
    	$('.xeve_venue').text(venue);
    	$('.xeve_rating').text(rating);
    	$('.xeve_organiser').text(organiser);
    	$('.xeve_organiser_logo').attr('src', organiser_logo);
    	$('.xeve_fb_link').text(fb_link);
    	$('.xeve_twitter_link').text(twitter_link);
    	$('.xeve_ig_link').text(ig_link);
    	$('.xeve_tags').text(tags);
    	$('.xeve_banner').attr('src', banner);
    	$('.xeve_image1').attr('src', image1);
    	$('.xeve_image2').attr('src', image2);
    	$('.xeve_yt_video_link').text(yt_video_link);
    	$('.xeve_start_date').text(start_date);
    	$('.xeve_end_date').text(end_date);
    	$('.xeve_start_time').text(start_time);
    	$('.xeve_end_time').text(end_time);
    	$('.xeve_enable_ticket_sales').text(enable_ticket_sales);
    	$('.xeve_ticket_hashed').text(ticket_hashed);
    	$('.xeve_ticket_image').attr('src', ticket_image);

    	$('.xeve_ticket_name1').text(ticket_name1);
    	$('.xeve_ticket_desc1').text(ticket_desc1);
    	$('.xeve_ticket_price1').text(ticket_price1);
    	$('.xeve_ticket_quantity1').text(ticket_quantity1);
    	$('.xeve_ticket_name2').text(ticket_name2);
    	$('.xeve_ticket_desc2').text(ticket_desc2);
    	$('.xeve_ticket_price2').text(ticket_price2);
    	$('.xeve_ticket_quantity2').text(ticket_quantity2);
    	$('.xeve_ticket_name3').text(ticket_name3);
    	$('.xeve_ticket_desc3').text(ticket_desc3);
    	$('.xeve_ticket_price3').text(ticket_price3);
    	$('.xeve_ticket_quantity3').text(ticket_quantity3);
    	$('.xeve_ticket_name4').text(ticket_name4);
    	$('.xeve_ticket_desc4').text(ticket_desc4);
    	$('.xeve_ticket_price4').text(ticket_price4);
    	$('.xeve_ticket_quantity4').text(ticket_quantity4);

    	$('.xeve_start_sales_on').text(start_sales_on);
    	$('.xeve_ends_sales_on').text(ends_sales_on);
    	$('.xeve_show_attendees').text(show_attendees);
    	$('.xeve_enable_reviews').text(enable_reviews);
    	$('.xeve_audience').text(audience);
    	$('.xeve_active_status').text(active_status);

    	$('.popUpEventFrame').modal('show');
    }
</script>


