<?php  
	require_once("../../resources/config.inc.php");
	require_once("../../resources/auth.inc.php");

?>
<style>
	a{
		text-decoration: none !important;
	}
</style>

<div class="row flex">
	<!-- No. of subscribers -->
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
	                    <h6 class="text-muted font-semibold">Active Subscribers</h6>
	                    <h6 class="font-extrabold mb-0"><?php echo query_database("SELECT COUNT(subs_id) AS total FROM subscriptions WHERE subs_active_status=1 "); ?></h6>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>
	<!-- No. of contacts -->
	<div class="col-6 col-lg-3 col-md-6">
	    <div class="card">
	        <div class="card-body px-3 py-4-5">
	            <div class="row">
	                <div class="col-md-4">
	                    <div class="stats-icon purple">
	                        <i class="fas fa-envelope"></i>
	                    </div>
	                </div>
	                <div class="col-md-8">
	                    <h6 class="text-muted font-semibold">Active Contacts</h6>
	                    <h6 class="font-extrabold mb-0"><?php echo query_database("SELECT COUNT(con_id) AS total FROM contacts WHERE con_active_status=1 "); ?></h6>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>
	<!-- No. of news -->
	<div class="col-6 col-lg-3 col-md-6">
	    <div class="card">
	        <div class="card-body px-3 py-4-5">
	            <div class="row">
	                <div class="col-md-4">
	                    <div class="stats-icon blue">
	                        <i class="fas fa-newspaper"></i>
	                    </div>
	                </div>
	                <div class="col-md-8">
	                    <h6 class="text-muted font-semibold">Active News Posts</h6>
	                    <h6 class="font-extrabold mb-0"><?php echo query_database("SELECT COUNT(news_id) AS total FROM news_posts WHERE news_active_status=1 "); ?></h6>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>
	<!-- No. of videos -->
	<div class="col-6 col-lg-3 col-md-6">
	    <div class="card">
	        <div class="card-body px-3 py-4-5">
	            <div class="row">
	                <div class="col-md-4">
	                    <div class="stats-icon green">
	                        <i class="fas fa-video"></i>
	                    </div>
	                </div>
	                <div class="col-md-8">
	                    <h6 class="text-muted font-semibold">Active Videos</h6>
	                    <h6 class="font-extrabold mb-0"><?php echo query_database("SELECT COUNT(vid_id) AS total FROM videos WHERE vid_active_status=1 "); ?></h6>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>
	<!-- No. of Events -->
	<div class="col-6 col-lg-3 col-md-6">
	    <div class="card">
	        <div class="card-body px-3 py-4-5">
	            <div class="row">
	                <div class="col-md-4">
	                    <div class="stats-icon red">
	                        <i class="fas fa-calendar-alt"></i>
	                    </div>
	                </div>
	                <div class="col-md-8">
	                    <h6 class="text-muted font-semibold">Active Events</h6>
	                    <h6 class="font-extrabold mb-0"><?php echo query_database("SELECT COUNT(eve_id) AS total FROM event_posts WHERE eve_active_status=1 "); ?></h6>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>
	<!-- No. of vote casts -->
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
	                    <h6 class="text-muted font-semibold">Total Vote Cast</h6>
	                    <h6 class="font-extrabold mb-0"><?php echo query_database("SELECT COUNT(awvs_id) AS total FROM award_vote_cast WHERE awvs_year=YEAR(CURRENT_DATE)  "); ?></h6>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>
	<!-- No. of Events -->
	<div class="col-6 col-lg-3 col-md-6">
	    <div class="card">
	        <div class="card-body px-3 py-4-5">
	            <div class="row">
	                <div class="col-md-4">
	                    <div class="stats-icon green">
	                        <i class="fas fa-user-check"></i>
	                    </div>
	                </div>
	                <div class="col-md-8">
	                    <h6 class="text-muted font-semibold">Total Voters</h6>
	                    <h6 class="font-extrabold mb-0"><?php echo query_database("SELECT COUNT(awv_id) AS total FROM award_voters WHERE YEAR(awv_created_at)=YEAR(CURRENT_DATE) AND awv_banned=0"); ?></h6>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>

	<!-- No. of Payments -->
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

	<!-- No. of amount collected -->
	<div class="col-6 col-lg-3 col-md-6">
	    <div class="card">
	        <div class="card-body px-3 py-4-5">
	            <div class="row">
	                <div class="col-md-4">
	                    <div class="stats-icon purple">
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
</div>