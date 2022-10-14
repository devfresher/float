<?php
require_once MODEL_DIR.'Utility.php';

class Pages extends Utility {
    protected $responseBody;

    public function __construct($db) {
        $this->db = $db;
        $this->table = new stdClass();
        $this->table->pages = 'pages';
    }

    public function getPage($page) {
        $result = $this->db->getSingleRecord($this->table->pages, "*", "AND (id = '$page' OR slug = '$page')");

        if ($result != NULL) {
            $this->responseBody = $this->arrayToObject($result);
        }else {
            $this->responseBody = false;
        }
        
        return $this->responseBody;
    }

    public function getAllPages($pageType = '') {

        if ($pageType == '') {
            $result = $this->db->getAllRecords($this->table->pages, "id");
        } else {
            $result = $this->db->getAllRecords($this->table->pages, "id", "AND (access_type = '$pageType')");
        }

        if (count($result) > 0) {
            foreach ($result as $index => $value) {
                $userPage[] = $value['id'];
            }
            $this->responseBody = $userPage;
        }else {
            $this->responseBody = false;
        }
        
        return $this->responseBody;
    }

    public function getParentMenus() {
        $result = $this->db->getAllRecords($this->table->pages, "*", " AND access_type = 'user' AND parent_menu IS NOT NULL group by parent_menu order by id"); 
        if (count($result) > 0) {
            $this->responseBody = $result;
        } else {
            $this->responseBody = false;
        }
        
        return $this->responseBody;
    }

    public function getStandAloneMenu() {
        $result = $this->db->getAllRecords($this->table->pages, "*", " AND access_type = 'user' AND parent_menu IS NULL", " ORDER BY id"); 
        if (count($result) > 0) {
            $this->responseBody = $result;
        } else {
            $this->responseBody = false;
        }
        
        return $this->responseBody;
    }

    public function getSubMenu(string $parentMenu) {
        $subMenus = $this->db->getAllRecords($this->table->pages, "*", " AND parent_menu = '$parentMenu'", " ORDER BY id");
        $pages = [];

        foreach($subMenus as $subMenu) {
            if(in_array($subMenu['id'], $this->getAllPages('user'))) {
                $pages['title'][] = $subMenu['title'];
                $pages['slug'][] = $subMenu['slug'];
            } 
        }
        $this->responseBody = $pages;
        return $this->responseBody;
    }

}
?>