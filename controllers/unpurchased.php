<?php
	defined('_JEXEC') or die;
	defined('VMPATH_ADMIN') or define('VMPATH_ADMIN', JPATH_VM_ADMINISTRATOR);

	if (!class_exists('VmController')) require(VMPATH_ADMIN . DS . 'helpers' . DS . 'vmcontroller.php');
 
	class VirtuemartControllerUnpurchased extends VmController {
 
		function __construct() {
			parent::__construct();
			$this->addViewPath(JPATH_PLUGINS . DS . 'vmextended' . DS . 'unpurchased' . DS . 'views');
		}
	}