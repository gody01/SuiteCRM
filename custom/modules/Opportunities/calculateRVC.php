<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

class OpportunitiesCalculateRVCHook {

    function __construct() {
    }

    /**
     * @deprecated deprecated since version 7.6, PHP4 Style Constructors are deprecated and will be remove in 7.8, please update your code, use __construct instead
     */
    function OpportunitiesCalculateRVCHook(){
        $deprecatedMessage = 'PHP4 Style Constructors are deprecated and will be remove in 7.8, please update your code';
        if(isset($GLOBALS['log'])) {
            $GLOBALS['log']->deprecated($deprecatedMessage);
        }
        else {
            trigger_error($deprecatedMessage, E_USER_DEPRECATED);
        }
        self::__construct();
    }


    function calculateRVC($bean, $event, $arguments) {
        // before_save
        
        global $timedate;
        
        if(empty($bean->id)){
            return false ;
        } else {

        $bean->rvc_c = $bean->beesmart_licence_value_c +
                        $bean->bs_subscription_support_c +
                        $bean->x3rd_party_equipment_c -
                        $bean->x3rd_party_equipment_cost_c +
                        $bean->professional_services_c +
                        $bean->software_customization_c -
                        $bean->project_cost_c ;
        } 
        
    }

}
