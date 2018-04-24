# env

Simple library to get environment variables converted to simple types. This library is just a fork of [oscarotero/env](https://packagist.org/packages/oscarotero/env).

## Example

```php
// Using getenv function:
var_dump(Env::get('FOO')); //string(5) "false"

// Using Env:
var_dump(Env::get('FOO')); //bool(false)
```

## Available conversions

* `"false"` is converted to boolean `false`
* `"true"` is converted to boolean `true`
* `"null"` is converted to `null`
* If the string contains only numbers is converted to an integer
* If the string has quotes, remove them

## Options

To configure the conversion, you can use the following constants (all enabled by default):

* `Env::CONVERT_BOOL` To convert boolean values
* `Env::CONVERT_NULL` To convert null values
* `Env::CONVERT_INT` To convert integer values
* `Env::STRIP_QUOTES` To remove the quotes of the strings
* `Env::USE_ENV_ARRAY` To get the values from `$_ENV`, instead `getenv()`.
