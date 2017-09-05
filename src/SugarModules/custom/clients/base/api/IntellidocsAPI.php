<?php

if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

// include the intellidocs class
include_once('custom/include/classes/intellidocs.php');
//Instantiate the parser factory.
require_once('modules/ModuleBuilder/parsers/ParserFactory.php');
// require Administration class
require_once('modules/Administration/Administration.php');
// Include reports class
require_once('modules/Reports/Report.php');

class IntellidocsApi extends SugarApi
{
    // default function to extends SugarAPI
    public function registerApiRest()
    {
        return array(
            // Post request
            'SyncIntellidocs' => array(
                'reqType' => 'POST',
                'path' => array('intellidocs', 'syncintellidocs'),
                'method' => 'SyncIntellidocs',
                'shortHelp' => 'Sync Intellidocs records to Sugar',
                'longHelp' => '',
            ),
            'GetDocuments' => array(
                'reqType' => 'GET',
                'path' => array('intellidocs', 'getdocuments'),                                
                'method' => 'GetDocuments',                
                'shortHelp' => 'get intellidoc documents from database',
                'longHelp' => '',
            ),
            'SearchContactsUsers' => array(
                'reqType' => 'GET',
                'path' => array('intellidocs', 'searchcontactsusers'),                                
                'method' => 'SearchContactsUsers',
                'shortHelp' => 'get intellidoc documents from database',
                'longHelp' => '',
            ),               
            'GetVariables' => array(
                'reqType' => 'GET',
                'path' => array('intellidocs', 'getvariables'),                                
                'method' => 'GetVariables',
                'shortHelp' => 'Returns a list of the module variables',
                'longHelp' => '',
            ),
            'MergeDocument' => array(
                'reqType' => 'POST',
                'path' => array('intellidocs', 'mergedocument'),                                
                'method' => 'MergeDocument',
                'shortHelp' => 'Merge and download the document',
                'longHelp' => '',
            ), 
            'GenerateMulti' => array(
                'reqType' => 'POST',
                'path' => array('intellidocs', 'generatemulti'),                                
                'method' => 'GenerateMulti',
                'shortHelp' => 'Merge and download the document',
                'longHelp' => '',
            ), 
            'GetIntellidocsSettings' => array(
                'reqType' => 'GET',
                'path' => array('intellidocs', 'getsettings'),                                
                'method' => 'GetIntellidocsSettings',
                'shortHelp' => 'Check signing status and update the record',
                'longHelp' => '',
            ),
            'ValidateIntellidocsLicense' => array(
                'reqType' => 'POST',
                'path' => array('intellidocs', 'validatelicense'),                                
                'method' => 'ValidateIntellidocsLicense',
                'shortHelp' => 'Validate the license key in the intellidocs portal and save as config',
                'longHelp' => '',
            ),
            'SignDocument' => array(
                'reqType' => 'POST',
                'path' => array('intellidocs', 'sign'),                                
                'method' => 'SignDocument',
                'shortHelp' => 'Send the document for signing',
                'longHelp' => '',
            ),
            'GetIntellidocsRecord' => array(
                'reqType' => 'GET',
                'path' => array('intellidocs', 'getrecord'),                                
                'method' => 'GetIntellidocsRecord',
                'shortHelp' => 'Get the intellidocs record and related timelines which are saved as notes',
                'longHelp' => '',
            ),
            'GetIntellidocsDashletList' => array(
                'reqType' => 'GET',
                'path' => array('intellidocs', 'getintellidocsdashletlist'),                                
                'method' => 'GetIntellidocsDashletList',
                'shortHelp' => 'Get all the intellidocs list and related events (recent up to 5) ',
                'longHelp' => '',
            ),
            'GetRelatedIntellidocs' => array(
                'reqType' => 'GET',
                'path' => array('intellidocs', 'getrelatedintellidocs'),                                
                'method' => 'GetRelatedIntellidocs',
                'shortHelp' => 'Get all the intellidocs related to the record ',
                'longHelp' => '',
            ),
            'DeleteRelatedIntellidoc' => array(
                'reqType' => 'POST',
                'path' => array('intellidocs', 'deleterelatedintellidocs'),                                
                'method' => 'DeleteRelatedIntellidoc',
                'shortHelp' => 'Delete the related intellidoc record',
                'longHelp' => '',
            ),
            'HandleSignatureCallback' => array(
                'reqType' => 'POST',
                'path' => array('intellidocs', 'handlecallback'),
                'method' => 'HandleSignatureCallback',
                'shortHelp' => 'Handles the callback from IntelliDocs platform',
                'longHelp' => '',
            ),
            'CancelSigning' => array(
                'reqType' => 'POST',
                'path' => array('intellidocs', 'cancelsigning'),
                'method' => 'CancelSigning',
                'shortHelp' => 'cancel document sent to signing',
                'longHelp' => '',                
            ),
            'GetModuleInfo' => array(
                'reqType' => 'GET',
                'path' => array('intellidocs', 'getmoduleinfo'),                
                'method' => 'GetModuleInfo',
                'shortHelp' => 'Get Module information and list of intellidocs',
                'longHelp' => '',
                'noLoginRequired' => true,
            ),
            'FiltersTest' => array(
                'reqType' => 'POST',
                'path' => array('intellidocs', 'filterstest'),
                'method' => 'FiltersTest',
                'shortHelp' => 'test filters defined in mass document generation',
                'longHelp' => '',
            ),
            'GenerateDocuments' => array(
                'reqType' => 'POST',
                'path' => array('intellidocs', 'generatedocuments'),
                'method' => 'GenerateDocuments',
                'shortHelp' => 'Pull records based on the defined filters and send it to intellidocs platform for document generation',
                'longHelp' => '',
            ),
            'GetSignatureDetails' => array(
                'reqType' => 'GET',
                'path' => array('intellidocs', 'getsignaturedetails'),
                'method' => 'GetSignatureDetails',
                'shortHelp' => 'Get the signature details, the signature type and signers',
                'longHelp' => '',
            ),            
            'HandleMergedDocuments' => array(
                'reqType' => 'POST',
                'path' => array('intellidocs', 'handlemergeddocuments'),
                'method' => 'HandleMergedDocuments',
                'shortHelp' => 'Handles merged documents returned by intellidocs platform',
                'longHelp' => '',
            ),
            'ConvertDocument' => array(
                'reqType' => 'POST',
                'path' => array('intellidocs', 'convertdocument'),
                    'method' => 'ConvertDocument',
                'shortHelp' => 'Download document to different formats',
                'longHelp' => '',
            ),            
            'GetDocumentForEmail' => array(
                'reqType' => 'POST',
                'path' => array('intellidocs', 'getdocumentforemail'),
                    'method' => 'GetDocumentForEmail',
                'shortHelp' => 'Converts the given document',
                'longHelp' => '',
            ),            
            'UpdateDocuments' => array(
                'reqType' => 'POST',
                'path' => array('intellidocs', 'updatedocuments'),
                'method' => 'UpdateDocuments',
                'shortHelp' => 'Update documents saved in local from IntelliDocs platform',
                'longHelp' => '',
            ),
            'GetLastSync' => array(
                'reqType' => 'GET',
                'path' => array('intellidocs', 'getlastsync'),
                'method' => 'GetLastSync',
                'shortHelp' => 'Get the last updated date of sync',
                'longHelp' => '',
            ),
            'MergeMultipleDocuments' => array(
                'reqType' => 'POST',
                'path' => array('intellidocs', 'mergemultipledocuments'),                                
                'method' => 'MergeMultipleDocuments',
                'shortHelp' => 'Merge and download the multiple documents in zip',
                'longHelp' => '',
            ),
            'VerifyMailingAddress' => array(
                'reqType' => 'POST',
                'path' => array('intellidocs', 'verifymailingaddress'),
                'method' => 'VerifyMailingAddress',
                'shortHelp' => 'Verify Mailing address provided by the user',
                'longHelp' => '',
            ),
            'SendToMailingAddress' => array(
                'reqType' => 'POST',
                'path' => array('intellidocs', 'sendtomailingaddress'),
                'method' => 'SendToMailingAddress',
                'shortHelp' => 'send to mailing address provided by the user',
                'longHelp' => '',
            ),
            'ManualUpload' => array(
                'reqType' => 'POST',
                'path' => array('intellidocs', 'manualupload'),
                'pathVars' => array(),
                'method' => 'ManualUpload',
                'shortHelp' => '',
                'longHelp' => '',
            ),
            'GetCompatibleReports' => array(
                'reqType' => 'GET',
                'path' => array('intellidocs', 'getcompatiblereports'),
                'method' => 'GetCompatibleReports',
                'shortHelp' => 'Returns the available reports for the given module',
                'longHelp' => '',
            ),                             
        );
    }

    /**
     * Searches for matching addresses based on the given term
     */
    public function GetCompatibleReports($api, $args) {
        // get access to globals
        global $db, $timedate, $sugar_config, $app_list_strings;
        // require args
        $this->requireArgs($args, array('parent_module'));        
        // Initialize the data
        $arReturn = array(
            "success" => true,
            "reports" => array(),
        );
        // Get a list of the reports
        $strQuery = "
            SELECT
                id,
                name
            FROM
                saved_reports
            WHERE
                module = '{$args["parent_module"]}'
            AND
                deleted = '0'
            ORDER BY
                name
        ";
        // Execute
        $hQuery = $db->query($strQuery);
        // Loop through
        while ($arRow = $db->fetchByAssoc($hQuery)) {
            // Add to the list            
            $arReturn["reports"][] = array(
                "key" => $arRow["id"],
                "value" => $arRow["name"],
            );
        }
        // return courses
        return $arReturn;
    }

