<?php
require_once MODEL_DIR.'Utility.php';
require_once MODEL_DIR.'Settings.php';
require_once MODEL_DIR.'Promos.php';
require_once MODEL_DIR.'Language.php';

class BuyWin extends Utility {
    protected $responseBody;

    public function __construct($db) {
        $this->db = $db;
        $this->settings = new Settings($this->db);
        $this->promos = new Promos($this->db);
        $this->language = new Language($this->db);
        $this->table = new stdClass();
        $this->table->ticketcategory = 'ticketcategory';
    }
    
    private function buyWinSettings() {
        return json_decode($this->settings->getAllSettings()->buyWinOffer);
    }
    
    public function getBuyWinOffers() {
        if($this->buyWinSettings()->isActive) {
            $this->responseBody = $this->promos->getAllPromo('buywin');
        }
        else {
            $_SESSION['formErrorMessage'] = $this->language->buyWin_notActive;
            $this->responseBody = false;
        }
        return $this->responseBody;
    }

    public function getBuyWinPackageByReference($orderRef) {
        $this->responseBody = $this->promos->getPromoByReference($orderRef);
        return $this->responseBody;
    }

}