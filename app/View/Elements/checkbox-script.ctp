<script>
    $(document).ready(function() {
        $('#selectAll').on('click', function() {
            $(this).closest('form').find(':checkbox').prop('checked', this.checked);
            getVals();
        });
    });

    function getVals() {

        var checkedValue = null;
        $("#recs_selected").val(null);
        $("#approve_recs_selected").val(null);
        $("#recs_selected_for_delete").val(null);
        $("#recs_selected_for_restore").val(null);
        $("#recs_selected_for_purge").val(null);

        var inputElements = document.getElementsByTagName('input');

        for (var i = 0; inputElements[i]; ++i) {

            if (inputElements[i].className === "rec_ids" && inputElements[i].checked)
            {
                $("#approve_recs_selected").val($("#approve_recs_selected").val() + '+' + inputElements[i].value);
                $("#approval_recs_selected").val($("#approval_recs_selected").val() + '+' + inputElements[i].value);
                $("#recs_selected").val($("#recs_selected").val() + '+' + inputElements[i].value);
                $("#recs_selected2").val($("#recs_selected").val() + '+' + inputElements[i].value);
                $("#recs_selected_for_delete").val($("#recs_selected_for_delete").val() + '+' + inputElements[i].value);
                $("#recs_selected_for_restore").val($("#recs_selected_for_restore").val() + '+' + inputElements[i].value);
                $("#recs_selected_for_purge").val($("#recs_selected_for_purge").val() + '+' + inputElements[i].value);
                $("#recs_selected_for_export").val($("#recs_selected_for_export").val() + '+' + inputElements[i].value);
            }
        }
    }
</script>
