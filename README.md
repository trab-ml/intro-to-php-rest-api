# REST API using Php

## Create the database

You should have create the necessary database and table created before start testing.

One way to do it: In phpmyadmin, create a database named `rest-api` and then copy [the table script](./db/sql).

## Testing

In Thunderclient (Postman or similar tool)

To select all records:
<path_to_the_file_in_your_computer/read.php>

To select a specific record (here, the record which have 2 as id):
<path_to_the_file_in_your_computer/read.php?id=2>

ex:
<http://localhost/public_html/intro-to-php-rest-api/customers/read.php>

## TODO

- Refactor
- ...
