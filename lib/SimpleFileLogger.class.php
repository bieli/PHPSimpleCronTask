<?php
/**
 * Logger core module
 * @todo TODO need refactoring !!!!
 *
 * @package phpMiniFr
 */
class SimpleFileLogger
{
    public $c_LogFile   = null;
    public $c_LogAppend = null;

   /**
    * Constructor
    * 
    * @access public
    */
    public function __construct($i_LogFilename = null, $i_LogAppend = false)
    {
        $this->c_LogFile   = $i_LogFilename;
        $this->c_LogAppend = $i_LogAppend;

        if ( null !== $this->c_LogFile )
        {
            $this->Create($this->c_LogFile, $this->c_LogAppend);
        }
    }

    public function Create($i_LogFilename = null, $i_LogAppend = false)
    {
        if ($i_LogFilename === null)
        {
            die('1:Logger - No valid log filename given!');
        }

        // assign given filename to class-logfile
//        $this->c_LogFile = defROOT_PATH . defLOGS_PATH . '/' .$i_LogFilename;
        $this->c_LogFile   = $i_LogFilename;
        $this->c_LogAppend = $i_LogAppend;
    }

    public function Write($i_Message = null)
    {
        if ($i_Message === null)
        {
            die('2:Logger - Null message given!');
        }

        // try to open logfile - if the file doesn't exists - create new oine

        switch ($this->c_LogAppend)
        {
            default:
            case false:
                $this->c_LogAppend = 'w';
                break;
            case true:
                $this->c_LogAppend = 'a+';
                break;
        }

        $_fp = fopen($this->c_LogFile, $this->c_LogAppend);
        if ($_fp === null
            || !is_resource($_fp))
        {
            die('3:Logger - Couldn\'t open log file (' . $this->c_LogFile . ')! or permission denied!');
        }


        $_wr = fwrite($_fp, $this->_GetCurrentTime() . ' ' . $i_Message . "\n");

        if ($_wr === null
            || empty($_wr))
        {
            die('3:Logger - Not write!');            
        }

        fclose($_fp);
    }
    
    /**
     * Gets current data and time like string in format 'YYYY-MM-DD hh:mm:ss'
     *
     * @return  string      Returns current data and time string
     * @access  private
     */
     private function _GetCurrentTime()
     {
         $_mtime = microtime();
         $_mtime = explode(' ', $_mtime);
	     
         $o_Time = date('Y-m-d H:i:s', $_mtime[1]) . substr($_mtime[0], 1);
		 
         return $o_Time;
    }
	
    /**
     * Gets current data and time like filename format
     *
     * @return  string      Returns current data and time string with filename format
     * @access  public
     */
     public function GetCurrentTimeLikeFilename()
     {
         return str_replace(array('-', ' ', ':', ), '_', $this->_GetCurrentTime());
     }

    public function Log($i_Message, $i_MsgType = 'info')
    {
        $this->Write(' {' . $i_MsgType . '} ' . $i_Message);
    }

    public function RawWrite($i_Message = null)
    {
        if ($i_Message === null)
        {
            die('52:Logger - Null message given!');
        }

        switch ($this->c_LogAppend)
        {
            default:
            case false:
                $this->c_LogAppend = 'w';
                break;
            case true:
                $this->c_LogAppend = 'a+';
                break;
        }

        $_fp = fopen($this->c_LogFile, $this->c_LogAppend);
        if ($_fp === null
            || !is_resource($_fp))
        {
            die('53:Logger - Couldn\'t open log file (' . $this->c_LogFile . ')! or permission denied!');
        }

        $_wr = fwrite($_fp, $i_Message);

        if ($_wr === null
            || empty($_wr))
        {
            die('3:Logger - Not write!');            
        }

        fclose($_fp);
    }

}

