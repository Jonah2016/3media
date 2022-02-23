<?php

    // include Database connection file
    require_once("../../resources/auth.inc.php");

?>

<div class="row flex">
    <!-- Total payments made -->
    <div class="col-6 col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body px-3 py-4-5">
                <div class="row">
                    <div class="col-md-4">
                        <div class="stats-icon purple">
                            <i class="fas fa-money-bill-alt"></i>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <h6 class="text-muted font-semibold">Total Payments Recorded</h6>
                        <h6 class="font-extrabold mb-0"><?php echo query_database("SELECT COUNT(pay_id) AS total FROM ticket_payments WHERE YEAR(pay_created_at)=YEAR(CURRENT_DATE) AND pay_active_status=1"); ?></h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Total amount made -->
    <div class="col-6 col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body px-3 py-4-5">
                <div class="row">
                    <div class="col-md-4">
                        <div class="stats-icon blue">
                            <i class="fas fa-wallet"></i>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <h6 class="text-muted font-semibold">Total Payments Amount </h6>
                        <h6 class="font-extrabold mb-0">GHS <?php echo number_format(query_database("SELECT SUM(pay_indiv_qty * pay_indiv_amt) AS total FROM ticket_payments WHERE YEAR(pay_created_at)=YEAR(CURRENT_DATE) AND pay_active_status=1"), 2); ?></h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Total receipts bought -->
    <div class="col-6 col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body px-3 py-4-5">
                <div class="row">
                    <div class="col-md-4">
                        <div class="stats-icon red">
                            <i class="fas fa-ticket-alt"></i>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <h6 class="text-muted font-semibold">Total Tickets Bought</h6>
                        <h6 class="font-extrabold mb-0"><?php echo query_database("SELECT SUM(pay_indiv_qty) AS total FROM ticket_payments WHERE YEAR(pay_created_at)=YEAR(CURRENT_DATE) AND pay_active_status=1"); ?></h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Total customers who purchased -->
    <div class="col-6 col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body px-3 py-4-5">
                <div class="row">
                    <div class="col-md-4">
                        <div class="stats-icon green">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <h6 class="text-muted font-semibold">No. or Customers </h6>
                        <h6 class="font-extrabold mb-0"><?php echo query_database("SELECT COUNT(cus_id) AS total FROM user_ticket_payment_details WHERE YEAR(cus_created_at)=YEAR(CURRENT_DATE) AND cus_active_status=1"); ?></h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <?php       
        $stmt = $db_connect->prepare("SELECT eve_hashed, eve_name FROM event_posts WHERE YEAR(eve_created_at)=YEAR(CURRENT_DATE) AND eve_active_status!=3 ORDER BY eve_name ASC, eve_id DESC ");
        $stmt->execute();
        if($stmt->rowCount() > 0)
        {
            $counter = 1;
            while($row=$stmt->fetch(PDO::FETCH_ASSOC))
            {
                $count = $counter++;
                extract($row); 
                $event_code = $row['eve_hashed'];
                $eve_name   = $row['eve_name'];
    ?>
    <div class="col-12 col-lg-4 col-md-4 col-sm-12 mb-4">
        <div class="card h-100">
            <div class="card-header"><h3><?php echo $eve_name; ?></h3></div>
            <div class="card-content h-100" align="center">
                <?php 

                    $tot_ticket_array   = [];
                    $tot_quantity_array     = [];
                    $tot_formatted_array = [];
                    $tot_ticketJson     = "";
                    $tot_quantityJson       = 0;

                    $sql0005 = $db_connect->prepare(" SELECT * FROM ( SELECT pay_ticket_name AS ticket FROM ticket_payments WHERE  pay_event_hash='$event_code' AND YEAR(pay_created_at)=YEAR(CURRENT_DATE) GROUP BY pay_ticket_name) AS TICK JOIN ( SELECT COUNT(*) AS quantity, pay_ticket_name AS tick_name FROM ticket_payments GROUP BY pay_ticket_name) AS QTY ON QTY.tick_name=TICK.ticket ");
                    $sql0005->execute();
                    if($sql0005->rowCount() > 0)
                    {
                        while($row0005=$sql0005->fetch(PDO::FETCH_ASSOC))
                        {
                            $ticket = $row0005['ticket'];
                            $quantity = $row0005['quantity'];
                            $tot_ticket_formatted = $ticket;
                            $tot_quantity_formatted = number_format($quantity);
                            $new_format = $tot_ticket_formatted." = ".$tot_quantity_formatted;

                            array_push($tot_ticket_array, $ticket);
                            array_push($tot_quantity_array, $quantity);
                            array_push($tot_formatted_array, $new_format);
                        }
                    }
                    else{
                        $ticket = "";
                        $quantity = 0;
                        $tot_ticket_formatted = "";
                        $tot_quantity_formatted = "";
                        $new_format = "";
                    }
                    
                    $tot_ticketJson = json_encode($tot_ticket_array);
                    $tot_quantityJson   = json_encode($tot_quantity_array);

                ?>
                <div class="row">
                    <?php if($ticket!=""): ?>
                    <div class="col-md-12">
                        <canvas id="totalTicketsChart<?php echo $count; ?>" width="400" height="250"></canvas>
                    </div>
                    <?php else: ?>
                    <div class="col-md-12 p-3 px-4">
                        <div class="alert alert-dismissible alert-warning" role="alert">
                            <strong> <span>No data found. Chart cannot be displayed</span></strong>
                        </div>
                    </div>
                    <?php endif ?>
                </div>
            </div>
        </div>
        <script>
            var new_tot_ticket = <?php echo $tot_ticketJson; ?>;
            var new_tot_vote = <?php echo $tot_quantityJson; ?>;
            var count = 'totalTicketsChart<?php echo $count; ?>';
            if (new_tot_vote != "") {
                // statement
                var ctx = document.getElementById(count);
                var totalTicketsChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: new_tot_ticket,
                        datasets: [{
                            label: 'Total Quantity',
                            data: new_tot_vote,
                            backgroundColor: [
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)',
                                'rgba(253, 199, 132, 0.7)',
                                'rgba(54, 172, 225, 0.7)',
                                'rgba(252, 216, 186, 0.7)',
                                'rgba(75, 202, 102, 0.7)',
                                'rgba(155, 102, 205, 0.7)'
                            ],
                            borderColor: [
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)',
                                'rgba(253, 199, 132, 0.7)',
                                'rgba(54, 172, 225, 0.7)',
                                'rgba(252, 216, 186, 0.7)',
                                'rgba(75, 202, 102, 0.7)',
                                'rgba(155, 102, 205, 0.7)'
                            ],
                            borderWidth: 1,
                            hoverOffset:5,
                            hoverBorderWidth:5,
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                display: true,
                                ticks: {
                                    beginAtZero: true,
                                }
                            }]
                        },
                    }
                });
            }
        </script>
    </div>
    <?php 
            }
        }
    ?>
</div>



