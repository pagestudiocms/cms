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