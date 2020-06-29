# Laravel Vatlayer API

Laravel Vatlayer is a very small package which helps you connect your Laravel application with the [Vatlayer API](https://vatlayer.com/).

## Installation

Installation is very quick and easy. Install the package via Composer and you're ready to go.

```bash
composer require owowagency/vatlayer
```

## Setup

The package requires an API key from the Vatlayer API. You can request one [here](https://vatlayer.com/product). Once set up, you need to add the following config to your `services.php` config file:

```php
'vatlayer' => [
    'key' => env('VATLAYER_KEY'),
    'encrypted' => env('VATLAYER_ENCRYPTED', false)
],
```

You can now set your API key in your `.env` file. The `encrypted` boolean indicates if the API request should be made over https or http. This depends on the subscription plan you're using. If you're using the free plan you should set this variable to `false`, if you've a paid subscription, definitely set this variable to `true`.

## Usage

The package comes with a Facade helper to quickly call any of the methods. Currently the package only ships with two usable methods.

### Execute a validate request

To check if the VAT number has a valid format, valid value and to receive the name and address of the company which belongs to the VAT number you should call the `validate($vatNumber)` method.

```php
$response = \Vatlayer::validate('NL123456789B01');

// The response looks like: 
$response = [
  'valid' => true,
  'format_valid' => true,
  'query' => 'NL123456789B01',
  'country_code' => 'NL',
  'vat_number' => '855020970B01',
  'company_name' => 'OWOW PROJECTS B.V.',
  'company_address' => ' FUUTLAAN 00014 UNIT E 5613AB EINDHOVEN ',
];
```

### Check VAT number 

To quickly check if a VAT number is valid use the `isValidVatNumber($vatNumber)` method. This method returns a boolean to check if the number has a valid format and is a known European VAT number.

```php
$valid = \Vatlayer::isValidVatNumber('NL123456789B01');
```
