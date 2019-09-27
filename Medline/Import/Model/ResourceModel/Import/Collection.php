<?php

namespace Medline\Import\Model\ResourceModel\Import;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Medline\Import\Model\Import', 'Medline\Import\Model\ResourceModel\Import');
        $this->_map['fields']['page_id'] = 'main_table.page_id';
    }

}
?>