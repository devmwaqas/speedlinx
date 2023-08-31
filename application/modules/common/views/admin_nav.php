<?php $class = $this->router->fetch_class(); ?>

<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">
                    <img alt="image" class="rounded-circle" src="<?php echo base_url(); ?>admin_assets/img/user.png" style="width: 30px;background: white;"/>
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="block m-t-xs font-bold"> <?php echo $this->session->userdata('admin_username'); ?> </span>
                        <span class="text-muted text-xs block"> <?php echo ($this->session->userdata('admin_type') == 1) ? "Admin" : "Editor"; ?> <b class="caret"></b></span>
                    </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a class="dropdown-item" href="<?php echo admin_url(); ?>profile">Profile</a></li>
                        <li><a class="dropdown-item" href="<?php echo admin_url(); ?>logout">Logout</a></li>
                    </ul>
                </div>
                <div class="logo-element">
                    TA
                </div>
            </li>

            <li <?php if($class == "admin" ) { ?> class="active" <?php } ?>>
                <a href="<?php echo admin_url(); ?>dashboard"><i class="fa fa-th-large"></i> <span class="nav-label">Dashboard</span></a>
            </li>

            <li <?php if($class == "service_areas" ) { ?> class="active" <?php } ?>>
                <a href="<?php echo admin_url(); ?>service_areas"><i class="fa fa-map"></i> <span class="nav-label">Service Areas</span>  </a>
            </li>

            <li <?php if($class == "users" ) { ?> class="active" <?php } ?>>
                <a href="<?php echo admin_url(); ?>users"><i class="fa fa-users"></i> <span class="nav-label">Users</span>  </a>
            </li>

            <li <?php if($class == "service_requests" ) { ?> class="active" <?php } ?>>
                <a href="<?php echo admin_url(); ?>service_requests"><i class="fa fa-list"></i> <span class="nav-label">Service Requests</span>  </a>
            </li>

            <li <?php if($class == "tickets" ) { ?> class="active" <?php } ?>>
                <a href="<?php echo admin_url(); ?>tickets"><i class="fa fa-ticket"></i> <span class="nav-label">Tickets</span>  </a>
            </li>

            <li <?php if($class == "feedbacks" ) { ?> class="active" <?php } ?>>
                <a href="<?php echo admin_url(); ?>feedbacks"><i class="fa fa-comments-o"></i> <span class="nav-label">Feedbacks</span>  </a>
            </li>

        </ul>

    </div>
</nav>