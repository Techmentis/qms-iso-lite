<script>
    $().ready(function () {
        $.ajaxSetup({cache: false});
        $('#int_audits_modal_window<?php echo $record_id; ?>').modal();
    });


</script>

<style>.modal-dialog{ width:80%}</style>

<div class="modal fade" id="int_audits_modal_window<?php echo $record_id; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">View / Upload Approval Files</h4>
            </div>
            <div class="modal-body">
                <?php echo $this->element('upload-edit', array('usersId' => $created_by, 'recordId' => $record_id)); ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
