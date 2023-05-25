<?php

namespace Sellacious\Cli;

require_once __DIR__ . '/color.php';

use DateTime;

class Prompt
{
	public static function say($message)
	{
		echo Color::GREEN . $message . Color::RESET;
	}

	public static function ask($message)
	{
		echo Color::BLUE . $message . Color::RESET;

		$input = readline();

		readline_add_history($input);

		return $input;
	}

	public static function errorMessage($message)
	{
		echo Color::RED . $message . Color::RESET . PHP_EOL;
	}

	public static function askString($prompt)
	{
		return self::ask($prompt);
	}

	public static function askInteger($prompt)
	{
		while (true)
		{
			$input = self::ask($prompt);

			if ($input === '')
			{
				return $input;
			}

			if (is_numeric($input) && (int) $input == $input)
			{
				return (int) $input;
			}

			self::errorMessage("Invalid input. Please enter a valid integer value.");
		}
	}

	public static function askFloat($prompt)
	{
		while (true)
		{
			$input = self::ask($prompt);

			if ($input === '')
			{
				return $input;
			}

			if (is_numeric($input))
			{
				return (float) $input;
			}

			self::errorMessage("Invalid input. Please enter a valid float value.");
		}
	}

	public static function askBoolean($prompt)
	{
		while (true)
		{
			$input = self::ask($prompt);

			if ($input === '')
			{
				return $input;
			}

			$input = strtolower($input);

			if ($input === 'yes' || $input === 'y' || $input === 'true' || $input === '1')
			{
				return true;
			}

			if ($input === 'no' || $input === 'n' || $input === 'false' || $input === '0')
			{
				return false;
			}

			self::errorMessage("Invalid input. Please enter either '(y)es' or '(n)o'.");
		}
	}

	public static function askDate($prompt)
	{
		while (true)
		{
			$input = self::ask($prompt . " (YYYY-MM-DD)");

			if ($input === '')
			{
				return $input;
			}

			$date = DateTime::createFromFormat('Y-m-d', $input);

			if ($date && $date->format('Y-m-d') === $input)
			{
				return $input;
			}

			self::errorMessage("Invalid input. Please enter a valid date in the format 'YYYY-MM-DD'.");
		}
	}
}
