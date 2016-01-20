# I18n Filters

Zend Framework comes with a set of filters related to Internationalization.

## Alnum

The `Alnum` filter can be used to return only alphabetic characters and digits in the unicode
"letter" and "number" categories, respectively. All other characters are suppressed.

### Supported Options

The following options are supported for `Alnum`:

`Alnum([ boolean $allowWhiteSpace [, string $locale ]])`

- `$allowWhiteSpace`: If set to true then whitespace characters are allowed. Otherwise they are
suppressed. Default is "false" (whitespace is not allowed).

    Methods for getting/setting the allowWhiteSpace option are also available:
`getAllowWhiteSpace()` and `setAllowWhiteSpace()`

- `$locale`: The locale string used in identifying the characters to filter (locale name, e.g.
en\_US). If unset, it will use the default locale (`Locale::getDefault()`).

    Methods for getting/setting the locale are also available: `getLocale()` and `setLocale()`

### Basic Usage

```php
// Default settings, deny whitespace
$filter = new \Zend\I18n\Filter\Alnum();
echo $filter->filter("This is (my) content: 123");
// Returns "Thisismycontent123"

// First param in constructor is $allowWhiteSpace
$filter = new \Zend\I18n\Filter\Alnum(true);
echo $filter->filter("This is (my) content: 123");
// Returns "This is my content 123"
```

> ### Note
`Alnum` works on almost all languages, except: Chinese, Japanese and Korean. Within these languages
the english alphabet is used instead of the characters from these languages. The language itself is
detected using the `Locale`.

## Alpha

The `Alpha` filter can be used to return only alphabetic characters in the unicode "letter"
category. All other characters are suppressed.

### Supported Options

The following options are supported for `Alpha`:

`Alpha([ boolean $allowWhiteSpace [, string $locale ]])`

- `$allowWhiteSpace`: If set to true then whitespace characters are allowed. Otherwise they are
suppressed. Default is "false" (whitespace is not allowed).

    Methods for getting/setting the allowWhiteSpace option are also available:
`getAllowWhiteSpace()` and `setAllowWhiteSpace()`

- `$locale`: The locale string used in identifying the characters to filter (locale name, e.g.
en\_US). If unset, it will use the default locale (`Locale::getDefault()`).

    Methods for getting/setting the locale are also available: `getLocale()` and `setLocale()`

### Basic Usage

```php
// Default settings, deny whitespace
$filter = new \Zend\I18n\Filter\Alpha();
echo $filter->filter("This is (my) content: 123");
// Returns "Thisismycontent"

// Allow whitespace
$filter = new \Zend\I18n\Filter\Alpha(true);
echo $filter->filter("This is (my) content: 123");
// Returns "This is my content "
```

> ### Note
`Alpha` works on almost all languages, except: Chinese, Japanese and Korean. Within these languages
the english alphabet is used instead of the characters from these languages. The language itself is
detected using the `Locale`.

## NumberFormat

The `NumberFormat` filter can be used to return locale-specific number and percentage strings. It
extends the `NumberParse` filter, which acts as wrapper for the `NumberFormatter` class within the
Internationalization extension (Intl).

### Supported Options

The following options are supported for `NumberFormat`:

`NumberFormat([ string $locale [, int $style [, int $type ]]])`

- `$locale`: (Optional) Locale in which the number would be formatted (locale name, e.g. en\_US). If
unset, it will use the default locale (`Locale::getDefault()`)

    Methods for getting/setting the locale are also available: `getLocale()` and `setLocale()`

- `$style`: (Optional) Style of the formatting, one of the [format style
constants](http://www.php.net/manual/class.numberformatter.php#intl.numberformatter-constants.unumberformatstyle).
If unset, it will use `NumberFormatter::DEFAULT_STYLE` as the default style.

    Methods for getting/setting the format style are also available: `getStyle()` and `setStyle()`

- `$type`: (Optional) The [formatting
type](http://www.php.net/manual/class.numberformatter.php#intl.numberformatter-constants.types) to
use. If unset, it will use `NumberFormatter::TYPE_DOUBLE` as the default type.

    Methods for getting/setting the format type are also available: `getType()` and `setType()`

### Basic Usage

```php
$filter = new \Zend\I18n\Filter\NumberFormat("de_DE");
echo $filter->filter(1234567.8912346);
// Returns "1.234.567,891"

$filter = new \Zend\I18n\Filter\NumberFormat("en_US", NumberFormatter::PERCENT);
echo $filter->filter(0.80);
// Returns "80%"

$filter = new \Zend\I18n\Filter\NumberFormat("fr_FR", NumberFormatter::SCIENTIFIC);
echo $filter->filter(0.00123456789);
// Returns "1,23456789E-3"
```

## NumberParse

The `NumberParse` filter can be used to parse a number from a string. It acts as a wrapper for the
`NumberFormatter` class within the Internationalization extension (Intl).

### Supported Options

The following options are supported for `NumberParse`:

`NumberParse([ string $locale [, int $style [, int $type ]]])`

- `$locale`: (Optional) Locale in which the number would be parsed (locale name, e.g. en\_US). If
unset, it will use the default locale (`Locale::getDefault()`)

    Methods for getting/setting the locale are also available: `getLocale()` and `setLocale()`

- `$style`: (Optional) Style of the parsing, one of the [format style
constants](http://www.php.net/manual/class.numberformatter.php#intl.numberformatter-constants.unumberformatstyle).
If unset, it will use `NumberFormatter::DEFAULT_STYLE` as the default style.

    Methods for getting/setting the parse style are also available: `getStyle()` and `setStyle()`

- `$type`: (Optional) The [parsing
type](http://www.php.net/manual/class.numberformatter.php#intl.numberformatter-constants.types) to
use. If unset, it will use `NumberFormatter::TYPE_DOUBLE` as the default type.

    Methods for getting/setting the parse type are also available: `getType()` and `setType()`

### Basic Usage

```php
$filter = new \Zend\I18n\Filter\NumberParse("de_DE");
echo $filter->filter("1.234.567,891");
// Returns 1234567.8912346

$filter = new \Zend\I18n\Filter\NumberParse("en_US", NumberFormatter::PERCENT);
echo $filter->filter("80%");
// Returns 0.80

$filter = new \Zend\I18n\Filter\NumberParse("fr_FR", NumberFormatter::SCIENTIFIC);
echo $filter->filter("1,23456789E-3");
// Returns 0.00123456789
```
