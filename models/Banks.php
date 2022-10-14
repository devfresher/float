<?php
require_once MODEL_DIR.'Utility.php';

class Banks extends Utility {
    protected $responseBody;


    public function __construct($db) {
        $this->db = $db;
        $this->table = new stdClass();
        $this->table->auto_banks = 'auto_funding_banks';
    }

    public function getAutoBankId($bankId) {
        $result = $this->db->getSingleRecord($this->table->auto_banks, "*", " AND id='$bankId'");
        if($result != NULL) {
            $this->responseBody = $this->arrayToObject($result);
        }
        else {
            $this->responseBody = false;
        }
        return $this->responseBody;
    }

    public function getAutoBankByCode($bank_code) {
        $result = $this->db->getSingleRecord($this->table->auto_banks, "*", " AND bank_code='$bank_code'");
        if($result != NULL) {
            $this->responseBody = $this->arrayToObject($result);
        }
        else {
            $this->responseBody = false;
        }
        return $this->responseBody;
    }

    public function getAllAutoBanks() {
        $result = $this->db->getAllRecords($this->table->auto_banks, "*");
        if($result != NULL) {
            $this->responseBody = ($result);
        }
        else {
            $this->responseBody = false;
        }
        return $this->responseBody;
    }
}