<?php
$string = file_get_contents("test-phones.txt");

function getPhonesNumbersByString($string) {
  //FR phone number regex
  $pattern1 = '/^(\+33\s[1-9]{8})|(0[1-9]\s{8})$/i';
  preg_match_all($pattern1, $string, $search1);
  //UK phone number regex ^(((\+44\s?\d{4}|\(?0\d{4}\)?)\s?\d{3}\s?\d{3})|((\+44\s?\d{3}|\(?0\d{3}\)?)\s?\d{3}\s?\d{4})|((\+44\s?\d{2}|\(?0\d{2}\)?)\s?\d{4}\s?\d{4}))(\s?\#(\d{4}|\d{3}))?$
  $pattern1 = '//i';
  preg_match_all($pattern1, $string, $search1);

  return array_unique($search1[0], $flags = SORT_STRING);
};

$result = getPhonesNumbersByString($string);
$sample = 1000;
$found = count($result);
$pourcent = $found*100/$sample;
echo '<h1>Phone found : '.count($result).'</h1>';
echo '<h2>Samples : '.$sample.'</h2>';
echo '<h2>'.$pourcent.'%</h2>';
foreach ($result as $key => $value) {
  echo "------     ".$value;
  echo '</br>';
};


//((?:\+|00)[17](?: |\-)?|(?:\+|00)[1-9]\d{0,2}(?: |\-)?|(?:\+|00)1\-\d{3}(?: |\-)?)?(0\d|\([0-9]{3}\)|[1-9]{0,3})(?:((?: |\-)[0-9]{2}){4}|((?:[0-9]{2}){4})|((?: |\-)[0-9]{3}(?: |\-)[0-9]{4})|([0-9]{7}))
