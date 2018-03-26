# Virtuemart Custom Textarea Plugin

This plugin helps you add custom textarea field to your Virtuemart product to capture customer's input (e.g. comment, shipping instruction...) This plugin is similar to the core ```textinput``` plugin, but this adds ```<textarea>``` field instead of ```<input>``` field and entered value doesn't affect product's price.

After installing, this plugin is stored in <your Joomla! root folder>/plugins/vmcustom/textarea.

## Installation

You can install this plugin with Joomla's Extension Mananger, the same way you install other Joomla! extensions.

## Usage

You enable the plugin after installation. Create a custom field for it just like other Virtuemart custom field.

The custom field contains the following options:

 * **Row Quantity**: Specify the visible number of lines of text area.
 * **Column Quantity**: Specify the visible width of text area. You may not need to use this option if your site is responsive.
 * **Max Length**: Specify the maximum number of characters allowed in text area.
 * **Placeholder**: Specify a short hint that describes the expected value of a text area. It can be either a text or a key string that can be translated.
 * **CSS Classe**: Custom CSS classes for text area.
 * **Value's Prefix**: Custom text or HTML code shown before value in shopping cart, order detail and email. If you want to show double quote or single quote, use ```DOUBLEQUOTE``` and ```SINGLEQUOTE``` text instead.
 * **Value's Postfix**: Custom text or HTML code shown after value in cart and email. If you want to show double quote or single quote, use ```DOUBLEQUOTE``` and ```SINGLEQUOTE``` text instead.

The reason you need to use ```DOUBLEQUOTE``` and ```SINGLEQUOTE``` instead of doulbe quote and single quote symbols is Virtuemart strips the quotes when you save.

## License

[GNU General Public License version 2 or later](http://www.gnu.org/licenses/gpl-2.0.html)