    /**
     * Manually upload a file in console
     */
    public function ManualUpload($api, $args) {
        // get access to globals
        global $db, $current_user;
        // require args
        $this->requireArgs($args,array('file-name','file-data','module','document-id','record-id'));        
        // separate file data
        $arFileData = explode(',', $args['file-data']);
        // 2nd index is the base64 encode data
        if (empty($arFileData[1])) return json_encode(array("error" => 'File not found'));
        // decode 
        $strFileContent = base64_decode($arFileData[1]);
        // setup params
        $arPostData = array(
            'name' => $args['file-name'],
            'type' => $args['file-type'],
            'data' => $arFileData[1],
            'document-id' => $args['document-id'],
            'module' => $args['module'],
        );
        // json encode the data before passing
        $arPostData = json_encode($arPostData);        
        // setup intellidocs merge endpoint                            
        $strUrl = IntelliDocs::ApiEndpoint . "manualupload";        
        // make a curl request
        if ( $arResponse = IntelliDocs::sendCurlRequest($strUrl, $arPostData, 'POST') ) {
            // if error occured
            if (!empty($arResponse['error'])) {
                // return error message
                return json_encode(array("error" => $arResponse['error']));
            }
            // get related flexidocs document
            if ( $objIntellidocs = BeanFactory::getBean('idoc_documents', $args['record-id']) ) {
                // set status
                $objIntellidocs->document_status = 'manually_uploaded';
                // set the filename, replace space character
                $strFileName = "Manually Uploaded {$args['file-name']}";
                // Handle PDF Attachment
                $objFile = new UploadFile('uploadfile');
                // Set the filename
                $objFile->set_for_soap($strFileName, $strFileContent);
                $objFile->create_stored_filename();
                // Create the new doc event
                $objDocEvent = new idoc_events();
                // set doc event name
                $objDocEvent->document_name = $objDocEvent->filename = $strFileName;
                // Set the mime type
                $objDocEvent->file_mime_type = $args['file-type'];
                $objDocEvent->file_ext = $args['file-type'];
                // Set the parent id
                $objDocEvent->parent_id = $objIntellidocs->id;
                // Set the parent name
                $objDocEvent->parent_type = 'idoc_documents';   
                // Set assigned user
                $objDocEvent->assigned_user_id = $objIntellidocs->assigned_user_id;                                
                // Set assigned team
                $objDocEvent->team_id = $objIntellidocs->team_id;
                // set document status
                $objDocEvent->document_status = $objIntellidocs->document_status;
                // Save the doc event
                $strId = $objDocEvent->save();
                // Do final move
                $objFile->final_move($strId);                
                // save
                if ($objIntellidocs->save()) {
                    // Move to upload directory
                    $objFile->final_move($args['record-id']);
                    // // if we get here, success
                    return json_encode(array("success" => $arResponse['success']));
                }            
            }
            // no record found
            return json_encode(array("error" => 'No FlexiDocs Record Found'));            
        }
        // if we get to here, error message
        return json_encode(array("error" => IntelliDocs::$strErrorMessage));        
    }
    // /**
    //  * Uploads a file and return its id
    //  */
    // public function UploadBlockFile($api, $args) {     
    //     $GLOBALS['log']->fatal('Uploading File');
    //     // initialise return data
    //     return $arReturn = array(
    //         'id' => 123
    //     );                   
    // }
    // /**
    //  * Save Block Data
    //  */
    // public function SaveBlockdata($api, $args) {        
    //     //access the globals
    //     global $app_list_strings, $db, $current_user;
    //     // Initialize the return data
    //     $arReturn = array();
    //     // setup required data
    //     $this->requireArgs($args, array('record', 'module', 'field'));
    //     // instantiate Opportunity object
    //     $objBean = BeanFactory::newBean($args["module"]);
    //     // retrieve
    //     if ($objBean->retrieve($args['record'])) { 
    //         // set the field
    //         $strField = $args["field"];
    //         // Set the value
    //         $objBean->$strField = json_encode($args["blockdata"]);
    //         // save
    //         if ($objBean->save()) {
    //             // Success
    //             $arReturn["success"] = true;
    //         }
    //     }
    //     // if we get to here, error
    //     return $arReturn;
    // }
    /**
     * Send to Mailing Address
     *
     * @return Json object
     */
    public function SendToMailingAddress($api, $args) {
        // initialise array
        $arPostData = array(
            'name' => '',
            'description' => '',
            'print_type' => 1,
            'double_sided' => 1,
            'addresses' => array(),
            'file_content' => '',
            'file_type' => '',
            'calculate_first' => true
        );
        $arHeader = array();          
        // instantiate intellidocs object
        $objIntellidocs = BeanFactory::newBean('idoc_documents');
         // if theres no existing Intellidocs record using parent module, id and Intellidocs id
        if ( !$objIntellidocs->retrieve_by_string_fields(array('parent_type' => $args['parent_module'], 'parent_id' => $args['parent_id'], 'intellidocs_id' => $args['intellidocs_id'] )) ) {
            // return error
            return json_encode(array("error" => 'Record not found'));
        }  
        // get the related record
        if ($objBean = BeanFactory::getBean($args['parent_module'], $args['parent_id'])) {            
            // setup POST data to be passed on to Intellidocs
            $arPostData['name'] = (!empty($objBean->full_name) ? $objBean->full_name: $objBean->name);
            $arPostData['print_type'] = $args['print_type'];
            $arPostData['description'] = $args['description'];
            $arPostData['double_sided'] = $args['double_sided'];
            $arPostData['addresses'] = $args['addresses'];                        
            // if calculate first
            $arPostData['calculate_first'] = $args['calculate_first'];
            // do we have merged_id?
            if (empty($args['merge_id'])) {
                // do we have event id?
                if (!empty($args['event_id'])) {
                    // get the document attached to it
                    $objFile = new UploadFile();
                    // get the file location
                    $objFile->temp_file_location = UploadFile::get_upload_path($args['event_id']);
                    // get file content
                    $strFileContents = $objFile->get_file_contents();
                    // do we have file content?
                    if (!empty($strFileContents) ) {
                        // set file data
                        $arPostData['file_content'] = base64_encode($strFileContents);
                        // set file type
                        $arPostData['file_type'] = (!in_array($objIntellidocs->document_status, array('partially_signed','signed'))) ? 'docx' : 'pdf';
                    }                        
                }
                // setup intellidocs merge endpoint                            
                $strUrl = IntelliDocs::ApiEndpoint . "sendtomailingaddress/{$args['intellidocs_id']}";
            } else {
                // setup intellidocs merge endpoint                            
                $strUrl = IntelliDocs::ApiEndpoint . "sendtomailingaddress/{$args['intellidocs_id']}/{$args['merge_id']}";
            }            
            // json encode the data before passing
            $arPostData = json_encode($arPostData);                    
            // make a curl request
            if ( $arResponse = IntelliDocs::sendCurlRequest($strUrl, $arPostData, 'POST', $arHeader) ) {
                // if error occured
                if (!empty($arResponse['error'])) {
                    // return error message
                    return json_encode(array("error" => $arResponse['error']));
                }
                // if we have a total amount return
                if (!empty($arResponse['total'])) {
                    // return the total amount
                    return json_encode(array("total" => $arResponse['total']));
                }                
                // Create the new doc event
                $objDocEvent = new idoc_events();                
                // Set the remaining intellidocs details
                $objIntellidocs->document_status = "letter_sent";                
                // Set the doc event filename
                $objDocEvent->document_name = "Letter_Sent_" . $objIntellidocs->document_name;                
                // Set the parent id
                $objDocEvent->parent_id = $objIntellidocs->id;
                // Set the parent name
                $objDocEvent->parent_type = 'idoc_documents';   
                // Set assigned user
                $objDocEvent->assigned_user_id = $objIntellidocs->assigned_user_id;
                // Set assigned team
                $objDocEvent->team_id = $objIntellidocs->team_id;
                // set document status
                $objDocEvent->document_status = $objIntellidocs->document_status;
                // Save the doc event
                if ( $objDocEvent->save() ) {
                    // save intellidocs
                    $objIntellidocs->save();
                    // return success
                    return json_encode(array(
                        "success" => "Successfully queued mail for sending <br />" 
                                    . "<strong>Tracking Number:</strong> {$arResponse['tracking_number']}<br />"
                                    . "<strong>To:</strong> {$arResponse['to_address']}<br />"
                                    . "<strong>From:</strong> {$arResponse['from_address']}<br />"
                                    . "<strong>Expected Delivery Date:</strong> {$arResponse['expected_delivery_date']}<br />"                        
                        )
                    );
                }                
            }    
            // if we get to here, error message
            return json_encode(array("error" => IntelliDocs::$strErrorMessage));        
        }   
        // if we get here, record not found
        return json_encode(array("error" => 'Record not found'));                 
    }
    /**
     * Verify Mailing address
     *     
     * @return Boolean
     */
    public function VerifyMailingAddress($api, $args) {
        // setup POST data to be passed on to Intellidocs
        $arPostData = $args['addresses'];        
        // json encode the data before passing
        $arPostData = json_encode($arPostData);        
        // setup intellidocs merge endpoint                            
        $strUrl = IntelliDocs::ApiEndpoint . "verifymailingaddress";
        // make a curl request
        if ( $arResponse = IntelliDocs::sendCurlRequest($strUrl, $arPostData, 'POST', $arHeader) ) {
            // if error occured
            if (!empty($arResponse['error'])) {
                // return error message
                return json_encode(array("error" => $arResponse['error']));
            }
            // else, success
            return json_encode(array("success" => $arResponse['success']));
        }
        // if we get to here, error message
        return json_encode(array("error" => IntelliDocs::$strErrorMessage));
    }
    /**
     * Merge multiple documents and return a zip file containing all the merged documents
     */
    public function MergeMultipleDocuments($api, $args) {        
        // get access to globals
        global $current_user, $timedate, $sugar_config, $db, $app_list_strings;
        // get the related record
        if ( $objParent = BeanFactory::getBean($args['parent_module'], $args['parent_id']) ) {
            // assign record name
            $strRecordName = (!empty($objParent->name)) ? $objParent->name : $objParent->full_name;
            // initialise string
            $strCombinedDocumentName = '';            
            // if not empty
            if (!empty($args['ids'])) {
                // initialise data as array
                $arMultipleData = array(   
                    // 'merge_type' => $args['merge_type'],             
                    'count' => 0,
                    'documents' => array()
                );
                // initialise no of signers
                $intNoOfSigners = 0;
                // initialise
                $arOutputFormat = array();
                $bAllowEmail = $bAllowDownload = $bOutputPdf = $bOutputOrig = true;
                $strLastDocumentId = '';                
                // loop through this
                foreach ($args['ids'] as $strIntellidocsId) {
                    // Instantiate Intellidocs record
                    $objIntellidocs = BeanFactory::newBean('idoc_documents');
                    // check for existing Intellidocs record using parent module, id and Intellidocs id
                    if ( $objIntellidocs->retrieve_by_string_fields(array('parent_type' => $args['parent_module'], 'parent_id' => $args['parent_id'], 'intellidocs_id' => $strIntellidocsId )) ) {
                        // check if currently on signature process
                        if ($arSigningStatus = $this->checkSigningStatus($objIntellidocs)) {
                            // if in progress, return
                            return $arSigningStatus;
                        }                                  
                    }           
                    // get related document template
                    if ($objDocTemplate = BeanFactory::getBean('idoc_templates', $strIntellidocsId)) {                                                                             
                        // add name
                        $strCombinedDocumentName .= ", {$objDocTemplate->name}";
                        // if module is the same
                        if ( $objDocTemplate->parent_module == $args['parent_module'] ){
                            // document fields not empty?
                            if (!empty($objDocTemplate->field_map)) {
                                // call function to get data
                                if ($arFieldsData = $this->getFieldsData($args['parent_module'], $args['parent_id'], json_decode($objDocTemplate->field_map,true) ) ) {                                                                              
                                    // if greater than no of signers
                                    if ($objDocTemplate->no_of_signers > $intNoOfSigners) {
                                        // set new value for no of signer
                                        $intNoOfSigners = $objDocTemplate->no_of_signers;
                                        // set it as the last document id
                                        $strLastDocumentId = $strIntellidocsId;
                                        // add it to the last position
                                        $arMultipleData['documents'] = array_merge(                                                
                                             $arMultipleData['documents'],
                                             array( 
                                                 $strIntellidocsId => array(                                    
                                                    'fields' => $arFieldsData   
                                                )
                                            )
                                        );
                                        // set new document options
                                        $bAllowEmail = ($objDocTemplate->allow_email) ? true : false;
                                        $bAllowDownload = ($objDocTemplate->allow_download) ? true : false;
                                        $bOutputPdf = ($objDocTemplate->output_format_pdf) ? true : false;
                                        $bOutputOrig = ($objDocTemplate->output_format_orig) ? true : false;
                                        // // initialise 
                                        // $arFormat = array();
                                        // // loop through output formats
                                        // foreach ($arDocument['output_format'] as $strFormat) {
                                        //     // assign string
                                        //     $arFormat[] = strtoupper($strFormat);
                                        // }
                                        // assign variable
                                        // $arOutputFormat = $arFormat;
                                    } else {                                            
                                        // if empty
                                        if (empty($strLastDocumentId)) {
                                            // add it to the end                                           
                                            $arMultipleData['documents'][$strIntellidocsId] = array(                                                                                        
                                                'fields' => $arFieldsData   
                                            );                                                
                                            // set new document options
                                            $bAllowEmail = ($objDocTemplate->allow_email) ? true : false;
                                            $bAllowDownload = ($objDocTemplate->allow_download) ? true : false;
                                            $bOutputPdf = ($objDocTemplate->output_format_pdf) ? true : false;
                                            $bOutputOrig = ($objDocTemplate->output_format_orig) ? true : false;

                                            // initialise 
                                            // $arFormat = array();
                                            // // loop through output formats
                                            // foreach ($arDocument['output_format'] as $strFormat) {
                                            //     // assign string
                                            //     $arFormat[] = strtoupper($strFormat);
                                            // }
                                            // // assign variable
                                            // $arOutputFormat = $arFormat;
                                        } else {
                                            // add to the beginning                                            
                                            $arMultipleData['documents'] = array_merge(
                                                 array( 
                                                     $strIntellidocsId => array(                                    
                                                        'fields' => $arFieldsData   
                                                    )
                                                 ),
                                                 $arMultipleData['documents']
                                            );
                                        }                                            
                                    }                                        
                                    // setup POST data to be passed on to Intellidocs
                                    $arMultipleData['documents'][$strIntellidocsId] = array(                                    
                                        'fields' => $arFieldsData   
                                    );           
                                }
                            }
                        }    
                    }                    
                }                    
            }            
            // set the number for templates selected
            $arMultipleData['count'] = count($arMultipleData['documents']);            
            // json encode the data before passing
            $arPostData = json_encode($arMultipleData);            
            // setup intellidocs multiple merge endpoint                            
            $strUrl = IntelliDocs::ApiEndpoint . "mergemultiple";            
            // // do we have last document id
            $strLastDocumentId = empty($strLastDocumentId) ? end($args['ids']) : $strLastDocumentId;
            // start curl request
            if ( $strFileContent = IntelliDocs::sendCurlRequest($strUrl, $arPostData, 'POST', $arHeader) ) {
                // Process the return file content here
                if (!$strFileContent)
                {
                    return json_encode(array("error" => "Invalid File Content"));
                }
                // Instantiate Intellidocs record
                $objIntellidocs = BeanFactory::newBean('idoc_documents');                
                // create new record
                $strIntellidocsRecordId = $objIntellidocs->id = create_guid();                
                $objIntellidocs->new_with_id = true;
                // set the related intellidocs id as the last selected template
                $objIntellidocs->intellidocs_id = $strLastDocumentId;
                // set as multidoc
                $objIntellidocs->multidoc_c = 1;                        
                // set the parent type
                $objIntellidocs->parent_type = $args['parent_module'];
                // set the parent id
                $objIntellidocs->parent_id = $args['parent_id']; 
                // set status
                $objIntellidocs->document_status = 'merged';
                // set the filename, replace space character
                $strFileName = "Multidoc:{$strRecordName}" . "(" . trim($strCombinedDocumentName,',') . ").docx";
                // Handle PDF Attachment
                $objFile = new UploadFile('uploadfile');
                // Set the filename
                $objFile->set_for_soap($strFileName, $strFileContent);
                $objFile->create_stored_filename();
                $objIntellidocs->name = $objIntellidocs->filename = str_replace(" ", "_", $strFileName);
                $objIntellidocs->document_name =  $strFileName;                
                $objIntellidocs->file_mime_type = $objIntellidocs->file_ext = 'docx';                 
                // set current user id and team id
                $objIntellidocs->assigned_user_id = $current_user->id ;                    
                $objIntellidocs->team_id = $current_user->team_id;
                // Create the new doc event
                $objDocEvent = new idoc_events();
                // set doc event name
                $objDocEvent->document_name = $objDocEvent->filename = str_replace(" ", "_", $strFileName);
                // Set the mime type
                $objDocEvent->file_mime_type = 'docx';
                // Set the parent id
                $objDocEvent->parent_id = $objIntellidocs->id;
                // Set the parent name
                $objDocEvent->parent_type = 'idoc_documents';   
                // Set assigned user
                $objDocEvent->assigned_user_id = $objIntellidocs->assigned_user_id;                                
                // Set assigned team
                $objDocEvent->team_id = $objIntellidocs->team_id;
                // set document status
                $objDocEvent->document_status = $objIntellidocs->document_status;
                // Save the doc event
                $strId = $objDocEvent->save();
                // Do final move
                $objFile->final_move($strId);                  
                // save
                if ($objIntellidocs->save()) {                    
                    // Move to upload directory
                    $objFile->final_move($strIntellidocsRecordId);
                    // get related signers
                    $arSignatureDetails = $this->_getRelatedSigners($strLastDocumentId, $objParent); 
                    // initialise array
                    $arAddresses = array();
                    // call function to get addresses related to record
                    $arAddresses = $this->_getRecordAddresses($args['parent_module'], $args['parent_id']);
                    // initialise 
                    $intEnableLob = 0;                    
                    // instantiate
                    $objAdmin = new Administration();
                    // retrieve intellidocs config
                    $objAdmin->retrieveSettings('intellidocs_config');
                    // assign lob setting
                    $intEnableLob = !empty($objAdmin->settings['intellidocs_config_enable_lob']) ? 1 : 0;                    
                    // Return success
                    return json_encode(array(
                        "success" => true,
                        "record_id" => $strIntellidocsRecordId,
                        'document_id' => $objIntellidocs->intellidocs_id,
                        "merge_id" => !empty($arHeader["Merge-Id"]) ? $arHeader["Merge-Id"] : "",
                        'merge_name' => $objIntellidocs->document_name,
                        "doc_event_id" =>  $objDocEvent->id,                                        
                        "no_of_signers" =>  $intNoOfSigners,                        
                        "default_signers" => $arSignatureDetails['default_signers'],
                        "default_signers_init" => $arSignatureDetails['default_signers_init'],
                        'default_addresses' => $arAddresses,
                        'enable_lob' => $intEnableLob,
                        'allow_email' => $bAllowEmail,
                        'allow_download' => $bAllowDownload,
                        'output_format_pdf' => $bOutputPdf,
                        'output_format_orig' => $bOutputOrig
                    ));                                                            
                }
                                     
            }    
                    
        }
        // if we get here, error
        return false;
    }
    /**
     * Get Related Signers
     *
     * @param String $strIntellidocsId the Intellidocs Id of the document
     * @param Object $objParent the parent module of the record being merge
     *
     * @return Array signers details
     */
    private function _getRelatedSigners($strIntellidocsId, $objParent) {
        // get access to globals
        global $db, $timedate, $app_list_strings, $current_user;
        $arSignatureDetails = array();
        // setup intellidocs to get the signature detail
        $strUrl = IntelliDocs::ApiEndpoint . "getsignaturedetails/{$strIntellidocsId}";                
        // make a curl request
        $arSignatureDetails = IntelliDocs::sendCurlRequest($strUrl);                
        // Initialize the default signers
        $arDefaultSigners = array();        
        // Do we have any signers?
        if (!empty($arSignatureDetails["no_of_signers"])) {                               
            // Determine the parent module
            switch ($objParent->module_dir) {
                // Determine the type
                case "Leads":
                case "Contacts":
                    // Do we have just the one signer?
                    if ($arSignatureDetails["no_of_signers"] == 1) {
                        // Get the module label
                        $strLabel = $app_list_strings["moduleListSingular"][$objParent->module_dir];
                        // Set the name
                        $strText = "{$objParent->full_name} <" . (!empty($objParent->email1) ? $objParent->email1 : "No Email Address") . "> ({$strLabel})";
                        // Get a list of the matches
                        $arDefaultSigners[] = array(
                            "id" => "{$objParent->module_dir}:{$objParent->id}",
                            "text" => $strText,
                            "module" => $objParent->module_dir
                        );
                    } elseif ($arSignatureDetails["no_of_signers"] == 2) {
                        // Get the module label
                        $strLabel = $app_list_strings["moduleListSingular"][$objParent->module_dir];
                        // Set the name
                        $strText = "{$objParent->full_name} <" . (!empty($objParent->email1) ? $objParent->email1 : "No Email Address") . "> ({$strLabel})";
                        // Get a list of the matches
                        $arDefaultSigners[] = array(
                            "id" => "{$objParent->module_dir}:{$objParent->id}",
                            "text" => $strText,
                            "module" => $objParent->module_dir
                        );
                        // Get the module label
                        $strLabel = $app_list_strings["moduleListSingular"][$current_user->module_dir];
                        // Set the name
                        $strText = "{$current_user->full_name} <" . (!empty($current_user->email1) ? $current_user->email1 : "No Email Address") . "> ({$strLabel})";
                        // Get a list of the matches
                        $arDefaultSigners[] = array(
                            "id" => "{$current_user->module_dir}:{$current_user->id}",
                            "text" => $strText,
                            "module" => $current_user->module_dir
                        );
                    }
                    break;
                // Opportunities
                case "Opportunities":
                    // Determine the number of contacts
                    $strQuery = "
                        SELECT
                            C.id,
                            CONCAT_WS(' ', C.first_name, C.last_name) as name,
                            EA.email_address,
                            'Contacts' as module
                        FROM
                            contacts C
                        LEFT JOIN
                            opportunities_contacts OC
                        ON
                            C.id = OC.contact_id
                        LEFT OUTER JOIN
                            email_addr_bean_rel EAB
                        ON
                            C.id = EAB.bean_id
                        AND
                            EAB.bean_module = 'Contacts'
                        AND
                            EAB.deleted = '0' 
                        LEFT OUTER JOIN
                            email_addresses EA
                        ON
                            EAB.email_address_id = EA.id
                        WHERE
                            OC.opportunity_id = '{$objParent->id}'
                        AND
                            OC.deleted = '0'
                        AND
                            C.deleted = '0'
                    ";
                    // Execute
                    $hQuery = $db->query($strQuery);
                    // Initialize contacts
                    $arContacts = array();
                    // Loop through
                    while ($arRow = $db->fetchByAssoc($hQuery)) {
                        // Get the module label
                        $strLabel = $app_list_strings["moduleListSingular"]["Contacts"];
                        // Set the name
                        $strText = "{$arRow["name"]} <" . (!empty($arRow["email_address"]) ? $arRow["email_address"] : "No Email Address") . "> ({$strLabel})";
                        // Get a list of the matches
                        $arContacts[] = array(
                            "id" => "Contacts:{$arRow["id"]}",
                            "text" => $strText,
                            "module" => "Contacts"
                        );
                    }
                    // Determine the count
                    if ($arSignatureDetails["no_of_signers"] == count($arContacts)) {
                        // Set to the contacts
                        $arDefaultSigners = $arContacts;
                    } elseif ($arSignatureDetails["no_of_signers"] == (count($arContacts) + 1)) {
                        // Add the user to the list
                        $arDefaultSigners = $arContacts;
                        // Get the module label
                        $strLabel = $app_list_strings["moduleListSingular"][$current_user->module_dir];
                        // Set the name
                        $strText = "{$current_user->full_name} <" . (!empty($current_user->email1) ? $current_user->email1 : "No Email Address") . "> ({$strLabel})";
                        // Get a list of the matches
                        $arDefaultSigners[] = array(
                            "id" => "{$current_user->module_dir}:{$current_user->id}",
                            "text" => $strText,
                            "module" => $current_user->module_dir
                        );                                                            
                    } else {
                        // Check if we have any contact relate fields
                        foreach ($objParent->field_defs as $arConfig) {
                            // Determine the type
                            if (($arConfig["type"] == "relate") && ($arConfig["module"] == "Contacts") && !empty($arConfig["id_name"])) {
                                // Get the id field
                                $strIdField = $arConfig["id_name"];
                                // Do we have a value?
                                if (!empty($objParent->$strIdField)) {
                                    // Retrieve the contact
                                    $objContact = new Contact();
                                    $objContact->disable_row_level_security = true;
                                    // Retrieve
                                    if ($objContact->retrieve($objParent->$strIdField)) {
                                        // Get the module label
                                        $strLabel = $app_list_strings["moduleListSingular"][$objContact->module_dir];
                                        // Set the name
                                        $strText = "{$objContact->full_name} <" . (!empty($objContact->email1) ? $objContact->email1 : "No Email Address") . "> ({$strLabel})";
                                        // Get a list of the matches
                                        $arDefaultSigners[] = array(
                                            "id" => "{$objContact->module_dir}:{$objContact->id}",
                                            "text" => $strText,
                                            "module" => $objContact->module_dir
                                        );
                                    }
                                }
                            }
                        }
                    }
                    break;

                // Default case
                default:
                    // Create the bean
                    if ($objParent = BeanFactory::newBean($args['parent_module'])) {
                        // Retrieve
                        if ($objParent->retrieve($args['parent_id'])) {
                            // Does this record have an email address?
                            if (!empty($objParent->email1)) {
                                // Do we have just the one signer?
                                if ($arSignatureDetails["no_of_signers"] >= 1) {
                                    // Get the module label
                                    $strLabel = $app_list_strings["moduleListSingular"][$objParent->module_dir];
                                    // Determine the name
                                    $strName = (!empty($objParent->full_name) ? $objParent->full_name : $objParent->name);
                                    // Set the name
                                    $strText = "{$strName} <" . (!empty($objParent->email1) ? $objParent->email1 : "No Email Address") . "> ({$strLabel})";
                                    // Get a list of the matches
                                    $arDefaultSigners[] = array (
                                        "id" => "{$objParent->module_dir}:{$objParent->id}",
                                        "text" => $strText,
                                        "module" => $objParent->module_dir
                                    );
                                }
                                // If we have exactly 2 signers
                                if ($arSignatureDetails["no_of_signers"] == 2) {
                                    // Get the module label
                                    $strLabel = $app_list_strings["moduleListSingular"][$current_user->module_dir];
                                    // Set the name
                                    $strText = "{$current_user->full_name} <" . (!empty($current_user->email1) ? $current_user->email1 : "No Email Address") . "> ({$strLabel})";
                                    // Get a list of the matches
                                    $arDefaultSigners[] = array (
                                        "id" => "{$current_user->module_dir}:{$current_user->id}",
                                        "text" => $strText,
                                        "module" => $current_user->module_dir
                                    ); 
                                }
                            }
                        }
                    }
            }
            // Initialize signers
            $arData = array();
            // Get the signers
            if (!empty($arDefaultSigners)) {
                // Loop through
                foreach ($arDefaultSigners as $arSigner) {
                    // Add to the value
                    $arData[] = $arSigner["id"];
                }
            }                                
            // return data
            return array(
                'no_of_signers' => (!empty($arSignatureDetails["no_of_signers"]) ? intval($arSignatureDetails["no_of_signers"]) : 0),
                'default_signers' => $arDefaultSigners,
                'default_signers_init' => implode(",", $arData),
            );
        }    
        // if we get here, error
        return $arSignatureDetails;
    }
    /**
     * Manually update the documents saved in db from the IntelliDocs platform
     */
    public function UpdateDocuments($api, $args) {
        //get access to globals
        global $db, $timedate;
        // setup intellidocs end point to trigger documents syncing
        $strUrl = Intellidocs::ApiEndpoint . "updatedocument";
        // make a curl request1
        if ($arResponse = IntelliDocs::sendCurlRequest($strUrl)) {
            // do we have documents
            if (!empty($arResponse["documents"])) {
                // Loop through and set the documents
                foreach ($arResponse["documents"] as $arDocument) {
                    //
                }
            }
            // check if document is saved
            $strQuery = "
                    SELECT
                        value
                    FROM
                        config
                    WHERE
                        category = 'intellidocs_config'              
                    AND
                        name = 'last_updated'
            ";
            // Execute
            $hQuery = $db->query($strQuery);
            // get current date
            $strNowDate = $timedate->nowDb();
            // Retrieve the config
            if ($arRow = $db->fetchByAssoc($hQuery)) {
                // Update the config
                $strQuery = "UPDATE config SET value = '{$strNowDate}' WHERE category = 'intellidocs_config' AND name = 'last_updated'";
            } else {
                // Insert the config
                $strQuery = "INSERT INTO config (category, name, value) VALUES ('intellidocs_config', 'last_updated', '{$strNowDate}' )";
            }
            // run query failed?
            if ( $db->query($strQuery) ) {
                // return
                return $strNowDate;   
            }            
        }
        // return error
        return array('error'=>'Error Converting Document');
    }

    
    /**
     * Download document from the Intellidocs platform in different formats
     *
     */
    public function GetDocumentForEmail($api, $args) {
        // require data
        $this->requireArgs($args, array('id', 'format', 'parent_id', 'parent_module'));
        // instantiate intellidocs and retrieve
        $objIntellidoc = BeanFactory::getBean('idoc_documents');
        // Initialize the return data
        $arReturn = array(
            "success" => false,
            "parent_id" => $args["parent_id"],
            "parent_name" => $args["parent_name"],
            "parent_type" => $args["parent_module"],
            "name" => "",
            "description_html" => "",
            "to_addresses" => "",
            "html_body" => "",
            "subject" => "",
            "documents" => array(),
        );        
        // Create the parent object
        if ($objParent = BeanFactory::getBean($args["parent_module"])) {
            // Retrieve
            if ($objParent->retrieve($args["parent_id"])) {
                // Set the name
                $arReturn["parent_name"] = (!empty($objParent->name) ? $objParent->name : $objParent->full_name);
                // Determine the type
                if (!empty($objParent->email1)) {
                    // Set the email
                    $arReturn["to_addresses"][] = array(
                        "id" => $objParent->id,
                        "email" => $objParent->email1,
                        "module" => $objParent->module_dir,
                        "name" => $arReturn["parent_name"],
                    );
                } elseif (!empty($objParent->account_id) || !empty($objParent->account_id_c)) {
                    // Get the account
                    $strAccountId = (!empty($objParent->account_id) ? $objParent->account_id : $objParent->account_id_c);
                    // Get the account
                    $objAccount = new Account();
                    $objAccount->disable_row_level_security = true;
                    // Retrieve
                    if ($objAccount->retrieve($strAccountId)) {
                        // Do we have the email?
                        if (!empty($objAccount->email1)) {
                            // Set the email
                            $arReturn["to_addresses"][] = array(
                                "id" => $objParent->id,
                                "email" => $objAccount->email1,
                                "module" => $objAccount->module_dir,
                                "name" => $objAccount->name,
                            );
                        }
                    }
                } elseif (!empty($objParent->contact_id) || !empty($objParent->contact_id_c)) {
                    // Get the account
                    $strContactId = (!empty($objParent->contact_id) ? $objParent->contact_id : $objParent->contact_id_c);
                    // Get the account
                    $objContact = new Contact();
                    $objContact->disable_row_level_security = true;
                    // Retrieve
                    if ($objContact->retrieve($strContactId)) {
                        // Do we have the email?
                        if (!empty($objContact->email1)) {
                            // Set the email
                            $arReturn["to_addresses"][] = array(
                                "id" => $objContact->id,
                                "email" => $objContact->email1,
                                "module" => $objContact->module_dir,
                                "name" => $objContact->full_name,
                            );
                        }
                    }
                }
            }
        }
        // retrieve by id and parent id
        if ($objIntellidoc->retrieve_by_string_fields(array('intellidocs_id' => $args['id'], 'parent_id' => $args['parent_id'], 'parent_type' => $args['parent_module']))) {
            // Determine the format
            if ($args["format"] == "original") {
                // Set to success
                $arReturn["success"] = true;
                // Create the document
                $objNote = new Note();
                $objNote->disable_row_level_security = true;
                // Check if it exists
                if (!$objNote->retrieve($objIntellidoc->id)) {
                    // No file yet
                    $objNote->id = $objIntellidoc->id;
                    $objNote->new_with_id = true;
                    $objNote->name = $objIntellidoc->document_name;
                    $objNote->filename = $objIntellidoc->filename;
                    $objNote->parent_type = $objIntellidoc->parent_type;
                    $objNote->parent_id = $objIntellidoc->parent_id;
                    $objNote->file_mime_type = $objIntellidoc->file_mime_type;
                    $objNote->intellidocs_id_c = $objIntellidoc->id;
                    // Save the note
                    $objNote->save();
                }
                // Add the one file
                $arReturn["documents"][] = array(
                    "id" => $objIntellidoc->id,
                    "name" => $objIntellidoc->document_name,
                );
            } else {
                // setup intellidocs download endpoint
                $strUrl = Intellidocs::ApiEndpoint . "convertdocument/{$args['id']}/{$args['format']}/{$args['merge_id']}";
                // make a curl request1
                if ($strContents = IntelliDocs::sendCurlRequest($strUrl)) {    
                    // Generate the filename
                    $strDocName = preg_replace('/[^a-z0-9A-Z|^.]/i', '_', $objIntellidoc->document_name);
                    // instantiate file upload object
                    $objFileUpload = new UploadFile();
                    // Decode the file content and set it for upload
                    $objFileUpload->set_for_soap("{$strDocName}.{$args["format"]}", $strContents);
                    // longreach - added
                    $objFileUpload->create_stored_filename();
                    // Set the extention
                    $objFileUpload->file_ext = $args["format"];
                    // Create the document
                    $objNote = new Note();
                    $objNote->disable_row_level_security = true;
                    // Create the note
                    $strId = $objNote->id = create_guid();
                    $objNote->new_with_id = true;
                    $objNote->name = "{$strDocName}.{$args['format']}";
                    $objNote->filename = "{$strDocName}.{$args['format']}";
                    $objNote->parent_type = $objIntellidoc->parent_type;
                    $objNote->parent_id = $objIntellidoc->parent_id;
                    $objNote->file_mime_type = $objIntellidoc->file_mime_type;
                    $objNote->intellidocs_id_c = $objIntellidoc->id;
                    // Save the note
                    $objNote->save();
                    // Do final move
                    $objFileUpload->final_move($strId);                    
                    // Add the one file
                    $arReturn["documents"][] = array(
                        "id" => $strId,
                        "name" => $objNote->name,
                    );
                }
            }
        }
        // Return the data
        return $arReturn;
    }


