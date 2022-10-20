<?php
require "includes/config.php";

// echo "<pre>";
// print_r($user->getUserById(7));
// echo "</pre>";

// die;
$promoMsg = "This is a promo test

This is a promo test

This is a promo test

This is a promo test

This is a promo test

This is a promo test

This is a promo test

This is a promo test

This is a promo test

This is a promo test

This is a promo test";

$offers = [
    "offer" => [
        "data" => [
            [
                "promoType" => "MTN 10.0GB/30DAYS",
                "amount" => 25000,
                "reward" => "MTN N2000",
                "offer_type" => "digital",
                "description" => $promoMsg,
                "range" => [
                    "total_transaction" => 1000,
                    "transaction_counter" => 25,500,751
                ],
                "isActive" => false
            ],
            [
                "promoType" => "MTN 2.0GB/30DAYS",
                "amount" => 2500,
                "reward" => "Oraimo Headset",
                "offer_type" => "physical",
                "description" => $promoMsg,
                "range" => [
                    "total_transaction" => 50,
                    "transaction_counter" => 2,10,47
                ],
                "isActive" => false
            ],
            [
                "promoType" => "MTN 2.0GB/30DAYS",
                "amount" => 5000,
                "reward" => "Tecno EarBud",
                "offer_type" => "physical",
                "description" => $promoMsg,
                "range" => [
                    "total_transaction" => 100,
                    "transaction_counter" => 31,47,65
                ],
                "isActive" => false
            ],
            [
                "promoType" => "MTN 200GB/30DAYS",
                "amount" => 25000,
                "reward" => "MTN N2000",
                "offer_type" => "digital",
                "description" => $promoMsg,
                "range" => [
                    "total_transaction" => 67,
                    "transaction_counter" => 2,10,47
                ],
                "isActive" => false
            ],
            [
                "promoType" => "MTN 10.0GB/30DAYS",
                "amount" => 25000,
                "reward" => "MTN N2000",
                "offer_type" => "digital",
                "description" => $promoMsg,
                "range" => [
                    "total_transaction" => 1000,
                    "transaction_counter" => 25,500,751
                ],
                "isActive" => false
            ],
            [
                "promoType" => "MTN 2.0GB/30DAYS",
                "amount" => 2500,
                "reward" => "Oraimo Headset",
                "offer_type" => "physical",
                "description" => $promoMsg,
                "range" => [
                    "total_transaction" => 50,
                    "transaction_counter" => 2,10,47
                ],
                "isActive" => false
            ],
            [
                "promoType" => "MTN 2.0GB/30DAYS",
                "amount" => 5000,
                "reward" => "Tecno EarBud",
                "offer_type" => "physical",
                "description" => $promoMsg,
                "range" => [
                    "total_transaction" => 100,
                    "transaction_counter" => 31,47,65
                ],
                "isActive" => false
            ],
            [
                "promoType" => "MTN 200GB/30DAYS",
                "amount" => 25000,
                "reward" => "MTN N2000",
                "offer_type" => "digital",
                "description" => $promoMsg,
                "range" => [
                    "total_transaction" => 67,
                    "transaction_counter" => 2,10,47
                ],
                "isActive" => false
            ],
            [
                "promoType" => "MTN 10.0GB/30DAYS",
                "amount" => 25000,
                "reward" => "MTN N2000",
                "offer_type" => "digital",
                "description" => $promoMsg,
                "range" => [
                    "total_transaction" => 1000,
                    "transaction_counter" => 25,500,751
                ],
                "isActive" => false
            ],
            [
                "promoType" => "MTN 2.0GB/30DAYS",
                "amount" => 2500,
                "reward" => "Oraimo Headset",
                "offer_type" => "physical",
                "description" => $promoMsg,
                "range" => [
                    "total_transaction" => 50,
                    "transaction_counter" => 2,10,47
                ],
                "isActive" => false
            ],
            [
                "promoType" => "MTN 2.0GB/30DAYS",
                "amount" => 5000,
                "reward" => "Tecno EarBud",
                "offer_type" => "physical",
                "description" => $promoMsg,
                "range" => [
                    "total_transaction" => 100,
                    "transaction_counter" => 31,47,65
                ],
                "isActive" => false
            ],
            [
                "promoType" => "MTN 200GB/30DAYS",
                "amount" => 25000,
                "reward" => "MTN N2000",
                "offer_type" => "digital",
                "description" => $promoMsg,
                "range" => [
                    "total_transaction" => 67,
                    "transaction_counter" => 2,10,47
                ],
                "isActive" => false
            ]
        ]
    ],
    "isActive" => false
];

echo "<pre>";
    print_r(json_encode($offers));       
echo "</pre>";

?>