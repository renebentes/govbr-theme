<?php

/**
 * @package     Joomla.Site
 * @subpackage  Templates.GovBR
 *
 * @author      Rene Bentes Pinto <renebentes@yahoo.com.br>
 * @copyright   Copyright (C) 2026 Rene Bentes Pinto. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 * @since       __DEPLOY_VERSION__
 */

\defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;

extract($displayData, EXTR_OVERWRITE);

/**
 * Layout variables
 * -----------------
 * @var  boolean  $autofocus       Is autofocus enabled?
 * @var  string   $class           Classes for the input.
 * @var  string   $description     Description of the field.
 * @var  boolean  $disabled        Is this field disabled?
 * @var  string   $group           Group the field belongs to. <fields> section in form XML.
 * @var  boolean  $hidden          Is this field hidden in the form?
 * @var  string   $placeholder     Placeholder for the field.
 * @var  string   $id              DOM id of the field.
 * @var  string   $label           Label of the field.
 * @var  string   $labelclass      Classes to apply to the label.
 * @var  boolean  $multiple        Does this field support multiple values?
 * @var  string   $name            Name of the input field.
 * @var  string   $onchange        Onchange attribute for the field.
 * @var  string   $onclick         Onclick attribute for the field.
 * @var  string   $pattern         Pattern (Reg Ex) of value of the form field.
 * @var  boolean  $readonly        Is this field read only?
 * @var  boolean  $repeat          Allows extensions to duplicate elements.
 * @var  boolean  $required        Is this field required?
 * @var  integer  $size            Size attribute of the input.
 * @var  boolean  $spellcheck      Spellcheck state for the form field.
 * @var  string   $validate        Validation rules to apply.
 * @var  string   $value           Value attribute of the field.
 * @var  array    $checkedOptions  Options that will be set as checked.
 * @var  boolean  $hasValue        Has this field a value assigned?
 * @var  array    $options         Options available for this field.
 * @var  array    $inputType       Options available for this field.
 * @var  string   $accept          File types that are accepted.
 * @var  string   $dataAttribute   Miscellaneous data attributes preprocessed for HTML output
 * @var  array    $dataAttributes  Miscellaneous data attribute for eg, data-*.
 * @var  string   $dirname         The directory name
 * @var  string   $addonBefore     The text to use in a bootstrap input group prepend
 * @var  string   $addonAfter      The text to use in a bootstrap input group append
 * @var  boolean  $charcounter     Does this field support a character counter?
 * @var  string   $hint            Help text for the field
 * @var  string   $selected        The selected value for the field
 */

$class      = !empty($class) ? ' ' . $class : '';
$id ??= $name;
$labelclass = !empty($labelclass) ? 'class="' . $labelclass . '" ' : '';
$attributes = [
    !empty($description) ? 'aria-describedby="' . $id . '-desc"' : '',
    !empty($disabled) ? 'disabled' : '',
    !empty($readonly) ? 'readonly' : '',
    !empty($onchange) ? 'onchange="' . $onchange . '"' : '',
    $dataAttribute ?? '',
    !empty($required) ? 'required' : '',
    !empty($autofocus) ? 'autofocus' : '',

    // @TODO add a proper string here!!!
    !empty($validationtext) ? 'data-validation-text="' . $this->escape(Text::_($validationtext)) . '"' : '',
];

?>
<div class="br-select<?php echo $class; ?>"
    <?php echo implode(' ', $attributes); ?>>
    <div class="br-input">
        <label <?php echo $labelclass ?>for="<?php echo $this->escape($id); ?>"><?php echo $this->escape($label); ?></label>
        <input
            name="<?php echo $name; ?>"
            id="<?php echo $id; ?>"
            type="text"
            <?php echo !empty($placeholder) ? ' placeholder="' . htmlspecialchars($placeholder, ENT_COMPAT, 'UTF-8') . '"' : ''; ?> />
        <button
            class="br-button"
            type="button"
            <?php echo !empty($ariaLabel) ? 'aria-label="' . $this->escape($ariaLabel) . '"' : ''; ?>
            tabindex="-1"
            data-trigger="data-trigger">
            <i class="fas fa-angle-down" aria-hidden="true"></i>
        </button>
    </div>
    <?php if (!empty($options)) : ?>
        <div class="br-list" tabindex="0">
            <?php foreach ($options as $option) : ?>
                <?php $optionName = $name . '-' . $option->value; ?>
                <div class="br-item<?php echo $selected == $option->value ? ' selected' : ''; ?>" tabindex="-1">
                    <div class="br-radio">
                        <input id="<?php echo $optionName; ?>" type="radio" name="<?php echo $name; ?>" value="<?php echo $optionName; ?>" />
                        <label for="<?php echo $optionName; ?>"><?php echo $option->text; ?></label>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    <?php endif; ?>
</div>
