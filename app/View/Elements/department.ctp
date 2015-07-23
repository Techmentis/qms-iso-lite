<option value="-1">Select</option>
<?php foreach ($deptEmployees as $key => $value): ?>
    <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
<?php endforeach; ?>