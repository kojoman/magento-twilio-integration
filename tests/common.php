<?

/*
 * All common functions go in this file
 */


// Please replace with specific path to your Magento root. 
$magentoDir = '/var/www/vhosts/magento/'; 

$mageFileName = $magentoDir . 'app/Mage.php';

if(!file_exists($mageFileName)) {
	echo $mageFileName. " was not found. Exiting now";
	exit;
}

require_once $mageFileName;

// Error Reporting & Debuging 
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 1);
Mage::setIsDeveloperMode(true);
Varien_Profiler::enable();
umask(0);

// Initialize default store 
Mage::app('default');
