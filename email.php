<?php
$string = file_get_contents("test-emails.txt");

function getEmailsByString($string) {
  $pattern = '/[a-z0-9_\-\+\.]+@[a-z0-9\-]+\.([a-z]+)(?:\.[a-z]{2})?/i';
  preg_match_all($pattern, $string, $matches);
  return array_unique($matches[0]);
}

$result = getEmailsByString($string);
$sample = 10000;
$found = count($result);
$pourcent = $found*100/$sample;
echo '<h1>Email found : '.count($result).'</h1>';
echo '<h2>Samples : '.$sample.'</h2>';
echo '<h2>'.$pourcent.'%</h2>';
foreach ($result as $key => $value) {
  echo "------     ".$value;
  echo '</br>';
};
