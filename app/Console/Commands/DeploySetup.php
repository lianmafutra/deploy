<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use phpseclib3\Net\SSH2;

class DeploySetup extends Command
{
   /**
    * The name and signature of the console command.
    *
    * @var string
    */
   protected $signature = 'deploy:setup';

   /**
    * The console command description.
    *
    * @var string
    */
   protected $description = 'setup test configuration config/deploy.php';

   /**
    * Execute the console command.
    *
    * @return int
    */
   public function handle()
   {

   
      $ssh = new SSH2(config('deploy.server.host'), '22');

      $path_project = config('deploy.server.path');

      if (!$ssh->login(config('deploy.server.username'), config('deploy.server.password'))) {
         return $this->line("\n <bg=red> Login SSH failed  </>\n");
      } else {
         $this->line("\n<bg=green>- Test Connect & Login to Server Success  </>\n");
      }

      try {

         if (!extension_loaded('ftp')) {
            return $this->line("<bg=red> - FTP extension is not loaded!</>\n");
         }

         $con = ftp_connect(config('deploy.git-ftp.url'), 21, 10);
         if (false === $con) {
            throw new Exception('Unable to connect to FTP Server.');
         }
         $loggedIn = ftp_login($con,  config('deploy.git-ftp.user'),  config('deploy.git-ftp.password'));
         ftp_close($con);
         if (true === $loggedIn) {
            $this->line("<bg=green>- Git FTP connect to server success  </>\n");
         } else {
            $this->line("<bg=red>- Git FTP connect to server Failed  </>\n");
         }
      } catch (\Throwable $th) {
         $this->line("<bg=red>- Git FTP connect to server Failed, check " . $th->getMessage() . "</>\n");
      }

      // setup git-ftp config from config/deploy.php
      $git_ftp_url = exec('git config git-ftp.url ' . config('deploy.git-ftp.url'), $outputLines, $return);
      $git_ftp_user = exec('git config git-ftp.user ' . config('deploy.git-ftp.user'), $outputLines, $return);
      $git_ftp_pass = exec('git config git-ftp.password ' . config('deploy.git-ftp.password'), $outputLines, $return);

      $this->line("Git FTP URL = " . config('deploy.git-ftp.url') . " \n");
      $this->line("Git FTP User = " . config('deploy.git-ftp.user') . " \n");
      $this->line("Git FTP Password = " . config('deploy.git-ftp.password') . " \n");


      try {
         $git_ftp_cek = exec('git ftp show 2>&1', $outputLines, $return);

         $check = strpos($return, "fatal: bad object");
         if ($check) {
            $this->line("<bg=red> Git ftp not init this project");
         
         } else {
            $this->line("Git ftp running in this project");
         }
      } catch (\Throwable $th) {
         //throw $th;
      }
   }
}
