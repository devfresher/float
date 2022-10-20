<?php
require_once MODEL_DIR.'Utility.php';

class Plans extends Utility {
    protected $responseBody;


    public function __construct($db) {
        $this->db = $db;
        $this->table = new stdClass();
        $this->table->plans = 'plans';
    }

    public function getPlanById($planId) {
        $result = $this->db->getSingleRecord($this->table->plans, "*", " AND id='$planId'");
        if($result != NULL) {
            $this->responseBody = $this->arrayToObject($result);
        }
        else {
            $this->responseBody = false;
        }
        return $this->responseBody;
    }

    public function getAllPlans() {
        $result = $this->db->getAllRecords($this->table->plans, "*");
        if($result != NULL) {
            $this->responseBody = ($result);
        }
        else {
            $this->responseBody = false;
        }
        return $this->responseBody;
    }
}