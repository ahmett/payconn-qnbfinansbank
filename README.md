<p align="center"><img src="https://user-images.githubusercontent.com/12511137/80864283-581ea400-8c8a-11ea-8bdd-ea37da892af8.jpg" width="300"></p>

<h3 align="center">Payconn: QNB Finansbank</h3>

<p align="center">QNB Finansbank gateway for Payconn payment processing library</p>

<p align="center">
  <a href="https://travis-ci.org/ahmett/payconn-qnbfinansbank"><img src="https://travis-ci.org/ahmett/payconn-qnbfinansbank.svg" alt="Build Status"></a>
  <a href="https://packagist.org/packages/ahmett/payconn-qnbfinansbank"><img src="https://poser.pugx.org/ahmett/payconn-qnbfinansbank/d/total.svg" alt="Total Downloads"></a>
  <a href="https://packagist.org/packages/ahmett/payconn-qnbfinansbank"><img src="https://poser.pugx.org/ahmett/payconn-qnbfinansbank/v/stable.svg" alt="Latest Stable Version"></a>
  <a href="https://packagist.org/packages/ahmett/payconn-qnbfinansbank"><img src="https://poser.pugx.org/ahmett/payconn-qnbfinansbank/license.svg" alt="License"></a>
</p>

<hr>

<p align="center">
<b><a href="#installation">Installation</a></b>
|
<b><a href="#supported-methods">Supported Methods</a></b>
|
<b><a href="#basic-usages">Basic Usages</a></b>
</p>
<hr>

[Payconn](https://github.com/payconn/common) is a framework agnostic, multi-gateway payment
processing library for PHP. This package implements common classes required by Payconn.

## Installation

    $ composer require ahmett/payconn-qnbfinansbank

## Supported Methods
* **purchase** : authorize and immediately capture an amount
* **authorize** : authorize an amount on the customer's card
* **complete** : capture an amount you have previously authorized
* **refund** : refund an already processed transaction
* **cancel** : cancel an already processed transaction, this generally can only be called up to 24 hours after submitting a transaction

## Basic Usages

#### Purchase Action:

```php
use Payconn\Common\CreditCard;
use Payconn\QNBFinansbank\Token;
use Payconn\QNBFinansbank\Currency;
use Payconn\QNBFinansbank\Model\Purchase;
use Payconn\QNBFinansbank;

$token = new Token('MERCHANT_ID', 'MERCHANT_PASS', 'USER_CODE', 'USER_PASS');
$creditCard = new CreditCard('NUMBER', 'EXPIRE_YEAR', 'EXPIRE_MONTH', 'CVV');
$purchase = new Purchase();

$purchase->setTestMode(true);
$purchase->setCurrency(Currency::TRY);
$purchase->setAmount(1);
$purchase->setInstallment(0);
$purchase->setCreditCard($creditCard);
$purchase->generateOrderId();

$response = (new QNBFinansbank($token))->purchase($purchase);

if ( $response->isSuccessful() ) {
    // success!
}
```

Take a look at *samples* folder for more usage examples.

## Support

If you believe you have found a bug, please report it using the [GitHub issue tracker](https://github.com/ahmett/payconn-qnbfinansbank/issues),
or better yet, fork the library and submit a pull request.

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.