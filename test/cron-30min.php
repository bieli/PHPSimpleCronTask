<?php

// INIT --------------------------
define('SIMPLE_CRON_TASK_PATH', '../');

require_once(SIMPLE_CRON_TASK_PATH . 'SimpleCronTaskBoot.php');

// ADD TASKS  TO LIST ---------------------

$_tasks = array(
    'GetFreeDomainsFromNaskSimpleCronTask'
);

// RUN TASKS ----------------------

foreach ( $_tasks as $_taskNameValue )
{
    $_simpleCronTaskObject = new SimpleCronTask($_taskNameValue);
}
