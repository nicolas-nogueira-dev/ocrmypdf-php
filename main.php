<?php
require __DIR__.'/vendor/autoload.php';
use Spatie\PdfToText\Pdf;

function getEmailsByString($string) {
  $pattern = '/[a-z0-9_\-\+\.]+@[a-z0-9\-]+\.([a-z]+)(?:\.[a-z]{2})?/i';
  preg_match_all($pattern, $string, $matches);
  return array_unique($matches[0]);
}

function getUrlsByString($string) {
  $pattern = '/((https?):\/\/)?[-a-zA-Z0-9:%._\+~#]{1,256}\.[a-zA-Z0-9()]{1,6}\b([-a-zA-Z0-9():%_\+.~#?&=]*)/i';
  preg_match_all($pattern, $string, $matches);
  return array_unique($matches[0]);
}

function getPhonesNumbersByString($string) {
  $pattern1 = '/((?:\+|00)[17](?: |\-)?|(?:\+|00)[1-9]\d{0,2}(?: |\-)?|(?:\+|00)1\-\d{3}(?: |\-)?)?(0\d|\([0-9]{3}\)|[1-9]{0,3})(?:((?: |\-)[0-9]{2}){4}|((?:[0-9]{2}){4})|((?: |\-)[0-9]{3}(?: |\-)[0-9]{4})|([0-9]{7}))/i';
  preg_match_all($pattern1, $string, $search1);
  return array_unique($search1[0]);
};

$fileUrl = 'pdf/cv-facebook.pdf';

$pdfString = (new Pdf('C:/poppler-0.68.0/bin/pdftotext.exe'))
    ->setPdf($fileUrl)
    ->text();


if ($pdfString === '') {
  echo 'run ocrmypdf </br>';
  $tempImage = sys_get_temp_dir().'\tempFile.pdf';
  var_dump($tempImage);
  if (copy($fileUrl, $tempImage)) {
    echo "$fileUrl --> $tempImage done </br>";
  } else {
    echo "$fileUrl --> $tempImage failed </br>";
  }
  //copy($fileUrl, $tempImage);
  exec('ocrmypdf C:\WINDOWS\TEMP\tempFile.pdf C:\WINDOWS\TEMP\processedTempFile.pdf', $output, $result_code);

  //exec('ocrmypdf '.$tempImage.' '.sys_get_temp_dir().'\processedTempFile.pdf', $output, $result_code);
  $pdfString = (new Pdf('C:/poppler-0.68.0/bin/pdftotext.exe'))
      ->setPdf(sys_get_temp_dir().'\processedTempFile.pdf')
      ->text();
  echo "removing files... </br>";
  unlink(sys_get_temp_dir().'\processedTempFile.pdf');
  unlink($tempImage);
};

$data = array('emails' => getEmailsByString($pdfString),
              'urls' => getUrlsByString($pdfString),
              'phones' => getPhonesNumbersByString($pdfString),
              );
var_dump($data);
echo($pdfString);
