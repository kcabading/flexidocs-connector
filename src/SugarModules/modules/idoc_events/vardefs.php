<?php

/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */

$dictionary['idoc_events'] = array(
    'table' => 'idoc_events',
    'audited' => true,
    'activity_enabled' => false,
    'fields' => array (
  'document_status' => 
  array (
    'required' => false,
    'name' => 'document_status',
    'vname' => 'LBL_DOCUMENT_STATUS',
    'type' => 'enum',
    'massupdate' => true,
    'default' => 'merged',
    'no_default' => false,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'enabled',
    'duplicate_merge_dom_value' => '1',
    'audited' => false,
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'calculated' => false,
    'len' => 100,
    'size' => '20',
    'options' => 'document_status_list',
    'studio' => 'visible',
    'dependency' => false,
  ),
  'parent_name' => 
  array (
    'required' => false,
    'source' => 'non-db',
    'name' => 'parent_name',
    'vname' => 'LBL_FLEX_RELATE',
    'type' => 'parent',
    'massupdate' => false,
    'no_default' => false,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'enabled',
    'duplicate_merge_dom_value' => '1',
    'audited' => false,
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'calculated' => false,
    'len' => 36,
    'size' => '20',
    'options' => 'parent_type_display',
    'studio' => 'visible',
    'type_name' => 'parent_type',
    'id_name' => 'parent_id',
    'parent_type' => 'record_type_display',
  ),
  'parent_type' => 
  array (
    'required' => false,
    'name' => 'parent_type',
    'vname' => 'LBL_PARENT_TYPE',
    'type' => 'parent_type',
    'massupdate' => false,
    'no_default' => false,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'enabled',
    'duplicate_merge_dom_value' => 1,
    'audited' => false,
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'calculated' => false,
    'len' => 255,
    'size' => '20',
    'dbType' => 'varchar',
    'studio' => 'hidden',
    'group' => 'parent_name',
  ),
  'parent_id' => 
  array (
    'required' => false,
    'name' => 'parent_id',
    'vname' => 'LBL_PARENT_ID',
    'type' => 'id',
    'massupdate' => false,
    'no_default' => false,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'enabled',
    'duplicate_merge_dom_value' => 1,
    'audited' => false,
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'calculated' => false,
    'len' => 36,
    'size' => '20',
  ),
),
    'relationships' => array (
),
    'optimistic_locking' => true,
    'unified_search' => true,
);

if (!class_exists('VardefManager')){
    require_once 'include/SugarObjects/VardefManager.php';
}
VardefManager::createVardef('idoc_events','idoc_events', array('basic','team_security','assignable','file'));