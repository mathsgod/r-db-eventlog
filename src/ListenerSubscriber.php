<?php

namespace R\DB\EventLog;

use League\Event\ListenerRegistry;
use League\Event\ListenerSubscriber as EventListenerSubscriber;
use R\DB\Event\AfterDelete;
use R\DB\Event\AfterInsert;
use R\DB\Event\AfterUpdate;

class ListenerSubscriber implements EventListenerSubscriber
{

    protected int $userId = 0;

    public function setUserId(int $userId)
    {
        $this->userId = $userId;
    }

    public function subscribeListeners(ListenerRegistry $acceptor): void
    {
        $acceptor->subscribeTo(AfterInsert::class, function (AfterInsert $event) {
            $target = $event->target;
            /** @var \R\DB\Model $target */
            $schema = $target->GetSchema();

            $event_log_table = $schema->getTable("EventLog");
            $event_log_table->insert([
                "class" => get_class($target),
                "id" => $target->_id(),
                "action" => "Insert",
                "source" => null,
                "target" => json_encode($target),
                "created_time" => date("Y-m-d H:i:s"),
                "user_id" => $this->userId,

            ]);
        });


        $acceptor->subscribeTo(AfterDelete::class, function (AfterDelete $event) {
            $target = $event->target;
            /** @var \R\DB\Model $target */
            $schema = $target->GetSchema();

            $event_log_table = $schema->getTable("EventLog");
            $event_log_table->insert([
                "class" => get_class($target),
                "id" => $target->_id(),
                "action" => "Delete",
                "source" => json_encode($target),
                "target" => null,
                "created_time" => date("Y-m-d H:i:s"),
                "user_id" => $this->userId,

            ]);
        });

        $acceptor->subscribeTo(AfterUpdate::class, function (AfterUpdate $event) {
            $target = $event->target;
            /** @var \R\DB\Model $target */
            $schema = $target->GetSchema();

            $event_log_table = $schema->getTable("EventLog");
            $event_log_table->insert([
                "class" => get_class($target),
                "id" => $target->_id(),
                "action" => "Update",
                "source" => json_encode($target->getOriginal()),
                "target" => json_encode($target),
                "created_time" => date("Y-m-d H:i:s"),
                "user_id" => $this->userId,
            ]);
        });
    }
}
