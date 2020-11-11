<?php
/** @var modX $modx */
/** @var array $sources */

$settings = array();

$tmp = array(
    'merchant_id' => array(
        'xtype' => 'numberfield',
        'value' => '0',
        'area' => 'ms2_payment_assist_main',
    ),
    'secret' => array(
        'xtype' => 'textfield',
        'value' => 'secretword',
        'area' => 'ms2_payment_assist_main',
    ),
    'server_name' => array(
        'xtype' => 'textfield',
        'value' => 'payments.demo.paysecure.ru',
        'area' => 'ms2_payment_assist_main',
    ),
    'virtual_form_page_url' => array(
        'xtype' => 'textfield',
        'value' => 'assist_pay_process',
        'area' => 'ms2_payment_assist_main',
    ),
    'login' => array(
        'xtype' => 'textfield',
        'value' => '',
        'area' => 'ms2_payment_assist_main',
    ),
    'password' => array(
        'xtype' => 'textfield',
        'value' => '',
        'area' => 'ms2_payment_assist_main',
    ),
    'success_page_id' => array(
        'xtype' => 'numberfield',
        'value' => '0',
        'area' => 'ms2_payment_assist_main',
    ),
);

foreach ($tmp as $k => $v) {
    /** @var modSystemSetting $setting */
    $setting = $modx->newObject('modSystemSetting');
    $setting->fromArray(array_merge(
        array(
            'key' => 'ms2_payment_assist_' . $k,
            'namespace' => 'minishop2',
        ), $v
    ), '', true, true);

    $settings[] = $setting;
}
unset($tmp);

return $settings;
