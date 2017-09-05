<?php

global $current_user,$admin_group_header, $sugar_config, $mod_strings;

$admin_options_defs=array();

$admin_options_defs['Administration']['updateintellidocs']=array(       
    'ModuleBuilder',
    $mod_strings['LBL_INTELLIDOCS_CONFIG'],
    $mod_strings['LBL_INTELLIDOCS_CONFIG_DESC'],
    'javascript:parent.SUGAR.App.router.navigate("Home/layout/updateintellidocs", {trigger: true});',
);

$admin_options_defs['Administration']['openintellidocs']=array(       
    'ModuleBuilder',
    $mod_strings['LBL_INTELLIDOCS_PLATFORM'],
    $mod_strings['LBL_INTELLIDOCS_PLATFORM_DESC'],
    // open platform in new window    
    'javascript:window.open("https://console.flexidocs.co");',
);

$admin_options_defs['Administration']['openflexidocstemplates']=array(       
    'ModuleBuilder',
    $mod_strings['LBL_FLEXIDOCS_TEMPLATES'],
    $mod_strings['LBL_FLEXIDOCS_TEMPLATES_DESC'],    
    'javascript:parent.SUGAR.App.router.navigate("idoc_templates", {trigger: true});',
);

$admin_group_header[]=array(
    $mod_strings['LBL_INTELLIDOCS_TITLE'],
    '',
    false,
    $admin_options_defs,
    $mod_strings['LBL_INTELLIDOCS_DESC']
);


?>
