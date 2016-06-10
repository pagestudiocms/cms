<?php 
$field_options = [];
foreach(explode("\r\n", $options) as $key => $option) {
    $field_options[$option] = $option;
}
?>
<td style="width: auto;" class="matrix matrix-text">
    <?php echo form_dropdown($field_name, $field_options, set_value($field_name, $content)); ?>
</td>