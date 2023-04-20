<?php

namespace ExequielLares\MockApi\Logger\Handler;

use Magento\Framework\Logger\Handler\Base;
use Monolog\Logger;

class MockApiLogger extends Base
{
    /**
     * @var string
     */
    protected $fileName = '/var/log/mock_api.log';

    /**
     * @var int
     */
    protected $loggerType = Logger::DEBUG;
}
