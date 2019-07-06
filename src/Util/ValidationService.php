<?php


namespace App\Util;


use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class ValidationService
 * @package App\Util
 */
class ValidationService
{

    /**
     *
     */
    const FILETYPE = 'json';
    /**
     *
     */
    const ENCODING = 'UTF-8';

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * ValidationService constructor.
     *
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param UploadedFile $file
     *
     * @return mixed|bool
     */
    public function validate(UploadedFile $file)
    {
        try {

            if ($this->checkExtension($file)) {

                if ($this->checkEncoding($file)) {

                    return $this->validateJson($file);
                } else {

                    return FeedbackMessages::WRONG_ENCODING;
                }

            } else {

                return FeedbackMessages::WRONG_DATA_TYPE;
            }

        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());

            return $e->getMessage();
        }

        return false;
    }

    /**
     * @param UploadedFile $file
     *
     * @return bool
     */
    private function checkExtension(UploadedFile $file): bool
    {


        if ($file->getClientOriginalExtension() !== self::FILETYPE) {
            $this->logger->error(FeedbackMessages::WRONG_DATA_TYPE);

            return false;
        }

        return true;
    }


    /**
     * @param UploadedFile $file
     *
     * @return bool
     */
    private function checkEncoding(UploadedFile $file): bool
    {
        if (!mb_check_encoding(file_get_contents($file), self::ENCODING)) {
            $this->logger->error(FeedbackMessages::WRONG_ENCODING);

            return false;
        }

        return true;
    }

    /**
     * @param UploadedFile $file
     *
     * @return mixed|string
     */
    private function validateJson(UploadedFile $file)
    {
        try {

            $json = file_get_contents($file);
            json_decode($json);

            // switch and check possible JSON errors
            switch (json_last_error()) {
                case JSON_ERROR_NONE:
                    $error = '';
                    break;
                case JSON_ERROR_DEPTH:
                    $error = FeedbackMessages::MAX_DEPTH;
                    break;
                case JSON_ERROR_STATE_MISMATCH:
                    $error = FeedbackMessages::INVALID_FORMAT;
                    break;
                case JSON_ERROR_CTRL_CHAR:
                    $error = FeedbackMessages::CHAR_ERR_WRONG_ENCODED;
                    break;
                case JSON_ERROR_SYNTAX:
                    $error = FeedbackMessages::SYNTAX_ERR_JSON;
                    break;
                // PHP >= 5.3.3
                case JSON_ERROR_UTF8:
                    $error = FeedbackMessages::WRONG_CHAR_ENCODING;
                    break;
                // PHP >= 5.5.0
                case JSON_ERROR_RECURSION:
                    $error = FeedbackMessages::RECURSIVE_ERR;
                    break;
                // PHP >= 5.5.0
                case JSON_ERROR_INF_OR_NAN:
                    $error = FeedbackMessages::NAN_INF_ERR;
                    break;
                case JSON_ERROR_UNSUPPORTED_TYPE:
                    $error = FeedbackMessages::CAN_NOT_ENCODE;
                    break;
                default:
                    $error = FeedbackMessages::UNKNOWN_ERR;
                    break;
            }

            if ($error !== '') {
                $this->logger->error($error);

                return $error;
            }

            return true;

        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());

            return $e->getMessage();
        }
    }

}