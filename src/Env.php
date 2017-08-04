<?php

class Env {

	const CONVERT_BOOL = 1;

	const CONVERT_NULL = 2;

	const CONVERT_INT = 4;

	const STRIP_QUOTES = 8;

	const USE_ENV_ARRAY = 16;

	public static $options = self::CONVERT_BOOL | self::CONVERT_NULL | self::CONVERT_INT | self::STRIP_QUOTES;

	/**
	 * Returns an environment variable.
	 *
	 * @param string $name
	 * @param mixed $default
	 *
	 * @return mixed
	 */
	public static function get(string $name, $default = null) {
		if (self::$options & self::USE_ENV_ARRAY) {
			$value = $_ENV[$name] ?? false;
		} else {
			$value = getenv($name);
		}

		if ($value === false) {
			return $default;
		}

		return self::convert($value);
	}

	/**
	 * Converts the type of values like "true", "false", "null" or "123".
	 *
	 * @param string $value
	 * @param int|null $options
	 *
	 * @return mixed
	 */
	public static function convert(string $value, int $options = null) {
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

		if (($options & self::CONVERT_INT) && ctype_digit($value)) {
			return (int) $value;
		}

		if (($options & self::STRIP_QUOTES) && !empty($value)) {
			return self::stripQuotes($value);
		}

		return $value;
	}

	/**
	 * Strip quotes.
	 *
	 * @param string $value
	 *
	 * @return string
	 */
	private static function stripQuotes(string $value): string {
		if (($value[0] === '"' && substr($value, -1) === '"') || ($value[0] === "'" && substr($value, -1) === "'")) {
			return substr($value, 1, -1);
		}

		return $value;
	}

}
