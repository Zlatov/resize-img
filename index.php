<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Resizing images</title>

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body>

<div class="container">
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<h1 class="text-center"><a href="">Resizing images in a local directory and (or) creating thumbnails</a></h1>
			<form action="" method="POST" role="form" class="form-horizontal">
				<fieldset>
					<legend>What to do?</legend>

					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">

							<div data-toggle="buttons" class="btn-group">
								<label class="btn btn-primary">
									<input type="radio" name="do" id="input" class="sr-only" required value="resize">
									Just change the image size
								</label>

								<label class="btn btn-primary">
									<input type="radio" name="do" id="input" class="sr-only" required value="thumbnails">
									Only creates thumbnails
								</label>

								<label class="btn btn-primary active">
									<input type="radio" name="do" id="input" class="sr-only" required value="resizeandthumbnails" checked="checked">
									Resize images and create thumbnails
								</label>
							</div>

						</div>
					</div>
				</fieldset>

				<fieldset>
					<legend>Options for resizing images</legend>
					<div class="form-group">

						<label for="imgwidthid" class="col-sm-2 control-label">Width</label>
						<div class="col-sm-10">
							<input type="number" name="imgwidth" class="form-control" id="imgwidthid" value="800" placeholder="Width">
						</div>

					</div>
					<div class="form-group">

						<label for="imgheightid" class="col-sm-2 control-label">Height</label>
						<div class="col-sm-10">
							<input type="number" name="imgheight" class="form-control" id="imgheightid" value="600" placeholder="Height">
						</div>

					</div>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">

							<div class="radio">
								<label>
									<input type="radio" name="imgtype" id="input" value="contain" checked="checked" required>
									<q>Contain</q> — holds the image in the frame.
								</label>
							</div>

							<div class="radio">
								<label>
									<input type="radio" name="imgtype" id="input" value="cover" required>
									<q>Cover</q> — image fills the frame
								</label>
							</div>

						</div>
					</div>
				</fieldset>
				<fieldset>
					<legend>Options for creating thumbnails</legend>
					<div class="form-group">

						<label for="thumbnailwidthid" class="col-sm-2 control-label">Width</label>
						<div class="col-sm-10">
							<input type="number" name="thumbnailwidth" class="form-control" id="thumbnailwidthid" value="250" placeholder="Thumbnail width" required>
						</div>

					</div>
					<div class="form-group">

						<label for="thumbnailheightid" class="col-sm-2 control-label">Height</label>
						<div class="col-sm-10">
							<input type="number" name="thumbnailheight" class="form-control" id="thumbnailheightid" value="250" placeholder="Thumbnail height" required>
						</div>

					</div>

					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">

							<div class="radio">
								<label>
									<input type="radio" name="thumbnailtype" id="input" value="contain" required>
									<q>Contain</q> — holds the image in the frame.
								</label>
							</div>

							<div class="radio">
								<label>
									<input type="radio" name="thumbnailtype" id="input" value="cover" checked="checked" required>
									<q>Cover</q> — image fills the frame
								</label>
							</div>

						</div>
					</div>
				</fieldset>

				<fieldset>
					<legend>Extra options</legend>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">

							<div class="checkbox">
								<label>
									<input name="subfolder" type="checkbox" value="true" checked="checked">
									Save result as a subfolder
								</label>
							</div>
						
						</div>
					</div>
				</fieldset>

				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<button type="submit" class="btn btn-primary">Du it!</button>
					</div>
				</div>

			</form>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<?php

		if (isset($_POST)&&!empty($_POST)) {
			$path = __DIR__;
			$dir = opendir($path);
			chdir($path);

			$paramImg = [
				'width' => (int)$_POST['imgwidth'],
				'height' => (int)$_POST['imgheight'],
				'kind' => $_POST['imgtype'],
				'subFolder' => (isset($_POST['subfolder'])&&($_POST['subfolder']==='true'))?true:false,
				'nameSufix' => false,
			];
			$paramThumbnail = [
				'width' => (int)$_POST['thumbnailwidth'],
				'height' => (int)$_POST['thumbnailheight'],
				'kind' => $_POST['thumbnailtype'],
				'subFolder' => (isset($_POST['subfolder'])&&($_POST['subfolder']==='true'))?true:false,
				'nameSufix' => true,
			];

			while ($f = readdir($dir))
			{
				if (is_file($f) && ($f !== ".") && ($f !== "..") && in_array(mb_strtolower(pathinfo($f)['extension']), ['png','jpg','jpeg']))
				{
					$pathToFile = $path . DIRECTORY_SEPARATOR . $f;
					try {
						$img = new ResizeImg($pathToFile);
						switch ($_POST['do']) {
							case 'resizeandthumbnails':
								$img->resize($paramImg);
								echo '<p>' . $img->imgTag . '</p>';
								$img->resize($paramThumbnail);
								echo '<p>' . $img->imgTag . '</p>';
								break;
							case 'thumbnails':
								$img->resize($paramThumbnail);
								echo '<p>' . $img->imgTag . '</p>';
								break;
							case 'resize':
								$img->resize($paramImg);
								echo '<p>' . $img->imgTag . '</p>';
								break;
						}
						$img = null;
					} catch (Exception $e) {
						echo "<p>Ошибка: " . $e->getMessage() . "</p>";
					}
				}
			}
		}

		?>
		</div>
	</div>
