<?php

namespace Ilovepdf;

use App;
App\General::class_include('Task.php', 'iLovePDF/vendor/ilovepdf/ilovepdf-php/src');
/**
 * Class UnlockTask
 *
 * @package Ilovepdf
 */
class UnlockTask extends Task
{

    /**
     * UnlockTask constructor.
     *
     * @param null|string $publicKey    Your public key
     * @param null|string $secretKey    Your secret key
     * @param bool $makeStart           Set to false for chained tasks, because we don't need the start
     */
    function __construct($publicKey, $secretKey, $makeStart = true)
    {
        $this->tool = 'unlock';
        parent::__construct($publicKey, $secretKey, $makeStart);
    }
}
