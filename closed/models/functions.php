<?php

use models\PHPMailerClass;
use models\ExeptionMy;

require_once('ExeptionMy.php');

/**
 *@param $value
 * @return string
 */
function escapeValue(string $value)
{
    return trim(strip_tags($value));
}

/**
 * @param string $value
 * @return mixed
 */
function sanitizeValueStrong(string $value)
{
    return filter_var($value, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
}

/**
 * @param string $durty_int
 * @return mixed
 */
function escapeIntValue($durty_int)
{
    return filter_var(abs((int) $durty_int), FILTER_SANITIZE_NUMBER_INT);
}

/**
 * @param string $value
 * @return string
 * @throws ExeptionMy
 */
function validateValueForEmail(string $value)
{
    if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
        return $value;
    } else {
        throw new ExeptionMy ('E-mail не может так выглядеть');
    }
}
/**
 * @param string $marked_string
 * @return mixed
 */
function stripZerosFromDate(string $marked_string="")
{$no_zeros = str_replace('*0', '', $marked_string);
  $cleaned_string = str_replace('*', '', $no_zeros);
  return $cleaned_string;
}

/**
 * @param string $location
 */
function redirectTo(string $location = null ): void
{
  if ($location != null) {
    header("Location: {$location}");
    exit;
  }
}


/**
 * @param string $message
 * @return string
 */
function outputMessage(string $message="")
{
  if (!empty($message)) { 
    return "<p class=\"message\">{$message}</p>";
  } else {
    return "";
  }
}

/**
 * @param string $logfile
 * @param string $action
 * @param string $message
 * @throws ExeptionMy
 */
function logAction(string $logfile, string $action, string $message="")
{
	if (file_exists($logfile)) {
        if($handle = fopen($logfile, 'a')) {
            $timestamp = strftime("%Y-%m-%d %H:%M:%S", time());
            $content = "{$timestamp} | {$action}: {$message}\n";
            fwrite($handle, $content);
            fclose($handle);
        } else {
            throw new ExeptionMy("Не удалось открыть файл для записи.");
        }
    } else {
        throw new ExeptionMy("Файл не существует.");
    }
}

/**
 *
 * Блок отправки логов на почту
 *
 * @param string $dt
 * @param string $action
 * @param string $message
 * @throws ExeptionMy
 */
function tryToSendMessageToPost(string $action, string $message, string $dt=null)
{
    $timestamp = strftime("%Y-%m-%d %H:%M:%S", time());
    PHPMailerClass::getMailSettingsFromDB();
    PHPMailerClass::sendNotification($action, $message, $timestamp);
}


/**
 * @param string $datetime
 * @return string
 */
function datetimeToText(string $datetime="")
{
  $unixdatetime = strtotime($datetime);
  return strftime("%B %d, %Y at %I:%M %p", $unixdatetime);
}

/**
 * @param string $tmpname
 * @return string
 */
function getExtens(string $tmpname)
{
    switch(exif_imagetype($tmpname)) :
        case IMAGETYPE_GIF :
            $ext = '.gif';
            break;
        case IMAGETYPE_PNG :
            $ext = '.png';
            break;
        case IMAGETYPE_JPEG :
            $ext = '.jpg';
            break;
        default :
            $ext = '.jpg';
            break;
    endswitch;
    return $ext;
}

/**
 * TO DO: would be array
 * @param string $str_color
 * @return int
 */
function getCodeColor(string $str_color)
{
    switch ($str_color) :
        case 'black':
            $hex_color = 0x000000;
            break;
        case 'white':
            $hex_color = 0xFFFFFF;
            break;
        case 'red':
            $hex_color = 0xFF0000;
            break;
        case 'blue':
            $hex_color = 0x99FFFF;
            break;
        case 'green':
            $hex_color = 0x009900;
            break;
        case 'yellow':
            $hex_color = 0xFFFF00;
            break;
        case 'orange':
            $hex_color = 0xFF6600;
            break;
        case 'crimson':
            $hex_color = 0xCC0033;
            break;
        case 'purple':
            $hex_color = 0xCC00FF;
            break;
        case 'lilac':
            $hex_color = 0x9966FF;
            break;
        case 'cyan':
            $hex_color = 0x00FFFF;
            break;
        case 'pink':
            $hex_color = 0xFF99CC;
            break;
        case 'gray':
            $hex_color = 0x999999;
            break;
        default:
            $hex_color = 0xFFFFFF;// white
            break;
    endswitch;
    return $hex_color;
}


/**
 * @param string $password
 * @return bool|string
 */
function myHash(string $password)
{
    $salt = "24akjJ0340LJafkri3409jag";
    $options = [
        'cost' => 12,
        'salt' => $salt
    ];
    $hash_password = password_hash($password, PASSWORD_BCRYPT, $options);
    return $hash_password;
}


/**
 * @param string $pass
 * @return string
 */
function encrypt(string $pass)
{
    $key = 'y4Ialfaq019';
    $method = 'aes-128-cbc';
    $iv = '4823049582346724';// 16 bytes

    $code_password = openssl_encrypt ($pass, $method, $key, false, $iv);
    return $code_password;
}


/**
 * @param string $code_pass
 * @return string
 */
function decrypt(string $code_pass)
{
    $key = 'y4Ialfaq019';
    $method = 'aes-128-cbc';
    $iv = '4823049582346724';// 16 bytes

    $password = openssl_decrypt($code_pass, $method, $key, false, $iv);
    return $password;
}

/**
 * @param $param_pages
 * @return mixed
 */
function getParamsViewForUsers($param_pages)
{
    if ($result_array = array_shift($param_pages)) {
        if (!empty($result_array->title) || !empty($result_array->name_page) || !empty($result_array->count_images)
            || !empty($result_array->footer)) {
            $_SESSION['title'] = $result_array->title;
            $_SESSION['footer'] = $result_array->footer;
            $_SESSION['name_pages'] = $result_array->name_pages;
            $_SESSION['count_images'] = $result_array->count_images;
        }
    }
    return $result_array;
}
