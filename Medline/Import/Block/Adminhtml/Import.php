<?php

namespace Medline\Import\Block\Adminhtml;

class Import extends \Magento\Backend\Block\Widget\Container
{
    /**
     * @var string
     */
    protected $_template = 'import/import.phtml';

    /**
     * @param \Magento\Backend\Block\Widget\Context $context
     * @param array $data
     */
    public function __construct(\Magento\Backend\Block\Widget\Context $context,array $data = [])
    {
        parent::__construct($context, $data);
    }

    /**
     * Prepare button and grid
     *
     * @return \Magento\Catalog\Block\Adminhtml\Product
     */
    protected function _prepareLayout()
    {

		
        $addButtonProps = [
            'id' => 'add_new',
            'label' => __('Add New'),
            'class' => 'add',
            'button_class' => '',
            'class_name' => 'Magento\Backend\Block\Widget\Button\SplitButton',
            'options' => $this->_getAddButtonOptions(),
        ];
        $this->buttonList->add('add_new', $addButtonProps);
        
        $addButtonPropsImport = [
            'id' => 'add_new_json',
            'label' => __('Import Json'),
            'class' => 'add',
            'button_class' => '',
            'class_name' => 'Magento\Backend\Block\Widget\Button\SplitButton',
            'options' => $this->_getAddButtonOptionsImport(),
        ];
        $this->buttonList->add('add_new_json', $addButtonPropsImport);

        $this->setChild(
            'grid',
            $this->getLayout()->createBlock('Medline\Import\Block\Adminhtml\Import\Grid', 'medline.import.grid')
        );
        return parent::_prepareLayout();
    }

    /**
     *
     *
     * @return array
     */
    protected function _getAddButtonOptions()
    {

        $splitButtonOptions[] = [
            'label' => __('Add New'),
            'onclick' => "setLocation('" . $this->_getCreateUrl() . "')"
        ];

        return $splitButtonOptions;
    }

    protected function _getAddButtonOptionsImport()
    {

        $splitButtonOptions[] = [
            'label' => __('Import Json'),
            'onclick' => "setLocation('" . $this->_getCreateUrlImport() . "')"
        ];

        return $splitButtonOptions;
    }

    /**
     *
     *
     * @param string $type
     * @return string
     */
    protected function _getCreateUrl()
    {
        return $this->getUrl(
            'import/*/new'
        );
    }
    protected function _getCreateUrlImport()
    {
        
        return $this->getUrl(
            'import/index/index'
        );
    }

    /**
     * Render grid
     *
     * @return string
     */
    public function getGridHtml()
    {
        return $this->getChildHtml('grid');
    }

}