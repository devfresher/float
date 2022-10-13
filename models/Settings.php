<?php
require_once MODEL_DIR.'Utility.php';

class Settings extends Utility {
    protected $responseBody;

    public function __construct($db) {
        $this->db = $db;
        $this->table = new stdClass();
        $this->table->settings = 'settings';
    }

    public function getAllSettings() {
        $allSettings = $this->db->getAllRecords($this->table->settings, "*",  " ORDER BY name asc");
        if($allSettings != NULL) {
            foreach($allSettings as $key => $record) {
                $feedback[$record['name']] = $record['value'];
            }
            $this->responseBody = $this->arrayToObject($feedback);
    
            return $this->responseBody;
        }
        else {
            $this->responseBody = false;
        }
        return $this->responseBody;
    }

}
?>