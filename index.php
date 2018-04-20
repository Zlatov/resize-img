
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
