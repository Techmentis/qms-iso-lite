<?php
    if ($type == 'custCode') {
        if (count($customerCode)) {
            echo "Customer Code already exists, please enter another Customer Code";
        }
    } else {
        if (count($emailId)) {
            echo "Email ID already exists, please enter another Email ID";
        }
    }
?>