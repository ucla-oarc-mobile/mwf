<?php

$page = isset($_GET['p']) ? $_GET['p'] : 'overview/introduction';
$segments = explode('/', $page);

$sitemap = array(
    
    'overview'=>array(
        'name'=>'Overview',
        'pages'=>array(
                'introduction'=>'Introduction',
                'principles'=>'Principles &amp; Strategy'
            )
    ),
    
    'start'=>array(
        'name'=>'Getting Started',
        'pages'=>array(
                'module'=>'Module Development',
                'framework'=>'Framework Administration'
            )
    ),
    
    'script'=>array(
        'name'=>'Framework Scripts',
        'pages'=>array(
                'required'=>'Required Handlers',
                'redirect'=>'Mobile Redirector',
                'compression'=>'Minifiers &amp; Compressors',
                'classification'=>'Classification Overrriding',
                'appcache'=>'Appcache Handler'
            )
    ),
    
    'entity'=>array(
        'name'=>'HTML/CSS Entities',
        'pages'=>array(
                'base'=>'Header &amp; Footer',
                'content'=>'Content',
                'menu'=>'Menus',
                'button'=>'Buttons',
                'form'=>'Forms',
                'messages'=>'Messages'
            )
    ),
    
    'core'=>array(
        'name'=>'Javascript API',
        'pages'=>array(
                'site'=>'Site [mwf.site]',
                'capability'=>'Capabilities [mwf.capability]',
                'browser'=>'Browser [mwf.browser]',
                'screen'=>'Screen [mwf.screen]',
                'userAgent'=>'User Agent [mwf.userAgent]',
                'classification'=>'Classification [mwf.classification]',
                'utilities'=>'Utilities [mwf.util]',
                'override'=>'Override [mwf.override]',
                'server'=>'Server'
            )
    ),
    
    'library'=>array(
        'name'=>'Javascript Libraries',
        'pages'=>array(
                'geolocation'=>'Geolocation',
                'trigger'=>'Target/Trigger Engine',
                'touchable'=>'Touch Interactions Engine',
                'expandable'=>'Expandable/Collapsable',
                'accordion'=>'Accordion',
                'transitionable'=>'Transitions',
                'filterable'=>'On-page Filter'
            )
    ),
    
    'extension'=>array(
        'name'=>'Extensions',
        'pages'=>array(
                'decorators'=>'PHP Decorators',
                'native'=>'Native Containers',
                'dts'=>'Device Telemetry Stack'
            )
    ),
    
    'internal'=>array(
        'name'=>'Internals',
        'pages'=>array(
                'scripts'=>'Outward-facing Scripts',
                'directory'=>'Directory Layout',
                'naming'=>'Naming Conventions',
                'dependencies'=>'Dependency Manager',
                'dts'=>'Telemetry Objects',
                'config'=>'Config Helper',
                'cookie'=>'Cookie Helper',
                'path'=>'Pathing Helper',
                'image'=>'Image Helper',
                'cache'=>'Cache Helper',
                'json'=>'JSON Helper',
                'test'=>'Testing Libraries'
            )
    ),
    
    'system'=>array(
        'name'=>'System Administration',
        'pages'=>array(
                'requirements'=>'Requirements &amp; Packages',
                'installation'=>'Installation &amp; Customization',
                'config'=>'Configuration Settings',
                'update'=>'Update Information'
            )
    ),
    
);

$disabled = array('library/trigger'
                 ,'library/touchable'
                 ,'library/expandable'
                 ,'library/accordion'
                 ,'library/transitionable'
                 ,'library/filterable'
                 ,'extension/decorators'
                 ,'extension/native'
                 ,'extension/dts'
                 ,'internal/scripts'
                 ,'internal/directory'
                 ,'internal/naming'
                 ,'internal/dependencies'
                 ,'internal/dts'
                 ,'internal/config'
                 ,'internal/cookie'
                 ,'internal/path'
                 ,'internal/image'
                 ,'internal/cache'
                 ,'internal/json'
                 ,'internal/test');

?><!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="assets/template.css"></link>
        <script type="text/javascript" src="assets/jquery.js"></script>
    </head>
    <body>
        <div id="container">
            <div id="top">
                <img src="<?php echo URL::asset('images/logo.jpg'); ?>"></img>
            </div>
            <ul id="menu">
                <?php foreach($sitemap as $category_key=>$category){ ?>
                    <li>
                        <a href="#"><?php echo $category['name']; ?></a>
                        <?php if(isset($category['pages'])){ ?>
                        <ul<?php if($segments[0] == $category_key) echo ' class="active"'; ?>>
                            <?php 
                            
                            foreach($category['pages'] as $page_key=>$title){ 
                            
                                if(in_array($category_key.'/'.$page_key, $disabled))
                                {
                                    echo '<li class="inactive">'.$title.'</li>';
                                }
                                else
                                {
                                    echo '<li><a href="'.URL::path($category_key.'/'.$page_key).'">'.$title.'</a></li>';
                                }
                                    
                             } ?>
                        </ul>
                        <?php } ?>
                    </li>
                <?php } ?>
            </ul>
            <div id="content">
                <?php echo $CONTENT; ?> 
            </div>
        </div>
        <script type="text/javascript">
            $('#menu > li > a').click(function(e){
                e.preventDefault();
                $(this).siblings('ul').slideToggle();
            });
        </script>
    </body>
</html>
