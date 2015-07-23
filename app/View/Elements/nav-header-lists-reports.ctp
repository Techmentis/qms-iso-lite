<div class="row">
    <div class="col-md-8">
        <h4><?php echo h($postData["pluralHumanName"]); ?>
            <span class=""></span>
            <span class=""></span>
            <?php echo $this->Html->image('indicator.gif', array('id' => 'busy-indicator')); ?>
        </h4>
    </div>
    <div class="col-md-4">
        <h4>From : <?php echo $this->request->data['reports']['from'] ?>
            To : <?php echo $this->request->data['reports']['to'] ?> </h4>
    </div>
</div>

