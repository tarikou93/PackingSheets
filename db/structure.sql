drop table if exists t_packing_part;
drop table if exists t_packingsheet_part;
drop table if exists t_part;
drop table if exists t_packing;
drop table if exists t_packType;
drop table if exists t_packingsheet;
drop table if exists t_group;
drop table if exists t_code;
drop table if exists t_service;
drop table if exists t_content;
drop table if exists t_priority;
drop table if exists t_shipper;
drop table if exists t_autority;
drop table if exists t_customStatus;
drop table if exists t_incotermsType;
drop table if exists t_incotermsLocation;
drop table if exists t_currency;
drop table if exists t_imput;

create table t_code (
  code_id integer not null primary key auto_increment,
  code_label varchar(20) not null,
  code_text varchar(500)
) engine=innodb character set utf8 collate utf8_unicode_ci;

create table t_service (
  serv_id integer not null primary key auto_increment,
  serv_label varchar(100) not null
) engine=innodb character set utf8 collate utf8_unicode_ci;

create table t_content (
  cont_id integer not null primary key auto_increment,
  cont_label varchar(100) not null
) engine=innodb character set utf8 collate utf8_unicode_ci;

create table t_priority (
  prior_id integer not null primary key auto_increment,
  prior_label varchar(100) not null
) engine=innodb character set utf8 collate utf8_unicode_ci;

create table t_shipper (
  ship_id integer not null primary key auto_increment,
  ship_label varchar(100) not null
) engine=innodb character set utf8 collate utf8_unicode_ci;

create table t_autority (
  aut_id integer not null primary key auto_increment,
  aut_label varchar(100) not null,
  aut_telNumber varchar(20) not null
) engine=innodb character set utf8 collate utf8_unicode_ci;

create table t_customStatus (
  custStat_id integer not null primary key auto_increment,
  custStat_label varchar(50) not null,
  custStat_text varchar(100) not null
) engine=innodb character set utf8 collate utf8_unicode_ci;

create table t_currency (
  curr_id integer not null primary key auto_increment,
  curr_label varchar(100) not null
) engine=innodb character set utf8 collate utf8_unicode_ci;

create table t_imput (
  imp_id integer not null primary key auto_increment,
  imp_label varchar(50) not null,
  imp_text varchar(100) not null
) engine=innodb character set utf8 collate utf8_unicode_ci;

create table t_group (
  group_id integer not null primary key auto_increment,
  group_label varchar(50) not null
) engine=innodb character set utf8 collate utf8_unicode_ci;

create table t_incotermsType (
  incType_id integer not null primary key auto_increment,
  incType_label varchar(100) not null
) engine=innodb character set utf8 collate utf8_unicode_ci;

create table t_incotermsLocation (
  incLoc_id integer not null primary key auto_increment,
  incLoc_label varchar(100) not null
) engine=innodb character set utf8 collate utf8_unicode_ci;

create table t_packingsheet (

  ps_id integer not null primary key auto_increment,
  ps_ref varchar(50) not null,

  group_id integer not null,
  constraint fk_ps_group foreign key(group_id) references t_group(group_id),

  consignedCode_id integer not null,
  constraint fk_ps_consignedCode foreign key(consignedCode_id) references t_code(code_id),

  deliveryCode_id integer not null,
  constraint fk_ps_deliveryCode foreign key(deliveryCode_id) references t_code(code_id),

  service_id integer not null,
  constraint fk_ps_service foreign key(service_id) references t_service(serv_id),

  content_id integer not null,
  constraint fk_ps_content foreign key(content_id) references t_content(cont_id),

  priority_id integer not null,
  constraint fk_ps_priority foreign key(priority_id) references t_priority(prior_id),

  shipper_id integer not null,
  constraint fk_ps_shipper foreign key(shipper_id) references t_shipper(ship_id),

  ps_yrOrder varchar(50) not null,
  ps_AWB varchar(50) not null,
  ps_dateIssue date not null,

  autority_id integer not null,
  constraint fk_ps_autority foreign key(autority_id) references t_autority(aut_id),

  customStatus_id integer not null,
  constraint fk_ps_customStatus foreign key(customStatus_id) references t_customStatus(custStat_id),

  incType_id integer not null,
  constraint fk_ps_incType foreign key(incType_id) references t_incotermsType(incType_id),

  incLoc_id integer not null,
  constraint fk_ps_incLoc foreign key(incLoc_id) references t_incotermsLocation(incLoc_id),

  currency_id integer not null,
  constraint fk_ps_currency foreign key(currency_id) references t_currency(curr_id),

  imput_id integer not null,
  constraint fk_ps_imput foreign key(imput_id) references t_imput(imp_id),

  ps_nbrPieces integer not null,
  ps_weight float(2) not null,
  ps_totalPrice float(2) not null,
  ps_signed bit not null,
  ps_printed bit not null,

  ps_memo varchar(300)
) engine=innodb character set utf8 collate utf8_unicode_ci;

create table t_part (
  part_id integer not null primary key auto_increment,
  part_pn varchar(100),
  part_serial varchar(100) not null,
  part_desc varchar(200),
  part_price float(2) not null,
  part_HSCode varchar(50)
) engine=innodb character set utf8 collate utf8_unicode_ci;

create table t_packType (
  packType_id integer not null primary key auto_increment,
  packType_label varchar(50) not null
) engine=innodb character set utf8 collate utf8_unicode_ci;

create table t_packing (
  pack_id integer not null primary key auto_increment,
  ps_id integer not null,
  constraint fk_pack_ps foreign key(ps_id) references t_packingsheet(ps_id),
  pack_netWeight float(2) not null,
  pack_grossWeight float(2) not null,
  pack_M1 float(2) not null,
  pack_M2 float(2) not null,
  pack_M3 float(2) not null,
  packType_id integer not null,
  constraint fk_pack_packType foreign key(packType_id) references t_packType(packType_id)
) engine=innodb character set utf8 collate utf8_unicode_ci;

create table t_packing_part (
  pkp_id integer not null primary key auto_increment,
  pack_id integer not null,
  constraint fk_pkp_pack foreign key(pack_id) references t_packing(pack_id),
  part_id integer not null,
  constraint fk_psp_part foreign key(part_id) references t_part(part_id),
  pkp_quantity integer,
  pkp_origin varchar(50)
) engine=innodb character set utf8 collate utf8_unicode_ci;
