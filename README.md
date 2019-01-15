# VAT.fyi SDK PHP

## Installing SDK

The recommended way to install SDK is through
[Composer](http://getcomposer.org).

```bash
# Install Composer
curl -sS https://getcomposer.org/installer | php
```

Next, run the Composer command to install the latest stable version of SDK:

```bash
php composer.phar require richweber-technology/vatfyi-sdk-php
```

After installing, you need to require Composer's autoloader:

```php
require 'vendor/autoload.php';
```

You can then later update SDK using composer:

 ```bash
php composer.phar update
 ```

## Use

```php
use RichweberTechnology\vatfyi\Client;
use RichweberTechnology\vatfyi\components\Company;
use RichweberTechnology\vatfyi\components\VatNumber;

$client = new Client('YOUR_API_KEY');
$checker = new VatNumber($client);

$check = $checker->checkVatNumber('EE102001059');

echo $check . PHP_EOL;
echo $checker->isSuccess() . PHP_EOL;
echo $checker->isValidNumber() . PHP_EOL;
echo $checker->getErrorDescription() . PHP_EOL;

$company = $checker->getCompany();
if ($company instanceof Company) {
    echo $company->getCompanyName() . PHP_EOL;
    echo $company->getCountryCode() . PHP_EOL;
    echo $company->getCompanyAddress() . PHP_EOL;
    echo $company->getVatNumber() . PHP_EOL;
}
```

```php
use RichweberTechnology\vatfyi\Client;
use RichweberTechnology\vatfyi\components\Amount;
use RichweberTechnology\vatfyi\components\RateDto;
use RichweberTechnology\vatfyi\components\VatRate;

$client = new Client('YOUR_API_KEY');

$dto = new RateDto('EE', 123.45);
$checker = new VatRate($client);

$check = $checker->getVatRate($dto);

echo $check . PHP_EOL;
echo $checker->isSuccess() . PHP_EOL;
echo $checker->isVatNumberConfirmed() . PHP_EOL;
echo $checker->isVatNumberFailed() . PHP_EOL;
echo $checker->getVatNumberFailDescription() . PHP_EOL;
echo $checker->getErrorDescription() . PHP_EOL;

$company = $checker->getAmount();
if ($company instanceof Amount) {
    echo $company->getVAT() . PHP_EOL;
    echo $company->getAmount() . PHP_EOL;
    echo $company->getVatAmount() . PHP_EOL;
    echo $company->getTotalAmount() . PHP_EOL;
}
```
