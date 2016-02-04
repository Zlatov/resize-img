<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Resize img</title>
	<link rel="stylesheet" media="screen" href="//netdna.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
	<script src="//code.jquery.com/jquery.js"></script>
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
	<script>
		!function(a,b){"function"==typeof define&&define.amd?define(["jquery"],b):"object"==typeof exports?module.exports=b(require("jquery")):a.lightbox=b(a.jQuery)}(this,function(a){function b(b){this.album=[],this.currentImageIndex=void 0,this.init(),this.options=a.extend({},this.constructor.defaults),this.option(b)}return b.defaults={albumLabel:"Image %1 of %2",alwaysShowNavOnTouchDevices:!1,fadeDuration:500,fitImagesInViewport:!0,positionFromTop:50,resizeDuration:700,showImageNumberLabel:!0,wrapAround:!1,disableScrolling:!1},b.prototype.option=function(b){a.extend(this.options,b)},b.prototype.imageCountLabel=function(a,b){return this.options.albumLabel.replace(/%1/g,a).replace(/%2/g,b)},b.prototype.init=function(){this.enable(),this.build()},b.prototype.enable=function(){var b=this;a("body").on("click","a[rel^=lightbox], area[rel^=lightbox], a[data-lightbox], area[data-lightbox]",function(c){return b.start(a(c.currentTarget)),!1})},b.prototype.build=function(){var b=this;a('<div id="lightboxOverlay" class="lightboxOverlay"></div><div id="lightbox" class="lightbox"><div class="lb-outerContainer"><div class="lb-container"><img class="lb-image" src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==" /><div class="lb-nav"><a class="lb-prev" href="" ></a><a class="lb-next" href="" ></a></div><div class="lb-loader"><a class="lb-cancel"></a></div></div></div><div class="lb-dataContainer"><div class="lb-data"><div class="lb-details"><span class="lb-caption"></span><span class="lb-number"></span></div><div class="lb-closeContainer"><a class="lb-close"></a></div></div></div></div>').appendTo(a("body")),this.$lightbox=a("#lightbox"),this.$overlay=a("#lightboxOverlay"),this.$outerContainer=this.$lightbox.find(".lb-outerContainer"),this.$container=this.$lightbox.find(".lb-container"),this.containerTopPadding=parseInt(this.$container.css("padding-top"),10),this.containerRightPadding=parseInt(this.$container.css("padding-right"),10),this.containerBottomPadding=parseInt(this.$container.css("padding-bottom"),10),this.containerLeftPadding=parseInt(this.$container.css("padding-left"),10),this.$overlay.hide().on("click",function(){return b.end(),!1}),this.$lightbox.hide().on("click",function(c){return"lightbox"===a(c.target).attr("id")&&b.end(),!1}),this.$outerContainer.on("click",function(c){return"lightbox"===a(c.target).attr("id")&&b.end(),!1}),this.$lightbox.find(".lb-prev").on("click",function(){return 0===b.currentImageIndex?b.changeImage(b.album.length-1):b.changeImage(b.currentImageIndex-1),!1}),this.$lightbox.find(".lb-next").on("click",function(){return b.currentImageIndex===b.album.length-1?b.changeImage(0):b.changeImage(b.currentImageIndex+1),!1}),this.$lightbox.find(".lb-loader, .lb-close").on("click",function(){return b.end(),!1})},b.prototype.start=function(b){function c(a){d.album.push({link:a.attr("href"),title:a.attr("data-title")||a.attr("title")})}var d=this,e=a(window);e.on("resize",a.proxy(this.sizeOverlay,this)),a("select, object, embed").css({visibility:"hidden"}),this.sizeOverlay(),this.album=[];var f,g=0,h=b.attr("data-lightbox");if(h){f=a(b.prop("tagName")+'[data-lightbox="'+h+'"]');for(var i=0;i<f.length;i=++i)c(a(f[i])),f[i]===b[0]&&(g=i)}else if("lightbox"===b.attr("rel"))c(b);else{f=a(b.prop("tagName")+'[rel="'+b.attr("rel")+'"]');for(var j=0;j<f.length;j=++j)c(a(f[j])),f[j]===b[0]&&(g=j)}var k=e.scrollTop()+this.options.positionFromTop,l=e.scrollLeft();this.$lightbox.css({top:k+"px",left:l+"px"}).fadeIn(this.options.fadeDuration),this.options.disableScrolling&&a("body").addClass("lb-disable-scrolling"),this.changeImage(g)},b.prototype.changeImage=function(b){var c=this;this.disableKeyboardNav();var d=this.$lightbox.find(".lb-image");this.$overlay.fadeIn(this.options.fadeDuration),a(".lb-loader").fadeIn("slow"),this.$lightbox.find(".lb-image, .lb-nav, .lb-prev, .lb-next, .lb-dataContainer, .lb-numbers, .lb-caption").hide(),this.$outerContainer.addClass("animating");var e=new Image;e.onload=function(){var f,g,h,i,j,k,l;d.attr("src",c.album[b].link),f=a(e),d.width(e.width),d.height(e.height),c.options.fitImagesInViewport&&(l=a(window).width(),k=a(window).height(),j=l-c.containerLeftPadding-c.containerRightPadding-20,i=k-c.containerTopPadding-c.containerBottomPadding-120,c.options.maxWidth&&c.options.maxWidth<j&&(j=c.options.maxWidth),c.options.maxHeight&&c.options.maxHeight<j&&(i=c.options.maxHeight),(e.width>j||e.height>i)&&(e.width/j>e.height/i?(h=j,g=parseInt(e.height/(e.width/h),10),d.width(h),d.height(g)):(g=i,h=parseInt(e.width/(e.height/g),10),d.width(h),d.height(g)))),c.sizeContainer(d.width(),d.height())},e.src=this.album[b].link,this.currentImageIndex=b},b.prototype.sizeOverlay=function(){this.$overlay.width(a(document).width()).height(a(document).height())},b.prototype.sizeContainer=function(a,b){function c(){d.$lightbox.find(".lb-dataContainer").width(g),d.$lightbox.find(".lb-prevLink").height(h),d.$lightbox.find(".lb-nextLink").height(h),d.showImage()}var d=this,e=this.$outerContainer.outerWidth(),f=this.$outerContainer.outerHeight(),g=a+this.containerLeftPadding+this.containerRightPadding,h=b+this.containerTopPadding+this.containerBottomPadding;e!==g||f!==h?this.$outerContainer.animate({width:g,height:h},this.options.resizeDuration,"swing",function(){c()}):c()},b.prototype.showImage=function(){this.$lightbox.find(".lb-loader").stop(!0).hide(),this.$lightbox.find(".lb-image").fadeIn("slow"),this.updateNav(),this.updateDetails(),this.preloadNeighboringImages(),this.enableKeyboardNav()},b.prototype.updateNav=function(){var a=!1;try{document.createEvent("TouchEvent"),a=this.options.alwaysShowNavOnTouchDevices?!0:!1}catch(b){}this.$lightbox.find(".lb-nav").show(),this.album.length>1&&(this.options.wrapAround?(a&&this.$lightbox.find(".lb-prev, .lb-next").css("opacity","1"),this.$lightbox.find(".lb-prev, .lb-next").show()):(this.currentImageIndex>0&&(this.$lightbox.find(".lb-prev").show(),a&&this.$lightbox.find(".lb-prev").css("opacity","1")),this.currentImageIndex<this.album.length-1&&(this.$lightbox.find(".lb-next").show(),a&&this.$lightbox.find(".lb-next").css("opacity","1"))))},b.prototype.updateDetails=function(){var b=this;if("undefined"!=typeof this.album[this.currentImageIndex].title&&""!==this.album[this.currentImageIndex].title&&this.$lightbox.find(".lb-caption").html(this.album[this.currentImageIndex].title).fadeIn("fast").find("a").on("click",function(b){void 0!==a(this).attr("target")?window.open(a(this).attr("href"),a(this).attr("target")):location.href=a(this).attr("href")}),this.album.length>1&&this.options.showImageNumberLabel){var c=this.imageCountLabel(this.currentImageIndex+1,this.album.length);this.$lightbox.find(".lb-number").text(c).fadeIn("fast")}else this.$lightbox.find(".lb-number").hide();this.$outerContainer.removeClass("animating"),this.$lightbox.find(".lb-dataContainer").fadeIn(this.options.resizeDuration,function(){return b.sizeOverlay()})},b.prototype.preloadNeighboringImages=function(){if(this.album.length>this.currentImageIndex+1){var a=new Image;a.src=this.album[this.currentImageIndex+1].link}if(this.currentImageIndex>0){var b=new Image;b.src=this.album[this.currentImageIndex-1].link}},b.prototype.enableKeyboardNav=function(){a(document).on("keyup.keyboard",a.proxy(this.keyboardAction,this))},b.prototype.disableKeyboardNav=function(){a(document).off(".keyboard")},b.prototype.keyboardAction=function(a){var b=27,c=37,d=39,e=a.keyCode,f=String.fromCharCode(e).toLowerCase();e===b||f.match(/x|o|c/)?this.end():"p"===f||e===c?0!==this.currentImageIndex?this.changeImage(this.currentImageIndex-1):this.options.wrapAround&&this.album.length>1&&this.changeImage(this.album.length-1):("n"===f||e===d)&&(this.currentImageIndex!==this.album.length-1?this.changeImage(this.currentImageIndex+1):this.options.wrapAround&&this.album.length>1&&this.changeImage(0))},b.prototype.end=function(){this.disableKeyboardNav(),a(window).off("resize",this.sizeOverlay),this.$lightbox.fadeOut(this.options.fadeDuration),this.$overlay.fadeOut(this.options.fadeDuration),a("select, object, embed").css({visibility:"visible"}),this.options.disableScrolling&&a("body").removeClass("lb-disable-scrolling")},new b});
	</script>
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
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<?php

		if (isset($_POST)&&!empty($_POST)) {
			$path = __DIR__;
			$dir = opendir($path);
			chdir($path);
			while ($f = readdir($dir))
			{
				if (is_file($f) && ($f !== ".") && ($f !== "..") && in_array(mb_strtolower(pathinfo($f)['extension']), ['png','jpg','jpeg']))
				{
					$pathToFile = $path . DIRECTORY_SEPARATOR . $f;
					try {
						$img = new ResizeImg($pathToFile);
						echo $img->resize();
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
	private $do = 'resizeandthumbnails';
	private $img = false;
	private $thu = false;
	private $imgwidth = 800;
	private $imgheight = 600;
	private $imgtype = 'contain';
	private $thumbnailwidth = 250;
	private $thumbnailheight = 250;
	private $thumbnailtype = 'cover';
	private $subfolder = false;

	private $validtypes = ["jpg", "jpeg", "png"];

	private $path_to_file;
	private $source_width;
	private $source_height;

	public $to;

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

	public function setDo($value)
	{
		if (is_string($value)&&in_array($value, ['resize','thumbnails','resizeandthumbnails']))
		{
			$this->do = $value;
			switch ($value) {
				case 'resizeandthumbnails':
					$this->img = true;
					$this->thu = true;
					break;
				case 'thumbnails':
					$this->thu = true;
					break;
				case 'resize':
					$this->img = true;
					break;
			}
		}
		else
		{
			throw new ResizeImgException(ResizeImgErrors::INVALIDDO);
		}
	}

	public function setThumbnailheight($value)
	{
		if (is_int((int)$value)&&($value>10)&&($value<2000))
		{
			$this->thumbnailheight = $value;
		}
		else
		{
			throw new ResizeImgException(ResizeImgErrors::INVALIDSIZE);
		}
	}

	public function setThumbnailwidth($value)
	{
		if (is_int((int)$value)&&($value>10)&&($value<2000))
		{
			$this->thumbnailwidth = $value;
		}
		else
		{
			throw new ResizeImgException(ResizeImgErrors::INVALIDSIZE);
		}
	}

	public function setImgheight($value)
	{
		if (is_int((int)$value)&&($value>10)&&($value<2000))
		{
			$this->imgheight = $value;
		}
		else
		{
			throw new ResizeImgException(ResizeImgErrors::INVALIDSIZE);
		}
	}

	public function setImgwidth($value)
	{
		if (is_int((int)$value)&&($value>10)&&($value<2000))
		{
			$this->imgwidth = $value;
		}
		else
		{
			throw new ResizeImgException(ResizeImgErrors::INVALIDSIZE);
		}
	}

	public function setImgtype($value)
	{
		if (is_string($value)&&in_array($value, ['cover','contain'])) {
			$this->imgtype = $value;
		}
		else
		{
			throw new ResizeImgException(ResizeImgErrors::INVALIDTYPE);
		}
	}

	public function setSubfolder($value)
	{
		if (is_null($value) || (is_string($value) && ($value==='true')))
		{
			$this->subfolder = (is_null($value))?false:true;
		}
		else
		{
			throw new ResizeImgException(ResizeImgErrors::INVALIDTYPEPATH);
		}
	}

	public function __construct($pathToFile)
	{
		foreach ($_POST as $var => $value)
		{
			$this->{'set'.ucfirst($var)}($value);
		}

		$this->path_to_file = $pathToFile;

		$pathinfo = pathinfo($this->path_to_file);
		
		if (!in_array(mb_strtolower($pathinfo['extension']), $this->validtypes))
		{
			throw new ResizeImgException(ResizeImgErrors::INVALIDFILEEXT,[$pathinfo['filename'] . '.' . $pathinfo['extension']]);
		}
		if (filesize($pathToFile) > 9 * 1024 * 1024)
		{
			throw new ResizeImgException(ResizeImgErrors::INVALIDFILESIZE,[$pathinfo['filename'] . '.' . $pathinfo['extension']]);
		}
		if (!list($source_width, $source_height) = getimagesize($pathToFile))
		{
			throw new ResizeImgException(ResizeImgErrors::INVALIDIMGSIZE,[$pathinfo['filename'] . '.' . $pathinfo['extension']]);
		}
		else
		{
			$this->source_width = $source_width;
			$this->source_height = $source_height;
		}
		if ($this->subfolder) {
			$this->to = $pathinfo['dirname'] . DIRECTORY_SEPARATOR . 'resize-img';
			if (!is_dir($this->to))
				if (!mkdir($this->to))
					throw new ResizeImgException(ResizeImgErrors::INVALIDSUBFOLDER,[$this->to]);
		} 
		else {
			$this->to = $pathinfo['dirname'];
		}

	}

	public function resize()
	{
		$pathinfo = pathinfo($this->path_to_file);
		$name = self::translit($pathinfo['filename']);

		switch ($pathinfo['extension']) {
			case 'jpeg':
				$source = imagecreatefromjpeg($this->path_to_file);
				break;
			case 'jpg':
				$source = imagecreatefromjpeg($this->path_to_file);
				break;
			case 'gif':
				$source = imagecreatefromgif($this->path_to_file);
				break;
			case 'png':
				$source = imagecreatefrompng($this->path_to_file);
				break;
			case 'bmp':
				$source = imagecreatefromwbmp($this->path_to_file);
				break;
		}
		
		if ($this->img) {
			$destinationimg = $this->sourceToDestination($this->imgwidth,$this->imgheight,$this->imgtype,$source);
			if (!imagejpeg($destinationimg, $this->to. DIRECTORY_SEPARATOR . $name . '.jpg', 100)) {
				throw new ResizeImgException(ResizeImgErrors::INVALIDSAVE);
			}
			imagedestroy($destinationimg);
		}
		if ($this->thu) {
			$destinationthu = $this->sourceToDestination($this->thumbnailwidth,$this->thumbnailheight,$this->thumbnailtype,$source);
			if (!imagejpeg($destinationthu, $this->to. DIRECTORY_SEPARATOR . $name . '-thumbnail' . '.jpg', 100)) {
				throw new ResizeImgException(ResizeImgErrors::INVALIDSAVE);
			}
			imagedestroy($destinationthu);
		}
		imagedestroy($source);
		return $this->returnLink($name);
	}

	public function sourceToDestination($destination_width,$destination_height,$type,$source)
	{
		$source_ratio = $this->source_width / $this->source_height;
		$destination_ratio = $destination_width / $destination_height;
		
		$frame_width = $this->source_width;
		$frame_height = $this->source_height;
		$frame_x = $frame_y = 0;

		switch ($type) {
			case 'cover':
				if ($source_ratio > $destination_ratio) {
					$frame_width = floor($destination_width * $this->source_height / $destination_height);
					$frame_x = floor($this->source_width / 2 - $frame_width / 2);
				} 
				else {
					$frame_height = floor($destination_height * $this->source_width / $destination_width);
					$frame_y = floor($this->source_height / 2 - $frame_height / 2);
				}
				break;

			case 'contain':
				if ($source_ratio > $destination_ratio) {
					$destination_height = floor($this->source_height * $destination_width / $this->source_width);
				} 
				else {
					$destination_width = floor($this->source_width * $destination_height / $this->source_height);
				}
				break;
		}
		
		$destination = imagecreatetruecolor($destination_width, $destination_height);
		imagefill($destination, 0, 0, imagecolorallocate($destination, 255, 255, 255));
		imagecopyresampled($destination, $source, 0, 0, $frame_x, $frame_y, $destination_width, $destination_height, $frame_width, $frame_height);
		return $destination;
	}

	public function returnLink($name)
	{
		$path = $this->to.DIRECTORY_SEPARATOR;
		if (DIRECTORY_SEPARATOR=='\\') {
			$path = str_replace('\\','/',$path);
			$path = substr($path,strlen($_SERVER['DOCUMENT_ROOT']));
		}
		$thumbnail = ($this->thu)?'-thumbnail':'';
		return sprintf('<a href="%1$s%2$s%4$s" data-lightbox="lightbox"><img src="%1$s%2$s%3$s%4$s"></a> ',$path,$name,$thumbnail,'.jpg');
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
	const INVALIDDO = 1001;
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

			case self::INVALIDDO:
				return 'Невозможно определить что делать.';
				break;

			case self::INVALIDSIZE:
				return 'Все размеры должны быть в диапазоне 10 < … < 2000.';
				break;

			case self::INVALIDTYPE:
				return 'Невозможно определить тип изменения размера.';
				break;

			case self::INVALIDTYPEPATH:
				return 'Невозможно определить необходимую папку.';
				break;

			case self::INVALIDFILEEXT:
				return sprintf("Неподходящее разрешение файла %s", $options[0]);
				break;

			case self::INVALIDFILESIZE:
				return sprintf("Слишком большой размер файла %s", $options[0]);
				break;

			case self::INVALIDIMGSIZE:
				return sprintf("Не получилось определить размеры изображения %s", $options[0]);
				break;

			case self::INVALIDSUBFOLDER:
				return sprintf("Не удалось создать директорию %s", $options[0]);
				break;

			case self::INVALIDSAVE:
				return sprintf("Не удалось сохранить изображение");
				break;

			case self::UNEXPECTEDERROR:
			default:
				return 'Какая-то ошибка!';
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


	
</body>
</html>
