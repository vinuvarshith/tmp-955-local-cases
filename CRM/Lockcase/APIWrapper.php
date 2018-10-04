<?php

class CRM_Lockcase_APIWrapper implements API_Wrapper {
  /**
   * the wrapper contains a method that allows you to alter the parameters of the api request (including the action and the entity)
   */
  public function fromApiInput($apiRequest) {
    //
    return $apiRequest;
  }

  /**
   * alter the result before returning it to the caller.
   */
  public function toApiOutput($apiRequest, $result) {
    if ($apiRequest['entity'] == 'Case' && $apiRequest['action'] == 'getcaselist') {
      $loggedContactID = CRM_Core_Session::singleton()->getLoggedInContactID();
      foreach ($result['values'] as &$case) {
        $caseLockedContacts = civicrm_api3('CaseContactLock', 'get', array(
          'case_id' => $case['id'],
          'contact_id' => $loggedContactID,
        ));

        // If case is locked for current user, activities should not be sent in reponse.
        if ($caseLockedContacts['count'] > 0) {
          $case['activity_summary'] = array();
          $case['lock'] = 1;
        } else {
          $case['lock'] = 0;
        }
      }
    }
    return $result;
  }
}
