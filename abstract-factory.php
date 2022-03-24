<?php

abstract class AbstractFactory
{
    abstract public function DBConnection() : Connection;

    abstract public function DBRecord() : Record;

    abstract public function DBQueryBuilder() : QueryBuilder;

}

class MySQLFactory extends AbstractFactory
{
    public function DBConnection() : Connection
    {

        return new MySQLConnection();
    }

    public function DBRecord() : Record
    {

        return new MySQLRecord();
    }

    public function DBQueryBuilder() : QueryBuilder
    {

        return new MySQLQueryBuilder();
    }
}

class PostgreSQLFactory extends AbstractFactory
{
    public function DBConnection() : Connection
    {

        return new PostgreSQLConnection();
    }

    public function DBRecord() : Record
    {

        return new PostgreSQLRecord();
    }

    public function DBQueryBuilder() : QueryBuilder
    {

        return new PostgreSQLQueryBuilder();
    }
}

class OracleFactory extends AbstractFactory
{
    public function DBConnection() : Connection
    {

        return new OracleConnection();
    }

    public function DBRecord() : Record
    {

        return new OracleRecord();
    }

    public function DBQueryBuilder() : QueryBuilder
    {

        return new OracleQueryBuilder();
    }
}

interface Connection
{
    public function setConnection() : string;
}

class MySQLConnection implements Connection
{
    public function setConnection() : string
    {
        return "MySQL DB connected";
    }
}

class PostgreSQLConnection implements Connection
{
    public function setConnection() : string
    {
        return "PostgreSQL DB connected";
    }
}

class OracleConnection implements Connection
{
    public function setConnection() : string
    {
        return "Oracle DB connected";
    }
}

interface Record
{
    public function addRecord() : string;
}

class MySQLRecord implements Record
{
    public function addRecord() : string
    {
        return "Record added to MySQL DB";
    }
}

class PostgreSQLRecord implements Record
{
    public function addRecord() : string
    {
        return "Record added to PostgreSQL DB";
    }
}

class OracleRecord implements Record
{
    public function addRecord() : string
    {
        return "Record added to Oracle DB";
    }
}

interface QueryBuilder
{
    public function query() : string;
}

class MySQLQueryBuilder implements QueryBuilder
{
    public function query() : string
    {
        return "MySQL DB query was executed successfully";
    }
}

class PostgreSQLQueryBuilder implements QueryBuilder
{
    public function query() : string
    {
        return "PostgreSQL DB query was executed successfully";
    }
}

class OracleQueryBuilder implements QueryBuilder
{
    public function query() : string
    {
        return "Oracle DB query was executed successfully";
    }
}


function clientCode(AbstractFactory $factory)
{
    $connection = $factory -> DBConnection();
    $record = $factory -> DBRecord();
    $querybuilder = $factory ->DBQueryBuilder();

    echo $connection -> setConnection() . "<br>";
    echo $record -> addRecord() . "<br>";
    echo $querybuilder -> query() . "<br>";
}

echo "Try to work with MySQL DB:<br>";
clientCode(new MySQLFactory());
echo "<br>";

echo "Try to work with PostgreSQL DB:<br>";
clientCode(new PostgreSQLFactory());
echo "<br>";

echo "Try to work with Oracle DB:<br>";
clientCode(new OracleFactory());
echo "<br>";

