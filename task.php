<?php
/**
 * @author Yurii Savka <yurii.savka@lendico.de>
 * @created 08/02/16 12:14
 */

function __autoload($class_name)
{
    include $class_name.'.php';
}

$fileName = @$argv[1] ?: 'learn_and_teach.in';
$zone = new PaintZone();
$zone->read($fileName);
$painter = new Painter($zone);
$painter->work();
