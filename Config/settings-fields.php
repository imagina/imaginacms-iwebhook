<?php

return [
  'activateUploadsJob' => [
    'value' => '0',
    "onlySuperAdmin" => true,
    'name' => 'iwebhooks::activateDispatchWebhooksJob',
    'type' => 'checkbox',
    'props' => [
      'label' => 'Activar Job de llamar webhooks cada cierto tiempo',
      'trueValue' => "1",
      'falseValue' => "0",
    ]
  ],
];
