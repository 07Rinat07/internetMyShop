#!/bin/sh
set -e

cd /var/www/html

if [ ! -f vendor/autoload.php ]; then
  composer install --no-interaction --prefer-dist
fi

if [ "${DB_CONNECTION}" = "mysql" ]; then
  php -r '
  $dsn = sprintf(
      "mysql:host=%s;port=%s;dbname=%s",
      getenv("DB_HOST") ?: "db",
      getenv("DB_PORT") ?: "3306",
      getenv("DB_DATABASE") ?: ""
  );

  $maxAttempts = 30;

  for ($attempt = 1; $attempt <= $maxAttempts; $attempt++) {
      try {
          new PDO($dsn, getenv("DB_USERNAME") ?: "root", getenv("DB_PASSWORD") ?: "");
          fwrite(STDOUT, "Database connection established.\n");
          exit(0);
      } catch (Throwable $e) {
          fwrite(STDOUT, sprintf("Waiting for database (%d/%d)...\n", $attempt, $maxAttempts));
          sleep(2);
      }
  }

  fwrite(STDERR, "Database is not reachable.\n");
  exit(1);
  '

  php artisan migrate --force --no-interaction
  php artisan db:seed --class=Database\\Seeders\\StorefrontSiteContentSeeder --force --no-interaction

  SHOULD_SEED=$(php -r '
  $dsn = sprintf(
      "mysql:host=%s;port=%s;dbname=%s",
      getenv("DB_HOST") ?: "db",
      getenv("DB_PORT") ?: "3306",
      getenv("DB_DATABASE") ?: ""
  );

  $pdo = new PDO(
      $dsn,
      getenv("DB_USERNAME") ?: "root",
      getenv("DB_PASSWORD") ?: "",
      [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
  );

  $count = (int) $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();

  echo $count === 0 ? "yes" : "no";
  ')

  if [ "$SHOULD_SEED" = "yes" ]; then
    php artisan db:seed --force --no-interaction
  else
    echo "Skipping full db seed because the database already contains users."
  fi
fi

if [ ! -e public/storage ]; then
  php artisan storage:link >/dev/null 2>&1 || true
fi
php artisan config:clear >/dev/null 2>&1 || true

exec php artisan serve --host=0.0.0.0 --port=8000
