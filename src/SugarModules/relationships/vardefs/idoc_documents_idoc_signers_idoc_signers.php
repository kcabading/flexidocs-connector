<?php
// created: 2015-08-19 15:36:35
$dictionary["idoc_signers"]["fields"]["idoc_documents_idoc_signers"] = array (
  'name' => 'idoc_documents_idoc_signers',
  'type' => 'link',
  'relationship' => 'idoc_documents_idoc_signers',
  'source' => 'non-db',
  'module' => 'idoc_documents',
  'bean_name' => 'idoc_documents',
  'side' => 'right',
  'vname' => 'LBL_IDOC_DOCUMENTS_IDOC_SIGNERS_FROM_IDOC_SIGNERS_TITLE',
  'id_name' => 'idoc_documents_idoc_signersidoc_documents_ida',
  'link-type' => 'one',
);
$dictionary["idoc_signers"]["fields"]["idoc_documents_idoc_signers_name"] = array (
  'name' => 'idoc_documents_idoc_signers_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_IDOC_DOCUMENTS_IDOC_SIGNERS_FROM_IDOC_DOCUMENTS_TITLE',
  'save' => true,
  'id_name' => 'idoc_documents_idoc_signersidoc_documents_ida',
  'link' => 'idoc_documents_idoc_signers',
  'table' => 'idoc_documents',
  'module' => 'idoc_documents',
  'rname' => 'document_name',
);
$dictionary["idoc_signers"]["fields"]["idoc_documents_idoc_signersidoc_documents_ida"] = array (
  'name' => 'idoc_documents_idoc_signersidoc_documents_ida',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_IDOC_DOCUMENTS_IDOC_SIGNERS_FROM_IDOC_SIGNERS_TITLE_ID',
  'id_name' => 'idoc_documents_idoc_signersidoc_documents_ida',
  'link' => 'idoc_documents_idoc_signers',
  'table' => 'idoc_documents',
  'module' => 'idoc_documents',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'right',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
