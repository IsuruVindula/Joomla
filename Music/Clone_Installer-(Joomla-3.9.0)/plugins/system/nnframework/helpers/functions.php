<?php
/**
 * @package         NoNumber Framework
 * @version         18.10.16084
 * 
 * @author          Peter van Westen <info@regularlabs.com>
 * @link            http://www.regularlabs.com
 * @copyright       Copyright © 2018 Regular Labs All Rights Reserved
 * @license         http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

defined('_JEXEC') or die;

use Joomla\CMS\Application\ApplicationHelper as JApplicationHelper;
use Joomla\CMS\Factory as JFactory;
use Joomla\CMS\Http\HttpFactory as JHttpFactory;
use Joomla\CMS\Language\Text as JText;
use Joomla\CMS\Uri\Uri as JUri;

require_once __DIR__ . '/cache.php';

/**
 * Framework Functions
 */
class NNFrameworkFunctions
{
	var $_version = '14.9.1';

	public static function isFeed()
	{
		return (
			JFactory::getDocument()->getType() == 'feed'
			|| JFactory::getApplication()->input->getWord('format') == 'feed'
			|| JFactory::getApplication()->input->getWord('type') == 'rss'
			|| JFactory::getApplication()->input->getWord('type') == 'atom'
		);
	}

	public static function script($file, $version = '')
	{
		if ( ! $file = self::getFileByFolder('js', $file))
		{
			return;
		}

		if ( ! empty($version))
		{
			$file .= '?v=' . $version;
		}

		JFactory::getDocument()->addScript($file);
	}

	public static function stylesheet($file, $version = '')
	{
		if ( ! $file = self::getFileByFolder('css', $file))
		{
			return;
		}

		if ( ! empty($version))
		{
			$file .= '?v=' . $version;
		}

		JFactory::getDocument()->addStylesheet($file);
	}

	protected static function getFileByFolder($folder, $file)
	{
		// If http is present in filename
		if (strpos($file, 'http') === 0 || strpos($file, '//') === 0)
		{
			return $file;
		}

		// Get the template
		$template = JFactory::getApplication()->getTemplate();

		$files = [];

		// Detect debug mode
		if (JFactory::getConfig()->get('debug') || JFactory::getApplication()->input->get('debug'))
		{
			$files[] = str_replace(['.min.', '-min.'], '.', $file);
		}

		$files[] = $file;

		/*
		 * Loop on 1 or 2 files and break on first found.
		 * Add the content of the MD5SUM file located in the same folder to url to ensure cache browser refresh
		 * This MD5SUM file must represent the signature of the folder content
		 */
		foreach ($files as $check_file)
		{
			// If the file is in the template folder
			if ($file_found = self::fileExists('/templates/' . $template . '/' . $folder . '/' . $check_file))
			{
				return $file_found;
			}

			// Try to deal with system files in the media folder
			if (strpos($check_file, '/') === false)
			{
				if ($file_found = self::fileExists('/media/system' . $folder . '/' . $check_file))
				{
					return $file_found;
				}

				continue;
			}

			if ($file_found = self::fileExistsByFolder($check_file, $folder))
			{
				return $file_found;
			}
		}

		return false;
	}

	private static function fileExistsByFolder($file, $folder)
	{
		$template = JFactory::getApplication()->getTemplate();

		// If the file is in the template folder
		if ($file_found = self::fileExists('/templates/' . $template . '/' . $folder . '/' . $file))
		{
			return $file_found;
		}

		// Try to deal with system files in the media folder
		if (strpos($file, '/') === false)
		{
			if ($file_found = self::fileExists('/media/system/' . $folder . '/' . $file))
			{
				return $file_found;
			}

			return false;
		}

		$paths = [];

		// If the file contains any /: it can be in a media extension subfolder
		// Divide the file extracting the extension as the first part before /
		list($extension, $file) = explode('/', $file, 2);

		$paths[] = '/media/' . $extension . '/' . $folder;
		$paths[] = '/templates/' . $template . '/' . $folder . '/system';
		$paths[] = '/media/system/' . $folder;

		foreach ($paths as $path)
		{
			if ($file_found = self::fileExists($path . '/' . $file))
			{
				return $file_found;
			}
		}

		return false;
	}

	private static function fileExists($path)
	{
		if ( ! file_exists(JPATH_ROOT . $path))
		{
			return false;
		}

		return JUri::root(true) . $path;
	}

	/*
	 * @Deprecated
	 * Use NNFrameworkFunctions::script($url, $version) instead
	 */
	public static function addScriptVersion($url)
	{
		jimport('joomla.filesystem.file');

		if ( ! empty($_GET['debug']))
		{
			$url = str_replace('.min.', '.', $url);
		}

		if ( ! JFile::exists(JPATH_SITE . $url))
		{
			return JFactory::getDocument()->addScriptVersion($url);
		}

		JFactory::getDocument()->addScript($url . '?' . filemtime(JPATH_SITE . $url));
	}

