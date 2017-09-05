<?php

// First of all, find the action dropdown
foreach ($viewdefs['Contacts']['base']['view']['recordlist']['selection']['actions'] as $strKey => $arConfig) {
  // Is this the action dropdown?
  if (!empty($arConfig["name"]) && ($arConfig["name"] == "export_button")) {
    // Add the actual button
    $viewdefs['Contacts']['base']['view']['recordlist']['selection']['actions'][] = array(
        'name' => 'flexilist',
        'type' => 'flexilist',
        'label' => 'Flexidocs',
        'acl_action' => 'export',
        'primary' => true,
        'events' => array(
            'click' => 'list:flexidocs:fire',
        ),
    );
    // Nothing else to do
    break;
  }
}

