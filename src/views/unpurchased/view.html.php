<?php
	defined('_JEXEC') or die;
if (!defined('VM_VERSION') or VM_VERSION < 3) {
	// VM2 has class VmView instead of VmViewAdmin:
	if (!class_exists('VmView')) { require(VMPATH_ADMIN . DS . 'helpers' . DS . 'vmview.php');
	}

	class VmViewAdmin extends VmView
	{
	}
	defined('VMPATH_PLUGINLIBS') or define('VMPATH_PLUGINLIBS', JPATH_VM_PLUGINS);
} else {
	if(!class_exists('VmViewAdmin')) { require(VMPATH_ADMIN . DS . 'helpers' . DS . 'vmviewadmin.php');
	}
}

class VirtuemartViewUnpurchased extends VmViewAdmin
{
	private function __construct()
	{
		parent::__construct();
		$this->_addPath('template', JPATH_PLUGINS . DS . 'vmextended' . DS . 'unpurchased' . DS . 'views' . DS . $this->getName() . DS . 'tmpl');
	}

	public function display($tpl = null)
	{
		if (!class_exists('VmHTML')) { require(VMPATH_ADMIN . DS . 'helpers' . DS . 'html.php');
		}

		vRequest::setvar('task', '');
		$this->SetViewTitle('UNPURCHASED');

		$model    = VmModel::getModel();
		$this->addStandardDefaultViewLists($model);

		$unpurchasedData = $model->getUnpurchasedProducts();
		$this->assignRef('report', $unpurchasedData);

		$this->pagination = $model->getPagination();

		parent::display($tpl);
	}
}
