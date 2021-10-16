<?php

return [
    'database' => [
        'sliders_table' => 'sliders',
        'categories_table' => 'sliders_categories',
    ],

    'routes' => [
        'prefix' => 'api/sliders',
        'middleware' => ['api'],
    ],
];
