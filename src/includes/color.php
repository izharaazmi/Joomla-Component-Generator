<?php

namespace Sellacious\Cli;

class Color
{
	const BLACK = "\033[0;30m";
	const RED = "\033[0;31m";
	const GREEN = "\033[0;32m";
	const YELLOW = "\033[0;33m";
	const BLUE = "\033[0;34m";
	const MAGENTA = "\033[0;35m";
	const CYAN = "\033[0;36m";
	const WHITE = "\033[0;37m";

	const BOLD_BLACK = "\033[1;30m";
	const BOLD_RED = "\033[1;31m";
	const BOLD_GREEN = "\033[1;32m";
	const BOLD_YELLOW = "\033[1;33m";
	const BOLD_BLUE = "\033[1;34m";
	const BOLD_MAGENTA = "\033[1;35m";
	const BOLD_CYAN = "\033[1;36m";
	const BOLD_WHITE = "\033[1;37m";

	const UNDERLINE_BLACK = "\033[4;30m";
	const UNDERLINE_RED = "\033[4;31m";
	const UNDERLINE_GREEN = "\033[4;32m";
	const UNDERLINE_YELLOW = "\033[4;33m";
	const UNDERLINE_BLUE = "\033[4;34m";
	const UNDERLINE_MAGENTA = "\033[4;35m";
	const UNDERLINE_CYAN = "\033[4;36m";
	const UNDERLINE_WHITE = "\033[4;37m";

	const BACKGROUND_BLACK = "\033[40m";
	const BACKGROUND_RED = "\033[41m";
	const BACKGROUND_GREEN = "\033[42m";
	const BACKGROUND_YELLOW = "\033[43m";
	const BACKGROUND_BLUE = "\033[44m";
	const BACKGROUND_MAGENTA = "\033[45m";
	const BACKGROUND_CYAN = "\033[46m";
	const BACKGROUND_WHITE = "\033[47m";

	const RESET = "\033[0m";
}
