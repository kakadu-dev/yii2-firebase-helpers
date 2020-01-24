<?php
/**
 * Created by PhpStorm.
 * User: mikhail
 * Date: 1/21/19
 * Time: 12:57 PM
 */

namespace Kakadu\Yii2Firebase;

use Kreait\Firebase\Database;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

/**
 * Class    FirebaseHelper
 *
 * @package Kakadu\Yii2Firebase
 * @author  Yarmaliuk Mikhail
 * @version 2.0
 *
 * Firebase SDK helper
 */
class FirebaseHelper extends FluentAbstract
{
    /**
     * Default path with part of the file name
     *
     * @var string
     */
    private static $_configFile = '@common/config/firebase';

    /**
     * @var FirebaseHelper
     */
    private static $_instance;

    /**
     * @var Factory
     */
    private static $_firebase;

    /**
     * @var Database
     */
    private static $_db;

    /**
     * Set config file path (with part of the file name)
     *
     * @param string $newPath
     *
     * @return static
     */
    public static function setConfigPath(string $newPath)
    {
        self::$_configFile = $newPath;

        return __CLASS__;
    }

    /**
     * Get firebase instance
     *
     * @param string|null $projectId
     *
     * @return FirebaseHelper
     */
    public static function init(string $projectId = 'google-services')
    {
        if (self::$_instance === null) {
            self::$_instance = new FirebaseHelper();

            if (self::$_firebase === null) {
                try {
                    $serviceAccount  = ServiceAccount::fromJsonFile(\Yii::getAlias(self::$_configFile . "/$projectId.json"));
                    self::$_firebase = (new Factory)->withServiceAccount($serviceAccount);
                } catch (\Exception $e) {
                    return self::catchMethod();
                }
            }
        }

        return self::$_instance;
    }

    /**
     * Get database instance
     *
     * @return Database
     */
    public function getDatabase(): Database
    {
        if (self::$_db === null) {
            try {
                self::$_db = self::$_firebase->createDatabase();
            } catch (\Exception $e) {
                return self::catchMethod();
            }
        }

        return self::$_db;
    }
}
