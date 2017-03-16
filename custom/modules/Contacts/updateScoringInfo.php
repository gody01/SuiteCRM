<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

class LeadsUpdateScoringHook {

    function __construct() {
    }

    /**
     * @deprecated deprecated since version 7.6, PHP4 Style Constructors are deprecated and will be remove in 7.8, please update your code, use __construct instead
     */
    function LeadsUpdateScoringHook(){
        $deprecatedMessage = 'PHP4 Style Constructors are deprecated and will be remove in 7.8, please update your code';
        if(isset($GLOBALS['log'])) {
            $GLOBALS['log']->deprecated($deprecatedMessage);
        }
        else {
            trigger_error($deprecatedMessage, E_USER_DEPRECATED);
        }
        self::__construct();
    }


    function updateScoring($bean, $event, $arguments) {
        // before_save
        
        global $timedate;
        
        if(empty($bean->id)){
            return false ;
        } else {

            $saved_score = $bean->total_score_c ;

            $bean->total_score_c = $bean->decision_maker_c * 5 ;

            switch ($bean->decision_timeframe_c) {
                case "m_empty":
                    $bean->total_score_c += 0 ;
                break;

                case "m1_3":
                    $bean->total_score_c += 60 ;
                break;
                
                case "m3_6":
                    $bean->total_score_c += 40 ;
                break;
                
                case "m6_9":
                    $bean->total_score_c += 30 ;
                break;
                
                case "m9_12":
                    $bean->total_score_c += 20 ;
                break;
                
                case "m12_":
                    $bean->total_score_c += 5 ;
                break;

            }

            $bean->total_score_c += $bean->blog_signup_c * 5 ;            
            $bean->total_score_c += $bean->has_budget_c * 20 ;
            $bean->total_score_c += $bean->nda_signed_c * 10 ;
            $bean->total_score_c += $bean->project_defined_c * 35 ;
            $bean->total_score_c += $bean->web_downloads_c * 5 ;

            if ( $bean->total_score_c != $saved_score ) {
                $bean->total_score_changed_date_c = $timedate->getInstance()->nowDb() ;
            }
        } 
        
    }

}
