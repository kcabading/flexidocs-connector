<?php

/**
 * Class that contains all logic to connecting with the IntelliDocs Platform
 */
class IntelliDocs
{   
    /**
     * Class Constant
     *
     * IntelliDocsApiEnpoint IntelliDocs Platform REST endpoint
     */
    const ApiEndpoint = 'https://console.flexidocs.co/api/intellidocs/';
    const URI = 'https://console.flexidocs.co/';

    /**
     * Error Message 
     */
    public static $strErrorMessage;
    /**
    * function that calls curl request to Intellidocs Platform
    *
    * @param string $url The IntelliDocs Platform url endpoint to handle the request
    * @param array $data The data to be pass
    * @param string $action The http verb to use
    *
    * @return array $arData Array of return data
    */
    public static function sendCurlRequest($url, $data = array(), $action = 'GET', &$arHeaders = array())
    {   
        // get access to globals        
        global $sugar_config;
        $arRequestHeader = array('Access-Token:' . $sugar_config['unique_key'], 'Content-type: application/json');
        // Determine the request type
        if ($action == "GET") {
            if (!empty($data)) {
                // build the url with query strings
                $url .= http_build_query($data);
            }
        }
        // Record the error
        // $GLOBALS['log']->info("URL: {$url}, Type: {$action}");        
        // initialize curl        
        $objCurl = curl_init();                        
        // Set the data
        curl_setopt($objCurl, CURLOPT_URL, $url);  
        curl_setopt($objCurl, CURLOPT_RETURNTRANSFER, true);  
        curl_setopt($objCurl, CURLOPT_HEADER, true);  
        // curl_setopt($objCurl, CURLOPT_FOLLOWLOCATION, true);  
        curl_setopt($objCurl, CURLOPT_ENCODING, "");  
        curl_setopt($objCurl, CURLOPT_USERAGENT, "Intellidocs for SugarCRM");  
        curl_setopt($objCurl, CURLOPT_AUTOREFERER, true);  
        curl_setopt($objCurl, CURLOPT_CONNECTTIMEOUT, 3600);  
        curl_setopt($objCurl, CURLOPT_TIMEOUT, 3600);  
        curl_setopt($objCurl, CURLOPT_MAXREDIRS, 10);  
        curl_setopt($objCurl, CURLOPT_SSL_VERIFYPEER, false);  
        curl_setopt($objCurl, CURLOPT_SSL_VERIFYHOST, 2);  
        // do we have data
        if (!empty($data)) {
            $arRequestHeader[] = 'Content-length: ' . strlen($data);
        }
        curl_setopt($objCurl, CURLOPT_HTTPHEADER, $arRequestHeader);
        // check for the action
        if ($action == "POST") {
            // Set the options
            curl_setopt($objCurl, CURLOPT_POST, true);  
            if (!empty($data)) {
                curl_setopt($objCurl, CURLOPT_POSTFIELDS, $data);
            }
        }                                
        // Get the data
        $strData = curl_exec($objCurl);
        // Then, after your curl_exec call:
        $intHeaderSize = curl_getinfo($objCurl, CURLINFO_HEADER_SIZE);
        $strHeader = substr($strData, 0, $intHeaderSize);
        $strData = substr($strData, $intHeaderSize);
        // Do we have a header?
        if (!empty($strHeader)) {
            // Split the header
            $arContent = explode("\n", $strHeader);
            // Loop through
            foreach ($arContent as $strContent) {
                // Split the line
                $arLine = explode(":", $strContent, 2);
                // Do we have two values?
                if (count($arLine) == 2) {
                    // Add to the header
                    $arHeaders[trim($arLine[0])] = trim($arLine[1]);                    
                }
            }
        }
        // Get the info
        $objInfo = curl_getinfo($objCurl);        
        // Check for errors and display the error message
        if ($intError = curl_errno($objCurl)) {
            // Do we have an error?
            $strError = curl_error($objCurl);
            // Record the error
            $GLOBALS['log']->fatal("Error #{$intError}: ", $strError);
        }

        // Get the headers
        $intStatusCode = curl_getinfo($objCurl,CURLINFO_HTTP_CODE);
        // check the status code
        if ($intStatusCode != '200' && $intStatusCode != '201') {
            // convert to array
            $arResponse = json_decode($strData, true);  
            // set error message            
            self::$strErrorMessage = ( !empty($arResponse['error']) ) ? $arResponse['error'] : 'Something has failed' ;
            // Error has occured
            return false;
        }
        // close curl
        curl_close($objCurl);
        // Is this raw data?
        if ($intStatusCode == 201) {
            // Return the raw data - it's a download
            return $strData;   
        }        
        // decode json response to array and check if successful
        if ($arData = json_decode($strData, 1)) {
            // return data
            return $arData;    
        }
        // if we get here, return file contents
        return $strData;        
    }
}