    /**
     * Download document from the Intellidocs platform in different formats
     *
     */
    public function ConvertDocument($api, $args) {
        // get access to global variables
        global $current_user;
        // require data
        $this->requireArgs($args, array('id', 'format', 'parent_id', 'parent_module'));
        // instantiate intellidocs and retrieve
        $objIntellidoc = BeanFactory::getBean('idoc_documents');
        // Initialize the return data
        $arReturn = array(
            "success" => false,
            "file_id" => '',
            "download_from_module" => ''
        );
        // retrieve by id and parent id
        if ($objIntellidoc->retrieve_by_string_fields(array('intellidocs_id' => $args['id'], 'parent_id' => $args['parent_id'], 'parent_type' => $args['parent_module']))) {
            // Determine the format
            if ($args["format"] == "original") {
                // Set to success
                $arReturn["success"] = true;                
                // Add the file id
                $arReturn["file_id"] = $objIntellidoc->id;
                // add module
                $arReturn['download_from_module'] = 'idoc_documents';
            } else {
                // setup intellidocs download endpoint
                $strUrl = Intellidocs::ApiEndpoint . "convertdocument/{$args['id']}/{$args['format']}/{$args['merge_id']}";
                // make a curl request
                if ($strContents = IntelliDocs::sendCurlRequest($strUrl)) {
                    // Generate the filename
                    $strDocName = preg_replace('/[^a-z0-9A-Z|^.]/i', '_', $objIntellidoc->document_name);                    
                    // instantiate file upload object
                    $objFileUpload = new UploadFile();
                    // Decode the file content and set it for upload
                    $objFileUpload->set_for_soap("{$strDocName}.{$args["format"]}", $strContents);
                    // longreach - added
                    $objFileUpload->create_stored_filename();
                    // Set the extention
                    $objFileUpload->file_ext = $args['format'];
                    // Create the document
                    $objDocEvent = new idoc_events();
                    $objDocEvent->disable_row_level_security = true;
                    // Create the note
                    $strId = $objDocEvent->id = create_guid();
                    $objDocEvent->new_with_id = true;
                     // Set the doc event filename
                    $objDocEvent->document_name = $objDocEvent->filename = "{$strDocName}.{$args['format']}";
                    // Set the mime type
                    $objDocEvent->file_mime_type = $args['format'];
                    $objDocEvent->file_ext = $args['format'];
                    // Set the parent id
                    $objDocEvent->parent_id = $objIntellidoc->id;
                    // Set the parent name
                    $objDocEvent->parent_type = 'idoc_documents';   
                    // Set assigned user
                    $objDocEvent->assigned_user_id = $objIntellidoc->assigned_user_id;
                    // Set assigned team
                    $objDocEvent->team_id = $objIntellidoc->team_id;
                    // set document status
                    $objDocEvent->document_status = 'document_converted';                    
                    // Save the note
                    $objDocEvent->save();
                    // Do final move
                    $objFileUpload->final_move($strId);
                    // Set to success
                    $arReturn["success"] = true;                
                    // Add the file id
                    $arReturn["file_id"] = $strId;
                    // add module
                    $arReturn['download_from_module'] = 'idoc_events';
                } else {
                    // Throw an exception
                    throw new SugarApiException("Error converting document.");
                }
            }
        }
        // Return the data
        return $arReturn;    }

    /**
     * Handles merged documents return by intellidocs platform
     *
     */
    public function HandleMergedDocuments($api, $args) {
        // set status code to ok
        $intHttpStatusCode = 200;
        // set header
        header("HTTP/1.1 {$intHttpStatusCode}", true, $intHttpStatusCode);
        // return sugar unique key
        return true;
    }
    /**
     * Get Signature Details
     *
     */
    public function GetSignatureDetails($api, $args) {
        // get access to globals
        global $current_user, $timedate, $sugar_config, $db;   
        // // get related document template
        // if ($objDocTemplate = BeanFactory::getBean('idoc_templates', $args['id'])) {

        //     // get contact users
        //     $arDocument['contacts_users'] = $this->getContactsUsers($args["parent_module"], $args["parent_id"]);
        //     // return 
        //     return $arDocument;
        // }
        // query setting using doc id
        $strQuery = "
                SELECT
                        value
                FROM
                        config
                WHERE
                        category = 'intellidocs_config'
                AND
                        name = '{$args['id']}'
        ";
        // Execute
        $hQuery = $db->query($strQuery);
        // Retrieve the config
        if ($arRow = $db->fetchByAssoc($hQuery)) {
            // json decode
            if ( $arDocument = json_decode($arRow['value'], 1) ) {
                // get contact users
                $arDocument['contacts_users'] = $this->getContactsUsers($args["parent_module"], $args["parent_id"]);                
                // return 
                return $arDocument;
            }
        }        
        // if we get to here, return error
        return array('error'=>'No Signature');
    }
    /**
     *
     *
     */
    public function GenerateDocuments($api, $args) {

        // $GLOBALS['log']->info('INTELLIDOCS DATA', $args);
        // get access to globals
        global $sugar_config, $db, $current_user;
        // initialise return data
        $arIntellidocsData = array();
        // instantiate primary module
        $objPrimaryModule = BeanFactory::getBean($args['primary_module']);
        // initialise as string
        $strWhereClause = '';
        // do we have a filter for primary module
        if (array_key_exists($args['primary_module'], $args['related_filters']))
        {
            // build where clause
            $strWhereClause = $this->_buildWhereClause($objPrimaryModule->table_name, $args['related_filters'][$args['primary_module']]);
        }
        // retrieve using where clause
        $objRecords = $objPrimaryModule->get_full_list('', $strWhereClause);
        // loop through records
        foreach ($objRecords as $key => $objBean) {
            // get fields data 
            $arIntellidocsData[]= $this->getFieldsData($args['primary_module'], $objBean->id, $args['intellidocs']['field_maps'], $args['related_filters'], $args['aggregate_fields']);            
        }
        // if Intellidocs data not empty
        if (!empty($arIntellidocsData)) {
            // setup post data
            $arPostData = array(
                // 'license_key' => $sugar_config['unique_key'],
                'records' => $arIntellidocsData
            );
            // json encode the data before passing
            $arPostData = json_encode($arPostData);                       
            // setup intellidocs merge endpoint                            
            $strUrl = IntelliDocs::ApiEndpoint . "mergemulti/{$args['intellidocs']['id']}";
            // make a curl request
            if ($strFileContent = IntelliDocs::sendCurlRequest($strUrl, $arPostData, 'POST') ) {
                // Process the return file content here
                if (!$strFileContent)
                {
                    return json_encode(array("error" => "Invalid File Content"));
                }
                // set filename
                $strFileName = 'Multirecord_' . str_replace(' ', '_', $args['intellidocs']['file_name']);
                // Handle PDF Attachment
                $objFile = new UploadFile('uploadfile');
                // Set the filename
                $objFile->set_for_soap($strFileName, $strFileContent);
                $objFile->create_stored_filename();
                // instantiate intellidocs object
                $objNote = new Note();
                $objNote->id = create_guid();
                $objNote->new_with_id = true;
                $objNote->name = $objNote->filename = $strFileName;
                $objNote->file_mime_type = 'docx';
                $objNote->assigned_user_id = empty($current_user->id) ? $objNote->assigned_user_id : $current_user->id ;                    
                $objNote->team_id = empty($current_user->team_id) ? $objNote->team_id : $current_user->team_id;
                // Do final move
                $objFile->final_move($objNote->id);
                // Save the doc event
                if ($objNote->save()) {
                    // Return success
                    return array(
                        "success" => true,
                        "note_id" => $objNote->id,
                    );
                }                
                // // return file id
                // return array('file_id'=>$arResponse['file_id']);
            }
            // if we get here, error
            return array('error'=>IntelliDocs::$strErrorMessage);
        }
        // return the number of records
        return count($arIntellidocsData);
    }
    /**
     * Test the filters defined 
     *
     * @return Return the number of related records
     */
    public function FiltersTest($api, $args) {        
        // get access to globals
        global $sugar_config, $db;
        // initialise return data
        $arReturnData = array();
        // instantiate primary module
        $objPrimaryModule = BeanFactory::getBean($args['primary_module']);
        // initialise as string
        $strWhereClause = '';
        // do we have a filter for primary module
        if (array_key_exists($args['primary_module'], $args['related_filters']))
        {
            // build where clause
            $strWhereClause = $this->_buildWhereClause($objPrimaryModule->table_name, $args['related_filters'][$args['primary_module']]);
        }        
        // retrieve using where clause
        $objRecords = $objPrimaryModule->get_full_list('',$strWhereClause);
        // loop through records
        foreach ($objRecords as $key => $objBean) {
            // initialise record array
            $arRecord = array(
                'id' => $objBean->id,
                'name' => $objBean->name,
                'related_modules' => array()
            );           
            // loop through each related modules
            foreach ($args['related_modules'] as $strRelatedModule) {
                // if related beans not exist in the array
                if (empty($arRecord['related_modules'][$strRelatedModule])) {                
                    // set it as array
                    $arRecord['related_modules'][$strRelatedModule] = array();
                }
                // get relationship name
                $strRelName = $this->_getRelationshipByModules($args['primary_module'], $strRelatedModule);
                // load relationship
                if ( $objBean->load_relationship($strRelName) ) {
                    // initialise as array
                    $arWhereClause = array();
                    // do we have a filter for related module
                    if (array_key_exists($strRelatedModule, $args['related_filters']))
                    {
                        // build where clause
                        $arWhereClause['where'] = $this->_buildWhereClause(lcfirst($strRelatedModule), $args['related_filters'][$strRelatedModule]);                        
                    }                                   
                    // get related beans
                    $arRelated = $objBean->$strRelName->getBeans($arWhereClause);
                    // if related records no empty
                    if(!empty($arRelated)) {
                        // loop through each related
                        foreach($arRelated as $objRelated) {
                            // add related record
                            $arRecord['related_modules'][$strRelatedModule][] = array(
                                'id' => $objRelated->id,
                                'name' => $objRelated->name,
                                'lead_source' => $objRelated->lead_source
                            );
                        }                        
                    }
                }                
            }     
            // if we get here, add
            $arReturnData[] = $arRecord;   
        }        
        // return the number of records
        return count($arReturnData);
    }
    /**
     * Build where clause to be used in query
     *
     * @param string $strTableName table name
     * @param array $arFilters Filters to be passed
     *
     * @return string the equivalent where clause of the filter
     */
    private function _buildWhereClause($strTableName, $arFilters) {
        // initiase as string
        $strQuery = "";
        // loop through each filters
        foreach ($arFilters as $key => $arFilter) {
            // check if this is a custom field by checking last 2 character
            $strTableName = ( substr($arFilter['field'], -2) == '_c' ) ? "{$strTableName}_cstm"  : $strTableName;                
            // if query not empty
            if (!empty($strQuery)) {
                // add where clause starting with AND
                $strQuery .= " AND {$strTableName}.{$arFilter['field']} {$arFilter['operator']} '{$arFilter['value']}'";
            } else {
                // start where clause
                $strQuery .= "{$strTableName}.{$arFilter['field']} {$arFilter['operator']} '{$arFilter['value']}'";
            }
        }
        // return where clause
        return $strQuery;
    }
    /**
     * Get relationship name by modules
     *
     * @param string $m1,$m2 module name
     *
     * @return string Relationship name
     */
    private function _getRelationshipByModules ($m1, $m2)
    {
      global $db,$dictionary,$beanList;
      $rel = new Relationship;
      if($rel_info = $rel->retrieve_by_sides($m1, $m2, $db)){
        $bean = BeanFactory::getBean($m1);
        $rel_name = $rel_info['relationship_name'];
        foreach($bean->field_defs as $field=>$def){
          if(isset($def['relationship']) && $def['relationship']==$rel_name) {
            // return(array($def['name'], $m1));
            return $def['name'];
          }
        }
      } elseif($rel_info = $rel->retrieve_by_sides($m2, $m1, $db)){
        $bean = BeanFactory::getBean($m2);
        $rel_name = $rel_info['relationship_name'];
        foreach($bean->field_defs as $field=>$def){
          if(isset($def['relationship']) && $def['relationship']==$rel_name) {
            // return(array($def['name'], $m2));
            return $def['name'];
          }
        }
      }
      return(FALSE);
    }
    /**
    * Get Module Information and Intellidocs documents
    */
    public function GetModuleInfo($api, $args) {
        // get access to globals
        global $current_user, $timedate, $app_list_strings, $app_strings, $db;
        // Initialise the data
        $arReturn = array(
            "module_list" => $app_list_strings["moduleList"],
            "module_relationships" => array(),
            "module_fields" => array(),
            "documents" => array()
        );
        // Get the relationship factory
        $objRel = SugarRelationshipFactory::getInstance();
        // Loop through the modules
        foreach ($app_list_strings["moduleList"] as $strModule => $strLabel) {
            // Create the
            if ($objBean = BeanFactory::newBean($strModule)) {
                // Initialize the fields
                $arReturn["module_fields"][$strModule] = array();
                // Get all related objects
                $arLinkedFields = $objBean->get_linked_fields();
                // Loop through each field
                foreach ($arLinkedFields as $strLink => $arDefs) {
                    // Is this a relate field
                    if (!empty($arDefs['relationship']) && !empty($arDefs['name'])) {
                        // Ignore certain built in relationships
                        if (stristr($arDefs['relationship'], "favorite") || stristr($arDefs['relationship'], "following") ||
                            stristr($arDefs['relationship'], "created_by") || stristr($arDefs['relationship'], "modified_user") ||
                            stristr($arDefs['relationship'], "assigned_user") || stristr($arDefs['relationship'], "idocs_intellidocs") ||
                            stristr($arDefs['relationship'], "currencies") || stristr($arDefs['relationship'], "forecastworksheets") ||
                            stristr($arDefs['relationship'], "activities") || stristr($arDefs['relationship'], "team") ||
                            stristr($arDefs['relationship'], "email_addresses")) {
                            // Ignore this relationship
                            continue;                            
                        }
                        // Set the link
                        $strRelationship = $arDefs['relationship'];
                        // Set the link name
                        $strLinkName = $arDefs['name'];                        
                        // Is this relationship defined?
                        if ($arRelationship = $objRel->getRelationshipDef($strRelationship)) {
                            // Is this related to the target module?
                            if (($arRelationship['lhs_module'] == $objBean->module_dir) && in_array($arRelationship['relationship_type'], array("one-to-many", "many-to-many"))) {
                                // Get the other module
                                $strOtherModule = (($arRelationship['lhs_module'] == $objBean->module_dir) ? $arRelationship['rhs_module'] : $arRelationship['lhs_module']);
                                // Add the relationship
                                $arReturn["module_relationships"][$strModule][$strRelationship] = array(
                                    "module" => $strOtherModule,
                                    "label" => $app_list_strings["moduleList"][$strOtherModule],
                                );
                            }
                        }
                    }
                }
                // Get the module strings
                $mod_strings = return_module_language("en_us", $strModule);
                // Loop through the fields
                foreach ($objBean->field_defs as $strField => $arDef) {
                    // Determine the type
                    switch ($arDef["type"]) {
                        // These are the types we support
                        case "date":
                        case "datetime":
                        case "enum":
                        case "bool":
                        case "int":
                        case "decimal":
                        case "currency":
                            // Add the strings
                            if (!empty($arDef["vname"]) && (!empty($mod_strings[$arDef["vname"]]) || !empty($app_strings[$arDef["vname"]]))) {
                                // Add to the list
                                $arReturn["module_fields"][$strModule][$strField] = array(
                                    "type" => $arDef["type"],
                                    "label" => (!empty($mod_strings[$arDef["vname"]]) ? $mod_strings[$arDef["vname"]] : $app_strings[$arDef["vname"]]),
                                    "options" => array(),
                                );
                                // Dropdown field?
                                if (($arDef["type"] == "enum") && !empty($app_list_strings[$arDef["options"]])) {
                                    // Set the options
                                    $arReturn["module_fields"][$strModule][$strField]["options"] = $app_list_strings[$arDef["options"]];
                                }
                            }
                            break;
                    }
                }
            }
        }
        // initialize document holder as array
        $arDocuments = array();
        // intialise template module
        $objDocTemplate = BeanFactory::getBean('idoc_templates');        
        // get alld template list
        $objRecords = $objDocTemplate->get_full_list('');        
        // loop through 
        foreach ($objRecords as $objBean) {
            // add to list
            $arDocuments[$objBean->id] = array(
                'id' => $objBean->id,
                'name' => $objBean->name,
                'status' => $objBean->status,
                'file_name' => $objBean->file_name,
                'file_type' => $objBean->file_type,
                'field_maps' => json_decode($objBean->field_map, true),
                'module' => $objBean->parent_module,
                'no_of_signers' => $objBean->no_of_signers,
                'allow_email' => $objBean->allow_email,
                'allow_download' => $objBean->allow_download,
                'output_format_pdf' => $objBean->output_format_pdf,
                'output_format_orig' => $objBean->output_format_orig,                
            );
        }        
        // assign documents 
        $arReturn['documents'] = $arDocuments;
        // If we get to here, we have an error
        return $arReturn;
    }

    /**
     *  Cancels document sent to Electronic Signing
     *
     */
    public function CancelSigning($api, $args) {
        // get access to globals
        global $sugar_config;
        // instantiate intellidocs record and retrieved
        if ( $objIntellidocs = BeanFactory::getBean('idoc_documents', $args['id']) ) {
            // check status and signature request id
            if (($objIntellidocs->document_status == 'sent_for_signing' || $objIntellidocs->document_status == 'signature_request_viewed') && !empty($objIntellidocs->signature_request_id)) {
                // prepare the post data for Intellidocs
                $arPostData = array(
                    'license_key' => $sugar_config['unique_key'],
                    'signature_request_id' => $objIntellidocs->signature_request_id, 
                );                
                // json encode the data before passing
                $arPostData = json_encode($arPostData);
                // setup intellidocs merge endpoint                            
                $strUrl = IntelliDocs::ApiEndpoint . "cancelsignature";
                // make a curl request
                if ($arResponse = IntelliDocs::sendCurlRequest($strUrl, $arPostData, 'POST') ) {                    
                    // is success?
                    if ($arResponse['success']) {
                        // set the status of the document back to merged
                        $objIntellidocs->document_status = 'merged';
                        // save
                        $objIntellidocs->save();
                        // add an event for esign canceled
                        $objDocEvent = BeanFactory::getBean('idoc_events');
                        $objDocEvent->new_with_id = true;
                        $objDocEvent->id = create_guid();
                        // set name and document name
                        $objDocEvent->name = $objDocEvent->document_name = "Signature Cancelled: " . $objIntellidocs->document_name;
                        // Set the parent id
                        $objDocEvent->parent_id = $objIntellidocs->id;
                        // Set the parent name
                        $objDocEvent->parent_type = 'idoc_documents';                           
                        // Set assigned user
                        $objDocEvent->assigned_user_id = $objIntellidocs->assigned_user_id;
                        // Set assigned team
                        $objDocEvent->team_id = $objIntellidocs->team_id;
                        // set document status
                        $objDocEvent->document_status = 'signature_cancelled';
                        // save event
                        $objDocEvent->save();
                        // return response
                        return json_encode(array("success" => $arResponse['success']));
                    }
                }
                // if we get to here, error
                return json_encode(array("error" => IntelliDocs::$strErrorMessage));
            }
        }
    }
    /**
     * Private function that gets the license key saved in config table
     */
    public function GetLastSync() {
        // get access to globals
        global $current_user, $db;
        // build query to get intellidocs configuration
        $strQuery = "SELECT 
                    value
                FROM  
                    config 
                WHERE 
                    category =  'intellidocs_config'
                AND
                    name = 'last_updated'                
        ";
        // Execute
        $hQuery = $db->query($strQuery);
        // retrieve
        if ($arRow = $db->fetchByAssoc($hQuery)) {
            // return license key if exist, otherwise return false
            return $arRow['value'];
        }
    }
    /**
     * Delete related Intellidoc
     */
    public function DeleteRelatedIntellidoc($api, $args) {
        // require data
        $this->requireArgs($args, array('id', 'parent_id'));
        // get access to globals
        global $current_user, $db;
        // instantiate intellidocs and retrieve
        $objIntellidoc = BeanFactory::getBean('idoc_documents');
        // retrieve by id and parent id
        if ( $objIntellidoc->retrieve_by_string_fields( array('intellidocs_id' => $args['id'], 'parent_id' => $args['parent_id'] ) ) ) {
            // set deleted to true
            $objIntellidoc->deleted = 1;
            // save
            if ($objIntellidoc->save() ) {
                // success
                return true;
            }
            // if we get here, error
            return false;               
        }       
        // return
        return false;
    }
    
