<?php
/**
 * Created by IntelliJ IDEA.
 * User: mekdr
 * Date: 1/13/2017
 * Time: 9:11 PM
 */

return [
    'container' => [
        'processor' => \App\Processors\DefaultProcessor::class,
        'writer' => \App\Writers\StdoutWriter::class
    ],
    'currencies' => [
        'EUR' => 1.0,
        'USD' => 1.1497,
        'JPY' => 129.53
    ],
    'rules' => [
        \App\Enum\UserType::INDIVIDUAL => [
            \App\Enum\CashFlowType::IN => [
                'default_commission' => [
                    'value' => 0.03,
                    'percent' => true
                ],
                'max_commision' => [
                    'value' => 5.00,
                    'percent' => false
                ]
            ],
            \App\Enum\CashFlowType::OUT => [
                'default_commission' => [
                    'value' => 0.3,
                    'percent' => true
                ],
                'free_per_week' => [
                    'value' => 1000.00,
                    'percent' => false,
                    'op_count' => 3
                ]
            ]
        ],
        \App\Enum\UserType::JURIDICAL => [
            \App\Enum\CashFlowType::OUT => [
                'default_commission' => [
                    'value' => 0.3,
                    'percent' => true
                ],
                'min_commision' => [
                    'value' => 0.50,
                    'percent' => false
                ]
            ],
            \App\Enum\CashFlowType::IN => [
                'default_commission' => [
                    'value' => 0.03,
                    'percent' => true
                ],
                'max_commision' => [
                    'value' => 5.00,
                    'percent' => false
                ]
            ]
        ]
    ]
];