<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
    <h1 align="center">Yii 2 Advanced Project Template</h1>
    <br>
</p>

Yii 2 Advanced Project Template is a skeleton [Yii 2](https://www.yiiframework.com/) application best for
developing complex Web applications with multiple tiers.

The template includes three tiers: front end, back end, and console, each of which
is a separate Yii application.

The template is designed to work in a team development environment. It supports
deploying the application in different environments.

Documentation is at [docs/guide/README.md](docs/guide/README.md).

[![Latest Stable Version](https://img.shields.io/packagist/v/yiisoft/yii2-app-advanced.svg)](https://packagist.org/packages/yiisoft/yii2-app-advanced)
[![Total Downloads](https://img.shields.io/packagist/dt/yiisoft/yii2-app-advanced.svg)](https://packagist.org/packages/yiisoft/yii2-app-advanced)
[![build](https://github.com/yiisoft/yii2-app-advanced/workflows/build/badge.svg)](https://github.com/yiisoft/yii2-app-advanced/actions?query=workflow%3Abuild)

DIRECTORY STRUCTURE
-------------------

```
common
    config/              contains shared configurations
    mail/                contains view files for e-mails
    models/              contains model classes used in both backend and frontend
    tests/               contains tests for common classes    
console
    config/              contains console configurations
    controllers/         contains console controllers (commands)
    migrations/          contains database migrations
    models/              contains console-specific model classes
    runtime/             contains files generated during runtime
backend
    assets/              contains application assets such as JavaScript and CSS
    config/              contains backend configurations
    controllers/         contains Web controller classes
    models/              contains backend-specific model classes
    runtime/             contains files generated during runtime
    tests/               contains tests for backend application    
    views/               contains view files for the Web application
    web/                 contains the entry script and Web resources
frontend
    assets/              contains application assets such as JavaScript and CSS
    config/              contains frontend configurations
    controllers/         contains Web controller classes
    models/              contains frontend-specific model classes
    runtime/             contains files generated during runtime
    tests/               contains tests for frontend application
    views/               contains view files for the Web application
    web/                 contains the entry script and Web resources
    widgets/             contains frontend widgets
vendor/                  contains dependent 3rd-party packages
environments/            contains environment-based overrides
```

<p>
    <h2 align="center">Yii 2 Advanced My Project</h2>
</p>

This project, developed based on the Yii2 framework, includes a REST service, a console command and an administrative
panel for working with queries.

---

## 📋 Project Description

The project implements the following functions:

1. **REST Service**:
    - Endpoint `/checkStatus` to retrieve information from the database by queries.
    - Example request:
      ``http.
      POST /checkStatus
      Content-Type: application/json
      ```
      {{ “url”: [{ “https://somesite_1.com”,“https://somesite_2.com”,“https://somesite_3.com”,“https://somesite_4.com”]}
      ```

2. **Console command**:
    - Command to output all requests for the last 24 hours.
    - Example command:
      ```
      yii check-status/statistics
      ```

3. **Administration Panel**:
    - A panel to view and filter queries from the database.
    - CSV file example:
      ```csv
      hash_string,created_at,updated_at,url,status_code,query_count
      0cf95881ddad1b6e93114c923715bd56,“2025-01-09 11:16:36”,“2025-01-15 18:38:45”,https://somesite_6.com,0,44
      ```

---

## 🛠 Setup and startup

1. **Setup**:

- Clone the repository with the `ruslan` branch:
   ```
   git clone -b ruslan git@gitlab.com:PHPis/trainee.git
   cd trainee
- The project uses Docker to start. You can run it in two modes: prod (production) and dev (development).

    1. To run in production mode
       ```
       docker-compose --env-file .env.prod up

    2. To run in development mode:
       ```
       docker-compose --env-file .env.dev up

## 🛑 Stopping containers

- To stop the containers, run the command:
   ```
   docker-compose down