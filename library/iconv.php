<?

function iconv_strlen($string, $charset = null)
{
	return is_null($charset) ? mb_strlen($string) : mb_strlen($string, $charset);
}

function iconv_strpos($string, $substring, $offset = 0, $charset = null)
{
	return is_null($charset) ? mb_strpos($string, $substring, $offset)
		: mb_strpos($string, $substring, $offset, $charset);
}

function iconv_substr(string $string, int $offset, ?int $length = null, ?string $encoding = null)
{
	return is_null($encoding)
		? mb_substr($string, $offset, $length)
		: mb_substr($string, $offset, $length, $encoding);
}