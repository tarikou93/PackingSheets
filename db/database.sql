create database if not exists packingsheets character set utf8 collate utf8_unicode_ci;
use packingsheets;

grant all privileges on packingsheets.* to 'packingsheets'@'localhost' identified by 'secret';
