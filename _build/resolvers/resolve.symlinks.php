<?php
/** @var xPDOTransport $transport */
/** @var array $options */
/** @var modX $modx */
if ($transport->xpdo) {
    $modx =& $transport->xpdo;

    $dev = MODX_BASE_PATH . 'mspAssist/';
    /** @var xPDOCacheManager $cache */
    $cache = $modx->getCacheManager();
    if (file_exists($dev) && $cache) {
        if (!is_link($dev . 'assets/components/mspassist')) {
            $cache->deleteTree(
                $dev . 'assets/components/mspassist/',
                ['deleteTop' => true, 'skipDirs' => false, 'extensions' => []]
            );
            symlink(MODX_ASSETS_PATH . 'components/mspassist/', $dev . 'assets/components/mspassist');
        }
        if (!is_link($dev . 'core/components/mspassist')) {
            $cache->deleteTree(
                $dev . 'core/components/mspassist/',
                ['deleteTop' => true, 'skipDirs' => false, 'extensions' => []]
            );
            symlink(MODX_CORE_PATH . 'components/mspassist/', $dev . 'core/components/mspassist');
        }
    }
}

return true;