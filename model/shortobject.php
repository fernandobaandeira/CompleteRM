<?php
require_once 'conn.php';
class status
{
    public $id;
    public $name;

    public function find($id){
        $this->set($id,'id');
        $db = connect();
        $query_result = pg_fetch_assoc(pg_query_params($db, "SELECT * FROM status WHERE id = $1", array($id)));
        $this->set($query_result['name'], 'name');
        return $this;
    }
    public function save($data){
        $db = connect();
        pg_query_params($db, "INSERT INTO status (name) VALUES ($1)", array($data['name']));
    }
    public function update($data){
        $db = connect();
        pg_query_params($db, "UPDATE status SET name=$1 WHERE id=$2", array($data['name'], $data['id']));
    }
    public function delete($data){
        $db = connect();
        pg_query_params($db, "DELETE FROM status WHERE id=$1",array($data['id']));
    }
    public function search(){
        $db = connect();
        if(null!=$this->get('name'))
            $query_result = pg_fetch_all(pg_query_params($db, "SELECT * FROM status WHERE name ILIKE $1 ORDER BY name", array("%".$this->get('name')."%")));
        else 
            $query_result = pg_fetch_all(pg_query($db, "SELECT * FROM status ORDER BY name"));
        $statuses = array();
        if ($query_result == false) return $statuses;
        foreach ($query_result as $row) {
            $status = new status();
            $status->set($row['id'], 'id');
            $status->set($row['name'], 'name');
            array_push($statuses, $status);
        }
        return $statuses;
    }
    public function findwithleadcount(){
        $db = connect();
        $query_result = pg_fetch_all(pg_query($db, "SELECT * FROM status ORDER BY name"));
        $statuses = array();
        if ($query_result == false) return $statuses;
        foreach ($query_result as $row) {
            $status = array('id' => $row['id'], 'name' => $row['name']);
            $id=$row['id'];
            $status['leadquantity'] = pg_fetch_all(pg_query($db, "SELECT COUNT(*) as value FROM lead WHERE status_id=$id"))[0]['value'];
            array_push($statuses, $status);
        }
        return $statuses;
    }
    public function get($attribute){
        return $this->$attribute;
    }
    public function set($value, $attribute){
        $this->$attribute = $value;
    }
}
class source
{
    public $id;
    public $name;

    public function find($id){
        $this->set($id,'id');
        $db = connect();
        $query_result = pg_fetch_assoc(pg_query_params($db, "SELECT * FROM source WHERE id = $1", array($id)));
        $this->set($query_result['name'], 'name');
        return $this;
    }
    public function save($data){
        $db = connect();
        pg_query_params($db, "INSERT INTO source (name) VALUES ($1)", array($data['name']));
    }
    public function update($data){
        $db = connect();
        pg_query_params($db, "UPDATE source SET name=$1 WHERE id=$2", array($data['name'], $data['id']));
    }
    public function delete($data){
        $db = connect();
        pg_query_params($db, "DELETE FROM source WHERE id=$1",array($data['id']));
    }
    public function search(){
        $db = connect();
        if(null!=$this->get('name'))
            $query_result = pg_fetch_all(pg_query_params($db, "SELECT * FROM source WHERE name ILIKE $1 ORDER BY name", array("%".$this->get('name')."%")));
        else 
            $query_result = pg_fetch_all(pg_query($db, "SELECT * FROM source ORDER BY name"));
        $sources = array();
        if ($query_result == false) return $sources;
        foreach ($query_result as $row) {
            $source = new source();
            $source->set($row['id'],'id');
            $source->set($row['name'],'name');
            array_push($sources, $source);
        }
        return $sources;
    }
    public function findwithleadcount(){
        $db = connect();
        $query_result = pg_fetch_all(pg_query($db, "SELECT * FROM source ORDER BY name"));
        $sources = array();
        if ($query_result == false) return $statuses;
        foreach ($query_result as $row) {
            $source = array('id' => $row['id'], 'name' => $row['name']);
            $id=$row['id'];
            $source['leadquantity'] = pg_fetch_all(pg_query($db, "SELECT COUNT(*) as value FROM lead WHERE source_id=$id"))[0]['value'];
            array_push($sources, $source);
        }
        return $sources;
    }
    public function get($attribute){
        return $this->$attribute;
    }
    public function set($value, $attribute){
        $this->$attribute = $value;
    }
}
class interest
{
    public $id;
    public $name;
    public $description;

