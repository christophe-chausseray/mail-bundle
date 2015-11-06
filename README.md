[![SensioLabsInsight](https://insight.sensiolabs.com/projects/a54ada4d-0519-4b9e-85ae-fc6e124b165d/big.png)](https://insight.sensiolabs.com/projects/a54ada4d-0519-4b9e-85ae-fc6e124b165d)

# Mail Bundle

Installation
============

Step 1: Download the Bundle
---------------------------

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```bash
$ composer require chris13/mail-bundle "~1"
```

This command requires you to have Composer installed globally, as explained
in the [installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

Step 2: Enable the Bundle
-------------------------

Then, enable the bundle by adding it to the list of registered bundles
in the `app/AppKernel.php` file of your project:

```php
<?php
// app/AppKernel.php

// ...
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            // ...

            new Chris\Bundle\MailBundle\MailBundle(),
        );

        // ...
    }

    // ...
}
```

Step 3 : Configure the bundle
-----------------------------

Add the following configuration to your config.yml

```yml
mail:
    sendgrid:
        user: sendgrid_user
        password: sendgrid_pass
```

Usage
=====

For SendGrid :

```php
<?php

$categories = array('category1');

$mailer = $this->get('mail_bundle.send_grid_mailer');
$mailer->setCategories($categories)
       ->prepare($from, $to, $subject, $body)
       ->send();
```

For SwiftMailer :

```php
<?php

$mailer = $this->get('mail_bundle.swift_mailer');
$mailer->prepare($from, $to, $subject, $body)
       ->send();
```
