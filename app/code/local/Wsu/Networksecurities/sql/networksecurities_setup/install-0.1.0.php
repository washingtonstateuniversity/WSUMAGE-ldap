<?php

$installer=new  Mage_Customer_Model_Entity_Setup ('core_setup');
/* @var $installer Mage_Core_Model_Resource_Setup */
$installer->startSetup();

/* ATTR SETUP */
$installer->addAttribute('customer', 'ldap_user', array(
    'type'         => 'int',
    'input'        => 'select',
    'source'       => 'eav/entity_attribute_source_boolean',
	'label'				=> 'Has AD account',
	'visible'			=> true,
	'required'			=> false,
));
$attr = Mage::getSingleton( 'eav/config' )->getAttribute( 'customer', 'ldap_user' );
$attr->setData( 'used_in_forms', array( 'adminhtml_customer' ) );
$attr->save();

$installer->getConnection()->addColumn($installer->getTable('admin/user'), 'ldap_user', array(
    'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
    'length' => 256,
    'nullable' => true,
    'default' => null,
    'comment' => 'Ldap user'
)); 


/* TABLE SETUP */
$installer->getConnection()->dropTable($this->getTable('wsu_spamlog'));
$installer->getConnection()->dropTable($this->getTable('wsu_failedlogin_log'));
$installer->getConnection()->dropTable($this->getTable('wsu_blacklist'));

$table_spamlog = $installer->getTable('wsu_spamlog');
$installer->run("
    CREATE TABLE `{$table_spamlog}` (
  `spamlog_id` int(10) NOT NULL AUTO_INCREMENT,
  `updated_at` timestamp,
  `type` varchar(255) NULL,
  `value` varchar(255) NULL,
  `count`  int(10) NOT NULL DEFAULT '1',
  `admin` TINYINT(1),
  `user_id` int(10) NULL,
  `ip` varchar(255) NOT NULL DEFAULT '0.0.0.0',
  `user_agent` text NULL,
  `httpbl_response` varchar(255) NOT NULL DEFAULT 'NXDOMAIN',
  `blocked` TINYINT(1) UNSIGNED DEFAULT 0,
  `reported_at` timestamp,
  PRIMARY KEY (`spamlog_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

    ");

$connection = $this->getConnection();
$connection->addColumn($this->getTable('review'), "spam","TINYINT(1) UNSIGNED DEFAULT 0");
//$installer->run("ALTER TABLE {$this->getTable('review')} ADD `spam` TINYINT(1) UNSIGNED DEFAULT 0;");

$table_failedlogin = $installer->getTable('wsu_failedlogin_log');
$installer->run("
    CREATE TABLE `{$table_failedlogin}` (
  `failedlogin_id` int(10) NOT NULL AUTO_INCREMENT,
  `log_at` timestamp,
  `login` varchar(255) NULL,
  `password` varchar(255) NULL,
  `admin` TINYINT(1) UNSIGNED DEFAULT 0,
  `ip` varchar(255) NOT NULL DEFAULT '0.0.0.0',
  `user_agent` text NULL,
  PRIMARY KEY (`failedlogin_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
    ");

$table_blacklist = $installer->getTable('wsu_blacklist');
$installer->run("
    CREATE TABLE `{$table_blacklist}` (
  `blacklist_id` int(10) NOT NULL AUTO_INCREMENT,
  `log_at` timestamp,
  `admin` TINYINT(1) UNSIGNED DEFAULT 0,
  `ip` varchar(255) NOT NULL DEFAULT '0.0.0.0',
  PRIMARY KEY (`blacklist_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
    ");


	
$installer->endSetup();
