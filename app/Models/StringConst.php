<?php

namespace App\Models;

class StringConst
{
    const ERROR_CONFLICT_AUTH_MSG = [
        'errors' => [
            'message' => 'Incorrect username or password',
        ],
    ];

    const ERROR_RECORD_EXIST = [
        'errors' => [
            'message' => 'Record already exist',
        ]
    ];

    const ERROR_RECORD_NOT_FOUND = [
        'errors' => [
            'message' => 'Record not found',
        ]
    ];

    const ERROR_SERVICE_UNAVAILABLE = [
        'errors' => [
            'message' => 'Service un available this time.'
        ]
    ];

    const ERROR_UPLOADING_FILE = [
        'errors' => [
            'message' => 'Uploading file unsuccessful'
        ]
    ];

    const ERROR_EXCEPTION_ERROR = [
        'errors' => [
            'message' => 'Exception Error'
        ]
    ];

    const EXCEPTION_MSG = "Exception occurred";

}
