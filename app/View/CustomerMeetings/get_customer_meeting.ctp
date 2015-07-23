<?php
    if (!empty($customermeetings)) {
        echo $form->input('customer_meeting_id', array(
            'label' => 'Customer_Meeting: <span>*</span>',
            'title' => 'Customer_Meeting',
            'type' => 'select',
            'options' => $pages,
            'div' => false,
            'name' => 'data[ProposalFollowup][customer_meeting_id]'
        ));
    }
?>