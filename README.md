# imaginacms-iwebhooks

## Install
```bash
composer require imagina/iwebhooks=v10.x-dev
```

## Enable the module
```bash
php artisan module:enable Iwebhooks
```

## JOB
Add the following name to the queue: bulk | Example: --queue=bulk

## URL Testing Webhooks

- Create a Category
- Create a Hook
    - API Url you can add this:

```bash
siteurl/api/iwebhooks/v1/bulk/chunk-result
```

Check results in log.