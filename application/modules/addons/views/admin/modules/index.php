<div class="box">
    <div class="heading">
        <h1>Modules</h1>
        <div class="buttons">
            <!--
            <a class="button" href="<?php echo site_url() . ADMIN_PATH; ?>"><span>Add New</span></a>
            -->
            <a class="button" href="<?php echo site_url() . ADMIN_PATH; ?>"><span>Exit</span></a>
        </div>
    </div>
    <div class="content">
        <?php echo form_open(null, 'id="form"'); ?>
        <table class="list">
            <thead>
                <tr>
                    <th width="1" class="center"><input type="checkbox" onClick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></th>
                    <th class="sortable">Module Name</th>
                    <th width="540">Description</th>
                    <th>Version</th>
                    <th>Status</th>
                    <th class="right" width="145">Action</th>
                </tr>
            </thead>
            <tbody>
            <?php if ($modules_exists): ?>
                <?php foreach($modules as $module):?>
                <tr>
                    <td class="center"><input type="checkbox" value="<?php echo $module->slug ?>" name="selected[]" /></td>
                    <td><?php echo $module->name; ?></td>
                    <td><?php echo $module->description; ?></td>
                    <td><?php echo $module->version; ?></td>
                    <td><?php echo ($module->is_enabled) ? '<span style="color:#4D9A26;">Installed</span>' : '<span style="color:#F00;">Not installed</span>'; ?></td>
                    <td class="right">
                    <?php if($module->is_core): ?>
                        [ <span style="color:#666;">Core</span> ]
                    <?php else: ?>
                        <?php if($module->is_enabled): ?>
                        <!--
                        [ <a href="<?php echo site_url(ADMIN_PATH . '/addons/admin-modules/disable/' . $module->slug) ?>">Disable</a> ]
                        -->
                        [ <a href="<?php echo site_url(ADMIN_PATH . '/addons/admin-modules/uninstall/' . $module->slug) ?>">Remove</a> ]
                        <?php else: ?>
                        [ <a href="<?php echo site_url(ADMIN_PATH . '/addons/admin-modules/install/' . $module->slug) ?>">Install</a> ]
                        <?php endif; ?>
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