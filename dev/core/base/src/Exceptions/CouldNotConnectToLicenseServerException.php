<?php

namespace Dev\Base\Exceptions;

use Dev\Base\Contracts\Exceptions\IgnoringReport;
use Illuminate\Http\Client\ConnectionException;

class CouldNotConnectToLicenseServerException extends ConnectionException implements IgnoringReport
{
}
