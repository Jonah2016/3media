<style>
    .award_navbar .pill-nav a {
      display: inline-block;
      color: black;
      text-align: center;
      padding: 0.8rem;
      text-decoration: none;
      font-size: 1.05rem;
      border-radius: 0.23rem;
      font-weight: 800;
    }
    .award_navbar .pill-nav a:hover {
      background-color: #ddd;
      color: black;
    }
    .award_navbar .pill-nav a.active {
      background-color: #000;
      color: white;
    }
</style>

<div class="row award_navbar noselect">
    <div class="pill-nav" align="center">
      <a class="<?php if(isset($award_abt_active)){ echo $award_abt_active; } ?>" href="<?php echo SECTION_PATH.'award/about_awards'; ?>">About</a>
      <a class="<?php if(isset($award_news_active)){ echo $award_news_active; } ?>" href="<?php echo SECTION_PATH.'award/'; ?>">Latest news</a>
      <a class="<?php if(isset($award_nom_active)){ echo $award_nom_active; } ?>" href="<?php echo SECTION_PATH.'award/nominees'; ?>">Nominees</a>
      <a class="<?php if(isset($award_win_active)){ echo $award_win_active; } ?>" href="<?php echo SECTION_PATH.'award/winners'; ?>">Winners</a>
      <?php if ($sett_data['sett_voting_opened'] == 1): ?>
      <a class="<?php if(isset($award_vot_active)){ echo $award_vot_active; } ?>" href="<?php echo SECTION_PATH.'award/voting'; ?>">Voting</a>
      <?php endif ?>
    </div>
</div>
        