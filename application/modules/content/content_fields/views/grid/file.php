<td style="width: auto;" class="matrix matrix-text">
    <div class="filename" href="javascript:void(0);" style="display: block; margin-bottom: 8px; font-weight: bold;">
        <?php echo set_value($field_id, ($content == '') ? 'No File Added' : $content); ?>
    </div>

    <a class="remove_file" href="javascript:void(0);">Remove File</a> |
    <a class="choose_file" href="javascript:void(0);">Add File</a>
    <input class="hidden_file" type="hidden" value="<?php echo set_value($field_id, $content); ?>" name="<?php echo $field_name; ?>" />
</td>
