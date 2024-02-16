<?php
namespace application\modules\yii\db;

use yii;
use application\modules\yii\log;
use application\modules\yii\db;
use application\modules\yii\db\Defines;

class Helper
{
    /**
     * Returns whether if specified exception is one provided in list
     *
     * @param \Exception $error Exception to examine
     * @param array      $list  List of error code to check for
     *
     * @return bool
     */
    public static function findError(\Exception $error, array $list)
    {
        foreach ($list as $code) {
            // Get SQL state corresponding to code
            $state = Defines\Sql\Error\Code::state($code);
            // All conditions MUST be satisfied
            switch (false) {
                case Defines\Sql\State::find($state, $error->getMessage()):
                    // State exists in error message
                case (strpos($error->getMessage(), (string)$code) !== false):
                    // Error code exists in error message
                    //case ($code == $error->getCode()):
                    // Error code corresponds
                    break;
                default:
                    return true;
            }
        }

        return false;
    }

    /**
     * Checks provided error for repeat possibility if any
     *
     * @param \Exception $error
     * @param integer    $attempt  Current attempt
     * @param array      $list     List of allowed error codes
     * @param integer    $maxRetry Maximal possible attempts amount
     *
     * @return bool
     * @throws \Exception
     */
    public static function checkError(\Exception $error, array $list, $attempt, $maxRetry)
    {
        $message = "Command Attempt {$attempt}/{$maxRetry}";
        // Check whether it's allowed to retry such error
        if (Helper::findError($error, $list)) {
            if ($attempt < $maxRetry) {
                // Try next attempt
                log\Helper::logError($error, "{$message} => Continue", Defines\Connection::LOG_PREFIX_ERR);
                sleep($attempt);

                // Returns whether to continue
                return true;
            } else {
                $message .= " => Stop";
            }
        } else {
            $message .= ". Not supported retry error";
        }
        log\Helper::logError($error, $message, Defines\Connection::LOG_PREFIX_ERR);
        // Throw error out
        throw $error;
    }
}
