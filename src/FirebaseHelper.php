<?php
/**
 * Created by PhpStorm.
 * User: mikhail
 * Date: 1/21/19
 * Time: 12:57 PM
 */

namespace Kakadu\Yii2Firebase;

use Kreait\Firebase;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

/**
 * Class    FirebaseHelper
 * @package Kakadu\Yii2Firebase
 * @author  Yarmaliuk Mikhail
 * @version 1.0
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
     * @var Firebase
     */
    private static $_instanceRDB;

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
     * Get firebase realtime db instance
     *
     * @param string|null $projectId
     *
     * @return Firebase
     */
    public static function initRDB(string $projectId = 'google-services')
    {
        if (self::$_instanceRDB === null) {
            try {
                $serviceAccount     = ServiceAccount::fromJsonFile(\Yii::getAlias(self::$_configFile . "/$projectId.json"));
                self::$_instanceRDB = (new Factory)
                    ->withServiceAccount($serviceAccount)
                    ->create();
            } catch (\Exception $e) {
                return self::catchMethod();
            }
        }

        return self::$_instanceRDB;
    }
}