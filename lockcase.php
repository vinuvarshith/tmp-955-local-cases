<?php

require_once 'lockcase.civix.php';
use CRM_Lockcase_ExtensionUtil as E;

/**
 * Implements hook_civicrm_config().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_config
 */
function lockcase_civicrm_config(&$config) {
  _lockcase_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_xmlMenu().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_xmlMenu
 */
function lockcase_civicrm_xmlMenu(&$files) {
  _lockcase_civix_civicrm_xmlMenu($files);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_install
 */
function lockcase_civicrm_install() {
  _lockcase_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_postInstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_postInstall
 */
function lockcase_civicrm_postInstall() {
  _lockcase_civix_civicrm_postInstall();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_uninstall
 */
function lockcase_civicrm_uninstall() {
  _lockcase_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_enable
 */
function lockcase_civicrm_enable() {
  _lockcase_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_disable
 */
function lockcase_civicrm_disable() {
  _lockcase_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_upgrade
 */
function lockcase_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _lockcase_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_managed
 */
function lockcase_civicrm_managed(&$entities) {
  _lockcase_civix_civicrm_managed($entities);
}

/**
 * Implements hook_civicrm_caseTypes().
 *
 * Generate a list of case-types.
 *
 * Note: This hook only runs in CiviCRM 4.4+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_caseTypes
 */
function lockcase_civicrm_caseTypes(&$caseTypes) {
  _lockcase_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implements hook_civicrm_angularModules().
 *
 * Generate a list of Angular modules.
 *
 * Note: This hook only runs in CiviCRM 4.5+. It may
 * use features only available in v4.6+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_angularModules
 */
function lockcase_civicrm_angularModules(&$angularModules) {
  _lockcase_civix_civicrm_angularModules($angularModules);
}

/**
 * Implements hook_civicrm_alterSettingsFolders().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_alterSettingsFolders
 */
function lockcase_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _lockcase_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

// --- Functions below this ship commented out. Uncomment as required. ---

/**
 * Implements hook_civicrm_preProcess().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_preProcess
 *
function lockcase_civicrm_preProcess($formName, &$form) {

} // */

/**
 * Implements hook_civicrm_navigationMenu().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_navigationMenu
 *
function lockcase_civicrm_navigationMenu(&$menu) {
  _lockcase_civix_insert_navigation_menu($menu, NULL, array(
    'label' => E::ts('The Page'),
    'name' => 'the_page',
    'url' => 'civicrm/the-page',
    'permission' => 'access CiviReport,access CiviContribute',
    'operator' => 'OR',
    'separator' => 0,
  ));
  _lockcase_civix_navigationMenu($menu);
} // */

/**
 * Implements hook_civicrm_entityTypes().
 */
function lockcase_civicrm_entityTypes(&$entityTypes) {
  $entityTypes[] = array(
    'name'  => 'CaseContactLock',
    'class' => 'CRM_Civicase_DAO_CaseContactLock',
    'table' => 'civicase_contactlock',
  );
}

/**
 * Implements hook_civicrm_queryObjects().
 */
function lockcase_civicrm_queryObjects(&$queryObjects, $type) {
  if ($type == 'Contact') {
    $queryObjects[] = new CRM_Civicase_BAO_Query();
  }
}

/**
 * Implements hook_civicrm_permission_check().
 */
function lockcase_civicrm_permission_check($permission, &$granted) {
  $permissionsChecker = new CRM_Civicase_Hook_Permissions_Check();
  $granted = $permissionsChecker->validatePermission($permission, $granted);
}

/**
 * Implements hook_civicrm_apiWrappers().
 */
function lockcase_civicrm_apiWrappers(&$wrappers, $apiRequest) {
  //&apiWrappers is an array of wrappers, you can add your(s) with the hook.
  // You can use the apiRequest to decide if you want to add the wrapper (eg. only wrap api.Contact.create)
  if ($apiRequest['entity'] == 'Case' && $apiRequest['action'] == 'getcaselist') {
    $wrappers[] = new CRM_Lockcase_APIWrapper();
  }
}

/**
 * Implements hook_civicrm_alterAngular().
 */
function lockcase_civicrm_alterAngular(&$angular) {
  // add lock case action
  $lockCase = array(
    'title' => ts('Lock Case'),
    'action' => 'lockCases(cases[0])',
    'number' => 1,
    'icon' => 'fa-lock',
  );
  '<li ng-class="{disabled: !isActionEnabled(action)}" ng-if="isActionAllowed(action)" ng-repeat="action in caseActions">' +
  '  <a href ng-click="doAction(action)"><i class="fa {{action.icon}}"></i> {{ action.title }}</a>' +
  '</li>';
  $changeSet = \Civi\Angular\ChangeSet::create('lockcase')
    // ->requires('crmMailing', 'mailwords')
    ->alterHtml('~/civicase/CaseViewHeader.html',
      function (phpQueryObject $doc) {
        $doc->find('.crm-group')->append('
        <div crm-ui-field="{name: \'subform.mailwords\', title: ts(\'Keywords\')}">
          <input crm-ui-id="subform.mailwords" class="crm-form-text" name="mailwords" ng-model="mailing.template_options.keywords">
        </div>
      ');
      });
  //$angular->add($changeSet);
}

