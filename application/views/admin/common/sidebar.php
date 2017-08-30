<div class="sidebar compact-2">
	<?php
        $seg1 = $this->uri->segment(1);
        $seg2 = $this->uri->segment(2);
        $seg3 = $this->uri->segment(3);
    ?>
	<ul>
		<li class="section-label">
			<span class="nav-section-label">Content</span>
		</li>
		<li class="<?php echo( $seg1 == "dashboard" ? "active" : "" ); ?>">
			<a href="<?php echo base_url("dashboard"); ?>">
				<i class="fa fa-tachometer fa-1x" ></i>
				<span class="nav-label">Dashboard</span>
			</a>
		</li>
		<!-- <li class="<?php echo( $seg1 == "tasks" ? "active" : "" ); ?>">
			<a href="<?php echo base_url("tasks"); ?>">
				<i class="fa fa-graduation-cap" aria-hidden="true"></i>
				<span class="nav-label">Tasks</span>
			</a>
		</li> -->
		<li class="<?php echo( $seg1 == "users" ? "active" : "" ); ?>">
			<a href="<?php echo base_url('users'); ?>">
				<i class="fa fa-user-o" aria-hidden="true"></i>
				<span class="nav-label">Users</span>
			</a>
		</li>
		<li>
			<a href="<?php echo base_url('admin/logout'); ?>">
				<i class="fa fa-sign-out" aria-hidden="true"></i>
				<span class="nav-label">Logout</span>
			</a>
		</li>
	</ul>
</div>