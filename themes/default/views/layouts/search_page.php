{{ theme:partial name="header" }}

    <!-- Header
	============================================== -->
    <section class="alternate no-border-top " style="margin-top:-55px;padding-top: 60px;">
		<div class="container">
            <div class="sixteen columns">
				<div class="jumbotron">
                    {{ hero_text }}
                    <div class="row">
                        <div class="columns twelve alpha offset-by-four">
                            {{ search:form_simple placeholder="Type to search..." redirect="search" }}
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- container end -->
	</section>
    
	<section class="no-border-top normal">
		<div class="container">
			<div class="columns sixteen main-content shadow">

                <div class="row">
                    <div class="columns thirteen offset-by-three alpha">
                        {{ content }}
                    </div>
                </div>
                
			</div><!-- two-thirds .end -->	
					
		</div><!-- container .end -->
	</section><!--/ .About Us -->	
    
{{ theme:partial name="footer" }}