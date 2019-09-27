<?php
namespace Medline\Import\Controller\Adminhtml\import;

use Magento\Backend\App\Action;
use Magento\Framework\App\Filesystem\DirectoryList;


class Save extends \Magento\Backend\App\Action
{

    /**
     * @param Action\Context $context
     */
    public function __construct(Action\Context $context)
    {
        parent::__construct($context);
    }

    /**
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            $model = $this->_objectManager->create('Medline\Import\Model\Import');

            $id = $this->getRequest()->getParam('id');
            if ($id) {
				//echo "here";
				//die;
                $model->load($id);
				//$model->setMemberId($data['id']);
				$model->setMemberId($data['member_id']);
				$model->setPlanId($data['plan_id']);
				$model->setProviderId($data['provider_id']);
				$model->setDob($data['dob']);
				$model->setFirstname($data['firstname']);
				$model->setLastname($data['lastname']);
				$model->setPhoneNumber($data['phone_number']);
				$model->setAddress1($data['address_1']);
				$model->setAddress2($data['address_2']);
				$model->setCity($data['city']);
				$model->setState($data['state']);
				$model->setPostCode($data['post_code']);
				$model->setCustomerId($data['customer_id']);
				$model->setUpdatedAt(date('Y-m-d H:i:s'));
				$model->setStatus($data['status']);
            }else{
				$model->setMemberId($data['member_id']);
				$model->setPlanId($data['plan_id']);
				$model->setProviderId($data['provider_id']);
				$model->setDob($data['dob']);
				$model->setFirstname($data['firstname']);
				$model->setLastname($data['lastname']);
				$model->setPhoneNumber($data['phone_number']);
				$model->setAddress1($data['address_1']);
				$model->setAddress2($data['address_2']);
				$model->setCity($data['city']);
				$model->setState($data['state']);
				$model->setPostCode($data['post_code']);
				$model->setCustomerId($data['customer_id']);
				$model->setCreatedAt(date('Y-m-d H:i:s'));
				$model->setUpdatedAt(date('Y-m-d H:i:s'));
				$model->setStatus($data['status']);
			}	
            try {
                $model->save();
                $this->messageManager->addSuccess(__('The Import has been saved.'));
                $this->_objectManager->get('Magento\Backend\Model\Session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['id' => $model->getId(), '_current' => true]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\RuntimeException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the Import.'));
            }

            $this->_getSession()->setFormData($data);
            return $resultRedirect->setPath('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}