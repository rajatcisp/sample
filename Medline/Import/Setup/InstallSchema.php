<?php

namespace Medline\Import\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\DB\Adapter\AdapterInterface;

class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;

        $installer->startSetup();

        if (version_compare($context->getVersion(), '1.0.0') < 0){

		$installer->run('create table otcjsonimport(
id int not null auto_increment,
member_id varchar(15) not null,
plan_id varchar(15) not null,
provider_id varchar(15),
dob date not null,
firstname varchar(50),
lastname varchar(50),
phone_number varchar(12),
address_1 varchar(50),
address_2 varchar(50),
city varchar(50),
state varchar(50),
post_code varchar(5),
customer_id int,
created_at datetime not null,
updated_at datetime not null,
status tinyint not null,
primary key(id))');


		

		}

        $installer->endSetup();

    }
}