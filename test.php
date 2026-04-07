<?php
$str = file_get_contents('/home/polyhp7/opti-learning/resources/views/components/navbar.blade.php');
if(strpos($str, '<form method="POST"') !== false) {
    echo "Form exists in navbar.\n";
} else {
    echo "Form NOT found!\n";
}
