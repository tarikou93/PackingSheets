insert into t_code values
(1, 'testLabelCode');

insert into t_code values
(2, 'testLabelCode2');

insert into t_address values
(1, 1,'testLabelAddress');

insert into t_address values
(2, 2, 'testLabelAddress2');

insert into t_contact values
(1, 1, 'Michael Jackson', 'mj@test.com', '+33645897456', '+3345884756');

insert into t_contact values
(2, 2, 'Chuck Norris', 'cn@test.com', '+33642179433', '+33694785222');

insert into t_contact values
(3, 2, 'Jean Jacques Goldman', 'jjg@test.com', '+33679998563', '+3367444512');

insert into t_service values
(1, 'testLabelService');

insert into t_service values
(2, 'testLabelService2');

insert into t_content values
(1, 'testLabelContent');

insert into t_content values
(2, 'testLabelContent2');

insert into t_priority values
(1, 'testLabelPriority');

insert into t_priority values
(2, 'testLabelPriority2');

insert into t_shipper values
(1, 'testLabelShipper');

insert into t_shipper values
(2, 'testLabelShipper2');

insert into t_memo values
(1, 'testLabelMemoTable');

insert into t_memo values
(2, 'testLabelMemoTable2');

insert into t_autority values
(1, 'testLabelAutority', '+32422521');

insert into t_autority values
(2, 'testLabelAutority2', '+32454238');

insert into t_customStatus values
(1, 'testLabelCustomStatus', 'This is a test text for custom Status table');

insert into t_customStatus values
(2, 'testLabelCustomStatus2', 'This is test 2 text for custom Status table');

insert into t_incotermsType values
(1, 'testLabelIncoType');

insert into t_incotermsType values
(2, 'testLabelIncoType2');

insert into t_incotermsLocation values
(1, 'testLabelIncoLoc');

insert into t_incotermsLocation values
(2, 'testLabelIncoLoc2');

insert into t_currency values
(1, 'testLabelCurrency');

insert into t_currency values
(2, 'testLabelCurrency2');

insert into t_imput values
(1, 'testLabelImput', 'This is a test text for imput table');

insert into t_imput values
(2, 'testLabelImput2', 'This is test 2 text for imput table');

insert into t_packingsheet values
(1, '20160927/701', 1, 1, 2, 1, 2, 1, 1, 1, 1, '2016', '4517842745', '2016-09-27', 1, 1, 1, 1, 1, 1, 1, 0, 0, 0, 1, 0, 'Test memo');

insert into t_packingsheet values
(2, '20161005/701', 2, 2, 2, 2, 3, 1, 1, 2, 1, '2016', '4517847854', '2016-10-05', 1, 2, 1, 2, 1, 2, 2, 0, 0, 0, 1, 1, 'Test memo 2');

insert into t_part values
(1, '784-48172', '84584258457', 'This is a part', 152.56, 'HS4218465513');

insert into t_part values
(2, '785-481487', '84584944215', 'This is another part', 132.23, 'HS4218465895');

insert into t_part values
(3, '786-48332', '84547854123', 'This is one more part', 183.52, 'HS4218465513');

insert into t_packType values
(1, 'testlabelPackType');

insert into t_packType values
(2, 'testlabelPackType2');

insert into t_packing values
(1, 1, 45.52, 56.98, 21.0, 35.2, 56.48, 1, 'packing1.jpg');

insert into t_packing values
(2, 2, 53.46, 23.88, 18.00, 33.22, 87.52, 2, 'packing2.jpg');

insert into t_packing values
(3, 1, 65.23, 33.25, 83.20, 77.18, 45.25, 2, 'packing3.jpg');

insert into t_packing_part values
(1, 1, 1, 23, 'USA');

insert into t_packing_part values
(2, 1, 2, 18, 'France');

insert into t_packing_part values
(3, 2, 3, 5, 'Belgium');
