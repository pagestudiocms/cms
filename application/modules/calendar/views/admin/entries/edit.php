<!--[if lte IE 7]> <style type="text/css"> #entry_fields > div > label .arrow { display: inline; } </style> <![endif]-->

<div class="box">
    <div class="heading">
        <h1><img alt="" src="<?php echo theme_url('assets/images/review.png'); ?>"> Event Edit <?php echo ($edit_mode) ? '- ' . strip_tags($Event->title) . ' (#' . $Event->id . ')' : ''; ?></h1>

        <div class="buttons">
            <a class="button" href="javascript:void(0);" id="save"><span>Save</span></a>
            <a class="button" href="javascript:void(0);" id="save_exit"><span>Save &amp; Exit</span></a>
            <a class="button" href="<?php echo site_url(ADMIN_PATH . '/content/entries'); ?>"><span>Cancel</span></a>
        </div>
    </div>
    <div class="content">

        <?php if ($edit_mode && $Event->url != ''): ?>
            <a style="float: right; z-index: 1; position: relative;" target="_blank" href="<?php echo site_url("$Event->url"); ?>"><img src="<?php echo theme_url('assets/images/preview-icon-medium.png') ?>" /></a>
        <?php endif; ?>

        <div class="fright" style="margin-top: 4px; margin-right: 10px;">
            <a id="collapse_all" class="no_underline" href="javascript:void(0);">Collapse All</a> &nbsp;|&nbsp; <a id="expand_all" class="no_underline" href="javascript:void(0);">Expand All</a>
        </div>

        <?php echo form_open(null, 'id="entry_edit"'); ?>
        <div class="tabs">
            <ul class="htabs">
                <li><a href="#content-tab">Content</a></li>
                <li><a href="#categories-tab">Categories</a></li>
                <li><a href="#settings-tab">Settings</a></li>
            </ul>
            <!-- Content Tab -->
            <div id="content-tab">
                <div id="entry_fields">
                    <div>
                        <?php echo form_label('<div class="arrow arrow_expand"></div><span class="required">*</span> Title', 'title'); ?>
                        <div>
                            <?php echo form_input(array('name'=>'title', 'id'=>'title', 'value'=>set_value('title', !empty($Event->title) ? $Event->title : ''))); ?>
                        </div>
                    </div>
                    <div>
                        <?php echo form_label('<div class="arrow arrow_expand"></div><span class="required">*</span> Start Date:', 'start'); ?>
                        <div>
                            <?php echo 
                                form_input( array(
                                    'name'=>'start', 
                                    'class'=>'datetime', 
                                    'id'=>'start', 
                                    'value'=>set_value('start', !empty($Event->start) ? date('m/d/Y h:i:s a', strtotime($Event->start)) : date('m/d/Y h:i:s a'))
                                )); 
                            ?>
                        </div>
                    </div>
                    <div>
                        <?php echo form_label('<div class="arrow arrow_expand"></div><span class="required">*</span> End Date:', 'end'); ?>
                        <div>
                            <?php echo 
                                form_input( array(
                                    'name'=>'end', 
                                    'class'=>'datetime', 
                                    'id'=>'end', 
                                    'value'=>set_value('end', !empty($Event->end) ? date('m/d/Y h:i:s a', strtotime($Event->end)) : date('m/d/Y h:i:s a'))
                                )); 
                            ?>
                        </div>
                    </div>
                    <div>
                        <?php echo form_label('<div class="arrow arrow_expand"></div><span class="required">*</span> Description', 'description'); ?>
                        <div>
                            <?php echo 
                                form_textarea( array(
                                    'name' =>'description', 
                                    'id' =>'description_textarea', 
                                    'class' => 'textarea_content ckeditor_textarea',
                                    'value' =>set_value('description', ! empty($Event->description) ? $Event->description : '')
                                )); 
                            ?>
                        </div>
                    </div>
                    <div>
                        <?php echo form_label('<div class="arrow arrow_expand"></div> Featured Image', 'featured'); ?>
                        <div>
                            <div style="width: 150px; text-align: center; float: left;">
                                <a class="choose_image" href="javascript:void(0);" style="display: block; margin-bottom: 5px;">
                                    <img class="image_thumb" src="<?php echo ! empty($Event->featured_image) ? $Event->featured_image : 
                                    theme_url() . '/assets/images/no_image.jpg'; ?>" />
                                </a>

                                <a class="remove_image" href="javascript:void(0);">Remove Image</a><br />
                                <a class="choose_image" href="javascript:void(0);">Add Image</a>
                                <input class="hidden_file" type="hidden" value="" name="featured_image" />
                            </div>
                            <!--
                            <div style="float: left; margin-left: 15px; width: 220px;">
                                <label for="alt"><strong>Alternative Text:</strong></label>
                                <input type="text" name="field_id_24[alt]" value="" id="alt" />
                            </div>
                            -->

                            <div class="clear"></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Categories Tab -->
            <div id="categories-tab">
                <div class="form format_list">
                </div>
            </div>
            <!-- Page Tab -->
            <div id="settings-tab">
                <div class="form">
                    <?php var_dump($Event); ?>
                </div>
                <!--
                <div class="form">
                    <div>
                        <?php echo form_label('URL:', 'url'); ?>
                        <span style="line-height: 24px; "> <?php echo trim(site_url(), '/'); ?>/ </span>
                        <?php echo form_input(array('name'=>'url', 'id'=>'url', 'value'=>set_value('url', !empty($Event->url) ? $Event->url : ''))); ?>
                    </div>
                    <div>
                        <?php echo form_label('Description:<br /><span class="help">150 Characters Max</span>', 'meta_description'); ?>
                        <?php echo form_textarea(array('name'=>'meta_description', 'id'=>'description_textarea', 'value'=>set_value('meta_description', !empty($Event->meta_description) ? $Event->meta_description : ''))); ?>
                        &nbsp;<span id="meta_description_count" class="help" style="display: inline;">(<?php echo strlen(set_value('meta_description', !empty($Event->meta_description) ? $Event->meta_description : '')); ?> Chars)</span>
                    </div>
                </div>
                -->
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>

