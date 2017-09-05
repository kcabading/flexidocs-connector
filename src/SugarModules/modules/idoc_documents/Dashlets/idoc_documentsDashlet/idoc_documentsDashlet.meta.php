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

 * Description:  Defines the English language pack for the base application.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/
 
global $app_strings;

$dashletMeta['idoc_documentsDashlet'] = array('module'		=> 'idoc_documents',
										  'title'       => translate('LBL_HOMEPAGE_TITLE', 'idoc_documents'), 
                                          'description' => 'A customizable view into idoc_documents',
                                          'icon'        => 'icon_idoc_documents_32.gif',
                                          'category'    => 'Module Views');