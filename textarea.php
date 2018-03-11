<?php
/**
 * @package    PlgVMCustomTextarea
 * @copyright  Copyright (C) 2018 CMExtension https://www.cmext.vn/
 * @license    GNU General Public License version 2 or later
 */

defined('_JEXEC') or die();

if (!class_exists('vmCustomPlugin')) {
    require VMPATH_PLUGINLIBS . DS . 'vmcustomplugin.php';
}

class PlgVmCustomTextarea extends vmCustomPlugin {
    public function __construct(&$subject, $config)
    {
        parent::__construct($subject, $config);

        $varsToPush = [
            'rows' => array(0.0, 'int'),
            'cols' => array(0.0, 'int'),
            'maxlength' => array(0.0, 'int'),
            'placeholder' => array('', 'char'),
            'css_classes' => array('', 'char'),
            'required' => array(0.0, 'bool')
        ];

        $this->setConfigParameterable('customfield_params', $varsToPush);
    }

    public function plgVmOnProductEdit($field, $productId, &$row, &$returnedValue)
    {

        if ($field->custom_element != $this->_name) {
            return false;
        }

        $requiredOptions = [
            0 => 'JNO',
            1 => 'JYES'
        ];

        $html = '
<fieldset>
    <legend>' . vmText::_('PLG_VMCUSTOM_TEXTAREA') . '</legend>
    <table class="admintable">';

       $html = VmHTML::row('input', 'PLG_VMCUSTOM_TEXTAREA_ROWS', 'customfield_params[' . $row . '][rows]', $field->rows);

       $html = VmHTML::row('input', 'PLG_VMCUSTOM_TEXTAREA_COLS', 'customfield_params[' . $row . '][cols]', $field->cols);

       $html = VmHTML::row('input', 'PLG_VMCUSTOM_TEXTAREA_MAXLENGTH', 'customfield_params[' . $row . '][maxlength]', $field->maxlength);

       $html = VmHTML::row('input', 'PLG_VMCUSTOM_TEXTAREA_PLACEHOLDER', 'customfield_params[' . $row . '][placeholder]', $field->placeholder);

       $html = VmHTML::row('input', 'PLG_VMCUSTOM_TEXTAREA_CSS_CLASSES', 'customfield_params[' . $row . '][css_classes]', $field->css_classes);

        $html .= VmHTML::row('select', 'PLG_VMCUSTOM_TEXTAREA_REQUIRED', 'customfield_params[' . $row . '][required]', $requiredOptions, $field->required, '', 'value', 'text', false);

        $html .='
    </table>
</fieldset>';

        $returnedValue .= $html;
        $row++;

        return true;
    }

    public function plgVmOnDisplayProductFEVM3(&$product, &$group)
    {
        if ($group->custom_element != $this->_name) {
            return false;
        }

        $group->display .= $this->renderByLayout('default', array(&$product, &$group));

        return true;
    }

    public function plgVmOnViewCartVM3(&$product, &$productCustom, &$html)
    {
        if (empty($productCustom->custom_element)
            || $productCustom->custom_element != $this->_name) {
            return false;
        }

        if (empty($product->customProductData[$productCustom->virtuemart_custom_id][$productCustom->virtuemart_customfield_id])) {
            return false;
        }

        foreach ($product->customProductData[$productCustom->virtuemart_custom_id] as $k => $item) {
            if ($productCustom->virtuemart_customfield_id == $k) {
                if (isset($item['comment'])) {
                    $html .= '<span>' . vmText::_($productCustom->custom_title) . ' ' . $item['comment'] . '</span>';
                }
            }
        }
 
        return true;
    }

    public function plgVmOnViewCartModuleVM3(&$product, &$productCustom, &$html)
    {
        return $this->plgVmOnViewCartVM3($product, $productCustom, $html);
    }

    public function plgVmDisplayInOrderBEVM3(&$product, &$productCustom, &$html)
    {
        $this->plgVmOnViewCartVM3($product, $productCustom, $html);
    }

    public function plgVmDisplayInOrderFEVM3(&$product, &$productCustom, &$html)
    {
        $this->plgVmOnViewCartVM3($product, $productCustom, $html);
    }

    public function plgVmDisplayInOrderBE(&$item, $productCustom, &$html)
    {
        if (!empty($productCustom)) {
            $item->productCustom = $productCustom;
        }

        if (empty($item->productCustom->custom_element)
            || $item->productCustom->custom_element != $this->_name) {
            return;
        }

        $this->plgVmOnViewCart($item, $productCustom, $html);
    }

    public function plgVmDisplayInOrderFE(&$item, $productCustom, &$html)
    {
        if (!empty($productCustom)) {
            $item->productCustom = $productCustom;
        }

        if (empty($item->productCustom->custom_element)
            || $item->productCustom->custom_element != $this->_name) {
            return;
        }

        $this->plgVmOnViewCart($item, $productCustom, $html);
    }

    public function plgVmOnStoreInstallPluginTable($psType, $data, $table)
    {
        if ($psType != $this->_psType) {
            return false;
        }

        if (empty($table->custom_element)
            || $table->custom_element != $this->_name ) {
            return false;
        }

        if (empty($table->is_input)) {
            vmInfo('COM_VIRTUEMART_CUSTOM_IS_CART_INPUT_SET');
            $table->is_input = 1;
            $table->store();
        }
    }


    public function plgVmDeclarePluginParamsCustomVM3(&$data)
    {
        return $this->declarePluginParams('custom', $data);
    }

    public function plgVmGetTablePluginParams($psType, $name, $id, &$xParams, &$varsToPush)
    {
        return $this->getTablePluginParams($psType, $name, $id, $xParams, $varsToPush);
    }

    public function plgVmSetOnTablePluginParamsCustom($name, $id, &$table, $xParams)
    {
        return $this->setOnTablePluginParams($name, $id, $table, $xParams);
    }

    public function plgVmOnDisplayEdit($virtuemartCustomId, &$customPlugin)
    {
        return $this->onDisplayEditBECustom($virtuemartCustomId, $customPlugin);
    }

    public function plgVmPrepareCartProduct(&$product, &$customField, $selected, &$modificatorSum)
    {
        if ($customField->custom_element !== $this->_name) {
            return false;
        }

        if (!empty($selected['comment'])) {
            if ($customField->custom_price_by_letter == 1) {
                $charcount = strlen(html_entity_decode($selected['comment']));
            } else {
                $charcount = 1.0;
            }

            $modificatorSum += $charcount * $customField->customfield_price ;
        } else {
            $modificatorSum += 0.0;
        }

        return true;
    }


    public function plgVmDisplayInOrderCustom(&$html, $item, $param, $productCustom, $row, $view = 'FE')
    {
        $this->plgVmDisplayInOrderCustom($html, $item, $param, $productCustom, $row, $view);
    }

    public function plgVmOnSelfCallFE($type, $name, &$render)
    {
        $render->html = '';
    }
}
