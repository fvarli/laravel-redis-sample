# **Laravel Redis Integration Sample**

## **Project Overview**
This Laravel project demonstrates how to integrate and use Redis for caching to improve application performance. It provides an example of fetching and caching article data using Redis.

---

## **Features**
- **Article Management**:
  - Manage articles with categories and authors.
  - Fetch all articles with optimized Redis caching.
- **Redis Integration**:
  - Cache data to reduce database queries and improve response time.
  - Use `Redis::get` and `Redis::set` methods for storing and retrieving data.
- **RESTful API**:
  - Expose endpoints for managing articles, including a Redis-powered endpoint.

---

## **Requirements**
- PHP >= 8.1
- Composer >= 2.5.4
- Laravel >= 10.x
- Redis server installed and running
- MySQL

---

## **Directory Structure**
Below is a simplified overview of the relevant directory structure:

```
└── fvarli-laravel-redis-sample/
    ├── README.md
    ├── composer.json
    ├── .env.example
    ├── app/
    │   ├── Http/
    │   │   ├── Controllers/
    │   │   │   └── ArticleController.php
    │   ├── Models/
    │   │   ├── Article.php
    │   │   ├── Category.php
    │   │   └── User.php
    ├── config/
    │   └── database.php
    ├── database/
    │   ├── migrations/
    │   │   ├── create_articles_table.php
    │   │   ├── create_categories_table.php
    │   │   └── create_article_category_table.php
    │   ├── seeders/
    │   │   ├── ArticleSeeder.php
    │   │   ├── CategorySeeder.php
    │   │   └── UserSeeder.php
    ├── routes/
    │   └── api.php
```

---

## **Setup Instructions**

1. **Clone the repository**
   ```bash
   git clone https://github.com/fvarli/fvarli-laravel-redis-sample.git
   cd fvarli-laravel-redis-sample
   ```

2. **Install dependencies**
   ```bash
   composer install
   ```

3. **Configure environment variables**
   - Copy `.env.example` to `.env`.
   - Update the database credentials and Redis connection in the `.env` file:
     ```env
     DB_DATABASE=your_database_name
     DB_USERNAME=your_username
     DB_PASSWORD=your_password
     REDIS_CLIENT=predis
     REDIS_HOST=127.0.0.1
     REDIS_PASSWORD=null
     REDIS_PORT=6379
     ```

4. **Generate the application key**
   ```bash
   php artisan key:generate
   ```

5. **Migrate the database**
   ```bash
   php artisan migrate
   ```

6. **Seed the database**
   ```bash
   php artisan db:seed
   ```

7. **Install Redis** (Linux instructions):
   - Update your system:
     ```bash
     sudo apt update && sudo apt upgrade -y
     ```
   - Install Redis:
     ```bash
     sudo apt install redis-server
     ```
   - Enable and start the Redis service:
     ```bash
     sudo systemctl enable redis
     sudo systemctl start redis
     ```
   - Verify Redis is running:
     ```bash
     redis-cli ping
     # Expected response: PONG
     ```
   - Optionally, configure Redis in `/etc/redis/redis.conf` for production.

8. **Serve the application**
   ```bash
   php artisan serve
   ```

---

## **API Endpoints**

| Method | Endpoint              | Description                          |
|--------|-----------------------|--------------------------------------|
| GET    | `/api/articles`       | Fetch all articles                  |
| GET    | `/api/articlesWithRedis` | Fetch all articles using Redis caching |

---

## **Redis Integration Details**

- **Controller Implementation**:
  In `ArticleController.php`, the `articlesWithRedis` method fetches data from Redis. If the data is not cached, it retrieves the data from the database, caches it, and returns it:

  ```php
  public function articlesWithRedis()
  {
      $redis = Redis::get('articles');

      if ($redis) {
          return json_decode($redis);
      }

      $articles = Article::all();
      Redis::set('articles', $articles);

      return $articles;
  }
  ```

- **Clearing the Cache**:
  Use the following command to clear the Redis cache:
  ```bash
  php artisan cache:clear
  ```

---

## **Database Structure**

### Tables

1. **`articles`**
   - `id`
   - `title`
   - `slug`
   - `body`
   - `excerpt`
   - `user_id` (foreign key)
   - `image`
   - `status` (`draft` or `published`)
   - `published_at`
   - Timestamps

2. **`categories`**
   - `id`
   - `name`
   - Timestamps

3. **`article_category`**
   - `id`
   - `article_id` (foreign key)
   - `category_id` (foreign key)
   - Timestamps

---

## **Official Documentation**
- [Laravel Documentation](https://laravel.com/docs)
- [Redis Documentation](https://redis.io/docs)

---

## **License**
This project is open-source and available under the [MIT License](https://opensource.org/licenses/MIT).
