<div id="login_page">
    <div class="back-to-site">
        <a href="<?php echo site_url(); ?>"><span>&laquo;</span> Back to my website</a>
    </div>

    <div id="login_form">
        <div class="heading">
            Welcome! Please login.
        </div>
        <div class="content">
            <?php echo form_open(); ?>

                <?php echo validation_errors(); ?>
                <?php echo $this->session->flashdata('message'); ?>

                <div class="fields">
                    <div>
                        <?php echo form_label('Email', 'email'); ?>
                        <?php echo form_input(array('id' => 'email', 'name' => 'email', 'value' => set_value('email'))); ?>
                    </div>

                    <div>
                        <?php echo form_label('Password', 'password'); ?>
                        <?php echo form_password(array('id' => 'password', 'name' => 'password')); ?>
                    </div>

                    <div class="">
                        <div class="fleft">
                            <label><input name="remember_me" class="remember_me" type="checkbox" value="1" /> Remember me</label>
                        </div>
                        <div class="fright">
                            <button class="button" type="submit">LOG IN</button>
                        </div>
                        <div class="clear"></div>
                    </div>
                    
                    <?php echo anchor(ADMIN_PATH . '/users/forgot-password', 'Forgot Password?') ?>
                </div>

            <?php echo form_close(); ?>
        </div>
    </div>
</div>
