#!/bin/bash

PID=$$

if [ -f /tmp/check_cachet.lock ]
	then 
	echo "$0 already running, check PID $(cat /tmp/check_cachet.lock)"
	exit 1
fi

function finish {
	rm /tmp/check_cachet.lock
}

trap finish EXIT

echo -n ${PID} > /tmp/check_cachet.lock

#ps aux|grep -e 99uu -e nb88 -e aubo |grep -v grep > /dev/null
for i in 99uu nb88 aubo 
do
	ps aux|grep $i |grep -v grep > /dev/null
	result=$?
	echo  $result
	if [ "${result}" -eq 0   ]
	then 
	echo "`date`: cachet-monitor for ${i} is running." >> /var/log/check_cachet.log 2>&1
	else 
	echo "`date`: starting ${i} cachet-monitor." >> /var/log/check_cachet.log 2>&1
	nohup /usr/local/go/bin/cachet-monitor -c /etc/cachet/${i}.json > /var/log/cachet-monitor.log 2>&1 &
	fi

done

