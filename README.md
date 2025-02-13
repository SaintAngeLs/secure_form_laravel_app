# Secure Form Laravel Application

## Overview

The **Secure Form Laravel Application** is a hybrid modular monolith built with **Clean Architecture** and **Domain-Driven Design (DDD)** principles. This application allows users to submit forms and upload files in a secure and efficient manner. It integrates an event-driven architecture powered by Kafka for asynchronous form submission processing.

## Key Features

- **File Upload**: Securely upload files and retrieve them using file metadata.
- **Form Submission**: Users can submit detailed forms stored in the database.
- **Asynchronous Processing**: Form submissions are processed asynchronously using Kafka as the message broker.
- **Pagination & Search**: Provides paginated lists of form entries with search functionality.
- **Swagger Documentation**: API documentation using Swagger UI.
- **Clean Architecture**: Separation of concerns between domain, application, infrastructure, and presentation layers.
- **Modular Design**: Organized codebase with reusable and testable modules.
- **Docker Support**: Simplified local development with Docker containers.

---


## Technological Stack

### Service Part:
- **Laravel 11**: PHP framework for application logic and APIs.
- **PHP 8.2**: Core programming language.
- **PostgreSQL**: Database for persisting data. It is also possible to go with MySQL.
- **Redis**: Caching and session management.
- **AMQTT Message broker**: publish subscriber outbox pattern.

### Frontend:
- **Blade Templates**: Laravel’s templating engine.
- **TailwindCSS**: Styling and responsive design.
- **jQuery**: Enhances dynamic interactions and frontend functionality.

### DevOps:
- **Docker**: Containerized development environment.
- **Nginx**: Web server.
- **Kafka**: Message broker for event-driven architecture.
- **Swagger**: API documentation and exploration.
- **Pgadmin**: Web-based administration interface for PostgreSQL.


---
## How to Run the Project Locally

### Prerequisites

Ensure the following tools are installed:

- **Docker & Docker Compose**: For containerized application setup.
- **Node.js** (Optional): Required for frontend development.
- **PHP 8.2** (Optional): If running outside Docker.

### Steps

1. **Clone the Repository**:
   ```bash
   git clone https://github.com/SaintAngeLs/secure_form_laravel_app.git
   cd secure_form_laravel_app/src
   ```

2. **Set Up Environment Variables**:
   Copy the provided `.env.example` file to `.env` and configure your local environment:
   ```bash
   cp .env.example .env
   ```

3. **Install dependencies**:
   Run the following command to install and build js dependencies:
   ```bash
   nvm use 18 # at least 18 v.
   npm install
   npm run build
   ```

4. **Start the Containers**:
   Run the following command to build and start the containers within the services of microinfrastructure performing artisan commands (migration and seeding):
   ```bash
   docker compose up -d --build
   ```

