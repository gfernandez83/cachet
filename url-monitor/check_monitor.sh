#!/bin/bash



if [ -f /tmp/check_monitor.lock ]
	then 
	echo "$0 already running, check PID $(cat /tmp/check_monitor.lock)"
	exit 1
fi

function finish {
	rm /tmp/check_monitor.lock
}

trap finish EXIT

echo -n ${PID} > /tmp/check_monitor.lock

#ps aux|grep -e 99uu -e nb88 -e aubo |grep -v grep > /dev/null
#for i in 99uu nb88 aubo cms palazzo gpi massimo apollo betsoft crescendo png 
for i in 99uu cms apollo betsoft crescendo gpi massimo palazzo png 
do
	ps aux|grep $i |grep -v grep > /dev/null
	result=$?
	echo  $result
	if [ "${result}" -eq 0   ]
	then 
	echo "`date`: url monitoring for ${i} is running." >> /var/log/check_monitor.log 2>&1
	else 
	echo "`date`: starting ${i} url-monitor." >> /var/log/check_${i}_monitor.log 2>&1
	nohup /usr/bin/php /etc/cachet/url-monitor/url-monitor.php /etc/cachet/url-monitor/${i}.json > /var/log/check_${i}_monitor.log 2>&1 &
	fi
	sleep 10
done

