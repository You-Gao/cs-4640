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
pg_query($dbHandle, "drop sequence if exists sprint3_users_seq cascade;");
pg_query($dbHandle, "drop sequence if exists sprint3_characters_seq cascade;");
pg_query($dbHandle, "drop sequence if exists sprint3_items_seq cascade;");
pg_query($dbHandle, "drop table if exists sprint3_users cascade;");
pg_query($dbHandle, "drop table if exists sprint3_characters cascade;");
pg_query($dbHandle, "drop table if exists sprint3_friends cascade;");
pg_query($dbHandle, "drop table if exists sprint3_character_items cascade;");
pg_query($dbHandle, "drop table if exists sprint3_items cascade;");

// Create sequences
pg_query($dbHandle, "create sequence sprint3_users_seq;");
pg_query($dbHandle, "create sequence sprint3_characters_seq;");
pg_query($dbHandle, "create sequence sprint3_items_seq;");

// Create tables
pg_query($dbHandle, "create table sprint3_users (
    id int primary key default nextval('sprint3_users_seq'),
    email text,
    username text,
    password text
);");

pg_query($dbHandle, "create table sprint3_characters (
    id int primary key default nextval('sprint3_characters_seq'),
    user_id int references sprint3_users(id),
    name text,
    exp int,
    atk int,
    def int,
    hp int,
    stat_points int,
    monsters_killed int,
    quest_id int,
    hat_id int,
    shirt_id int,
    pant_id int,
    shoes_id int
);");

pg_query($dbHandle, "create table sprint3_friends (
    user_id0 int references sprint3_users(id),
    user_id1 int references sprint3_users(id),
    status text,
    primary key (user_id0, user_id1)
);");

pg_query($dbHandle, "create table sprint3_items (
    id int primary key default nextval('sprint3_items_seq'),
    name text,
    atk int,
    def int,
    hp int,
    type text
);");

pg_query($dbHandle, "create table sprint3_character_items (
    char_id int references sprint3_characters(id),
    item_id int references sprint3_items(id),
    item_count int,
    equiped int,
    primary key (char_id, item_id)
);");
//TODO change for sever deployment
$items = json_decode(file_get_contents("/opt/src/project/data/items.json"), true);

$res = pg_prepare($dbHandle, "myinsert", "insert into sprint3_items (name, atk, def, hp, type) values 
($1, $2, $3, $4, $5);");
foreach ($items as $item) {
    $res = pg_execute($dbHandle, "myinsert", [$item["name"], $item["atk"], $item["def"], $item["hp"], $item["type"]]);
    echo "Added item: {$item["name"]}<br>\n";
}

echo " | Done setting up db";

?>
