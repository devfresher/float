<?php
$a = [1, 2, 3, 4, 5, 6];
$b = $a;

unset($a[4]);

print_r($a);

print_r($b);

?>