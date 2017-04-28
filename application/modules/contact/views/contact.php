<form<?php echo (($anchor) ? ' action="' . current_url() . $anchor . '"' : '')  . ' method="post"' . (($id) ? ' id="' . $id . '"' : '') . (($class) ? ' class="' . $class . '"' : ''); ?>>
    <?php if ($content): ?>
        <?php echo $content; ?>
    <?php else: ?>

            <label for="name">Name:</label>
            <input type="text" name="name" id="name" placeholder="" />

            <label for="email">Email:</label>
            <input type="text" name="email" id="email" placeholder="" />

            <label for="phone">Phone:</label>
            <input type="text" name="phone" id="phone" placeholder="" />

            <label for="message">Message:</label>
            <textarea name="message" id="message" cols="3" rows="11"></textarea>

        <?php if ($captcha): ?>
            <div>
                <span>
                    <label for="captcha">Please input the characters below:</label><br />
                    <img class="captcha_image" src="<?php echo site_url('contact/captcha'); ?>" /><br />
                    <input id="captcha" class="captcha_input" type="text" name="captcha_input" />
                </span>
            </div>
        <?php endif; ?>

        <div>
            <label for="submit"></label>
            <button name="submit" type="submit" id="submit" class="button lg">Submit</button>
        </div>
    <?php endif; ?>

    <div style="display: none;">
        <input type="text" name="spam_check" value="" /> 
        <?php if ($id): ?>
            <input type="hidden" name="form_id" value="<?php echo $id; ?>" />
        <?php endif; ?>
    </div>
	
	<div class="js-contact-form-spinner" style="display:none;">
		<i class="fa fa-spinner fa-pulse fa-3x fa-fw fa-spin"></i>
		<span class="sr-only">Loading...</span>
	</div><!-- end .form-spinner -->
</form>

<?php if($ajax_submit): js_start(); ?>
<script type="text/javascript" src="<?php echo site_url() . 'application/modules/contact/assets/js/jquery.validate.min.js'; ?>"></script>
<script type="text/javascript">
    $( document ).ready( function() {
        var $validator = $(".js-contact-form").validate({
            submitHandler: function(form){
                $('.js-contact-form-spinner').show();
                $.ajax({
                    type: 'POST',
                    url: "<?php echo base_url() . 'contact/ajax/'; ?>",
                    data: $(form).serialize(),
                    dataType: 'JSON',
                    success: function(response){
                        $('.js-contact-form-spinner').hide();
                        if(response.length !== '') {
                            console.log('The email sending process completed in ' + response.time);
                            if(response.status == 'success') {
                                $('.js-result').html('<p class="success">Thank you! Your message was successfully sent.</p>');
                                $('.js-contact-form').find("input[type=text], input[type=email], textarea").val("");
                            } else {
                                $('.js-result').html('<p class="error">Something went wrong. We were unable to send your email.</p>');
                                console.log(response.status, response.message);
                            }
                        }
                    }
                });
            },
            errorClass: 'required help-inline',
            validClass: 'success',
            errorPlacement: function(error, element) { }, // Hide error label
            highlight: function(element) {
                $(element).closest('.form-group').addClass('has-error');
            },
            unhighlight: function(element) {
                $(element).closest('.form-group').removeClass('has-error');
            },
            // all fields are required
            rules: {
                email: {
                    required: true,
                    email: true
                }
            }
        });
    });
</script>
<?php js_end(); endif;?>