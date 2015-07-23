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
        var inputElements = document.getElementsByTagName('input');

        for (var i = 0; inputElements[i]; ++i) {

            if (inputElements[i].className === "rec_ids" &&
                    inputElements[i].checked)
            {
                $("#approve_recs_selected").val($("#approve_recs_selected").val() + '+' + inputElements[i].value);
                $("#recs_selected").val($("#recs_selected").val() + '+' + inputElements[i].value);

            }
        }
    }
</script>

<div  id="main">
    <?php echo $this->Session->flash(); ?>
    <div class="materialTypes ">
        <?php echo $this->element('nav-header-lists', array('postData' => array('pluralHumanName' => 'Material Types', 'modelClass' => 'MaterialType', 'options' => array("sr_no" => "Sr No", "name" => "Name"), 'pluralVar' => 'materialTypes'))); ?>

<script type="text/javascript">
    $(document).ready(function() {
        $('table th a, .pag_list li span a').on('click', function() {
            var url = $(this).attr("href");
            $('#main').load(url);
            return false;
        });
    });
</script>

        <div class="table-responsive">
            <?php echo $this->Form->create(array('class' => 'no-padding no-margin no-background')); ?>
            <table cellpadding="0" cellspacing="0" class="table table-bordered table table-striped table-hover">
                <tr>
                    <th colspan="2"><input type="checkbox" id="selectAll"></th>
                    <th><?php echo $this->Paginator->sort('sr_no'); ?></th>
                    <th><?php echo $this->Paginator->sort('name'); ?></th>
                    <th><?php echo $this->Paginator->sort('prepared_by'); ?></th>
                    <th><?php echo $this->Paginator->sort('approved_by'); ?></th>
                    <th><?php echo $this->Paginator->sort('publish'); ?></th>
                </tr>
                <?php if ($materialTypes) {
                        $x = 0;
                        foreach ($materialTypes as $materialType):
                ?>
                <tr>
                    <td width="15"><?php echo $this->Form->checkbox('rec_ids_' . $x, array('label' => false, 'value' => $materialType['MaterialType']['id'], 'multiple' => 'checkbox', 'class' => 'rec_ids', 'onClick' => 'getVals()')); ?></td>
                    <td class=" actions">
                        <div class="btn-group">
                            <button type="button" data-toggle="dropdown" class="dropdown-toggle btn  btn-sm btn-default "><span class=" glyphicon glyphicon-wrench"></span></button>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                <li><?php echo $this->Html->link(__('View / Upload Evidence'), array('action' => 'view', $materialType['MaterialType']['id'])); ?></li>
                                <li><?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $materialType['MaterialType']['id'])); ?></li>
                                <li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $materialType['MaterialType']['id']), array('style' => 'display:none'), __('Are you sure you want to delete this record ?', $materialType['MaterialType']['id'])); ?></li>
                                <li class="divider"></li>
                                <li><?php echo $this->Form->postLink(__('Delete Record'), array('action' => 'delete', $materialType['MaterialType']['id']), array('class' => ''), __('Are you sure ?', $materialType['MaterialType']['id'])); ?></li>
                            </ul>
                        </div>
                    </td>
                    <td width="50"><?php echo h($materialType['MaterialType']['sr_no']); ?>&nbsp;</td>
                    <td><?php echo h($materialType['MaterialType']['name']); ?>&nbsp;</td>
                    <td><?php echo h($PublishedEmployeeList[$materialType['MaterialType']['prepared_by']]); ?>&nbsp;</td>
                    <td><?php echo h($PublishedEmployeeList[$materialType['MaterialType']['approved_by']]); ?>&nbsp;</td>
                    <td width="60">
                        <?php if ($materialType['MaterialType']['publish'] == 1) { ?>
                            <span class="glyphicon glyphicon-ok-sign"></span>
                        <?php } else { ?>
                            <span class="glyphicon glyphicon-remove-circle"></span>
                        <?php } ?>&nbsp;</td>

                </tr>
                <?php
                    $x++;
                    endforeach;
                    } else {
                ?>
                    <tr><td colspan=14>No results found</td></tr>
                <?php } ?>
            </table>
            <?php echo $this->Form->end(); ?>
        </div>
        <p>
            <?php
                echo $this->Paginator->options(array(
                    'update' => '#main',
                    'evalScripts' => true,
                    'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
                    'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
                ));

                echo $this->Paginator->counter(array(
                    'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
                ));
            ?>
        </p>
        <ul class="pagination">
            <?php
                echo "<li class='previous'>" . $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled')) . "</li>";
                echo "<li>" . $this->Paginator->numbers(array('separator' => '')) . "</li>";
                echo "<li class='next'>" . $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled')) . "</li>";
            ?>
        </ul>
    </div>
</div>

<?php echo $this->element('export'); ?>
<?php echo $this->element('advanced-search', array('postData' => array("sr_no" => "Sr No", "name" => "Name"), 'PublishedBranchList' => array($PublishedBranchList))); ?>
<?php echo $this->element('import', array('postData' => array("sr_no" => "Sr No", "name" => "Name"))); ?>
<?php echo $this->element('approvals'); ?>
<?php echo $this->Js->writeBuffer(); ?>

<script>
    $.ajaxSetup({beforeSend: function() {
            $("#busy-indicator").show();
        }, complete: function() {
            $("#busy-indicator").hide();
        }
    });
</script>