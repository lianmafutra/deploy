<?php
namespace App\Console\Commands;
use Illuminate\Console\Command;
use phpseclib3\Net\SSH2;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Process\Process;
class Deploy extends Command
{
   protected $signature = 'deploy';
   public function __construct()
   {
      parent::__construct();
   }
   protected $description = '';
   public function handle()
   {
      if (config('deploy.server.port') == '') {
         $port = 22;
      } else {
         $port = config('deploy.server.port');
      }
      $ssh = new SSH2(config('deploy.server.host'), '22');
      $path_project = config('deploy.server.path');
      if (!$ssh->login(config('deploy.server.username'), config('deploy.server.password'))) {
         throw new \Exception('Login failed');
      }
     
      $choice = $this->choice(
         "Select Action ",
         [
            1 => 'First Deploy',
            2 => 'Deploy Push',
            3 => 'Only Optimize',
            4 => 'Rollback Previous',
         ],
      );
      if ($this->confirm('Are you sure you want to choose ' . $choice . '?', true)) {
         if ($choice == 'Deploy Push') {
            $this->info("Waiting to push ...");
            sleep(1.5);
            $this->output->progressStart(3);
           
            $this->info(PHP_EOL."git ftp start ...");
            $this->info("Running : git ftp push" . PHP_EOL);
            // Command to execute        
            $process = Process::fromShellCommandline('git ftp push');

            $process->setTimeout(null); 
            $process->run(function ($type, $output) {
               $this->output->write($output);
            });

            if (!$process->isSuccessful()) {
               $this->error(PHP_EOL . PHP_EOL . "git ftp push failed \n");
               return 1;
           } else {
               $this->line(PHP_EOL . PHP_EOL . "<bg=green> git ftp success </>\n");
               sleep(1.5);
               $commandList = config('deploy.command-deploy');
               foreach ($commandList as $key => $value) {
                  $this->info("Running : ".$value);
                  $this->info($ssh->exec('cd ' . $path_project . '&& echo "'.config('deploy.server.password').'" | sudo -S  ' . $value.' 2> /dev/null'));
               }
               $this->line("<bg=blue;options=blink;>  Success deploy to production  </>\n");
            }
         }
         if ($choice == 'Only Optimize') {
            $commandList = config('deploy.command-optimize');
            foreach ($commandList as $key => $value) {
               $this->info("Running : ".$value);
               $this->info($ssh->exec('cd ' . $path_project . '&& echo "'.config('deploy.server.password').'" | sudo -S  ' . $value.' 2> /dev/null'));
            }
         }
         if ($choice == 'Rollback Previous') {
            $previous_commit = "";
            $output = exec('git checkout HEAD~1 ' . $previous_commit, $outputLines, $return);
            $this->info("Waiting to push ...");
            sleep(1.5);
            $this->output->progressStart(3);
            for ($i = 0; $i < 3; $i++) {
               sleep(0.5);
               $this->output->progressAdvance();
            }
            $this->output->progressFinish();
            $this->info("git ftp start ...");
            $this->info("Running : git ftp push" . PHP_EOL);
            // Command to execute
             // Command to execute        
             $process = Process::fromShellCommandline('git ftp push');

             $process->setTimeout(null); 
             $process->run(function ($type, $output) {
                $this->output->write($output);
             });
             if (!$process->isSuccessful()) {
               $this->error(PHP_EOL . PHP_EOL . "git ftp push failed \n");
               return 1;
           }  else {
               $this->line(PHP_EOL . PHP_EOL . "<bg=green> git ftp success </>\n");
               sleep(1.5);
               $commandList = config('deploy.command-optimize');
               foreach ($commandList as $key => $value) {
                  $this->info("Running : ".$value);
                  $this->info($ssh->exec('cd ' . $path_project . '&& echo "'.config('deploy.server.password').'" | sudo -S  ' . $value.' 2> /dev/null'));
               } 
               sleep(2);
               $this->line("<bg=blue;options=blink;>  Success deploy to production  </>\n");
               $output = exec('git checkout master' . $previous_commit, $outputLines, $return);
            }
         }
         if ($choice == 'First Deploy') {
            $process = Process::fromShellCommandline('git ftp init');

            $process->setTimeout(null); 
            $process->run(function ($type, $output) {
               $this->output->write($output);
            });

            $commandList = config('deploy.command-first-deploy');
            foreach ($commandList as $key => $value) {
               $this->info("Running : ".$value);
               $this->info($ssh->exec('cd ' . $path_project . '&& echo "'.config('deploy.server.password').'" | sudo -S  ' . $value.' 2> /dev/null'));
            }
         }
      }
   }
}
