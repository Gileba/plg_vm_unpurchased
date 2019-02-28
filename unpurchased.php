<?php
	defined('_JEXEC') or die;
	defined('VMPATH_PLUGINLIBS') or define('VMPATH_PLUGINLIBS', JPATH_VM_PLUGINS);
	
	if (!class_exists('vmExtendedPlugin')) require(VMPATH_PLUGINLIBS . DS . 'vmextendedplugin.php');
 
	class plgVmExtendedUnpurchased extends vmExtendedPlugin {
		public function __construct (&$subject, $config=array()) {
			parent::__construct($subject, $config);
				$this->_path = JPATH_PLUGINS . DS . 'vmextended' . DS . $this->getName();
				JPlugin::loadLanguage('plg_vmextended_' . $this->getName());
		}
 
		public function onVmAdminController ($controller) {
			if ($controller = $this->getName()) {
				VmModel::addIncludePath($this->_path . DS . 'models');
				require_once($this->_path . DS . 'models' . DS . 'unpurchased.php');
				require_once($this->_path . DS . 'controllers' . DS . 'unpurchased.php');
				return true;
			}
		}
	}