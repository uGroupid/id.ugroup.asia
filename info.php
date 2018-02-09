<?php
$m = new MongoClient("mongodb://127.0.0.1:27017");
$db = $m->client_ugroup; // where testdb is already existing Database
var_dump($db );