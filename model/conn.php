<?php
function connect(){
	return pg_connect("host=ec2-75-101-142-91.compute-1.amazonaws.com port=5432 dbname=dba48bhqvchn68 user=pncwurojuhgwaw password=ec0bedaa78c38b30baa6ad3cb3cf945b65c896b71a8b8ef1bf36912a8da13eef");
}
?>