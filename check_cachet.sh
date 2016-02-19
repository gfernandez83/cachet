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

ps aux|grep cachet-monitor |grep -v grep > /dev/null

result=$?

if [ "${result}"  -eq "0" ] 
	then 
	echo "`date`: cachet-monitor is running." >> /var/log/check_cachet.log 2>&1
	else 
	echo "`date`: restarting cachet-monitor." >> /var/log/check_cachet.log 2>&1
	nohup /usr/local/go/bin/cachet-monitor -c /etc/cachet/99uu.json > /var/log/cachet-monitor.log 2>&1 &
fi
