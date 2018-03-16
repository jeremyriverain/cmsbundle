Warning
=======

This project is not stable at all. In fact, the bundle is very helpful in my proper workflow, to build websites faster. It extracts my own logic when I build some admin dashboard and it is very opinionated and probably not convenient for your usage. Despite this warning, if you want to use it anyway, copy it and make your own bundle based on that!

Installation
============

### Step 1: Install Symfony and download the CMS Bundle

If you definitly want to use this bundle, I strongly recommend to install it at the beginning of your project because cmsbundle relies heavily on overrides of controllers, routes. It will probably mess your project up if you install it in the middle of it. So, ideally first step: install Symfony.

```console
$ composer create-project symfony/website-skeleton my-project
```

Then, enter your project directory and execute the following command to download the latest stable version of this bundle:

```console
$ composer require geekco/cmsbundle:dev-master
```

This command requires you to have Composer installed globally, as explained
in the [installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

### Step 2: Import routes

```yaml
# config/routes.yaml

logout:
    path: /deconnexion

geekco_cms_bundle:
    resource: '@GeekcoCmsBundle/Controller/'
    type: annotation
```

### Step 3: change the locale if you are not english native speaker (like me)

``` yaml
# config/services.yml
parameters:
    locale: 'fr'
```

### Step 4: Load the services

```yaml
// config/services.yaml
services:
    Geekco\CmsBundle\:
        resource: '../vendor/geekco/cmsbundle/src/*'
        exclude: '../vendor/geekco/cmsbundle/src/{Entity,Migrations,Tests,Kernel.php}'

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

### Step 5: Create the configuration file

```yaml
# config/packages/geekco_cms.yaml
geekco_cms:
    targetDir_relative: 'cms/uploads'
    targetDir: '%kernel.project_dir%/public/cms/uploads'
```

### Step 6: Update some configuration's symfony packages

```yaml
# config/packages/framework.yaml
framework:
    # ...
    csrf_protection: true
    assets:
        packages:
            geekco_cms:
                base_path: /bundles/geekcocms/
                json_manifest_path: '%kernel.project_dir%/public/bundles/geekcocms/build/manifest.json'
```

### Step 7: Configure security.yaml

```yaml
security:
    role_hierarchy:
        ROLE_ADMIN:       ROLE_USER
        ROLE_SUPER_ADMIN: [ROLE_USER, ROLE_ADMIN, ROLE_ALLOWED_TO_SWITCH]
    encoders:
        Geekco\CmsBundle\Entity\User:
            algorithm: bcrypt
    # https://symfony.com/doc/current/security.html#where-do-users-come-from-user-providers
    providers:
        our_db_provider:
            entity:
                class: Geekco\CmsBundle\Entity\User
    firewalls:
        dev:
            pattern: ^/(_(profiler|wdt)|css|images|js)/
            security: false
        main:
            pattern:    ^/
            user_checker: Geekco\CmsBundle\Security\UserChecker
            http_basic: ~
            provider: our_db_provider
            switch_user: ~

            anonymous: ~

            # https://symfony.com/doc/current/security/form_login_setup.html
            form_login:
                login_path: geekco_cms_connexion
                check_path: geekco_cms_connexion
                csrf_token_generator: security.csrf.token_manager

            logout:
                path: /deconnexion
                target: /

    access_control:
        - { path: ^/admin, roles: ROLE_ADMIN }
```

### Step 8: Load the entities

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

Then create your database (don't forget to check the DATABASE_URL in .env). And update your database schema with those commands:


```console
$ bin/console doctrine:database:create
$ bin/console doctrine:database:diff
$ bin/console doctrine:database:migrate
```


### Step 9: configure the mailer env parameter

In order to reset a password when it's requested by an admin, you must configure the MAILER_URL in your .env file located at the root of your project. If you use gmail, it could be:

```lang
MAILER_URL=gmail://gmail_username:gmail_password@localhost?encryption=tls&auth_mode=oauth
```

### Step 10: symlink the assets

```console
$ bin/console assets:install --symlink
```
