<?php

class mspAssist
{
    /** @var modX $modx */
    public $modx;


    /**
     * @param modX $modx
     * @param array $config
     */
    function __construct(modX &$modx, array $config = array())
    {
        $this->modx =& $modx;

        $corePath = $this->modx->getOption('ms2_payment_assist_core_path', $config,
            $this->modx->getOption('core_path') . 'components/mspassist/'
        );
        $assetsUrl = $this->modx->getOption('ms2_payment_assist_assets_url', $config,
            $this->modx->getOption('assets_url') . 'components/mspassist/'
        );
        $connectorUrl = $assetsUrl . 'connector.php';

        $this->config = array_merge(array(
            'assetsUrl' => $assetsUrl,
            'cssUrl' => $assetsUrl . 'css/',
            'jsUrl' => $assetsUrl . 'js/',
            'imagesUrl' => $assetsUrl . 'images/',
            'connectorUrl' => $connectorUrl,

            'corePath' => $corePath,
            'modelPath' => $corePath . 'model/',
            'chunksPath' => $corePath . 'elements/chunks/',
            'templatesPath' => $corePath . 'elements/templates/',
            'chunkSuffix' => '.chunk.tpl',
            'snippetsPath' => $corePath . 'elements/snippets/',
            'processorsPath' => $corePath . 'processors/',

            'merchantId' => $this->modx->getOption('ms2_payment_assist_merchant_id', null, 0),
            'secret' => $this->modx->getOption('ms2_payment_assist_secret', null, 'secretword'),
            'login' => $this->modx->getOption('ms2_payment_assist_login', null, ''),
            'password' => $this->modx->getOption('ms2_payment_assist_password', null, ''),
            'successPageId' => $this->modx->getOption('ms2_payment_assist_success_page_id', null, 0),
            'urlReturn' => $this->modx->getOption('ms2_payment_assist_url_return', null, 'assets/components/mspassist/callback.php'),
            'serverName' => $this->modx->getOption('ms2_payment_assist_server_name', null, 'payments.demo.paysecure.ru'),
            'virtualFormPageUrl' => $this->modx->getOption('ms2_payment_assist_virtual_form_page_url', null, '/assist_pay_process'),
        ), $config);

        $this->modx->addPackage('mspassist', $this->config['modelPath']);
        $this->modx->lexicon->load('mspassist:default');
    }

    public function getForm ($orderId)
    {
        if ($order = $this->modx->getObject('msOrder', $orderId)) {

            $post_variables = array(
                'Merchant_ID' => $this->config['merchantId'],
                'OrderNumber' => $orderId,
                'OrderAmount' => $order->get('cost'),
                'FirstName' => $order->Address->receiver,
                'LastName' => $order->Address->receiver,
                'Email' => $order->UserProfile->email,
                'MobilePhone' => $order->Address->phone,
                'CardPayment' => true,
                'YMPayment' => true,
                'QIWIPayment' => true,

                'URL_RETURN_OK' => $this->modx->getOption('site_url') . $this->config['urlReturn'] . '?ordernumber=' . $orderId,
                'URL_RETURN_NO' => $this->modx->getOption('site_url') . $this->config['urlReturn'] . '?ordernumber=' . $orderId,
                'CheckValue' => strtoupper(md5(strtoupper(md5($this->config['secret']) . md5($this->config['merchantId'] . ';' . $orderId . ';' . $order->cost . ';'/*.$currency_code_3*/)))),
                'CheckValueCheck' => $this->config['merchantId'] . ';' . $orderId . ';' . $order->cost . ';'
//            'OrderCurrency' => $currency_code_3,
//            'Middlename' => $address->middle_name,
//            'Address' => $address->address_1,
//            'HomePhone' => $address->phone_2,
//            'Fax' => $address->fax,
//            'Country' => ShopFunctions::getCountryByID($address->virtuemart_country_id, 'country_3_code'),
//            'State' => isset($address->virtuemart_state_id) ? ShopFunctions::getStateByID($address->virtuemart_state_id) : '',
//            'City' => $address->city,
//            'Zip' => $address->zip,
                /*.$currency_code_3*/,
            );

            $url = 'https://' . $this->config['serverName'] . '/pay/order.cfm';
            $html = '<html><head><title>Перенаправление...</title></head><body><div style="margin: auto; text-align: center;">';
            $html .= '<form action="' . $url . '" method="post" name="vm_' . $this->_name . '_form">';
            $html .= '<input type="image" name="submit" src="https://www.assist.ru/images/icons/logo.svg" alt="assist.ru" />';

            foreach ($post_variables as $name => $value) {
                if (trim($value)) {
                    $html .= '<input type="hidden" name="' . $name . '" value="' . htmlspecialchars($value) . '" />' . PHP_EOL;
                }
            }

            $html .= '</form></div>';
            $html .= '<script type="text/javascript">';
            $html .= 'document.vm_'.$this->_name.'_form.submit();';
            $html .= '</script></body></html>';

            return $html;
        } else {
            return 'No order';
        }
    }

}