<?php
    $products = null;
    foreach ($productDetails as $product):
        $products .= " " . $product['Product']['name'] . ",";
    endforeach;
?>
<?php if ($stock == 0) { ?>
    <div class="alert alert-danger">
<?php } else { ?>
    <div class="alert alert-info">
<?php } ?>
    <h6><?php echo $materialDetails['Material']['name'] ?> is used in following product/s :  <?php echo $products ?></h6>
    <h4>Quantity In Hand : <?php echo $stock ?> </h4>
</div>

<?php echo $this->Form->hidden('quantity_in_hand', array('value' => $stock)); ?>