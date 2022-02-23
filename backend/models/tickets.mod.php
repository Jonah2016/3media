<?php

require('../core/Auth.php');


// Add items to cart
if (isset($_POST['action']) && htmlspecialchars($_POST['action'], ENT_QUOTES) == "add_ticket_to_cart") {
	try {
		$btnId        = htmlspecialchars(strip_tags($_POST['btnId']), ENT_QUOTES);
		$eventCode    = htmlspecialchars(strip_tags($_POST['eventCode']), ENT_QUOTES);
		$ticketName   = htmlspecialchars($_POST['ticketName'], ENT_QUOTES);
		$ticketQty    = htmlspecialchars(strip_tags($_POST['ticketQty']), ENT_QUOTES);
		$neo_tickname = $global_class->removeSpecialChar($ticketName);
		$cartItemID   = $neo_tickname."_".$eventCode;

	    // Retrieve all news data by hashced key from News class
	    $eve_ticket_name1 = null;
	    $eve_ticket_name2 = null;
	    $eve_ticket_name3 = null;
	    $eve_ticket_name4 = null;
	    $event_class = new EventController(['eve_hashed' => $eventCode]);
	    $tickets = $event_class->getEvent();
	    if(count($tickets) > 0) {
	        foreach ($tickets as $key => $ticket) {
	            $eve_ticket_hashed       = $ticket['eve_ticket_hashed'];
				$eve_name             = htmlspecialchars_decode($ticket['eve_name']);
				$eve_ticket_name1     = htmlspecialchars($ticket['eve_ticket_name1'], ENT_QUOTES);
				$eve_ticket_price1    = $ticket['eve_ticket_price1'];
				$eve_ticket_quantity1 = $ticket['eve_ticket_quantity1'];
				$eve_ticket_name2     = htmlspecialchars($ticket['eve_ticket_name2'], ENT_QUOTES);
				$eve_ticket_price2    = $ticket['eve_ticket_price2'];
				$eve_ticket_quantity2 = $ticket['eve_ticket_quantity2'];
				$eve_ticket_name3     = htmlspecialchars($ticket['eve_ticket_name3'], ENT_QUOTES);
				$eve_ticket_price3    = $ticket['eve_ticket_price3'];
				$eve_ticket_quantity3 = $ticket['eve_ticket_quantity3'];
				$eve_ticket_name4     = htmlspecialchars($ticket['eve_ticket_name4'], ENT_QUOTES);
				$eve_ticket_price4    = $ticket['eve_ticket_price4'];
				$eve_ticket_quantity4 = $ticket['eve_ticket_quantity4'];
				$eve_banner           = $ticket['eve_banner'];
				$new_eve_banner       = (!empty($eve_banner)) ? UPLOAD_PATH."events/".$eve_banner : UPLOAD_PATH."templates/no_photo.png";

			    if ($ticketName == $eve_ticket_name1) {
			    	$ticket_price = $eve_ticket_price1;
			    }
			    elseif ($ticketName == $eve_ticket_name2) {
			    	$ticket_price = $eve_ticket_price2;
			    }
			    elseif ($ticketName == $eve_ticket_name3) {
			    	$ticket_price = $eve_ticket_price3;
			    }
			    elseif ($ticketName == $eve_ticket_name4) {
			    	$ticket_price = $eve_ticket_price4;
			    }

			    $itemArray = array($cartItemID=>array('event_name'=>$eve_name,  'event_code'=>$eventCode, 'event_img'=>$new_eve_banner, 'ticket_name'=>$ticketName, 'ticket_qty'=>$ticketQty, 'ticket_price'=>$ticket_price));
			    if(isset($_SESSION["cart_item"]) && !empty($_SESSION["cart_item"])) {
			    	if(in_array($ticketName,$_SESSION["cart_item"])) {
			    		foreach($_SESSION["cart_item"] as $key => $val) {
			    			if($ticketName == $key) {
			    				$_SESSION["cart_item"][$key]["ticket_qty"] = $ticketQty;
			    			}
			    		}
			    	} else {
			    		$_SESSION["cart_item"] = array_merge($_SESSION["cart_item"],$itemArray);
			    	}
			    } else {
			    	$_SESSION["cart_item"] = $itemArray;
			    }
		    }
		}

		$reposne = ['code'=>200, 'msg'=>"Ticket has been added to cart successfully. Click on cart to checkout or continue shopping.", 'btnId'=>$btnId, 'cartTotal'=>count($_SESSION["cart_item"])];

	} catch (Exception $e) {
		$neo_cart_total = count($_SESSION["cart_item"]);
		$reposne = ['code'=>404, 'msg'=>"Ticket could not be added to to your cart. Please refresh the page and try again.", 'btnId'=>$btnId, 'cartTotal'=>count($_SESSION["cart_item"])];
	}

    echo json_encode($reposne);
    exit();
}


// Remove items from cart
if (isset($_POST['action']) && htmlspecialchars($_POST['action'], ENT_QUOTES) == "remove_item") {
	try {
		$cartItemID = htmlspecialchars(strip_tags($_POST["itemID"]), ENT_QUOTES);
		if(isset($_SESSION["cart_item"]) && !empty($_SESSION["cart_item"])) {
			foreach($_SESSION["cart_item"] as $key => $val) {
				if($cartItemID == $key) { unset($_SESSION["cart_item"][$key]); }
				if(empty($_SESSION["cart_item"])){ unset($_SESSION["cart_item"]); }
			}
		}

		$reposne = ['code'=>200, 'msg'=>"Cart item removed successfully."];
	} catch (Exception $e) {
		$reposne = ['code'=>404, 'msg'=>"Item could not be remove from cart. Refresh the page and try again."];
	}

	echo json_encode($reposne);
	exit();
}


// Empty items in cart
if (isset($_POST['action']) && htmlspecialchars($_POST['action'], ENT_QUOTES) == "empty_cart") {
	try {
		if(isset($_SESSION["cart_item"]) && !empty($_SESSION["cart_item"])) {
			unset($_SESSION["cart_item"]);
		}
		$reposne = ['code'=>200, 'msg'=>"Cart emptied successfully."];
	} catch (Exception $e) {
		$reposne = ['code'=>404, 'msg'=>"Cart could not be emptied. Refresh the page and try again."];
	}

	echo json_encode($reposne);
	exit();
}