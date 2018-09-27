<?php
require_once 'conn.php';
require_once 'shortobject.php';
require_once 'operator.php';
class lead
{
    public $id;
    public $name;
    public $mail;
    public $phone;
    public $address;
    public $birth;
    public $creation;
    public $observation;
    public $is_active;
    public $status;
    public $source;
    public $owner;
    public $parent;

    public function find($id){
        $db = connect();
        $query_result = pg_fetch_assoc(pg_query_params($db, "SELECT * FROM lead WHERE id = $1", array($id)));
        if($query_result==false)return false;
        $this->setdatafromdatabase($query_result);
        return $this;
    }
    public function save($data){
        $db = connect();
        $owner = $_SESSION['operator'];
        if(isset($data['parentname'])){
            $data['parent'] = pg_fetch_assoc(pg_query_params($db, "INSERT INTO lead (name, creation, is_active, status_id, source_id, owner_id) VALUES ($1, CURRENT_TIMESTAMP(0), true, $2, $3, $4) RETURNING id", array($data['parentname'], $data['status'], $data['source'], $owner)))['id'];
        }
        $id = pg_fetch_assoc(pg_query_params($db, "INSERT INTO lead (name, mail, phone, address, creation, observation, is_active, status_id, source_id, owner_id) VALUES ($1, $2, $3, $4, CURRENT_TIMESTAMP(0) , $5, true, $6, $7, $8) RETURNING id", array($data['name'], $data['mail'], $data['phone'], $data['address'], $data['observation'], $data['status'], $data['source'], $owner)))['id'];
        if(!empty($data['birth'])) pg_query_params($db, "UPDATE lead SET birth = $1 WHERE id = $2", array($data['birth'], $id));
        if(!empty($data['parent'])) pg_query_params($db, "UPDATE lead SET parent_id = $1 WHERE id = $2", array($data['parent'], $id));
        return $id;
    }
    public function update($data){
        $db = connect();
        if(isset($data['parentname'])){
            $data['parent'] = pg_fetch_assoc(pg_query_params($db, "INSERT INTO lead (name, creation, is_active, status_id, source_id, owner_id) VALUES ($1, CURRENT_TIMESTAMP(0), true, $2, $3, $4) RETURNING id", array($data['parentname'], $data['status'], $data['source'], $_SESSION['operator'])))['id'];
        }
        if(!empty($data['birth'])) $this->set($data['birth'], 'birth');
        else $this->set(null, 'birth');
        if(!empty($data['parent'])) $this->set($data['parent'], 'parent');
        else $this->set(null, 'parent');
        pg_query_params($db, "UPDATE lead SET name=$1, mail=$2, phone=$3, birth=$4, address=$5, observation=$6, status_id=$7, source_id=$8, parent_id=$9 WHERE id=$10", array($data['name'], $data['mail'], $data['phone'], $this->get('birth'), $data['address'], $data['observation'], $data['status'], $data['source'], $this->get('parent'), $this->get('id')));
    }
    public function deactivate($id){
        if($_SESSION['is_admin']=='f') return false;
        $db = connect();
        pg_query($db, "UPDATE lead SET is_active=false WHERE id=$id");
    }
    public function search(){
        $db = connect();
        $query = "SELECT * FROM lead WHERE is_active=true";
        $params = array();
        $count = 1;
        if(null!=$this->get('name')){
            $query = $query.' AND name ILIKE $'.$count;
            array_push($params, "%".$this->get('name')."%");
            $count++;
        }
        if(null!=$this->get('status')){
            $query = $query.' AND status_id = $'.$count;
            array_push($params, $this->get('status'));
            $count++;
        }
        if(null!=$this->get('source')){
            $query = $query.' AND source_id = $'.$count;
            array_push($params, $this->get('source'));
            $count++;
        }
        if(null!=$this->get('observation')){
            if($this->get('observation')==2){
                $query = $query.' AND parent_id IS NOT NULL';
            }
            if($this->get('observation')==1){
                $query = $query.' AND parent_id IS NULL';
            }
            $count++;
        }
        if($count>1){
            $query = $query.' ORDER BY name';
            $query_result = pg_fetch_all(pg_query_params($db, $query, $params));
        } else $query_result = pg_fetch_all(pg_query($db, "SELECT * FROM lead WHERE is_active=true ORDER BY name"));
        $leads = array();
        if ($query_result == false) return $leads;
        foreach ($query_result as $row) {
            $lead = new lead();
            $lead->setdatafromdatabase($row);
            array_push($leads, $lead);
        }
        return $leads;
    }
    public function finddependents(){
        $db = connect();
        $query_result = pg_fetch_all(pg_query_params($db, "SELECT * FROM lead WHERE parent_id = $1 AND is_active=true ORDER BY name", array($this->get('id'))));
        $leads = array();
        if ($query_result == false) return $leads;
        foreach ($query_result as $row) {
            $lead = new lead();
            $lead->setdatafromdatabase($row);
            array_push($leads, $lead);
        }
        return $leads;

    }
    private function setdatafromdatabase($query_result){
        $this->set($query_result['id'],'id');
        $this->set($query_result['name'],'name');
        $this->set($query_result['mail'],'mail');
        $this->set($query_result['phone'],'phone');
        $this->set($query_result['address'],'address');
        $this->set($query_result['birth'],'birth');
        $this->set($query_result['creation'],'creation');
        $this->set($query_result['observation'],'observation');
        $this->set($query_result['is_active'],'is_active');
        $status = new status();
        $this->set($status->find($query_result['status_id']),'status');
        $source = new source();
        $this->set($source->find($query_result['source_id']),'source');
        $owner = new operator();
        $this->set($owner->find($query_result['owner_id']),'owner');
        if (!is_null($query_result['parent_id'])){
            $parent = new lead();
            $this->set($parent->find($query_result['parent_id']),'parent');
        }
    }
    public function addnote($leadid, $noteid){
        $db = connect();
        pg_query_params($db, "INSERT INTO lead_note (lead_id, note_id) VALUES ($1, $2)", array($leadid, $noteid));
    }
    public function addinterest($leadid, $interestid){
        $db = connect();
        $query_result = pg_fetch_all(pg_query_params($db, 'SELECT * FROM interest_lead WHERE interest_id = $1 AND lead_id = $2', array($interestid,$leadid)));
        if($query_result == false) pg_query_params($db, "INSERT INTO interest_lead (interest_id, lead_id, creation) VALUES ($1, $2, CURRENT_TIMESTAMP(0))", array($interestid, $leadid));
    }
    public function get($attribute){
        return $this->$attribute;
    }
    public function set($value, $attribute){
        $this->$attribute = $value;
    }
}
?>