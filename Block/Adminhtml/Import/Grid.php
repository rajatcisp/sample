<?php
namespace Medline\Import\Block\Adminhtml\Import;

class Grid extends \Magento\Backend\Block\Widget\Grid\Extended
{
    /**
     * @var \Magento\Framework\Module\Manager
     */
    protected $moduleManager;

    /**
     * @var \Medline\Import\Model\importFactory
     */
    protected $_importFactory;

    /**
     * @var \Medline\Import\Model\Status
     */
    protected $_status;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Backend\Helper\Data $backendHelper
     * @param \Medline\Import\Model\importFactory $importFactory
     * @param \Medline\Import\Model\Status $status
     * @param \Magento\Framework\Module\Manager $moduleManager
     * @param array $data
     *
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        \Medline\Import\Model\ImportFactory $ImportFactory,
        \Medline\Import\Model\Status $status,
        \Magento\Framework\Module\Manager $moduleManager,
        array $data = []
    ) {
        $this->_importFactory = $ImportFactory;
        $this->_status = $status;
        $this->moduleManager = $moduleManager;
        parent::__construct($context, $backendHelper, $data);
    }

    /**
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('postGrid');
        $this->setDefaultSort('id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(false);
        $this->setVarNameFilter('post_filter');
    }

    /**
     * @return $this
     */
    protected function _prepareCollection()
    {
        $collection = $this->_importFactory->create()->getCollection();
        $this->setCollection($collection);

        parent::_prepareCollection();

        return $this;
    }

    /**
     * @return $this
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    protected function _prepareColumns()
    {
        $this->addColumn(
            'id',
            [
                'header' => __('ID'),
                'type' => 'number',
                'index' => 'id',
                'header_css_class' => 'col-id',
                'column_css_class' => 'col-id'
            ]
        );


		
				$this->addColumn(
					'member_id',
					[
						'header' => __('Member ID'),
						'index' => 'member_id',
					]
				);
				
				$this->addColumn(
					'plan_id',
					[
						'header' => __('Plan ID'),
						'index' => 'plan_id',
					]
				);
				
				$this->addColumn(
					'provider_id',
					[
						'header' => __('Provider ID'),
						'index' => 'provider_id',
					]
				);
				
				$this->addColumn(
					'dob',
					[
						'header' => __('Date of Birth'),
						'index' => 'dob',
						'type'      => 'datetime',
					]
				);
					
					
				$this->addColumn(
					'firstname',
					[
						'header' => __('First Name'),
						'index' => 'firstname',
					]
				);
				
				$this->addColumn(
					'lastname',
					[
						'header' => __('Last Name'),
						'index' => 'lastname',
					]
				);
				
				$this->addColumn(
					'phone_number',
					[
						'header' => __('Phone Number'),
						'index' => 'phone_number',
					]
				);
				
				$this->addColumn(
					'address_1',
					[
						'header' => __('Address Line 1'),
						'index' => 'address_1',
					]
				);
				
				$this->addColumn(
					'address_2',
					[
						'header' => __('Address Line 2'),
						'index' => 'address_2',
					]
				);
				
				$this->addColumn(
					'city',
					[
						'header' => __('City Name'),
						'index' => 'city',
					]
				);
				
				$this->addColumn(
					'state',
					[
						'header' => __('State'),
						'index' => 'state',
					]
				);
				
				$this->addColumn(
					'post_code',
					[
						'header' => __('Postal Code'),
						'index' => 'post_code',
					]
				);
				
				$this->addColumn(
					'customer_id',
					[
						'header' => __('Magento Customer ID'),
						'index' => 'customer_id',
					]
				);
				
				$this->addColumn(
					'created_at',
					[
						'header' => __('Created at Timestamp'),
						'index' => 'created_at',
						'type'      => 'datetime',
					]
				);
					
					
				$this->addColumn(
					'updated_at',
					[
						'header' => __('Last Updated Timestamp'),
						'index' => 'updated_at',
						'type'      => 'datetime',
					]
				);
					
					
						
						$this->addColumn(
							'status',
							[
								'header' => __('Status'),
								'index' => 'status',
								'type' => 'options',
								'options' => \Medline\Import\Block\Adminhtml\Import\Grid::getOptionArray16()
							]
						);
						
						


		
        //$this->addColumn(
            //'edit',
            //[
                //'header' => __('Edit'),
                //'type' => 'action',
                //'getter' => 'getId',
                //'actions' => [
                    //[
                        //'caption' => __('Edit'),
                        //'url' => [
                            //'base' => '*/*/edit'
                        //],
                        //'field' => 'id'
                    //]
                //],
                //'filter' => false,
                //'sortable' => false,
                //'index' => 'stores',
                //'header_css_class' => 'col-action',
                //'column_css_class' => 'col-action'
            //]
        //);
		

		
		   $this->addExportType($this->getUrl('import/*/exportCsv', ['_current' => true]),__('CSV'));
		   $this->addExportType($this->getUrl('import/*/exportExcel', ['_current' => true]),__('Excel XML'));

        $block = $this->getLayout()->getBlock('grid.bottom.links');
        if ($block) {
            $this->setChild('grid.bottom.links', $block);
        }

        return parent::_prepareColumns();
    }

	
    /**
     * @return $this
     */
    protected function _prepareMassaction()
    {

        $this->setMassactionIdField('id');
        //$this->getMassactionBlock()->setTemplate('Medline_Import::import/grid/massaction_extended.phtml');
        $this->getMassactionBlock()->setFormFieldName('import');

        $this->getMassactionBlock()->addItem(
            'delete',
            [
                'label' => __('Delete'),
                'url' => $this->getUrl('import/*/massDelete'),
                'confirm' => __('Are you sure?')
            ]
        );

        $statuses = $this->_status->getOptionArray();

        $this->getMassactionBlock()->addItem(
            'status',
            [
                'label' => __('Change status'),
                'url' => $this->getUrl('import/*/massStatus', ['_current' => true]),
                'additional' => [
                    'visibility' => [
                        'name' => 'status',
                        'type' => 'select',
                        'class' => 'required-entry',
                        'label' => __('Status'),
                        'values' => $statuses
                    ]
                ]
            ]
        );


        return $this;
    }
		

    /**
     * @return string
     */
    public function getGridUrl()
    {
        return $this->getUrl('import/*/index', ['_current' => true]);
    }

    /**
     * @param \Medline\Import\Model\import|\Magento\Framework\Object $row
     * @return string
     */
    public function getRowUrl($row)
    {
		
        return $this->getUrl(
            'import/*/edit',
            ['id' => $row->getId()]
        );
		
    }

	
		static public function getOptionArray16()
		{
            $data_array=array(); 
			$data_array[0]='Not activated';
			$data_array[1]='Activated';
			$data_array[2]='Suspended';
            return($data_array);
		}
		static public function getValueArray16()
		{
            $data_array=array();
			foreach(\Medline\Import\Block\Adminhtml\Import\Grid::getOptionArray16() as $k=>$v){
               $data_array[]=array('value'=>$k,'label'=>$v);		
			}
            return($data_array);

		}
		

}