<?php
/**
 * @declare 日志工具
 */
class Log {
	private static $logpath = LOG_DIR;

	public static function writeLog($strFileName, $strFix ,$strMSG) {

		if (!file_exists(self::$logpath))
		{
			if (!mkdir(self::$logpath, '0777'))
			{
				if (DEBUG_MODE)
				{
					die(Tools::displayError("Make " . self::$logpath . " error"));
				}
				else
				{
					die("error");
				}
			}
		}
		elseif (!is_dir(self::$logpath))
		{
			if (DEBUG_MODE)
			{
				die(Tools::displayError(self::$logpath . " is already token by a file"));
			}
			else
			{
				die("error");
			}
		}
		else
		{
			if (!is_writable(self::$logpath))
			{
				@chmod(self::$logpath, 0777);
			}
			$logfile = rtrim(self::$logpath, '/') . '/' . $strFileName . '.log';
			if (file_exists($logfile) && !is_writable($logfile))
			{
				@chmod($logfile, 0644);
			}
			$handle = @fopen($logfile, "a");
			if ($handle)
			{
				if (!empty($strMSG)){
					$strContent = $strFix.':'.$strMSG."\r\n";
				}
				else {
					$strContent = $strFix."\r\n";
				}
				if (!fwrite($handle, $strContent))
				{
					@fclose($handle);
					die("Write permission deny");
				}
				@fclose($handle);
			}
		}
	}

	/**
	 * 读文件内容
	 *
	 * @param $strFileName
	 *
	 * @return bool|string
	 */
	public static function readLog($strFileName) {
		$logfile = trim(self::$logpath, '/') . '/' . $strFileName . '.log';
		if (file_exists($logfile) && is_readable($logfile))
		{
			$strContent = '';
			$handler = @fopen($logfile, 'r');
			if ($handler)
			{
				while (!feof($handler))
				{
					$strContent .= fgets($handler);
				}
				@fclose($handler);
			}

			return $strContent;
		}

		return false;
	}
}

?>
