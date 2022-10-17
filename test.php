<?php
$offers = [
    "offer" => [
        "airtime" => [
            [
                "promoType" => "MTN N10000",
                "amount" => 25000,
                "reward" => "Oraimo Bluetooth Dustfree",
                "offer_type" => "onsite",
                "description" => "This is a promo test",
                "win_ref" => mt_rand(1111, 9999)
            ],
            [
                "promoType" => "MTN N10000",
                "amount" => 9950,
                "reward" => "MTN 2.0GB SME",
                "offer_type" => "immediate",
                "description" => "This is a promo test",
                "win_ref" => mt_rand(1111, 9999)
            ]
        ],
        "data" => [
            [
                "promoType" => "MTN 25.0GB SME",
                "amount" => 250000,
                "reward" => "MTN N2000",
                "offer_type" => "immediate",
                "description" => "This is a promo test",
                "win_ref" => mt_rand(1111, 9999)
            ],
            [
                "promoType" => "MTN 2.0GB SME",
                "amount" => 2500,
                "reward" => "Oraimo Headset",
                "offer_type" => "onsite",
                "description" => "This is a promo test",
                "win_ref" => mt_rand(1111, 9999)
            ],
            [
                "promoType" => "MTN 2.0GB SME",
                "amount" => 5000,
                "reward" => "Tecno EarBud",
                "offer_type" => "onsite",
                "description" => "This is a promo test",
                "win_ref" => mt_rand(1111, 9999)
            ],
            [
                "promoType" => "MTN 200GB/60 days",
                "amount" => 25000,
                "reward" => "MTN N2000",
                "offer_type" => "immediate",
                "description" => "This is a promo test",
                "win_ref" => mt_rand(1111, 9999)
            ]
        ]
    ],
    "isActive" => true
];

echo "<pre>";
    echo json_encode($offers);       
echo "</pre>";

?>