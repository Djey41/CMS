<?php
/**
 * Created by PhpStorm.
 * User: sapphirehead
 * Date: 10.06.2016
 * Time: 22:15
 */
namespace models;

class ExeptionUploadMy extends \Exception
{
    public function __construct(int $code)
    {
        $message = $this->codeToMessage($code);
        parent::__construct($message, $code);
    }

    private function codeToMessage(int $code): string
    {
        switch ($code) {
            case UPLOAD_ERR_INI_SIZE:
                $message = "Размер загружаемого файла превышает значение директивы upload_max_filesize в php.ini";
                break;
            case UPLOAD_ERR_FORM_SIZE:
                $message = "Загрузка файла превышающего MAX_FILE_SIZE который был ограничен в HTML-форме";
                break;
            case UPLOAD_ERR_PARTIAL:
                $message = "Файл загружен частично";
                break;
            case UPLOAD_ERR_NO_FILE:
                $message = "Файл не был загружен";
                break;
            case UPLOAD_ERR_NO_TMP_DIR:
                $message = "Временная директория не существует";
                break;
            case UPLOAD_ERR_CANT_WRITE:
                $message = "Не удалась запись файла на диск";
                break;
            case UPLOAD_ERR_EXTENSION:
                $message = "Загрузка файла остановлена расширением";
                break;

            default:
                $message = "Неизвестная ошибка загрузки";
                break;
        }
        return $message;
    }
}
