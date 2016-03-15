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
</form>

<?php if($ajax_submit): js_start(); ?>
<script type="text/javascript">
    $( document ).ready( function() {
        $(".js-contact-form").find("input,textarea,select").jqBootstrapValidation({
            preventSubmit: true,
            submitError: function($form, event, errors) {
                // console.log(errors);
            },
            submitSuccess: function($form, event) {
                event.preventDefault();
                $.ajax({
                    url: "<?php echo base_url() . ADMIN_PATH . '/contact/ajax/'; ?>",
                    async: false,
                    cache: false,
                    type: 'POST',
                    data: $('.js-contact-form').serialize(),
                    success: function(data){
                        var message = data.replace('Invalid address: ','');
                        if(message === '1') {
                            $('.js-result').html('<p class="success">Thank you! Your message was successfully sent.</p>');
                            $('.js-contact-form').find("input[type=text], input[type=email], textarea").val("");
                        } else {
                            $('.js-result').html('<p class="error">Something went wrong. We were unable to send your email.</p>');
                        }
                        // console.log(data);
                    }
                });
            },
        });
    });
</script>
<?php js_end(); endif;?>