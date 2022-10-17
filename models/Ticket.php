<?php
require_once MODEL_DIR.'Utility.php';
require_once MODEL_DIR.'User.php';

class Ticket extends Utility {
    protected $responseBody;

    public function __construct($db) {
        $this->db = $db;
        $this->user = new User($this->db);
        $this->table = new stdClass();
        $this->table->ticketcategory = 'ticketcategory';
        $this->table->tickets = 'tickets';
        $this->table->ticketreplies = 'ticketreplies';
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

    public function getTicketCategoryById($category_id) {
        $result = $this->db->getSingleRecord($this->table->ticketcategory, "*", " AND id='$category_id'");
        if($result != NULL) {
            $this->responseBody = $this->arrayToObject($result);
        } else {
            $this->responseBody = false;
        }
        return $this->responseBody;
    }
    
    public function getAllTickets($creator_id = "") {
        if($creator_id == "") {
            $result = $this->db->getAllRecords($this->table->tickets, "*", "", " ORDER by id desc");
        }
        else {
            $result = $this->db->getAllRecords($this->table->tickets, "*", " AND creator_id='$creator_id'", " ORDER by id desc");
        }
        
        if($result != NULL) {
            $this->responseBody = $result;
        } else {
            $this->responseBody = false;
        }
        return $this->responseBody;
    }

    public function createTicket($ticketData) {
        $result = $this->db->insert($this->table->tickets, $ticketData);
        if($result) {
            $this->responseBody = true;
        }
        else {
            $this->responseBody = true;
        }
        return $this->responseBody;
    }
    
    public function getTicketByReference($reference) {
        $reference = str_replace(array("-"), '', $reference);

        $result = $this->db->getSingleRecord($this->table->tickets, "*", " AND ticket_reference='$reference'", " ORDER by id desc");
        
        if($result != NULL) {
            $this->responseBody = $this->arrayToObject($result);
        } else {
            $this->responseBody = false;
        }
        return $this->responseBody;
    }

    public function createReplyTicket($ticketReplyData) {
        $result = $this->db->insert($this->table->ticketreplies, $ticketReplyData);
        if($result) {
            $this->responseBody = true;
        }
        else {
            $this->responseBody = true;
        }
        return $this->responseBody;
    }
    
    public function getTicketReplyByReference($reference) {
        $reference = str_replace(array("-"), '', $reference);

        $results = $this->db->getAllRecords($this->table->ticketreplies, "*", " AND ticket_reference='$reference'", " ORDER by id desc");
        
        if($results != NULL) {
            foreach($results as $replyIndex => $result) {
                $userObject = $this->user->getUserById($result["user_id"]);
                unset($userObject->password);
                $results[$replyIndex]["user"] = $userObject;
                unset($results[$replyIndex]['user_id']);
            }
            $this->responseBody = $this->arrayToObject($results);
        } else {
            $this->responseBody = false;
        }
        return $this->responseBody;
    }

}