    /**
     * Get all intellidocs related to a record
     */
    public function GetRelatedIntellidocs($api, $args) {
        // require data
        $this->requireArgs($args, array('record_id', 'module'));
        // get access to globals
        global $current_user, $db, $timedate, $app_list_strings;
        // build query to get all related intellidocs                
        // initialize return as array
        $arIntellidocs = array(
            'documents' => array(),
            'document_templates' => array(),
            'default_addresses' => array(),
            'enable_lob' => 0,
        );        
        // initialise params
        $arParams = array(
            'parent_module' => $args['module']
        );
        // initialise 
        $arDocuments = array();
        // get all the document templates
        if ( $arDocumentTemplates = $this->GetDocuments(null,$arParams) ) {
            // transform to 
            foreach ($arDocumentTemplates as $arDocument) {
                // we only need the id and the value
                $arDocuments[$arDocument['id']] = array(                        
                    'name' => $arDocument['name'],
                    'file_type' => $arDocument['file_type'],
                    'allow_email' => $arDocument['allow_email'],
                    'allow_download' => $arDocument['allow_download'],
                    'no_of_signers' => $arDocument['no_of_signers'],
                    'output_format_pdf' => $arDocument['output_format_pdf'],
                    'output_format_orig' => $arDocument['output_format_orig'],
                    'field_maps' => $arDocument['field_map']
                );
            }
            // add to the returned data
            $arIntellidocs['document_templates'] = $arDocuments;
        }
        // instantiate related record and retrieve
        if ( $objRelated = BeanFactory::getBean($args['module'], $args['record_id']) ) {
            // initialise address array
            $arAddresses = array();
            // get addresses field
            $arIntellidocs['default_addresses'] = $this->_getRecordAddresses($args['module'], $args['record_id']);
            // initialise query to get all active intellidocs
            $strQuery = "SELECT
                            id,
                            intellidocs_id,
                            document_name,
                            file_ext,                                             
                            document_status
                        FROM
                            idoc_documents
                        WHERE
                            parent_type = '{$args['module']}'
                        AND
                            parent_id = '{$args['record_id']}'
                        AND
                            deleted = 0
                        ORDER BY
                            date_modified
                        DESC
            ";
            // Execute query
            $hQuery = $db->query($strQuery);
            // retrieve
            while ($arRow = $db->fetchByAssoc($hQuery)) {                 
                // if intellidocs id not yet added
                if (empty($arIntellidocs['documents'][$arRow['intellidocs_id']] )) {                                 
                    // set the first letter to uppercase and replace _ to whitespace
                    $arRow['document_status'] = ucfirst( str_replace("_", " ", $arRow['document_status']));
                    // get related document template
                    if ($objDocTemplate = BeanFactory::getBean('idoc_templates', $arRow['intellidocs_id'] )) {
                        // get related signers
                        $arSignatureDetails = $this->_getRelatedSigners($arRow['intellidocs_id'], $objRelated);
                        // iniatialise and add to array
                        $arIntellidocs['documents'][$arRow['intellidocs_id']] = array(    
                            'id' => $arRow['id'],
                            'document_name' => $arRow['document_name'],
                            'name' => $arRow['document_name'],
                            'file_ext' => $arRow['file_ext'],
                            'document_status' => $arRow['document_status'],                                    
                            "no_of_signers" =>  (!empty($arSignatureDetails["no_of_signers"]) ? intval($arSignatureDetails["no_of_signers"]) : 0),                                    
                            "default_signers" => $arSignatureDetails['default_signers'],
                            "default_signers_init" => $arSignatureDetails['default_signers_init'],
                            'download_url' => "rest/v10/idoc_documents/{$arRow['id']}/file/uploadfile?force_download=1&platform=base",
                            'doc_event_id' => '',
                            'allow_email' => $arIntellidocs['document_templates'][$arRow['intellidocs_id']]['allow_email'],
                            'allow_download' => $arIntellidocs['document_templates'][$arRow['intellidocs_id']]['allow_download'],
                            'output_format_orig' => $arIntellidocs['document_templates'][$arRow['intellidocs_id']]['output_format_orig'],
                            'output_format_pdf' => $arIntellidocs['document_templates'][$arRow['intellidocs_id']]['output_format_pdf'],                            
                            'events' => array(),
                        );
                    }                       
                }
                // get user date time format
                $objUserDateTimePref = $current_user->getUserDateTimePreferences();
                // setup query to get the related events
                $strEventQuery = "SELECT
                                    id,
                                    document_name,
                                    document_status,
                                    file_ext,                                                           
                                    date_entered,
                                    modified_user_id                           
                                FROM
                                    idoc_events                    
                                WHERE
                                    deleted = 0     
                                AND
                                    parent_id = '{$arRow['id']}'
                                ORDER BY
                                    date_entered
                                DESC                 
                ";
                // Execute query
                $hEventQuery = $db->query($strEventQuery);
                // retrieve
                while ($arEventRow = $db->fetchByAssoc($hEventQuery)) {
                    // do we have the latest doc event
                    if (empty($arIntellidocs['documents'][$arRow['intellidocs_id']]['doc_event_id'])) {
                        // add
                        $arIntellidocs['documents'][$arRow['intellidocs_id']]['doc_event_id'] = $arEventRow['id'];
                    }
                    // Is this the first value?
                    if (empty($arIntellidocs['documents'][$arRow['intellidocs_id']]['events']) && ($arEventRow['document_status'] == "signed")) {
                        // Set the URL
                        $arIntellidocs['documents'][$arRow['intellidocs_id']]['download_url'] = "rest/v10/idoc_events/{$arEventRow['id']}/file/uploadfile?force_download=1&platform=base";
                    }
                    // if added events are not 5 in total
                    if (count($arIntellidocs['documents'][$arRow['intellidocs_id']]['events']) < $args['timeline_limit'] ) { 
                        // convert to user timezone first
                        $strRecordDate = $timedate->to_display_date_time($arEventRow['date_entered']);  
                        $strUserTimezone = $current_user->getPreference('timezone');
                        $objUserTimezone = new DateTimeZone($strUserTimezone);
                        // create DateTime object from the value of date in DB
                        $objDate = SugarDateTime::createFromFormat($timedate->get_date_format($current_user) . " " . $timedate->get_time_format($current_user), $strRecordDate, $objUserTimezone);
                        // // get ISO format for date
                        $arEventRow['date_entered'] = $timedate->asIso($objDate, $current_user);
                        // // create DateTime object from the value of date in DB
                        // $objDate = DateTime::createFromFormat("Y-m-d H:i:s", $arEventRow['date_entered']);                                         
                        // get ISO format for date
                        // $arEventRow['date_entered'] = $timedate->asIso($objDate,BeanFactory::getBean('Users', $current_user->id));
                        // Set the status
                        $arEventRow['document_status_label'] = (!empty($app_list_strings["idoc_document_status_list"][$arEventRow['document_status']]) ? $app_list_strings["idoc_document_status_list"][$arEventRow['document_status']] : "Unknown Event - {$arEventRow['document_status']}");
                        // create new User object and retrieve
                        if ( $objUser = BeanFactory::getBean('Users', $arEventRow['modified_user_id']) ) {
                            // assign user full name
                            $arEventRow['modified_user_name'] = $objUser->full_name;
                            // Set the default description
                            $arEventRow['description'] = "by {$arEventRow['modified_user_name']}";
                        }
                        // Initialize the badge icon and colour
                        $arEventRow["badge_colour"] = "";
                        $arEventRow["badge_icon"] = "";
                        // Determine the document status
                        switch ($arEventRow['document_status']) {
                            // Determine the event
                            case "manually_uploaded":
                                // Document merged
                                $arEventRow["badge_icon"] = "icon-upload fa-cloud-upload";
                                $arEventRow["badge_colour"] = "info";
                                break;
                            // Determine the event
                            case "document_converted":
                                // Document merged
                                $arEventRow["badge_icon"] = "icon-gear fa-file-pdf-o";
                                $arEventRow["badge_colour"] = "info";
                                break;
                            // Determine the event
                            case "merged":
                                // Document merged
                                $arEventRow["badge_icon"] = "icon-gear fa-gear";
                                $arEventRow["badge_colour"] = "info";
                                break;                                
                            // Determine the event
                            case "sent_for_signing":
                                // Document merged
                                $arEventRow["badge_icon"] = "icon-envelope fa-envelope-o";
                                $arEventRow["badge_colour"] = "info";
                                break;                                
                            // Determine the event
                            case "signature_request_viewed":
                                // Document merged
                                $arEventRow["badge_icon"] = "icon-eye-open fa-eye";
                                $arEventRow["badge_colour"] = "info";
                                // Update to use the associated document name
                                $arEventRow['description'] = str_replace("_", " ", $arEventRow['document_name']);
                                break;                                
                            // Determine the event
                            case "partially_signed":
                                // Document merged
                                $arEventRow["badge_icon"] = "icon-pencil fa-pencil";
                                $arEventRow["badge_colour"] = "primary";
                                // Update to use the associated document name
                                $arEventRow['description'] = str_replace("_", " ", $arEventRow['document_name']);
                                break;                                
                            // Determine the event
                            case "signed":
                                // Document merged
                                $arEventRow["badge_icon"] = "icon-check fa-check-circle";
                                $arEventRow["badge_colour"] = "success";
                                break;
                            case "letter_sent":
                                // Letter sent
                                $arEventRow["badge_icon"] = "icon-envelope fa-envelope";
                                $arEventRow["badge_colour"] = "info";
                                break;
                            case "signature_cancelled":
                                // Letter sent
                                $arEventRow["badge_icon"] = "icon-reply fa-reply";
                                $arEventRow["badge_colour"] = "danger";
                                break;                                
                            // Determine the event
                            case "signature_error":
                                // Document merged
                                $arEventRow["badge_icon"] = "icon-times-circle fa-times-circle";
                                $arEventRow["badge_colour"] = "danger";
                                break;
                        }
                        // Is this the first value?
                        if (in_array($arEventRow['document_status'], array("signed", "partially_signed"))) {
                            // Set the URL
                            $arEventRow['download_url'] = "rest/v10/idoc_events/{$arEventRow['id']}/file/uploadfile?force_download=1&platform=base";
                        }
                        // add events to the intellidocs
                        $arIntellidocs['documents'][$arRow['intellidocs_id']]['events'][] = $arEventRow;                        
                    } else {

                        $arIntellidocs['documents'][$arRow['intellidocs_id']]['events'][] = array(
                            'exceedlimit' => true
                        );
                        // break in the loop
                        break;
                    }
                }
            }
            // initialise 
            $intEnableLob = 0;            
            // instantiate
            $objAdmin = new Administration();
            // retrieve intellidocs config
            $objAdmin->retrieveSettings('intellidocs_config');
            // assign lob setting
            $arIntellidocs['enable_lob'] = !empty($objAdmin->settings['intellidocs_config_enable_lob']) ? 1 : 0;                                    
            // if we have 
            // if (count($arIntellidocs['documents']) > 0) {
                // return Intellidocs
                return $arIntellidocs;   
            // }       
        }
        // if we get to here
        return false;        
    }
    /**
     * Get the intellidocs settings
     *
     */    
    public function GetIntellidocsSettings($api, $args) {
        // get access to globals
        global $current_user, $db;
        // build query to get intellidocs configuration
        $strQuery = "SELECT 
                    value
                FROM  
                    config 
                WHERE 
                    category =  'intellidocs_config'
                AND
                    name = 'intellidocs_license_settings'                
        ";
        // Execute
        $hQuery = $db->query($strQuery);
        // retrieve
        if ($arRow = $db->fetchByAssoc($hQuery)) {
            // return the settings
            return $arRow['value'];
        }
        // if we get here, no settings found
        return false;
    }
    /**
     * Validates Intellidocs License
     *
     */
    public function ValidateIntellidocsLicense($api, $args) {        
        // require both license key and expiry date
        $this->requireArgs($args, array('intellidocs_license_key'));
        // get access to globals
        global $db;
        // setup post data
        $arPost = array(
            'license_key' => $args['intellidocs_license_key']            
        );
        $arPostData = json_encode($arPost);
        // setup intellidocs merge endpoint                            
        $strUrl = IntelliDocs::ApiEndpoint . "validatelicense";
        // make a curl request
        if ( $arLicense = IntelliDocs::sendCurlRequest($strUrl, $arPostData, 'POST') ) {
            // setup data and json encode
            $strJsonEncoded = json_encode( array(
                'license_key' => $arLicense['license_key'],
                'expiry_date' => $arLicense['license_expiry_date'],                
            ) );
            // if successful save it to config,
            // check if there's existing config            
            $strQuery = "
                    SELECT
                            value
                    FROM
                            config
                    WHERE
                            category = 'intellidocs_config'
                    AND
                            name = 'intellidocs_license_settings'
            ";
            // Execute
            $hQuery = $db->query($strQuery);
            // Retrieve the config
            if ($arRow = $db->fetchByAssoc($hQuery)) {
                // Update the config
                $strQuery = "UPDATE config SET value = '{$strJsonEncoded}' WHERE category = 'intellidocs_config' AND name = 'intellidocs_license_settings'";
            } else {
                // Insert the config
                $strQuery = "INSERT INTO config (category, name, value) VALUES ('intellidocs_config', 'intellidocs_license_settings', '{$strJsonEncoded}')";
            }
            // run query failed?
            if ( !$db->query($strQuery) ) {
                // return error
                return json_encode(array("error" => 'Failed to save config'));
            }
            // return success
            return json_encode(array("success" => "License is still active and will be expired on " . $arLicense['license_expiry_date']));
        }
        // if we get to here error,
        return json_encode(array("error" => IntelliDocs::$strErrorMessage));
    }
    /**
     * Send the document to signing
     */
    public function SignDocument($api, $args) {
        // die;
        // get access to globals
        global $current_user, $db, $sugar_config;
        // initialise array
        $arSigners = array();        
        $arPostSigners = array();
        // return $args;
        // create the related object and retrieve
        if ($objBean = BeanFactory::getBean($args['parent_module'], $args['parent_id'] )) {            
            // instantiate idoc document object
            $objIntellidoc = BeanFactory::newBean('idoc_documents');
            // retrieve by intellidocs id
            if ($objIntellidoc->retrieve_by_string_fields(array('intellidocs_id' => $args['intellidocs_id'], 'parent_id' => $args['parent_id']) ) ) {    
                // Reset the signing order for current signers
                $db->query("UPDATE idoc_signers SET signing_order = '-1' WHERE idoc_documents_id_c = '{$objIntellidoc->id}'");
                // Before we get started, get a list of all current signers linked to this intellidoc
                $strQuery = "SELECT id, parent_type, parent_id FROM idoc_signers WHERE deleted = '0' AND idoc_documents_id_c = '{$objIntellidoc->id}'";
                // Execute
                $hQuery = $db->query($strQuery);
                // Initialise existing signers
                $arExistingSigners = array();
                // Get the list of signers
                while ($arSigner = $db->fetchByAssoc($hQuery)) {
                    // Add to the list
                    $arExistingSigners["{$arSigner["parent_type"]}:{$arSigner["parent_id"]}"] = $arSigner["id"];
                }                
                // Split into an array
                $args['related_contacts'] = explode(",", $args['related_contacts']);
                // Loop through
                foreach ($args['related_contacts'] as $strContact) {
                    // Split the object - can be users, contacts, leads etc
                    $arContact = explode(":", $strContact, 2);
                    // We should have two values
                    if (count($arContact) == 2) {
                        // Set the class
                        $strClass = trim($arContact[0]);
                        $strBeanId = trim($arContact[1]);
                        // Get the bean
                        if ($objBean = BeanFactory::newBean($strClass)) {
                            // Retrieve
                            if ($objBean->retrieve($strBeanId)) {
                                // Initialise the order
                                $intSigningOrder = count($arSigners);
                                // Create the signer record
                                $objSigner = new idoc_signers();
                                $objSigner->disable_row_level_security = true;
                                // Do we have an existing signer link?
                                if (!empty($arExistingSigners["{$strClass}:{$strBeanId}"])) {
                                    // Set the signing order
                                    $objSigner->retrieve($arExistingSigners["{$strClass}:{$strBeanId}"]);
                                } else {
                                    // Set the key data
                                    $objSigner->id = create_guid();
                                    $objSigner->new_with_id = true;
                                    $objSigner->idoc_documents_id_c = $objIntellidoc->id;
                                    $objSigner->parent_type = $strClass;
                                    $objSigner->parent_id = $strBeanId;
                                }
                                // Add to the signers object
                                $arSigners[] = $objBean;
                                // add to post signers
                                $arPostSigners[] = array(
                                    'id' => $objBean->id,
                                    'name' => ($objBean->full_name) ? $objBean->full_name : $objBean->name,
                                    'email_address' => $objBean->email1,                                    
                                );
                                // Set the signing order
                                $objSigner->signing_order = $intSigningOrder;
                                $objSigner->name = "Signer: {$objIntellidoc->document_name}: {$intSigningOrder}";
                                $objSigner->signed = 0;
                                // Add to the signing links array
                                $arSignLinks[] = $objSigner;
                                // $objSigner->save();
                            }
                        }
                    }
                }
                // Initialise the return result
                $arReturn = array (
                    "success" => true,
                    "url" => "",
                );                
                // prepare the post data for Intellidocs
                $arPostData = array(
                    'license_key' => $sugar_config['unique_key'],
                    'id' => $args['intellidocs_id'],
                    'email_subject' => $args['email_subject'],
                    'email_body' => $args['email_body'],                        
                    'in_person' => $args['in_person'],
                    'signers' => $arPostSigners,
                    'completion_url' => IntelliDocs::ApiEndpoint . "trigger_signing/{$objIntellidoc->id}"
                );                
                // json encode the data before passing
                $arPostData = json_encode($arPostData);
                // setup intellidocs merge endpoint                            
                $strUrl = IntelliDocs::ApiEndpoint . "sendtosignature/{$args['intellidocs_id']}";
                // do we have merge id
                $strUrl .= !empty($args['merge_id']) ? "/{$args['merge_id']}": "";
                // make a curl request
                if ( $arResponse = IntelliDocs::sendCurlRequest($strUrl, $arPostData, 'POST') ) {                                        
                    // Store the signer id
                    $strSignatureId = $arResponse["signature_id"];
                    // Do we have an envelope id?
                    if (empty($strSignatureId)) {            
                        // return error result
                        return $arResponse;
                    }
                    // Update the intellidocs values
                    $objIntellidoc->signature_request_id = $strSignatureId;
                    $objIntellidoc->document_status = "sent_for_signing";                        
                    // Save the updated data
                    if ( $objIntellidoc->save() ) {                        
                        // create an event
                        $objDocEvent = BeanFactory::newBean('idoc_events');                                      
                        // Set the doc event filename
                        $objDocEvent->document_name = $objDocEvent->filename = $objIntellidoc->filename . ".docx";
                        // Set the mime type
                        $objDocEvent->file_mime_type = $objIntellidoc->file_mime_type;
                        // set file ext
                        $objDocEvent->file_ext = 'docx';
                        // Set the parent id
                        $objDocEvent->parent_id = $objIntellidoc->id;
                        // Set the parent name
                        $objDocEvent->parent_type = 'idoc_documents';   
                        // Set assigned user
                        $objDocEvent->assigned_user_id = $objIntellidoc->assigned_user_id;
                        // Set assigned team
                        $objDocEvent->team_id = $objIntellidoc->team_id;
                        // set document status
                        $objDocEvent->document_status = 'sent_for_signing';
                        // save
                        $objDocEvent->save();
                        // create file upload object
                        $objFileUpload = new UploadFile();
                        // duplicate file
                        $objFileUpload->duplicate_file($args['doc_event_id'], $objDocEvent->id);                                        
                    }
                    // Loop through the signers
                    if (!empty($arResponse["signature_ids"])) {
                        // Loop through
                        foreach ($arResponse["signature_ids"] as $intIndex => $strSigId) {
                            // We should have a match
                            if (!empty($arSignLinks[$intIndex])) {
                                // Set the signature id
                                $arSignLinks[$intIndex]->signature_id = $strSigId;
                                // Save the updated link
                                $arSignLinks[$intIndex]->save();
                            }
                        }
                    }
                    // set return data
                    $arReturn['success'] = $arResponse['success'];
                    // if in person, set url
                    if ($args['in_person']) {
                        // set the url
                        $arReturn['url'] = IntelliDocs::URI . "trigger_signing/{$arResponse['user_id']}/{$objIntellidoc->id}/{$strSignatureId}";
                        $arReturn['user_id'] = $arResponse['user_id'];
                        $arReturn['id'] = $args['intellidocs_id'];
                        $arReturn['signature_id'] = $strSignatureId;
                    }                    
                    // return success
                    return json_encode($arReturn);
                }                
                // if we get to here, error
                return json_encode(array("error" => IntelliDocs::$strErrorMessage));
            }   
            // if we get here, intellidocs record couldn't retrieved
            return json_encode(array("error" => "Intellidocs record couldn't retrieve"));          
        }
        // if we get here, error
        return json_encode(array("error" => "Parent record couldn't retrieve"));
    }    
    
