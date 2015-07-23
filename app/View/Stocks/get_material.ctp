<?php echo $this->Form->input('Stock.material_id', array('options' => $materials)); ?>
<script>
    $('#StockMaterialId').chosen();
</script>
<script>
    $(document).ready(function() {
        $('#StockMaterialId').change(function() {
            $('#materialDetails').load('<?php echo Router::url('/', true); ?><?php echo $this->request->params['controller'] ?>/get_material_details/' + $('#StockMaterialId').val())
        });
    });
</script>