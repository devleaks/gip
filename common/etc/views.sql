// Mouvements à afficher autour de '2016-04-03 10:00'
select movement_direction, SCHEDULED_TIME_OF_DEPARTURE as SCHEDULED, ACTUAL_TIME_OF_DEPARTURE as ACTUAL
  from movement_eblg
 where movement_direction = 'D'
   and least(SCHEDULED_TIME_OF_DEPARTURE, ESTIM_TIME_OF_DEPARTURE, ACTUAL_TIME_OF_DEPARTURE) < date_add('2016-04-03 10:00', interval 4 hour)
   and greatest(SCHEDULED_TIME_OF_DEPARTURE, ESTIM_TIME_OF_DEPARTURE, ACTUAL_TIME_OF_DEPARTURE) > date_sub('2016-04-03 10:00', interval 4 hour)
   and ACTUAL_TIME_OF_DEPARTURE > '2016-04-03 10:00'
union
select movement_direction, SCHEDULED_TIME_OF_DEPARTURE, ESTIM_TIME_OF_DEPARTURE
  from movement_eblg
 where movement_direction = 'D'
   and least(SCHEDULED_TIME_OF_DEPARTURE, ESTIM_TIME_OF_DEPARTURE, ACTUAL_TIME_OF_DEPARTURE) < date_add('2016-04-03 10:00', interval 4 hour)
   and greatest(SCHEDULED_TIME_OF_DEPARTURE, ESTIM_TIME_OF_DEPARTURE, ACTUAL_TIME_OF_DEPARTURE) > date_sub('2016-04-03 10:00', interval 4 hour)
   and ACTUAL_TIME_OF_DEPARTURE <= '2016-04-03 10:00'
union
select movement_direction, SCHEDULED_TIME_OF_ARRIVAL as SCHEDULED, ACTUAL_TIME_OF_ARRIVAL as ACTUAL
  from movement_eblg
 where movement_direction = 'A'
   and least(SCHEDULED_TIME_OF_ARRIVAL, ESTIM_TIME_OF_ARRIVAL, ACTUAL_TIME_OF_ARRIVAL) < date_add('2016-04-03 10:00', interval 4 hour)
   and greatest(SCHEDULED_TIME_OF_ARRIVAL, ESTIM_TIME_OF_ARRIVAL, ACTUAL_TIME_OF_ARRIVAL) > date_sub('2016-04-03 10:00', interval 4 hour)
   and ACTUAL_TIME_OF_ARRIVAL > '2016-04-03 10:00'
union
select movement_direction, SCHEDULED_TIME_OF_ARRIVAL, ESTIM_TIME_OF_ARRIVAL
  from movement_eblg
 where movement_direction = 'A'
   and least(SCHEDULED_TIME_OF_ARRIVAL, ESTIM_TIME_OF_ARRIVAL, ACTUAL_TIME_OF_ARRIVAL) < date_add('2016-04-03 10:00', interval 4 hour)
   and greatest(SCHEDULED_TIME_OF_ARRIVAL, ESTIM_TIME_OF_ARRIVAL, ACTUAL_TIME_OF_ARRIVAL) > date_sub('2016-04-03 10:00', interval 4 hour)
   and ACTUAL_TIME_OF_ARRIVAL <= '2016-04-03 10:00'
 order by scheduled







// +/- 4 hours
select movement_direction,
       count(movement_direction),
       600 * round(unix_timestamp(SCHEDULED_TIME_OF_DEPARTURE)/600) as SCHEDULED,
       FROM_UNIXTIME(600 * round(unix_timestamp(SCHEDULED_TIME_OF_DEPARTURE)/600)) as date_window
  from movement_eblg
 where least(SCHEDULED_TIME_OF_DEPARTURE, ESTIM_TIME_OF_DEPARTURE, ACTUAL_TIME_OF_DEPARTURE) < date_add('2016-04-03 10:00', interval 4 hour)
   and greatest(SCHEDULED_TIME_OF_DEPARTURE, ESTIM_TIME_OF_DEPARTURE, ACTUAL_TIME_OF_DEPARTURE) > date_sub('2016-04-03 10:00', interval 4 hour)
 group by SCHEDULED
 order by SCHEDULED

// last 4 hours
select movement_direction,
	   count(movement_direction),
       600 * round(unix_timestamp(SCHEDULED_TIME_OF_DEPARTURE)/600) as ACTUAL,
       FROM_UNIXTIME(600 * round(unix_timestamp(SCHEDULED_TIME_OF_DEPARTURE)/600)) as date_window
  from movement_eblg
 where least(SCHEDULED_TIME_OF_DEPARTURE, ESTIM_TIME_OF_DEPARTURE, ACTUAL_TIME_OF_DEPARTURE) < date_add('2016-04-03 10:00', interval 4 hour)
   and greatest(SCHEDULED_TIME_OF_DEPARTURE, ESTIM_TIME_OF_DEPARTURE, ACTUAL_TIME_OF_DEPARTURE) > date_sub('2016-04-03 10:00', interval 4 hour)
   and ACTUAL_TIME_OF_DEPARTURE <= '2016-04-03 10:00'
 group by movement_direction, ACTUAL
 order by ACTUAL

// next 4 hours
select movement_direction,
	   count(movement_direction),
       600 * round(unix_timestamp(SCHEDULED_TIME_OF_DEPARTURE)/600) as PLANNED,
       FROM_UNIXTIME(600 * round(unix_timestamp(SCHEDULED_TIME_OF_DEPARTURE)/600)) as date_window
  from movement_eblg
 where least(SCHEDULED_TIME_OF_DEPARTURE, ESTIM_TIME_OF_DEPARTURE, ACTUAL_TIME_OF_DEPARTURE) < date_add('2016-04-03 10:00', interval 4 hour)
   and greatest(SCHEDULED_TIME_OF_DEPARTURE, ESTIM_TIME_OF_DEPARTURE, ACTUAL_TIME_OF_DEPARTURE) > date_sub('2016-04-03 10:00', interval 4 hour)
   and ACTUAL_TIME_OF_DEPARTURE > '2016-04-03 10:00'
 group by movement_direction, PLANNED
 order by PLANNED




select iata_delay_code, iata_delay_description, sum( round(time_to_sec(timediff(actual_time_of_departure, scheduled_time_of_departure))/60) ) as delay
  from movement_eblg
 where movement_direction = 'd'
   and iata_delay_code <> ''
 group by iata_delay_code, iata_delay_description

create or replace view movement_eblg_delays
as
select iata_delay_code, iata_delay_description, round(time_to_sec(timediff(actual_time_of_departure, scheduled_time_of_departure))/60) as delay
  from movement_eblg
 where movement_direction = 'D'
   and iata_delay_code <> ''
union
select iata_delay_code, iata_delay_description, round(time_to_sec(timediff(actual_time_of_arrival, scheduled_time_of_arrival))/60) as delay
  from movement_eblg
 where movement_direction = 'A'
   and iata_delay_code <> ''


select iata_delay_code, iata_delay_description, sum(delay) as total_delay
from movement_eblg_delays
group by iata_delay_code, iata_delay_description
order by total_delay desc



