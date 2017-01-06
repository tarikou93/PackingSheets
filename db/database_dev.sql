create database if not exists packingsheets_dev character set utf8 collate utf8_unicode_ci;
use packingsheets_dev;

grant all privileges on packingsheets_dev.* to 'packingsheets'@'localhost' identified by 'secret';
