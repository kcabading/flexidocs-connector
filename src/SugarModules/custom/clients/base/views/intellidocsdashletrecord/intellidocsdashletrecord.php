<?php

/*
 * By installing or using this file, you are confirming on behalf of the entity
 * subscribed to the SugarCRM Inc. product ('Company') that Company is bound by
 * the SugarCRM Inc. Master Subscription Agreement ("MSA"), which is viewable at:
 * http://www.sugarcrm.com/master-subscription-agreement
 *
 * If Company is not bound by the MSA, then by installing or using this file
 * you are agreeing unconditionally that Company will be bound by the MSA and
 * certifying that you have authority to bind Company accordingly.
 *
 * Copyright  2004-2013 SugarCRM Inc.  All rights reserved.
 */

$viewdefs['base']['view']['intellidocsdashletrecord'] = array(
    'dashlets' => array(
        array(
            'label' => 'Flexidocs Record View',
            'description' => 'Flexidocs Dashlet Record View',
            'config' => array(                
                'visibility' => 'group',
                'user_field' => 'modified_user_id',  
                'user_ownership' => 'Mine',                              
                'timeline_limit' => 5,
            ),
            'preview' => array(                
                'visibility' => 'group',
            ),
            'filter' => array(                
                'view' => 'record',
            ),
        ),
    ),
    'panels' => array(
        array(
            'name' => 'panel_body',
            'columns' => 2,
            'labelsOnTop' => true,
            'placeholders' => true,
            'fields' => array(    
                array(
                    'name' => 'timeline_limit',
                    'label' => 'LBL_TIMELINE_LIMIT',
                    'type' => 'int',
                    'default' => 5
                ),               
            ),
        ),
    )    
);