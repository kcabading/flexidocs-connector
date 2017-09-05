<?php
 // created: 2015-08-19 15:36:35
$layout_defs["idoc_documents"]["subpanel_setup"]['idoc_documents_idoc_signers'] = array (
  'order' => 100,
  'module' => 'idoc_signers',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_IDOC_DOCUMENTS_IDOC_SIGNERS_FROM_IDOC_SIGNERS_TITLE',
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
