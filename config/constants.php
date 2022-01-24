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
            'name'  => 'basic',
            'desc'  => '- Earn 48% total profit <br> - 32 days lock-in period',
            'sub'   => '(Minimum of 500 pesos)',
            'class' => 'badge-info',
            'min'   => 500
        ],
        2 => [
            'name'  => 'luxury',
            'desc'  => '- Earn 100% total profit <br> - 40 days lock-in period',
            'sub'   => '(Minimum of 2000 pesos)',
            'class' => 'badge-warning',
            'min'   => 2000
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