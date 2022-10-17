<?php
require_once MODEL_DIR.'Utility.php';
require_once MODEL_DIR.'User.php';

class Floats extends Utility {
    protected $responseBody;

    public function __construct($db) {
        $this->db = $db;
        $this->table = new stdClass();
        $this->table->ticketcategory = 'ticketcategory';
        $this->table->floathistory = 'floathistories';
    }

    public function createFloat($floattData) {
        $result = $this->db->insert($this->table->floathistory, $floattData);
        if($result) {
            $this->responseBody = true;
        }
        else {
            $this->responseBody = true;
        }
        return $this->responseBody;
    }

    public function userFloatHistory($userId = '', $limit = 100) {
        if($userId == '') {

        }
        else {
            $result = $this->db->getAllRecords($this->table->floathistory, "*", " AND userid = '$userId' order by id desc limit $limit");
        }

        if($result != NULL) {
            foreach($result as $index => $floatRecord) {
                $user = new User($this->db);
                $receiverId = !empty($floatRecord['receiver_id']) ? $floatRecord['receiver_id']: NULL;

                if($receiverId != NULL) {
                    $receiverInfo = $user->getUserById($receiverId);
                    unset($receiverInfo->password);
                    $result[$index]['receiver'] = $receiverInfo;
                }                
            }
            $this->responseBody = $this->arrayToObject($result);
        }
        else {
            $this->responseBody = false;
        }
        return $this->responseBody;
    }

}