</div>


<?php

class ResizeImg
{
	// Properties for constructor
	private $pathToFile;
	private $pathInfo;
	private $source;
	private $sourceWidth;
	private $sourceHeight;
	private $validTypes = ["jpg", "jpeg", "png"];

	// Params for resize
	private $width;
	private $height;
	private $kind;
	private $subFolder;
	private $nameSufix;

	// Some prop
	private $pathToDestinFile;
	private $destinPath;
	private $destinName;

	// For display in browser
	public $imgTag;

	public function __construct($pathToFile)
	{
		$this->pathToFile = $pathToFile;
		$this->pathInfo = pathinfo($this->pathToFile);
		
		if (!in_array(mb_strtolower($this->pathInfo['extension']), $this->validTypes))
		{
			throw new ResizeImgException(ResizeImgErrors::INVALIDFILEEXT,[$this->pathInfo['filename'] . '.' . $this->pathInfo['extension']]);
		}
		if (filesize($pathToFile) > 9 * 1024 * 1024)
		{
			throw new ResizeImgException(ResizeImgErrors::INVALIDFILESIZE,[$this->pathInfo['filename'] . '.' . $this->pathInfo['extension']]);
		}
		if (!list($sourceWidth, $sourceHeight) = getimagesize($pathToFile))
		{
			throw new ResizeImgException(ResizeImgErrors::INVALIDIMGSIZE,[$this->pathInfo['filename'] . '.' . $this->pathInfo['extension']]);
		}
		else
		{
			$this->sourceWidth = $sourceWidth;
			$this->sourceHeight = $sourceHeight;
		}

		switch ($this->pathInfo['extension']) {
			case 'jpeg':
				$this->source = imagecreatefromjpeg($this->pathToFile);
				break;
			case 'jpg':
				$this->source = imagecreatefromjpeg($this->pathToFile);
				break;
			case 'gif':
				$this->source = imagecreatefromgif($this->pathToFile);
				break;
			case 'png':
				$this->source = imagecreatefrompng($this->pathToFile);
				break;
			case 'bmp':
				$this->source = imagecreatefromwbmp($this->pathToFile);
				break;
		}
	}

	public function resize($params)
	{
		foreach ($params as $var => $value)
		{
			$this->{'set'.ucfirst($var)}($value);
		}

		if ($this->subFolder) {
			$this->destinPath = $this->pathInfo['dirname'] . DIRECTORY_SEPARATOR . 'resize-img';
			if (!is_dir($this->destinPath))
				if (!mkdir($this->destinPath))
					throw new ResizeImgException(ResizeImgErrors::INVALIDSUBFOLDER,[$this->destinPath]);
		} 
		else {
			$this->destinPath = $this->pathInfo['dirname'];
		}

		if ($this->nameSufix) {
			$this->destinName = self::translit($this->pathInfo['filename']).'-thumbnail';
		}else{
			$this->destinName = self::translit($this->pathInfo['filename']);
		}

		$this->pathToDestinFile = $this->destinPath . DIRECTORY_SEPARATOR . $this->destinName . '.jpg';

		if (!imagejpeg($this->sourceToDestination(), $this->pathToDestinFile, 100))
		{
			throw new ResizeImgException(ResizeImgErrors::INVALIDSAVE);
		}
		$this->returnImgTag();
		return $this;
	}

	public function __call($method_name, $argument)
	{
		$args = preg_split('/(?<=\w)(?=[A-Z])/', $method_name);
		$action = array_shift($args);
		$property_name = strtolower(implode('_', $args));
 
		switch ($action)
		{
			case 'get':
				return isset($this->$property_name) ? $this->$property_name : null;
 
			case 'set':
				$this->$property_name = $argument[0];
				return $this;
		}
	}

	public function setHeight($value)
	{
		if (is_int((int)$value)&&($value>10)&&($value<2000))
		{
			$this->height = $value;
		}
		else
		{
			throw new ResizeImgException(ResizeImgErrors::INVALIDSIZE);
		}
	}

	public function setWidth($value)
	{
		if (is_int((int)$value)&&($value>10)&&($value<2000))
		{
			$this->width = $value;
		}
		else
		{
			throw new ResizeImgException(ResizeImgErrors::INVALIDSIZE);
		}
	}

	public function setKind($value)
	{
		if (is_string($value)&&in_array($value, ['cover','contain'])) {
			$this->kind = $value;
		}
		else
		{
			throw new ResizeImgException(ResizeImgErrors::INVALIDTYPE);
		}
	}

	public function setNameSufix($value)
	{
		if (is_bool($value))
		{
			$this->nameSufix = $value;
		}
		else
		{
			throw new ResizeImgException(ResizeImgErrors::INVALIDNAMESUFIX);
		}
	}

	public function setSubFolder($value)
	{
		if (is_bool($value))
		{
			$this->subFolder = $value;
		}
		else
		{
			throw new ResizeImgException(ResizeImgErrors::INVALIDTYPEPATH);
		}
	}

