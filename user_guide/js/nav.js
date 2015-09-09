function create_menu(basepath)
{
	var base = (basepath == 'null') ? '' : basepath;

	document.write(
		'<table cellpadding="0" cellspaceing="0" border="0" style="width:98%"><tr>' +
		'<td class="td" valign="top">' +

		'<h3>Author</h3>' +
		'<ul>' +
		'	<li><a href="#/">Cosmo Mathieu</a></li>' +
		'	<li><a href="http://cosmointeractive.co" target="_blank">Website</a></li>' +
		'	<li><a href="http://bitbucket.org/philsturgeon/codeigniter-template">BitBucket</a></li>' +
		'</ul>' +
        

		'<h3>Basic Info</h3>' +
		'<ul>' +
        '	<li><a href="'+base+'.html">Getting Started</a></li>' +
        '	<li><a href="'+base+'changelog.html">Themes</a></li>' +
        '	<li><a href="'+base+'changelog.html">Multilingual Setup</a></li>' +
		'	<li><a href="'+base+'index.html#license">License</a></li>' +
        '	<li><a href="'+base+'changelog.html">Change Log</a></li>' +
        '	<li><a href="'+base+'road-map.html">Road Map</a></li>' +
		'	<li><a href="">GitHub</a></li>' +
		'	<li><a href="'+base+'style-guide.html">Style Guide</a></li>' +
		'</ul>' +

		'</td><td class="td_sep" valign="top">' +
                
		'<h3>Installation</h3>' +
		'<ul>' +
        '	<li><a href="'+base+'.html">Server Requirements</a></li>' +
        '	<li><a href="'+base+'.html">Installation Instructions</a></li>' +
        '	<li><a href="'+base+'.html">Upgrade Instructions</a></li>' +
        '	<li><a href="'+base+'.html">Troubleshooting / FAQ</a></li>' +
		'</ul>' +

		'<h3>General Topics</h3>' +
		'<ul>' +
			'<li><a href="'+base+'layouts.html">Layouts</a></li>' +
			'<li><a href="'+base+'partials.html">Partials</a></li>' +
		'</ul>' +

		'</td><td class="td_sep" valign="top">' +

		'<h3>Tag Plugins</h3>' +
		'<ul>' +
        '	<li><a href="'+base+'calendar-plugin.html">Calendar Plugin</a></li>' +
        '	<li><a href="'+base+'.html">Contact Plugin</a></li>' +
        '	<li><a href="'+base+'.html">Content Plugin</a></li>' +
        '	<li><a href="'+base+'.html">Galleries Plugin</a></li>' +
        '	<li><a href="'+base+'helper-plugin/index.html">Helper Plugin</a></li>' +
        '	<li><a href="'+base+'.html">Navigations Plugin</a></li>' +
        '	<li><a href="'+base+'.html">Secure Plugin</a></li>' +
        '	<li><a href="'+base+'.html">Settings Plugin</a></li>' +
        '	<li><a href="'+base+'.html">Template Plugin</a></li>' +
        '	<li><a href="'+base+'.html">Theme Plugin</a></li>' +
        '	<li><a href="'+base+'.html">Users Plugin</a></li>' +
		'</ul>' +

		'</td><td class="td_sep" valign="top">' +
        
        '<h3>Core Modules</h3>' +
		'<ul>' +
        '	<li><a href="'+base+'.html">Calendar Module</a></li>' +
        '	<li><a href="'+base+'.html">Contact Module</a></li>' +
        '	<li><a href="'+base+'.html">Content Module</a></li>' +
        '	<li><a href="'+base+'.html">Dashboard Module</a></li>' +
        '	<li><a href="'+base+'.html">Galleries Module</a></li>' +
        '	<li><a href="'+base+'.html">Navigations Module</a></li>' +
        '	<li><a href="'+base+'.html">Settings Module</a></li>' +
        '	<li><a href="'+base+'.html">Users Module</a></li>' +
		'</ul>' +

		'</td></tr></table>');
}