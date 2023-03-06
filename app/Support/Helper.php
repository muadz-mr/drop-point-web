<?php

namespace App\Support;

use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

/**
 * Helper
 *
 * @method string replacePhoneNoLeadingZero(string $phoneNo)
 * @method string getSymbolicLinkPublicUrl(string $path = null)
 * @method string storeFile(string $base64EncodeFile, string $path = null)
 * @method void deleteFile(string $path = null)
 * @method string getFileExtension(string $base64EncodeFile)
 */
class Helper
{
    private $defaultPath = 'uploads';

    /**
     * Replace Phone No Leading Zero
     *
     * @param string $phoneNo
     * @return string
     */
    public function replacePhoneNoLeadingZero(string $phoneNo): string
    {
        return preg_replace("/^0/", "60", $phoneNo);
    }

    /**
     * Get Symbolic Link Public Path
     *
     * @param string $path
     * @return string
     */
    public function getSymbolicLinkPublicUrl(string $path = null): string|null
    {
        return $path ? (string) asset("storage/{$path}") : $path;
    }

    /**
     * Store File
     *
     * @param string $base64EncodeFile
     * @param ?string $path
     * @return string
     */
    public function storeFile(string $base64EncodeFile, string $path = null): string
    {
        $extension = $this->getFileExtension($base64EncodeFile);
        $fileName = $this->generateFileName();
        $path = $this->prepareUploadPath($fileName . '.' . $extension, $path);
        if (!Storage::disk('public')->put($path, base64_decode($base64EncodeFile))) {
            throw new BadRequestException(__('message.error_upload_file'));
        }

        return $path;
    }

    /**
     * Delete File
     *
     * @param string $path
     * @return void
     */
    public function deleteFile(string $path = null): void
    {
        if ($path && $this->directoryExists($path)) {
            if (!Storage::disk('public')->delete($path)) {
                throw new BadRequestException(__('message.error_delete_file'));
            }
        }
    }

    /**
     * Get File Extension
     *
     * @param string $base64EncodeFile
     * @return string
     */
    public function getFileExtension(string $base64EncodeFile): string
    {
        $fileData = base64_decode($base64EncodeFile);
        $file = finfo_open();
        $extension = substr(strstr(finfo_buffer($file, $fileData, FILEINFO_MIME_TYPE), '/'), strlen('/'));

        return $extension == 'jpeg' ? 'jpg' : $extension;
    }

    private function generateFileName(): string
    {
        return (string) Str::orderedUuid();
    }

    private function prepareUploadPath(string $fileName, string $path = null): string
    {
        if (!$path) {
            $path = $this->defaultPath . '/' . $fileName;
        } else {
            $path .= '/' . $fileName;
        }

        return $this->localPathAware($path);
    }

    private function localPathAware(string $path): string
    {
        return str_replace('\\', '/', $path);
    }

    private function directoryExists($path): bool
    {
        return Storage::disk('public')->exists($path);
    }
}
