<h1 id="header">Configuration Settings</h1>

<div class="content">

<p>The UCLA Mobile Web Framework has a series of configuration files for enabling and customizing the behavior of your instance. All of these files can be found in <strong>/config</strong>. The following sections outline the configuration options available in each file respectively.</p>

<h2>General System Configuration (global.php)</h2>

<p>The file <strong>global.php</strong> is the only configuration file that <strong>must</strong> be populated for a new installation of the framework to function. The first set of entities specify site specific paths:</p>

<ul>
<li>
<code>site_url</code> (<strong>required</strong>) - The url of the MWF installation. This should be the web-accessible address for the <strong>root</strong> directory, including protocol(http/https).</li>
<li>
<code>site_assets_url</code> (<strong>required</strong>) - The URL of <strong>assets</strong> directory of the MWF installation. This should be the web-accessible address for the assets directory, including protocol(http/https). </li>
<li>
<code>site_nonmobile_url</code> - This parameter specifies a URL that non-mobile users will be redirected to when they visit the mobile site. If set to false, desktop users will not be redirected when they visit the mobile site.</li>
<li>
<code>full_site_url</code> - This parameter specifies a URL for the "View Full Site" link at the bottom of all mobile pages. If set to false, the link will not be displayed.</li>
<li>
<code>help_site_url</code> - This parameter specifies a URL for the "Help" link at the bottom of all mobile pages. If set to false, the link will not be displayed.</li>
</ul><p><em>Note: All paths specified in the above parameters should NOT include a trailing slash</em></p>

<p>In addition to the global pathing configuration options, <strong>global.php</strong> has a set of options for the way the site is presented. This includes <code>cookie_prefix</code> which can be set to add a prefix to all cookies set by the framework. The front-end presentational configuration options include the following:</p>

<ul>
<li>
<code>appicon_img</code> - The URL of an image that will represent your app on the homescreen of iOS devices. This icon is used when iOS users choose the "Add to Homescreen" option while browsing your mobile site. An image in this tag will have default effects applied to it, including rounded corners and a gloss overlay.</li>
<li>
<code>appicon_img_precomposed</code> - The URL of an image that will represent your app on the homescreen of iOS devices. This option is identical to the previous, but an image specified here will not have the gloss overlay applied to it. This is useful for icons that are designed to be displayed exactly as-is on the homescreen.</li>
<li>
<code>appicon_allow_disable_flag</code> - If set to false, this option will make it so that the framework appicon will always be present. If true, a content provider will be able to pass the <strong>no_appicon</strong> or <strong>no_icon</strong> flags when including <strong>js.php</strong> to disable the framework appicon.</li>
<li>
<code>back_to_home_text</code> - Text to be displayed at the bottom of framework apps or sub-navigation menus to get back to the mobile homepage.
&lt;!-- * <code>charset</code> - Character set (e.g., "utf-8") to be specified in a meta tag on pages. This is useful if you do not have sufficient control over your web server to configure the HTTP headers to specify a character set.  (For Apache, this can be done with the AddDefaultCharset directive.) --&gt;</li>
<li>
<code>copyright_text</code> - The copyright text to be displayed in the footer of every mobile page.</li>
<li>
<code>header_home_button</code> - The URL of an image to be displayed in the header of all framework mobile pages on the left hand side.</li>
<li>
<code>header_home_button_alt</code> - Alternate text for the header home button image.
&lt;!--  * <code>language</code> - Default language code (e.g., "en" for English). --&gt;</li>
<li>
<code>title_text</code> - Text to be used for the title of mobile framework webpages.</li>
</ul><h2>Mobile Front Page Configuration (frontpage.php)</h2>

<p>An institution can customize their mobile site's front page menu by modifying the <code>menu</code> configuration setting in the <strong>frontpage.php</strong> config file. The value for this setting is a three-tiered array. The top level items in the array correspond to submenus on the homepage. The <code>default</code> element in this top level array corresponds to the menu displayed on the homepage of the framework. The value for each top-level element should be an array of menu items to be displayed in the corresponding (sub)menu with each menu item itself represented by an associative array of attributes for the menu item. The available attributes are as follows:</p>

<ul>
<li>
<code>name</code> - The name for the menu item that will be displayed for the item in the menu.</li>
<li>
<code>id</code> - The HTML "id" attribute that will be applied to the <code>&lt;li&gt;</code> entity representing the menu item. This makes it easy to specify icons for each menu item.</li>
<li>
<code>url</code> - The URL that should be launched upon selection of the menu item. If you want a menu item to go to a submenu, set this attribute to <code>index.php?s={SUBMENU_NAME}</code> where you replace <strong>{SUBMENU_NAME}</strong> with the name specified as the array key for the desired submenu.</li>
<li>
<code>restriction</code> - A string that corresponds to a function in the User_Agent class that will be called to determine whether or not to display the link. This can be used to make menu items that will only be displayed on certain devices. For example, a value of <code>is_iphone_os</code> will restrict the menu item to be displayed on iOS devices only.</li>
</ul><h2>System Stylesheet Configuration (css.php)</h2>

<p>The <strong>css.php</strong> configuration file provides a mechanism by which an institution can define a directory of custom stylesheets that will overwrite the default MWF styles. By setting the <code>custom</code> option to a string, the framework will look for a directory with this name inside the <strong>/root/assets/css</strong> directory, and if found, will apply the contained stylesheets after the default framework stylesheets, effectively overwriting any specified styles. If an array is provided, the framework will look for multiple directories, and load them in the same order in which they appear in the array. (CSS definitions from files listed later in the array will take precedence)</p>

<h2>Analytics Configuration (analytics.php)</h2>

<p>The <strong>analytics.php</strong> configuration file provides an option for institutions to set a Google Analytics identifier that the framework will use to embed Google Analytics code in each page that leverages the framework. If no Google Analytics identifier is specified, Google Analytics code will not be produced by the framework.</p>

<h2>Accessing Configuration Settings</h2>

<p>The Config class offers a static accessor method to retrieve the values of configuration options. This class is available in any page that includes <strong>/root/assets/config.php</strong> and configuration options can be acquired with the following call: <code>Config::get('{NAME_OF_CONFIG_FILE', '{NAME_OF_OPTION}');</code>. Simply specify the config file where the desired option resides, and the name of the option, and the value will be returned.</p>

</div>