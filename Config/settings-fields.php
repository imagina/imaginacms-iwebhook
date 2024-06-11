<?php

return [
  'activateUploadsJob' => [
    'value' => '0',
    "onlySuperAdmin" => true,
    'name' => 'iwebhooks::activateDispatchWebhooksJob',
    'type' => 'checkbox',
    'props' => [
      'label' => 'iwebhooks::cms.label.activateWebhookJob',
      'trueValue' => "1",
      'falseValue' => "0",
    ]
  ],
];
