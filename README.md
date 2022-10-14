# r-db-eventlog

## setup
Create database table EventLog

```sql
CREATE TABLE `EventLog` (
  `eventlog_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `class` varchar(64) DEFAULT NULL,
  `id` int(10) unsigned NOT NULL,
  `action` varchar(64) DEFAULT NULL,
  `source` json DEFAULT NULL,
  `target` json DEFAULT NULL,
  `remark` text,
  `user_id` int(10) unsigned NOT NULL,
  `created_time` datetime NOT NULL,
  `status` int(10) unsigned DEFAULT '0',
  `different` json DEFAULT NULL,
  PRIMARY KEY (`eventlog_id`),
  KEY `class` (`class`),
  KEY `user_id` (`user_id`),
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;
```

Register listeners

```php
$schema = \R\DB\Model::GetSchema();

$subscriber = new ListenerSubscriber();

$subscriber->setUserId(1);

$schema->eventDispatcher()->subscribeListenersFrom($subscriber);

```