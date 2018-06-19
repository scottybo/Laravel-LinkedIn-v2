### Linkedin API v2 integration for Laravel Framework

DO NOT USE - STILL IN DEVELOPMENT

This package is a wrapper for [Scottybo/LinkedIn-API-client-v2](https://github.com/scottybo/Laravel-LinkedIn-v2).
You can view the documentation for php version [here](https://github.com/scottybo/LinkedIn-API-client-v2/blob/master/README.md). Don't forget to consult the oficial [LinkedIn API](https://developer.linkedin.com/) site.

###### If you need install on Lumen, go to [Lumen section](#installation-on-lumen)

### Installation on Laravel

##### Install with composer
```bash
composer require scottybo/laravel-linkedin-v2
```

##### Add service Provider
```
Scottybo\LinkedIn\LinkedinServiceProviderV2::class,
```

##### Facade
```
'LinkedInV2'  => \Scottybo\LinkedIn\Facades\LinkedInV2::class,
```

##### Publish config file
```
php artisan vendor:publish --provider="Scottybo\LinkedIn\LinkedinServiceProviderV2"
```

### Installation on Lumen

##### Install with composer
```bash
composer require scottybo/laravel-linkedin-v2
```

##### Add Service Provider, facade and config parameters to the `bootstrap/app.php` file and copy the [linkedin.php](https://github.com/scottybo/laravel-linkedin-v2/blob/master/src/Scottybo/LinkedIn/config/linkedin-v2.php) to the config directory of your project (create then if not exists)
```php
$app->register(\Scottybo\LinkedIn\LinkedinServiceProviderV2::class);
class_alias(\Scottybo\LinkedIn\Facades\LinkedInV2::class,'LinkedInV2');

$app->configure('linkedin-v2');
```

### Usage

In order to use this API client (or any other LinkedIn clients) you have to [register your app](https://www.linkedin.com/developer/apps) 
with LinkedIn to receive an API key. Once you've registered your LinkedIn app, you will be provided with
an *API Key* and *Secret Key*, please fill this values on `linkedin.php` config file.

####Basic Usage
The unique difference in this package is the `LinkedInV2` facade. Instead of this:
```php
$linkedIn=new ScottyBo\LinkedIn\LinkedIn('app_id', 'app_secret');
$linkedin->foo();
```
you can simple call the facade for anyone method, like this:
```php
LinkedInV2::foo();
```
or use the laravel container:
```php
app('linkedin-v2')->foo();
app()['linkedin-v2']->foo();
App::make('linkedin-v2')->foo(); // ...
```

The service container automatically return an instance of `LinkedInV2` class ready to use

#### LinkedIn login

This example below is showing how to login with LinkedIn using `LinkedIn` facade.

```php 
if (LinkedInV2::isAuthenticated()) {
     //we know that the user is authenticated now. Start query the API
     $user=LinkedIn::get('v2/me');
     echo  "Welcome ".$user['firstName'];
     exit();
}elseif (LinkedInV2::hasError()) {
     echo  "User canceled the login.";
     exit();
}

//if not authenticated
$url = LinkedInV2::getLoginUrl();
echo "<a href='$url'>Login with LinkedIn</a>";
exit();
```


#### Get basic profile info
You can retrive information using the `get()` method, like this:
```php
LinkedIn::get('v2/me');
```
This query return an array of information. You can view all the `REST` api's methods in [REST API Console](https://apigee.com/console/linkedin)

#### How to post on LinkedIn wall

The example below shows how you can post on a users wall. The access token is fetched from the database. 

```php
LinkedInV2::setAccessToken('access_token_from_db');

$options = ['json'=>
     [
        'comment' => 'Im testing Scottybo LinkedIn v2 client with Laravel Framework! https://github.com/scottybo/laravel-linkedin-v2',
        'visibility' => [
               'code' => 'anyone'
        ]
     ]
];

$result = LinkedIn::post('v2/people/~/shares', $options);
```


You may of course do the same in xml. Use the following options array.
```php
$options = array(
'format' => 'xml',
'body' => '<share>
 <comment>Im testing Scottybo LinkedIn v2 client with Laravel Framework! https://github.com/scottybo/laravel-linkedin-v2</comment>
 <visibility>
   <code>anyone</code>
 </visibility>
</share>');
```

## Configuration

### The api options

The third parameter of `LinkedInV2::api` is an array with options. Below is a table of array keys that you may use. 

| Option name | Description
| ----------- | -----------
| body | The body of a HTTP request. Put your xml string here. 
| format | Set this to 'json', 'xml' or 'simple_xml' to override the default value.
| headers | This is HTTP headers to the request
| json | This is an array with json data that will be encoded to a json string. Using this option you do need to specify a format. 
| response_data_type | To override the response format for one request 
| query | This is an array with query parameters



### Changing request format

The default format when communicating with LinkedIn API is json. You can let the API do `json_encode` for you. 
The following code shows you how. 

```php
$body = array(
    'comment' => 'Testing the linkedin v2 API!',
    'visibility' => array('code' => 'anyone')
);

LinkedInV2::post('v1/people/~/shares', array('json'=>$body));
LinkedInV2::post('v1/people/~/shares', array('body'=>json_encode($body)));
```

When using `array('json'=>$body)` as option the format will always be `json`. You can change the request format in three ways.

```php
// By setter
LinkedInV2::setFormat('xml');

// Set format for just one request
LinkedInV2::post('v1/people/~/shares', array('format'=>'xml', 'body'=>$body));
```


### Understanding response data type

The data type returned from `LinkedIn::api` can be configured. You may use the
`LinkedInV2::setResponseDataType` or as an option for `LinkedInV2::api`

```php
// By setter
LinkedInV2::setResponseDataType('simple_xml');

// Set format for just one request
LinkedInV2::get('v2/me', array('response_data_type'=>'psr7'));

```

Below is a table that specifies what the possible return data types are when you call `LinkedIn::api`.

| Type | Description
| ------ | ------------
| array | An assosiative array. This can only be used with the `json` format.
| simple_xml | A SimpleXMLElement. See [PHP manual](http://php.net/manual/en/class.simplexmlelement.php). This can only be used with the `xml` format.
| psr7 | A PSR7 response.
| stream | A file stream.
| string | A plain old string.

### Using different scopes

If you want to define special scopes when you authenticate the user you should specify them when you are generating the 
login url. If you don't specify scopes LinkedIn will use the default scopes that you have configured for the app.  

```php
$scope = 'r_fullprofile,r_emailaddress,w_share';
//or 
$scope = array('rw_groups', 'r_contactinfo', 'r_fullprofile', 'w_messages');

$url = LinkedInV2::getLoginUrl(array('scope'=>$scope));
return "<a href='$url'>Login with LinkedIn</a>";
```

#### Changelog

You can view the latest changes [here](https://github.com/scottybo/laravel-linkedin-v2/blob/master/CHANGELOG.md)
