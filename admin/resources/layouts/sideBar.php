<!-- Side bar -->
<div id="sidebar" class="active">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header">
            <div class="d-flex justify-content-between">
                <div class="logo">
                    <a href="<?php echo ADMIN_BASE_PATH; ?>"><img height="100%" src="<?php echo ASSETS_PATH; ?>/img/logo/logo.jpg" alt="Logo" srcset=""></a>
                </div>
                <div class="toggler">
                    <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                </div>
            </div>
        </div>
        <div class="sidebar-menu">
            <ul class="menu">
                <li class="sidebar-title">Menu</li>

                <li class="sidebar-item  <?php if(isset($home_active)){ echo $home_active; } ?>">
                    <a href="<?php echo ADMIN_BASE_PATH; ?>views/" class='sidebar-link'> <i class="bi bi-grid-fill"></i> <span>Dashboard</span> </a>
                </li>

                <li class="sidebar-item  <?php if(isset($contact_active)){ echo $contact_active; } ?>">
                    <a href="<?php echo ADMIN_BASE_PATH; ?>views/contacts/" class='sidebar-link'><i class="bi bi-person-badge-fill"></i> <span>Contacts</span> </a>
                </li>
                <li class="sidebar-item  <?php if(isset($subscription_active)){ echo $subscription_active; } ?>">
                    <a href="<?php echo ADMIN_BASE_PATH; ?>views/subscriptions/" class='sidebar-link'><i class="bi bi-hand-thumbs-up-fill"></i> <span>Subscriptions</span> </a>
                </li>

                <?php if ($neo_eve_permission == "1"): ?>
                <li class="sidebar-item  has-sub <?php if(isset($events_mgt_active)){ echo $events_mgt_active; } ?>">
                    <a href="#" class='sidebar-link'>
                        <i class="bi bi-calendar-fill"></i>
                        <span>Events Management</span>
                    </a>
                    <ul class="submenu ">
                        <li class="submenu-item <?php if(isset($event_active)){ echo $event_active; } ?>">
                            <a href="<?php echo ADMIN_BASE_PATH; ?>views/events_management/">Events</a>
                        </li>
                        <li class="submenu-item <?php if(isset($tickets_active)){ echo $tickets_active; } ?>">
                            <a href="<?php echo ADMIN_BASE_PATH; ?>views/events_management/tickets">Tickets</a>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-item  <?php if(isset($tickets_active)){ echo $tickets_active; } ?>">
                    <a href="<?php echo ADMIN_BASE_PATH; ?>views/events_management/tickets" class='sidebar-link'><i class="bi bi-cash"></i> <span>Ticket Sales</span> </a>
                </li>
                <li class="sidebar-item  <?php if(isset($voting_active)){ echo $voting_active; } ?>">
                    <a href="<?php echo ADMIN_BASE_PATH; ?>views/awards_management/voting" class='sidebar-link'><i class="bi bi-check-square-fill"></i> <span>Voting</span> </a>
                </li>
                <?php endif ?>


                <li class="sidebar-title">Editorial Content</li>

                <?php if ($neo_news_permission == "1"): ?>
                <li class="sidebar-item  <?php if(isset($news_active)){ echo $news_active; } ?>">
                    <a href="<?php echo ADMIN_BASE_PATH; ?>views/news_management/" class='sidebar-link'><i class="bi bi-newspaper"></i> <span>News Posts</span> </a>
                </li>
                <?php endif ?>

                <?php if ($neo_eve_permission == "1"): ?>
                <li class="sidebar-item has-sub <?php if(isset($awards_active)){ echo $awards_active; } ?>">
                    <a href="#" class='sidebar-link'>
                        <i class="bi bi-award-fill"></i>
                        <span>Awards</span>
                    </a>
                    <ul class="submenu ">
                        <li class="submenu-item <?php if(isset($about_awards_active)){ echo $about_awards_active; } ?>">
                            <a href="<?php echo ADMIN_BASE_PATH; ?>views/awards_management">About Award</a>
                        </li>
                        <li class="submenu-item <?php if(isset($nominees_active)){ echo $nominees_active; } ?>">
                            <a href="<?php echo ADMIN_BASE_PATH; ?>views/awards_management/nominees">Nominees</a>
                        </li>
                    </ul>
                </li>
                <?php endif ?>
                <li class="sidebar-title">Media Content</li>

                <?php if ($neo_med_permission == "1"): ?>
                <li class="sidebar-item  <?php if(isset($videos_active)){ echo $videos_active; } ?>">
                    <a href="<?php echo ADMIN_BASE_PATH; ?>views/videos_management/" class='sidebar-link'><i class="bi bi-collection-play-fill"></i> <span>Videos</span> </a>
                </li>
                <?php endif ?>

                <?php if ($neo_adv_permission == "1"): ?>
                <li class="sidebar-item  <?php if(isset($advert_active)){ echo $advert_active; } ?>">
                    <a href="<?php echo ADMIN_BASE_PATH; ?>views/advs_management/" class='sidebar-link'><i class="bi bi-badge-ad-fill"></i> <span>Advertisement</span> </a>
                </li>
                <?php endif ?>

                <li class="sidebar-title">Others</li>

                <?php if ($neo_set_permission == "1"): ?>
                <li class="sidebar-item  has-sub <?php if(isset($settings_active)){ echo $settings_active; } ?>">
                    <a href="#" class='sidebar-link'>
                        <i class="bi bi-gear-fill"></i>
                        <span>Settings</span>
                    </a>
                    <ul class="submenu ">
                        <li class="submenu-item <?php if(isset($general_active)){ echo $general_active; } ?>">
                            <a href="<?php echo ADMIN_BASE_PATH; ?>views/general_settings/settings">General</a>
                        </li>
                        <li class="submenu-item <?php if(isset($about_active)){ echo $about_active; } ?>">
                            <a href="<?php echo ADMIN_BASE_PATH; ?>views/general_settings/about">About</a>
                        </li>
                    </ul>
                </li>
                <?php endif ?>

                <?php if ($neo_user_permission == "1"): ?>
                <li class="sidebar-item  <?php if(isset($users_active)){ echo $users_active; } ?>">
                    <a href="<?php echo ADMIN_BASE_PATH; ?>views/user_management/users" class='sidebar-link'><i class="bi bi-person-square"></i> <span>Users</span> </a>
                </li>
                <?php endif ?>
            </ul>
        </div>
        <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
    </div>
</div>
<!-- // End Side bar -->

<!-- Main content of the dashboard -->
<div id="main" class='layout-navbar'>