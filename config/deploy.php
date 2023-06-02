<?php
return [
   'server'=>[
      'host'     => env("DEPLOY_HOST"),
      'port'     => env("DEPLOY_PORT"),
      'path'     => env("DEPLOY_PATH"),
      'username' => env("DEPLOY_USER"),
      'password' => env("DEPLOY_PASS"),
   ],
   'git-ftp'=>[
      "url"      => env("FTP_URL"),
      "user"     => env("FTP_USER"),
      "password" => env("FTP_PASS"),
   ],
   'deploy'=>[
      "route_cache"      => true,
      "config_cache"     => true,
      "view_cache"       => true,
      "maintenance_mode" => true,
      "password"     => ""
   ]
];

