<?php
	// Require config file
	require_once('backend/core/Config.php');
	// Required classes and controllers
	require_once (CORE_PATH . '/Required.php' );

	// Get settings data from utils
	foreach ($SETTINGS_DATA as $key => $val) {
	    $sett_data = $val;
	}
	
    $page_title = '3Music: Ticket Details';
    $home_active = 'active';
    
	// Include header
	require_once(LAYOUTS_PATH . "/header.php");


	// Retrieve events details
	$a_key    = strip_tags($_GET['tid']);
	$b_key    = stripslashes($a_key);
	$c_key    = htmlspecialchars($b_key, ENT_QUOTES);
	$hash_key = strip_tags($c_key);
	if (empty($hash_key)) {
	    echo "Ticket data cannot be accessed due to an invalid QR code.";
	    exit;
	} else {
	    // Retrieve all ticket data by hashed key from ticket class
	    $event_class = new EventController(['pay_hash_key' => $hash_key]);
	    $tickets = $event_class->getTicketPayment();
	    if(count($tickets) > 0) {
	        foreach ($tickets as $key => $ticket) {
				$pay_customer_id     = $ticket['pay_customer_id'];
				$pay_trans_reference = $ticket['pay_trans_reference'];
				$pay_hash_key        = $ticket['pay_hash_key'];
				$pay_ticket_name     = $ticket['pay_ticket_name'];
				$pay_event_hash      = $ticket['pay_event_hash'];
	        }
	    }

	    // Retrieve all event data by hashed key from event class
	    $event_class = new EventController(['eve_hashed' => $pay_event_hash]);
	    $events = $event_class->getEvent();
	    if(count($events) > 0) {
	        foreach ($events as $key => $event) {
	            $eve_name = htmlspecialchars_decode($event['eve_name']);
	        }
	    }

	    // Retrieve customer name
	    $full_name = "";
	    $s_stmt = $db_connect->prepare('SELECT cus_fname, cus_lname FROM user_ticket_payment_details WHERE cus_hash_key =:xcus_hash_key');
        $s_stmt->bindParam(':xcus_hash_key',$pay_customer_id);
        $s_stmt->execute();
        if($s_stmt->rowCount() > 0){
        	while($row=$s_stmt->fetch(PDO::FETCH_ASSOC))
        	{
        		$full_name = $row['cus_fname']." ".$row['cus_lname'];
        	}
        }
	}
?>
<style>
	.information_display_title{
		font-size: 2rem;
		font-weight: 900;
	}
	.logo_pattern h3{
		font-weight: 900;
		font-size: 1.4rem;
		opacity: 1;
	}
	.logo_pattern{
		background-color: white;
		opacity: 0.9;
		background-image: repeating-linear-gradient(45deg, #fe4d55 25%, transparent 25%, transparent 75%, #fe4d55 75%, #fe4d55),
		repeating-linear-gradient(45deg, #fe4d55 25%, white 25%, white 75%, white 75%, #fe4d55);
		background-position: 0 0, 15px 15px;
		background-size: 30px 30px;
	}
	.logo_pattern img{
		height:100%;
		width:100%;
	}

	.information_display_text_div{
		z-index: 1;
		position: absolute;
		top: 37%;
		left: 35%;
	}
	.information_display_text_div_opacity{
		background-color:white;
		opacity:0.7;
		height:13rem;
		width:30rem;
		position:relative;
	}

	@media (max-width: 991px) {
		.information_display_text_div{
			z-index: 1;
			position: absolute;
			top: 18%;
			left: 15%;
		}
		.information_display_text_div_opacity{
			margin-top: 5rem;
			background-color: white;
			opacity: 0.8;
			height: 15rem;
			width: 100%;
			position: relative;
		}
		.logo_pattern img{
			height:18rem;
			width:18rem;
		}
		.logo_pattern{
			height: 100vh;
		}
	}


</style>

<!-- body -->
<div class="page_content">
	<div class="bg_light d-flex justify-content-center align-items-center vh-100">
		<div class="container-lg">
			<div class="row">
				<div class="col-lg-10 col-md-10 col-sm-12 offset-lg-1">
					<div class="jumbotron clean_shadow mt-0">
						<div class="row logo_pattern text-uppercase">
							<div class="col-lg-8 col-md-8 col-sm-12">
								<div class="m-0 m-lg-5 m-md-5 m-sm-0">
									<div class="information_display_text_div_opacity"></div>
									<div class="information_display_text_div">
										<h3 class="text-center pt-3"><span class="fw-bolder fs-4"><?php echo $eve_name; ?></span> </h3>
										<h4 class="text-center pt-4">Ref no: <span class="fw-bolder"><?php echo $pay_hash_key; ?></span> </h4>
										<h4 class="text-center pt-2">Ticket type: <span class="fw-bolder"><?php echo $pay_ticket_name; ?></span> </h4>
										<h4 class="text-center pt-2">Name: <span class="fw-bolder"><?php echo $full_name; ?></span> </h4>
									</div>
								</div>
							</div>
							<div class="col-lg-4 col-md-4 col-sm-12 d-flex justify-content-center align-items-center">
								<img src="<?php echo ASSETS_PATH.'/img/logo.png'; ?>" alt="logo">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>



<!-- footer -->
<?php
	require_once(LAYOUTS_PATH . "/footer.php");
?>