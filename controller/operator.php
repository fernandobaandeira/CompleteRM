<?php
require_once '../../model/operator.php';
require_once '../../model/shortobject.php';
function login($data){
    $operator = new operator();
    $operator->set(strtolower($data['login']),'login');
    $operator->set($data['password'],'password');
    $login = $operator->login();
    if($login != false){
        session_start();
        $_SESSION['operator'] = $login->get('id');
        $_SESSION['is_admin'] = $login->get('is_admin');
    }
}
function logout(){
    session_start();
    unset($_SESSION['operator']);
    unset($_SESSION['is_admin']);
    session_destroy();
}
function find($id){
    $operator = new operator();
    return $operator->find($id);
}
function save($terms){
    $operator = new operator();
    $id = $operator->save($terms);
}
function update($terms){
    $operator = new operator();
    $operator->set($terms['id'],'id');
    $operator->update($terms);
}
function updatepassword($terms){
    $operator = new operator();
    $operator->set($_SESSION['operator'],'id');
    $operator->set($terms['password'],'password');
    $operator->updatepassword();
}
function search($terms){
    $operator = new operator();
    $operator->set("",'name');
    $operators = false;
    if(isset($terms['search'])) $operator->set($terms['search'],'name');
    $operators = $operator->search();
    return $operators;
}
function findwithleadcount($attr){
    $$attr = new $attr();
    return $$attr->findwithleadcount();
}
function operation($attr,$terms){
    $$attr = new $attr();
    $function = $terms['function'];
    $$attr->$function($terms);
}
function get($operator,$attribute){
    $value = $operator->get($attribute);
    if(isset($value)) return $value;
    else return false;
}
function set($operator,$value, $attribute){
    echo $operator->set($operator, $attribute);;
}
?>