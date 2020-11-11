<?php

/**
 * The home manager controller for mspAssist.
 *
 */
class mspAssistHomeManagerController extends modExtraManagerController
{
    /** @var mspAssist $mspAssist */
    public $mspAssist;


    /**
     *
     */
    public function initialize()
    {
        $path = $this->modx->getOption('mspassist_core_path', null,
                $this->modx->getOption('core_path') . 'components/mspassist/') . 'model/mspassist/';
        $this->mspAssist = $this->modx->getService('mspassist', 'mspAssist', $path);
        parent::initialize();
    }


    /**
     * @return array
     */
    public function getLanguageTopics()
    {
        return array('mspassist:default');
    }


    /**
     * @return bool
     */
    public function checkPermissions()
    {
        return true;
    }


    /**
     * @return null|string
     */
    public function getPageTitle()
    {
        return $this->modx->lexicon('mspassist');
    }


    /**
     * @return void
     */
    public function loadCustomCssJs()
    {
        $this->addCss($this->mspAssist->config['cssUrl'] . 'mgr/main.css');
        $this->addCss($this->mspAssist->config['cssUrl'] . 'mgr/bootstrap.buttons.css');
        $this->addJavascript($this->mspAssist->config['jsUrl'] . 'mgr/mspassist.js');
        $this->addJavascript($this->mspAssist->config['jsUrl'] . 'mgr/misc/utils.js');
        $this->addJavascript($this->mspAssist->config['jsUrl'] . 'mgr/misc/combo.js');
        $this->addJavascript($this->mspAssist->config['jsUrl'] . 'mgr/widgets/items.grid.js');
        $this->addJavascript($this->mspAssist->config['jsUrl'] . 'mgr/widgets/items.windows.js');
        $this->addJavascript($this->mspAssist->config['jsUrl'] . 'mgr/widgets/home.panel.js');
        $this->addJavascript($this->mspAssist->config['jsUrl'] . 'mgr/sections/home.js');

        $this->addHtml('<script type="text/javascript">
        mspAssist.config = ' . json_encode($this->mspAssist->config) . ';
        mspAssist.config.connector_url = "' . $this->mspAssist->config['connectorUrl'] . '";
        Ext.onReady(function() {
            MODx.load({ xtype: "mspassist-page-home"});
        });
        </script>
        ');
    }


    /**
     * @return string
     */
    public function getTemplateFile()
    {
        return $this->mspAssist->config['templatesPath'] . 'home.tpl';
    }
}