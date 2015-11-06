# I18n Validators

Zend Framework comes with a set of validators related to Internationalization.

# Alnum Validator

`Zend\I18n\Validator\Alnum` allows you to validate if a given value contains only alphabetical
characters and digits. There is no length limitation for the input you want to validate.

## Supported Options

The following options are supported for `Zend\I18n\Validator\Alnum`:

- **allowWhiteSpace**: If whitespace characters are allowed. This option defaults to `FALSE`

## Basic usage

A basic example is the following one:

```php
$validator = new Zend\I18n\Validator\Alnum();
if ($validator->isValid('Abcd12')) {
    // value contains only allowed chars
} else {
    // false
}
```

## Using whitespaces

Per default whitespaces are not accepted because they are not part of the alphabet. Still, there is
a way to accept them as input. This allows to validate complete sentences or phrases.

To allow the usage of whitespaces you need to give the `allowWhiteSpace` option. This can be done
while creating an instance of the validator, or afterwards by using `setAllowWhiteSpace()`. To get
the actual state you can use `getAllowWhiteSpace()`.

```php
$validator = new Zend\I18n\Validator\Alnum(array('allowWhiteSpace' => true));
if ($validator->isValid('Abcd and 12')) {
    // value contains only allowed chars
} else {
    // false
}
```

## Using different languages

There are actually 3 languages which are not accepted in their own script. These languages are
**korean**, **japanese** and **chinese** because this languages are using an alphabet where a single
character is build by using multiple characters.

In the case you are using these languages, the input will only be validated by using the english
alphabet.

# Alpha Validator

`Zend\I18n\Validator\Alpha` allows you to validate if a given value contains only alphabetical
characters. There is no length limitation for the input you want to validate. This validator is
related to the `Zend\I18n\Validator\Alnum` validator with the exception that it does not accept
digits.

### Supported options for Zend\\I18n\\Validator\\Alpha

The following options are supported for `Zend\I18n\Validator\Alpha`:

- **allowWhiteSpace**: If whitespace characters are allowed. This option defaults to `FALSE`

### Basic usage

A basic example is the following one:

```php
$validator = new Zend\I18n\Validator\Alpha();
if ($validator->isValid('Abcd')) {
    // value contains only allowed chars
} else {
    // false
}
```

### Using whitespaces

Per default whitespaces are not accepted because they are not part of the alphabet. Still, there is
a way to accept them as input. This allows to validate complete sentences or phrases.

To allow the usage of whitespaces you need to give the `allowWhiteSpace` option. This can be done
while creating an instance of the validator, or afterwards by using `setAllowWhiteSpace()`. To get
the actual state you can use `getAllowWhiteSpace()`.

```php
$validator = new Zend\I18n\Validator\Alpha(array('allowWhiteSpace' => true));
if ($validator->isValid('Abcd and efg')) {
    // value contains only allowed chars
} else {
    // false
}
```

### Using different languages

When using `Zend\I18n\Validator\Alpha` then the language which the user sets within his browser will
be used to set the allowed characters. This means when your user sets **de** for german then he can
also enter characters like **ä**, **ö** and **ü** additionally to the characters from the english
alphabet.

Which characters are allowed depends completely on the used language as every language defines it's
own set of characters.

There are actually 3 languages which are not accepted in their own script. These languages are
**korean**, **japanese** and **chinese** because this languages are using an alphabet where a single
character is build by using multiple characters.

In the case you are using these languages, the input will only be validated by using the english
alphabet.

# IsFloat

`Zend\I18n\Validator\IsFloat` allows you to validate if a given value contains a floating-point
value. This validator validates also localized input.

### Supported options for Zend\\I18n\\Validator\\IsFloat

The following options are supported for `Zend\I18n\Validator\IsFloat`:

- **locale**: Sets the locale which will be used to validate localized float values.

### Simple float validation

The simplest way to validate a float is by using the system settings. When no option is used, the
environment locale is used for validation:

```php
$validator = new Zend\I18n\Validator\IsFloat();

$validator->isValid(1234.5);   // returns true
$validator->isValid('10a01'); // returns false
$validator->isValid('1,234.5'); // returns true
```

In the above example we expected that our environment is set to "en" as locale.

### Localized float validation

Often it's useful to be able to validate also localized values. Float values are often written
different in other countries. For example using english you will write "1.5". In german you may
write "1,5" and in other languages you may use grouping.

`Zend\I18n\Validator\IsFloat` is able to validate such notations. However,it is limited to the
locale you set. See the following code:

```php
$validator = new Zend\I18n\Validator\IsFloat(array('locale' => 'de'));

$validator->isValid(1234.5); // returns true
$validator->isValid("1 234,5"); // returns false
$validator->isValid("1.234"); // returns true
```

As you can see, by using a locale, your input is validated localized. Using a different notation you
get a `FALSE` when the locale forces a different notation.

The locale can also be set afterwards by using `setLocale()` and retrieved by using `getLocale()`.

## Migration from 2.0-2.3 to 2.4+

Version 2.4 adds support for PHP 7. In PHP 7, `float` is a reserved keyword, which required renaming
the `Float` validator. If you were using the `Float` validator directly previously, you will now
receive an `E_USER_DEPRECATED` notice on instantiation. Please update your code to refer to the
`IsFloat` class instead.

Users pulling their `Float` validator instance from the validator plugin manager receive an
`IsFloat` instance instead starting in 2.4.0.

### IsInt

`Zend\I18n\Validator\IsInt` validates if a given value is an integer. Also localized integer values
are recognised and can be validated.

## Supported Options

The following options are supported for `Zend\I18n\Validator\IsInt`:

- **locale**: Sets the locale which will be used to validate localized integers.

## Simple integer validation

The simplest way to validate an integer is by using the system settings. When no option is used, the
environment locale is used for validation:

```php
$validator = new Zend\I18n\Validator\IsInt();

$validator->isValid(1234);   // returns true
$validator->isValid(1234.5); // returns false
$validator->isValid('1,234'); // returns true
```

In the above example we expected that our environment is set to "en" as locale. As you can see in
the third example also grouping is recognised.

## Localized integer validation

Often it's useful to be able to validate also localized values. Integer values are often written
different in other countries. For example using english you can write "1234" or "1,234". Both are
integer values but the grouping is optional. In german for example you may write "1.234" and in
french "1 234".

`Zend\I18n\Validator\IsInt` is able to validate such notations. But it is limited to the locale you
set. This means that it not simply strips off the separator, it validates if the correct separator
is used. See the following code:

```php
$validator = new Zend\I18n\Validator\IsInt(array('locale' => 'de'));

$validator->isValid(1234); // returns true
$validator->isValid("1,234"); // returns false
$validator->isValid("1.234"); // returns true
```

As you can see, by using a locale, your input is validated localized. Using the english notation you
get a `FALSE` when the locale forces a different notation.

The locale can also be set afterwards by using `setLocale()` and retrieved by using `getLocale()`.

## Migration from 2.0-2.3 to 2.4+

Version 2.4 adds support for PHP 7. In PHP 7, `int` is a reserved keyword, which required renaming
the `Int` validator. If you were using the `Int` validator directly previously, you will now receive
an `E_USER_DEPRECATED` notice on instantiation. Please update your code to refer to the `IsInt`
class instead.

Users pulling their `Int` validator instance from the validator plugin manager receive an `IsInt`
instance instead starting in 2.4.0.
