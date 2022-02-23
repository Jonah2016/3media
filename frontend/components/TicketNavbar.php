<?php if(isset($page_id) && !empty($page_id)){ $neo_page_id =  $page_id; } else {$neo_page_id = "";} ?>
<div class="col-lg-12 col-md-12 col-sm-12">
      <div class="row instruction_title noselect">
          <div class="col-lg-4 col-md-4 col-sm-12 text-muted <?php if(isset($choose_ticket_active)){ echo $choose_ticket_active; } ?> instruction_texts">
              <a href="<?php echo SECTION_PATH.'tickets/?tid='.$neo_page_id; ?>" class="text-dark"><h3 class="py-3">1. Choose Your Tickets</h3></a>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-12 text-muted <?php if(isset($payment_active)){ echo $payment_active; } ?> instruction_texts">
            <a href="<?php echo SECTION_PATH.'tickets/ticket_checkout'; ?>" class="text-dark"><h3 class="py-3">2. Checkout</h3></a>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-12 <?php if(isset($confirm_details_active)){ echo $confirm_details_active; } ?> instruction_texts">
            <a href="<?php echo SECTION_PATH.'tickets/payment_details?pid='.$neo_page_id; ?>" class="text-dark"><h3 class="py-3">3. Confirm Details</h3></a>
          </div>
      </div>
</div>