    public function find($id){
        $this->set($id,'id');
        $db = connect();
        $query_result = pg_fetch_assoc(pg_query_params($db, "SELECT * FROM interest WHERE id = $1", array($id)));
        if($query_result==false)return false;
        $this->set($query_result['name'],'name');
        $this->set($query_result['description'],'description');
        return $this;
    }
    public function save($data){
        $db = connect();
        $id = pg_fetch_assoc(pg_query_params($db, "INSERT INTO interest (name, description) VALUES ($1, $2) RETURNING id", array($data['name'], $data['description'])))['id'];
        return $id;
    }
    public function update($data){
        $db = connect();
        pg_query_params($db, "UPDATE interest SET name=$1, description=$2 WHERE id=$3", array($data['name'], $data['description'], $this->get('id')));
    }
    public function delete($id){
        $db = connect();
        pg_query_params($db, "DELETE FROM interest_lead WHERE interest_id=$1",array($id));
        pg_query_params($db, "DELETE FROM interest WHERE id=$1",array($id));
    }
    public function deleteinterested($leadid, $id){
        $db = connect();
        pg_query_params($db, "DELETE FROM interest_lead WHERE lead_id=$1 AND interest_id=$2",array($leadid, $id));
    }
    public function search(){
        $db = connect();
        if(null!=$this->get('name'))
            $query_result = pg_fetch_all(pg_query_params($db, "SELECT * FROM interest WHERE name ILIKE $1 OR description ILIKE $1 ORDER BY name", array("%".$this->get('name')."%")));
        else 
            $query_result = pg_fetch_all(pg_query($db, "SELECT * FROM interest ORDER BY name"));
        $interests = array();
        if ($query_result == false) return $interests;
        foreach ($query_result as $row) {
            $interest = new interest();
            $interest->setdatafromdatabase($row);
            array_push($interests, $interest);
        }
        return $interests;
    }
    public function getinterestedcount(){
        $db = connect();
        $id = $this->get('id');
        return pg_fetch_all(pg_query($db, "SELECT COUNT (*) AS value FROM interest_lead WHERE interest_id=$id"))[0]['value'];
    }
    public function getinterested(){
        $db = connect();
        $id = $this->get('id');
        $query_result = pg_fetch_all(pg_query($db, "SELECT * FROM lead INNER JOIN interest_lead on lead.id = interest_lead.lead_id WHERE interest_id = $id ORDER BY interest_lead.creation DESC"));
        $interested = array();
        if ($query_result == false) return $interested;
        foreach ($query_result as $row) {
            $interest = array('id' => $row['id'], 'name' => $row['name']);
            $creation = pg_fetch_all(pg_query_params($db, "SELECT creation FROM interest_lead WHERE interest_id=$1 AND lead_id=$2", array($id, $row['id'])))[0]['creation'];
            $interest['creation'] = $creation;
            array_push($interested, $interest);
        }
        return $interested;
    }
    public function findbylead($leadid){
        $db = connect();
        $query_result = pg_fetch_all(pg_query_params($db, "SELECT * FROM interest INNER JOIN interest_lead on interest.id = interest_lead.interest_id WHERE lead_id = $1 ORDER BY creation DESC", array($leadid)));
        $interests = array();
        if ($query_result == false) return $interests;
        foreach ($query_result as $row) {
            $interest = array('id' => $row['id'], 'name' => $row['name'], 'creation' => $row['creation']);
            array_push($interests, $interest);
        }
        return $interests;
    }
    private function setdatafromdatabase($query_result){
        $this->set($query_result['id'],'id');
        $this->set($query_result['name'],'name');
        $this->set($query_result['description'],'description');
    }
    public function get($attribute){
        return $this->$attribute;
    }
    public function set($value, $attribute){
        $this->$attribute = $value;
    }
}
?>