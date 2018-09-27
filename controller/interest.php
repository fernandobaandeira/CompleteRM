<?php
require_once '../../model/shortobject.php';
function find($id){
    $interest = new interest();
    return $interest->find($id);
}
function save($terms){
    $interest = new interest();
    $id = $interest->save($terms);
    return $interest->find($id);
}
function update($id, $terms){
    $interest = new interest();
    $interest->set($id,'id');
    $interest->update($terms);
    return $interest->find($id);
}
function deleteinterest($id){
    $interest= new interest();
    $interest->delete($id);
}
function search($terms){
    $interest = new interest();
    $interest->set("",'name');
    if(isset($terms['search'])) $interest->set($terms['search'],'name');
    $interests = $interest->search();
    return $interests;
}
function getinterestedcount($interest){
    return $interest->getinterestedcount();;
}
function getinterested($interest){
    return $interest->getinterested();;
}
function get($interest,$attribute){
    $value = $interest->get($attribute);
    if(isset($value)) return $value;
    else return false;
}
function set($interest,$value, $attribute){
    echo $interest->set($value, $attribute);;
}
function getinfo($data, $info){
    if($info == 'date') return date('d M. Y', strtotime($data) - timezone_difference());
    if($info == 'time') return date('H:i', strtotime($data) - timezone_difference());
}
?>