	/*
	 * @Deprecated
	 * Use NNFrameworkFunctions::stylesheet($url, $version) instead
	 */
	public static function addStyleSheetVersion($url)
	{
		jimport('joomla.filesystem.file');

		if ( ! empty($_GET['debug']))
		{
			$url = str_replace('.min.', '.', $url);
		}

		if ( ! JFile::exists(JPATH_SITE . $url))
		{
			return JFactory::getDocument()->addStyleSheetVersion($url);
		}

		JFactory::getDocument()->addStyleSheet($url . '?' . filemtime(JPATH_SITE . $url));
	}

	public function getByUrl($url)
	{
		$hash = md5('getByUrl_' . $url);

		if (NNCache::has($hash))
		{
			return NNCache::get($hash);
		}

		// only allow url calls from administrator
		if ( ! JFactory::getApplication()->isClient('administrator'))
		{
			die;
		}

		// only allow when logged in
		$user = JFactory::getUser();
		if ( ! $user->id)
		{
			die;
		}

		if (substr($url, 0, 4) != 'http')
		{
			$url = 'http://' . $url;
		}

		// only allow url calls to nonumber.nl domain
		if ( ! (preg_match('#^https?://([^/]+\.)?nonumber\.nl/#', $url)))
		{
			die;
		}

		// only allow url calls to certain files
		if (
			strpos($url, 'download.nonumber.nl/extensions.php') === false
			&& strpos($url, 'download.nonumber.nl/extensions.json') === false
			&& strpos($url, 'download.nonumber.nl/extensions.xml') === false
		)
		{
			die;
		}

		$format = (strpos($url, '.json') !== false || strpos($url, 'format=json') !== false)
			? 'application/json'
			: 'text/xml';

		header("Pragma: public");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Cache-Control: public");
		header("Content-type: " . $format);

		return NNCache::set(
			$hash,
			self::getContents($url)
		);
	}

	public function getContents($url, $timeout = 20)
	{
		$hash = md5('getContents_' . $url);

		if (NNCache::has($hash))
		{
			return NNCache::get($hash);
		}

		if (JFactory::getApplication()->input->getInt('cache', 0)
			&& $content = NNCache::read($hash)
		)
		{
			return $content;
		}

		try
		{
			$content = JHttpFactory::getHttp()->get($url, null, $timeout)->body;
		}
		catch (RuntimeException $e)
		{
			return '';
		}

		if ($ttl = JFactory::getApplication()->input->getInt('cache', 0))
		{
			return NNCache::write($hash, $content, $ttl > 1 ? $ttl : 0);
		}

		return NNCache::set($hash, $content);
	}

	public static function getComponentBuffer()
	{
		$buffer = JFactory::getDocument()->getBuffer('component');

		if (empty($buffer) || ! is_string($buffer))
		{
			return false;
		}

		$buffer = trim($buffer);

		if (empty($buffer))
		{
			return false;
		}

		return $buffer;
	}

	public static function getAliasAndElement(&$name)
	{
		$name    = self::getNameByAlias($name);
		$alias   = self::getAliasByName($name);
		$element = self::getElementByAlias($alias);

		return [$alias, $element];
	}

	public static function getNameByAlias($alias)
	{
		// Alias is a language string
		if (strpos($alias, ' ') === false && strtoupper($alias) == $alias)
		{
			return JText::_($alias);
		}

		// Alias has a space and/or capitals, so is already a name
		if (strpos($alias, ' ') !== false || $alias !== strtolower($alias))
		{
			return $alias;
		}

		return JText::_(self::getXMLValue('name', $alias));
	}

	public static function getAliasByName($name)
	{
		$alias = preg_replace('#[^a-z0-9]#', '', strtolower($name));

		switch ($alias)
		{
			case 'advancedmodules':
				return 'advancedmodulemanager';

			case 'advancedtemplates':
				return 'advancedtemplatemanager';

			case 'nonumbermanager':
				return 'nonumberextensionmanager';

			case 'what-nothing':
				return 'whatnothing';
		}

		return $alias;
	}

	public static function getElementByAlias($alias)
	{
		$alias = self::getAliasByName($alias);

		switch ($alias)
		{
			case 'advancedmodulemanager':
				return 'advancedmodules';

			case 'advancedtemplatemanager':
				return 'advancedtemplates';

			case 'nonumberextensionmanager':
				return 'nonumbermanager';
		}

		return $alias;
	}

	static function getXMLValue($key, $alias, $type = 'component', $folder = 'system')
	{
		if ( ! $xml = self::getXML($alias, $type, $folder))
		{
			return '';
		}

		if ( ! isset($xml[$key]))
		{
			return '';
		}

		return isset($xml[$key]) ? $xml[$key] : '';
	}

