<?php
if (file_exists(dirname(dirname(dirname(dirname(__FILE__)))) . '/config.core.php')) {
    /** @noinspection PhpIncludeInspection */
    require_once dirname(dirname(dirname(dirname(__FILE__)))) . '/config.core.php';
}
else {
    require_once dirname(dirname(dirname(dirname(dirname(__FILE__))))) . '/config.core.php';
}
/** @noinspection PhpIncludeInspection */
require_once MODX_CORE_PATH . 'config/' . MODX_CONFIG_KEY . '.inc.php';
/** @noinspection PhpIncludeInspection */
require_once MODX_CONNECTORS_PATH . 'index.php';
/** @var mspAssist $mspAssist */
$mspAssist = $modx->getService('mspassist', 'mspAssist', $modx->getOption('mspassist_core_path', null,
        $modx->getOption('core_path') . 'components/mspassist/') . 'model/mspassist/'
);
$modx->lexicon->load('mspassist:default');

// handle request
$corePath = $modx->getOption('mspassist_core_path', null, $modx->getOption('core_path') . 'components/mspassist/');
$path = $modx->getOption('processorsPath', $mspAssist->config, $corePath . 'processors/');
$modx->getRequest();

/** @var modConnectorRequest $request */
$request = $modx->request;
$request->handleRequest(array(
    'processors_path' => $path,
    'location' => '',
));