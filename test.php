<?php
namespace GlobalIdGenerator;

// use GlobalIdGenerator;

require_once 'GlobalIdGenerator.php';





// var_dump(__namespace__);exit;

$generator = new GlobalIdGenerator(4,2,7,6,3);
$generator->test();
echo '<hr>';
$id = $generator->getGlobalId(2, 1, 3, 6, 'cg');
var_dump($id);