	static function getXML($alias, $type = 'component', $folder = 'system')
	{
		if ( ! $file = self::getXMLFile($alias, $type, $folder))
		{
			return false;
		}

		return JApplicationHelper::parseXMLInstallFile($file);
	}

	static function getXMLFile($alias, $type = 'component', $folder = 'system')
	{
		jimport('joomla.filesystem.file');

		$element = self::getElementByAlias($alias);

		$files = [];

		// Components
		if (empty($type) || $type == 'component')
		{
			$files[] = JPATH_ADMINISTRATOR . '/components/com_' . $element . '/' . $element . '.xml';
			$files[] = JPATH_SITE . '/components/com_' . $element . '/' . $element . '.xml';
			$files[] = JPATH_ADMINISTRATOR . '/components/com_' . $element . '/com_' . $element . '.xml';
			$files[] = JPATH_SITE . '/components/com_' . $element . '/com_' . $element . '.xml';
		}

		// Plugins
		if (empty($type) || $type == 'plugin')
		{
			if ( ! empty($folder))
			{
				$files[] = JPATH_PLUGINS . '/' . $folder . '/' . $element . '/' . $element . '.xml';
				$files[] = JPATH_PLUGINS . '/' . $folder . '/' . $element . '.xml';
			}

			// System Plugins
			$files[] = JPATH_PLUGINS . '/system/' . $element . '/' . $element . '.xml';
			$files[] = JPATH_PLUGINS . '/system/' . $element . '.xml';

			// Editor Button Plugins
			$files[] = JPATH_PLUGINS . '/editors-xtd/' . $element . '/' . $element . '.xml';
			$files[] = JPATH_PLUGINS . '/editors-xtd/' . $element . '.xml';
		}

		// Modules
		if (empty($type) || $type == 'module')
		{
			$files[] = JPATH_ADMINISTRATOR . '/modules/mod_' . $element . '/' . $element . '.xml';
			$files[] = JPATH_SITE . '/modules/mod_' . $element . '/' . $element . '.xml';
			$files[] = JPATH_ADMINISTRATOR . '/modules/mod_' . $element . '/mod_' . $element . '.xml';
			$files[] = JPATH_SITE . '/modules/mod_' . $element . '/mod_' . $element . '.xml';
		}

		foreach ($files as $file)
		{
			if ( ! JFile::exists($file))
			{
				continue;
			}

			return $file;
		}

		return '';
	}

	static function extensionInstalled($extension, $type = 'component', $folder = 'system')
	{
		jimport('joomla.filesystem.folder');
		jimport('joomla.filesystem.file');

		switch ($type)
		{
			case 'component':
				if (JFile::exists(JPATH_ADMINISTRATOR . '/components/com_' . $extension . '/' . $extension . '.php')
					|| JFile::exists(JPATH_ADMINISTRATOR . '/components/com_' . $extension . '/admin.' . $extension . '.php')
					|| JFile::exists(JPATH_SITE . '/components/com_' . $extension . '/' . $extension . '.php')
				)
				{
					if ($extension == 'cookieconfirm')
					{
						// Only Cookie Confirm 2.0.0.rc1 and above is supported, because
						// previous versions don't have isCookiesAllowed()
						require_once JPATH_ADMINISTRATOR . '/components/com_cookieconfirm/version.php';

						if (version_compare(COOKIECONFIRM_VERSION, '2.2.0.rc1', '<'))
						{
							return false;
						}
					}

					return true;
				}
				break;

			case 'plugin':
				return JFile::exists(JPATH_PLUGINS . '/' . $folder . '/' . $extension . '/' . $extension . '.php');

			case 'module':
				return (JFile::exists(JPATH_ADMINISTRATOR . '/modules/mod_' . $extension . '/' . $extension . '.php')
					|| JFile::exists(JPATH_ADMINISTRATOR . '/modules/mod_' . $extension . '/mod_' . $extension . '.php')
					|| JFile::exists(JPATH_SITE . '/modules/mod_' . $extension . '/' . $extension . '.php')
					|| JFile::exists(JPATH_SITE . '/modules/mod_' . $extension . '/mod_' . $extension . '.php')
				);

			case 'library':
				return JFolder::exists(JPATH_LIBRARIES . '/' . $extension);
		}

		return false;
	}

	static function loadLanguage($extension = 'plg_system_nnframework', $basePath = '')
	{
		if ($basePath && JFactory::getLanguage()->load($extension, $basePath))
		{
			return true;
		}

		$basePath = self::getExtensionPath($extension, $basePath, 'language');

		return JFactory::getLanguage()->load($extension, $basePath);
	}

