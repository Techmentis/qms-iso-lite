<div class="main nav panel">
    <div class="panel-title">
    	<div class="panel-heading"><h3><?php echo __('FlinkISO Manual Report Center'); ?></h3></div>
    </div>
    <div class="panel-body">
        <div class="panel-group" id="full_report_accordion">
                <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="row">
                                <?php if($dateDiff == 0){
                                    $minDate = 0;
                                }else{
                                    $minDate = '-'.$dateDiff.'M';
                                }
                                
                                ?>
                                    <script>
                                    $(document).ready(function(){
                                        $("#submit-indicator").hide();
                                        $('#ddfrom').datepicker({
                                                changeMonth: true,
                                                changeYear: true,
                                                dateFormat: 'MM yy',
                                                 minDate: '<?php echo $minDate;?>',
                                                 maxDate:0,
                                                onClose: function(dateText, inst) {
                                                var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
                                                var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
                                                 $(this).val($.datepicker.formatDate('yy-mm', new Date(year, month, 1)));
                                                }                                                
                                        });
                                        // getter
                                        var showButtonPanel = $("#ddfrom").datepicker( "option", "showButtonPanel" );
                                        $("#ddfrom").datepicker( "option", "showButtonPanel", true );
                                        
                                         $("#ddfrom").focus(function () {
                                             $('#ddfrom').removeClass('error');
                                            $(".ui-datepicker-calendar").hide();
                                            $("#ui-datepicker-div").position({
                                                my: "left top",
                                                at: "left bottom",
                                                of: $(this)
                                            });
                                        });
                                        
                                        $('#generate_report').click(function(){
                                             $("#generate_report").prop("disabled",true);
                                             $("#submit-indicator").show();
                                            var date = $('#ddfrom').val();
                                            
                                            if(date === ''){
                                                $('#ddfrom').addClass('error');
                                                $("#generate_report").prop("disabled",false);
                                                $("#submit-indicator").hide();
                                            }else{
                                            $('#ddfrom').removeClass('alert-danger');
                                            var date1 = new Date(date);
                                            var m = date1.getMonth()+1;
                                            var y = date1.getFullYear();
                                            var date1 = m+'/'+y;
                                            $.ajax({
                                                url: "<?php echo Router::url('/', true); ?><?php echo $this->request->params['controller'] ?>/manual_reports/"+date,
                                                type: 'GET',
                                                success: function(response){
                                                    if(response ){
                                                        $("#generate_report").prop("disabled",false);
                                                        $("#submit-indicator").hide();
                                                        $("#msg").html("<div class="+"col-md-12"+"><h3 class="+"text-success"+">Report Generated successfully.<a href="+"report_center"+"> Click Here</a></h3></div>");
                                                    }
                                                }
                                                    
                                            });
                                          }
                                            
                                        });
                                        
                                    });
                                        </script>
                                <div class="col-md-8">
                                    <div class ="row">
                                    <div class="col-md-12">
                                    <p>
                                    	If you do not have your cron jobs or scheduler set up, you can generate the reports for the month from this section.
                                        <br /><br />
                                       To generate the report select the month & year from the dropn-down below and click "Generate Report". It will generate, daily, weekly & monthly reports for that month.                                         
                                    </p>
                                    </div>
                                    <div class="col-md-4">
                                        <?php echo $this->Form->input('from', array('id' => 'ddfrom', 'label' => false, 'class' => 'btn', 'div' => array('class' => 'input-group-btn'))); ?>
                                    </div>
                                    <div class="col-md-4">
                                        <?php echo $this->Form->Submit('Generate Report', array('id'=>'generate_report','class' => 'btn btn-success ', 'div' => FALSE)); ?>
                                        <?php echo $this->Html->image('indicator.gif', array('id' => 'submit-indicator')); ?>
                                    </div>
                                    </div>
                                    <div class="row">
                                        <div id ="msg" class="success">
                                            
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
