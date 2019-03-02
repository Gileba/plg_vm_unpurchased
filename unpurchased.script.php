<?php
	defined('_JEXEC') or die;
	defined('DS') or define('DS', DIRECTORY_SEPARATOR);
	if (!class_exists( 'VmConfig' )) 
    	require(JPATH_ROOT . DS . 'administrator' . DS . 'components' . DS . 'com_virtuemart' . DS . 'helpers' . DS . 'config.php');
    	
	class plgVmExtendedUnpurchasedInstallerScript {
    	public function postflight ($type, $parent = null) {
        	JPlugin::loadLanguage('plg_vmextended_unpurchased');
			$db = JFactory::getDBO();
			$db->setQuery("SELECT `id` FROM `#__virtuemart_adminmenuentries` WHERE `view` = 'unpurchased'");
			$exists = $db->loadResult();
			if (!$exists) {
            	$q = "INSERT INTO `#__virtuemart_adminmenuentries` (`module_id`, `name`, `link`, `depends`, `icon_class`, `ordering`, `published`, `tooltip`, `view`, `task`) VALUES
(2, '" . vmText::_('COM_VIRTUEMART_UNPURCHASED') . "', '', '', 'vmicon vmicon-16-report', 25, 1, '', 'unpurchased', '')";
            	$db->setQuery($q);
				$db->query();
        	}
    	}
 
		public function install(JAdapterInstance $adapter)
		{
        	$db = JFactory::getDBO();
			$db->setQuery('update #__extensions set enabled = 1 where type = "plugin" and element = "unpurchased" and folder = "vmextended"');
			$db->query();
			return True;
    	}
 
		public function uninstall(JAdapterInstance $adapter)
		{
        	$db = JFactory::getDBO();
			$q = "DELETE FROM `#__virtuemart_adminmenuentries` WHERE `view` = 'unpurchased' AND `task` = '' AND `module_id` = 2";
			$db->setQuery($q);
			$db->query();
    	}
	}