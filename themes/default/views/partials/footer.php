
    <footer>
		<div class="container">
			<div class="row">
				<div class="col-md-6">
                    {{ navigations:nav nav_id="2" class="footer-menu" }}
				</div>
				<div class="col-md-6 text-right">
					<p>&copy; {{ helper:date format="Y" }}. Designed by <a href="http://cosmointeractive.co" target="_blank">Cosmo Interactive</a> based on a theme by <a href="http://bootstraptaste.com/" target="_blank">BootstrapTaste</a>.</p>
                    <!-- 
                        All links in the footer should remain intact. 
                        Licenseing information is available at: http://bootstraptaste.com/license/
                        You can buy this theme without footer links online at: http://bootstraptaste.com/buy/?theme=Bocor
                    -->
				</div>
			</div>	
		</div>
	</footer>
<footer>

<!-- JavaScript
====================================================== -->        
    
    <!-- Core JavaScript Files -->
    <script src="{{ theme_url }}/assets/js/jquery.min.js"></script>	 
    <script src="{{ theme_url }}/assets/js/vendor/bootstrap/bootstrap.min.js"></script>
	<script src="{{ theme_url }}/assets/js/jquery.sticky.js"></script>
    <script src="{{ theme_url }}/assets/js/jquery.easing.min.js"></script>	
	<script src="{{ theme_url }}/assets/js/jquery.scrollTo.js"></script>
	<script src="{{ theme_url }}/assets/js/jquery.appear.js"></script>
	<script src="{{ theme_url }}/assets/js/stellar.js"></script>
	<script src="{{ theme_url }}/assets/js/nivo-lightbox.min.js"></script>
	<script src="{{ theme_url }}/assets/js/jqBootstrapValidation.js"></script>

    <script src="{{ theme_url }}/assets/js/custom.js"></script>
	<script src="{{ theme_url }}/assets/js/css3-animate-it.js"></script>
    
    {{ template:footer }}

</body>
</html>