	static function getExtensionPath($extension = 'plg_system_nnframework', $basePath = JPATH_ADMINISTRATOR, $check_folder = '')
	{
		$basePath = $basePath ?: JPATH_SITE;

		if ( ! in_array($basePath, [JPATH_ADMINISTRATOR, JPATH_SITE]))
		{
			return $basePath;
		}

		switch (true)
		{
			case (strpos($extension, 'com_') === 0):
				$path = 'components/' . $extension;
				break;

			case (strpos($extension, 'mod_') === 0):
				$path = 'modules/' . $extension;
				break;

			case (strpos($extension, 'plg_system_') === 0):
				$path = 'plugins/system/' . substr($extension, strlen('plg_system_'));
				break;

			case (strpos($extension, 'plg_editors-xtd_') === 0):
				$path = 'plugins/editors-xtd/' . substr($extension, strlen('plg_editors-xtd_'));
				break;
		}

		$check_folder = $check_folder ? '/' . $check_folder : '';

		if (is_dir($basePath . '/' . $path . $check_folder))
		{
			return $basePath . '/' . $path;
		}

		if (is_dir(JPATH_ADMINISTRATOR . '/' . $path . $check_folder))
		{
			return JPATH_ADMINISTRATOR . '/' . $path;
		}

		if (is_dir(JPATH_SITE . '/' . $path . $check_folder))
		{
			return JPATH_SITE . '/' . $path;
		}

		return $basePath;
	}

	static function xmlToObject($url, $root = '')
	{
		$hash = md5('xmlToObject_' . $url . '_' . $root);

		if (NNCache::has($hash))
		{
			return NNCache::get($hash);
		}

		if (JFile::exists($url))
		{
			$xml = @new SimpleXMLElement($url, LIBXML_NONET | LIBXML_NOCDATA, 1);
		}
		else
		{
			$xml = simplexml_load_string($url, "SimpleXMLElement", LIBXML_NONET | LIBXML_NOCDATA);
		}

		if ( ! @count($xml))
		{
			return NNCache::set(
				$hash,
				new stdClass
			);
		}

		if ($root)
		{
			if ( ! isset($xml->{$root}))
			{
				return NNCache::set(
					$hash,
					new stdClass
				);
			}

			$xml = $xml->{$root};
		}

		$json = json_encode($xml);
		$xml  = json_decode($json);
		if (is_null($xml))
		{
			$xml = (object) [];
		}

		if ($root && isset($xml->{$root}))
		{
			$xml = $xml->{$root};
		}

		return NNCache::set(
			$hash,
			$xml
		);
	}

	/*
	 * @Deprecated
	 */
	protected
	function curl($url)
	{
		$hash = md5('curl_' . $url);

		if (NNCache::has($hash))
		{
			return NNCache::get($hash);
		}

		$timeout = JFactory::getApplication()->input->getInt('timeout', 3);
		$timeout = min([30, max([3, $timeout])]);

		$ch = curl_init($url);

		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_USERAGENT, 'NoNumber/' . $this->_version);
		curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);

		//follow on location problems
		if ( ! ini_get('safe_mode') && ! ini_get('open_basedir'))
		{
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
			$html = curl_exec($ch);
		}
		else
		{
			$html = $this->curl_redir_exec($ch);
		}
		curl_close($ch);

		return NNCache::set(
			$hash,
			$html
		);
	}

	/*
	 * @Deprecated
	 */
	public function curl_redir_exec($ch)
	{
		static $curl_loops = 0;
		static $curl_max_loops = 20;

		if ($curl_loops++ >= $curl_max_loops)
		{
			$curl_loops = 0;

			return false;
		}

		curl_setopt($ch, CURLOPT_HEADER, true);
		$data = curl_exec($ch);

		list($header, $data) = explode("\n\n", str_replace("\r", '', $data), 2);
		$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		if ($http_code != 301 && $http_code != 302)
		{
			return $data;
		}

		$matches = [];
		preg_match('/Location:(.*?)\n/', $header, $matches);
		$url = @parse_url(trim(array_pop($matches)));
		if ( ! $url)
		{
			//couldn't process the url to redirect to
			$curl_loops = 0;

			return $data;
		}
		$last_url = parse_url(curl_getinfo($ch, CURLINFO_EFFECTIVE_URL));
		if ( ! $url['scheme'])
		{
			$url['scheme'] = $last_url['scheme'];
		}
		if ( ! $url['host'])
		{
			$url['host'] = $last_url['host'];
		}
		if ( ! $url['path'])
		{
			$url['path'] = $last_url['path'];
		}
		$new_url = $url['scheme'] . '://' . $url['host'] . $url['path'] . ($url['query'] ? '?' . $url['query'] : '');
		curl_setopt($ch, CURLOPT_URL, $new_url);

		return self::curl_redir_exec($ch);
	}
}
