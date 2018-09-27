<?php
require_once 'conn.php';
require_once 'operator.php';
require_once 'product.php';
require_once 'lead.php';
class deal
{
    public $id;
    public $owner;
    public $product;
    public $lead;
    public $sale_date;
    
    public function find($id){
        $db = connect();
        $query_result = pg_fetch_assoc(pg_query_params($db, "SELECT * FROM deal WHERE id = $1", array($id)));
        if($query_result==false)return false;
        $this->setdatafromdatabase($query_result);
        return $this;
    }
    public function save($leadid, $productid){
        $db = connect();
        $owner = $_SESSION['operator'];
        $id = pg_fetch_assoc(pg_query_params($db, "INSERT INTO deal (owner_id, product_id, lead_id, sale_date) VALUES ($1, $2, $3, CURRENT_TIMESTAMP(0)) RETURNING id", array($owner, $productid, $leadid)))['id'];
        return $id;
    }
    public function delete($dealid){
        if($_SESSION['is_admin']=='t'){
            $db = connect();
            pg_query($db, "DELETE FROM deal WHERE id = $dealid");
        }
    }
    private function setdatafromdatabase($query_result){
        $this->set($query_result['id'],'id');
        $this->set($query_result['sale_date'],'sale_date');
        $owner = new operator();
        $this->set($owner->find($query_result['owner_id']),'owner');
        $product = new product();
        $this->set($product->find($query_result['product_id']),'product');
        $lead = new lead();
        $this->set($lead->find($query_result['lead_id']),'lead');
    }
    public function findbylead($leadid){
        $db = connect();
        $lead = new lead();
        $lead->set($leadid,'id');
        $dependents = $lead->finddependents();
        $query = $leadid;
        if(!empty($dependents)){
        	foreach ($dependents as $dependent) {
        		$query = $query.' OR lead_id = '.$dependent->get('id');
        	}
        }
        $query = "SELECT * FROM deal WHERE lead_id = ".$query."ORDER BY sale_date DESC";
        $query_result = pg_fetch_all(pg_query($db, $query));
        $deals = array();
        if ($query_result == false) return $deals;
        foreach ($query_result as $row) {
            $deal = array('id' => $row['id'], 'sale_date' => $row['sale_date']);
            $deal['owner'] = pg_fetch_all(pg_query_params($db, "SELECT name FROM operator WHERE id = $1", array($row['owner_id'])))[0]['name'];
            $product = pg_fetch_all(pg_query_params($db, "SELECT id, name FROM product WHERE id = $1", array($row['product_id'])))[0];
            $deal['product'] = $product['name'];
            $deal['product_id'] = $product['id'];
            $temp = pg_fetch_all(pg_query_params($db, "SELECT id, name FROM lead WHERE id = $1", array($row['lead_id'])))[0];
            $deal['lead_id'] = $temp['id'];
            $deal['lead_name'] = $temp['name'];
            array_push($deals, $deal);
        }
        return $deals;
    }
    public function findbyproduct($productid){
        $db = connect();
        $product = new product();
        $product->set($productid,'id');
        $query_result = pg_fetch_all(pg_query($db, "SELECT * FROM deal WHERE product_id = $productid ORDER BY sale_date DESC"));
        $deals = array();
        if ($query_result == false) return $deals;
        foreach ($query_result as $row) {
            $deal = array('id' => $row['id'], 'sale_date' => $row['sale_date']);
            $deal['owner'] = pg_fetch_all(pg_query_params($db, "SELECT name FROM operator WHERE id = $1", array($row['owner_id'])))[0]['name'];
            $temp = pg_fetch_all(pg_query_params($db, "SELECT id, name FROM lead WHERE id = $1", array($row['lead_id'])))[0];
            $deal['lead_id'] = $temp['id'];
            $deal['lead_name'] = $temp['name'];
            array_push($deals, $deal);
        }
        return $deals;
    }
    public function get($attribute){
        return $this->$attribute;
    }
    public function set($value, $attribute){
        $this->$attribute = $value;
    }
}
?>