<?php

$command = "-_./a-Z0-9";

$result = exec('ocrmypdf -l fra+eng+deu /tmp/tempFile.pdf /tmp/processedTempFile.pdf');

var_dump($result);
