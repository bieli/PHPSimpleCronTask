<?php

class GetFreeDomainsFromNaskSimpleCronTask
//TODO: extends SimpleCronTask 
//TODO: implements SimpleCronTaskInterface
{
    const DATETIME_FORMAT = 'Ymd_His';

    public function __construct()
    {
        $this->properties = array(
                             'nask_domains_contents_address' 
                             => 'http://www.dns.pl/deleted_domains.txt',
                             'output_file_format'
                             => sprintf('deleted_domains.%s.xml', 
                                        self::DATETIME_FORMAT)

                            );
    }

    public function GetParams($i_Parametrs = array())
    {

    }

    public function Run($i_Parametrs = array())
    {
        $_freeDomains = @file_get_contents(
                        $this->properties['nask_domains_contents_address']);

        if ( true === is_string($_freeDomains)
             && 0 < strlen($_freeDomains) )
        {
            $_domains = explode("\n", $_freeDomains);

            $_domainsAll = array();

            $_updateTime = null;
            foreach ( $_domains as $_domainValue )
            {
                $_domainValue = trim($_domainValue);
                if ( 0 < strlen($_domainValue) )
                {
                    $_domainsAll[ $_domainValue ] = $_domainValue;
                }

                if ( null === $_updateTime )
                {
                    $_updateTime = $_domainsAll[ $_domainValue ];
                    unset($_domainsAll[ $_domainValue ]);
                }
            }

            $this->taskLogger->Log('Got ' . count($_domainsAll)
                                   . ' domains with update time "'
                                   . trim($_updateTime) . '"');

            $this->SaveXMLOutput($_updateTime, $_domainsAll);
        }
        else
        {
            $this->taskLogger->Log('Problem with getting domains from address: '
                                   . $this->properties['nask_domains_contents_address'], 'error');
        }

    }

    public function SetLogger($i_TaskLogger)
    {
        $this->taskLogger = $i_TaskLogger;
    }

    private function SaveXMLOutput($i_UpdateTime, $i_DomainsAll)
    {
        $_md5sum = md5(base64_encode(serialize($i_DomainsAll)));

        $_outputDataPath = sprintf('%s/%s.%s.%s.xml', DATA_PATH, basename(__FILE__), date('Ymd'), $_md5sum);

        $_xml = simplexml_load_string('<?xml version="1.0" encoding="utf-8"?><free_domains></free_domains>');

        $_xml->addAttribute('update_time', $i_UpdateTime);
        $_xml->addAttribute('download_unixtime', time());

        $_domains = $_xml->addChild('domains');

        foreach ( $i_DomainsAll as $_domainName )
        {
        $_domains->AddChild('domain_name', htmlentities($_domainName));
        }

        return $_xml->asXML($_outputDataPath);
    }
}
