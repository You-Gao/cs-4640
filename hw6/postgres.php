<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$host = "localhost"; 
$port = "5432";
$database = "djx3rn"; 
$user = "djx3rn"; 
$password = "8Z9M9LrD_wrD"; 

$dbHandle = pg_connect("host=$host port=$port dbname=$database user=$user password=$password");

if ($dbHandle) {
    echo "Success connecting to database";
} else {
    echo "An error occurred connecting to the database";
}

// Drop tables and sequences (that are created later)
$res  = pg_query($dbHandle, "drop sequence if exists hw6_word_seq cascade;");
$res  = pg_query($dbHandle, "drop sequence if exists hw6_user_seq cascade;");
$res  = pg_query($dbHandle, "drop sequence if exists hw6_userwords_seq cascade;");
$res  = pg_query($dbHandle, "drop sequence if exists hw6_userstats_seq cascade;");
$res  = pg_query($dbHandle, "drop sequence if exists hw6_stats_seq cascade;");

$res  = pg_query($dbHandle, "drop table if exists hw6_word;");
$res  = pg_query($dbHandle, "drop table if exists hw6_users;");
$res  = pg_query($dbHandle, "drop table if exists hw6_userwords;");
$res  = pg_query($dbHandle, "drop table if exists hw6_userstats;");
$res  = pg_query($dbHandle, "drop table if exists hw6_stats;");

// Create sequences
$res  = pg_query($dbHandle, "create sequence hw6_word_seq;");
$res  = pg_query($dbHandle, "create sequence hw6_user_seq;");
$res  = pg_query($dbHandle, "create sequence hw6_userwords_seq;");
$res  = pg_query($dbHandle, "create sequence hw6_userstats_seq;");
$res  = pg_query($dbHandle, "create sequence hw6_stats_seq;");

// Create tables
$res  = pg_query($dbHandle, "create table hw6_word (
    id  int primary key default nextval('word_seq'),
    word        text
    );");
$res  = pg_query($dbHandle, "create table hw6_users (
    id  int primary key default nextval('user_seq'),
    name text,
    email text,
    password text,
    display text,
    score int);");
$res  = pg_query($dbHandle, "create table hw6_userwords (
    id int primary key default nextval('userwords_seq'),
    user_id int,
    word_id int);"); 
$res  = pg_query($dbHandle, "create table hw6_userstats (
    id int primary key default nextval('userstats_seq'),
    user_id int,
    stat_id int,
    word_id int);");
$res  = pg_query($dbHandle, "create table hw6_stats (
    id int primary key default nextval('stats_seq'),
    score int,
    win int,
    words_remaining int
    );");

echo " | Done setting up db";

?>
