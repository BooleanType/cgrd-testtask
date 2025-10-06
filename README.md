# News Manager

A simple PHP application for managing news items with user authentication.

## Features

* User authentication (only authorized users can manage news).
* View the list of news items.
* Create and edit news using a single `save` method.
* Delete news items.
* Flash messages for success and error notifications.

## Technology Stack

* Docker (custom image based on `php:8.4-apache` official image; compose is used). Let me note, that this image is very raw and is not really for production environment, but it's suitable enough for the test task.
* PHP 8.4
* MySQL (via PDO)
* phpMyAdmin
* Twig templating engine

## Installation

1. Clone the repository:

   ```bash
   git clone https://github.com/BooleanType/cgrd-testtask.git
   cd news-manager
   ```

2. Build the project.

    ```bash
   docker compose up -d --build
   ```

3. Open `http://localhost:3033` in your browser.

4. You can also open phpMyAdmin page ( http://localhost:8081 ). Server is `db`, username is `root` and password is `secret`.
