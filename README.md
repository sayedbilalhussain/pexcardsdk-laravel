# PEXCARD SDK -PHP-laravel
Pex Cards PHP Laravel SDK 
Pex Cards PHP SDK
## Usage
- requirements 
```
Laravel >= 5.8
PHP >= 7.0
Guzzle >= 6.0
```
- Installation
```
composer require sayedbilalhussain/pexcardsdk-laravel
```

- Publish Config
```
php artisan vendor:publish
```
### After Publishing Mention Api Credentials
- Add PexCard Administrator Username and Password and required credentials in config/pex.php. 

## Auth Tokens / Api Auth Token/Key
- Create Token 
```
use SayedBilalHussain\PexCardSdk\Services\PexService;

$pexService = new PexService();
$pexService->generateUserToken() //this will return auth token
```
- Renew Token (Only one month prior to expiry)
[Implementation note](https://developer.pexcard.com/docs4#!/Token3258321032323232323232323232323232323232Manage32authentication32for32the32PEX32API4610323232323232323232323232/Token_RenewByAuthorizationPOSTToken_Renew)
```
use SayedBilalHussain\PexCardSdk\Services\PexService;

$pexService = new PexService();
$pexService->setToken(<token>);
$pexService->renewToken();
$pexService->getToken(); 
```
- Revoke/Logout from all created tokens

```
use SayedBilalHussain\PexCardSdk\Services\PexService;

$pexService = new PexService();
$pexService->revokeTokens();
```


- Revoke/Logout from specific token

```
use SayedBilalHussain\PexCardSdk\Services\PexService;

$pexService = new PexService();
$pexService->revokeToken(<token>);
```
- Detail of Tokens (Expiry/App)

```
use SayedBilalHussain\PexCardSdk\Services\PexService;

$pexService = new PexService();
$pexService->getTokenDetail(<token>); // this will return detail of all apps and related tokens with detail
```
