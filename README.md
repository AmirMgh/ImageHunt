A web game designed to hunt images! This game was developed during Morbify hackathon event.
Contributors: Kazem Jahanbakhsh, Ajay Sridharan, Amir Moghaddam, Priyanka Gupta & AmirHossein Hajizadeh

Dependencies:
1) You need to have installed Apache + PhP + MySql
2) You need to install curl. In ubuntu, try below to install curl extension for php:
sudo apt-get install php5-curl
sudo /etc/init.d/apache2 restart
Read the following link for more information:
http://www.php.net/manual/en/curl.setup.php
3) You also need GD extension for php.
Go the following link for more information:
http://php.net/manual/en/image.installation.php
In ubuntu, follow below steps:
sudo apt-get install php5-gd
sudo /etc/init.d/apache2 restart
4) You need to create the required database and tables in MySql.
5) Finally you need to give the right permissions to apache user. Follow steps below in Ubuntu:
sudo chown -R www-data:www-data tmp
sudo chmod -R g+w tmp/

If you have any other questions, feel free to contact me @ k.jahanbakhsh@gmail.com
