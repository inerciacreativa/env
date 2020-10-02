# env

Simple library to get environment variables converted to simple types. This library is just a fork of [oscarotero/env](https://packagist.org/packages/oscarotero/env).

## Example

```php
// Using getenv function:
var_dump(getenv('FOO')); //string(5) "false"

// Using Env:
var_dump(Env::get('FOO')); //bool(false)
```

## Available conversions

* `"false"` is converted to boolean `false`
* `"true"` is converted to boolean `true`
* `"null"` is converted to `null`
* If the string contains only numbers is converted to an integer or float
* If the string has quotes, remove them

## Options

To configure the conversion, you can use the following constants (all enabled by default):

* `Env::CONVERT_BOOL` To convert boolean values
* `Env::CONVERT_NULL` To convert null values
* `Env::CONVERT_NUMERIC` To convert numeric values
* `Env::STRIP_QUOTES` To remove the quotes of the strings

The following settings allow to specify where to get the values (only the first two are enabled by default):

* `Env::USE_ENV` To get the values from `$_ENV`
* `Env::USE_SERVER` To get the values from `$_SERVER`
* `Env::USE_FUNCTION` To get the values from `getenv()`

```php
// Convert booleans and null, but not numbers or strip quotes
Env::$options = Env::CONVERT_BOOL | Env::CONVERT_NULL;

// Add one more option
Env::$options |= Env::USE_FUNCTION;

// Remove one option
Env::$options ^= Env::CONVERT_NULL;
```
