<?php

if (!class_exists('msPaymentInterface')) {
    /** @noinspection PhpIncludeInspection */
    require_once dirname(dirname(dirname(__FILE__))) . '/minishop2/model/minishop2/mspaymenthandler.class.php';
}

class Assist extends msPaymentHandler implements msPaymentInterface
{
    /** @var modX $modx */
    public $modx;
    /** @var array $config */
    public $config;
    /** @var mspAssist $Assist */
    public $Assist;

    /** @var msOrder */
    public $order;
    public $assistState = 'pending';


    /**
     * @param xPDOObject $object
     * @param array $config
     */
    function __construct(xPDOObject $object, $config = [])
    {
        parent::__construct($object, $config);
        $this->order = $object;

        $this->Assist = $this->modx->getService('mspassist', 'mspAssist', $this->modx->getOption('mspassist_core_path', null,
                $this->modx->getOption('core_path') . 'components/mspassist/') . 'model/mspassist/');
    }


    /**
     * @param msOrder $order
     *
     * @return array|string
     *
     */
    public function send(msOrder $order)
    {
        $response = $this->success('', [
            'redirect' => $this->getPaymentLink($order),
        ]);
        return $response;
    }


    /**
     * @param msOrder $order
     *
     * @return string
     */
    public function getPaymentLink(msOrder $order)
    {
        return $this->modx->getOption('site_url') . $this->modx->getOption('ms2_payment_assist_virtual_form_page_url') . '?id=' . $order->id;
    }


    /**
     * @param msOrder $order
     * @param int $status
     *
     * @return bool
     */
    public function receive(msOrder $order, $status = 2)
    {
        if ($order->get('status') == $status) {
            return true;
        }
        /* @var miniShop2 $miniShop2 */
        $miniShop2 = $this->modx->getService('miniShop2');
        $ctx = $order->get('context');
        if ($ctx != 'web') {
            $this->modx->switchContext($ctx);
        }

        return $miniShop2->changeOrderStatus($order->id, $status);
    }

    public function check($order)
    {
        $params = [
            'Ordernumber' => $order->id,
            'Merchant_ID' => $this->Assist->config['merchantId'],
            'Login' => $this->Assist->config['login'],
            'Password' => $this->Assist->config['password'],
            'Format' => 5,
        ];

        /** @var modRest $client */
        $client = $this->modx->getService('rest.modRest');

        $url = 'https://' . $this->Assist->config['serverName'] . '/orderstate/orderstate.cfm';

//        exit($url . PHP_EOL . print_r($params, 1));

        $response = $client->post($url, $params);


        $state = @ $this->modx->fromJSON($response->responseBody)['orderstate'] ?? [0 => 'In Process'];
        $orders = [];
//        foreach ($states as $state) {
            $orders[$state['ordernumber']] = $state['orderstate'];
//        }

        $this->assistState = $orders[$order->id] ?? '';

//        $this->modx->log(1, 'RESPONSE: ' . $response->responseBody);
//        $this->modx->log(1, 'ERROR: ' . $response->headerSize . ' ' . print_r($response->responseInfo, 1));

    }


    public function isPaid ()
    {
        return in_array($this->assistState, ['Approved']);
    }


    public function isPending ()
    {
        return in_array($this->assistState, ['In Process', 'Delayed', 'PartialDelayed']);
    }


    public function isCancelled ()
    {
        return in_array($this->assistState, ['Declined', 'Canceled', 'PartialCanceled', 'Timeout']);
    }
}