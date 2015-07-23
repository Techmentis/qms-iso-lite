<div class="col-md-12">
    <?php
        if ($products) {
            echo $this->Form->input('CorrectivePreventiveAction.record_id', array('options' => $products));
        }
    ?>
</div>