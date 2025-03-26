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
$res  = pg_query($dbHandle, "drop sequence if exists word_seq cascade;");
$res  = pg_query($dbHandle, "drop sequence if exists user_seq cascade;");
$res  = pg_query($dbHandle, "drop sequence if exists userwords_seq cascade;");
$res  = pg_query($dbHandle, "drop sequence if exists userstats_seq cascade;");
$res  = pg_query($dbHandle, "drop sequence if exists stats_seq cascade;");

$res  = pg_query($dbHandle, "drop table if exists word;");
$res  = pg_query($dbHandle, "drop table if exists users;");
$res  = pg_query($dbHandle, "drop table if exists userwords;");
$res  = pg_query($dbHandle, "drop table if exists userstats;");
$res  = pg_query($dbHandle, "drop table if exists stats;");

// Create sequences
$res  = pg_query($dbHandle, "create sequence word_seq;");
$res  = pg_query($dbHandle, "create sequence user_seq;");
$res  = pg_query($dbHandle, "create sequence userwords_seq;");
$res  = pg_query($dbHandle, "create sequence userstats_seq;");
$res  = pg_query($dbHandle, "create sequence stats_seq;");

// Create tables
$res  = pg_query($dbHandle, "create table word (
    id  int primary key default nextval('word_seq'),
    word        text
    );");
$res  = pg_query($dbHandle, "create table users (
    id  int primary key default nextval('user_seq'),
    name text,
    email text,
    password text,
    display text,
    score int);");
$res  = pg_query($dbHandle, "create table userwords (
    id int primary key default nextval('userwords_seq'),
    user_id int,
    word_id int);"); 
$res  = pg_query($dbHandle, "create table userstats (
    id int primary key default nextval('userstats_seq'),
    user_id int,
    stat_id int,
    word_id int);");
$res  = pg_query($dbHandle, "create table stats (
    id int primary key default nextval('stats_seq'),
    score int,
    win int,
    words_remaining int
    );");

echo " | Done setting up db";

?>
