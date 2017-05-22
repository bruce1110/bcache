<?php

namespace configs;

class config
{
     private static $configs = null;
     public static function getServers($driver)
     {
          self::$configs = empty(self::$configs)?parse_ini_file('/work/bcache/configs/memcached.ini', true) : self::$configs;
          $servers = array();
          foreach(self::$configs[$driver] as $v)
          {
               $servers[] = array($v['host'], $v['port'], $v['weight']);
          }
          return $servers;
     }


     public static function getOptions()
     {
          self::$configs = empty(self::$configs)?parse_ini_file('/work/bcache/configs/memcached.ini', true) : self::$configs;
          return self::$configs['options'];
     }
}
