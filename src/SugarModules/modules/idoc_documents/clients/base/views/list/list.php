<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
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
/*********************************************************************************
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/

$module_name = 'idoc_documents';
$viewdefs[$module_name]['base']['view']['list'] = array(
    'panels' => array(
        array(
            'label' => 'LBL_PANEL_DEFAULT',
            'fields' => array(
                array(
                    'name' => 'document_name',
                    'width' => '40',
                    'label' => 'LBL_NAME',
                    'link' => true,
                    'default' => true,
                    'enabled' => true,
                ),
                array(
                    'name' => 'modified_by_name',
                    'width' => '10',
                    'label' => 'LBL_MODIFIED_USER',
                    'module' => 'Users',
                    'id' => 'USERS_ID',
                    'default' => false,
                    'sortable' => false,
                    'related_fields' => array('modified_user_id'),
                ),
                array(
                    'name' => 'category_id',
                    'width' => '40',
                    'label' => 'LBL_LIST_CATEGORY',
                    'default' => true,
                    'enabled' => true,
                ),
                array(
                    'name' => 'subcategory_id',
                    'width' => '40',
                    'label' => 'LBL_LIST_SUBCATEGORY',
                    'default' => true,
                    'enabled' => true,
                ),
                array(
                    'name' => 'team_name',
                    'width' => '2',
                    'label' => 'LBL_TEAM',
                    'sortable' => false,
                    'default' => true,
                    'enabled' => true,
                ),
                array(
                    'name' => 'created_by_name',
                    'width' => '2',
                    'label' => 'LBL_LIST_LAST_REV_CREATOR',
                    'default' => true,
                    'sortable' => false,
                    'enabled' => true,
                ),
                array(
                    'name' => 'active_date',
                    'width' => '10',
                    'label' => 'LBL_LIST_ACTIVE_DATE',
                    'default' => true,
                    'enabled' => true,
                ),
                array(
                    'name' => 'exp_date',
                    'width' => '10',
                    'label' => 'LBL_LIST_EXP_DATE',
                    'default' => true,
                    'enabled' => true,
                ),
            ),
        ),
    ),
);