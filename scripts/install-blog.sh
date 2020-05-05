#!/bin/bash

clear
echo "============================================"
echo "Blog Install Script"
echo "============================================"

echo "Host: "
read -e wphost

echo "Admin Login: "
read -e wpname

echo "Admin Email: "
read -e wpemail

echo "Admin pass: "
read -s wppass

echo "Blog title: "
read -e wptitle

echo "run install? (y/n)"
read -e run

if [ "$run" == n ] ; then
	exit
else

	curl "$wphost/wp-admin/install.php?step=2" \
		-d "weblog_title=$wptitle
			&user_name=$wpname
			&admin_password=$wppass
			&admin_password2=$wppass
			&admin_email=$wpemail"
fi