    /**
     * function to get documents from db
     *
     */
    public function SearchContactsUsers($api, $args) {
        // get access to globals
        global $current_user, $db, $app_list_strings;
        // Ensure that we have valid arguments
        $this->requireArgs($args, array('search'));
        // initialize returned data as array
        $arReturn = array(
            "items" => array(),
        );
        // initialise as string
        $strQuery = '';        
        // loop through list of modules
        foreach ($app_list_strings["moduleList"] as $strModule => $strLabel) {
            // skip these
            if ($strModule == 'Sugar_Favorites' || strpos($strModule, '_') === false) continue;
            // instantiate object
            $objModule = BeanFactory::newBean($strModule);
            // if first, last and email exist we can use it as a signer
            if( array_key_exists('first_name', $objModule->field_defs) &&
                array_key_exists('last_name', $objModule->field_defs) &&
                array_key_exists('email', $objModule->field_defs)
            )
            {
                $strQuery .= "
                (
                    SELECT
                        C.id,
                        CONCAT_WS(' ', C.first_name, C.last_name) as name,
                        '$strModule' as module,
                        EA.email_address
                    FROM
                        $objModule->table_name C
                    LEFT OUTER JOIN
                        email_addr_bean_rel EAB
                    ON
                        C.id = EAB.bean_id
                    AND
                        EAB.bean_module = '$strModule'
                    AND
                        EAB.deleted = '0' 
                    LEFT OUTER JOIN
                        email_addresses EA
                    ON
                        EAB.email_address_id = EA.id
                    AND
                        EA.deleted = '0'
                    WHERE
                        C.deleted = '0'
                    AND
                        CONCAT_WS(' ', C.first_name, C.last_name) LIKE '" . $db->quote($args["search"]) . "%'
                    ORDER BY
                        C.first_name, C.last_name
                )
                ";
            }
        }        
        // Get the list of items that match
        $strQuery .= "
            (
                SELECT
                    C.id,
                    CONCAT_WS(' ', C.first_name, C.last_name) as name,
                    'Contacts' as module,
                    EA.email_address
                FROM
                    contacts C
                LEFT OUTER JOIN
                    email_addr_bean_rel EAB
                ON
                    C.id = EAB.bean_id
                AND
                    EAB.bean_module = 'Contacts'
                AND
                    EAB.deleted = '0' 
                LEFT OUTER JOIN
                    email_addresses EA
                ON
                    EAB.email_address_id = EA.id
                AND
                    EA.deleted = '0'
                WHERE
                    C.deleted = '0'
                AND
                    CONCAT_WS(' ', C.first_name, C.last_name) LIKE '" . $db->quote($args["search"]) . "%'
                ORDER BY
                    C.first_name, C.last_name
            )
            UNION
            (
                SELECT
                    L.id,
                    CONCAT_WS(' ', L.first_name, L.last_name) as name,
                    'Leads' as module,
                    EA.email_address
                FROM
                    leads L
                LEFT OUTER JOIN
                    email_addr_bean_rel EAB
                ON
                    L.id = EAB.bean_id
                AND
                    EAB.bean_module = 'Leads'
                AND
                    EAB.deleted = '0' 
                LEFT OUTER JOIN
                    email_addresses EA
                ON
                    EAB.email_address_id = EA.id
                AND
                    EA.deleted = '0'
                WHERE
                    L.deleted = '0'
                AND
                    CONCAT_WS(' ', L.first_name, L.last_name) LIKE '" . $db->quote($args["search"]) . "%'
                ORDER BY
                    L.first_name, L.last_name
            )
            UNION
            (
                SELECT
                    U.id,
                    CONCAT_WS(' ', U.first_name, U.last_name) as name,
                    'Users' as module,
                    EA.email_address
                FROM
                    users U
                LEFT OUTER JOIN
                    email_addr_bean_rel EAB
                ON
                    U.id = EAB.bean_id
                AND
                    EAB.bean_module = 'Users'
                AND
                    EAB.deleted = '0' 
                LEFT OUTER JOIN
                    email_addresses EA
                ON
                    EAB.email_address_id = EA.id
                AND
                    EA.deleted = '0'
                WHERE
                    U.deleted = '0'
                AND
                    CONCAT_WS(' ', U.first_name, U.last_name) LIKE '" . $db->quote($args["search"]) . "%'
                ORDER BY
                    U.first_name, U.last_name
            )
            LIMIT
                0, 20
        ";
        // Execute
        $hQuery = $db->query($strQuery);
        // Loop through
        while ($arRow = $db->fetchByAssoc($hQuery)) {
            // Get the module label
            $strLabel = $app_list_strings["moduleListSingular"][$arRow["module"]];
            // Set the name
            $strText = "{$arRow["name"]} <" . (!empty($arRow["email_address"]) ? $arRow["email_address"] : "No Email Address") . "> ({$strLabel})";
            // Get a list of the matches
            $arReturn["items"][] = array(
                "id" => "{$arRow["module"]}:{$arRow["id"]}",
                "text" => $strText,
                "module" => $arRow["module"]
            );
        }
        // loop through modules
        // foreach (array('Contacts','Leads','Users') as $strModule) {
        //     // convert to lowercase
        //     $strModuleLowercase = strtolower($strModule);
        //     // initialise selected fields
        //     // $arFields = array('id','first_name','last_name','EA.email_address email_address');            
        //     $strFieldRaw = "{$strModuleLowercase}.id id, {$strModuleLowercase}.first_name first_name, {$strModuleLowercase}.last_name last_name, {$strModuleLowercase}.team_set_id team_set_id, EA.email_address email_address";
        //     // instantiate SugarQuery object
        //     $objSugarQuery = new SugarQuery();
        //     // start with contacts
        //     $objSugarQuery->from(  BeanFactory::newBean($strModule),array('team_security'=> true,'deleted' => 0));
        //     $objSugarQuery->select()->fieldRaw($strFieldRaw);
        //     $objSugarQuery->joinTable("email_addr_bean_rel EAB ON {$strModuleLowercase}.id = EAB.bean_id LEFT OUTER JOIN email_addresses EA ON EAB.email_address_id = EA.id");
        //     $objSugarQuery->whereRaw("CONCAT_WS(' ', first_name, last_name) LIKE '".$args['search']."%'");
        //     $objSugarQuery->whereRaw("EAB.bean_module = '{$strModule}'");
        //     $objSugarQuery->whereRaw("EAB.deleted = '0'");            
        //     // execute the query
        //     $arResult = $objSugarQuery->execute();            
        //     // loop through result
        //     foreach ($arResult as $arValue) {
        //         // Set the name
        //         $strText = "{$arValue['first_name']} {$arValue['last_name']} <" . (!empty($arValue["email_address"]) ? $arValue["email_address"] : "No Email Address") . "> ({$strModule})";
        //         // add to array
        //         $arReturn["items"][] = array(
        //             "id" => "{$strModule}:{$arValue['id']}",
        //             "text" => $strText,
        //             "module" => $strModule
        //         );                
        //     }
        // }
        // return documents
        return $arReturn;
    }

    /**
     * function to get documents from db
     *
     */
    public function GetDocuments($api, $args) {        
        // get access to globals
        global $current_user, $db;
        // initialize returned data as array
        $arDocuments = array();      
        $arDocument = array();  
        // intialise template module
        $objDocTemplate = BeanFactory::getBean('idoc_templates');
        // setup where clause, get only those active and is related to the current module
        $strWhereClause = "idoc_templates.parent_module = '{$args['parent_module']}' AND idoc_templates.status='active'";        
        // get list
        $objRecords = $objDocTemplate->get_full_list('', $strWhereClause);        
        // loop through 
        foreach ($objRecords as $objBean) {
            // add to list
            $arDocuments[] = array(
                'id' => $objBean->id,
                'name' => $objBean->name,
                'status' => $objBean->status,
                'file_name' => $objBean->file_name,
                'file_type' => $objBean->file_type,
                'field_maps' => json_decode($objBean->field_map, true),
                'module' => $objBean->parent_module,
                'no_of_signers' => $objBean->no_of_signers,
                'allow_email' => $objBean->allow_email,
                'allow_download' => $objBean->allow_download,
                'output_format_pdf' => $objBean->output_format_pdf,
                'output_format_orig' => $objBean->output_format_orig
            );
        }        
        // return documents
        return $arDocuments;
    }
    /**
    * Get Variables
    */
    public function GetVariables($api, $args) {
        // get access to globals
        global $current_user, $timedate, $current_language, $app_strings, $app_list_strings;
        // Initialise the data
        $arReturn = array(
            "signing" => array(
                "signature1" => array (
                    "label" => "Signature Tag (Signer 1)", 
                    "notation" => "[sig|req|signer1]",
                ),
                "signtext1" => array (
                    "label" => "Text Field (Signer 1)", 
                    "notation" => "[text|req|signer1]",
                ),
                "signinitial1" => array (
                    "label" => "Initial Field (Signer 1)", 
                    "notation" => "[initial|req|signer1]",
                ),
                "signdate1" => array (
                    "label" => "Signature Date (Signer 1)", 
                    "notation" => "[date|req|signer1]",
                ),
                "signature2" => array (
                    "label" => "Signature Tag (Signer 2)", 
                    "notation" => "[sig|req|signer2]",
                ),
                "signtext2" => array (
                    "label" => "Text Field (Signer 2)", 
                    "notation" => "[text|req|signer2]",
                ),
                "signinitial2" => array (
                    "label" => "Initial Field (Signer 2)",
                    "notation" => "[initial|req|signer2]",
                ),
                "signdate2" => array (
                    "label" => "Signature Date (Signer 2)", 
                    "notation" => "[date|req|signer2]",
                ),
            ),
            "fields" => array(),
            "relate_fields" => array(),
            "relate_modules" => array(),
        );
        // Get the relationship factory
        $objRel = SugarRelationshipFactory::getInstance();
        // Ensure that we have valid arguments
        $this->requireArgs($args, array('parent_module', 'parent_id'));
        // Create the
        if ($objBean = BeanFactory::newBean($args['parent_module'])) {
            // Get the labels
            $arLabels = return_module_language($current_language, $objBean->module_dir);
            // Merge the data
            $arLabels = array_merge($arLabels,$app_strings);
            // Add the today tag
            $arReturn["fields"]["today"] = array (
                "label" => "Today",
                "notation" => '{$today}'
            );
            // Add the today tag
            $arReturn["fields"]["merge_time"] = array (
                "label" => "Merge Time",
                "notation" => '{$merge_time}'
            );
            // Add the now tag
            $arReturn["fields"]["now"] = array (
               "label" => "Now (Y-m-d H:i:s)",
               "notation" => '{$now}'
            );
            // Loop through the field defs
            foreach ($objBean->field_defs as $strField => $arConfig) {
                // Ignore links
                if ($arConfig["type"] == "link") {
                    // Ignore this field
                    continue;
                }
                // Ignore links
                if (!in_array($arConfig["type"], array("id"))) {
                    // Do we have a label?
                    $strLabel = (!empty($arLabels[$arConfig["vname"]]) ? trim($arLabels[$arConfig["vname"]], ": ") : $strField);
                    // Add to the list
                    $arReturn["fields"][$strField] = array(
                        "label" => $strLabel,
                        "notation" => '{$' . $strField . '}'
                    );
                }
                // if field type is date or datetime, add unixtime variable
                if ($arConfig['type'] == 'date' || $arConfig['type'] == 'datetime') {
                    // Do we have a label?
                    $strLabel = (!empty($arLabels[$arConfig["vname"]]) ? trim($arLabels[$arConfig["vname"]], ": ") : $strField);
                    // Add to the list
                    $arReturn["fields"]["{$strField}_unixtime"] = array(
                        "label" => "{$strLabel} Unixtime",
                        "notation" => '{$' . $strField . '_unixtime}'
                    );
                }
                // Re-order the fields
                $arReturn["fields"] = $this->sortByLabel($arReturn["fields"]);
                // Is this a relate field
                if (!empty($arConfig["type"]) && ($arConfig["type"] == "relate") && ($arConfig["name"] != $arConfig["id_name"])) {
                    // Ensure that we have a module and id field
                    if (!empty($arConfig["module"]) && !empty($arConfig["id_name"])) {
                        // Retrieve the related field
                        if ($objRelatedBean = BeanFactory::newBean($arConfig['module'])) {
                            // Get the labels
                            $arRelatedLabels = return_module_language($current_language, $objRelatedBean->module_dir);
                            // Merge the data
                            $arRelatedLabels = array_merge($arRelatedLabels, $app_strings);
                            // Do we have a label?
                            $strLabel = (!empty($arLabels[$arConfig["vname"]]) ? trim($arLabels[$arConfig["vname"]], ": ") : $strField);
                            // Initialise the fields
                            $arReturn["relate_fields"][$strField] = array(
                                "label" => $strLabel,
                                "fields" => array()
                            );
                            // Loop through the field defs
                            foreach ($objRelatedBean->field_defs as $strRelateField => $arRelateConfig) {
                                // Ignore links
                                if ($arRelateConfig["type"] == "link") {
                                    // Ignore this field
                                    continue;
                                }
                                // Do we have a label?
                                $strLabel = (!empty($arRelatedLabels[$arRelateConfig["vname"]]) ? trim($arRelatedLabels[$arRelateConfig["vname"]], ": ") : $strRelateField);
                                // Add to the list
                                $arReturn["relate_fields"][$strField]["fields"][$strRelateField] = array(
                                    "label" => $strLabel,
                                    "notation" => '{$' . $strField . "_" . $strRelateField . '}'
                                );
                            }
                            // Reorder the fields
                            $arReturn["relate_fields"][$strField]["fields"] = $this->sortByLabel($arReturn["relate_fields"][$strField]["fields"]);
                        }
                    }
                }
            }
            // get current user
            $objUser = BeanFactory::getBean('Users', $current_user->id);                
            // Get the labels
            $arLabels = return_module_language($current_language, $objUser->module_dir);
            // Merge the data
            $arLabels = array_merge($arLabels, $app_strings);
            // Loop through the user field defs
            foreach ($objUser->field_defs as $strField => $arConfig) {
                // Ignore links
                if ($arConfig["type"] == "link") {
                    // Ignore this field
                    continue;
                }
                // dont include the ff fields
                if (!in_array($strField, array('system_generated_password','user_hash','authenticate_id','sugar_login','pwd_last_changed') )) {                    
                    // Do we have a label?
                    $strLabel = (!empty($arLabels[$arConfig["vname"]]) ? trim($arLabels[$arConfig["vname"]], ": ") : $strField);
                    // Add to the list
                    $arReturn["current_user"][$strField] = array(
                        "label" => $strLabel,
                        "notation" => '{$current_user_' . $strField . '}'
                    );
                }                                    
            }
            // Sort fields
            $arReturn["current_user"] = $this->sortByLabel($arReturn["current_user"]);
            // Get all related objects
            $arLinkedFields = $objBean->get_linked_fields();
            // Loop through each field
            foreach ($arLinkedFields as $strLink => $arDefs) {
                // Is this a relate field
                if (!empty($arDefs['relationship']) && !empty($arDefs['name'])) {
                    // Ignore certain built in relationships
                    if (stristr($arDefs['relationship'], "favorite") || stristr($arDefs['relationship'], "following") ||
                        stristr($arDefs['relationship'], "created_by") || stristr($arDefs['relationship'], "modified_user") ||
                        stristr($arDefs['relationship'], "assigned_user") || stristr($arDefs['relationship'], "idoc_documents") ||
                        stristr($arDefs['relationship'], "currencies") || stristr($arDefs['relationship'], "forecastworksheets") ||
                        stristr($arDefs['relationship'], "activities") || stristr($arDefs['relationship'], "team")) {
                        // Ignore this relationship
                        continue;                            
                    }
                    // Set the link
                    $strRelationship = $arDefs['relationship'];
                    // Set the link name
                    $strLinkName = $arDefs['name'];                        
                    // Is this relationship defined?
                    if ($arRelationship = $objRel->getRelationshipDef($strRelationship)) {
                        // Is this related to the target module?
                        if (($arRelationship['lhs_module'] == $objBean->module_dir) || ($arRelationship['rhs_module'] == $objBean->module_dir)) {
                            // Get the other module
                            $strOtherModule = (($arRelationship['lhs_module'] == $objBean->module_dir) ? $arRelationship['rhs_module'] : $arRelationship['lhs_module']);
                            // Retrieve the related field
                            if ($objOtherBean = BeanFactory::newBean($strOtherModule)) {
                                // Get the labels
                                $arRelatedLabels = return_module_language($current_language, $objOtherBean->module_dir);
                                // Merge the data
                                $arRelatedLabels = array_merge($arRelatedLabels, $app_strings);
                                // Set up the label
                                $strLabel = (!empty($app_list_strings["moduleList"][$objOtherBean->module_dir]) ? $app_list_strings["moduleList"][$objOtherBean->module_dir] : $objOtherBean->module_dir);
                                // Initialise the fields
                                $arReturn["relate_modules"][$strLinkName] = array(
                                    "label" => $strLabel,
                                    "fields" => array()
                                );
                                // Loop through the field defs
                                foreach ($objOtherBean->field_defs as $strRelateField => $arRelateConfig) {
                                    // Ignore links
                                    if (in_array($arRelateConfig["type"], array("id", "link"))) {
                                        // Ignore this field
                                        continue;
                                    }
                                    // Do we have a label?
                                    $strLabel = (!empty($arRelatedLabels[$arRelateConfig["vname"]]) ? trim($arRelatedLabels[$arRelateConfig["vname"]], ": ") : $strRelateField);
                                    // Add to the list
                                    $arReturn["relate_modules"][$strLinkName]["fields"][$strRelateField] = array(
                                        "label" => $strLabel,
                                        "notation" => $strRelateField
                                    );                                    
                                }
                                // Sort the array
                                $arReturn["relate_modules"][$strLinkName]["fields"] = $this->sortByLabel($arReturn["relate_modules"][$strLinkName]["fields"]);
                            }
                        }
                    }
                }
            }
            // return error message
            return json_encode($arReturn);
        }
        // If we get to here, we have an error
        return json_encode(array("error" => "Unable to retrieve record for merging"));
    }

    /**
     * Sorts the given field array by label
     */
    private function sortByLabel($arFieldList) {
        // Generate the list of fields indexed by labe;
        $arLabels = $arLabelIndexed = $arFinal = array();
        // Loop through
        foreach ($arFieldList as $strField => $arConfig) {
            // Do we have a label?
            if (!empty($arConfig["label"])) {
                // Add to the labels
                $arLabels[] = $arConfig["label"];
                // Add the indexed
                $arLabelIndexed[$arConfig["label"]] = array(
                    "field" => $strField,
                    "label" => $arConfig["label"],
                    "notation" => $arConfig["notation"],
                );
            }
        }
        // Sort the list
        sort($arLabels);
        // Now, loop through and restore the ordered array
        foreach ($arLabels as $strLabel) {
            // Add to the final list
            $arFinal[] = $arLabelIndexed[$strLabel];
        }
        // Return the data
        return $arFinal;
    }

