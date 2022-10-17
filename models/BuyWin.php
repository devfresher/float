<?php
require_once MODEL_DIR.'Utility.php';
require_once MODEL_DIR.'Settings.php';

class BuyWin extends Utility {
    protected $responseBody;

    public function __construct($db) {
        $this->db = $db;
        $this->settings = new Settings($db);
        $this->table = new stdClass();
        $this->table->ticketcategory = 'ticketcategory';
    }


    public function getBuyWinOffers() {
        return json_decode($this->settings->getAllSettings()->buyWinOffer);
    }

}