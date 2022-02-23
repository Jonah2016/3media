<?php

	class Payment extends DB_CONN
	{
		
		protected function process($rid, $pay_fname, $pay_lname, $pay_email, $pay_phone, $pay_location, $cart_data){
			#test num = 0551234987
			try {
				$error = null;
				$msg = null;

				$total_price = 0;
				foreach ($cart_data as $key => $item) {
				    $total_price += $item['ticket_price'];
				}

				$callback_url = PAYSTACK_CALLBACK; 
				// Set post params
				$post_fields =  json_encode([
									'amount'       =>$total_price*100,
									'email'        =>$pay_email,
									'callback_url' => $callback_url
								]);
				//open connection
				$curl_init = curl_init();
				// Ececute curl
				curl_setopt_array($curl_init, array(
					CURLOPT_URL => "https://api.paystack.co/transaction/initialize",
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_CUSTOMREQUEST => "POST",
					CURLOPT_POSTFIELDS => $post_fields,
					CURLOPT_HTTPHEADER => [
						"authorization: Bearer ".$_ENV['PAYSTACK_SKEY'],
						"content-type: application/json",
						"cache-control: no-cache"
					],
				));

				$err      = curl_error($curl_init);
				$response = curl_exec($curl_init);
				$result   = json_decode($response);
				$tranx    = json_decode(json_encode($result), true);

				// Check if status is true or valid
				if ($tranx['status'] === true) {
					$msg = "Your payment has been initialized successfully. Press OK to redirect you to the payment page.";
					$auth_url = $tranx['data']['authorization_url'];
					echo json_encode(['code'=>200, 'msg'=> $msg, 'url'=>$auth_url]);
					exit;
				} else {
					$error = "Your transaction failed. We could not initialize your payment, try again.";
					echo json_encode(['code'=>404, 'msg'=> $error]);
					exit;
				}

			} catch (PDOException $e) {
			    $error = 'Unkown error! Payment initialization failed, please try again in a few minutes.';
			}

			return ['code'=>404, 'msg'=>$error];
			exit();
		}


	}

