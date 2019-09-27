<?php
namespace Medline\Import\Controller\Adminhtml\import;

use Magento\Backend\App\Action;
use Magento\Framework\App\Filesystem\DirectoryList;
//use Magento\Framework\App\Action\Context;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\Filesystem;
use Magento\MediaStorage\Model\File\UploaderFactory;
use Magento\Framework\Controller\ResultFactory;


class Import extends \Magento\Backend\App\Action
{

    protected $messageManager;
    protected $_storeManager;
    /**
     * @var \Magento\Framework\Filesystem $filesystem
     */
    protected $filesystem;

    /**
     * @var \Magento\MediaStorage\Model\File\UploaderFactory $fileUploader
     */
    protected $fileUploader;

    public function __construct(
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        Context $context,
        ManagerInterface $messageManager,
        Filesystem $filesystem,
        UploaderFactory $fileUploader
        // 
    )
    {
        $this->_storeManager = $storeManager;
        $this->messageManager       = $messageManager;
        $this->filesystem           = $filesystem;
        $this->fileUploader         = $fileUploader;

        $this->mediaDirectory = $filesystem->getDirectoryWrite(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA);

        parent::__construct($context);
    }

    public function execute()
    {
        
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $uploadedFile = $this->uploadFile();
        $resultRedirect->setUrl($this->_redirect->getRefererUrl());
        return $resultRedirect;

        
    }

    public function uploadFile()
    {
        $yourFolderName = 'your-custom-folder/';
        $yourInputFileName = 'my_custom_file';

        try{
         $file = $this->getRequest()->getFiles($yourInputFileName);
         $fileName = ($file && array_key_exists('name', $file)) ? $file['name'] : null;

         if ($file && $fileName) {
             $target = $this->mediaDirectory->getAbsolutePath($yourFolderName);        
             
             $uploader = $this->fileUploader->create(['fileId' => $yourInputFileName]);
             $uploader->setAllowedExtensions(['json']);

                // allow folder creation
             $uploader->setAllowCreateFolders(true);

                // rename file name if already exists 
             $uploader->setAllowRenameFiles(true);


             $result = $uploader->save($target);



             if ($result['file']) {
                $this->messageManager->addSuccess(__('File has been successfully uploaded.')); 
            }
            $target_path=$target . $uploader->getUploadedFileName();
            $json = file_get_contents($target_path);

            $json_data = json_decode($json,true);
            $objectManager = \Magento\Framework\App\ObjectManager::getInstance(); // Instance of object manager
            $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
            $connection = $resource->getConnection();
            $tableName = $resource->getTableName('otcjsonimport'); //gives table name with prefix
            foreach($json_data as $row) {


              $member_id_json=$row['MEMBER_ID'];
              $lastname_json=$row['SUBSCRIBER_LAST_NAME'];
              $firstname_json=$row['SUBSCRIBER_FIRST_NAME'];
              $phone_number_json=$row['INSURED_HOME_PHONE_NUMBER'];
              $address_1_json=$row['ADDRESS_LINE'];
              $address_2_json=$row['ADDRESS_LINE_2'];
              $city_json=$row['CITY_NAME'];
              $state_json=$row['STATE_OR_PROVINCE_CODE'];
              $post_code_json=$row['POSTAL_CODE'];
              $dob_json=$row['MEMBER_BIRTH_DATE'];
              $plan_id_json=$row['PLAN_ID'];
              $provider_id_json=$row['PROVIDER_ID'];
              $customer_id_json=$row['CUSTOMER_ID'];
              $status_json=$row['STATUS'];
              $status_json=$row['STATUS'];
              $your_date = date("Y/m/d", strtotime($dob_json));
              
              $sql = "Select member_id FROM " . $tableName." where member_id='$member_id_json'";
              $result = $connection->fetchAll($sql);
              if (empty($result)) {
              //inserting if db table is empty
                $sql2 = "INSERT into ".$tableName."(member_id, plan_id, provider_id, dob, firstname, lastname,phone_number,address_1,address_2,city,state,post_code,customer_id,created_at,updated_at,status) values('$member_id_json','$plan_id_json','$provider_id_json',' $your_date','$firstname_json','$lastname_json','$phone_number_json','$address_1_json','$address_2_json','$city_json','$state_json','$post_code_json','$customer_id_json',NOW(),NOW(),'$status_json')";
                $connection->query($sql2);
            }
            else{
                //inserting if value not present in db table
                foreach($result as $row_data)

                {
                    if($row_data['member_id'] !=$member_id_json)
                    {

                        $sql2 = "INSERT into ".$tableName."(member_id, plan_id, provider_id, dob, firstname, lastname,phone_number,address_1,address_2,city,state,post_code,customer_id,created_at,updated_at,status) values('$member_id_json','$plan_id_json','$provider_id_json',' $your_date','$firstname_json','$lastname_json','$phone_number_json','$address_1_json','$address_2_json','$city_json','$state_json','$post_code_json','$customer_id_json',NOW(),NOW(),'$status_json')";
                        echo $sql2;
                        $connection->query($sql2);
                    }
                }

            }



        }
          return $target . $uploader->getUploadedFileName();
      }
  } catch (\Exception $e) {
    $this->messageManager->addError($e->getMessage());
}

return false;
        
    }
}