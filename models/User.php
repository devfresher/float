<?php 
require_once MODEL_DIR."Settings.php";
require_once MODEL_DIR."Monnify.php";

class User extends Utility {
    protected $responseBody;


    public function __construct($db) {
        $this->db = $db;
        $this->table = new stdClass();
        $this->table->users = 'users';
        $this->table->usermeta = 'users_meta';

        $this->settings = new Settings($this->db);
        $this->monnify = new Monnify($this->db);
    }   

    public function createMember($userData) {
        try {
            $userData['monnify_ref'] = $this->randID(12, 'numeric');
            $createUser = $this->db->insert($this->table->users, $userData);
            
            // User id of the member created
            $userId = $this->db->lastInsertId();
            
            $this->db->beginTransaction();
            if($createUser) {

                $generateMonnify = $this->monnify->reserveAccount($userData['fullname'], $userData['email'], $userData['monnify_ref']);
                if($generateMonnify === false) {
                    $this->responseBody =  false;
                    $this->db->rollBack();
                }
                else {

                    // All User Meta Data...
                    $userMetaData['main_wallet'] = (float) 0;
                    $userMetaData['cashback_wallet'] = (float) 0;
                    $userMetaData['referral_wallet'] = (float) 0;
                    $userMetaData['float_wallet'] = (float) 0;
                    $userMetaData['winning_wallet'] = (float) 0;
                    $userMetaData['wallet_funding_bonus'] = (float) 0;

                    // User monnify...
                    $encodeMonnify = json_encode($generateMonnify);
                    $userMetaData['monnify'] = $encodeMonnify;
                    $userMetaData['plan_id'] = $this->settings->getAllSettings()->defaultPlan;

                    // Let's create user meta data...
                    $this->createUserMeta($userId, $userMetaData);
                    
                    $this->responseBody =  true;
                    $this->db->commit();
                }
            } 
            else {
                $this->responseBody =  false;
                $this->db->rollBack();
            }
        }
        catch(Throwable $e) {
            echo $e->getMessage();
            $this->responseBody = false;
        }
        return $this->responseBody;
    }

    function getUserByMobileNo($mobile_no) {

        $result = $this->db->getSingleRecord($this->table->users, "*", "AND mobile_no = '$mobile_no'");
        
        if ($result) {
            $userId = $result['id'];
            $this->responseBody = $this->getUserById($userId);
        }else {
            $this->responseBody = false;
        }
        
        return $this->responseBody;
    }

    function getUserByUsername($username) {
        // $plan = new Plan($this->db);
        // $role = new Role($this->db);
        // $wallet = new Wallet($this->db);

        $result = $this->db->getSingleRecord($this->table->users, "*", "AND username = '$username'");
        
        if ($result) {
            $userId = $result['id'];
            $this->responseBody = $this->getUserById($userId);
        }else {
            $this->responseBody = false;
        }
        
        return $this->responseBody;
    }

    private function createUserMeta($userId, $userMetaData) {
        $theUser = $this->getUserById($userId);
        
        if ($theUser != false) {    
            $index = 0;        
            foreach ($userMetaData as $key => $value) {
                $userMeta[$index]['key'] = $key;
                $userMeta[$index]['value'] = $value;
                $userMeta[$index]['user_id'] = $userId;
                
                $index++;
            }
            
            $insert = $this->db->multiInsert($this->table->usermeta, $userMeta);

            if ($insert > 0) {
                $this->responseBody =  true;
            } else {
                $this->responseBody =  false;
            }
        } else {
            $this->responseBody = false;
        }

        return $this->responseBody;
    }

    public function getUserById($userId) {
        try {
            $result = $this->db->getSingleRecord($this->table->users, "*", "AND id = '$userId'");
            if ($result) {
                $this->responseBody = $this->arrayToObject($result);
                $this->responseBody->userMeta = $this->getUserMeta($userId);
            }
            else {
                $this->responseBody = false;
            }
        }
        catch(Throwable $exception) {
            $exception->getMessage();
            $this->responseBody = false;
        }
        return $this->responseBody;
    }

    private function getUserMeta($userId) {
        $result = $this->db->getAllRecords($this->table->usermeta, "*", "AND user_id = '$userId'");
        foreach($result as $index => $value) {
            $meta[$result[$index]['key']] = $result[$index]['value'];
        }
        return $this->arrayToObject($meta);
    }

    public function hashPassword($password) {
        $hash = password_hash($password, PASSWORD_BCRYPT, array('cost' => 12));

        $this->responseBody = $hash;
        return $this->responseBody;
    }

    public function isLoggedIn () {
        if ($this->loggedInUser() !== false) {
            $this->responseBody = true;
        }else {
            $this->responseBody = false;
        }

        return $this->responseBody;
    }
    
    public function loggedInUser()
    {

        if (isset($_SESSION['userid']) AND !empty($_SESSION['userid'])) {
            $userId = $_SESSION['userid'];
        } else {
            return false;
        }

        $result = $this->getUserById($userId);
        if ($result !== false) {
            unset($result->password);

            $this->responseBody = $result;
        }else {
            $this->responseBody = false;
        }

        return $this->responseBody;
    }

    public function getAllUsers()
    {
        $result = $this->db->getAllRecords($this->table->users, "*", "ORDER BY date_created DESC");

        if (count($result) > 0) {
            foreach ($result as $index => $user) {
                $users[$index] = $this->getUserById($user['id']);
            }
            $this->responseBody = $users;
        }else {
            $this->responseBody = false;
        }
        
        return $this->responseBody;
    }

    public function getFloatUsers()
    {
        $allUsers = $this->getAllUsers();

        if (count($allUsers) > 0) {
            foreach ($allUsers as $index => $user) {
                if ($user->userMeta->float_wallet > 0) {
                    $floatingUsers[] = $user;
                }
            }
            $this->responseBody = isset($floatingUsers) ? $floatingUsers:false;
        }else {
            $this->responseBody = false;
        }
        
        return $this->responseBody;
    }
    
    public function updateUser($userData, $userId) {

        if(array_key_exists("user_meta", $userData)) {
                        
            $userMeta = $userData['user_meta'];
            unset($userData['user_meta']);

            $isUpdated = $this->db->update($this->table->users, $userData, ['id' => $userId]);

            foreach($userMeta as $metaKey => $metaValue) {

                $searchMeta = $this->db->getRecFrmQry("select * from ".$this->table->usermeta." where `key` = '$metaKey' AND user_id = '$userId'");

                if(count($searchMeta) > 0) {                
                    $metaValue = ['value' => $metaValue];
                    $this->db->update_new($this->table->usermeta, $metaValue , " AND `key` ='".$metaKey."' AND `user_id` = '$userId'");
                } else {
                    $this->db->insert($this->table->usermeta, ['`key`' => $metaKey, 'value' => $metaValue, 'user_id' => $userId]);
                }
            }
        }
        else {
            $isUpdated = $this->db->update($this->table->users, $userData, ['id' => $userId]);
        }

        if($isUpdated) {
            $this->responseBody = true;
        }
        else {
            $this->responseBody = false;
        }
        return $this->responseBody;

    }
}