	public function sourceToDestination()
	{
		$source_ratio = $this->sourceWidth / $this->sourceHeight;
		$destination_ratio = $this->width / $this->height;
		
		$frame_width = $this->sourceWidth;
		$frame_height = $this->sourceHeight;
		$frame_x = $frame_y = 0;

		switch ($this->kind) {
			case 'cover':
				if ($source_ratio > $destination_ratio) {
					$frame_width = floor($this->width * $this->sourceHeight / $this->height);
					$frame_x = floor($this->sourceWidth / 2 - $frame_width / 2);
				} 
				else {
					$frame_height = floor($this->height * $this->sourceWidth / $this->width);
					$frame_y = floor($this->sourceHeight / 2 - $frame_height / 2);
				}
				break;

			case 'contain':
				if ($source_ratio > $destination_ratio) {
					$this->height = floor($this->sourceHeight * $this->width / $this->sourceWidth);
				} 
				else {
					$this->width = floor($this->sourceWidth * $this->height / $this->sourceHeight);
				}
				break;
		}
		
		$destination = imagecreatetruecolor($this->width, $this->height);
		imagefill($destination, 0, 0, imagecolorallocate($destination, 255, 255, 255));
		imagecopyresampled($destination, $this->source, 0, 0, $frame_x, $frame_y, $this->width, $this->height, $frame_width, $frame_height);
		return $destination;
	}

	public function returnImgTag()
	{
		$path = $this->destinPath.DIRECTORY_SEPARATOR;
		if (DIRECTORY_SEPARATOR=='\\') {
			$path = str_replace('\\','/',$path);
			$path = substr($path,strlen($_SERVER['DOCUMENT_ROOT']));
		}
		$this->imgTag = sprintf('<img src="%1$s%2$s%3$s">', $path, $this->destinName, '.jpg');
	}

	public static function translit($text) {
		if (DIRECTORY_SEPARATOR == '\\') {
			$text = iconv('windows-1251', 'UTF-8', $text);
		}
		$text = mb_strtolower($text, 'UTF-8');
		$replace = array(
			"а" => "a", "б" => "b", "в" => "v", "г" => "g", "д" => "d", "е" => "e", "ё" => "e", "ж" => "j", "з" => "z", "и" => "i", 
			"й" => "y", "к" => "k", "л" => "l", "м" => "m", "н" => "n", "о" => "o", "п" => "p", "р" => "r", "с" => "s", "т" => "t", 
			"у" => "u", "ф" => "f", "х" => "h", "ц" => "c", "ч" => "ch", "ш" => "sh", "щ" => "sch", "ъ" => "", "ы" => "y", "ь" => "", 
			"э" => "e", "ю" => "yu", "я" => "ya", 
			" " => "-"
		);
		$text = strtr($text, $replace);
		$text = preg_replace('/[^a-z0-9_-]/', '', $text);
		$text = preg_replace('/[-]{2,}/', '-', $text);
		$text = preg_replace('/[_]{2,}/', '_', $text);
		$text = trim($text, '-_');
		return $text;
	}
}


class ResizeImgErrors
{
	const INVALIDNAMESUFIX = 1001;
	const INVALIDSIZE = 1002;
	const INVALIDTYPE = 1003;
	const INVALIDTYPEPATH = 1004;
	const INVALIDFILEEXT = 1005;
	const INVALIDFILESIZE = 1006;
	const INVALIDIMGSIZE = 1007;
	const INVALIDSUBFOLDER = 1008;
	const INVALIDSAVE = 1009;

	public static function getErrorMessage($code, $options = []) {
		switch ($code) {

			case self::INVALIDNAMESUFIX:
				return 'The parameter is incorrect for the property nameSufix.';
				break;

			case self::INVALIDSIZE:
				return 'All measurements should be in the range 10 < … < 2000.';
				break;

			case self::INVALIDTYPE:
				return 'Unable to determine the kind of resizing.';
				break;

			case self::INVALIDTYPEPATH:
				return 'Unable to determine the desired folder.';
				break;

			case self::INVALIDFILEEXT:
				return sprintf("Unfavourable extension of file %s.", $options[0]);
				break;

			case self::INVALIDFILESIZE:
				return sprintf("Large file size %s.", $options[0]);
				break;

			case self::INVALIDIMGSIZE:
				return sprintf("Do not define the size of the image %s.", $options[0]);
				break;

			case self::INVALIDSUBFOLDER:
				return sprintf("Unable to create subdirectory %s.", $options[0]);
				break;

			case self::INVALIDSAVE:
				return sprintf("Unable to save image.");
				break;

			case self::UNEXPECTEDERROR:
			default:
				return 'Unknown error!';
				break;
		}
	}
}


class ResizeImgException extends Exception
{
	public function __construct($error_code)
	{
		parent::__construct(ResizeImgErrors::getErrorMessage($error_code), $error_code);
	}
}

?>

		<!-- jQuery -->
		<script src="//code.jquery.com/jquery.js"></script>
		<!-- Bootstrap JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
		<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
		<script src="Hello World"></script>
	</body>
</html>
