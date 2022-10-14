<?php
require_once MODEL_DIR.'Utility.php';

class Ticket extends Utility {
    protected $responseBody;

    public function __construct($db) {
        $this->db = $db;
        $this->table = new stdClass();
        $this->table->ticketcategory = 'ticketcategory';
    }

    public function getAllTicketCategory() {
        $result = $this->db->getAllRecords($this->table->ticketcategory, "*", "");
        if($result != NULL) {
            $this->responseBody = $result;
        } else {
            $this->responseBody = false;
        }
        return $this->responseBody;
    }

    public function createTicket($ticketData) {
        $result = $this->db->insert($this->table->ticket, $ticketData);
        if($result) {
            $this->responseBody = true;
        }
        else {
            $this->responseBody = true;
        }
        return $this->responseBody;
    }

}