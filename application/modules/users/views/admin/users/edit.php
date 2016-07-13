<div class="box">
    <div class="heading">
        <h1><img alt="" src="<?php echo theme_url('assets/images/user.png'); ?>"> <?php echo ($edit_mode) ? 'User Edit' : 'User Add'; ?></h1>

        <div class="buttons">
            <a class="button" href="#" id="save" onClick="$('#user_edit_form').submit()"><span>Save</span></a>
        </div>
    </div>
    <div class="content">
        <?php echo form_open_multipart(null, 'id="user_edit_form"'); ?>

        <?php if ($edit_mode): ?>
            <div class="tabs">
                <ul class="htabs">
                    <li><a href="#edit-user-tab">Edit User</a></li>
                    <li><a href="#password-tab">Password</a></li>
                </ul>
        <?php endif; ?>

            <div id="edit-user-tab">
                <div class="form">
                    <div class="field_spacing">
                        <?php echo form_label('Profile Image:', 'photo'); ?>
                        <?php echo form_upload(['id' => 'photo', 'class' => 'hidden_file', 'name' => 'photo', 'value' => set_value('photo', (isset($User->photo)) ? $User->photo : '')],'', 'style="display: none;"'); ?>

                        <div href="javascript:void(0);" style="display: block; margin-top: 10px;margin-bottom: 10px;">
                            <img id="photo_preview" src="<?php echo (isset($User->photo)) ? site_url() . $User->photo : ADMIN_NO_IMAGE;?>" alt="Profile Avatar" width="100" height="100" />
                        </div>

                        <a class="remove_file" href="javascript:void(0);">Remove File</a> |
                        <a class="choose_file" href="javascript:void(0);">Add File</a>
                        
                        <input type="hidden" name="original_photo" id="photo_hidden" value="<?php echo set_value('original_photo', (isset($User->photo)) ? $User->photo : ''); ?>" />
                        <input type="hidden" name="photo_upload_action" id="photo_upload_action" />
                    </div>                    
                    
                    <div class="field_spacing">
                        <?php echo form_label('<span class="required">*</span> Group:', 'groups'); ?>
                        <?php echo form_dropdown('group_id', option_array_value($Groups, 'id', 'name', array(''=>'')), set_value('group_id', (isset($User->group_id)) ? $User->group_id : $this->settings->users_module->default_group), 'id="groups" class="long"'); ?>
                    </div>

                    <div class="field_spacing">
                        <?php echo form_label('<span class="required">*</span> Email:', 'email'); ?>
                        <?php echo form_input(array('id' => 'email', 'name' => 'email', 'value' => set_value('email', (isset($User->email)) ? $User->email : ''))); ?>
                    </div>

                    <?php if ( ! $edit_mode): ?>
                        <div class="field_spacing">
                            <?php echo form_label('<span class="required">*</span> Password:', 'password')?>
                            <?php echo form_password(array('id' => 'password', 'name' => 'password')); ?>
                        </div>

                        <div class="field_spacing">
                            <?php echo form_label('<span class="required">*</span> Confirm Password:', 'confirm_password'); ?>
                            <?php echo form_password(array('id' => 'confirm_password', 'name' => 'confirm_password')); ?>
                        </div>
                    <?php endif; ?>

                    <div class="field_spacing">
                        <?php echo form_label('<span class="required">*</span> First Name:', 'first_name'); ?>
                        <?php echo form_input(array('id' => 'first_name', 'name' => 'first_name', 'value' => set_value('first_name', (isset($User->first_name)) ? $User->first_name : ''))); ?>
                    </div>

                    <div class="field_spacing">
                        <?php echo form_label('<span class="required">*</span> Last Name:', 'last_name'); ?>
                        <?php echo form_input(array('id' => 'last_name', 'name' => 'last_name', 'value' => set_value('last_name', (isset($User->last_name)) ? $User->last_name : ''))); ?>
                    </div>

                    <div class="field_spacing">
                        <?php echo form_label('Phone:', 'phone'); ?>
                        <?php echo form_input(array('id' => 'phone', 'name' => 'phone', 'value' => set_value('phone', (isset($User->phone)) ? $User->phone : ''))); ?>
                    </div>

                    <div class="field_spacing">
                        <?php echo form_label('Address:', 'address'); ?>
                        <?php echo form_input(array('id' => 'address', 'name' => 'address', 'value' => set_value('address', (isset($User->address)) ? $User->address : ''))); ?>
                    </div>

                    <div class="field_spacing">
                        <?php echo form_label('Address 2:', 'address2'); ?>
                        <?php echo form_input(array('id' => 'address2', 'name' => 'address2', 'value' => set_value('address2', (isset($User->address2)) ? $User->address2 : ''))); ?>
                    </div>

                    <div class="field_spacing">
                        <?php echo form_label('City:', 'city'); ?>
                        <?php echo form_input(array('id' => 'city', 'name' => 'city', 'value' => set_value('city', (isset($User->city)) ? $User->city : ''))); ?>
                    </div>

                    <div class="field_spacing">
                        <?php echo form_label('State:', 'state'); ?>
                        <?php echo form_dropdown('state', $states, set_value('state', (isset($User->state)) ? $User->state : ''), 'id="state" class="long"'); ?>
                    </div>

                    <div class="field_spacing">
                        <?php echo form_label('Zip:', 'zip'); ?>
                        <?php echo form_input(array('id' => 'zip', 'name' => 'zip', 'value' => set_value('zip', (isset($User->zip)) ? $User->zip : ''))); ?>
                    </div>

                    <div>
                        <?php echo form_label('Status: <span class="help">Allow user to log in.</span>', 'enabled'); ?>
                        <span>
                            <?php echo form_radio(array('id' => 'status_enabled', 'name' => 'enabled', 'value' => '1', 'checked' => set_radio('enabled', '1', (isset($User->enabled) && $User->enabled) ? TRUE : TRUE))); ?>
                            <label for="status_enabled">Enabled</label>
                            <?php echo form_radio(array('id' => 'status_disabled', 'name' => 'enabled', 'value' => '0', 'checked' => set_radio('enabled', '0', (isset($User->enabled) && ! $User->enabled) ? TRUE : FALSE))); ?> 
                            <label for="status_disabled">Disabled</label>
                        </span>
                    </div>
                </div>
            </div>

            <?php if ($edit_mode): ?>
                    <div id="password-tab">
                        <div class="form">
                            <div class="field_spacing">
                                <?php echo form_label('Password:', 'password')?>
                                <?php echo form_password(array('id' => 'password', 'name' => 'password')); ?>
                            </div>

                            <div class="field_spacing">
                                <?php echo form_label('Confirm Password:', 'confirm_password'); ?>
                                <?php echo form_password(array('id' => 'confirm_password', 'name' => 'confirm_password')); ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <div class="clear"></div>

            <?php echo form_close(); ?>
        </div>
    </div>
</div>

<?php js_start(); ?>
<script type="text/javascript">
    $(document).ready(function() {
        $( ".tabs" ).tabs();
        
        // Generate image thumbnail preview 
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();            
                reader.onload = function (e) {
                    $('#photo_preview').attr('src', e.target.result);
                }
                
                reader.readAsDataURL(input.files[0]);
            }
        }
        
        $("#photo").change(function(){
            readURL(this);
        });
        
        $('.remove_file').on('click', function(e){
            $('input#photo').val('');
            $('input#photo_upload_action').val('delete');
            $('#photo_preview').attr('src', '<?php echo site_url() . ADMIN_NO_IMAGE; ?>');
        });
        
        $('.choose_file').on('click', function(e){
            $('input#photo').click();
            $('input#photo_upload_action').val('upload');
        });
    });
</script>
<?php js_end(); ?>