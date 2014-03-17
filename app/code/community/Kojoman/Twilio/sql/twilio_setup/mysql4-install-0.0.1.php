<?php

/*
 * Tables Needed = kojoman_twilio
 * Columns:
 *  - message_id
 *  - log_at
 *  - to
 *  - sms_body
 */

$installer = $this;
Mage::log($installer);

$installer->startSetup();

$installer->run(
    "
    CREATE TABLE `{$installer->getTable('kojoman/twilio')}` (
      `sms_id` int(11) NOT NULL auto_increment,
      `sms_to` VARCHAR(255) NOT NULL default '',
      `sms_body` text,
      `date` datetime default NULL,
      `timestamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
      PRIMARY KEY (`sms_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET = UTF8;

    INSERT INTO `{$installer->getTable('kojoman/twilio')}` VALUES (1, '(123) 456-7890', 'Hello World', '2014-02-24 00:00:00','2014-02-24 23:12:30');
    "
);

$installer->endSetup();