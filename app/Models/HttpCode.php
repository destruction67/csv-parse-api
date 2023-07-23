<?php

namespace App\Models;

use Symfony\Component\HttpFoundation\Response;

class HttpCode extends Response
{
    //1xx Informational
    const CONTINUE = 100;

    //2xx SUCCESS
    const SUCCESS_OK = 200;
    const SUCCESS_CREATED = 201;
    const NON_AUTHORITATIVE_INFORMATION = 203;
    const SUCCESS_NO_CONTENT = 204;

    //3xx REDIRECTION
    const NOT_MODIFIED = 301;

    //4xx CLIENT ERROR
    const BAD_REQUEST = 400;
    const FORBIDDEN = 403;
    const CONFLICT = 409;
    const UNAUTHORIZED = 401;
    const NOT_FOUND = 404;
    const UNPROCESSABLE_ENTITY = 422;

    //5xx SERVER ERROR
    const INTERNAL_SERVER_ERROR = 500;
    const NOTE_IMPLEMENTED = 501;
    const BAD_GATEWAY = 502;
    const SERVICE_UNAVAILABLE = 503;
    const GATEWAY_TIME_OUT = 504;
    const HTTP_VERSION_NOT_SUPPORTED = 505;
    const VARIANT_ALSO_NEGOTIATES = 506;
    const BANDWIDTH_LIMIT_EXCEEDED = 509;
}
