<?php
require __DIR__.'/vendor/autoload.php';
use Spatie\PdfToText\Pdf;
//use thiagoalessio\TesseractOCR\TesseractOCR;

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
  $pattern1 = '/((?:\+|00)[17](?: |\-)?|(?:\+|00)[1-9]\d{0,2}(?: |\-)?|(?:\+|00)1\-\d{3}(?: |\-)?)?(0\d|\([0-9]{3}\)|[1-9]{0,3})(?:((?: |\-)[0-9]{2}){4}|((?:[0-9]{2}){4})|((?: |\-)[0-9]{3}(?: |\-)[0-9]{4})|([0-9]{7}))/i';
  preg_match_all($pattern1, $string, $search1);
  return array_unique($search1[0]);
};

//$fileUrl = 'https://mmedia-storage-bucket.s3.eu-west-3.amazonaws.com/files/14/bFq3WpqKn6NCEoBWN9zJLa2V0zi5Ev9ozMa9Ejyk.pdf';
$fileUrl = 'pdf/testImage.pdf';

$pdfString = (new Pdf('C:/poppler-0.68.0/bin/pdftotext.exe'))
    ->setPdf($fileUrl)
    ->text();

if ($pdfString === '') {
  $tempImage = sys_get_temp_dir().'\tempFile.pdf';
  copy($fileUrl, $tempImage);
  exec('ocrmypdf '.$tempImage.' '.sys_get_temp_dir().'\processedTempFile.pdf', $output, $result_code);
  $pdfString = (new Pdf('C:/poppler-0.68.0/bin/pdftotext.exe'))
      ->setPdf(sys_get_temp_dir().'\processedTempFile.pdf')
      ->text();
};

echo "</br>";
if (!unlink($tempImage)) {
    echo ("$tempImage cannot be deleted due to an error");
}
else {
  echo ("$tempImage has been deleted");
};
echo "</br>";
if (!unlink(sys_get_temp_dir().'\processedTempFile.pdf')) {
    echo ("ProcessedTempFile cannot be deleted due to an error");
}
else {
  echo ("ProcessedTempFile has been deleted");
};
echo "</br>";
echo($pdfString);

$data = array('emails' => getEmailsByString($pdfString),
              'urls' => getUrlsByString($pdfString),
              'phones' => getPhonesNumbersByString($pdfString),
              );

var_dump($data);



/*
$pdfString = (new TesseractOCR("imageOutputTemp2.png"))
//->imageData($data, $size)
->executable('C:\ProgramData\chocolatey\lib\capture2text\tools\Capture2Text\Utils\tesseract\tesseract.exe')
->allowlist(range('A', 'z'), range('À', 'ú'), range(0, 9), '-_@.:/')// A-zÀ-ú
->lang('eng', 'fra')
->run();
*/
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
