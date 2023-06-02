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

## Configuration
1. open .env file and setting with your server host production and ftp account

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

## Contributing

Pull requests are welcome. For major changes, please open an issue first
to discuss what you would like to change.

Please make sure to update tests as appropriate.

## License

[MIT](https://choosealicense.com/licenses/mit/)
