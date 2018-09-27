<?php
require_once '../../model/lead.php';
require_once '../../model/note.php';
require_once '../../model/deal.php';
require_once '../../model/shortobject.php';
require_once '../../model/operator.php';
require_once '../../model/product.php';
require_once '../fragments/language.php';

function find($id){
    $lead = new lead();
    return $lead->find($id);
}
function about_dependents($lead){
    $return = array('situation'=>'none');
    if(!is_null($lead->get('parent'))){
        $return['situation'] = 'dependent';
        $return['parent_id'] = $lead->get('parent')->get('id');
        $return['parent_name'] = $lead->get('parent')->get('name');
    } else{
        $dependents = $lead->finddependents();
        if($dependents!=false) {
            $return['situation'] = 'parent';
            $return['dependents'] = array();
            foreach($dependents as $dependent){
                $temp = array("dependent_id"=>$dependent->get('id'), "dependent_name"=>$dependent->get('name'));
                array_push($return['dependents'], $temp);
            }
        }            
    }
    return $return;
}
function save($terms){
    $lead = new lead();
    $id = $lead->save($terms);
    return $lead->find($id);
}
function update($id, $terms){
    $lead = new lead();
    $lead->set($id,'id');
    $lead->update($terms);
    return $lead->find($id);
}
function deactivatelead($id){
    $lead= new lead();
    $lead->deactivate($id);
}
function search($terms){
    $lead = new lead();
    $lead->set("",'name');
    if(isset($terms['search'])) if(!empty($terms['search'])) $lead->set($terms['search'],'name');
    if(isset($terms['status'])) if(!empty($terms['status'])) $lead->set($terms['status'],'status');
    if(isset($terms['source'])) if(!empty($terms['source'])) $lead->set($terms['source'],'source');
    if(isset($terms['situation'])) if(!empty($terms['situation'])) $lead->set($terms['situation'],'observation');
    $leads = $lead->search();
    return $leads;
}
function searchattr($terms,$attr){
    $$attr = new $attr();
    $$attr->set("",'name');
    if(isset($terms)) $$attr->set($terms,'name');
    return $$attr->search();
}
function addnote($leadid,$notetext){
    $note = new note();
    $noteid = $note->save($notetext);
    $lead = new lead();
    $lead->addnote($leadid, $noteid);
}
function findnotesbylead($leadid){
    $notes = new note();
    return $notes->findbylead($leadid);
}
function deletenote($noteid){
    $note = new note();
    $note->delete($noteid);
}
function adddeal($leadid,$productid){
    $deal = new deal();
    $dealid = $deal->save($leadid, $productid);
}
function finddealsbylead($leadid){
    $deals = new deal();
    return $deals->findbylead($leadid);
}
function deletedeal($dealid){
    $deal = new deal();
    $deal->delete($dealid);
}
function addinterest($leadid, $terms){
    $lead = new lead();
    $interestid = $terms['interestid'];
    if(isset($terms['interestname'])){
        $terms['name'] = $terms['interestname'];
        $terms['description'] = "";
        $interest = new interest();
        $interestid = $interest->save($terms);
    } 
    $lead->addinterest($leadid, $interestid);
}
function findinterestsbylead($leadid){
    $interests = new interest();
    return $interests->findbylead($leadid);
}
function deleteinterested($leadid, $terms){
    $interest = new interest();
    $interest->deleteinterested($leadid, $terms['interestid']);
}
function get($lead,$attribute){
    $value = $lead->get($attribute);
    if(isset($value)) return $value;
    else return false;
}
function getdep($lead,$dependency,$attribute){
    $value = $lead->get($dependency)->get($attribute);
    if(isset($value)) return $value;
    else return false;
}
function set($lead,$value, $attribute){
    echo $lead->set($value, $attribute);;
}
function getproduct($product, $data){
    if($data == 'id') return $product->get('id');
    if($data == 'name') return $product->get('name');
}
function getinterest($interest, $data){
    if($data == 'id') return $interest->get('id');
    if($data == 'name') return $interest->get('name');
}
function getinfo($data, $info){
    if($info == 'date') return date('d M. Y', strtotime($data) - timezone_difference());
    if($info == 'time') return date('H:i', strtotime($data) - timezone_difference());
}
?>