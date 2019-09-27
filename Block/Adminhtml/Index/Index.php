<?php

namespace Medline\Import\Block\Adminhtml\Index;

class Index extends \Magento\Backend\Block\Widget\Container
{



    public function __construct(\Magento\Backend\Block\Widget\Context $context,array $data = [])
    {
        parent::__construct($context, $data);
        $this->addButton(
            'my_back_button',
            [
                'label' => __('Back'),
                'onclick' => 'setLocation(\'' . $this->getUrl('import/import/index') . '\')',
                'class' => 'back'
            ],
            -1
        );
    }



}