5. **Access the Application**:
   - **Frontend**: [http://localhost:9090](http://localhost:9090)
        > **Note**: You can register users using **Laravel Breeze** or use the pre-seeded test user:
        > - **Email**: `test@example.com`
        > - **Password**: `testtest`

   - **API Documentation**: [http://localhost:9090/api/documentation](http://localhost:9090/api/documentation)

   - **Kafka**: [http://localhost:8081](http://localhost:8081)
   - **PgAdmin**: [http://localhost:5050](http://localhost:5050)
        > **Note**: You cansign in to PgAdmin dashboard as a user:
        > - **Email**: `admin@example.com`
        > - **Password**: `admin`
   - **Laravel Telescope**: [http://localhost:9090/telescope](http://localhost:9090/telescope) -- is not secured by auth.


---

# Brief Routes Documentation

## Public Routes (No Authentication Required)
- **Homepage**:  
  `GET /`  
  Displays the user form.  
  **Controller**: `FormViewController@userForm`  
  **Route Name**: `form.userForm`

- **Create Form Entry**:  
  `POST /form/create`  
  Submits a new form entry.  
  **Controller**: `FormApiController@store`  
  **Route Name**: `form.create`

- **File Upload**:  
  `POST /files/upload`  
  Handles file uploads.  
  **Controller**: `FileUploadController@upload`  
  **Route Name**: `files.index`

---

## Secured Routes (Authentication Required)
- **Dashboard**:  
  `GET /dashboard`  
  Displays the user dashboard.  
  **Controller**: `DashboardController@index`  
  **Route Name**: `dashboard`

- **Dashboard Entry Details**:  
  `GET /dashboard/entry/{id}`  
  Shows details of a specific dashboard entry.  
  **Controller**: `DashboardController@show`  
  **Route Name**: `dashboard.show`

---

## Kafka Publish/Subscribe Mechanism

### Overview

This application integrates **Kafka** as an event-driven mechanism for decoupling certain tasks. Currently, the system **publishes** messages to the `form-entries` topic whenever a new form entry is created. Meanwhile, a dedicated **consumer** service runs in the background to process these messages and clean up unused files.

### Publishing Messages

Inside the application, messages are produced by calling:

```php
$this->messageBroker->publishAsync('form-entries', json_encode($data));
```

The `MessageBroker` class is responsible for creating a **Kafka producer** and sending messages to the specified topic. The producer is configured in `App\Infrastructure\Services\MessageBroker::publishAsync()`.

### Subscribing to Messages & Cleaning Unused Files

The **UnusedFilesCleaner** service (`App\Infrastructure\Services\UnusedFilesCleaner`) listens to the `form-entries` topic to perform cleanup of unused files. It uses the `MessageBroker::subscribeAsync()` method, which implements a **high-level Kafka consumer**. This consumer runs in an infinite loop, polling for new events.

> **Key Components**  
> - **Topic**: `form-entries`  
> - **Consumer Group**: defaults to `"default-consumer-group"` (configurable in `MessageBroker` constructor)  

###  Asynchronous Form Submission Processing:

 - The **FormSubmissionsProcessor** subscribes to the form-submissions topic and processes incoming messages.
 - Messages are decoded and stored in the database.
 - Message Processing Command:

 - The consumer logic is encapsulated in a Laravel Artisan command `app:start-form-submissions-processor`.
 - This command is executed by the `form_submissions_processor` container.

### The Background Consumer Job

A **Laravel Artisan Command** called `app:start-file-cleanup-listener` is provided to run the consumer logic indefinitely. In `docker-compose.yml`, the `kafka-consumer` service automatically invokes:

```bash
php artisan app:start-file-cleanup-listener
```

Under the hood, this command calls `UnusedFilesCleaner->handleUnusedFiles()`, which subscribes to the `form-entries` topic and processes any incoming events to remove orphans (unused files older than 5 minutes).

#### Running the Consumer Manually

If you want to run the cleanup listener manually (instead of via the `kafka-consumer` container), you can do:

```bash
docker exec -it secure_form_app php artisan app:start-file-cleanup-listener
```

Or on your local machine (if you have PHP and dependencies installed):

```bash
php artisan app:start-file-cleanup-listener
```

## Directory Structure

The project follows the Clean Architecture pattern with modular organization:

- **Application**: Business logic (DTOs, Services, Events, Exceptions).
- **Domain**: Core domain models, repositories, and value objects.
- **Infrastructure**: Implementation of persistence and external services.
- **Http**: Controllers, middleware, and HTTP requests.
- **View**: Blade components for UI rendering.

---

## Swagger Documentation

To view and interact with the API documentation, access [http://localhost:9090/api/documentation](http://localhost:9090/api/documentation). The Swagger UI provides detailed information on all available endpoints.


## Images

Below are some screenshots of the application showcasing its key features and interface:

### Form Submission Page
![Form Submission Page](./images/image_1.png)

### Dashboard with Paginated Entries
![Dashboard](./images/image_2.png)

### Sign In form
![Sign In form](./images/image_3.png)


### Swagger API Documentation
![Swagger API Documentation](./images/image_4.png)


## Contributing

Contributions are welcome! Please read the [CONTRIBUTING.md](./CONTRIBUTING.md) and [CODE_OF_CONDUCT.md](./CODE_OF_CONDUCT.md) before submitting issues or pull requests.

---

## License

This project is licensed under the [MIT License](./LICENSE).

---


