<?php
namespace App\Classes;

class Constants {
    //for success status
    const SUCCESS_STATUS = 'success';
    //for failed status
    const FAILED_STATUS = 'failed';
    //for error
    const ERROR_STATUS='Error';
    //for query cache
    const LONG_CACHE_TIME=1440;
    const SHORT_CACHE_TIME=60;
    const AWS_FILE_TTL=120;
    const CATCH_ERROR = 'Something went wrong. Please try again later.';
    const PAYMENT_FAILED = 'payment failed';
}
