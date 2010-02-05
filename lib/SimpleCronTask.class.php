<?php

/**
 * SimpleCronTasks runner object
 *
 */
class SimpleCronTask extends PropertiesManager
{
    private $taskLogger = null;

    public function __construct($i_TaskName = null)
    {
        $this->className = $i_TaskName;

        if ( null !== $i_TaskName )
        {
    //TODO: remember about use properties
    //        date('Y-m-d H:i:s');
    //        $this->output_file_format
            $_logPath = LOGS_PATH . '/' . $i_TaskName . '.class.php.'
                        . date('Ymd') . '.log';
//var_dump($_logPath);
            $this->taskLogger = new SimpleFileLogger($_logPath, true);

            $this->taskLogger->Log('START');

            $_taskObj = $this->GetSimpleTaskInstance($i_TaskName);

//TODO: set parametrs
            $_taskObj->GetParams(array());

            $this->taskLogger->Log('RUN');

            $_taskObj->Run(array());

            //TODO: load task from batch
            // $i_TaskName
            //TODO: set additional properties 
            //TODO: run task procsess

            $this->taskLogger->Log('STOP');
        }
    }

    private function GetSimpleTaskInstance($i_TaskName)
    {
        $o_Instance = false;

        require_once(BATCH_PATH . '/' . $i_TaskName . '.class.php');

        $o_Instance = new $i_TaskName();
        $o_Instance->SetLogger($this->taskLogger);

        return  $o_Instance;
    }
}

