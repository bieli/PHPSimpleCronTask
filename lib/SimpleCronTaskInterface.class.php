<?php

/**
 * Interface for defining one SimpleCronTask object
 */
interface SimpleCronTaskInterface
{
    /**
     * Get specific parameters
     */
    public function GetParams($i_Parametrs = array());

    /**
     * Run task with special/optional parameters
     */
    public function Run($i_Parametrs = array());
}
