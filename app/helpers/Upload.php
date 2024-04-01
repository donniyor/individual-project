<?php

namespace app\helpers;

use Yii;
use yii\base\Exception;
use yii\web\UploadedFile;
use \yii\web\HttpException;
use yii\helpers\Inflector;
use yii\helpers\StringHelper;
use yii\helpers\FileHelper;
use yii\imagine\Image;

class Upload
{
    public static $UPLOADS_DIR = 'uploads';

    /**
     * @throws Exception
     * @throws HttpException
     */
    public static function file(UploadedFile $fileInstance, $dir = '', $namePostfix = true)
    {
        $fileName = Upload::getUploadPath($dir) . DIRECTORY_SEPARATOR . Upload::getFileName($fileInstance, $namePostfix);

        if (!$fileInstance->saveAs($fileName)) {
            throw new HttpException(500, 'Cannot upload file "' . $fileName . '". Please check write permissions.');
        }

        $im = fopen(Yii::getAlias('@webroot' . Upload::getLink($fileName)), 'r');
        $f = Upload::getFileName($fileInstance, $namePostfix);
        $content = Yii::$app->minio->writeStream($f, $im);
        
        return $content['path'];
    }

    public  static function fileAlias(UploadedFile $fileInstance, $namePostfix = true): string
    {
        $content = Yii::$app->minio->writeStream(Upload::getFileName($fileInstance, $namePostfix), fopen($fileInstance->tempName, 'r'));
        return $content['path'];
    }

    /**
     * @throws Exception
     * @throws HttpException
     */
    static function getUploadPath($dir): string
    {
        $uploadPath = Yii::getAlias('@webroot') . DIRECTORY_SEPARATOR . self::$UPLOADS_DIR . ($dir ? DIRECTORY_SEPARATOR . $dir : '');
        if (!FileHelper::createDirectory($uploadPath)) {
            throw new HttpException(500, 'Cannot create "' . $uploadPath . '". Please check write permissions.');
        }
        return $uploadPath;
    }

    static function getLink($fileName)
    {
        return str_replace('\\', '/', str_replace(Yii::getAlias('@webroot'), '', $fileName));
    }

    static function getFileName($fileInstance, $namePostfix = true): string
    {
        $baseName = str_ireplace('.' . $fileInstance->extension, '', $fileInstance->name);
        $fileName = StringHelper::truncate(Inflector::slug($baseName), 32, '');
        if ($namePostfix || !$fileName) {
            $fileName .= ($fileName ? '-' : '') . substr(uniqid(md5(rand()), true), 0, 10);
        }
        $fileName .= '.' . $fileInstance->extension;

        return $fileName;
    }
}