<?php
require_once 'conn.php';
class operator
{
    public $id;
    public $name;
    public $login;
    public $password;
    public $is_admin;
    public $is_active;

    public function login(){
        $db = connect();
        $query_result = pg_fetch_assoc(pg_query_params($db, "SELECT * FROM operator WHERE login = $1 AND is_active = true", array($this->get('login'))));
        if($query_result==false) return false;
        if (password_verify($this->get('password'),$query_result['password'])) $this->setdatafromdatabase($query_result);
        else return false;
        return $this;
    }
    private function setdatafromdatabase($query_result){
        $this->set($query_result['id'],'id');
        $this->set($query_result['name'],'name');
        $this->set($query_result['login'],'login');
        $this->set($query_result['is_admin'],'is_admin');
        $this->set($query_result['is_active'],'is_active');
    }
    public function find($id){
        $db = connect();
        $query_result = pg_fetch_assoc(pg_query_params($db, "SELECT * FROM operator WHERE id = $1", array($id)));
        if($query_result==false)return false;
        $this->setdatafromdatabase($query_result);
        return $this;
    }
    public function save($data){
        if($_SESSION['is_admin']=='f') return false;
        $is_admin='false';
        if(isset($data['is_admin'])) $is_admin='true';
        $is_active='false';
        if(isset($data['is_active'])) $is_active='true';
        $password = password_hash($data['password'], PASSWORD_DEFAULT);
        $db = connect();
        pg_query_params($db, "INSERT INTO operator (name, login, password, is_admin, is_active) VALUES ($1, $2, $3, $4, $5)", array($data['name'], $data['login'], $password, $is_admin, $is_active));
    }
    public function update($data){
        if($_SESSION['is_admin']=='f') return false;
        $is_admin='false';
        if(isset($data['is_admin'])) $is_admin='true';
        $is_active='false';
        if(isset($data['is_active'])) $is_active='true';
        $db = connect();
        if(!empty($data['password'])){
            $password = password_hash($data['password'], PASSWORD_DEFAULT);
            pg_query_params($db, "UPDATE operator SET name=$1, login=$2, password=$3, is_admin=$4, is_active=$5 WHERE id=$6", array($data['name'], $data['login'], $password, $is_admin, $is_active, $this->get('id')));
        } else pg_query_params($db, "UPDATE operator SET name=$1, login=$2, is_admin=$3, is_active=$4 WHERE id=$5", array($data['name'], $data['login'], $is_admin, $is_active, $this->get('id')));
    }
    public function updatepassword(){
        $db = connect();
        $password = password_hash($this->get('password'), PASSWORD_DEFAULT);
        pg_query_params($db, "UPDATE operator SET password=$1 WHERE id=$2", array($password, $this->get('id')));
    }
    public function search(){
        $db = connect();
        if(null!=$this->get('name'))
            $query_result = pg_fetch_all(pg_query_params($db, "SELECT * FROM operator WHERE name ILIKE $1 ORDER BY is_active DESC, name", array("%".$this->get('name')."%")));
        else 
            $query_result = pg_fetch_all(pg_query($db, "SELECT * FROM operator ORDER BY is_active DESC, name"));
        $operators = array();
        if ($query_result == false) return $operators;
        foreach ($query_result as $row) {
            $operator = new operator();
            $operator->setdatafromdatabase($row);
            array_push($operators, $operator);
        }
        return $operators;
    }
    public function get($attribute){
        return $this->$attribute;
    }
    public function set($value, $attribute){
        $this->$attribute = $value;
    }
}
?>