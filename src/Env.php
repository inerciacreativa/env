<?php

/**
 * Class Env
 */
class Env
{

	public const CONVERT_BOOL = 1;

	public const CONVERT_NULL = 2;

	public const CONVERT_NUMBERS = 4;

	public const STRIP_QUOTES = 8;

	public const USE_ENV = 16;

	public const USE_SERVER = 32;

	public const USE_FUNCTION = 64;

	public static $options = self::CONVERT_BOOL | self::CONVERT_NULL | self::CONVERT_NUMBERS | self::STRIP_QUOTES | self::USE_ENV | self::USE_SERVER;

	/**
	 * Returns an environment variable.
	 *
	 * @param string $name
	 * @param mixed  $default
	 *
	 * @return mixed
	 */
	public static function get(string $name, $default = null)
	{
		if (self::useEnv($name)) {
			$value = $_ENV[$name];
		} else if (self::useServer($name)) {
			$value = $_SERVER[$name];
		} else if (self::useFunction()) {
			$value = getenv($name);
		}

		if (!isset($value)) {
			return $default;
		}

		return self::convert($value);
	}

	/**
	 * Converts the type of values like "true", "false", "null" or "123".
	 *
	 * @param string   $value
	 * @param int|null $options
	 *
	 * @return mixed
	 */
	public static function convert(string $value, int $options = null)
	{
		if ($options === null) {
			$options = self::$options;
		}

		switch (strtolower($value)) {
			case 'true':
				return ($options & self::CONVERT_BOOL) ? true : $value;

			case 'false':
				return ($options & self::CONVERT_BOOL) ? false : $value;

			case 'null':
				return ($options & self::CONVERT_NULL) ? null : $value;
		}

		if (($options & self::CONVERT_NUMBERS) && is_numeric($value)) {
			return $value + 0;
		}

		if (($options & self::STRIP_QUOTES) && !empty($value)) {
			return self::stripQuotes($value);
		}

		return $value;
	}

	/**
	 * @param string $name
	 *
	 * @return bool
	 */
	protected static function useEnv(string $name): bool
	{
		return (self::$options & self::USE_ENV) && array_key_exists($name, $_ENV);
	}

	/**
	 * @param string $name
	 *
	 * @return bool
	 */
	protected static function useServer(string $name): bool
	{
		return (self::$options & self::USE_SERVER) && array_key_exists($name, $_SERVER);
	}

	/**
	 * @return bool
	 */
	protected static function useFunction(): bool
	{
		return (self::$options & self::USE_FUNCTION) && function_exists('getenv') && function_exists('putenv');
	}

	/**
	 * Strip quotes.
	 *
	 * @param string $value
	 *
	 * @return string
	 */
	protected static function stripQuotes(string $value): string
	{
		if (self::hasQuotes($value, '"') || self::hasQuotes($value, "'")) {
			return substr($value, 1, -1);
		}

		return $value;
	}

	/**
	 * @param string $value
	 * @param string $quote
	 *
	 * @return bool
	 */
	protected static function hasQuotes(string $value, string $quote): bool
	{
		return strpos($value, $quote) === 0 && substr($value, -1) === $quote;
	}

}
