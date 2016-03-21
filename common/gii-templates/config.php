<?php

$config['modules']['gii']['generators'] = [
    'kartikgii-crud' => [ // generator name
        'class' => 'warrence\kartikgii\crud\Generator', // generator class
        'templates' => [ //setting for out templates
            'devleaks' => '@common/gii-templates/crud/devleaks', // template name => path to template
        ],
	],
	'insolita-migration' => ['class' => 'insolita\migrik\gii\Generator'],
];
