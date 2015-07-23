<?php echo $this->Html->script(array('jquery.validate.min', 'jquery-form.min')); ?>
<?php echo $this->fetch('script'); ?>

<script>
    $.validator.setDefaults({
        ignore: null,
        errorPlacement: function(error, element) {
            if ($(element).attr('name') == 'data[Customer][branch_id]') {
                $(element).next().after(error);
            } else {
                $(element).after(error);
            }
        },
        submitHandler: function(form) {
            $(form).ajaxSubmit({

                url: "<?php echo Router::url('/', true); ?><?php echo $this->request->params['controller'] ?>/add_ajax",
                type: 'POST',
                target: '#main',
                beforeSend: function(){
                   $("#submit_id").prop("disabled",true);
                    $("#submit-indicator").show();
                },
                complete: function() {
                   $("#submit_id").removeAttr("disabled");
                   $("#submit-indicator").hide();
                },
                error: function(request, status, error) {
                    //alert(request.responseText);
                    alert('Action failed!');
                }
            });

        }

    });

    $().ready(function() {
    $("#submit-indicator").hide();
        var curValue = $("input[name='data[Customer][customer_type]']").val();
        if (curValue != 0) {
            $("#CustomerMaritialStatus_chosen").width('100%');
            $("div.indCust").show();
        } else {
            $("div.indCust").hide();
        }

        $("input[name='data[Customer][customer_type]']").click(function() {
            var curValue = $("input[name='data[Customer][customer_type]']:checked").val();
            if (curValue == 0) {
                $("div.indCust").hide();
            } else {
                $("#CustomerMaritialStatus_chosen").width('100%');
                $("div.indCust").show();

            }
        });

        jQuery.validator.addMethod("greaterThanZero", function(value, element) {
            return this.optional(element) || (parseFloat(value) > 0);
        }, "Please select the value");
        jQuery.validator.addMethod("customPhoneNumber", function(value, element) {
            return this.optional(element) || /^[0-9-/()+]{6,16}$/i.test(value);
        }, "Please enter correct number");
        $('#CustomerAddAjaxForm').validate({
            rules: {
                "data[Customer][branch_id]": {
                    greaterThanZero: true,
                },
                "data[Customer][phone]": {
                    customPhoneNumber: true,
                },
                "data[Customer][mobile]": {
                    customPhoneNumber: true,
                },
            }
        });
        $('#CustomerBranchId').change(function() {
            if ($(this).val() != -1 && $(this).next().next('label').hasClass("error")) {
                $(this).next().next('label').remove();
            }
        });

        $('#CustomerCustomerCode').blur(function() {
            uniqueCheck(this.value, 'custCode');
        });
        $('#CustomerEmail').blur(function() {
            uniqueCheck(this.value, 'emailId');
        });
    });

    function uniqueCheck(chechVal, type) {
        if (type == 'custCode') {
            $("#getCustCode").load('<?php echo Router::url('/', true); ?><?php echo $this->request->params['controller'] ?>/get_unique_values/' + encodeURIComponent(chechVal) + '/' + type, function(response, status, xhr) {
                if (response != "") {
                    $('#CustomerCustomerCode').val('');
                    $('#CustomerCustomerCode').addClass('error');
                } else {
                    $('#CustomerCustomerCode').removeClass('error');
                }
            });
        } else {
            $("#getEmail").load('<?php echo Router::url('/', true); ?><?php echo $this->request->params['controller'] ?>/get_unique_values/' + encodeURIComponent(chechVal) + '/' + type, function(response, status, xhr) {
                if (response != "") {
                    $('#CustomerEmail').val('');
                    $('#CustomerEmail').addClass('error');
                } else {
                    $('#CustomerEmail').removeClass('error');
                }
            });
        }
    }
</script>

<div id="customers_ajax">
    <?php echo $this->Session->flash(); ?>
    <div class="nav">
        <div class="customers form col-md-8">
            <h4><?php echo __('Add Customer'); ?></h4>
            <?php echo $this->Form->create('Customer', array('role' => 'form', 'class' => 'form', 'default' => false)); ?>
            <div class="row">
                <div class="col-md-12"><?php
                    echo "<label>" . __('Customer Type') . "</label>";
                    echo $this->Form->input('customer_type', array('options' => array('0' => __('Company'), '1' => __('Individual')), 'type' => 'radio', 'class' => 'checkbox-2', 'legend' => false, 'default' => 0));
                    ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('name'); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('customer_since_date'); ?></div>
                <div class="col-md-6">
                    <?php echo $this->Form->input('customer_code'); ?>
                    <label id="getCustCode" class="error" style="clear:both" ></label>
                </div>
                <div class="col-md-6">
                    <?php echo $this->Form->input('email'); ?>
                    <label id="getEmail" class="error" style="clear:both" ></label>
                </div>
                <div class="col-md-6"><?php echo $this->Form->input('phone'); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('mobile'); ?></div>
                <div class="indCust">
                    <div class="col-md-6"><?php echo $this->Form->input('maritial_status', array('type' => 'select', 'options' => $maritalStatus, 'style' => 'width:100%', 'label' => __('Marital Status'))); ?></div>
                    <div class="col-md-6"><?php echo $this->Form->input('date_of_birth'); ?></div>
                </div>
                <div class="col-md-6"><?php echo $this->Form->input('residence_address', array('label' => __('Address'))); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('branch_id', array('label'=> __('Branch'), 'options' => $PublishedBranchList)); ?></div>
                <?php
                    echo $this->Form->input('branchid', array('type' => 'hidden', 'value' => $this->Session->read('User.branch_id', array('style' => 'width:100%', 'label' => __('Branch')))));
                    echo $this->Form->input('departmentid', array('type' => 'hidden', 'value' => $this->Session->read('User.department_id')));
                    echo $this->Form->input('master_list_of_format_id', array('type' => 'hidden', 'value' => $documentDetails['MasterListOfFormat']['id']));
                ?>
            </div>
            <?php
                if ($showApprovals && $showApprovals['show_panel'] == true) {
                    echo $this->element('approval_form');
                } else {
                    echo $this->Form->input('publish');
                }
            ?>
            <?php echo $this->Form->submit('Submit', array('div' => false, 'class' => 'btn btn-primary btn-success', 'update' => '#customers_ajax', 'async' => 'false','id'=>'submit_id')); ?>
            <?php echo $this->Html->image('indicator.gif', array('id' => 'submit-indicator')); ?>
            <?php echo $this->Form->end(); ?>
            <?php echo $this->Js->writeBuffer(); ?>
        </div>

<script>
    var myDate = new Date();
    var newDate = new Date(myDate.getFullYear() - 18, myDate.getMonth(), myDate.getDate());
    $("[name*='customer_since_date']").datetimepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'yy-mm-dd',
        'showTimepicker': false,
    }).attr('readonly', 'readonly');
    $("[name*='customer_since_date']").datetimepicker('option', 'maxDate', myDate);


    $("[name*='date_of_birth']").datetimepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'yy-mm-dd',
        'showTimepicker': false,
    }).attr('readonly', 'readonly');
    $("[name*='date_of_birth']").datetimepicker('option', 'maxDate', myDate);
</script>

        <div class="col-md-4">
            <p><?php echo $this->element('helps'); ?></p>
        </div>
    </div>
</div>

<script>
    $.ajaxSetup({beforeSend: function() {
            $("#busy-indicator").show();
        }, complete: function() {
            $("#busy-indicator").hide();
        }});
</script>