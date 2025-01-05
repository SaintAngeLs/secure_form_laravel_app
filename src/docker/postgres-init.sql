CREATE DATABASE secure_form_laravel;
CREATE USER secure_form_laravel_user WITH PASSWORD 'secure_form_laravel_user_password';
GRANT ALL PRIVILEGES ON DATABASE secure_form_laravel TO secure_form_laravel_user;
