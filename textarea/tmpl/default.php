<?php
/**
 * @package    PlgVMCustomTextarea
 * @copyright  Copyright (C) 2018 CMExtension https://www.cmext.vn/
 * @license    GNU General Public License version 2 or later
 */

defined('_JEXEC') or die();

$class = 'vmcustom-textarea';
$product = $viewData[0];
$params = $viewData[1];
$name = 'customProductData['.$product->virtuemart_product_id.']['.$params->virtuemart_custom_id.']['.$params->virtuemart_customfield_id .'][comment]';

if ($params->css_classes != '') {
    $class .= ' ' . $params->css_classes;
}

if ((int) $params->rows > 0) {
    $rows = ' rows="' . (int) $params->rows . '"';
} else {
    $rows = '';
}

if ((int) $params->cols > 0) {
    $cols = ' cols="' . (int) $params->cols . '"';
} else {
    $cols = '';
}

if ((int) $params->maxlength > 0) {
    $maxlength = ' maxlength="' . (int) $params->maxlength . '"';
} else {
    $maxlength = '';
}

if ($params->placeholder != '') {
    $placeholder = ' placeholder="' . JText::_($params->placeholder, true) . '"';
} else {
    $placeholder = '';
}
?>
<textarea class="<?php echo $class ?>" name="<?php echo $name?>"<?php echo $rows . $cols . $maxlength . $placeholder; ?>></textarea>