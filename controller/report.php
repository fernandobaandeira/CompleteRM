<?php
require_once '../../model/report.php';
require_once '../../model/lead.php';
require_once '../../model/note.php';
require_once '../../model/deal.php';
require_once '../../model/shortobject.php';
require_once '../../model/operator.php';
require_once '../../model/product.php';
require_once '../fragments/language.php';

function generate($terms){
    $report = false;
    if(empty($terms['periodstart'])) $terms['periodstart'] = date_format(date_modify(date_create(),'-1 month'),'Y-m-d H:i:s');
    if(empty($terms['periodend'])) $terms['periodend'] = date_format(date_create(),'Y-m-d H:i:s');
    switch ($terms['id']) {
        case '1':
            $report = newlead($terms);
            break;
        case '2':
            $report = deals($terms);
            break;
    }
    return $report;
}
function searchattr($terms,$attr){
    $$attr = new $attr();
    $$attr->set("",'name');
    if(isset($terms)) $$attr->set($terms,'name');
    return $$attr->search();
}
function get($object,$attribute){
    $value = $object->get($attribute);
    if(isset($value)) return $value;
    else return false;
}
//break here
function getinfo($data, $info){
    if($info == 'date') return date('d/m/Y', strtotime($data) - timezone_difference());
    if($info == 'time') return date('H:i', strtotime($data) - timezone_difference());
}
?>