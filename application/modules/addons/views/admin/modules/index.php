<div class="box">
    <div class="heading">
        <h1>Modules</h1>
        <!--
        <div class="buttons">
            <a class="button" href="#"><span>Exit</span></a>
        </div>
        -->
    </div>
    <div class="content">
        <?php echo form_open(null, 'id="form"'); ?>
        <table class="list">
            <thead>
                <tr>
                    <th width="1" class="center"><input type="checkbox" onClick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></th>
                    <th class="sortable">Module Name</th>
                    <th>Description</th>
                    <th>Version</th>
                    <th>Enabled</th>
                    <th class="right">Action</th>
                </tr>
            </thead>
            <tbody>
            <?php if ($modules_exists): ?>
                <?php foreach($modules as $module):?>
                <tr>
                    <td class="center"><input type="checkbox" value="<?php echo $module->id ?>" name="selected[]" /></td>
                    <td><?php echo $module->module_name; ?></td>
                    <td><?php echo $module->module_description; ?></td>
                    <td><?php echo $module->module_version; ?></td>
                    <td><?php echo ($module->is_enabled) ? '<span style="color:#4D9A26;">Yes</span>' : '<span style="color:#F00;">No</span>'; ?></td>
                    <td class="right">
                        <?php if($module->is_enabled): ?>
                        [ <a href="<?php echo site_url(ADMIN_PATH . '/addons/module-install/' . $module->module_slug) ?>">Install</a> ]
                        <?php else: ?>
                        [ <a href="<?php echo site_url(ADMIN_PATH . '/addons/module-uninstall/' . $module->module_slug) ?>">Uninstall</a> ]
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td class="center" colspan="6">No modules available for installation.</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
        <?php echo form_close(); ?>
    </div>
</div>