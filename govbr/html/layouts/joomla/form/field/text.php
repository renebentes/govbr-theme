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

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;

extract($displayData, EXTR_OVERWRITE);

/**
 * Layout variables
 * -----------------
 * @var   string   $autocomplete    Autocomplete attribute for the field.
 * @var   boolean  $autofocus       Is autofocus enabled?
 * @var   string   $class           Classes for the input.
 * @var   string   $description     Description of the field.
 * @var   boolean  $disabled        Is this field disabled?
 * @var   string   $group           Group the field belongs to. <fields> section in form XML.
 * @var   boolean  $hidden          Is this field hidden in the form?
 * @var   string   $placeholder     Placeholder for the field.
 * @var   string   $id              DOM id of the field.
 * @var   string   $label           Label of the field.
 * @var   string   $labelclass      Classes to apply to the label.
 * @var   boolean  $multiple        Does this field support multiple values?
 * @var   string   $name            Name of the input field.
 * @var   string   $onchange        Onchange attribute for the field.
 * @var   string   $onclick         Onclick attribute for the field.
 * @var   string   $pattern         Pattern (Reg Ex) of value of the form field.
 * @var   boolean  $readonly        Is this field read only?
 * @var   boolean  $repeat          Allows extensions to duplicate elements.
 * @var   boolean  $required        Is this field required?
 * @var   integer  $size            Size attribute of the input.
 * @var   boolean  $spellcheck      Spellcheck state for the form field.
 * @var   string   $validate        Validation rules to apply.
 * @var   string   $value           Value attribute of the field.
 * @var   array    $checkedOptions  Options that will be set as checked.
 * @var   boolean  $hasValue        Has this field a value assigned?
 * @var   array    $options         Options available for this field.
 * @var   array    $inputType       Options available for this field.
 * @var   string   $accept          File types that are accepted.
 * @var   string   $dataAttribute   Miscellaneous data attributes preprocessed for HTML output
 * @var   array    $dataAttributes  Miscellaneous data attribute for eg, data-*.
 * @var   string   $dirname         The directory name
 * @var   string   $addonBefore     The text to use in a bootstrap input group prepend
 * @var   string   $addonAfter      The text to use in a bootstrap input group append
 * @var   boolean  $charcounter     Does this field support a character counter?
 * @var   string   $hint            Help text for the field
 */

$list = '';

if (!empty($options)) {
    $list = 'list="' . $id . '_datalist"';
}

$charcounterclass = '';

if (!empty($charcounter)) {
    // Load the js file
    /** @var Joomla\CMS\WebAsset\WebAssetManager $wa */
    $wa = Factory::getApplication()->getDocument()->getWebAssetManager();
    $wa->useScript('short-and-sweet');

    // Set the css class to be used as the trigger
    $charcounterclass = ' charcount';

    // Set the text
    $counterlabel = 'data-counter-label="' . $this->escape(Text::_('JFIELD_META_DESCRIPTION_COUNTER')) . '"';
}

$class      = !empty($class) ? ' ' . $class . $charcounterclass : $charcounterclass;
$labelclass = !empty($labelclass) ? 'class="' . $labelclass . '" ' : '';
$attributes = [
    !empty($size) ? 'size="' . $size . '"' : '',
    !empty($description) ? 'aria-describedby="' . ($id ?: $name) . '-desc"' : '',
    !empty($disabled) ? 'disabled' : '',
    !empty($readonly) ? 'readonly' : '',
    $dataAttribute ?? '',
    $list,
    \strlen($placeholder) ? 'placeholder="' . htmlspecialchars($placeholder, ENT_COMPAT, 'UTF-8') . '"' : '',
    !empty($onchange) ? 'onchange="' . $onchange . '"' : '',
    !empty($maxLength) ? $maxLength : '',
    !empty($required) ? 'required' : '',
    !empty($autocomplete) ? 'autocomplete="' . $autocomplete . '"' : '',
    !empty($autofocus) ? 'autofocus' : '',
    !empty($spellcheck) ? '' : 'spellcheck="false"',
    !empty($inputmode) ? $inputmode : '',
    !empty($counterlabel) ? $counterlabel : '',
    !empty($pattern) ? 'pattern="' . $pattern . '"' : '',

    // @TODO add a proper string here!!!
    !empty($validationtext) ? 'data-validation-text="' . $this->escape(Text::_($validationtext)) . '"' : '',
];

$class .= !empty($addonAfter) ? ' input-button' : '';

?>
<div class="br-input<?php echo $class; ?>">
    <label <?php echo $labelclass ?>for="<?php echo $this->escape($name); ?>"><?php echo $this->escape($label); ?></label>
    <?php if (!empty($addonBefore)) : ?>
        <div class="input-group">
            <div class="input-icon">
                <?php echo Text::_($addonBefore); ?>
            </div>
        <?php endif; ?>

        <input
            type="text"
            name="<?php echo $name; ?>"
            id="<?php echo $id ?? $name; ?>"
            value="<?php echo htmlspecialchars($value, ENT_COMPAT, 'UTF-8'); ?>"
            <?php echo $dirname ?? ''; ?>
            <?php echo implode(' ', $attributes); ?> />

        <?php if (!empty($addonBefore)) : ?>
        </div>
    <?php endif; ?>
    <?php echo Text::_($addonAfter ?? ''); ?>
    <?php echo $hint ?? ''; ?>
</div>

<?php if (!empty($options)) : ?>
    <datalist id="<?php echo $id; ?>_datalist">
        <?php foreach ($options as $option) : ?>
            <?php if (!$option->value) : ?>
                <?php continue; ?>
            <?php endif; ?>
            <option value="<?php echo $option->value; ?>"><?php echo $option->text; ?></option>
        <?php endforeach; ?>
    </datalist>
<?php endif; ?>
