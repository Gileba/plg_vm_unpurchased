<?php
	defined('_JEXEC') or die; 
	AdminUIHelper::startAdminArea($this);
	JHtml::_('behavior.framework', true);
?>
 
<form action="index.php" method="post" name="adminForm" id="adminForm">
 
    <div id="header">
        <h2><?php echo vmText::sprintf('VMEXT_UNPURCHASED_VIEW_TITLE_REPORT'); ?></h2>
 
        <div id="resultscounter">
            <?php if ($this->pagination) echo $this->pagination->getResultsCounter();?>
        </div>
    </div>
 
    <div id="editcell">
      <table class="adminlist table table-striped" cellspacing="0" cellpadding="0">
            <thead>
                <tr>
                    <th><?php echo $this->sort('`product_id`', 'VMEXT_UNPURCHASED_PRODUCTID') ; ?></th>
                    <th><?php echo $this->sort('`sku`', 'VMEXT_UNPURCHASED_SKU') ; ?></th>
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
                		$i = 1-$i; 
					} 
				?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="10">
                        <?php if ($this->pagination) echo $this->pagination->getListFooter(); ?>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
 
  <?php 
	  echo $this->addStandardHiddenToForm(); 
?>
</form>
 
<?php 
	AdminUIHelper::endAdminArea(); 
?>