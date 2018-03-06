Warning
=======

The project is not stable yet. So be careful and don't use it for production usage, unless you are adventurous!

Installation
============

### Step 1: Download the Bundle

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```console
$ composer require geekco/cmsbundle:dev-master
```

This command requires you to have Composer installed globally, as explained
in the [installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

### Step 2: Enable the Bundle

Then, enable the bundle by adding it to the list of registered bundles
in the `config/bundles.php` file of your project:

```php
// config/bundles.php
<?php
return [
    Geekco\CmsBundle\GeekcoCmsBundle::class => ['all' => true],
];

### Step 3: Import routes

```yaml
# config/routes.yaml
geekco_cms_bundle:
    resource: '@GeekcoCmsBundle/Controller/'
    type: annotation

### Step 3: Load the entities

```yaml
// config/packages/doctrine.yaml
doctrine:
    orm:
        # ...
        mappings:
            Geekco_Cms:
                is_bundle: false
                type: annotation
                dir: '%kernel.project_dir%/vendor/geekco/cmsbundle/src/Entity'
                prefix: 'Geekco\CmsBundle\Entity'
                alias: Geekco_Cms

### Step 4: Load the services

```yaml
// config/services.yaml
services:
    Geekco\CmsBundle\:
        resource: '../vendor/geekco/cmsbundle/src/*'
        exclude: '../vendor/geekco/cmsbundle/{Entity,Migrations,Tests,Kernel.php}'

    Geekco\CmsBundle\Controller\:
        resource: '../vendor/geekco/cmsbundle/src/Controller'
        tags: ['controller.service_arguments']
