<?php

/**
 * PostcodeAT.Importstatistikaustria API specification (optional)
 * This is used for documentation and validation.
 *
 * @param array $spec description of fields supported by this API call
 * @return void
 * @see http://wiki.civicrm.org/confluence/display/CRM/API+Architecture+Standards
 */
function _civicrm_api3_postcode_a_t_Importstatistikaustria_spec(&$spec) {
  $spec['zipfile']['title'] = "Path to zip file if available locally";
}

/**
 * PostcodeAT.Importstatistikaustria API
 *
 * @param array $params
 * @return array API result descriptor
 * @see civicrm_api3_create_success
 * @see civicrm_api3_create_error
 * @throws API_Exception
 */
function civicrm_api3_postcode_a_t_Importstatistikaustria($params) {
  try {
    set_time_limit(-1);
    if (!empty($params['zipfile'])) {
      $db = new CRM_Postcodeat_ImportStatistikAustria($params['zipfile']);
    }
    else {
      $db = new CRM_Postcodeat_ImportStatistikAustria();
    }

    // Put data in temporary table
    $db->importStatistikAustria();
    // Overwrite live table
    $db->copy();
    return civicrm_api3_create_success(1, $params, 'PostcodeAT', 'Importstatistikaustria');
  }
  catch (Exception $e) {
    throw new API_Exception(/*errorMessage*/ 'Import failed: ' . $e->getMessage(), /*errorCode*/ 1);
  }
}
