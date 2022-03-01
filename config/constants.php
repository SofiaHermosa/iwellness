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
    'positions' => [
        1 => 'system administrator',
        2 => 'manager',
        3 => 'team leader',
        4 => 'observer',
        5 => 'member'
    ],
    'complans' => [
        1 => [
            'name'          => 'basic',
            'desc'          => '- Earn 48% total profit <br> - 32 days lock-in period',
            'sub'           => '(Minimum of 500 pesos)',
            'class'         => 'badge-info',
            'min'           => 500,
            'profit'        => 0.12,
            'locked_in'     => 32 
        ],
        2 => [
            'name'          => 'luxury',
            'desc'          => '- Earn 85% total profit <br> - 40 days lock-in period',
            'sub'           => '(Minimum of 2000 pesos)',
            'class'         => 'badge-warning',
            'min'           => 2000,
            'profit'        => 0.17,
            'locked_in'     => 40 
        ],
        3 => [
            'name'          => 'majestic',
            'desc'          => '- Earn 92.5% total profit <br> - 40 days lock-in period',
            'sub'           => '(Minimum of 5000 pesos)',
            'class'         => 'badge-majestic',
            'min'           => 5000,
            'profit'        => 0.185,
            'locked_in'     => 32,
            'login_bonus'   => 0.007
        ],
    ],
    'payment_transaction_type' => [
        1 => 'account activation',
        2 => 'ordered product',
        3 => 'monthly earnings',
    ],
    'commision_type' => [
        1 => 'direct referral',
        2 => 'indirect referral',
        5 => 'login bonus'
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