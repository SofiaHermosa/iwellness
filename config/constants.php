<?php
return [
    'request' => [
        1 => 'cash in',
        2 => 'cash out'
    ],
    'user_type' => [
        'system administrator',
        'team leader',
        'member',
        'manager',
        'observer'
    ],
    'complans' => [
        1 => [
            'name' => 'basic',
            'desc' => 'minimum capital of 500 and 12% interest every 8 days with lock in period of 32 days'
        ],
        2 => [
            'name' => 'luxury',
            'desc' => 'minimum capital of 2000 and 20% interest every 8 days with lock in period of 40 days'
        ]
    ],
    'payment_transaction_type' => [
        1 => 'account activation',
        2 => 'ordered product',
        3 => 'monthly earnings',
    ],
    'commision_type' => [
        1 => 'direct referral',
        2 => 'indirect referral',
    ],
    'questions' => [
        1 => 'What is your favorite movie?',
        2 => 'What was the last name of your favorite teacher?',
        3 => 'What is your favorite animal?',
        4 => 'What is your favorite tv series?',
        5 => "What is your mother's maiden name?",
        6 => "What is your dream car?",
        7 => "Who is your childhood hero?",
        8 => "Where did you meet your spouse/partner?",
    ],
    'cashout_mode_of_payment' => [
        'AUB',
        'China Bank',
        'BPI',
        'Union Bank',
        'BDO',
        'GCash',
        'Cebuana',
        'Palawan',
        'LBC',
    ],

    'cashin_mode_of_payment' => [
        'AUB',
        'China Bank',
        'BPI',
        'Union Bank',
        'GCash',
        'Cebuana',
        'Palawan',
        'LBC',
    ],
];

?>