<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Resize img</title>
	<link rel="stylesheet" media="screen" href="//netdna.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
	<script src="//code.jquery.com/jquery.js"></script>
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
</head>
<body>







<div class="container">
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<h1>Resize img</h1>
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
</div>


<?php

echo "<pre>";
print_r($_POST);
echo "</pre>";







/*


$toResizeImg = false;
$resizeImg = true;

// contain - содержит все изображение в заданных рамках
// cover - заполняет указанные рамки обрезая лишнее
$resizeType = 'contain';
$imgWidth = 1280;
$imgHeight = 720;
$createThumbnail = true;

// contain - содержит все изображение в заданных рамках
// cover - заполняет указанные рамки обрезая лишнее
$resizeThumbnailType = 'cover';
$thumbnailWidth = 250;
$thumbnailHeight = 250;

$lightbox = '';

$getcwd = getcwd();
$path = $getcwd;
$dir = opendir($path);
chdir($path);
while ($f = readdir($dir)) {
	if (is_file($f) && ($f !== ".") && ($f !== "..")) {
		$r1 = $r2 = $path . DIRECTORY_SEPARATOR . $f;
		if ($resizeImg) {
			echo 'Преобразуемое изображение: ' . $path . DIRECTORY_SEPARATOR . $f;
			echo '<br>';
			$return = transformImg(
				$path . DIRECTORY_SEPARATOR . $f, 
				$imgWidth, 
				$imgHeight, 
				$resizeType, 
				false, 
				$toResizeImg
			);
			if (!is_array($return)) {
				echo 'Ошибка! ' . $return;
				echo '<br>';
			} 
			else {
				$r1 = $return[0];
				echo 'Success transform.';
				echo '<br>';
			}
			echo '<br>';
		}
		if ($createThumbnail) {
			echo 'Изображение для миниатюры: ' . $path . DIRECTORY_SEPARATOR . $f;
			echo '<br>';
			$return = transformImg(
				$path . DIRECTORY_SEPARATOR . $f, 
				$thumbnailWidth, 
				$thumbnailHeight, 
				$resizeThumbnailType, 
				true, 
				$toResizeImg
			);
			if (!is_array($return)) {
				echo 'Ошибка! ' . $return;
				echo '<br>';
			} 
			else {
				$r2 = $return[0];
				echo 'Успешное создание миниатюры.';
				echo '<br>';
			}
			echo '<br>';
		}
		if (DIRECTORY_SEPARATOR=='\\') {
			$r1 = str_replace('\\','/',$r1);
			$r1 = substr($r1,strlen($_SERVER['DOCUMENT_ROOT']));
			$r2 = str_replace('\\','/',$r2);
			$r2 = substr($r2,strlen($_SERVER['DOCUMENT_ROOT']));
		}
		$lightbox .= "&lt;a href=\"".$r1."\" data-lightbox=\"lightbox\">&lt;img src=\"".$r2."\">&lt;/a>\n";
	}
}
closedir($dir);

echo '<pre>';
echo $lightbox;
echo '</pre>';



*/

class ClassName
{
	
	function __construct(argument)
	{
		# code...
	}
}

