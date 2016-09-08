<?php
/**
 * Created by PhpStorm.
 * User: sapphirehead
 * Date: 27.04.2016
 * Time: 23:18
 */
namespace models;

require_once(__DIR__ . '/../../vendor/autoload.php');
/**
 * Class PHPMailerClass
 * @package models
 */
class PHPMailerClass extends DBObject
{
    /**
     * @staticvar string
     */
    protected static $table_name="mail";
    /**
     * @staticvar array
     */
    protected static $db_fields = array('id', 'host', 'mail_from', 'password', 'port', 'overall_name', 'mail_for', 'recipient', 'header');

    /**
     * @var
     */
    private static $result_array;
    /**
     * @var
     */
    public $host;
    /**
     * @var
     */
    public $mail_from;
    /**
     * @var
     */
    public $password;
    /**
     * @var
     */
    public $port;
    /**
     * @var
     */
    public $overall_name;
    /**
     * @var
     */
    public $mail_for;
    /**
     * @var
     */
    public $recipient;
    /**
     * @var
     */
    public $header;


    /**
     * @param string $host
     * @param string $mail_from
     * @param string $password
     * @param int $port
     * @param string $overall_name
     * @param string $mail_for
     * @param string $recipient
     * @param string $header
     * @return PHPMailerClass
     * @throws ExeptionMy
     */
    public function makeMailObj(string $host, string $mail_from, string $password, int $port, string $overall_name, string $mail_for,
                         string $recipient, string $header): PHPMailerClass
    {
        if (!empty($host) && !empty($mail_from) && !empty($password) && !empty($port) && !empty($overall_name) &&
            !empty($mail_for) && !empty($recipient) && !empty($header)) {

            $mail_obj = new self;
            $mail_obj->id = 0;
            $mail_obj->host = $host;
            $mail_obj->mail_from = $mail_from;
            $mail_obj->password = $password;
            $mail_obj->port = $port;
            $mail_obj->overall_name = $overall_name;
            $mail_obj->mail_for = $mail_for;
            $mail_obj->recipient = $recipient;
            $mail_obj->header = $header;
            return $mail_obj;
        } else {
            throw new ExeptionMy("Заполните все обязательные поля!");
        }

    }

    /**
     * Выбирает значения из БД для отправки письма
     *  Метод общий для комментариев и логов
     */
    public static function getMailSettingsFromDB()
    {
        $sql  = "SELECT * FROM mail ";
        $sql .= "LIMIT 1";
        $result_array = self::findBySql($sql);
        self::$result_array = array_shift($result_array);
    }


    /**
     * @param string $date
     * @param string $actor
     * @param string $message
     * @throws ExeptionMy
     * @throws \Exception
     * @throws \phpmailerException
     */
    public static function sendNotification(string $actor, string $message, string $date)
    {
       if (!empty(self::$result_array)) {
           $mail = new \PHPMailer();

           $mail->isSMTP();                                      // Set mailer to use SMTP
           $mail->Host = 'smtp.' . self::$result_array->host;  // Specify main and backup SMTP servers
           $mail->SMTPAuth = true;                               // Enable SMTP authentication
           $mail->Username = self::$result_array->mail_from;                 // SMTP username
           $mail->Password = decrypt(self::$result_array->password);                           // SMTP password
           $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
           $mail->Port = self::$result_array->port;                                    // TCP port to connect to 587

           $mail->setFrom(self::$result_array->mail_from, self::$result_array->overall_name);
           $mail->addAddress(self::$result_array->mail_for, self::$result_array->recipient);     // Add a recipient
            //$mail->addAddress('ellen@example.com');               // Name is optional
           $mail->addReplyTo(self::$result_array->mail_from, 'Information');
            //$mail->addCC('cc@example.com');// Copy is optional
            //$mail->addBCC('bcc@example.com');

            //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
            //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
            //$mail->isHTML(true);                                  // Set email format to HTML

           $mail->Subject = self::$result_array->header;
           $created = datetimeToText($date);
           $overall_name = self::$result_array->overall_name;
           $mail->CharSet = "UTF-8";
           $mail->Body = <<<EMAILBODY

A new message has been received from the $overall_name.

  At {$created}, {$actor} :

{$message}

EMAILBODY;
       $mail->send();
       } else {
           throw new ExeptionMy('Статус: не удалось отправить почтовое сообщение.');
       }
    }
}
