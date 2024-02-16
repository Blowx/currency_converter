<?php

namespace application\modules\core\models\Defines\Response;

class Code
{
    /**
     * Response to a successful GET, PUT
     */
    const OK = 200;

    /**
     * Response to a POST that results in a creation
     */
    const CREATED = 201;

    /**
     * Response to a successful request that won't be returning a body (like a DELETE request)
     */
    const NO_CONTENT = 204;

    /**
     * Provides status for multiple independent processes
     */
    const MULTI_STATUS = 207;

    /**
     * General error for when fulfilling the request would cause an invalid state.
     * Domain validation errors, missing data, etc. are some examples
     */
    const BAD_REQUEST = 400;

    /**
     * Error code response for missing or invalid authentication token
     */
    const UNAUTHORIZED = 401;

    /**
     * When authentication succeeded but authenticated user does not have access to the resource
     */
    const FORBIDDEN = 403;

    /**
     * When a non-existent resource is requested
     */
    const NOT_FOUND = 404;
    /**
     * Internal Server error (hiding exceptions)
     */
    const INTERNAL = 500;
    /**
     * When MySQL|Mongo|Redis unavailable
     */
    const SERVICE_UNAVAILABLE = 503;
}
