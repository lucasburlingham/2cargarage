echo "deleted $(ls /var/www/html/)"
sudo rm -r /var/www/html/*
sudo cp -R * /var/www/html/
echo "copied all files to /var/www/html/"
sudo chown www-data:www-data -R /var/www/html
echo "changed owner to www-data"
