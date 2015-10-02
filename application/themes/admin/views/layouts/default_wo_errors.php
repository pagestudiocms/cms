<?php echo theme_partial('header'); ?>

<div id="content">
    <?php if ($this->secure->is_auth()): ?>
    <div class="breadcrumb"></div>
    <?php endif; ?>

    <?php echo  $content; ?>
</div>

<?php echo theme_partial('footer'); ?>
