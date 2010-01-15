<?php

define('LIBRARY_PATH', dirname(__FILE__) . '/lib');
define('DATA_PATH', dirname(__FILE__) . '/data');
define('LOGS_PATH', dirname(__FILE__) . '/log');
define('BATCH_PATH', dirname(__FILE__) . '/batch');


function simple_class_autoloader($i_ClassName)
{
    $_classFilePath = LIBRARY_PATH . '/' . $i_ClassName . '.class.php';

    if ( true === file_exists($_classFilePath) )
    {
        require_once($_classFilePath);
        return true;
    }
    else
    {
        throw new Exception(sprintf('Could not load class "%s"'
                            . ' from file "%s"', $i_ClassName, $_classFilePath));
    }
}

if ( false === function_exists('spl_autoload_register') )
{
    die('Unable to use function "spl_autoload_register" !!!');
}

spl_autoload_register('simple_class_autoloader');

$_registredClases = array(
                     'SimpleFileLogger',
                     'PropertiesManager',
                     'SimpleCronTask'
                    );

foreach ( $_registredClases as $_class_Key => $_classNameValue )
{
    $_tmpObj = new $_classNameValue();
    unset($_tmpObj);
}

//var_dump(LIBRARY_PATH, $_registredClases);

/*
$_libsDir = opendir(LIBRARY_PATH);
if ( true === is_resource($_libsDir) )
{
    while ( $_className = readdir($_libsDir) )
    {
        $_registredClases[] = $_className;

echo $_className . "\n";
        $_tmpObj = new $_className();
        unset($_tmpObj);
    }

    closedir($_libsDir);

    var_dump($_registredClases);
}
*/

