##data today
select round(avg(value)) as avg_response_time from metric_points where metric_id=4 and DATE(created_at) = DATE(NOW());
##data past week
select round(avg(value)) as weekly_response_time from metric_points where metric_id=4 and created_at > date_sub(now(), interval 1 week);
##data past month

##data whole year




