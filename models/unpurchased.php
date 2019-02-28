<?php
	defined('_JEXEC') or die;

	if (!class_exists('VmModel')) require(VMPATH_ADMIN . DS . 'helpers' . DS . 'vmmodel.php');

	class VirtuemartModelUnpurchased extends VmModel {
		public $from_period  = '';
		
		function __construct () {
			parent::__construct ();
			$this->setMainTable ('products');
		}
		
		function correctTimeOffset(&$inputDate) {
			$config = JFactory::getConfig();
			$this->siteOffset = $config->get('offset');
			$date = new JDate($inputDate);
			$date->setTimezone($this->siteTimezone);
			$inputDate = $date->format('Y-m-d H:i:s',true);
		}
		
		function setPeriod () {
			$this->from_period = vRequest::getVar ('from_period');
 
			$config = JFactory::getConfig();
			$siteOffset = $config->get('offset');
			$this->siteTimezone = new DateTimeZone($siteOffset);
			
			$this->correctTimeOffset($this->from_period);
		}
 
		function getUnpurchasedProducts() {
			$user = JFactory::getUser();
			if($user->authorise('core.admin', 'com_virtuemart') or $user->authorise('core.manager', 'com_virtuemart'))
			{
				$vendorId = vRequest::getInt('virtuemart_vendor_id');
			} else {
				$vendorId = VmConfig::isSuperVendor();
			}
		
			// $this->setPeriod();
			$this->from_period = ('2017-01-01 00:00:00');
		 
			// Get a db connection.
			$db = JFactory::getDbo();
 
			// Create a new query object.
			$query = $db->getQuery(true);
			$subquery = $db->getQuery(true);
			
			$subquery 
				->select('io.virtuemart_product_id', 'io.order_item_name', 'io.created_on')
				->from('#__virtuemart_order_items', 'io')
				->where($db->quoteName('p.created_on') . ' > ' . $this->from_period . ' AND ' . $db->quotename('p.virtuemart_product_id') . ' = ' . $db->quoteName('io.virtuemart_product_id'));
			
			$query
				->select($db->quoteName(array('p.virtuemart_product_id', 'p.product_sku')))
				->from($db->quoteName('#__virtuemart_products', 'p'))
				->where($db->quoteName('p.published') . ' = ' . true)
				->where(' NOT EXISTS (' . $subquery . ')')
				->group($db->quoteName('p.virtuemart_product_id'))
				->order($db->quoteName('p.virtuemart_product_id' . ' ASC'));

			// Set the query using our newly populated query object and execute it.
			$db->setQuery($query);			
			
			try
			{
				$db->execute();
			}
			catch (Exception $e) 
			{
				JFactory::getApplication()->enqueueMessage($e->getMessage());
			}
			
			return $db->loadObject();
		}
	}