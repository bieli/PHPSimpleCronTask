<?php

interface SimpleCronTaskInterface
{
    public function GetParams($i_Parametrs = array());
    public function Run($i_Parametrs = array());
}
