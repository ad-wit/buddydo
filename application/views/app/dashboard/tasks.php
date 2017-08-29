<div class="ty-sub-container">
	<div class="ty-projects-tasks-container">
		<div class="ty-project-task">
			<div class="ty-project-add-task-container">
				<?php if( isset($tasks) && is_array($tasks) && count($tasks) > 0 ){ ?>
					<?php foreach ($tasks as $key => $value) { ?>
						<div class="ty-task-card <?php echo( $value['task_iscompleted'] == 0 ? 'incomplete' : 'completed' ); ?>">
							<p><?php echo $value['task_description']; ?></p>
							<?php if($value['task_iscompleted'] == 0){ ?>
								<a href="<?php echo base_url('app/marktask/complete/' . $value['task_public_id']); ?>" class="ty-task-change-status incomplete">Mark as completed</a>
							<?php }else{ ?>
								<a href="<?php echo base_url('app/marktask/incomplete/' . $value['task_public_id']); ?>" class="ty-task-change-status completed">Mark as uncomplete</a>
							<?php } ?>
						</div>
					<?php } ?>
				<?php }else{ ?>
					<h1 style="text-align: center; font-weight: 300; color: #666; font-size: 18px;">This list is empty</h1>
				<?php } ?>
			</div>
		</div>
		<div class="ty-project-task">
			<div class="ty-project-add-task-container">
				<div class="ty-add-first-task-form">
					<p style="padding-left: 10px;"><?php echo "Task List Name - <b>" . $tasklist['list_name'] . "</b>"; ?></p>
					<p style="padding-left: 10px;"><?php echo $summary; ?></p>
					<p style="padding-left: 10px;">Status - <?php echo $status; ?></p>
					<textarea name="task" style="resize: none;border-top: 1px solid #e3e3e3;" placeholder="Enter task here." class="ty-form-control-medium" id="" cols="30" rows="10"></textarea>
					<p class="task-error-message" style="padding: 0;text-align: center;">Account with this email doesn't exists.</p>
				</div>
				<div class="ty-project-add-first-task">
					<p class="add-task-btn">Add Task</p>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(e){
		$(document).on('click', '.add-task-btn', function(e){
			$('.task-error-message').css('visibility', 'hidden');
			if( $.trim($('textarea[name="task"]').val()) == '' ){
				$('.task-error-message').text('Task field cannot be empty.').css('visibility', 'visible');
			}else{
				var task = $.trim($('textarea[name="task"]').val());
				$.ajax({
					url : '<?php echo base_url('app/addtask/' . $taskid); ?>',
					data : { tasktext : task },
					type : 'get',
					success : function(data, status, jqxhr){
						var dat = JSON.parse(data);
						console.log(dat);
						if( dat.status == 'success' ){
							window.location.reload();
						}else{
							$('.task-error-message').text(dat.message).css('visibility', 'visible');
						}
					},
					error : function(jqxhr, status, error){
						console.log(error);
					}
				});
			}

		})
	});
</script>