<?php
/* ------------------------------------------------------------------------
  # jprccron - Joomla cronjobs component for J1.6/1.7
  # ------------------------------------------------------------------------
  # author    Prieco S.A.
  # copyright Copyright (C) 2012 Prieco.com. All Rights Reserved.
  # @license - http://http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
  # Websites: http://www.prieco.com
  # Technical Support:  Forum - http://www.prieco.com/en/forum.html
  ------------------------------------------------------------------------- */

defined('_JEXEC') or die('Restricted access');
?>
<form action="index.php" method="post" name="adminForm">
    <div id="editcell">
        <table class="adminlist">
            <thead>
                <tr>
                    <th width="5">
                        <?php echo JText::_('ID'); ?>
                    </th>
                    <th width="20">
                        <input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->items); ?>);" />
                    </th>			
                    <th>
                        <?php echo JText::_('Task Name'); ?>
                    </th>
                    <th>
                        <?php echo JText::_('Published'); ?>
                    </th>
                    <th>
                        <?php echo JText::_('Running At(Unix mode: minute hour day month year)'); ?>
                    </th>
                    <th>
                        <?php echo JText::_('Last Run Time'); ?>
                    </th>
                </tr>
            </thead>
            <?php
            $k = 0;
            for ($i = 0, $n = count($this->items); $i < $n; $i++) {
                $row = &$this->items[$i];
                $checked = JHTML::_('grid.id', $i, $row->id);
                $link = JRoute::_('index.php?option=com_jprccron&controller=jprccronedit&task=edit&cid[]=' . $row->id);
                ?>
                <tr class="<?php echo "row$k"; ?>">
                    <td align="center">
                        <?php echo JText::_($row->id); ?>
                    </td>
                    <td align="center">
                        <?php echo $checked; ?>
                    </td>
                    <td>
                        <a href="<?php echo $link; ?>"><?php echo JText::_($row->task); ?></a>
                    </td>
                    <td align="center">
                        <?php
                        echo JHTML::_('grid.published', $row, $i);
                        ?>
                    </td>
                    <td align="center">
                        <b><?php echo JText::_($row->mhdmd); ?></b>
                    </td>
                    <td align="center">
                        <?php echo JText::_($row->ran_at); ?>
                    </td>
                </tr>
                <?php
                $k = 1 - $k;
            }
            ?>
            <tfoot>
                <tr>
                    <td colspan="6"><?php echo $this->pagination->getListFooter(); ?></td>
                </tr>
            </tfoot>
        </table>
    </div>
    <?php echo JHTML::_('form.token'); ?>
    <input type="hidden" name="option" value="com_jprccron" />
    <input type="hidden" name="task" value="" />
    <input type="hidden" name="boxchecked" value="0" />
    <input type="hidden" name="controller" value="jprccronedit" />
</form>
