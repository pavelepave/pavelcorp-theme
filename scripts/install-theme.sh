#!/bin/bash

mkdir -p ./wordpress/wp-content/themes/pavelcorp

# Main CSS file
cp -v ./pavelcorp/style.css ./wordpress/wp-content/themes/pavelcorp/style.css

# PHP theme files
# cp -v ./pavelcorp/404.php ./wordpress/wp-content/themes/pavelcorp/404.php
# cp -v ./pavelcorp/author.php ./wordpress/wp-content/themes/pavelcorp/author.php
# cp -v ./pavelcorp/category.php ./wordpress/wp-content/themes/pavelcorp/category.php
cp -v ./pavelcorp/footer.php ./wordpress/wp-content/themes/pavelcorp/footer.php
cp -v ./pavelcorp/functions.php ./wordpress/wp-content/themes/pavelcorp/functions.php
cp -v ./pavelcorp/header.php ./wordpress/wp-content/themes/pavelcorp/header.php
cp -v ./pavelcorp/index.php ./wordpress/wp-content/themes/pavelcorp/index.php
cp -v ./pavelcorp/page.php ./wordpress/wp-content/themes/pavelcorp/page.php
cp -v ./pavelcorp/screenshot.png ./wordpress/wp-content/themes/pavelcorp/screenshot.png
# cp -v ./pavelcorp/search.php ./wordpress/wp-content/themes/pavelcorp/search.php
cp -v ./pavelcorp/single.php ./wordpress/wp-content/themes/pavelcorp/single.php

# README
cp -v ./pavelcorp/LICENSE.md ./wordpress/wp-content/themes/pavelcorp/LICENSE.md
cp -v ./pavelcorp/README.md ./wordpress/wp-content/themes/pavelcorp/README.md


# Main folders
cp -v -r ./pavelcorp/core ./wordpress/wp-content/themes/pavelcorp/
cp -v -r ./pavelcorp/css ./wordpress/wp-content/themes/pavelcorp/
cp -v -r ./pavelcorp/js ./wordpress/wp-content/themes/pavelcorp/
cp -v -r ./pavelcorp/functions ./wordpress/wp-content/themes/pavelcorp/
cp -v -r ./pavelcorp/languages/* ./wordpress/wp-content/themes/pavelcorp/languages
cp -v -r ./pavelcorp/static ./wordpress/wp-content/themes/pavelcorp/
cp -v -r ./pavelcorp/templates ./wordpress/wp-content/themes/pavelcorp/

#custom folders
mkdir -p ./wordpress/wp-content/themes/pavelcorp/css/custom
mkdir -p ./wordpress/wp-content/themes/pavelcorp/js/custom
mkdir -p ./wordpress/wp-content/themes/pavelcorp/php/custom
mkdir -p ./wordpress/wp-content/themes/pavelcorp/templates/custom
mkdir -p ./wordpress/wp-content/themes/pavelcorp/lang

cp -v ./pavelcorp/php/autoload.php ./wordpress/wp-content/themes/pavelcorp/php/autoload.php

echo 'Theme file updated'