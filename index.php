<?php

use R\DB\EventLog\ListenerSubscriber;
use R\DB\Schema;

require_once __DIR__ . '/vendor/autoload.php';


class Testing extends \R\DB\Model
{
}

$schema = \R\DB\Model::GetSchema();

$subscriber = new ListenerSubscriber();

$subscriber->setUserId(1);

$schema->eventDispatcher()->subscribeListenersFrom($subscriber);




$a = Testing::Create([
    "name" => "test",
]);

$a->save();


$testing = new Testing($a->_id());
$testing->name = "test2";
$testing->save();

$a->delete();







//$testing=new Testing(1);
//$testing->save();



//$schema = Schema::Create();
//$schema->eventDispatcher()->subscribeListenersFrom