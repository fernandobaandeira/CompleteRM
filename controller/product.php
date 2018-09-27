<?php
require_once '../../model/product.php';
require_once '../../model/deal.php';
require_once '../../model/lead.php';
require_once '../../model/note.php';
function find($id){
    $product = new product();
    return $product->find($id);
}
function save($terms){
    $product = new product();
    $id = $product->save($terms);
    return $product->find($id);
}
function update($id, $terms){
    $product = new product();
    $product->set($id,'id');
    $product->update($terms);
    return $product->find($id);
}
function deactivateproduct($id){
    $product= new product();
    $product->deactivate($id);
}
function search($terms){
    $product = new product();
    $product->set("",'name');
    if(isset($terms['search'])) $product->set($terms['search'],'name');
    $products = $product->search();
    return $products;
}
function searchattr($terms,$attr){
    $$attr = new $attr();
    $$attr->set("",'name');
    if(isset($terms)) $$attr->set($terms,'name');
    return $$attr->search();
}
function addnote($productid,$notetext){
    $note = new note();
    $noteid = $note->save($notetext);
    $product = new product();
    $product->addnote($productid, $noteid);
}
function findnotesbyproduct($productid){
    $notes = new note();
    return $notes->findbyproduct($productid);
}
function deletenote($noteid){
    $note = new note();
    $note->delete($noteid);
}
function getsoldquantity($product){
    return $product->getsoldquantity();;
}
function adddeal($leadid,$productid){
    $deal = new deal();
    $dealid = $deal->save($leadid, $productid);
}
function finddealsbyproduct($productid){
    $deals = new deal();
    return $deals->findbyproduct($productid);
}
function deletedeal($dealid){
    $deal = new deal();
    $deal->delete($dealid);
}
function get($product,$attribute){
    $value = $product->get($attribute);
    if(isset($value)) return $value;
    else return false;
}
function set($product,$value, $attribute){
    echo $product->set($value, $attribute);;
}
function getlead($lead, $data){
    if($data == 'id') return $lead->get('id');
    if($data == 'name') return $lead->get('name');
}
function getinfo($data, $info){
    if($info == 'date') return date('d M. Y', strtotime($data) - timezone_difference());
    if($info == 'time') return date('H:i', strtotime($data) - timezone_difference());

}
?>