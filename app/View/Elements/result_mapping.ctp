<table class="table table-recursive">
    <tr>
        <th><?php echo __('Customer'); ?></th>
        <th><?php echo "# " . __('Meeting'); ?></th>
        <th><?php echo "# " . __('Proposals'); ?></th>
        <th><?php echo "# " . __('Proposal Followups'); ?></th>
        <th><?php echo "# " . __('Invoices / Purchase Orders raised'); ?></th>
    </tr>
    <?php foreach ($resultMappings as $mapping): ?>
    <tr>
        <td><?php echo $mapping['CustomerDetails']['name']; ?></td>
        <td><?php echo $mapping['Number_of_meetings']; ?></td>
        <td><?php echo $mapping['Number_of_proposals']; ?></td>
        <td><?php echo $mapping['Number_of_proposal_followups']; ?></td>
        <td><?php echo $mapping['Number_of_purchase_orders']; ?></td>
    </tr>
    <?php endforeach; ?>
</table>
