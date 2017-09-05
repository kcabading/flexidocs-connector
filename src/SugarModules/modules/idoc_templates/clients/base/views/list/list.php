<?php
$module_name = 'idoc_templates';
$viewdefs[$module_name] = 
array (
  'base' => 
  array (
    'view' => 
    array (
      'list' => 
      array (
        'panels' => 
        array (
          0 => 
          array (
            'label' => 'LBL_PANEL_1',
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'name',
                'label' => 'LBL_NAME',
                'default' => true,
                'enabled' => true,
                'link' => true,
              ),
              1 => 
              array (
                'name' => 'status',
                'label' => 'LBL_STATUS',
                'enabled' => true,
                'default' => true,
              ),
              2 => 
              array (
                'name' => 'no_of_signers',
                'label' => 'LBL_NO_OF_SIGNERS',
                'enabled' => true,
                'default' => true,
              ),
              3 => 
              array (
                'name' => 'allow_email',
                'label' => 'LBL_ALLOW_EMAIL',
                'enabled' => true,
                'default' => true,
              ),
              4 => 
              array (
                'name' => 'allow_download',
                'label' => 'LBL_ALLOW_DOWNLOAD',
                'enabled' => true,
                'default' => true,
              ),
              5 => 
              array (
                'name' => 'output_format_pdf',
                'label' => 'LBL_OUTPUT_FORMAT_PDF',
                'enabled' => true,
                'default' => true,
              ),
              6 => 
              array (
                'name' => 'output_format_orig',
                'label' => 'LBL_OUTPUT_FORMAT_ORIG',
                'enabled' => true,
                'default' => true,
              ),
              7 => 
              array (
                'name' => 'team_name',
                'label' => 'LBL_TEAM',
                'default' => false,
                'enabled' => true,
              ),
            ),
          ),
        ),
        'orderBy' => 
        array (
          'field' => 'date_modified',
          'direction' => 'desc',
        ),
      ),
    ),
  ),
);
