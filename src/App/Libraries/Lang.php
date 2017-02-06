<?php


namespace App\Libraries;

use Silex\Application;
use Exception;

class Lang
{
    protected $_path = __DIR__."/../../config/lang/";
    protected $_app;
    protected $_lang;

    public function __construct(){

      $this->_app  = Util::getApp();
      $this->loadTranslations();

    }
    /**
     * Returns messages from parameter($message)
     * usage : $message = Lang::get("en.generic.messages.developer_message");
     * @param $message
     * @return string message
     */
    public static function get($message){

      $messageArray = self::formatMessage($message);
      $retrieved    = self::retrieveLang($messageArray);
      return $retrieved;
    }
    /**
     * Retrieve messages from file
     * @param $message
     * @return string message
     */
    public function retrieveLang($messageArray){
        $lang_path = ROOT."config/lang";
        $path  =  implode("/" ,array(
                    $lang_path,
                    $messageArray["lang"],
                    $messageArray["module"],
                    $messageArray["type"].".php"
                    )
                  );
        $result = include($path);
        $message = $messageArray["subtype"];
        self::checkFileExistence($path,$result);
        self::checkMessageExistence($message, $path , $result);
        return $result[$messageArray["subtype"]];
    }
    /**
     * Formats string to array
     * @param $message
     * @return array
     * "lang"         => LANGUAGE,
     * "module"       => MODULE NAME,
     * "type"         => FILENAME/SUBGROUP,
     * "subtype"      => MESSAGE/KEY,
     */
    public function formatMessage($message){

      $formattedMessage = explode('.' , $message);

      switch(count($formattedMessage)){
        case 1:
                return [
                    "lang"         => DEFAULT_LANGUAGE,
                    "module"       => DEFAULT_LANGUAGE_MODULE,
                    "type"         => DEFAULT_MESSAGE_SUBGROUP,
                    "subtype"      => $formattedMessage[1],
                  ];
        break;
        case 2:
                return [
                    "lang"         => DEFAULT_LANGUAGE,
                    "module"       => $formattedMessage[0],
                    "type"         => DEFAULT_MESSAGE_SUBGROUP,
                    "subtype"      => $formattedMessage[1],
                  ];
        break;
        case 3:
                return [
                    "lang"         => $formattedMessage[0],
                    "module"       => $formattedMessage[1],
                    "type"         => DEFAULT_MESSAGE_SUBGROUP,
                    "subtype"      => $formattedMessage[3],
                  ];
          break;
        case 4:
                return [
                    "lang"         => $formattedMessage[0],
                    "module"       => $formattedMessage[1],
                    "type"         => $formattedMessage[2],
                    "subtype"      => $formattedMessage[3],
                ];
        break;
        default:
            throw new Exception('Invalid number of parameters ('.$message.') on '.Lang::class.'/formatMessage()');
        break;

      }

    }
    /**
     * Throws an Exception if the file does not exist
     * @param $result
     * @param $path
     * @return string message
     */
    public static function checkFileExistence($path , $result){
      if(!$result){
        throw new Exception('Unable to locate message file('.$path.').');
      }
    }

    /**
     * Throws an Exception message does not exist in the file
     * @param $message
     * @param $result
     * @param $path
     * @return string message
     */
    public static function checkMessageExistence($message, $path ,$result){
      if(is_null($result[$message])){
        throw new Exception(
        'Unable to locate message ('.$message.') in file('.$path.').');
      }
    }
  }
