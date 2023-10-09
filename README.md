Steps to Install

1. Composer install

2. npm install && npm run dev

3. Set MAIL_SMTP Credentials in .env like below.
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=asadmansuri6797@gmail.com
MAIL_PASSWORD=####
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESSasadmansuri6797@gmail.com
MAIL_FROM_NAME="${APP_NAME}"

4. Run php artisan db:seed

After above done,

Visit this Route: {APP_URL}/tickets

Demo User: asadmansuri6797@gmail.com | 12345678
