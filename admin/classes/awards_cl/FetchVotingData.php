<?php

    // include Database connection file
    require_once("../../resources/auth.inc.php");

    function getNomineeName($id) {
        include("../../resources/connect.inc.php");
        $stmt1 = $db_connect->prepare("SELECT awn_fullname FROM award_nominees WHERE awn_id='$id' AND awn_active_status!=3 LIMIT 1 ");
        $stmt1->execute();
        if($stmt1->rowCount() > 0)
        {
            while($row1=$stmt1->fetch(PDO::FETCH_ASSOC))
            {
                $awn_fullname = $row1['awn_fullname'];
            }
        }

        return $awn_fullname;
    }

?>

<div class="row flex">
    <!-- No. of voters -->
    <div class="col-6 col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body px-3 py-4-5">
                <div class="row">
                    <div class="col-md-4">
                        <div class="stats-icon purple">
                            <i class="fa fa-thumbs-up"></i>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <h6 class="text-muted font-semibold">Total Voters (<?php echo date('Y'); ?>)</h6>
                        <h6 class="font-extrabold mb-0"><?php echo query_database("SELECT COUNT(awv_id) AS total FROM award_voters WHERE awv_banned=0 AND YEAR(awv_created_at)=YEAR(CURRENT_DATE) "); ?></h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- No. of votes -->
    <div class="col-6 col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body px-3 py-4-5">
                <div class="row">
                    <div class="col-md-4">
                        <div class="stats-icon blue">
                            <i class="fas fa-thumbs-up"></i>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <h6 class="text-muted font-semibold">Total Vote Cast (<?php echo date('Y'); ?>)</h6>
                        <h6 class="font-extrabold mb-0"><?php echo query_database("SELECT COUNT(awvs_id) AS total FROM award_vote_cast WHERE awvs_year=YEAR(CURRENT_DATE)  "); ?></h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <?php       
        $stmt = $db_connect->prepare("SELECT awc_id, awc_title FROM award_categories WHERE YEAR(awc_created_at)=YEAR(CURRENT_DATE) AND awc_active_status!=3 ORDER BY awc_id DESC ");
        $stmt->execute();
        if($stmt->rowCount() > 0)
        {
            $counter = 1;
            while($row=$stmt->fetch(PDO::FETCH_ASSOC))
            {
                $count = $counter++;
                extract($row); 
                $awc_title = $row['awc_title'];
                $awc_id = $row['awc_id'];
    ?>
    <div class="col-12 col-lg-4 col-md-4 col-sm-12 mb-4">
        <div class="card h-100">
            <div class="card-header"><h3><?php echo $awc_title; ?></h3></div>
            <div class="card-content h-100" align="center">
                <?php 

                    $tot_nominee_array   = [];
                    $tot_votes_array     = [];
                    $tot_formatted_array = [];
                    $tot_nomineeJson     = "";
                    $tot_votesJson       = 0;

                    $sql0005 = $db_connect->prepare(" SELECT * FROM ( SELECT awvs_nominee_id AS nominee FROM award_vote_cast WHERE awvs_category_id='$awc_id' AND YEAR(awvs_created_at)=YEAR(CURRENT_DATE) GROUP BY awvs_nominee_id) AS AWN JOIN ( SELECT COUNT(*) AS votes, awvs_nominee_id AS awnid FROM award_vote_cast GROUP BY awvs_nominee_id) AS VTS ON VTS.awnid=AWN.nominee ");
                    $sql0005->execute();
                    if($sql0005->rowCount() > 0)
                    {
                        while($row0005=$sql0005->fetch(PDO::FETCH_ASSOC))
                        {
                            $nominee = getNomineeName($row0005['nominee']);
                            $votes = $row0005['votes'];
                            $tot_nominee_formatted = $nominee;
                            $tot_votes_formatted = number_format($votes);
                            $new_format = $tot_nominee_formatted." = ".$tot_votes_formatted;

                            array_push($tot_nominee_array, $nominee);
                            array_push($tot_votes_array, $votes);
                            array_push($tot_formatted_array, $new_format);
                        }
                    }
                    else{
                        $nominee = "";
                        $votes = 0;
                        $tot_nominee_formatted = "";
                        $tot_votes_formatted = "";
                        $new_format = "";
                    }
                    
                    $tot_nomineeJson = json_encode($tot_nominee_array);
                    $tot_votesJson   = json_encode($tot_votes_array);

                ?>
                <div class="row">
                    <?php if($nominee!=""): ?>
                    <div class="col-md-12">
                        <canvas id="totalVoteChart<?php echo $count; ?>" width="400" height="250"></canvas>
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
    </div>

    <script>
        var new_tot_nominee = <?php echo $tot_nomineeJson; ?>;
        var new_tot_vote = <?php echo $tot_votesJson; ?>;
        var count = 'totalVoteChart<?php echo $count; ?>';
        if (new_tot_vote != "") {
            // statement
            var ctx = document.getElementById(count);
            var totalVoteChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: new_tot_nominee,
                    datasets: [{
                        label: 'Total Vote Cast',
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
                        yAxes: {
                            display: true,
                            beginAtZero: true,
                        }
                    },
                }
            });
        }
    </script>
    <?php 
            }
        }
    ?>
</div>


