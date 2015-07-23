<div  id="main">
    <?php echo $this->Session->flash(); ?>
    <div class="customers ">
        <div class="nav">
            <div id="tabs">
                <ul>
                    <?php
                        $i = 1;
                        foreach ($materialQualityChecks as $materialQualityCheck) {
                            if (isset($materialQualityCheck['disable']) && $materialQualityCheck['disable'] == 1) {
                                $class = 'disabled';
                            } else {
                                $class = '';
                            }
                    ?>
                        <li><?php echo $this->Html->link(__('Step') . ' - ' . $i, array('controller' => 'MaterialQualityCheckDetails', 'action' => 'add_quality_check', $materialQualityCheck['MaterialQualityCheck']['id'], $deliveryChallanId, $materialId, $class)); ?></li>

                    <?php
                        $i++;
                        }
                    ?>
                    <li><?php echo $this->Html->link(__('Add To Stock'), array('controller' => 'MaterialQualityCheckDetails', 'action' => 'add_to_stock', $materialId, $deliveryChallanId)); ?></li>
                </ul>
            </div>
        </div>
        <div id="customers_tab_ajax"></div>
    </div>
</div>

<script>
    $(function() {
        $("#tabs").tabs({
            beforeLoad: function(event, ui) {
                $(ui.panel).siblings('.ui-tabs-panel').empty();
                ui.jqXHR.error(function() {
                    ui.panel.html(
                            "Error Loading ... " +
                            "Please contact administrator.");
                });
            }
        });
    });
</script>

<script>
    $.ajaxSetup({beforeSend: function() {
            $("#busy-indicator").show();
        }, complete: function() {
            $("#busy-indicator").hide();
        }
    });
</script>