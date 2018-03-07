Warning
=======

The project is not stable yet. So be careful and don't use it for production usage, unless you are adventurous!

Installation
============

### Step 1: Download the Bundle

Open a command console, enter your project directory and execute the following command to download the latest stable version of this bundle:

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
```

### Step 3: Import routes

```yaml
# config/routes.yaml
geekco_cms_bundle:
    resource: '@GeekcoCmsBundle/Controller/'
    type: annotation
```

### Step 4: Load the entities

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
```

### Step 5: Load the services

```yaml
// config/services.yaml
services:
    Geekco\CmsBundle\:
        resource: '../vendor/geekco/cmsbundle/src/*'
        exclude: '../vendor/geekco/cmsbundle/{Entity,Migrations,Tests,Kernel.php}'

    Geekco\CmsBundle\Controller\:
        resource: '../vendor/geekco/cmsbundle/src/Controller'
        tags: ['controller.service_arguments']

    Geekco\CmsBundle\EventListener\PageListener:
        tags:
            - { name: doctrine.event_listener, event: prePersist, lazy: true}
            - { name: doctrine.event_listener, event: preUpdate, lazy: true }
    Geekco\CmsBundle\EventListener\ResourceListener:
        tags:
            - { name: doctrine.event_listener, event: prePersist, lazy: true }
            - { name: doctrine.event_listener, event: postUpdate, lazy: true }
    Geekco\CmsBundle\Services\FileUploader:
        arguments:
            $targetDir: "%geekco_cms.targetDir%"

    Geekco\CmsBundle\Twig\TwigExtension:
        arguments:
            $targetDir: "%geekco_cms.targetDir%"
            $targetDir_relative: "%geekco_cms.targetDir_relative%"

    Geekco\CmsBundle\EventListener\ImageResourceListener:
        tags:
            - { name: doctrine.event_listener, event: prePersist, lazy: true}
            - { name: doctrine.event_listener, event: preUpdate, lazy: true}
            - { name: doctrine.event_listener, event: postLoad, lazy: true}
            - { name: doctrine.event_listener, event: preRemove, lazy: true}

    Geekco\CmsBundle\Services\ModuleManager:
        arguments:
            $targetDir: "%geekco_cms.targetDir%"
            $pathFixturesImg: "%kernel.project_dir%/src/DataFixtures/images/"
```

### Step 6: Create the configuration file

```yaml
# config/packages/geekco_cms.yaml
geekco_cms:
    targetDir_relative: 'cms/uploads'
    targetDir: '%kernel.project_dir%/public/cms/uploads'

twig:
    paths:
        '%kernel.project_dir%/vendor/geekco/cmsbundle/src/Resources/views': geekco_cms
```