function transformImg(
	$pathToFile,
	$destination_width,
	$destination_height,
	$resizeType = 'cover',
	$createThumbnailname = false,
	$toResizeImg = true
) 
{
	$pathinfo = pathinfo($pathToFile);
	$valid_types = array("jpg", "jpeg", "png");
	if (!in_array($pathinfo['extension'], $valid_types)) return sprintf("Неподходящее разрешение файла %s", $pathinfo['filename'] . '.' . $pathinfo['extension']);
	if (filesize($pathToFile) > 9 * 1024 * 1024) return sprintf("Слишком большой размер файла %s", $pathinfo['filename'] . '.' . $pathinfo['extension']);
	if (!list($source_width, $source_height) = getimagesize($pathToFile)) return sprintf("Не получилось определить размеры изображения %s", $pathinfo['filename'] . '.' . $pathinfo['extension']);
	
	// Источник
	switch ($pathinfo['extension']) {
		case 'jpeg':
			$source = imagecreatefromjpeg($pathToFile);
			break;

		case 'jpg':
			$source = imagecreatefromjpeg($pathToFile);
			break;

		case 'gif':
			$source = imagecreatefromgif($pathToFile);
			break;

		case 'png':
			$source = imagecreatefrompng($pathToFile);
			break;

		case 'bmp':
			$source = imagecreatefromwbmp($pathToFile);
			break;
	}
	
	// Соотношения
	$destination_ratio = $destination_width / $destination_height;
	$source_ratio = $source_width / $source_height;
	
	// Область копирования
	$frame_width = $source_width;
	$frame_height = $source_height;
	$frame_x = $frame_y = 0;
	
	switch ($resizeType) {
		case 'cover':
			
			// Расчёт области копирования
			if ($source_ratio > $destination_ratio) {
				$frame_width = floor($destination_width * $source_height / $destination_height);
				$frame_x = floor($source_width / 2 - $frame_width / 2);
			} 
			else {
				$frame_height = floor($destination_height * $source_width / $destination_width);
				$frame_y = floor($source_height / 2 - $frame_height / 2);
			}
			break;

		case 'contain':
			
			// Расчёт назначения
			if ($source_ratio > $destination_ratio) {
				$destination_height = floor($source_height * $destination_width / $source_width);
			} 
			else {
				$destination_width = floor($source_width * $destination_height / $source_height);
			}
			break;
	}
	
	$destination = imagecreatetruecolor($destination_width, $destination_height);
	
	// Создаём назначение
	imagefill($destination, 0, 0, imagecolorallocate($destination, 255, 255, 255));
	
	// Закрашиваем назначение белым
	imagecopyresampled($destination, $source, 0, 0, $frame_x, $frame_y, $destination_width, $destination_height, $frame_width, $frame_height);
	
	// Копируем с ресайзом
	$name = translit($pathinfo['filename']);
	if ($createThumbnailname) {
		$name = $name . '-thumbnail';
	}
	if ($toResizeImg) {
		$to = $pathinfo['dirname'] . DIRECTORY_SEPARATOR . 'resize-img';
		if (!is_dir($to)) if (!mkdir($to)) return sprintf('Не удалось создать директорию %s', $to);
		$to = $to . DIRECTORY_SEPARATOR . $name . '.jpg';
	} 
	else {
		$to = $pathinfo['dirname'] . DIRECTORY_SEPARATOR . $name . '.jpg';
	}
	if (!imagejpeg($destination, $to, 100)) return sprintf("Что-то не так при сохранении");
	imagedestroy($destination);
	imagedestroy($source);
	$return = array($to);

	return $return;
}

// Транслитерация ГОСТ 7.79-2000 (Б) с отступлениями
function translit($text) {
	if (DIRECTORY_SEPARATOR == '\\') {
		$text = iconv('windows-1251', 'UTF-8', $text);
	}
	$text = mb_strtolower($text, 'UTF-8');
	$replace = array("а" => "a", "б" => "b", "в" => "v", "г" => "g", "д" => "d", "е" => "e", "ё" => "e", "ж" => "j", "з" => "z", "и" => "i", "й" => "y", "к" => "k", "л" => "l", "м" => "m", "н" => "n", "о" => "o", "п" => "p", "р" => "r", "с" => "s", "т" => "t", "у" => "u", "ф" => "f", "х" => "h", "ц" => "c", "ч" => "ch", "ш" => "sh", "щ" => "sch", "ъ" => "", "ы" => "y", "ь" => "", "э" => "e", "ю" => "yu", "я" => "ya", " " => "-");
	$text = strtr($text, $replace);
	$text = preg_replace('/[^a-z0-9_-]/', '', $text);
	$text = preg_replace('/[-]{2,}/', '-', $text);
	$text = preg_replace('/[_]{2,}/', '_', $text);
	$text = trim($text, '-_');
	return $text;
}
?>


	
</body>
</html>
