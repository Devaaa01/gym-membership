# Railway Deployment Guide

This project is a Laravel 10 application that uses MySQL, so the simplest Railway setup is:

- one Laravel app service
- one Railway MySQL database service
- an optional volume for uploaded profile photos

## 1. Push the app to GitHub

Railway can deploy directly from a GitHub repository. Make sure `.env` is not committed.

## 2. Create a Railway project

1. Open Railway.
2. Create a new project.
3. Choose **Deploy from GitHub repo**.
4. Select this repository.

Railway should use the included `Dockerfile`.

## 3. Add MySQL

1. In the same Railway project, click **New**.
2. Add a **MySQL** database.
3. Wait until the MySQL service finishes deploying.

## 4. Add Laravel variables

Open the Laravel app service, then go to **Variables** and add:

```env
APP_NAME="Gym Membership"
APP_ENV=production
APP_KEY=base64:replace_this_with_your_key
APP_DEBUG=false
APP_URL=https://${{RAILWAY_PUBLIC_DOMAIN}}
PORT=80

DB_CONNECTION=mysql
DB_HOST=${{MySQL.MYSQLHOST}}
DB_PORT=${{MySQL.MYSQLPORT}}
DB_DATABASE=${{MySQL.MYSQLDATABASE}}
DB_USERNAME=${{MySQL.MYSQLUSER}}
DB_PASSWORD=${{MySQL.MYSQLPASSWORD}}

SESSION_DRIVER=cookie
CACHE_DRIVER=file
QUEUE_CONNECTION=sync
FILESYSTEM_DISK=public
LOG_CHANNEL=stderr
```

If your MySQL service has a different name, use Railway's autocomplete for the `MySQL.*` references.

Generate the app key locally with:

```bash
php artisan key:generate --show
```

Use the generated value as `APP_KEY`.

## 5. Deploy

Click **Deploy** on the app service.

On startup, `docker-start.sh` will:

1. configure Apache for Railway's `PORT`
2. run migrations
3. seed the database if the `users` table is empty
4. create the Laravel storage symlink
5. start Apache

Default seeded admin login:

```text
Email: admin@fitlife.com
Password: password
```

Change this password after the first login.

## 6. Generate a public domain

1. Open the Laravel app service.
2. Go to **Settings**.
3. Open **Networking**.
4. Click **Generate Domain**.
5. Set the domain's **Target Port** to `80` if Railway asks for one.
6. Redeploy once after the domain appears, so `APP_URL` resolves correctly.

## 7. Persist uploaded photos

The app stores uploaded photos under Laravel's public storage disk. To keep uploads after redeploys:

1. Add a Railway volume to the Laravel app service.
2. Set the mount path to:

```text
/var/www/html/storage/app/public
```

Without this volume, uploaded photos can disappear when the container is replaced.

## 8. Troubleshooting

If the app fails to boot, check the Railway deploy logs first.

Common issues:

- Missing `APP_KEY`
- MySQL variable references use the wrong service name
- The MySQL service is still deploying
- Uploaded files are missing because no volume is mounted

Useful Railway docs:

- Laravel: https://docs.railway.com/guides/laravel
- MySQL: https://docs.railway.com/databases/mysql
- Variables: https://docs.railway.com/variables
- Public networking: https://docs.railway.com/public-networking
- Volumes: https://docs.railway.com/volumes
