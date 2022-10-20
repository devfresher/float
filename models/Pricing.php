<?php 
require_once MODEL_DIR.'Utility.php';
require_once MODEL_DIR.'Plans.php';
require_once MODEL_DIR.'Products.php';

class Pricing extends Utility
{
    protected $responseBody;
    
    public function __construct($db)
    {
        $this->db = $db;
        
        $this->table = new stdClass();
        $this->table->plan = 'plan';
        $this->table->product = 'product';
        $this->table->product_plan = 'product_plan';
    }

    public function updatePricingTable()
    {
        $plan = new Plans($this->db);
        $product = new Products($this->db);

        $allPlans = $plan->getAllPlans();
        $allProducts = $product->getAllProducts();

        $sql = "";
        foreach ($allPlans as $planIndex => $planItem) {
            foreach ($allProducts as $productIndex => $productItem) {
                $sql .= "insert into product_plan (plan_id, product_id, category) values ('".$planItem['id']."', '".$productItem['prodID']."', '".$productItem['category']."');";
            }
        }

        $this->db->multiInsert($sql);
    }
}


?>