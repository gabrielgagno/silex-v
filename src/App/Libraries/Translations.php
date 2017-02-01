<?php


namespace App\Libraries;

use Silex\Application;

class Translations
{
    protected $_path = __DIR__."/../../config/lang/";
    protected $_app;
    protected $_lang;

    public function __construct(){

      $this->_app  = Util::getApp();
      $this->_lang = $this->getLanguage();
      $this->loadTranslations();

    }

    public static function get($default = "generic.welcome"){

      $translations = self::formatMessage($default);
      $retrieved    = self::retrieveTranslations($translations);
      return $retrieved;
    }

    public function retrieveTranslations($translation){
        $lang_path = ROOT."config/lang";
        $path  =  implode("/" ,array(
                    $lang_path,
                    $translation["lang"],
                    $translation["module"],
                    $translation["type"].".php"
                    )
                  );
        $result = include($path);
      return $result[$translation["subtype"]];
    }

    public function formatMessage($message){

      $message = explode('.' , $message);

      if(count($message) == 4){
        return [
            "lang"         => $message[0],
            "module"       => $message[1],
            "type"         => $message[2],
            "subtype"      => $message[3],
        ];
      } else if (count($message) == 3){
        return [
            "lang"         => $message[0],
            "module"       => $message[1],
            "type"         => "messages",
            "subtype"      => $message[3],
          ];
      } else if (count($message) == 2){
        return [
            "lang"         => "en",
            "module"       => $message[0],
            "type"         => "messages",
            "subtype"      => $message[1],
          ];
      }
    }

  }
