<?php
    require "../includes/config.php";
    require MODEL_DIR.'Products.php';

    $plan = new Plans($db);
    $product = new Products($db);

    $allPlans = $plan->getAllPlans();
    $allProducts = $product->getAllProducts();

    $sql = "";
    foreach ($allPlans as $planIndex => $planItem) {
        foreach ($allProducts as $productIndex => $productItem) {
            $sql .= "insert into product_plan (plan_id, product_id, category) values ('".$planItem['id']."', '".$productItem['prodID']."', '".$productItem['category']."');";
        }
    }
?>