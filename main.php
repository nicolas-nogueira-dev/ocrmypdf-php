<?php
require __DIR__.'/vendor/autoload.php';
use Spatie\PdfToText\Pdf;
use thiagoalessio\TesseractOCR\TesseractOCR;

function getEmailsByString($string) {
  $pattern = '/[a-z0-9_\-\+\.]+@[a-z0-9\-]+\.([a-z]+)(?:\.[a-z]{2})?/i';
  preg_match_all($pattern, $string, $matches);
  return array_unique($matches[0]);
}

function getUrlsByString($string) {
  $pattern = '/(?:(?:https?|ftp|file):\/\/|www\.|ftp\.)(?:\([-A-Z0-9+&@#\/%=~_|$?!:,.]*\)|[-A-Z0-9+&@#\/%=~_|$?!:,.])*(?:\([-A-Z0-9+&@#\/%=~_|$?!:,.]*\)|[A-Z0-9+&@#\/%=~_|$])/i';
  preg_match_all($pattern, $string, $matches);
  return array_unique($matches[0]);
}

function getPhonesNumbersByString($string) {
  $pattern = '/^[\.-)( ]*([0-9]{3})[\.-)( ]*([0-9]{3})[\.-)( ]*([0-9]{4})$/i';
  preg_match_all($pattern, $string, $matches);
  return array_unique($matches[0]);
}

$fileUrl = 'https://mmedia-storage-bucket.s3.eu-west-3.amazonaws.com/files/14/bFq3WpqKn6NCEoBWN9zJLa2V0zi5Ev9ozMa9Ejyk.pdf';

$pdfString = (new Pdf('C:/poppler-0.68.0/bin/pdftotext.exe'))
    ->setPdf($filename)
    ->text();

if ($pdfString === '') {
  $pathInfo = pathinfo($url);
  $tempImage = tempnam(sys_get_temp_dir(), "tempFile.pdf");
  copy($fileUrl, $tempImage);
  $result = exec('ocrmypdf -l fra+eng+deu /tmp/tempFile.pdf /tmp/processedTempFile.pdf');
  exec('ocrmypdf -l fra+eng $path $pathToSave');
  $command = 'ocrmypdf -l fra+eng '.escapeshellarg($filename).' imageOutputTemp2'.'.png';
  exec($command)
  /*
  $image = new imagick();
  $image->setResolution(600,600);
  $image->readImage(realpath($filename));
  $img_resol = $image->getImageResolution();
  var_dump($img_resol);
  $image->setImageFormat("png");
  //-------Transformation
  //$imageWidth = $image->getImageWidth()*2;
  //$image->resizeImage($imageWidth, 0, \Imagick::FILTER_LANCZOS, 1, false);
  //$image->enhanceImage();
  //$image->autoLevelImage();
  //$image->quantizeImage(2, Imagick::COLORSPACE_GRAY, 1, TRUE, FALSE);
  //$image->sharpenimage(20, 10, true);
  //$image->contrastImage(0);
  //$image->brightnessContrastImage(0, 50);
  //$image->resizeImage($imageWidth/2, 0, \Imagick::FILTER_LANCZOS, 1, false);

  //--------End Transformation
  $image->writeImage(__DIR__."/".'imageOutputTemp2'.'.png');

  //Using Imagick
  $data = $image->getImageBlob();
  $size = $image->getImageLength();
  */
  $pdfString = (new TesseractOCR("imageOutputTemp2.png"))
  //->imageData($data, $size)
  ->executable('C:\ProgramData\chocolatey\lib\capture2text\tools\Capture2Text\Utils\tesseract\tesseract.exe')
  ->allowlist(range('A', 'z'), range('À', 'ú'), range(0, 9), '-_@.:/')// A-zÀ-ú
  ->lang('eng', 'fra')
  ->run();
}



var_dump($pdfString);

$emails = getEmailsByString($pdfString);
echo "Emails found:</br>";
var_dump($emails);
echo "</br>";
$urls = getUrlsByString($pdfString);
echo "Urls found:</br>";
var_dump($urls);
/*
$phones = getPhonesNumbersByString($pdfString);
echo "Phones Number found:</br>";
var_dump($phones);
*/


/*
$pattern = '/[a-z0-9_\-\+\.]+@[a-z0-9\-]+\.([a-z]+)(?:\.[a-z]{2})?/i';
preg_match_all($pattern, $pdfString, $matches);
var_dump(array_unique($matches[0]));
*/
/*
$image = new Imagick();
$image->newImage(1, 1, new ImagickPixel('#ffffff'));
$image->setImageFormat('png');
$pngData = $image->getImagesBlob();
echo strpos($pngData, "\x89PNG\r\n\x1a\n") === 0 ? 'Ok' : 'Failed';
*/
//foreach((new TesseractOCR())->availableLanguages() as $lang) echo $lang.".";
