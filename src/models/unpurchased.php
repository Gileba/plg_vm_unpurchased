<?php
	defined('_JEXEC') or die;

if (!class_exists('VmModel')) { require(VMPATH_ADMIN . DS . 'helpers' . DS . 'vmmodel.php');
}

class VirtuemartModelUnpurchased extends VmModel
{
	public $from_period  = '';

	private function __construct()
	{
		parent::__construct();
		$this->setMainTable('products');
	}

	protected function correctTimeOffset(&$inputDate)
	{
		$config = JFactory::getConfig();
		$this->siteOffset = $config->get('offset');
		$date = new JDate($inputDate);
		$date->setTimezone($this->siteTimezone);
		$inputDate = $date->format('Y-m-d H:i:s', true);
	}

	protected function setPeriod()
	{
		$this->from_period = vRequest::getVar('from_period');

		$config = JFactory::getConfig();
		$siteOffset = $config->get('offset');
		$this->siteTimezone = new DateTimeZone($siteOffset);

		$this->correctTimeOffset($this->from_period);
	}

	public function getUnpurchasedProducts()
	{
		// $this->setPeriod();
		$this->from_period = ('2017-01-01 00:00:00');

		$select = array();
		$select[] = "`p`.`virtuemart_product_id` AS `product_id`";
		$select[] = "`p`.`product_sku` AS `sku`";
		$selectString = join(', ', $select) . ' FROM `#__virtuemart_products` AS `p`';

		$whereString = 'WHERE `p`.`published` = true ';
		$whereString .= ' AND NOT EXISTS ( SELECT `io`.`virtuemart_product_id`, `io`.`order_item_name`, `io`.`created_on` ';
		$whereString .= ' FROM #__virtuemart_order_items AS `io` ';
		$whereString .= ' WHERE `io`.`created_on` > "' . $this->from_period . '" AND `p`.`virtuemart_product_id` = `io`.`virtuemart_product_id` )';

		$groupBy = 'GROUP BY `p`.`virtuemart_product_id`';
		$orderBy = 'ORDER BY `p`.`virtuemart_product_id` ASC';

		return $this->exeSortSearchListQuery(1, $selectString, '', $whereString, $groupBy, $orderBy);
	}
}
