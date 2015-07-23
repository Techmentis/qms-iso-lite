<script>

    function messages_sent_action(control) {
        $('#messagesSentForm').find(':checkbox').prop('checked', control.checked);
        getVals();
    }
    function messages_inbox_action(control) {
        $('#messagesInboxForm').find(':checkbox').prop('checked', control.checked);
        getVals();
    }

    function messages_trash_action(control) {
        $('#messagesTrashForm').find(':checkbox').prop('checked', control.checked);
        getVals();
    }

    function getVals() {
        var checkedValue = null;
        $("#recs_selected").val(null);
        $("#approve_recs_selected").val(null);
        $("#recs_selected_for_delete").val(null);
        $("#recs_selected_sent_for_delete").val(null);
        $("#recs_selected_inbox_for_delete").val(null);
        $("#recs_selected_trash_for_delete").val(null);
        $("#recs_selected_for_purge").val(null);

        var inputElements = document.getElementsByTagName('input');

        for (var i = 0; inputElements[i]; ++i) {

            if (inputElements[i].className === "rec_ids" && inputElements[i].checked)
            {
                $("#approve_recs_selected").val($("#approve_recs_selected").val() + '+' + inputElements[i].value);
                $("#approval_recs_selected").val($("#approval_recs_selected").val() + '+' + inputElements[i].value);
                $("#recs_selected").val($("#recs_selected").val() + '+' + inputElements[i].value);
                $("#recs_selected_for_delete").val($("#recs_selected_for_delete").val() + '+' + inputElements[i].value);
                $("#recs_selected_sent_for_delete").val($("#recs_selected_sent_for_delete").val() + '+' + inputElements[i].value);

                $("#recs_selected_inbox_for_delete").val($("#recs_selected_inbox_for_delete").val() + '+' + inputElements[i].value);
                $("#recs_selected_trash_for_delete").val($("#recs_selected_trash_for_delete").val() + '+' + inputElements[i].value);
                $("#recs_selected_for_purge").val($("#recs_selected_for_purge").val() + '+' + inputElements[i].value);
                $("#recs_selected_for_export").val($("#recs_selected_for_export").val() + '+' + inputElements[i].value);

            }
        }
    }
</script>
