	<?php require_once("../../../resources/auth.inc.php"); ?>
	<!-- Logout Modal-->
	<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutConfirmModal" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered " role="document">
			<div class="modal-content">
				<div class="modal-header">
				    <h5 class="modal-title" id="logoutConfirmModal">Ready to Leave?</h5>
				    <button class="close text-danger" type="button" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
				</div>
				<div class="modal-body"><span><strong>Hi! <?php echo $user_fname; ?>, </strong> are you sure you want to leave the session? Click on the "Logout" button below if you really want to logout your account.</span></div>
				<div class="modal-footer">
				    <button class="btn btn-danger" type="button" data-bs-dismiss="modal">Cancel</button>
				    <a class="btn btn-primary" href="<?php echo ADMIN_BASE_URL . '/resources/library/logout.lib.php' ?>">Logout</a>
				</div>
			</div>
		</div>
	</div>
