<?php
	define('__ROOT__', $_SERVER['DOCUMENT_ROOT']);
	define('__MAIN__', $_SERVER['SCRIPT_FILENAME']);
	/**
	 * Checks if needle is string is a prefix of the other string.
	 * @param string &$haystack 
	 * @param string $needle 
	 * @return string
	 */
	function starts_with($haystack, $needle) {
		if (strlen($haystack) < strlen($needle))
			return false;
		return substr_compare($haystack, $needle, 0, strlen($needle)) === 0;
	}

	/**
	 * Checks if needle is string is a suffix of the other string.
	 * @param string &$haystack 
	 * @param string $needle 
	 * @return string
	 */
	function ends_with($haystack, $needle) {
		$hlen = strlen($haystack);
		$nlen = strlen($needle);
		if ($hlen < $nlen) return false;
		return substr_compare($haystack, $needle, $hlen - $nlen) === 0;
	}

	/**
	 * Saves or reads JSON file in the /json directory.
	 * @param string $filename the JSON file name that will be searched in the /json directory. will automatically append the .json extension.
	 * @param string &$data data to put to the JSON file. if not specified, this function will return the contents of the json file.
	 * @return string the encoded JSON string if data is not null
		 * @return type the JSON object if the data is null
	 */
	function json($filename, $data = null) {
		$prefix = $_SERVER['DOCUMENT_ROOT'];
		if ($prefix[strlen($prefix) - 1] != '/')
			$prefix .= '/';
		$filename = $prefix."json/$filename.json";
		if (!is_null($data)) {
			$encoded = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK);
			file_put_contents($filename, $encoded);
			return $encoded;
		}
		else if (file_exists($filename))
			return json_decode(file_get_contents($filename), true);
		else
			return array();
	}

	/**
	 * Forcefully redirects current page to the designated url using javascript.
	 * @param string $link
	 * 		The URL of the page to be redirected to.
	 * @return void
	 */
	function redirect($link) {
		if ($link != '' && strpos($link, 'http') === false)
			while (!file_exists($link))
				$link = '../'.$link;
		die ('<script> window.location.href = "'.$link.'"</script>');
	}

	function join_path($array, $b = NULL) {
		if (!is_null($b)) {
			$array = array($array, $b);
		}
		$d = DIRECTORY_SEPARATOR;
		return join($d, $array);
	}

	/**
	 * References to a source code.
	 * @param string $link 
	 * @param int $limit the limit to the number of parent folders searched
	 * @return void
	 * Possible extensions: *.(php|css|js).
	 * Automatically prepends the address with the extension (e.g. "file.php" => "php/file.php").
	 * Iteratively searches for the nearest uncle in the file directory.
	 */
	function source($link, $limit = 5) {
		$link = trim($link);
		if (empty($link)) return '';
		$ext = pathinfo($link, PATHINFO_EXTENSION);
		// check first if permalink
		if (strpos($link, '://') === false) {
			// minify
			if (defined('MINIFY_JS') && $ext == 'js' && !ends_with($link, ".min.js"))
				$link = basename($link, '.js').'.min.js';
			if (defined('MINIFY_CSS') && $ext == 'css' && !ends_with($link, '.min.css'))
				$link = basename($link, '.css').'.min.css';
			// try relative paths if file exists
			for ($iter = 0, $found = false; $iter < 2 && !$found; ++$iter) {
				$cur_link = $iter ? join_path($ext, $link) : $link;
				for ($i = 0; $i < $limit; ++$i) {
					if (file_exists($cur_link)) {
						$link = $cur_link;
						$found = true;
						break;
					}
					$cur_link = join_path('..', $cur_link);
				}
			}
		}
		// refer to the link
		switch ($ext) {
			case 'css':
				echo "<link rel='stylesheet' type='text/css' href='$link'>";
				break;
			case 'js':
				echo "<script src='$link'></script>";
				break;
			case 'php':
				include $link;
				break;
		}
		return $link;
	}

	/**
	 * Convenient method for array key-value acquisition.
	 * @param array &$array input array
	 * @param type $key
	 * @param type $default the value to return if key is not set
	 * @return type
	 */
	function get(&$array, $key, $default = NULL) {
		return isset($array[$key]) ? $array[$key] : $default;
	}

	/**
	 * Convenient method for normalizing HTML attributes. replaces ' ' with '-' and removes all single quotes.
	 * @param string $text text you want to normalize 
	 * @return string
	 */
	function propertize($text) {
		return str_replace(array(' ', "'"), array('-', ''), strtolower($text));
	}

	/**
	 * Wraps and replaces line breaks with HTML paragraph tags.
	 * @param type $text text you want to transform into an html paragraph
	 * @return type
	 */
	function paragraph($text) {
		if ($text === null || $text === '') return '';
		return '<p>'.str_replace('\n', '</p><p>', $text).'</p>';
	}
?>