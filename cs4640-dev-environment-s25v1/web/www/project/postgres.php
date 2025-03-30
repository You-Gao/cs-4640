<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$host = "db"; 
$port = "5432";
$database = "example"; 
$user = "localuser"; 
$password = "cs4640LocalUser!"; 

$dbHandle = pg_connect("host=$host port=$port dbname=$database user=$user password=$password");

if ($dbHandle) {
    echo "Success connecting to database";
} else {
    echo "An error occurred connecting to the database";
}

// Drop tables and sequences (that are created later)
pg_query($dbHandle, "drop sequence if exists users_seq cascade;");
pg_query($dbHandle, "drop sequence if exists characters_seq cascade;");
pg_query($dbHandle, "drop sequence if exists items_seq cascade;");
pg_query($dbHandle, "drop table if exists users cascade;");
pg_query($dbHandle, "drop table if exists characters cascade;");
pg_query($dbHandle, "drop table if exists friends cascade;");
pg_query($dbHandle, "drop table if exists character_items cascade;");
pg_query($dbHandle, "drop table if exists items cascade;");

// Create sequences
pg_query($dbHandle, "create sequence users_seq;");
pg_query($dbHandle, "create sequence characters_seq;");
pg_query($dbHandle, "create sequence items_seq;");

// Create tables
pg_query($dbHandle, "create table users (
    id int primary key default nextval('users_seq'),
    email text,
    username text,
    password text
);");

pg_query($dbHandle, "create table characters (
    id int primary key default nextval('characters_seq'),
    user_id int references users(id),
    name text,
    exp int,
    atk int,
    def int,
    hp int,
    monsters_killed int,
    quest_id int,
    hat_id int,
    shirt_id int,
    pant_id int,
    shoes_id int
);");

pg_query($dbHandle, "create table friends (
    user_id0 int references users(id),
    user_id1 int references users(id),
    status text,
    primary key (user_id0, user_id1)
);");

pg_query($dbHandle, "create table items (
    id int primary key default nextval('items_seq'),
    name text,
    atk int,
    def int,
    hp int
);");

pg_query($dbHandle, "create table character_items (
    char_id int references characters(id),
    item_id int references items(id),
    item_count int,
    primary key (char_id, item_id)
);");



echo " | Done setting up db";

?>
