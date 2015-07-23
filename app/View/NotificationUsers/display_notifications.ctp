<p class=""><?php if($notificationUsers){ ?>
<?php foreach ($notificationUsers as $notification): ?>
<strong><?php echo $notificationType[$notification['Notification']['notification_type_id']] ?> Notification : <?php echo h($notification['Notification']['title']); ?>&nbsp;</strong><br/>
<?php echo  $notification['Notification']['message']; ?>&nbsp;<br />
<?php echo $this->Time->nice($notification['Notification']['start_date']); ?>&nbsp;
<?php endforeach; ?>
</p>
<?php }else{ ?>
<div style="padding: 5px" class="text-center">
          <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
        <!-- notificationa-ads -->
        <ins class="adsbygoogle"
             style="display:inline-block;width:320px;height:50px"
             data-ad-client="ca-pub-2922039071440353"
             data-ad-slot="7868701425"></ins>
        <script>
        (adsbygoogle = window.adsbygoogle || []).push({});
        </script>
        <br /><small>There are no notifications. Showing ad instead. Ads will disaper when there are notifications.</small>    
</div>
<?php } ?>

			<?php
			echo $this->Paginator->options(array(
			'update' => '#notification-center',
			'evalScripts' => true,
			'before' => $this->Js->get('#notification-indicator')->effect('fadeIn', array('buffer' => false)),
			'complete' => $this->Js->get('#notification-indicator')->effect('fadeOut', array('buffer' => false)),
			));

			?>
			<ul class="pager custom-pager">
			<?php

		echo "<li>".$this->Paginator->numbers(array('separator' => '','class'=>'badge btn-primary'))."</li>";

	?>
			</ul>

<script>$.ajaxSetup({beforeSend:function(){$("#notification-indicator").show();},complete:function(){$("#notification-indicator").hide();}});</script>
<?php echo $this->Js->writeBuffer();?>