<?php
	defined('_JEXEC') or die;
	AdminUIHelper::startAdminArea($this);
	JHtml::_('behavior.framework', true);
?>
 
<form action="index.php" method="post" name="adminForm" id="adminForm">
	 <div id="editcell">
	  <table class="adminlist table table-striped" cellspacing="0" cellpadding="0">
			<thead>
				<tr>
					<th><?php echo $this->sort('`product_id`', 'VMEXT_UNPURCHASED_PRODUCTID'); ?></th>
					<th><?php echo $this->sort('`sku`', 'VMEXT_UNPURCHASED_SKU'); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php
					$i = 0;
				foreach ($this->report as $r) {
					?>
				<tr class="row<?php echo $i;?>">
					<td align="center"><a href="/administrator/index.php?option=com_virtuemart&view=product&task=edit&virtuemart_product_id=<?php echo $r['product_id']; ?>"><?php echo $r['product_id']; ?></a></td>
					<td align="center"><?php echo $r['sku']; ?></td>
				</tr>
					<?php
						$i = 1 - $i;
				}
				?>
			</tbody>
	<?php if ($this->pagination) { ?>
			<tfoot>
				<tr>
					<td colspan="10">
						<?php echo $this->pagination->getListFooter(); ?>
					</td>
				</tr>
				<tr>
					<td colspan="10">
						<?php echo $this->pagination->getResultsCounter(); ?>
					</td>
				</tr>
			</tfoot>
	<?php } ?>
		</table>
	</div>
 
	<?php
	  echo $this->addStandardHiddenToForm();
	?>
</form>
 
<?php
	AdminUIHelper::endAdminArea();

