<?php
require_once '../../model/shortobject.php';
function find($id){
    $status = new status();
    return $status->find($id);
}
function search($terms){
    $status = new status();
    $status->set(''. 'name');
    if(isset($terms)) $status->set($terms, 'name');
    $statuses = $status->search();
    return $statuses;
}
function statusget($status,$attribute){
    $value = $status->get($attribute);
    if(isset($value)) return $value;
    else return false;
}
function statusset($status,$value, $attribute){
    echo $status->$set($value, $attribute);
}
?>