    <?php if ($this->secure->is_auth()): ?>

                <footer class="app-footer">
                    <p class="copy">&copy; <?php echo date('Y'); ?>&nbsp; <a href="http://pagestudiocms.com/" target="_blank">PageStudioCMS</a> v<?php echo CC_VERSION ?></p>
                </footer><!-- end .app-footer -->
            
            </div><!-- end the container -->
    
    	</div> <!-- .content-wrapper -->
	</main> <!-- .cd-main-content -->

    <?php endif; ?>
    <!-- -->
    <div id="ajax_status">
        <table id="ajax_status_frame">
            <tr>
                <td>
                    <div id="ajax_status_animation"><img src="<?php echo theme_url('assets/images/ajax-loader.gif'); ?>" /></div>
                    <div id="ajax_status_text"></div>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
