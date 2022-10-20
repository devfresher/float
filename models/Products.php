<?php
require_once MODEL_DIR.'Utility.php';

class Products extends Utility {
    protected $responseBody;


    public function __construct($db) {
        $this->db = $db;
        $this->table = new stdClass();
        $this->table->product = 'product';
    }

    public function getProductById($productId) {
        $result = $this->db->getSingleRecord($this->table->product, "*", " AND prodID='$productId'");
        
        if($result != NULL) {
            $this->responseBody = $this->arrayToObject($result);
        }
        else {
            $this->responseBody = false;
        }
        return $this->responseBody;
    }

    public function getAllProducts() {
        $result = $this->db->getAllRecords($this->table->product, "*");

        if($result != NULL) {
            $this->responseBody = ($result);
        }
        else {
            $this->responseBody = false;
        }
        return $this->responseBody;
    }
}