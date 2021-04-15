<?php

$result = exec('ocrmypdf C:\WINDOWS\TEMP\tempFile.pdf C:\WINDOWS\TEMP\processedTempFile.pdf');
var_dump($result);
