<?php
/** @var modX $modx */
switch ($modx->event->name) {

    case 'OnPageNotFound':
        if ($_REQUEST['q'] == $modx->getOption('ms2_payment_assist_virtual_form_page_url')) {
            /** @var mspAssist $mspAssist */
            if (($mspAssist = $modx->getService('mspassist', 'mspAssist', $modx->getOption('mspassist_core_path', null,
                    $modx->getOption('core_path') . 'components/mspassist/') . 'model/mspassist/', $scriptProperties))
                && (int) $_REQUEST['id']
            ) {
                @session_write_close();
                exit($mspAssist->getForm((int) $_REQUEST['id']));
            } else {
                return 'Could not load mspAssist class!';
            }
        }
}