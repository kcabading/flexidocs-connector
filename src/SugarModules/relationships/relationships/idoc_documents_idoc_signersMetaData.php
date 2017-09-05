<?php
// created: 2015-08-19 15:36:35
$dictionary["idoc_documents_idoc_signers"] = array (
  'true_relationship_type' => 'one-to-many',
  'relationships' => 
  array (
    'idoc_documents_idoc_signers' => 
    array (
      'lhs_module' => 'idoc_documents',
      'lhs_table' => 'idoc_documents',
      'lhs_key' => 'id',
      'rhs_module' => 'idoc_signers',
      'rhs_table' => 'idoc_signers',
      'rhs_key' => 'idoc_documents_id_c',
      'relationship_type' => 'one-to-many',
    ),
  ),
  'table' => NULL,
  'fields' => 
  array (
    0 => 
    array (
      'name' => 'id',
      'type' => 'varchar',
      'len' => 36,
    ),
    1 => 
    array (
      'name' => 'date_modified',
      'type' => 'datetime',
    ),
    2 => 
    array (
      'name' => 'deleted',
      'type' => 'bool',
      'len' => '1',
      'default' => '0',
      'required' => true,
    ),
    3 => 
    array (
      'name' => NULL,
      'type' => 'varchar',
      'len' => 36,
    ),
    4 => 
    array (
      'name' => NULL,
      'type' => 'varchar',
      'len' => 36,
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'idoc_documents_idoc_signersspk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'idoc_documents_idoc_signers_ida1',
      'type' => 'index',
      'fields' => 
      array (
        0 => NULL,
      ),
    ),
    2 => 
    array (
      'name' => 'idoc_documents_idoc_signers_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => NULL,
      ),
    ),
  ),
);