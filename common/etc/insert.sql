insert into cli_messages (msg_time,msg_subject,msg_source,msg_type,msg_body) values
(to_date('2016-04-03 15:10:00','YYYY-MM-DD HH24:MI:SS'),'Movement update', 'aodb','movements','')
/
insert into cli_messages (msg_time,msg_subject,msg_source,msg_type,msg_body) values
(to_date('2016-04-03 15:10:00','YYYY-MM-DD HH24:MI:SS'),'Departure update', 'aodb','departure','')
/
insert into cli_messages (msg_time,msg_subject,msg_source,msg_type,msg_body) values
(to_date('2016-04-03 15:10:00','YYYY-MM-DD HH24:MI:SS'),'Arrival update', 'aodb','arrival','')
/
insert into cli_messages (msg_time,msg_subject,msg_source,msg_type,msg_body) values
(to_date('2016-04-03 15:10:00','YYYY-MM-DD HH24:MI:SS'),'Parking occupancy update', 'aodb','parking-occupancy','')
/
insert into cli_messages (msg_time,msg_subject,msg_source,msg_type,msg_body) values
(to_date('2016-04-03 15:10:00','YYYY-MM-DD HH24:MI:SS'),'Delays update', 'aodb','delay-report','')
/


// EXAMPLES

insert into cli_messages (msg_time,msg_subject,msg_source,msg_type,msg_body) values
(to_date('2016-04-03 15:10:00','YYYY-MM-DD HH24:MI:SS'),'Movement update', 'aodb','movements','')
/
insert into cli_messages (msg_time,msg_subject,msg_source,msg_type,msg_body) values
(to_date('2016-04-03 15:10:00','YYYY-MM-DD HH24:MI:SS'),'Departure update', 'aodb','departure','"[{\"registration\":\"OHJRD\",\"flight_number\":\"OHJRD\",\"airport\":\"LSGG\",\"schedule\":\"14:00\",\"estimated\":\"20:20\"},{\"registration\":\"TCTLC\",\"flight_number\":\"TWI442\",\"airport\":\"LTAI\",\"schedule\":\"17:30\",\"estimated\":\"18:10\"},{\"registration\":\"TCTLA\",\"flight_number\":\"TWI464\",\"airport\":\"LTAI\",\"schedule\":\"17:30\",\"estimated\":\"18:30\"},{\"registration\":\"OOSSB\",\"flight_number\":\"BEL1737\",\"airport\":\"LEMG\",\"schedule\":\"17:35\",\"estimated\":\"18:12\"},{\"registration\":\"OOSND\",\"flight_number\":\"BEL1719\",\"airport\":\"LSGG\",\"schedule\":\"17:55\",\"estimated\":\"18:50\"},{\"registration\":\"N545JN\",\"flight_number\":\"AJK8250\",\"airport\":\"FLKK\",\"schedule\":\"18:00\",\"estimated\":\"20:33\"}]"')
/
insert into cli_messages (msg_time,msg_subject,msg_source,msg_type,msg_body) values
(to_date('2016-04-03 15:10:00','YYYY-MM-DD HH24:MI:SS'),'Arrival update', 'aodb','arrival','"[{\"registration\":\"OOJAF\",\"flight_number\":\"JAF752\",\"airport\":\"EBOS\",\"schedule\":\"17:45\",\"estimated\":\"18:30\"},{\"registration\":\"4XEKJ\",\"flight_number\":\"ELY1333\",\"airport\":\"LLBG\",\"schedule\":\"18:20\",\"estimated\":\"18:50\"},{\"registration\":\"OOSSI\",\"flight_number\":\"BEL682\",\"airport\":\"LIRF\",\"schedule\":\"18:25\",\"estimated\":\"18:02\"},{\"registration\":\"OOTSB\",\"flight_number\":\"TAY052\",\"airport\":\"OMDB\",\"schedule\":\"18:37\",\"estimated\":\"19:00\"},{\"registration\":\"4XICB\",\"flight_number\":\"ICL913\",\"airport\":\"LLBG\",\"schedule\":\"19:40\",\"estimated\":\"19:23\"},{\"registration\":\"OOSNG\",\"flight_number\":\"BEL1688\",\"airport\":\"EDDT\",\"schedule\":\"19:55\",\"estimated\":\"19:53\"}]"')
/
insert into cli_messages (msg_time,msg_subject,msg_source,msg_type,msg_body) values
(to_date('2016-04-03 15:10:00','YYYY-MM-DD HH24:MI:SS'),'Parking occupancy update', 'aodb','parking-occupancy','"{\"pax\":{\"avail\":46,\"busy\":54},\"freit\":{\"avail\":48,\"busy\":52}}"')
/
insert into cli_messages (msg_time,msg_subject,msg_source,msg_type,msg_body) values
(to_date('2016-04-03 15:10:00','YYYY-MM-DD HH24:MI:SS'),'Delays update', 'aodb','delay-report','"[{\"code\":\"93\",\"reason\":\"ROTATION D AVION\",\"time\":\"135\",\"percent\":\"71\"},{\"code\":\"61\",\"reason\":\"PLAN DE VOL\",\"time\":\"56\",\"percent\":\"29\"}]"')
/

