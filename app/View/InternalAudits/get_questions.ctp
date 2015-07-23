<h5>Click <span class="glyphicon glyphicon-download"></span> icon to drop the question below</h5>
<table cellpadding="0" cellspacing="0" class="table table-responsive table-hover">
    <?php if ($internalAuditQuestions) {
            $x = 0;
            foreach ($internalAuditQuestions as $internalAuditQuestion):
    ?>
            <tr>
                <td id="Q<?php echo $x; ?>"><?php echo h($internalAuditQuestion['InternalAuditQuestion']['title']); ?></td>
                <td width="60">
                    <span class="glyphicon glyphicon-download" id="<?php echo $x; ?>" data="<?php echo h($internalAuditQuestion['InternalAuditQuestion']['title']); ?>"></span>

<script>
    $("#<?php echo $x; ?>").click(function () {
        $("#InternalAuditQuestionAsked").val($("#Q<?php echo $x; ?>").html())
    });
</script>

                </td>
            </tr>
    <?php
        $x++;
        endforeach;
        }else {
    ?>
    <tr><td colspan=2>No sample questions are available for this department</td></tr>
    <?php } ?>