    /**
    * Send request to merge
    */
    private function getContactsUsers($strParentModule, $strParentId) {
        // get access to globals
        global $current_user, $timedate, $db;
        // Get the relationship factory
        $objRel = SugarRelationshipFactory::getInstance();
        // Initialise the contacts
        $arContacts = array();
        // Create the seed object
        if ($objBean = BeanFactory::newBean($strParentModule)) {
            // Initialize existing contacts
            $arExistingContacts = array();
            // Determine the parent module
            if ($objBean->retrieve($strParentId)) {
                // Do we have a name field?
                if (!empty($objBean->full_name)) {
                    // Return this record directly
                    $arContacts[$objBean->full_name] = array(
                        "id" => "{$objBean->module_dir}:{$objBean->id}",
                        "text" => $objBean->full_name,
                    );
                }
                // Get the any additional items
                $arLinkedFields = $objBean->get_linked_fields();
                // Loop through each field
                foreach ($arLinkedFields as $strLink => $arDefs) {
                    // Is this a relate field
                    if (!empty($arDefs['relationship']) && !empty($arDefs['name'])) {
                        // Ignore certain built in relationships
                        if (stristr($arDefs['relationship'], "favorite") || stristr($arDefs['relationship'], "following") ||
                            stristr($arDefs['relationship'], "created_by") || stristr($arDefs['relationship'], "modified_user") ||
                            stristr($arDefs['relationship'], "assigned_user") || stristr($arDefs['relationship'], "idoc_documents") ||
                            stristr($arDefs['relationship'], "currencies") || stristr($arDefs['relationship'], "forecastworksheets") ||
                            stristr($arDefs['relationship'], "activities") || stristr($arDefs['relationship'], "team")) {
                            // Ignore this relationship
                            continue;                            
                        }
                        // Set the link
                        $strRelationship = $arDefs['relationship'];
                        // Set the link name
                        $strLinkName = $arDefs['name']; 
                        // Is this relationship defined?
                        if ($arRelationship = $objRel->getRelationshipDef($strRelationship)) {
                            // Is this related to the target module?
                            if (($arRelationship['lhs_module'] == "Contacts") || ($arRelationship['rhs_module'] == "Contacts")) {
                                // Load the relationship
                                if ($objBean->load_relationship($strLinkName)) {
                                    // Get the related contacts
                                    $arRelated = $objBean->$strLinkName->getBeans(array("limit" => "20"));
                                    // Do we have any values?
                                    if (!empty($arRelated)) {
                                        // Loop through
                                        foreach ($arRelated as $objContact) {
                                            // Add to the list
                                            $arExistingContacts[$objContact->id] = $objContact->id;
                                            // Add the value
                                            $arContacts[$objContact->full_name] = array(
                                                "id" => "{$objContact->module_dir}:{$objContact->id}",
                                                "text" => $objContact->full_name,
                                                "default" => true,
                                            );
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
            // Set the account
            $strAccountId = "";
            // Do we have any account links?
            if (!empty($objBean->account_id)) {
                // Set the account id
                $strAccountId = $objBean->account_id;
            } elseif (!empty($objBean->account_id_c)) {
                // Set the account id
                $strAccountId = $objBean->account_id_c;
            }
            // Do we have an account?
            if (!empty($strAccountId)) {
                // Get the related contacts
                $strQuery = "SELECT C.id, CONCAT_WS(' ', C.first_name, C.last_name) as name FROM contacts C LEFT JOIN accounts_contacts AC ON AC.contact_id = C.id WHERE C.deleted = '0' AND AC.deleted = '0' AND AC.account_id = '{$strAccountId}' ORDER BY C.first_name, C.last_name";
                // Execute
                $hQuery = $db->query($strQuery);
                // Loop through
                while ($arRow = $db->fetchByAssoc($hQuery)) {
                    // Existing contact already?
                    if (empty($arExistingContacts[$arRow["id"]])) {
                        // Set the id
                        $arExistingContacts[$arRow["id"]] = $arRow["id"];
                        // Add to the list
                        $arContacts[$arRow["name"]] = array(
                            "id" => "Contacts:{$arRow["id"]}",
                            "text" => $arRow["name"],
                            "default" => false,
                        );
                    }
                }
            }
            // Add other users
            $strQuery = "SELECT id, CONCAT_WS(' ', first_name, last_name) as name FROM users WHERE deleted = '0' AND user_name NOT LIKE 'template_%' ORDER BY first_name, last_name";
            // Execute
            $hQuery = $db->query($strQuery);
            // Loop through
            while ($arRow = $db->fetchByAssoc($hQuery)) {
                // Add to the list
                $arContacts[$arRow["name"]] = array(
                    "id" => "Users:{$arRow["id"]}",
                    "text" => $arRow["name"],
                    "default" => ($current_user->id == $arRow["id"]),
                );
            }
            // Sort the array
            ksort($arContacts);
            // Return the contacts
            return array_values(array_reverse($arContacts));

            // // setup intellidocs to get the signature detail
            // $strUrl = IntelliDocs::ApiEndpoint . "getsignaturedetails/{$args['id']}";
            // // make a curl request
            // $arResponse = IntelliDocs::sendCurlRequest($strUrl); 
            // // return error message
            // return json_encode(array(
            //     "records" => array_values(array_reverse($arContacts)),
            //     "signature_details" => $arResponse,
            // ));
        }
        // Error generating data
        return false;
    }

    /**
     * function to sync intellidocs to local db
     *
     */
    public function SyncIntellidocs($api, $args) {
        // get access to globals
        global $current_user, $timedate, $sugar_config, $db, $app_strings, $app_list_strings;
        // initialize array of modules to exclude
        $arExcludeModules = array('Reports','Emails','EmailTemplates','Campaigns','Forecasts', 'KBDocuments', 'Documents', 'Bugs','Calls','Meetings', 'TrackerSessions', 'TrackerPerfs', 'TrackerQueries', 'EAPM', 'WebLogicHooks', 'Tags', 'PdfManager', 'KBContents');
        // initialize as array
        $arModules = array();
        // loop through modules
        foreach ($current_user->getDeveloperModules() as $strModule) {
            // skip if visibility is read_only
            if (in_array($strModule, $arExcludeModules)) continue;
            // add it to array
            $arModules[$strModule] = $app_list_strings['moduleList'][$strModule];
        }
        // initialize as array
        $arErrors = array();        
        // if documents not empty
        if (!empty($args['intellidocs']['documents'])) {
            // Initialize document ids
            $arDocumentIds = array();
            // Loop through the documents
            foreach ($args['intellidocs']['documents'] as $arDocument) {
                // Add to the ids
                $arDocumentIds[] = $arDocument["id"];
            }
            // initialise flexidocs template module
            $objDocTemplate = BeanFactory::getBean('idoc_templates');
            $objDocTemplate->disable_row_level_security = true;
            // build where clause to get all the deleted documents
            $strWhereDeleted = "idoc_templates.id NOT IN('" . implode($arDocumentIds, "', '") . "')";              
            // get list
            $objRecords = $objDocTemplate->get_full_list('', $strWhereDeleted);                        
            // do we have result?
            if (!empty($objRecords)) {
                // loop through it and mark as deleted
                foreach ($objRecords as $objBean) {
                    // flag as deleted
                    $objBean->mark_deleted();
                    // save
                    $objBean->save();
                }
            }            
            // loop through
            foreach ($args['intellidocs']['documents'] as $objDocument) { 
                // determine output format
                $bOutputPdf = in_array('pdf', $objDocument['output_format']) ? 1 : 0;
                $bOutputOrig = in_array($objDocument['file_type'], $objDocument['output_format']) ? 1 : 0;
                $bEnableMail = ($objDocument['enable_mail']) ? 1 : 0;
                $bAllowEmail = ($objDocument['allow_email']) ? 1 : 0;
                $bAllowDownload = ($objDocument['allow_download']) ? 1 : 0;
                // check if document template exist
                $strQuery = "
                        SELECT
                            *
                        FROM
                            idoc_templates
                        WHERE
                            id = '{$objDocument['id']}'                        
                ";
                // Execute
                $hQuery = $db->query($strQuery);                
                // Retrieve and if exist
                if ($arRow = $db->fetchByAssoc($hQuery)) {                    
                    // Update the template
                    $strQuery = "UPDATE 
                                    idoc_templates 
                                SET 
                                    deleted = 0, 
                                    name = '{$objDocument['name']}', 
                                    parent_module = '{$objDocument['module']}',
                                    file_name = '{$objDocument['file_name']}',
                                    status = '{$objDocument['status']}',
                                    file_type = '{$objDocument['file_type']}',
                                    no_of_signers = {$objDocument['no_of_signers']},
                                    field_map = '" . $objDocument['field_maps'] . "',
                                    enable_mail = $bEnableMail,
                                    allow_email = $bAllowEmail,
                                    allow_download = {$bAllowDownload},
                                    output_format_pdf = {$bOutputPdf},
                                    output_format_orig = {$bOutputOrig},
                                    team_id = 1,
                                    team_set_id = 1,
                                    assigned_user_id = 1    
                                WHERE 
                                    id = '{$objDocument['id']}'";
                } else {
                    // Insert the config
                    $strQuery = "INSERT INTO 
                                    idoc_templates (id, deleted, name, parent_module, file_name, status, file_type, no_of_signers, field_map, enable_mail, allow_email, allow_download, output_format_pdf, output_format_orig, team_id, team_set_id, assigned_user_id) 
                                VALUES 
                                    ('{$objDocument['id']}', 0, '{$objDocument['name']}', '{$objDocument['module']}', '{$objDocument['file_name']}', '{$objDocument['status']}', '{$objDocument['file_type']}', {$objDocument['no_of_signers']}, '" . $objDocument['field_maps'] . "', $bEnableMail, $bAllowEmail, $bAllowDownload, $bOutputPdf, $bOutputOrig, 1, 1, 1 )";
                }
                // run query failed?
                if ( !$db->query($strQuery) ) {
                    // set status code to 400
                    $intHttpStatusCode = 400;
                    // set header
                    header("HTTP/1.1 {$intHttpStatusCode}", true, $intHttpStatusCode);            
                    // return sugar unique key
                    return array(
                        'error' => "Error syncing document templates",
                    );
                } 
                // // if doesn't exist
                // $objDocTemplate = BeanFactory::getBean('idoc_templates', $objDocument['id']);
                // // do we have an id
                // if ($objDocTemplate->id != $objDocument['id']) {

                //     $GLOBALS['log']->fatal($objDocTemplate->id,$objDocument['id']);
                //     // new record
                //     $objDocTemplate->new_with_id = true;
                //     // set id
                //     $objDocTemplate->id = $objDocument['id'];
                // } 
                // // update other details
                // $objDocTemplate->deleted = 0;
                // $objDocTemplate->name = $objDocument['name'];
                // $objDocTemplate->parent_module = $objDocument['module'];
                // $objDocTemplate->file_name = $objDocument['file_name'];
                // $objDocTemplate->status = $objDocument['status'];
                // $objDocTemplate->file_type = $objDocument['file_type'];
                // $objDocTemplate->no_of_signers = $objDocument['no_of_signers'];
                // $objDocTemplate->field_map = $objDocument['field_maps'];
                // $objDocTemplate->enable_mail = $objDocument['enable_lob'];
                // $objDocTemplate->allow_email = $objDocument['allow_email'];
                // $objDocTemplate->allow_download = $objDocument['allow_download'];
                // $objDocTemplate->output_format_pdf = in_array('pdf', $objDocument['output_format']) ? 1 : 0;
                // $objDocTemplate->output_format_orig = in_array($objDocument['file_type'], $objDocument['output_format']) ? 1 : 0;
                // // save 
                // $objDocTemplate->save();                               
            }
        }
        // if selected modules not empty
        if (!empty($args['intellidocs']['selected_modules']) ) {
            // Divider
            $arDivider = array(
              'type' => 'divider',
              'acl_action' => 'view',
            );
            //metadata for button
            $arCustomButton = array (
                'type' => 'intellidocs',
                'name' => 'intellidocs',
                'label' => 'Flexidocs',
                'action' => 'merge',
                'acl_action' => 'view',
            );
            // Get the global view defs
            include("clients/base/views/record/record.php");
            // loop through all module
            foreach ($arModules as $strModule => $strLabel) {
                // get record view of module
                $sidecarParser = ParserFactory::getParser('recordview', $strModule);                        
                //If we don't have the buttons in the metadata grab from stock record view
                if (empty($sidecarParser->_viewdefs['buttons']) || (count($sidecarParser->_viewdefs['buttons']) <= 1)) {
                    // use stock record view
                    $sidecarParser->_viewdefs['buttons'] = $viewdefs['base']['view']['record']['buttons'];
                }
                // initialize
                $actionDropdownKey = null;
                $buttonExists = false;
                $intButtonIndex = 0;
                 //loop through each buttons
                foreach($sidecarParser->_viewdefs['buttons'] as $k => $v) {
                    //Retrieve the index for the action dropdown
                    if ($v['type'] == 'actiondropdown') {
                        // assign the button
                        $actionDropdownKey = $k;
                    }
                }
                // If no action dropdown, set to last item
                if (empty($actionDropdownKey)) {
                    // assign the button
                    $actionDropdownKey = $k;
                }
                // Do we have an action dropdown?
                if (!empty($actionDropdownKey)) {
                    // Are we removing or adding the button?
                    if (isset($args['intellidocs']['selected_modules'][$strModule])) {
                        // We want to add it if it's not there
                        foreach($sidecarParser->_viewdefs['buttons'][$actionDropdownKey]['buttons'] as $k => $v) {
                            // if we have a match
                            if ($v['type'] == $arCustomButton['type']) {
                                // Ignore - button already exists
                                continue;
                            }
                        }
                        // If we get to here, it doesn't exist, and we should add it
                        foreach($sidecarParser->_viewdefs['buttons'][$actionDropdownKey]['buttons'] as $k => $v) {
                            // if we have a match
                            if ($v['type'] == $arCustomButton['type']) {
                                // Set the index 
                                $intButtonIndex = $k;
                                // Previous item a divider?
                                if ($sidecarParser->_viewdefs['buttons'][$actionDropdownKey]['buttons'][$intButtonIndex - 1]["type"] == "divider") {
                                    // Remove
                                    unset($sidecarParser->_viewdefs['buttons'][$actionDropdownKey]['buttons'][$intButtonIndex - 1]);
                                }
                                // Remove
                                unset($sidecarParser->_viewdefs['buttons'][$actionDropdownKey]['buttons'][$intButtonIndex]);
                            }
                        }
                        // if button does not exist and is selected
                        if ($actionDropdownKey != null && in_array($strModule, $args['intellidocs']['selected_modules'])) {
                            // add the button to the metadata
                            array_push($sidecarParser->_viewdefs['buttons'][$actionDropdownKey]['buttons'], $arDivider);
                            array_push($sidecarParser->_viewdefs['buttons'][$actionDropdownKey]['buttons'], $arCustomButton);
                            // Push the update
                            $sidecarParser->handleSave(false);
                        }
                    } else {
                        // if not empty
                        if (!empty($sidecarParser->_viewdefs['buttons'][$actionDropdownKey]['buttons'])) {
                            // make sure the button isn't already on the record metadata
                            foreach($sidecarParser->_viewdefs['buttons'][$actionDropdownKey]['buttons'] as $k => $v) {
                                // if we have a match
                                if ($v['type'] == $arCustomButton['type']) {
                                    // Set the index 
                                    $intButtonIndex = $k;
                                    // Previous item a divider?
                                    if ($sidecarParser->_viewdefs['buttons'][$actionDropdownKey]['buttons'][$intButtonIndex - 1]["type"] == "divider") {
                                        // Remove
                                        unset($sidecarParser->_viewdefs['buttons'][$actionDropdownKey]['buttons'][$intButtonIndex - 1]);
                                    }
                                    // Remove
                                    unset($sidecarParser->_viewdefs['buttons'][$actionDropdownKey]['buttons'][$intButtonIndex]);
                                    // Re-save
                                    $sidecarParser->handleSave(false);
                                }
                            }
                        }
                    }
                }
            }
        }     
        // get the value of enable lob option
        $strLobEnabled = $args['enable_lob'];
        // instantiate
        $objAdmin = new Administration();
        // save lob setting
        $objAdmin->saveSetting("intellidocs_config", "enable_lob", $strLobEnabled);        
        // set status code to 200
        $intHttpStatusCode = 200;
        // set header
        header("HTTP/1.1 {$intHttpStatusCode}", true, $intHttpStatusCode);            
        // return sugar unique key
        return array(
            'sugar_key' => $sugar_config['unique_key'],
            'modules' => $arModules
        );
    }
    /**
     * Check if Flexidoc document is currently on progress
     *
     * @param Object $objIntellidocs the idoc_document record object
     * 
     * @return String encoded in progress signing message
     */
    public function checkSigningStatus($objIntellidocs) {
        // check the status
        if (in_array($objIntellidocs->document_status, array('sent_for_signing','signature_request_viewed'))) {
            // return and prompt to cancel previous signing
            return json_encode(array(
                "cancel_signing" => "There's an existing document sent for signing. Would you like to cancel the previous?",
                "id" => $objIntellidocs->id
                )
            );
        } elseif ($objIntellidocs->document_status == 'partially_signed') {
            // return and prompt to cancel previous signing
            return json_encode(array(
                "partially_signed" => "There's an existing document that is currently in progress",
                "id" => $objIntellidocs->id
                )
            );
        }
        // if we get, here signing status is clear
        return false;
    }    
    /**
    * Send request to merge
    */
    public function MergeDocument($api, $args) {
        // get access to globals
        global $current_user, $timedate, $sugar_config, $db, $app_list_strings; 
        // Instantiate Intellidocs record
        $objIntellidocs = BeanFactory::newBean('idoc_documents');
        // if theres no existing Intellidocs record using parent module, id and Intellidocs id
        if ( ! $objIntellidocs->retrieve_by_string_fields(array('parent_type' => $args['parent_module'], 'parent_id' => $args['parent_id'], 'intellidocs_id' => $args['id'],'multidoc_c' => 0 )) ) {
            // create new record
            $objIntellidocs->id = create_guid();
            $objIntellidocs->new_with_id = true;
            $objIntellidocs->intellidocs_id = $args['id'];                                    
        }
        // check if currently on signature process
        if ($arSigningStatus = $this->checkSigningStatus($objIntellidocs)) {
            // if in progress, return
            return $arSigningStatus;
        }        
        // insntantiate document template and retrieve
        if ( $objDocTemplate = BeanFactory::getBean('idoc_templates',$args['id']) ) {
            // if the same module
            if ($objDocTemplate->parent_module == $args['parent_module']) {
                // document fields not empty?
                if (!empty($objDocTemplate->field_map)) {
                    // call function to get data
                    if ($arFieldsData = $this->getFieldsData($args['parent_module'], $args['parent_id'], json_decode($objDocTemplate->field_map, true) ) ) {
                        // do we have interactive fields passed?
                        if (!empty($args['interactive_fields'])) {
                            // initialise interactive field as array
                            $arFieldsData['interactive_fields'] = array();
                            // loop through 
                            foreach ($args['interactive_fields'] as $strFieldName => $arInteractiveField) {
                                // add to the fields data
                                $arFieldsData['interactive_fields'][$strFieldName] = $arInteractiveField['value'];
                            }
                        }
                        // Do we have a report data set?
                        if (!empty($objDocTemplate->report_source)) {
                            // Get the related report
                            $objReport = BeanFactory::newBean('Reports');
                            $objReport->disable_row_level_security = true;
                            // Retrieve
                            if ($objReport->retrieve($objDocTemplate->report_source)) {
                                // Initialize the data
                                $arReportData = array();
                                // Decode the json
                                $objJson = json_decode(html_entity_decode($objReport->content));
                                // Loop through the filters
                                foreach ($objJson->filters_def as $strKey => $objConfig) {
                                    // Loop through each filter
                                    foreach ($objConfig as $strIndex => $objFilter) {
                                        // Is this a filter?
                                        if (!empty($objFilter->name) && ($objFilter->name == "id") && ($objFilter->table_key == "self") && ($objFilter->qualifier_name == "is") && !empty($objFilter->runtime)) {
                                            // Update the value
                                            $objJson->filters_def->$strKey->$strIndex->input_name0 = $args['parent_id'];
                                        }
                                    }
                                }
                                // Load the report engine
                                $objEngine = new Report(html_entity_decode(json_encode($objJson)), '', '');
                                // Do we have any grouped data?
                                if (!empty($objJson->group_defs)) {
                                    // Disable paging so we get all results in one pass - can be risky!
                                    $objEngine->enable_paging = false;
                                    // Run the grouped query
                                    $objEngine->run_summary_combo_query();
                                    // Get the header row
                                    $arSummaryRow = $objEngine->get_summary_header_row();
                                    $arHeaderRow = $objEngine->get_header_row();
                                    // Loop through the data
                                    while (($arSummary = $objEngine->get_summary_next_row()) != 0) {
                                        // Initialize the index
                                        $intIndex = 0;
                                        // Initialize the data
                                        $arData = array(
                                            "lines" => array(),
                                        );
                                        // Loop through the data - have these as direct variables for user
                                        foreach ($objJson->summary_columns as $objColumn) {
                                            // get the column label, replace non-alphanumeric characters to space and transform to lowercase
                                            $strFieldName = strtolower(preg_replace("/[^a-zA-Z0-9]/", '_', $objColumn->label));                              
                                            // Set the data
                                            $arData[$strFieldName] = strip_tags($arSummary["cells"][$intIndex++]);
                                        }
                                        // Loop through the summary rows
                                        for ($i = 0; $i < $objEngine->current_summary_row_count; $i++) {
                                            // Get the detailed row for each summary item 
                                            if (($arRow = $objEngine->get_next_row('result', 'display_columns', false, true)) != 0) {
                                                // Initialize the index
                                                $intIndex = 0;
                                                // Initialize the data row
                                                $arLocalRow = array();
                                                // Loop through the data
                                                foreach ($objJson->display_columns as $objColumn) {
                                                    // get the column label, replace non-alphanumeric characters to space and transform to lowercase
                                                    $strFieldName = strtolower(preg_replace("/[^a-zA-Z0-9]/", '_', $objColumn->label));
                                                    // Set the data
                                                    $arLocalRow[$strFieldName] = strip_tags($arRow["cells"][$intIndex++]);
                                                }
                                                // Add the lines
                                                $arData["lines"][] = $arLocalRow;
                                            } else {
                                                // Nothing else to do
                                                break;
                                            }
                                        }
                                        // Add to the data
                                        $arReportData[] = $arData;
                                    }
                                } else {
                                    // Get the data set
                                    $objEngine->run_query();
                                    // Get the data
                                    while ($arRow = $objEngine->get_next_row('result', 'display_columns', false, true)) {
                                        // Initialize the index
                                        $intIndex = 0;
                                        // Initialize the data
                                        $arData = array();
                                        // Loop through the data
                                        foreach ($objJson->display_columns as $objColumn) {
                                            // get the column label, replace non-alphanumeric characters to space and transform to lowercase
                                            $strFieldName = strtolower(preg_replace("/[^a-zA-Z0-9]/", '_', $objColumn->label));
                                            // Set the data
                                            $arData[$strFieldName] = strip_tags($arRow["cells"][$intIndex++]);
                                        }
                                        // Add to the data
                                        $arReportData[] = $arData;
                                    }
                                }
                                // Add to the report data
                                $arFieldsData["reportdata"] = $arReportData;
                            }
                        } 
                        // setup POST data to be passed on to Intellidocs
                        $arPostData = array(
                            'license_key' => $sugar_config['unique_key'],                                                            
                            'fields' => $arFieldsData,
                        );
                        // return "test";
                        // json encode the data before passing
                        $arPostData = json_encode($arPostData);
                        // setup intellidocs merge endpoint                            
                        $strUrl = IntelliDocs::ApiEndpoint . "mergedocument/{$args['id']}";
                        // make a curl request
                        if ( $strFileContent = IntelliDocs::sendCurlRequest($strUrl, $arPostData, 'POST', $arHeader) ) {                            
                            // Process the return file content here
                            if (!$strFileContent)
                            {
                                return json_encode(array("error" => "Invalid File Content"));
                            }
                            // Create the bean for parent module
                            $objParent = BeanFactory::newBean($args['parent_module']);
                            // Retrieve
                            $objParent->retrieve($args['parent_id']);
                            // set the other details
                            $objIntellidocs->parent_type = $args['parent_module'];
                            // set the parent id
                            $objIntellidocs->parent_id = $args['parent_id'];                                
                            // Determine the filename
                            $strFileName = (!empty($objParent->name)) ? $objParent->name: $objParent->full_name;
                            $strFileName = preg_replace('/[^a-z0-9A-Z|^.]/i', '_', "{$strFileName} {$objDocTemplate->name}.{$objDocTemplate->file_type}");
                            // Handle PDF Attachment
                            $objFile = new UploadFile('uploadfile');
                            // Create the new doc event
                            $objDocEvent = new idoc_events();
                            // Set the filename
                            $objFile->set_for_soap($strFileName, $strFileContent);
                            $objFile->create_stored_filename();
                            // Set the remaining intellidocs details                                                         
                            $objIntellidocs->document_status = "merged";
                            // $objIntellidocs->name = "Test Intellidocs";
                            $objIntellidocs->name = $objIntellidocs->filename = $strFileName;
                            // prefix document name with parent object
                            $objIntellidocs->document_name =  (!empty($objParent->name)) ? $objParent->name: $objParent->full_name;
                            $objIntellidocs->document_name .= ":{$objDocTemplate->name}";
                            $objIntellidocs->file_mime_type = $objDocTemplate->file_type;
                            $objIntellidocs->file_ext = $objDocTemplate->file_type;
                            // if we dont have current user, get previous assigned user and team
                            $objIntellidocs->assigned_user_id = empty($current_user->id) ? $objIntellidocs->assigned_user_id : $current_user->id ;                    
                            $objIntellidocs->team_id = empty($current_user->team_id) ? $objIntellidocs->team_id : $current_user->team_id;
                            // set intellidocs id
                            $objIntellidocs->intellidocs_id = $args['id'];
                            // Set the doc event filename
                            $objDocEvent->document_name = $objDocEvent->filename = $strFileName;
                            // Set the mime type
                            $objDocEvent->file_mime_type = $objDocTemplate->file_type;
                            $objDocEvent->file_ext = $objDocTemplate->file_type;
                            // Set the parent id
                            $objDocEvent->parent_id = $objIntellidocs->id;
                            // Set the parent name
                            $objDocEvent->parent_type = 'idoc_documents';   
                            // Set assigned user
                            $objDocEvent->assigned_user_id = $objIntellidocs->assigned_user_id;                                
                            // Set assigned team
                            $objDocEvent->team_id = $objIntellidocs->team_id;
                            // set document status
                            $objDocEvent->document_status = $objIntellidocs->document_status;
                            // Save the doc event
                            $strId = $objDocEvent->save();
                            // Do final move
                            $objFile->final_move($strId);                             
                            // Save the doc event
                            if ($objIntellidocs->save()) {                                
                                // Move to upload directory
                                $objFile->final_move($objIntellidocs->id);   
                                // initialise
                                $arSignatureDetails = array();                                                             
                                // get related signers
                                $arSignatureDetails = $this->_getRelatedSigners($args['id'], $objParent);                                                                                                                                                                                   
                                // initialise array
                                $arAddresses = array();                                
                                // call function to get addresses related to record
                                $arAddresses = $this->_getRecordAddresses($args['parent_module'], $args['parent_id']);                                
                                // initialise 
                                $intEnableLob = 0;
                                // instantiate
                                $objAdmin = new Administration();                                
                                // retrieve intellidocs config
                                $objAdmin->retrieveSettings('intellidocs_config');
                                // assign lob setting
                                $intEnableLob = !empty($objAdmin->settings['intellidocs_config_enable_lob']) ? 1 : 0;                                                      
                                // setup return response
                                $arResponse = array(
                                    "success" => true,
                                    "intellidocs_id" => $objIntellidocs->id,
                                    "merge_id" => !empty($arHeader["Merge-Id"]) ? $arHeader["Merge-Id"] : "",
                                    "doc_event_id" =>  $objDocEvent->id,                                        
                                    "no_of_signers" =>  (!empty($arSignatureDetails["no_of_signers"]) ? intval($arSignatureDetails["no_of_signers"]) : 0),
                                    // "signature_type" => $arDocument['signature_type'],
                                    "default_signers" => !empty($arSignatureDetails['default_signers']) ? $arSignatureDetails['default_signers']: "",
                                    "default_signers_init" => !empty($arSignatureDetails['default_signers_init']) ? $arSignatureDetails['default_signers_init'] : "",
                                    'default_addresses' => $arAddresses,                                        
                                    'enable_lob' => $intEnableLob,
                                    'file_type' => strtoupper($objDocTemplate->file_type),
                                    'allow_download' => ( $objDocTemplate->allow_download == '1' ) ? true : false,
                                    'allow_email' => ( $objDocTemplate->allow_email == '1' ) ? true : false,
                                    'output_format_pdf' => ( $objDocTemplate->output_format_pdf == '1' ) ? true : false,
                                    'output_format_orig' => ( $objDocTemplate->output_format_orig == '1' ) ? true : false,
                                );                                
                                // Return success
                                return json_encode($arResponse);          
                            }                  
                            // if we get here, error message
                            return json_encode(array("error" => 'Unable to save document'));                                
                        }      
                        // if we get to here, error message
                        return json_encode(array("error" => IntelliDocs::$strErrorMessage));
                    }                        
                }
            }
        }
        // if we get here document record not found in the settings                
        return json_encode(array("error" => "Unable to retrieve record for merging"));
    }

    /**
    * Send request to merge
    */
    public function GenerateMulti($api, $args) {
        // get access to globals
        global $current_user, $timedate, $sugar_config, $db, $app_list_strings; 
        // require the Intellidocs Id
        $this->requireArgs($args, array('parent_module', 'records', 'intellidocs_id'));
        // retrieve document template
        if ($objDocTemplate = BeanFactory::getBean('idoc_templates', $args['intellidocs_id'])) {
            // if module is the same
            if ($objDocTemplate->parent_module == $args['parent_module']) {
                // document fields not empty?
                if (!empty($objDocTemplate->field_map)) {
                    // Initialize the fields
                    $arFieldsCombined = array();
                    // Loop through each of the records
                    foreach ($args["records"] as $strId) {
                        // call function to get data
                        if ($arFieldsData = $this->getFieldsData($args['parent_module'], $strId, json_decode($objDocTemplate->field_map,true) ) ) {
                            // Add the fields data
                            $arFieldsCombined[] = $arFieldsData;
                        }
                    }
                    // setup POST data to be passed on to Intellidocs
                    $arPostData = array(
                        'license_key' => $sugar_config['unique_key'],                                
                        'alternate_tag' => strtolower($args['parent_module']),
                        'records' => $arFieldsCombined
                    );
                    // json encode the data before passing
                    $arPostData = json_encode($arPostData);
                    // setup intellidocs merge endpoint                            
                    $strUrl = IntelliDocs::ApiEndpoint . "mergemulti/{$args['intellidocs_id']}";
                    // make a curl request
                    if ($strFileContent = IntelliDocs::sendCurlRequest($strUrl, $arPostData, 'POST', $arHeader) ) {
                        // Process the return file content here
                        if (!$strFileContent)
                        {
                            return json_encode(array("error" => "Invalid File Content"));
                        }
                        // Handle PDF Attachment
                        $objFile = new UploadFile('uploadfile');
                        // Set the filename
                        $objFile->set_for_soap($strFileName, $strFileContent);
                        $objFile->create_stored_filename();
                        // instantiate intellidocs object
                        $objNote = new Note();
                        $objNote->id = create_guid();
                        $objNote->new_with_id = true;
                        $objNote->name = $objNote->filename = $objDocTemplate->file_name;
                        $objNote->file_mime_type = $objDocTemplate->file_type;
                        $objNote->assigned_user_id = empty($current_user->id) ? $objNote->assigned_user_id : $current_user->id ;                    
                        $objNote->team_id = empty($current_user->team_id) ? $objNote->team_id : $current_user->team_id;
                        // Do final move
                        $objFile->final_move($objNote->id);
                        // Save the doc event
                        if ($objNote->save()) {
                            // Return success
                            return array(
                                "success" => true,
                                "note_id" => $objNote->id,
                            );
                        }
                    } else {
                        // Throw an exception
                        throw new SugarApiException("Error generating document from Flexidocs.");
                    }
                }                    
            }            
        }
        // if we get here document record not found in the settings                
        return array("error" => "Unable to retrieve record for merging");        
    }
    /**
     * Get the addresses related to the record
     *
     * @param String $strParentModule the record parent module
     * @param String $strParentId the record id
     *
     * @return Array $arAddresses the list of addresses found on the record
     */
    public function _getRecordAddresses($strParentModule, $strParentId) {
        // initialise address array
        $arAddresses = array();
        // Create the bean
        if ($objBean = BeanFactory::newBean($strParentModule)) {
            // Retrieve
            if ($objBean->retrieve($strParentId)) {                
                // Loop through the field defs
                foreach ($objBean->field_defs as $strField => $arConfig) {
                    // if its a group field and has address group name
                    if (!empty($arConfig['group']) && strpos($arConfig['group'], 'address')!==false) {
                        // if address group not added yet
                        if (!array_key_exists($arConfig['group'], $arAddresses)) {
                            // set it as array
                            $arAddresses[$arConfig['group']] = array();
                        }   
                        // Add address to the list
                        $arAddresses[$arConfig['group']][$arConfig['name']] = ((!empty($objBean->$strField) && is_scalar($objBean->$strField) ) ? $objBean->$strField : "");
                    }
                }
                // if we have addresses return
                return (!empty($arAddresses)) ? $arAddresses : false;
            }
        }       
        // if we get here, error
        return false; 
    }    
    /**
    * Get Fields Data
    *
    * @param string $strParentModule the record parent module
    * @param string $strParentId the record id
    * @param array $arFields the fields in the document
    *
    * @return array
    *
    */
    public function getFieldsData($strParentModule, $strParentId, $arFields, $arRelatedFilters = array(), $arAggregateFields = array() ) { 
        // get access to globals
        global $current_user, $timedate, $sugar_config, $db, $app_list_strings;
        // Get the relationship factory
        $objRel = SugarRelationshipFactory::getInstance();
        // Create the bean
        if ($objBean = BeanFactory::newBean($strParentModule)) {
            // Retrieve
            if ($objBean->retrieve($strParentId)) {
                // Initialise the data
                $arData = array();
                // if this is a quotes module
                if ($strParentModule == 'Quotes') {
                    // initialise
                    $arData['bundles'] = array();
                    // retrieve
                    $arProductBundle = $objBean->get_product_bundles();
                    // loop through bundles
                    foreach ($arProductBundle as $objProductBundle) {
                        // if empty
                        $strGroupName = empty($objProductBundle->name) ? "Default" : $objProductBundle->name;        
                        // initialise products and comments
                        $arProducts = $arNotes = array();            
                        // get list of product bundles
                        $strQuery = "
                            SELECT 
                                *
                            FROM
                                product_bundle_product
                            WHERE
                                bundle_id = '{$objProductBundle->id}'
                            AND
                                deleted = '0'
                            ORDER BY
                                date_modified ASC
                        ";
                        // run query
                        $hQuery = $db->query($strQuery);
                        // loop through
                        while ($arRow = $db->fetchByAssoc($hQuery)) {
                            // do we have product_id?
                            if (!empty($arRow['product_id'])) {
                                // get product details
                                $strProductQuery = "
                                    SELECT
                                        *
                                    FROM
                                        products
                                    WHERE
                                        id = '" . $arRow['product_id'] . "'
                                    ORDER BY
                                        date_entered ASC
                                ";
                                // run query
                                $hProductQuery = $db->query($strProductQuery);
                                // loop through
                                while ($arProductRow = $db->fetchByAssoc($hProductQuery)) {
                                    // add to list
                                    $arProducts[] = $arProductRow;
                                }
                            }
                        }
                        // get list of note bundles                        
                        $strQuery = "
                            SELECT 
                                *
                            FROM
                                product_bundle_note
                            WHERE
                                bundle_id = '{$objProductBundle->id}'
                            AND
                                deleted = '0'
                            ORDER BY
                                date_modified ASC
                        ";
                        // run query
                        $hQuery = $db->query($strQuery);
                        // loop through
                        while ($arRow = $db->fetchByAssoc($hQuery)) {
                            // do we have product_id?
                            if (!empty($arRow['note_id'])) {
                                // get note details
                                $strNoteQuery = "
                                    SELECT
                                        description
                                    FROM
                                        product_bundle_notes
                                    WHERE
                                        id = '" . $arRow['note_id'] . "'
                                    ORDER BY
                                        date_entered ASC
                                ";
                                // run query
                                $hNoteQuery = $db->query($strNoteQuery);
                                // loop through
                                while ($arNoteRow = $db->fetchByAssoc($hNoteQuery)) {
                                    // add description
                                    $arNotes[] = $arNoteRow['description'];
                                }
                            }
                        }
                        // get group name
                        $arData['groups'][] = array(
                            'name' => $strGroupName,
                            'total' => $objProductBundle->total,
                            'products' => $arProducts,
                            'comments' => $arNotes
                        );
                    }

                    $GLOBALS['log']->fatal('PRODUCT BUNDLE', $arData);
                }
                // add id by default
                $arData['id'] = $objBean->id;
                $intCtr = 1;
                // Loop through the field defs
                foreach ($objBean->field_defs as $strField => $arConfig) {
                    // Ignore links
                    if ($arConfig["type"] == "link") {
                        // Ignore this field
                        continue;
                    }
                    // if date or datetime field
                    if ($arConfig['type'] == 'date' || $arConfig['type'] == 'datetime') {
                        // add field to variable to list
                        $arFields[] = $strField;
                    }
                    // make sure the field exist in the document
                    if ( in_array($strField, $arFields) ){
                        // determine field type
                        switch ($arConfig['type']) {
                            case 'multienum':
                                // replace caret to empty character
                                $objBean->$strField = str_replace("^", "", $objBean->$strField);                                
                                break;
                            case 'enum':
                                // get the display value 
                                $objBean->$strField = $app_list_strings[$arConfig['options']][$objBean->$strField];
                                break;
                            case 'image':
                                // get file
                                $objFile = new UploadFile();
                                // get the file location
                                $objFile->temp_file_location = UploadFile::get_upload_path($objBean->$strField);
                                // get file content
                                $strFileContents = $objFile->get_file_contents();
                                break;
                            case 'date':         
                            case 'datetime':
                                // do we a returned value
                                if (!empty($objBean->$strField)) {                                
                                    // convert to db date and get timestamp
                                    $arData["{$strField}_unixtime"] = strtotime($timedate->to_db($objBean->$strField));

                                } else {
                                    // get value from DB
                                    $strQuery = "SELECT {$strField} FROM {$objBean->table_name} O LEFT JOIN {$objBean->table_name}_cstm C ON O.id = C.id_c WHERE id='{$objBean->id}'";
                                    // run query
                                    $hQuery = $db->query($strQuery);
                                    // Retrieve the config
                                    if ($arRow = $db->fetchByAssoc($hQuery)) {
                                        // add value
                                        $arData["{$strField}_unixtime"] = strtotime($arRow[$strField]); 
                                    }
                                }
                                break;
                            default:
                                # code...
                                break;
                        }
                        // is this an image
                        if ($arConfig['type'] == 'image' && !empty($strFileContents)) {
                            // encode and add to array
                            $arData[$strField] = base64_encode($strFileContents);
                        } else {
                            // Add to the list
                            $arData[$strField] = ((!empty($objBean->$strField) && is_scalar($objBean->$strField) ) ? $objBean->$strField : "");
                        }
                        // // if multienum
                        // if ($arConfig['type'] == 'multienum') {
                        //     // replace caret to empty character
                        //     $objBean->$strField = str_replace("^", "", $objBean->$strField);
                        // } else if ($arConfig['type'] == 'enum') {
                        //     // get the display value 
                        //     $objBean->$strField = $app_list_strings[$arConfig['options']][$objBean->$strField];
                        // } else if ($arConfig['type'] == 'image') {
                        //     // get file
                        //     $objFile = new UploadFile();
                        //     // // get the file location
                        //     $objFile->temp_file_location = UploadFile::get_upload_path($objBean->$strField);
                        //     // // get file content
                        //     $strFileContents = $objFile->get_file_contents();
                        // }
                        // // if date or datetime field
                        // if ($arConfig['type'] == 'date') {                            
                        //     // convert to timestamp
                        //     $arData["{$strField}_unixtime"] = strtotime($timedate->to_db_date($objBean->$strField));                            
                        // } elseif ($arConfig['type'] == 'datetime') {
                        //     // convert to timestamp
                        //     $arData["{$strField}_unixtime"] = strtotime($timedate->to_db($objBean->$strField));
                        // }
                        // is this an image
                        // if ($arConfig['type'] == 'image' && !empty($strFileContents)) {
                        //     // encode and add to array
                        //     $arData[$strField] = base64_encode($strFileContents);
                        // } else {
                        //     // Add to the list
                        //     $arData[$strField] = ((!empty($objBean->$strField) && is_scalar($objBean->$strField) ) ? $objBean->$strField : "");
                        // }
                    }
                    // Is this a relate field
                    if (!empty($arConfig["type"]) && ($arConfig["type"] == "relate") && ($arConfig["name"] != $arConfig["id_name"])) {
                        // Ensure that we have a module and id field
                        if (!empty($arConfig["module"]) && !empty($arConfig["id_name"])) {
                            // Get the id
                            $strIdField = $arConfig["id_name"];                            
                            // Do we have an id field?
                            if (!empty($objBean->$strIdField)) {
                                // Retrieve the related field
                                if ($objRelatedBean = BeanFactory::newBean($arConfig['module'])) {
                                    // Retrieve
                                    if ($objRelatedBean->retrieve($objBean->$strIdField)) {
                                        // Set the acronym
                                        $strAcronym = "";                                        
                                        // Loop through the field defs
                                        foreach ($objRelatedBean->field_defs as $strRelateField => $arRelateConfig) {
                                            // Ignore links
                                            if ($arRelateConfig["type"] == "link") {
                                                // Ignore this field
                                                continue;
                                            }
                                            // if date or datetime field
                                            if ($arConfig['type'] == 'date' || $arConfig['type'] == 'datetime') {
                                                // add relate field to variable to list
                                                $arFields[] = "{$strField}_{$strRelateField}";
                                            }
                                            // make sure the related field is available in the document
                                            if ( in_array($strField . "_" . $strRelateField, $arFields) ){
                                                // determine relate field type
                                                switch ($arRelateConfig['type']) {
                                                    case 'image':
                                                        // get file
                                                        $objFile = new UploadFile();
                                                        // // get the file location
                                                        $objFile->temp_file_location = UploadFile::get_upload_path($objRelatedBean->$strRelateField);
                                                        // get file contents, encode and add to array
                                                        $arData[$strField . "_" . $strRelateField] = base64_encode($objFile->get_file_contents());
                                                        # code...
                                                        break;
                                                    case 'multienum':                                                        
                                                        // replace caret to empty character                                                        
                                                        $arData[$strField . "_" . $strRelateField] = str_replace("^", "", $objRelatedBean->$strRelateField);
                                                        break;
                                                    case 'enum':
                                                        // get the display value 
                                                        $arData[$strField . "_" . $strRelateField] = $app_list_strings[$arRelateConfig['options']][$objRelatedBean->$strRelateField];
                                                        break;
                                                    case 'date':
                                                        // convert to timestamp add unix time
                                                        $arData["{$strField}_{$strRelateField}_unixtime"] = strtotime($timedate->to_db_date($objRelatedBean->$strRelateField));
                                                        // add field
                                                        $arData[$strField . "_" . $strRelateField] = ((!empty($objRelatedBean->$strRelateField) && is_scalar($objRelatedBean->$strRelateField)) ? $objRelatedBean->$strRelateField : "");
                                                    case 'datetime':
                                                        // convert to timestamp
                                                        $arData["{$strField}_{$strRelateField}_unixtime"] = strtotime($timedate->to_db($objRelatedBean->$strRelateField));
                                                        // add field
                                                        $arData[$strField . "_" . $strRelateField] = ((!empty($objRelatedBean->$strRelateField) && is_scalar($objRelatedBean->$strRelateField)) ? $objRelatedBean->$strRelateField : "");
                                                        break;                                                    
                                                    default:
                                                        // Add to the list
                                                        $arData[$strField . "_" . $strRelateField] = ((!empty($objRelatedBean->$strRelateField) && is_scalar($objRelatedBean->$strRelateField)) ? $objRelatedBean->$strRelateField : "");
                                                        # code...
                                                        break;
                                                }
                                                // is this an image
                                                // if ($arRelateConfig['type'] == 'image') {
                                                //     // get file
                                                //     $objFile = new UploadFile();
                                                //     // // get the file location
                                                //     $objFile->temp_file_location = UploadFile::get_upload_path($objRelatedBean->$strRelateField);
                                                //     // get file contents, encode and add to array
                                                //     $arData[$strField . "_" . $strRelateField] = base64_encode($objFile->get_file_contents());
                                                // } else if ($arRelateConfig['type'] == 'enum') {
                                                //     // get the display value 
                                                //     $arData[$strField . "_" . $strRelateField] = $app_list_strings[$arRelateConfig['options']][$objRelatedBean->$strRelateField];
                                                // } else if ($arRelateConfig['type'] == 'date') {                            
                                                //     // convert to timestamp
                                                //     $arData["{$strField}_{$strRelateField}_unixtime"] = strtotime($timedate->to_db_date($objRelatedBean->$strRelateField));                            
                                                // } elseif ($arRelateConfig['type'] == 'datetime') {
                                                //     // convert to timestamp
                                                //     $arData["{$strField}_{$strRelateField}_unixtime"] = strtotime($timedate->to_db($objRelatedBean->$strRelateField));
                                                // } else {  
                                                //     // Add to the list
                                                //     $arData[$strField . "_" . $strRelateField] = ((!empty($objRelatedBean->$strRelateField) && is_scalar($objRelatedBean->$strRelateField)) ? $objRelatedBean->$strRelateField : "");
                                                // }                                                
                                            }
                                        }                                        
                                    }
                                }
                            }
                        }
                    }
                }
                // Get all related objects
                $arLinkedFields = $objBean->get_linked_fields();
                // Loop through each field
                foreach ($arLinkedFields as $strLink => $arDefs) {
                    // Is this a relate field
                    if (!empty($arDefs['relationship']) && !empty($arDefs['name'])) {
                        // Ignore certain built in relationships
                        if (stristr($arDefs['relationship'], "favorite") || stristr($arDefs['relationship'], "following") ||
                            stristr($arDefs['relationship'], "created_by") || stristr($arDefs['relationship'], "modified_user") ||
                            stristr($arDefs['relationship'], "assigned_user") || stristr($arDefs['relationship'], "idoc_documents") ||
                            stristr($arDefs['relationship'], "currencies") || stristr($arDefs['relationship'], "forecastworksheets") ||
                            stristr($arDefs['relationship'], "activities") || stristr($arDefs['relationship'], "team")) {
                            // Ignore this relationship
                            continue;                            
                        }
                        // Set the link
                        $strRelationship = $arDefs['relationship'];
                        // Set the link name
                        $strLinkName = $arDefs['name'];
                        // ignore if the related object doesn't exist in the document
                        if (!in_array($strLinkName, $arFields) ){
                            // ignore this related object
                            continue;
                        }                        
                        // Is this relationship defined?
                        if ($arRelationship = $objRel->getRelationshipDef($strRelationship)) {          
                            // Is this related to the target module?
                            if (($arRelationship['lhs_module'] == $objBean->module_dir) || ($arRelationship['rhs_module'] == $objBean->module_dir)) {                                                                
                                // if not empty and load relationship
                                if (!empty($objBean->$strLinkName) || $objBean->load_relationship($strLinkName)) {                                    
                                    // get related module
                                    $stRelModule = (($arRelationship['lhs_module'] == $objBean->module_dir)) ? $arRelationship['rhs_module'] : $arRelationship['lhs_module'];
                                    // initialise related
                                    $objRelBean = BeanFactory::newBean($stRelModule);
                                    // do we have first name                                    
                                    if (isset($objRelBean->field_defs["first_name"])) {
                                        // initialise as array and add order by created date
                                        $arWhereClause = array('orderby' => 'first_name ASC');
                                    } else {
                                        // initialise as array and add order by created date
                                        $arWhereClause = array('orderby' => 'name ASC');
                                    }
                                    // do we have related filters
                                    if (!empty($arRelatedFilters)) {
                                        // determine the related module
                                        $strRelatedModule = ($arRelationship['lhs_module'] == $objBean->module_dir) ? $arRelationship['rhs_module'] : $arRelationship['lhs_module'];
                                        // check if module has filters
                                        if (array_key_exists($strRelatedModule, $arRelatedFilters)) {
                                            // build where clause
                                            $arWhereClause['where'] = $this->_buildWhereClause(lcfirst($strRelatedModule), $arRelatedFilters[$strRelatedModule]);                        
                                        }
                                    }
                                    // Retrieve any related objects
                                    if ($arRelated = $objBean->$strLinkName->getBeans($arWhereClause)) {
                                        // do we have aggregation
                                        if (!empty($arAggregateFields)) {
                                            // initialise aggregate variable container as array
                                            $arAggregate = array();
                                            // check if related module exist in the aggregate fields
                                            if (array_key_exists($strRelatedModule, $arAggregateFields)) {
                                                // loop through each aggregate fields
                                                foreach ($arAggregateFields[$strRelatedModule] as $arVariable) {                                                
                                                    // add to array
                                                    $arAggregate[$arVariable['field']] = array(                          
                                                        'variable_name' => $arVariable['variable'],
                                                        'operator' => $arVariable['operator'],
                                                        'values' => array()
                                                    );                                                                       
                                                }
                                            }                                        
                                        }
                                        // Initialise the count
                                        $intBeanCount = 0;
                                        // This is a direct relationship - add the field directly
                                        foreach ($arRelated as $objRelatedBean) {       
                                            // Do we have related fields?
                                            if (!empty($arRelationship['rel_fields'])) {
                                                // Loop through the fields
                                                foreach ($arRelationship['rel_fields'] as $strField => $arDef) {

                                                }
                                            }

                                            // &customers[0][name]=John Smith&customers[0][email]=john.smith@example.com&customers[1][name]=Jane Smith&customers[1][email]=jane.smith@example.com
                                            // Prefix is link name without the _link
                                            // $strPrefix = $strLinkName . "[" . $intBeanCount++ . "]";
                                            $intBeanCount = $intBeanCount++;
                                            // initialize as array
                                            $arRelated = array();                                            
                                            // Loop through the field defs
                                            foreach ($objRelatedBean->field_defs as $strField => $arConfig) {
                                                // Do we have relationship fields here?
                                                if (!empty($arConfig['relationship_fields'])) {
                                                    // Loop through and set the value
                                                    foreach ($arConfig['relationship_fields'] as $strRelField => $strSeedField) {
                                                        // Set the value
                                                        $arRelated[$strSeedField] = ((!empty($objRelatedBean->$strSeedField) && is_scalar($objRelatedBean->$strSeedField)) ? $objRelatedBean->$strSeedField : "");
                                                    }
                                                }                                                
                                                // check if field is image
                                                if ($arConfig['type'] == 'image') {                                                    
                                                    // initialise upload file
                                                    $objFile = new UploadFile();
                                                    // get the file location
                                                    $objFile->temp_file_location = UploadFile::get_upload_path($objRelatedBean->$strField);
                                                    // get file content
                                                    $strFileContents = $objFile->get_file_contents();                                                                                        
                                                    // encode and add to array
                                                    $arRelated[$strField] = base64_encode($strFileContents);
                                                } else if ($arConfig['type'] == 'enum') {
                                                    // get the display value 
                                                    $arRelated[$strField] = $app_list_strings[$arConfig['options']][$objRelatedBean->$strField];
                                                }
                                                else {
                                                    // add to the list
                                                    $arRelated[$strField] = ((!empty($objRelatedBean->$strField) && is_scalar($objRelatedBean->$strField)) ? $objRelatedBean->$strField : "");
                                                }
                                                // check if field is in aggregate array
                                                if (array_key_exists($strField, $arAggregate)){
                                                    // add the value to the value key
                                                    $arAggregate[$strField]['values'][] = ((!empty($objRelatedBean->$strField) && is_scalar($objRelatedBean->$strField)) ? $objRelatedBean->$strField : "");
                                                }
                                            }
                                                                                       
                                            // did we find aggregate values
                                            if (!empty($arAggregate)) {
                                                // loop through each aggregate variables
                                                foreach ($arAggregate as $strField => $arVarFields) {
                                                    // do we have values
                                                    if (!empty($arVarFields['values']) ) {
                                                        // evaluate and assign
                                                        if ($intCalculatedValue = $this->_evaluateAggregattion($arVarFields) ) {
                                                            // assign value
                                                            $arData[$arVarFields['variable_name']] = $intCalculatedValue;
                                                        }
                                                    }
                                                }                                                
                                            }    
                                            // add to the related array
                                            $arData[$strLinkName][] = $arRelated;                                            
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            } else {
                // return error
                return array('error'=>$intHttpStatusCode,'error_message'=>'record not found');        
            }
        }
        // get current user
        $objUser = BeanFactory::getBean('Users', $current_user->id);                
        // Loop through the user field defs
        foreach ($objUser->field_defs as $strField => $arConfig) {
            // Ignore links
            if ($arConfig["type"] == "link") {
                // Ignore this field
                continue;
            }
            // dont include the ff fields
            if (!in_array($strField, array('system_generated_password','user_hash','authenticate_id','sugar_login','pwd_last_changed') )) {                    
                // make sure the related field is available in the document
                if ( in_array('current_user_' . $strField, $arFields) ){
                    // Add to the list
                    $arData['current_user_' . $strField] = ((!empty($objUser->$strField) && is_scalar($objUser->$strField)) ? $objUser->$strField : "");
                }
            }                                    
        }
        // Add the today tag
        $strToday = gmdate("Y-m-d H:i:s");
        // add merge time base on the user date format
        $arData['merge_time'] = $timedate->to_display_date_time($strToday, true, true);
        $arData['today'] = $timedate->to_display_date($strToday, false);
        $arData['now'] = date("Y-m-d H:i:s", strtotime(substr($timedate->getNow(true),0,-6)));
        // return data
        return $arData;
    }
    /**
     * Evaluate the aggregate function
     *
     * @param array Array of values and operator
     *
     * @return int calculated value 
     */
    private function _evaluateAggregattion($arVarFields) {
        // if values empty
        if (!empty($arVarFields['values'])) {
            $intCalculatedValue = 0;
            // determine operator
            switch ($arVarFields['operator']) {
                case 'summation':
                    // add all values in array
                    $intCalculatedValue = array_sum($arVarFields['values']);                                    
                    break;  
                case 'average':
                    // sum all values and average
                    $intCalculatedValue = array_sum($arVarFields['values']) / count($arVarFields['values']);
                    break;
                case 'minimum':
                    // get the lowest value in array
                    $intCalculatedValue = min($arVarFields['values']);
                    break;
                case 'maximum':                
                    // get the highest value in array
                    $intCalculatedValue = max($arVarFields['values']);
                    break;
                default:
                    # code...
                    break;
            }
            // return total
            return $intCalculatedValue;
        }
        // return false
        return false;
    }
    /**
     * Get Intellidocs record details and the events to it
     */
    public function GetIntellidocsRecord($api, $args) {
        // require the Intellidocs Id
        $this->requireArgs($args, array('id') );
        // get access to globals
        global $db, $current_user, $timedate;
        // initialize return array
        $arReturn = array(
            'name' => '',
            'status' => '',
            'timeline' => array()
        );        
        // retrieve the intellidocs record
        if ( $objIntellidocs = BeanFactory::getBean('idoc_documents', $args['id'] ) ) {
            // assign the name
            $arReturn['name'] = $objIntellidocs->name;
            $arReturn['status'] = $objIntellidocs->document_status;
            // initialise query 
            $strQuery = "SELECT
                            id,
                            document_name,
                            date_modified, 
                            file_ext,                           
                            modified_user_id,
                            document_status
                        FROM
                            idoc_events                        
                        WHERE
                            parent_type = 'idoc_documents'
                        AND
                            parent_id = '{$objIntellidocs->id}'
                        AND
                            deleted = 0
                        ORDER BY
                            date_entered
                        DESC 
            ";                    
            // Execute query
            $hQuery = $db->query($strQuery);
            // Retrieve the config
            while ($arRow = $db->fetchByAssoc($hQuery)) {
                // create DateTime object from the value of date in DB
                $objDate = DateTime::createFromFormat("Y-m-d H:i:s", $arRow['date_modified']);
                // get ISO format for date 
                $arRow['date_modified'] = $timedate->asIso($objDate, BeanFactory::getBean('Users', $current_user->id) );
                // set the first letter to uppercase and replace _ to whitespace
                $arRow['document_status'] = ucfirst( str_replace("_", " ", $arRow['document_status']));                
                // create new User object and retrieve
                if ( $objUser = BeanFactory::getBean('Users', $arRow['modified_user_id']) ) {
                    // assign user full name
                    $arRow['modified_user_name'] = $objUser->full_name;                    
                }                
                // add to timeline array
                $arReturn['timeline'][] = $arRow;
            }
        }
        // return array
        return $arReturn;
    }
    /**
     * Get all the Intellidocs and the related recent events (max of 5)
     *
     * @return array 
     */
    public function GetIntellidocsDashletList($api, $args){
        // get access to globals
        global $db, $current_user, $timedate;
        // initialize return as array
        $arIntellidocs = array();
        // initialise query to get all active intellidocs
        $strQuery = "SELECT
                        id,
                        document_name,
                        document_status,
                        parent_type,
                        parent_id
                    FROM
                        idoc_documents
                    WHERE
                        deleted = 0
                    ORDER BY
                        date_modified
                    DESC
        ";
        // Execute query
        $hQuery = $db->query($strQuery);
        // retrieve
        while ($arRow = $db->fetchByAssoc($hQuery)) {
            // if we have a filter status
            if (!empty($args['status'])) {
                // check if the current row equals to the status
                if ( $args['status'] != $arRow['document_status']) {                    
                    // skip the record
                    continue;
                }
            }
            // if intellidocs id not yet added
            if (empty($arIntellidocs[$arRow['id']] )) {                
                // instantiate related record and retrieve
                if ( $objRelated = BeanFactory::getBean($arRow['parent_type'], $arRow['parent_id']) ) {
                    // iniatialise as array
                    $arIntellidocs[$arRow['id']] = array(                    
                        'document_name' => $arRow['document_name'],
                        'document_status' => $arRow['document_status'],
                        'parent_type' => $arRow['parent_type'],
                        'parent_id' => $arRow['parent_id'],
                        'parent_name' => !empty($objRelated->full_name) ? $objRelated->full_name : $objRelated->name,
                        'events' => array(),
                        'even' => $intRow % 2 ? false: true
                    );
                } 
            }
            // setup query to get the related events
            $strEventQuery = "SELECT
                                id,
                                filename,
                                document_name,
                                document_status,                                
                                date_modified,
                                modified_user_id                           
                            FROM
                                idoc_events                    
                            WHERE
                                deleted = 0     
                            AND
                                parent_id = '{$arRow['id']}'
                            ORDER BY
                                date_entered
                            DESC                 
            ";
            // Execute query
            $hEventQuery = $db->query($strEventQuery);
            // retrieve
            while ($arEventRow = $db->fetchByAssoc($hEventQuery)) {
                // if added events are not 5 in total
                if (count($arIntellidocs[$arRow['id']]['events']) <= 5 ) {
                    // get datetime object based on the value of date on db
                    $objDate = DateTime::createFromFormat("Y-m-d h:i:s", $arEventRow['date_modified']);             
                    if (get_class($objDate) == 'DateTime') {                                
                        // get ISO format for date
                        $arEventRow['date_modified'] = $timedate->asIso($objDate, BeanFactory::getBean('Users', $current_user->id));
                    }
                    // get date modified, transform and format this way for using relativeTime Handlebar helper
                    // $arEventRow['date_modified'] = date('m/d/Y H:i:s', strtotime( $timedate->to_display_date_time($arEventRow['date_modified'], true, true, $current_user) ));
                    // set the first letter to uppercase and replace _ to whitespace
                    $arEventRow['document_status'] = ucfirst( str_replace("_", " ", $arEventRow['document_status']));

                    // create new User object and retrieve
                    if ( $objUser = BeanFactory::getBean('Users', $arEventRow['modified_user_id']) ) {
                        // assign user full name
                        $arEventRow['modified_user_name'] = $objUser->full_name;                    
                    }                
                    // add events to the intellidocs
                    $arIntellidocs[$arRow['id']]['events'][] = array(
                        'id' => $arEventRow['id'],
                        'filename' => $arEventRow['filename'],
                        'document_status' => $arEventRow['document_status'],
                        'modified_user_id' => $arEventRow['modified_user_id'],
                        'modified_user_name' => $arEventRow['modified_user_name'],
                        'date_modified' => $arEventRow['date_modified'],
                    );
                } 
            }
        }
        // if we have 
        if (count($arIntellidocs) > 0) {
            // return Intellidocs
            return $arIntellidocs;   
        }       
        // if we get to here
        return false;        
    }
    /**
     * Handles IntelliDocs Callback
     */
    public function HandleSignatureCallback($api, $args) {
        global $timedate;        
        // if we have a signature id
        if (!empty($args['signature_request_id'])) {
            // Do we have a document that matches this signature? Retrieve by signature request id
            $objDoc = new idoc_documents();
            $objDoc->disable_row_level_security = true;
            // Attempt to retrieve
            if ($objDoc->retrieve_by_string_fields(array('signature_request_id' => $args['signature_request_id'] ))) {                
                // if already signed
                if ($objDoc->document_status == 'signed') {
                    // set status code to ok
                    header("HTTP/1.1 400", true, 400);
                    // return true
                    return false;      
                }
                // set the status
                $objDoc->document_status = $args['status'];   
                // check the status
                if ($args['status'] == 'partially_signed' || $args['status'] == 'signed') {
                    // instantiate signer object
                    $objSigner = BeanFactory::getBean('idoc_signers');
                    // retrieve by signature id
                    if ( $objSigner->retrieve_by_string_fields(array('signature_id' => $args['signer_id']) ) ) {
                        // set the flag to signed
                        $objSigner->signed = 1;
                        // save
                        $objSigner->save();
                    }
                    // if fully signed
                    if ($args['status'] == 'signed') {
                        // set the signed date
                        $objDoc->date_signed = $timedate->nowDb();
                    }
                }
                // instantiate idoc events
                $objEvent = new idoc_events();
                // check if we have existing event for this signer
                if ($objEvent->retrieve_by_string_fields(array('signer_id_c'=> $args['signer_id'], 'document_status'=> $args['event'] ))) {
                    // set status code to ok
                    header("HTTP/1.1 400", true, 400);
                    // return true
                    return false;                    
                }
                // create new id
                $objEvent->id = create_guid();                
                // Set the event name
                $objEvent->name = $objEvent->document_name = $objDoc->filename;
                $objEvent->parent_id = $objDoc->id;
                $objEvent->parent_type = "idoc_documents";
                $objEvent->signer_id_c = $args['signer_id'];
                $objEvent->team_id = $objDoc->team_id;
                $objEvent->team_set_id = $objDoc->team_set_id;
                $objEvent->assigned_user_id = $objDoc->assigned_user_id;
                // do we have a file content 
                if (!empty($args['file_contents'])) {
                    // if successful to set the signed document
                    if ( $this->_attachedSignedDocument($objDoc, $objEvent, $args['file_contents']) ) {
                        // change the file type to pdf
                        $GLOBALS['log']->info('Document saved');                        
                    }
                } else {
                    // if status if partially signed
                    if ($args['event'] == 'partially_signed') {
                        // set status code to error
                        header("HTTP/1.1 400", true, 400);
                        // return true
                        return false; 
                    }
                    // new id
                    $objEvent->new_with_id = true;
                    $objEvent->document_status =  $args['status'];                    
                    // save event
                    $objEvent->save();
                }
                // save intellidocs document
                if ($objDoc->save()) {
                    // set status code to ok
                    header("HTTP/1.1 200", true, 200);
                    // return true
                    return $objEvent->id;
                }
            }
        }    
        // if we get to here error set status code to 400         
        // set header
        header("HTTP/1.1 400", true, 400);            
        // return error
        return false;
    }
    /**
     * Attach the Signed Document to the Intellidocs record
     *
     * @param object $objIntellidocs the intellidocs object
     * @param string $strFileContent file contents
     *
     * @return boolean whether saving is successful or not
     */
    private function _attachedSignedDocument(&$objIntellidocs, &$objEvent, $strFileContent) {
        // $GLOBALS['log']->info('Attaching Signed Document');
        // new id
        $objEvent->new_with_id = true;
        $objEvent->document_status =  $args['status'];  
        // instantiate file upload object
        $objFileUpload = new UploadFile();    
        // Decode the file content and set it for upload
        $objFileUpload->set_for_soap( "{$objEvent->document_name}.pdf", base64_decode($strFileContent) );
        // longreach - added
        $objFileUpload->create_stored_filename();                                   
        // Set the extention
        $objFileUpload->file_ext = 'pdf';
        // set status
        $objEvent->document_status =  $objIntellidocs->document_status;
        // Set the filename
        $objEvent->filename = $objFileUpload->get_stored_file_name();
        // Set the mime type
        $objEvent->file_mime_type = 'pdf';
        $objEvent->file_ext = 'pdf';
        // Save the note
        $strId = $objEvent->save();
        // Do final move
        $objFileUpload->final_move($strId); 
        // if this is all signed
        if ($objIntellidocs->document_status == 'signed') {
            // // Set the id of the note to be the same as the intellidoc - will overwrite original unsigned doc with signed   
            // duplicate file and copy it to the intellidocs
            if ( $objFileUpload->duplicate_file($strId, $objIntellidocs->id) ) {
                // change the file name and type
                $objIntellidocs->filename = $objFileUpload->get_stored_file_name();
                // $GLOBALS['log']->info('INTELLIDOCS FILENAME', $objIntellidocs->filename);
                $objIntellidocs->file_mime_type = 'pdf';
                $objIntellidocs->file_ext = 'pdf';
            }  
        }        
        // return success
        return true;      
    }    
}
?>
