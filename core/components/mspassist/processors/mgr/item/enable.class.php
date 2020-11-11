<?php

class mspAssistItemEnableProcessor extends modObjectProcessor
{
    public $objectType = 'mspAssistItem';
    public $classKey = 'mspAssistItem';
    public $languageTopics = array('mspassist');
    //public $permission = 'save';


    /**
     * @return array|string
     */
    public function process()
    {
        if (!$this->checkPermissions()) {
            return $this->failure($this->modx->lexicon('access_denied'));
        }

        $ids = $this->modx->fromJSON($this->getProperty('ids'));
        if (empty($ids)) {
            return $this->failure($this->modx->lexicon('mspassist_item_err_ns'));
        }

        foreach ($ids as $id) {
            /** @var mspAssistItem $object */
            if (!$object = $this->modx->getObject($this->classKey, $id)) {
                return $this->failure($this->modx->lexicon('mspassist_item_err_nf'));
            }

            $object->set('active', true);
            $object->save();
        }

        return $this->success();
    }

}

return 'mspAssistItemEnableProcessor';
