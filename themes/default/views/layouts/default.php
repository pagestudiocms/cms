{{ theme:partial name="header" }}

    <!-- Main Content -->
    <div id="content_wrapper">
        {{ content }}
        <div class="clear"></div>
        {{ content:entries content_type="blog_pages" }}
            <h4>{{ title }}</h4>
        {{ /content:entries }}
    </div>

{{ theme:partial name="footer" }}
