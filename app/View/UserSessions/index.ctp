<script type="text/javascript">
    $(document).ready(function() {
	$("#UserSessionUserId").chosen();

	$("#submit-indicator").hide();
	$("#submit_id").click(function(){
	    $("#submit_id").prop("disabled",true);
	    $("#submit-indicator").show();
	    $("#UserSessionIndexForm").submit();
	});
    });
</script>
<div  id="main"  id="users_ajax">
	<?php echo $this->Session->flash();?>
	<h3>User Audit Trails</h3>

	<div class="row panel">
		<div class="col-md-5">
			<?php
                            echo $this->Form->create('UserSession',array('action'=>'index','type'=>'get'),array('role'=>'form','class'=>'form'));
                            echo $this->Form->input('user_id',array('div'=>array('class'=>'form pull-left'), 'value'=>$userId));
                            echo $this->Form->submit('Submit',array('class'=>'btn btn-info pull-left', 'id'=>'submit_id', 'div'=>array('style'=>array('margin:30px 0 0 10px'))));
			    echo $this->Html->image('indicator.gif', array('id' => 'submit-indicator', 'class'=>'pull-right'));
                            echo $this->Form->end();
			?>
		</div>
		<div class="col-md-7"><br />
			<p class="alert alert-warning">Select username from the dropdown and click submit. You will be able to see all the login sessions for that user. You can then click on "Show Details" to check details of any perticular section.</p>
		</div>

	</div>
	<div class="userSessions row panel">
		<script type="text/javascript">
		$(document).ready(function(){
		$('table th a, .pag_list li span a').on('click', function() {
		var url = $(this).attr("href");
		$('#main').load(url);
		return false;
		});
		});
		</script>
		<div class="col-md-12">
			<div class="table-responsive row">
				<table class="table table-bordered table-striped table-hover">
				<tr>
					<th><?php echo $this->Paginator->sort('ip_address'); ?></th>
					<th><?php echo $this->Paginator->sort('start_time'); ?></th>
					<th><?php echo $this->Paginator->sort('end_time'); ?></th>
					<th>Active for</th>
					<th><?php echo $this->Paginator->sort('user_id'); ?></th>
					<th><?php echo $this->Paginator->sort('employee_id'); ?></th>
					<th>Show Details</th>
				</tr>
				<?php if($userSessions){ ?>
				<?php $x=0;
					foreach ($userSessions as $userSession):
				?>
				<tr>
					<td><?php echo h($userSession['UserSession']['ip_address']); ?>&nbsp;</td>
					<td><?php echo h($userSession['UserSession']['start_time']); ?>&nbsp;</td>
					<td><?php echo h($userSession['UserSession']['end_time']); ?>&nbsp;</td>
					<td><?php echo round(abs(strtotime($userSession['UserSession']['end_time']) - strtotime($userSession['UserSession']['start_time'])) / 60,2). " minutes";			?></td>
					<td><?php echo $this->Html->link($users[$userSession['User']['id']], array('controller' => 'users', 'action' => 'view', $userSession['User']['id'])); ?></td>
					<td><?php echo $this->Html->link($userSession['Employee']['name'], array('controller' => 'employees', 'action' => 'view', $userSession['Employee']['id'])); ?></td>
					<td><?php echo $this->Html->link('Show Details',array('action'=>'view',$userSession['UserSession']['id']),array('class'=>'btn btn-xs btn-info'));?></td>
				</tr>
				<?php $x++;
				 endforeach; ?>
				 <?php }else{ ?>
					<tr><td colspan=7>No results found</td></tr></table>
				<?php } ?>
				</table>
			</div>
			<p>
				<?php
				echo $this->Paginator->options(array(
				'update' => '#main',
				'evalScripts' => true,
				'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
				'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
				));

				echo $this->Paginator->counter(array(
				'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
				));
				?>
			</p>
			<ul class="pagination">
				<?php
				echo "<li class='previous'>".$this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'))."</li>";
				echo "<li>".$this->Paginator->numbers(array('separator' => ''))."</li>";
				echo "<li class='next'>".$this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'))."</li>";
				?>
			</ul>
		</div>
	</div>
</div>
<?php echo $this->Js->writeBuffer();?>
<script>$.ajaxSetup({beforeSend:function(){$("#busy-indicator").show();},complete:function(){$("#busy-indicator").hide();}});</script>