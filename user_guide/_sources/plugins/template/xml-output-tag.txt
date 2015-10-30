
XML Output Tag
============== 

This tag allows you to output XML in your theme layouts or content types.

.. code-block:: php 

    {{ template:xml_output }}

Putting this tag at the top of a theme layout will set the page's content type as XML and will output the XML declaration tags:

.. code-block:: php 

    <?xml version="1.0"?>

With this tag you can quickly build dynamic RSS feeds.

Example:
********

.. code-block:: php 

    {{ template:xml_output }}
    <rss version="2.0">

    <channel>
        <title>My Site's News</title>
        <link>http://www.somedomain.com</link>
        <description>News articles from around the world</description>
        {{ content:entries content_type="news" limit="200" order_by="created_date|id" sort="desc|desc" }}
        <item>
            <title><![CDATA[{{ title }}]]></title>
            <link>{{ path }}</link>
            <description><![CDATA[{{ content }}]]></description>
            <pubDate>{{ created_date format="D, d M Y" }}</pubDate>
        </item>
        {{ /content:entries }}
    </channel>

    </rss>