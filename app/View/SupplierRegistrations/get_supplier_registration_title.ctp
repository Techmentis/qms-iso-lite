<?php
    if (count($supplierRegistrations)) {
        ($type == 'title')?$type = 'name':$type;
        echo "Supplier Registration $type already exists, please enter another $type";
    }
?>