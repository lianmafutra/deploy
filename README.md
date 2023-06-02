# Laravel GIT-FTP
A Simple Package for Deployment Laravel App with Git FTP Method, Easy Configuration, Tagging Log Deploy, Rollback Deploy, CI/CD 
Documentation is in progress ...

![Screenshot_1](https://github.com/lianmafutra/deploy/assets/15800599/a11b75ff-9a10-4dfe-a80a-4bd11c489677)


## Installation
Require this package with composer. It is recommended to only require the package for development.
1. Install with Composer 
```bash
composer require lianmafutra/deploy --dev
```
2. First publish config and console command into your app directory', by running the following command:
```bash
php artisan vendor:publish --provider="LianMafutra\Deploy\LibraryServiceProvider" --tag=deploy
```
will be create file : app/Console/Commands/Deploy.php , app/Console/Commands/DeploySetup.php, config/deploy.php

## Package Configuration
1. In your .env file, add the your SSH server host production and ftp account :

```bash
#Sample Configuration
DEPLOY_HOST="103.31.xx.xx"
DEPLOY_PORT="21"
DEPLOY_PATH="/www/wwwroot/myproject/"
DEPLOY_USER="root"
DEPLOY_PASS=""

FTP_URL="03.31.xx.xx"
FTP_USER="ftp_user"
FTP_PASS="ftp_pass"
```
2. Run Command Setup :
```bash
php artisan deploy:setup
```

![Screenshot_4](https://github.com/lianmafutra/deploy/assets/15800599/08895301-46ff-4a30-8fc2-df5c015bc5c0)

your done to complete configuration

## Usage

1. Run Command Terminal :

```bash
php artisan deploy
```

2. Terminal Show Option  

![Screenshot_5](https://github.com/lianmafutra/deploy/assets/15800599/72493c7d-bc68-48c9-bf6a-6e8c1835f3c9)

- [1] ###Deploy Full : Push New Commit file with GIT FTP, and Auto run command php artisan down, php artisan optimize, view:clear, view:cache finally php artisan up 
- [2] ###Only Optimize : No Push commit, only run optimize 
- [3] ###Rollback Previous : Rollback GIT locally and push to server , you can fix in local and push again

## Contributing

Pull requests are welcome. For major changes, please open an issue first
to discuss what you would like to change.

Please make sure to update tests as appropriate.

## License

[MIT](https://choosealicense.com/licenses/mit/)
