<?php

require_once('autoload.php');

use \Brainhp\Core as BCore;

$string = '> ---------- - ------------- ---------------- 
----------------------- ------ 
- -------------------------- 
---------------- 
---------------------- 
<';

echo BCore::parse($string) -> execute() -> response();