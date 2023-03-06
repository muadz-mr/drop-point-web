<?php

namespace App\Support\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static string replacePhoneNoLeadingZero(string $phoneNo)
 * @method static string getSymbolicLinkPublicUrl(string $path = null)
 * @method static string storeFile(string $base64EncodeFile, string $path = null)
 * @method static void deleteFile(string $path = null)
 * @method static string getFileExtension(string $base64EncodeFile)
 *
 * @see \App\Support\Helper
 */
class Helper extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     *
     * @throws \RuntimeException
     */
    protected static function getFacadeAccessor()
    {
        return 'helper';
    }
}
