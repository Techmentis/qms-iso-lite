<?php
    echo __('A request to reset your password was sent. To change your password click the link below.');
    echo "\n";
    echo Router::url(array('controller' => 'users', 'action' => 'reset_password', $token), true);
?>