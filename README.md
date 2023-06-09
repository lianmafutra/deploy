# Laravel GIT-FTP
A Simple Package for Deployment Laravel App with Git FTP Server Method and SSH Server, Easy Configuration, Rollback Deploy, CI/CD 

![Screenshot 2023-07-03 115658](https://github.com/lianmafutra/deploy/assets/15800599/ce362e8d-d9d6-47c1-b429-458002cab4d7)

![Screenshot_1](https://github.com/lianmafutra/deploy/assets/15800599/a11b75ff-9a10-4dfe-a80a-4bd11c489677)

## Requirement
Before using this package you must install and running GIT-FTP in your Local System https://github.com/git-ftp/git-ftp](https://github.com/git-ftp/git-ftp/blob/master/INSTALL.md

## Installation
Require this package with composer. It is recommended to only require the package for development.
1. Install with Composer 
```bash
composer require lianmafutra/deploy --dev
```
2. First publish config and console command into your app directory', by running the following command:
```bash
php artisan vendor:publish --provider="LianMafutra\Deploy\LibraryServiceProvider" --tag=deploy --force
```
will be create file : ```app/Console/Commands/Deploy.php``` , ```app/Console/Commands/DeploySetup.php```, ```config/deploy.php```

## Package Configuration
1. In your ```.env``` file, add the your SSH server host production and FTP account :

```bash
#Sample Configuration
DEPLOY_HOST=103.31.xx.xx
DEPLOY_PORT=22
DEPLOY_PATH="/www/wwwroot/myproject/"
DEPLOY_USER=root
DEPLOY_PASS=ssh_password

FTP_URL=103.31.xx.xx
FTP_USER=ftp_user
FTP_PASS=ftp_pass
```
2. Run Command Setup, to test configuration :
```bash
php artisan deploy:setup
```
![Screenshot_4](https://github.com/lianmafutra/deploy/assets/15800599/08895301-46ff-4a30-8fc2-df5c015bc5c0)

Setup is complete !

3. you can custom command deploy in ```config/deploy.php``` , default command like this :

```
  'command-first-deploy' => [
      'composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev',
      'php artisan down',
      'php artisan optimize',
      'php artisan storage:link',
      'php artisan migrate --force',
      'php artisan auth:clear-resets',
      'php artisan view:clear',
      'php artisan view:cache',
      'php artisan up'
   ],
   'command-deploy' => [
      'composer install --prefer-dist --no-scripts -q -o',
      'php artisan down',
      'php artisan optimize',
      'php artisan view:clear',
      'php artisan view:cache',
      'php artisan up'
   ],
   'command-optimize' => [
      'php artisan down',
      'php artisan optimize',
      'php artisan view:clear',
      'php artisan view:cache',
      'php artisan up'
   ]
```

## Usage

1. Run Command Terminal :

```bash
php artisan deploy
```

2. Terminal Show Option, Select option with type number :

![Screenshot 2023-07-03 115658](https://github.com/lianmafutra/deploy/assets/15800599/ce362e8d-d9d6-47c1-b429-458002cab4d7)

- [1] ``` First Deploy ``` : First Upload Project to server   
- [2] ``` Deploy Push ``` : Push New Commit file with GIT FTP and Auto run command through SSH server with command ```php artisan down```, ```php artisan optimize```, ```php artisan view:clear```, ```php artisan view:cache``` finally ```php artisan up```
- [3] ``` Only Optimize ``` : No Push commit, only run optimize in production
- [4] ``` Rollback Previous ``` : Rollback last commit in GIT locally and push to server production, you can fix in local with default branch and push again after fix

## Note
If you have error/failed to first git ftp init or first deploy, you must check this pull request git-ftp core error fix ( out of memory curl ), open git-ftp file and change it 
like this pull request https://github.com/git-ftp/git-ftp/pull/638


## Contributing

Pull requests are welcome. For major changes, please open an issue first
to discuss what you would like to change.

Please make sure to update tests as appropriate.

## License

[MIT](https://choosealicense.com/licenses/mit/)
