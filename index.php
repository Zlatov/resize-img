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

?>

		<!-- jQuery -->
		<script src="//code.jquery.com/jquery.js"></script>
		<!-- Bootstrap JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
		<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
		<script src="Hello World"></script>
	</body>
</html>
