<?php
require_once 'conn.php';
require_once 'operator.php';
class note
{
    public $id;
    public $description;
    public $creation;
    public $owner;

    public function find($id){
        $db = connect();
        $query_result = pg_fetch_assoc(pg_query_params($db, "SELECT * FROM note WHERE id = $1", array($id)));
        if($query_result==false)return false;
        $this->setdatafromdatabase($query_result);
        return $this;
    }
    public function save($notetext){
        $db = connect();
        $owner = $_SESSION['operator'];
        $id = pg_fetch_assoc(pg_query_params($db, "INSERT INTO note (description, creation, owner_id) VALUES ($1, CURRENT_TIMESTAMP(0) , $2) RETURNING id", array($notetext, $owner)))['id'];
        return $id;
    }
    public function delete($id){
        if($_SESSION['is_admin']=='f') return false;
        $db = connect();
        pg_query($db, "DELETE FROM lead_note WHERE note_id = $id");
        pg_query($db, "DELETE FROM note_product WHERE note_id = $id");
        pg_query($db, "DELETE FROM note WHERE id = $id");
    }
    private function setdatafromdatabase($query_result){
        $this->set($query_result['id'],'id');
        $this->set($query_result['description'],'description');
        $this->set($query_result['creation'],'creation');
        $owner = new operator();
        $this->set($owner->find($query_result['owner_id']),'owner');
    }
    public function findbylead($leadid){
        $db = connect();
        $query_result = pg_fetch_all(pg_query_params($db, "SELECT * FROM note INNER JOIN lead_note on note.id = lead_note.note_id WHERE lead_id = $1 ORDER BY creation DESC", array($leadid)));
        $notes = array();
        if ($query_result == false) return $notes;
        foreach ($query_result as $row) {
            $note = array('id' => $row['id'], 'description' => $row['description'], 'creation' => $row['creation']);
            $note['owner'] = pg_fetch_all(pg_query_params($db, "SELECT name FROM operator WHERE id = $1", array($row['owner_id'])))[0]['name'];
            array_push($notes, $note);
        }
        return $notes;
    }
    public function findbyproduct($productid){
        $db = connect();
        $query_result = pg_fetch_all(pg_query_params($db, "SELECT * FROM note INNER JOIN note_product on note.id = note_product.note_id WHERE product_id = $1 ORDER BY creation DESC", array($productid)));
        $notes = array();
        if ($query_result == false) return $notes;
        foreach ($query_result as $row) {
            $note = array('id' => $row['id'], 'description' => $row['description'], 'creation' => $row['creation']);
            $note['owner'] = pg_fetch_all(pg_query_params($db, "SELECT name FROM operator WHERE id = $1", array($row['owner_id'])))[0]['name'];
            array_push($notes, $note);
        }
        return $notes;
    }
    public function get($attribute){
        return $this->$attribute;
    }
    public function set($value, $attribute){
        $this->$attribute = $value;
    }
}
?>