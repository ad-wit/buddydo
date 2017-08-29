<div class="ty-sub-container">
	<div class="ty-add-project-center">
		<div class="lists">
			<div class="section">
				<div class="section-name">
					<a class="account-links">Tasks <span class="assigned-to">Assigned by you</span></a>
				</div>
				<div class="list assigned-to-you">
					<div class="ty-projects-container">
						<?php if( isset($tasks_assigned_by_me) && is_array($tasks_assigned_by_me) && count($tasks_assigned_by_me) > 0 ){ ?>
							<?php foreach ($tasks_assigned_by_me as $key => $value) { ?>
								<div class="ty-project">
									<?php if( $value['is_completed'] == 'completed' ){ ?>
										<img class="tasklist-completed" src="<?php echo base_url('assets/img/tick.png'); ?>" title="Task List Completed" alt="" />
									<?php } ?>
									<a href="<?php echo base_url('app/tasklist/' . $value['list_public_id']); ?>" class="ty-project-anchor-wrapper">
										<div class="ty-project-info">
											<p class="ty-project-name"><?php echo $value['list_name'] ?></p>
											<p class="ty-project-description">Assigned to <?php echo $value['list_assigned_to']['user_name']; ?></p>
										</div>
									</a>
									<div class="ty-project-actions"></div>
								</div>
							<?php } ?>
						<?php }else{ ?>
							<h1 class="message">You dont have assigned any tasks to any one.</h1>
						<?php } ?>
					</div>
				</div>
			</div>
			<div class="section">
				<div class="section-name">
					<a class="account-links">Tasks <span class="assigned-by">Assigned to you</span></a>
				</div>
				<div class="list assigned-by-you">
					<div class="ty-projects-container">
						<?php if( isset($tasks_assigned_to_me) && is_array($tasks_assigned_to_me) && count($tasks_assigned_to_me) > 0 ){ ?>
							<?php foreach ($tasks_assigned_to_me as $key => $value) { ?>
								<div class="ty-project">
									<?php if( $value['is_completed'] == 'completed' ){ ?>
										<img class="tasklist-completed" src="<?php echo base_url('assets/img/tick.png'); ?>" title="Task List Completed" alt="" />
									<?php } ?>
									<a href="<?php echo base_url('app/tasklist/' . $value['list_public_id']); ?>" class="ty-project-anchor-wrapper">
										<div class="ty-project-info">
											<p class="ty-project-name"><?php echo $value['list_name'] ?></p>
											<p class="ty-project-description">Assigned by <?php echo $value['list_assigned_by']['user_name']; ?></p>
										</div>
									</a>
									<div class="ty-project-actions"></div>
								</div>
							<?php } ?>
						<?php }else{ ?>
							<h1 class="message">You haven't assigned any tasks yet.</h1>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>