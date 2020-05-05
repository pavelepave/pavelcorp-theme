#!/bin/bash

clear
echo "============================================"
echo "WordPress Install Script"
echo "============================================"

echo "Database Name: "
read -e dbname

echo "Database User: "
read -e dbuser

echo "Database Password: "
read -s dbpass

echo "Database prefix: "
read -e dbprefix

echo "run install? (y/n)"
read -e run

if [ "$run" == n ] ; then
	exit
else

	echo "============================================"
	echo "A robot is now installing WordPress for you."
	echo "============================================"

	#change dir to wordpress
	cd wordpress

	#create wp config
	cp wp-config-sample.php wp-config.php

	#set database details with perl find and replace
	perl -pi -e "s/database_name_here/$dbname/g" wp-config.php
	perl -pi -e "s/username_here/$dbuser/g" wp-config.php
	perl -pi -e "s/password_here/$dbpass/g" wp-config.php
	perl -pi -e "s/table_prefix  = 'wp_'/table_prefix  = '$dbprefix'/g" wp-config.php

	#set WP salts
	perl -i -pe'
	  BEGIN {
	    @chars = ("a" .. "z", "A" .. "Z", 0 .. 9);
	    push @chars, split //, "!@#$%^&*()-_ []{}<>~\`+=,.;:/?|";
	    sub salt { join "", map $chars[ rand @chars ], 1 .. 64 }
	  }
	  s/put your unique phrase here/salt()/ge
	' wp-config.php

	#create uploads folder and set permissions
	mkdir wp-content/uploads
	chmod 775 wp-content/uploads

	echo "========================="
	echo "Installation is complete."
	echo "========================="
fi
