<?php
require_once 'conn.php';
require_once 'shortobject.php';
require_once 'operator.php';

function newlead($terms){
    //if($_SESSION['is_admin']=='f') return false;
    $db = connect();
    $query = "SELECT lead.name AS lead, operator.name AS owner, lead.creation AS creation FROM lead INNER JOIN operator ON lead.owner_id = operator.id WHERE lead.creation >= $1 AND lead.creation <= $2";
    $params = array($terms['periodstart'], $terms['periodend']);
    $count = 3;
    if(isset($terms['status'])) if(null!=$terms['status']){
        $query = $query.' AND lead.status_id = $'.$count;
        array_push($params, $terms['status']);
        $count++;
    }
    if(isset($terms['source'])) if(null!=$terms['source']){
        $query = $query.' AND lead.source_id = $'.$count;
        array_push($params, $terms['source']);
        $count++;
    }
    if(isset($terms['situation'])) if(null!=$terms['situation']){
        if($terms['situation']==2){
            $query = $query.' AND lead.parent_id IS NOT NULL';
        }
        if($terms['situation']==1){
            $query = $query.' AND lead.parent_id IS NULL';
        }
    }
    $query = $query.' ORDER BY lead.creation';
    $query_result = pg_fetch_all(pg_query_params($db, $query, $params));
    return $query_result;
}
function deals($terms){
    //if($_SESSION['is_admin']=='f') return false;
    $db = connect();
    $query = "SELECT product.name AS product, lead.name AS lead, operator.name AS owner, deal.sale_date AS sale_date FROM deal INNER JOIN operator ON deal.owner_id = operator.id INNER JOIN lead ON deal.lead_id = lead.id INNER JOIN product ON deal.product_id = product.id WHERE deal.sale_date >= $1 AND deal.sale_date <= $2";
    $params = array($terms['periodstart'], $terms['periodend']);
    $count = 3;
    if(isset($terms['operator'])) if(null!=$terms['operator']){
        $query = $query.' AND deal.owner_id = $'.$count;
        array_push($params, $terms['operator']);
        $count++;
    }
    if(isset($terms['product'])) if(null!=$terms['product']){
        $query = $query.' AND deal.product_id = $'.$count;
        array_push($params, $terms['product']);
        $count++;
    }
    $query = $query.' ORDER BY deal.sale_date';
    $query_result = pg_fetch_all(pg_query_params($db, $query, $params));
    return $query_result;
}
?>