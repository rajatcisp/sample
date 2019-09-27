<?php
namespace Medline\Import\Model;

class Import extends \Magento\Framework\Model\AbstractModel
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Medline\Import\Model\ResourceModel\Import');
    }
}
?>