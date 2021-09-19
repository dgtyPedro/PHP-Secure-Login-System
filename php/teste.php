<?php

$string = '';

if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $string))
{
    echo 'foi achado';
}else{
    echo 'não foi achado';
}