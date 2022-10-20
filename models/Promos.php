<?php
require_once MODEL_DIR.'Utility.php';

class Promos extends Utility {
    protected $responseBody;

    public function __construct($db) {
        $this->db = $db;
        $this->table = new stdClass();
        $this->table->promos = 'promos';
    }

    public function getAllPromo($category = "") {
        if($category == "") {
            $result = $this->db->getAllRecords($this->table->promos, "*", "");
        } else {
            $result = $this->db->getAllRecords($this->table->promos, "*", " AND promo_category ='$category'");
        }

        if($result != NULL) {
            $this->responseBody = $this->arrayToObject($result);
        } else {
            $this->responseBody = false;
        }
        return $this->responseBody;
    }

    public function getPromoById($promoId) {
        $result = $this->db->getSingleRecord($this->table->promos, "*", " AND id ='$promoId'");
        
        if($result != NULL) {
            $this->responseBody = $this->arrayToObject($result);
        } else {
            $this->responseBody = false;
        }
        return $this->responseBody;
    }

    public function getPromoByReference($promoRef) {
        $result = $this->db->getSingleRecord($this->table->promos, "*", " AND promo_reference ='$promoRef'");
        
        if($result != NULL) {
            $this->responseBody = $this->getPromoById($result['id']);
        } else {
            $this->responseBody = false;
        }
        return $this->responseBody;
    }

}