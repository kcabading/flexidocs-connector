<?php
 // created: 2015-07-24 14:26:10
$layout_defs["idoc_signers"]["subpanel_setup"]['idoc_documents_idoc_signers'] = array (
  'order' => 100,
  'module' => 'idoc_documents',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_IDOC_DOCUMENTS_IDOC_SIGNERS_FROM_IDOC_DOCUMENTS_TITLE',
  'get_subpanel_data' => 'idoc_documents_idoc_signers',
  'top_buttons' => 
  array (
    0 => 
    array (
      'widget_class' => 'SubPanelTopSelectButton',
      'mode' => 'MultiSelect',
    ),
    1 => 
    array (
      'widget_class' => 'SubPanelTopButtonQuickCreate',
    ),
  ),
);
