<?php
/** @var modX $modx */
define('MODX_API_MODE', true);
/** @noinspection PhpIncludeInspection */
$dir = dirname(__FILE__);
$subdirs = array('', 'www');
$subdir = '';

for ($i = 0; $i <= 10; $i++) {
    foreach ($subdirs as $subdir) {
        $path = $dir . '/' . $subdir;
        $filePath = $path . 'index.php';
        if (file_exists($path) and file_exists($filePath)) {
            require_once $filePath;
            break 2;
        }
    }
    $dir = dirname($dir . '/');
}
$modx->getService('error', 'error.modError');

$modx->error->message = null;
/** @var miniShop2 $miniShop2 */
/** @var mspAssist $record */
$miniShop2 = $modx->getService('miniShop2');
$miniShop2->loadCustomClasses('payment');
if (!class_exists('Assist')) {
    exit('Error: could not load payment class "Mollie".');
} elseif (empty($_REQUEST['ordernumber'])) {
    exit('Error: the order id is not specified.');
}

/** @var msOrder $order */
if ($order = $modx->getObject('msOrder', (int) $_REQUEST['ordernumber'])) {
    /** @var Assist $handler */
    $handler = new Assist($order);
    $handler->check($order);
    if ($handler->isPaid()) {
        $response = $handler->receive($order, 2);
    } elseif ($handler->isCancelled()) {
//        $response = $handler->receive($order, 4);
        $response = true;
    } elseif ($handler->isPending()) {
        $response = true;
    } else {
        $response = 'Error: could not process order.';
    }
    if ($response !== true) {
        exit($response);
    } else {
        $modx->sendRedirect($modx->makeurl($modx->getOption('ms2_payment_assist_success_page_id'), '', ['msorder' => $order->id]));
    }
}
exit('Error: unknown');