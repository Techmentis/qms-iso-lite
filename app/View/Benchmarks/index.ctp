<?php echo $this->Html->script(array('jquery.validate.min','jquery-form.min'));?>
<?php echo $this->fetch('script');?>

<div id="companyBenchmarks_ajax">
<?php echo $this->Session->flash();?>
    <div class="nav panel panel-default">
	<div class="companyBenchmarks form col-md-8">
	    <h4>Add Benchmark</h4>
            <?php if($benchMarks){
            $i=0;
	    foreach($benchMarks as $benchMark): ?>
		<div class="row">
		    <div class="col-md-12">
			<div class="panel panel-default">
			    <div class="panel-heading">
				<h4 class="list-group-item-heading"><?php echo __('Benchmarks for ');?><?php echo $benchMark['branch']['name']; ?> <span class="glyphicon glyphicon-pushpin pull-right"></span>
                                </h4>
				<p class="list-group-item-text"><?php echo __('This will help you track your preparedness.');?></p>
			    </div>
			    <div class="panel-body">
			    <?php echo $this->Form->create('benchmark',array('id'=>'BenchMarkForm-'.$i,'role'=>'form','class'=>'form blank')); ?>
				<?php foreach($benchMark['branch']['department'] as $key=>$value):?>
				<script>
				    $(function() {
					$( "#slider-<?php echo $benchMark['branch']['id']; ?>-<?php echo $value['id']; ?>" ).slider({
					range: "min",
					min: 0,
					max: 500,
					value: <?php echo $value['benchmark']; ?>,
					slide: function( event, ui ) {
					    $( "#vals-<?php echo $benchMark['branch']['id']; ?>-<?php echo $value['id']; ?>" ).html(ui.value);
					    $( "#<?php echo $benchMark['branch']['id']; ?>-<?php echo $value['id']; ?>" ).val(ui.value);

					    },
					stop: function( event, ui ) {
					    $( "#vals-<?php echo $benchMark['branch']['id']; ?>-<?php echo $value['id']; ?>" ).html(ui.value);
					    $( "#<?php echo $benchMark['branch']['id']; ?>-<?php echo $value['id']; ?>" ).val(ui.value);
                                            }
					    });
				    });
				 </script>
				 <h6 class="col-md-10 no-padding">
                                     <span class="pull-left"><?php echo $value['name']; ?> / per day </span>&nbsp;&nbsp;
                                        <div class="text-success pull-left" id="notice-<?php echo $benchMark['branch']['id']; ?>-<?php echo $value['id']; ?>">
                                        </div>
                                 </h6>
                                 <div id="vals-<?php echo $benchMark['branch']['id']; ?>-<?php echo $value['id']; ?>" class="col-md-2 pull-right"><?php echo $value['benchmark']; ?>
                                 </div>
                            	<div class="col-md-12" id="slider-<?php echo $benchMark['branch']['id']; ?>-<?php echo $value['id']; ?>"></div>
				<?php echo $this->Form->hidden('department.'.$value['id'].'.id',array('value'=>$value['id'])); ?>
				<?php echo $this->Form->hidden('benchmark.'.$value['id'].'.val',array('id'=>$benchMark['branch']['id'].'-'.$value['id'],'value'=>$value['benchmark'])); ?>
                            <?php
                                if(isset($value['benchmark_id']))
                                    echo $this->Form->input('benchmark.'.$value['id'].'.id',array('id'=>$benchMark['branch']['id'].'-'.$value['id'],'value'=>$value['benchmark_id'])); ?>
                            <div class="clear-fix">&nbsp;</div>
			    <?php endforeach ?>
			    <?php $branch_id = $benchMark['branch']['id'];?>
			    <?php echo $this->Form->hidden('branch.id', array('value'=>$branch_id)); ?>
			    <?php
                                echo $this->Form->submit(__('Submit'),array('div'=>false,'class'=>'btn btn-primary btn-success','update'=>'#branches_ajax','async' => 'false', 'id'=>'submit_id_'.$i));
                                echo $this->Form->end();
				echo $this->Html->image('indicator.gif', array('id' => 'submit-indicator_'.$i));
			    ?>
			    </div>
			</div>
		    </div>
		</div>
<script>
$().ready(function() {
    $("#submit-indicator_<?php echo $i; ?>").hide();
    $("#submit_id_<?php echo $i; ?>").click(function(){
	if($("#BenchMarkForm-<?php echo $i; ?>").valid()){
	    $("#submit_id_<?php echo $i; ?>").prop("disabled",true);
	    $("#submit-indicator_<?php echo $i; ?>").show();
	    $("#BenchMarkForm-<?php echo $i; ?>").submit();
	}
    });
});
</script>

	    <?php
	    $i++;
	    endforeach ?>
	    <?php } else { ?>
	    <div class="alert alert-danger">
		Please add branches first, or if there are branches already in the system, make sure to publish them.
		<br />
		<?php echo $this->Html->link('branches',array('controller'=>'branches')); ?> to  publish branches.
	    </div>
	    <?php } ?>
        </div>
            <div class="col-md-4">
                <p><?php echo $this->element('helps'); ?></p>
            </div>
     </div>
</div>
<script>$.ajaxSetup({beforeSend:function(){$("#busy-indicator").show();},complete:function(){$("#busy-indicator").hide();}});</script>