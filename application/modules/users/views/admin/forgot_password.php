<div id="login_page">
    <div class="back-to-site">
        <a href="<?php echo site_url(); ?>"><span>&laquo;</span> Back to my website</a>
    </div>
    
    <div id="login_form">
        <div class="heading">
            Enter the e-mail address associated with your account. Click submit to have a password reset link e-mailed to you.
        </div>
        <div class="content">
            <?php echo form_open(null, 'id="forgotten"'); ?>

                <?php echo validation_errors(); ?>
                <?php echo $this->session->flashdata('message'); ?>

                <div class="fields">
                
                    <div>
                        <?php echo form_label('Email Address', 'email'); ?>
                        <?php echo form_input(array('id' => 'email', 'name' => 'email')); ?>
                    </div>

                    <div class="">
                        <div class="fleft">
                            
                        </div>
                        <div class="fright">
                            <button class="button" type="submit">RESET</button>
                        </div>
                        <div class="clear"></div>
                    </div>
                    
                    <?php echo anchor(ADMIN_PATH . '/users/login', 'Cancel'); ?>
                </div>

            <?php echo form_close(); ?>
        </div>
    </div>
</div>