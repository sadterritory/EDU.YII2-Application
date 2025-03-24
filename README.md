
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
