<?php

require_once MODEL_DIR."Settings.php";
require_once MODEL_DIR."Banks.php";
require_once CLASS_DIR."Http.php";

class Monnify extends Utility {
    private $v1 = "/api/v1/";
    private $v2 = "/api/v2/";

    protected $responseBody;
    
    private $baseUrl, $apiKey, $secKey, $contractCode, $chargestype, $charges;

    public function __construct($db) {
        $this->db = $db;
        
        $this->settings = new Settings($this->db);
        $this->banks = new Banks($this->db);

        // Get Monnify Info...
        
        $this->baseUrl = $this->monnifyInfo()->baseUrl;
        $this->apiKey = $this->monnifyInfo()->apiKey;
        $this->secKey = $this->monnifyInfo()->secKey;
        $this->contractCode = $this->monnifyInfo()->contractCode;
        $this->chargestype = $this->monnifyInfo()->chargestype;
        $this->charges = $this->monnifyInfo()->charges; // Naira

        $this->header = ["Authorization: Basic ".base64_encode($this->apiKey.':'.$this->secKey)];
    }

    private function monnifyInfo() {
        $getSettings = $this->settings->getAllSettings()->monnify;
        return json_decode($getSettings);
    }

    private function getAuth() {

        $authLink = $this->baseUrl.$this->v1."auth/login";

        return HttpRequest::post($authLink, "", $this->header);
    }

    public function reserveAccount(string $uname, string $email, string $reference) {

        // $this->banks->getAllAutoBanks()
        $allBanks = $this->banks->getAllAutoBanks();

        if($allBanks === false) {
            $this->responseBody = false;
        }
        else {
            $accessToken = json_decode($this->getAuth());

            $accessToken = $accessToken->responseBody->accessToken;
            
            for($i = 0; $i < count($allBanks); $i++) {
                $bank_id = $allBanks[$i]['id'];
                $bank_code[] = $allBanks[$i]['bank_code'];
            }   

            $reserveBody = json_encode([
                "accountReference" => $reference,
                "accountName" => $uname,
                "currencyCode" => "NGN",
                "contractCode" => $this->contractCode,
                "customerEmail" => $email,
                "customerName" => $uname,
                "getAllAvailableBanks" => false,
                "preferredBanks" => $bank_code
            ]);

            $this->header = ["Authorization: Bearer ".$accessToken];

            $generateLink = $this->baseUrl.$this->v2.'bank-transfer/reserved-accounts';
            $reserveResult = HttpRequest::post($generateLink, $reserveBody, $this->header);
            
            $decodeReserve = json_decode($reserveResult, true);

            $getAccount = isset($decodeReserve['responseBody']['accounts']) ? $decodeReserve['responseBody']['accounts'] : false;

            if($getAccount !== false) {
                
                for($i = 0; $i < count($getAccount); $i++) {
                    $bank_code = $getAccount[$i]['bankCode'];
                    $accountNumber = $getAccount[$i]['accountNumber'];
                    $newArray[$bank_code] = $accountNumber;
                }
                $this->responseBody = $newArray;
            }
            else {
                $this->responseBody = false;
            }
        }
        return  $this->responseBody;
    }
}