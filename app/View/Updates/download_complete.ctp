<div id="update-complete">
    <h3 class="text-success">Download Complete!</h3>
    <h5 class="text-success link">Copying files to application</h5>
</div>
<script>
    $(document).ajaxStop(function() {
        $("#update-complete").load("<?php echo Router::url('/', true); ?><?php echo $this->request->params['controller'] ?>/update_complete/<?php echo $vars; ?>");
        $(this).unbind('ajaxStop');
});
</script>