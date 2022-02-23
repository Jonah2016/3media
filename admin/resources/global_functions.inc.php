<?php 


	//record each activity's history
	function log_history($uscode, $action, $status){
		 
		$act_sess_user_code = $uscode;
		$act_sess_action = $action;
		$act_sess_status = $status;
		$act_sess_time = date("Y-m-d");
		$act_sess_created_at = date("Y-m-d H:i:s");

		// Connect to database
		include("connect.inc.php");

		$his_sql =  $db_connect->prepare(" INSERT INTO history_logs (act_sess_user_code, act_sess_action, act_sess_time, act_sess_status, act_sess_created_at) VALUES (:xact_sess_user_code, :xact_sess_action, :xact_sess_time, :xact_sess_status, :xact_sess_created_at) ");
		$his_result = $his_sql->execute(
		    array( 
		    	':xact_sess_user_code' => $act_sess_user_code,
		    	':xact_sess_action' => $act_sess_action,
		    	':xact_sess_time' => $act_sess_time,
		    	':xact_sess_status' => $act_sess_status,
		    	':xact_sess_created_at' => $act_sess_created_at
		    )
		);

		return false;
	}

	// Generate random strings
	function generateRandomString($length) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }


    // Get totals of queries
	function query_database($statement){
		include("connect.inc.php");
		$sql0001 = $db_connect->prepare($statement);
        $sql0001->execute();
        if($sql0001->rowCount() > 0)
        {
            while($row0001=$sql0001->fetch(PDO::FETCH_ASSOC))
    		{
    			
    			if ($row0001['total'] > 0 || $row0001['total'] != NULL || !empty($row0001['total'])) {
    				$total = $row0001['total'];
    			} else {
    				$total = 0;
    			}
    		}
    	} else {
    		$total = 0;
    	}

    	return $total;
	}



?>