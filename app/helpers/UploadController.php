<?php

namespace Helpers;

use \Core\Controller as Controller;

/**
 * Provides functionality for uploading files
 */
class UploadController extends Controller
{
    /**
     * Array of allowed file types for uploading, as strings
     *
     * @var array
     */
    private $allowed_types = [];

    /**
     * Maximum file size that can be uploaded in bytes
     *
     * @var integer
     */
    private $max_size;

    /**
     * Constructor
     *
     * @param array $allowed_types
     * @param integer $max_size
     */
    public function __construct($allowed_types = [], $max_size = 500000)
    {
        $this->allowed_types = $allowed_types;
        $this->max_size = $max_size;
    }

    /**
     * Upload function
     *
     * @param array $params
     * @param string $file_name
     * 
     * @return string $target_file
     * 
     * @throws \Exception
     */
    public function upload($params, $file_name)
    {
        $target_dir = "uploads/";
        $time = strval('_' . time());
        $image_file_type = strtolower(pathinfo($_FILES[$file_name]['name'], PATHINFO_EXTENSION));

        $target_file = $target_dir .
                        basename($_FILES[$file_name]["name"], '.' . $image_file_type ) .
                        strval('_' . time()) .
                        '.' .
                        $image_file_type;

        $this->validateHasRole();
        $this->validateUploadErrors($file_name);
        $this->validateNoFileExists($target_file);
        $this->limitFileSize($file_name);
        $this->validateFileTypeAllowed($image_file_type);
        
        if (move_uploaded_file($_FILES[$file_name]["tmp_name"], $target_file)) {
            return $target_file;
        } else {
            throw new \Exception('Something went wrong uploading the file');
        }
    }

    /**
     * Validates the user has the required role
     *
     * @return bool
     *
     * @throws \Exception
     */
    private function validateHasRole()
    {
        $has_role = AuthController::hasRole('file_upload.access');

        if (!$has_role) {
            throw new \Exception('User is missing the required role file_upload.access');
        } else {
            return true;
        }    
    }

    /**
     * Validates there are no errors on the file
     *
     * @param string $file_name
     *
     * @return bool
     *
     * @throws \Exception
     */
    public function validateUploadErrors($file_name)
    {
        // Undefined | Multiple Files | $_FILES Corruption Attack
        // If this request falls under any of them, treat it invalid.
        if (
            !isset($_FILES[$file_name]['error']) ||
            is_array($_FILES[$file_name]['error'])
        ) {
            throw new \Exception('Invalid parameters.');
        }

        // Check $_FILES[$target_file]['error'] value.
        switch ($_FILES[$file_name]['error']) {
            case UPLOAD_ERR_OK:
                break;
            case UPLOAD_ERR_NO_FILE:
                throw new \Exception('No file sent.');
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                throw new \Exception('Exceeded filesize limit.');
            default:
                throw new \Exception('Unknown errors.');
        }
    }

    /**
     * Validates that no files exist with the same name
     *
     * @param string $target_file
     *
     * @return bool
     * 
     * @throws \Exception
     */
    private function validateNoFileExists($target_file)
    {
        if (file_exists($target_file)) {
            throw new \Exception('File already exists!');
        } else {
            return true;
        }
    }

    /**
     * Validates that the file is within the file limit
     *
     * @param string $file_name
     *
     * @return bool
     *
     * @throws \Exception
     */
    public function limitFileSize($file_name)
    {
        if ($_FILES[$file_name]["size"] > $this->max_size) {
            throw new \Exception('File size too large');
        } else {
            return true;
        }
    }

    /**
     * Validates that the file is an allowed type
     *
     * @param string $file_type
     *
     *  @return bool
     *
     * @throws \Exception
     */
    private function validateFileTypeAllowed($file_type)
    {
        if (!in_array($file_type, $this->allowed_types)) {
            throw new \Exception(
                'File type not allowed. Recieved: ' .
                $file_type .
                '. Allowed: ' .
                implode(',', $this->allowed_types)
            );
        } else {
            return true;
        }
    }
}