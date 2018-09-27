<?php
require_once 'conn.php';
require_once 'operator.php';
class product
{
    public $id;
    public $name;
    public $description;
    public $creation;
    public $is_active;
    public $owner;

    public function find($id){
        $db = connect();
        $query_result = pg_fetch_assoc(pg_query_params($db, "SELECT * FROM product WHERE id = $1", array($id)));
        if($query_result==false)return false;
        $this->setdatafromdatabase($query_result);
        return $this;
    }
    public function save($data){
        $db = connect();
        $owner = $_SESSION['operator'];
        $id = pg_fetch_assoc(pg_query_params($db, "INSERT INTO product (name, description, creation, is_active, owner_id) VALUES ($1, $2, CURRENT_TIMESTAMP(0), true, $3) RETURNING id", array($data['name'], $data['description'], $owner)))['id'];
        return $id;
    }
    public function update($data){
        $db = connect();
        pg_query_params($db, "UPDATE product SET name=$1, description = $2 WHERE id=$3", array($data['name'], $data['description'], $this->get('id')));
    }
    public function deactivate($id){
        $db = connect();
        pg_query($db, "UPDATE product SET is_active=false WHERE id=$id");
    }
    public function search(){
        $db = connect();
        if(null!=$this->get('name'))
            $query_result = pg_fetch_all(pg_query_params($db, "SELECT * FROM product WHERE name ILIKE $1 AND is_active = true ORDER BY name", array("%".$this->get('name')."%")));
        else 
            $query_result = pg_fetch_all(pg_query($db, "SELECT * FROM product WHERE is_active = true ORDER BY name"));
        $products = array();
        if ($query_result == false) return $products;
        foreach ($query_result as $row) {
            $product = new product();
            $product->setdatafromdatabase($row);
            array_push($products, $product);
        }
        return $products;
    }
    public function getsoldquantity(){
        $db = connect();
        $id = $this->get('id');
        return pg_fetch_all(pg_query($db, "SELECT COUNT (*) AS value FROM deal WHERE product_id=$id"))[0]['value'];
    }
    private function setdatafromdatabase($query_result){
        $this->set($query_result['id'],'id');
        $this->set($query_result['name'],'name');
        $this->set($query_result['description'],'description');
        $this->set($query_result['creation'],'creation');
        $this->set($query_result['is_active'],'is_active');
        $owner = new operator();
        $this->set($owner->find($query_result['owner_id']),'owner');
    }
    public function addnote($productid, $noteid){
        $db = connect();
        pg_query_params($db, "INSERT INTO note_product (product_id, note_id) VALUES ($1, $2)", array($productid, $noteid));
    }
    public function get($attribute){
        return $this->$attribute;
    }
    public function set($value, $attribute){
        $this->$attribute = $value;
    }
}
?>