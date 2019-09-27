<?php
namespace Medline\Import\Model\ResourceModel;

class Import extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('otcjsonimport', 'id');
    }
}
?>