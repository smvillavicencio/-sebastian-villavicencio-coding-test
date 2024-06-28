<a name="readme-top"></a>

<div align="center">
    <h3 align="center">Backend Developer coding test</h3>
</div>

<!-- TABLE OF CONTENTS -->
<details>
  <summary>Table of Contents</summary>
  <ol>
    <li>
      <a href="#how-to-setup">How to setup</a>
      <ul>
        <li><a href="#installation-of-dependencies">Installation of dependencies</a></li>
        <li><a href="#starting-the-development-server">Starting the development server</a></li>
        <li><a href="#testing">Testing</a></li>
      </ul>
    </li>
    <li>
      <a href="#about-the-test">About the test</a>
    </li>
    <li>
      <a href="#requirements">Requirements</a>
      <ul>
        <li><a href="#product-specifications">Product specifications</a></li>
        <li><a href="#api-requirements">API Requirements</a></li>
      </ul>
    </li>
    <li>
      <a href="#getting-started">Getting started</a>
      <ul>
        <li><a href="#prerequisites">Prerequisites</a></li>
        <li><a href="#installation">Installation</a></li>
      </ul>
    </li>
    <li>
      <a href="#bonus-points">Bonus points</a>
    </li>
  </ol>
</details>

<!-- HOW TO SETUP -->

## How to setup

### Installation of dependencies

To install necessary dependencies, run:

```sh
composer install
```

### Starting the development server

1. Start the Apache and MySQL on [XAMPP](https://www.apachefriends.org/download.html).
2. To generate the application key, run:

```sh
php artisan key:generate
```

3. Rename the `.env.example` to `.env` and edit the file with your database configuration.
4. To create the necessary tables in the database, run:

```sh
php artisan migrate
```

5. To start the development server, run:

```sh
php artisan serve
```

### Testing

1. Uncomment lines 24 and 25 in the `phpunit.xml` file.

```xml
<env name="DB_CONNECTION" value="sqlite"/>
<env name="DB_DATABASE" value=":memory:"/>
```

2. To execute the tests, run:

```sh
php artisan test
```

3. Once testing is complete, comment out lines 24 and 25 in the `phpunit.xml` file again.
 <!-- ABOUT THE TEST -->

## About the test

You're tasked to create a simple REST web service application for a fictional e-commerce business using Laravel.

You need to develop the following REST APIs:

-   Products list
-   Product detail
-   Create product
-   Update product
-   Delete product

<!-- REQUIREMENTS -->

## Requirements

### Product specifications

A product needs to have the following information:

-   Product name
-   Product description
-   Product price
-   Created at
-   Updated at

### API requirements

-   Products list API
    -   The products list API must be paginated.
-   Create and Update product API
    -   The product name, description, and price must be required.
    -   The product name must accept a maximum of 255 characters.
    -   The product price must be numeric in type and must accept up to two decimal places.
    -   The created at and updated at fields must be in timestamp format.

Others:

-   You are required to use MYSQL for the database storage in this test.
-   You are free to use any library or component just as long as it can be installed using Composer.
-   Don't forget to provide instructions on how to set the application up.

<p align="right">(<a href="#readme-top">back to top</a>)</p>

<!-- GETTING STARTED -->

## Getting Started

### Prerequisites

-   Git
-   Composer
-   PHP ^8.0.2
-   MySQL

### Installation

-   Create a new repository under your account named `{FIRST NAME}-{LAST NAME}-coding-test`. (e.g. `john-doe-coding-test`)
-   Push your code to the new repository.

<p align="right">(<a href="#readme-top">back to top</a>)</p>

<!-- BONUS POINTS -->

## Bonus points

#### For bonus points:

-   Cache the response of the Product detail API. You are free to use any cache driver.
-   Use the Service layer and Repository design patterns.
-   Create automated tests for the app.

#### Answer the question below by updating this file.

Q: The management requested a new feature where in the fictional e-commerce app must have a "featured products" section.
How would you go about implementing this feature in the backend?

A: To implement a "featured products" section, I will begin by adjusting the database schema of the products `table` to include a new boolean attribute named `is_featured`. This attribute will serve as a flag to indicate whether a product is featured or not. Next, I will create an API endpoint specifically for fetching featured products. This endpoint will query the database for products where `is_featured` is set to true.

To enhance performance, especially if the featured products list does not change frequently, I will implement caching for the featured products. Caching these products for a longer duration will reduce the load on the database and ensure quicker response times.