<?php js_start(); ?>
<script type="text/javascript" src="<?php echo theme_url(); ?>/assets/js/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
    $(document).ready( function() {
        var ckeditor_config = { 
            toolbar : [
                { name: 'styles', items : [ 'Styles','Format','Font','FontSize' ] },
                { name: 'colors', items : [ 'TextColor','BGColor' ] },
                { name: 'paragraph', items : [ 'NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote','CreateDiv','- ','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock' ] },
                { name: 'tools', items : [ 'ShowBlocks' ] },
                { name: 'tools', items : [ 'Maximize' ] },
                                '/',
                { name: 'basicstyles', items : [ 'Bold','Italic','Underline','Subscript','Superscript','Strike','-','RemoveFormat' ] },
                { name: 'clipboard', items : [ 'Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo' ] },
                { name: 'editing', items : [ 'Find','Replace','-','Scayt' ] },
                { name: 'insert', items : [ 'Image','Flash','MediaEmbed','Table','HorizontalRule','SpecialChar','Iframe' ] },
                { name: 'links', items : [ 'Link','Unlink','Anchor' ] },
                { name: 'document', items : [ 'Source' ] }
            ],
            entities : true,
            extraPlugins : 'stylesheetparser',contentsCss : ['<?php echo theme_url(); ?>/assets/js/ckeditor/contents.css', 'http://local.cmscanvas.app/sitemin/content/entries/css/8?' + new Date().getTime()  ],stylesSet : [],
            height : '400px',
            filebrowserBrowseUrl : '<?php echo theme_url(); ?>/assets/js/kcfinder/browse.php?type=files',
            filebrowserImageBrowseUrl : '<?php echo theme_url(); ?>/assets/js/kcfinder/browse.php?type=images',
            filebrowserFlashBrowseUrl : '<?php echo theme_url(); ?>/assets/js/kcfinder/browse.php?type=flash',
            filebrowserUploadUrl : '<?php echo theme_url(); ?>/assets/js/kcfinder/upload.php?type=files',
            filebrowserImageUploadUrl : '<?php echo theme_url(); ?>/assets/js/kcfinder/upload.php?type=images',
            filebrowserFlashUploadUrl : '<?php echo theme_url(); ?>/assets/js/kcfinder/upload.php?type=flash'
        };

        $('textarea.ckeditor_textarea').each(function(index) {
            ckeditor_config.height = $(this).height();
            CKEDITOR.replace($(this).attr('name'), ckeditor_config); 
        });

    });
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $( ".tabs" ).tabs();

        $( ".datetime" ).datetimepicker({
            showSecond: true,
            timeFormat: 'hh:mm:ss tt',
            ampm: true
        });

        // Wrap datepicker popup with a class smoothness for styleing
        $('body').find('#ui-datepicker-div').wrap('<div class="smoothness"></div>');

        $("#save, #save_exit").click( function() {

            response = true;

            if ($('#status').val() != '<?php echo empty($Event->status) ? 'published' : $Event->status; ?>' && $('#status').val() != 'published')
            {
                // response = confirm('When changing the page type from published ensure you do not have any published navigations or links to this page.\n\n Are you sure you want to continue?');
            }

            if (response)
            {
                if ($(this).attr('id') == 'save_exit')
                {
                    $('<input>').attr({
                        type: 'hidden',
                        name: 'save_exit',
                        value: '1'
                    }).appendTo('#entry_edit');

                    $('#entry_edit').submit();
                }
                else
                {
                    $('#entry_edit').submit();
                }
            }
        });

        // Count description characters
        $('#description_textarea').keyup( function() {
            $('#meta_description_count').html('(' + $(this).val().length + ' Chars)');
        });

        // Expand / Collapse entry fields
        $('#entry_fields > div > label').click( function() {
            if($(this).next('div').is(":visible"))
            {
                $(this).next('div').slideUp();
                $('div', this).removeClass('arrow_expand').addClass('arrow_collapse');
            }
            else
            {
                $(this).next('div').slideDown();
                $('div', this).removeClass('arrow_collapse').addClass('arrow_expand');
            }
        });

        <?php if ( ! $edit_mode): ?>
            // Auto Generate Url Title
            $('#title').keyup( function(e) {
                $('#url_title').val($(this).val().toLowerCase().replace(/\s+/g, '-').replace(/[^a-z0-9\-_]/g, ''))
            });
        <?php endif; ?>

        heading_pos = $('.heading').offset().top;
        position_top = false;

        $(window).scroll(function () {
            if (heading_pos - $(window).scrollTop() <= 0) {
                if (!position_top) {
                    $('.heading').addClass('position_top');
                    $('.content').addClass('position_top');
                    position_top = true;
                }
            } else {
                if (position_top) {
                    $('.heading').removeClass('position_top');
                    $('.content').removeClass('position_top');
                    position_top = false;
                }
            }
        });

        $('#collapse_all').click( function() {
            $('.arrow_expand').trigger('click');
        });

        $('#expand_all').click( function() {
            $('.arrow_collapse').trigger('click');
        });
    });
</script>
<?php js_end(); ?>
