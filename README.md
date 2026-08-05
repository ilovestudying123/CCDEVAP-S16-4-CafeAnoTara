1. Access your virtual machine (VM) 
i. Access the virtual machine in CCS Cloud using a browser in the link https://ccscloud.dlsu.edu.ph and log in using the username (CCDEVAP##) and password given. Ensure that the ‘Realm’ chosen is ‘Proxmox VE authentication server’. 
ii. Click on each ‘Datacenter’ until you find a machine (lxc) listed in the right part then double-click on that listing. 
iii. It will now display a new tab with options where you can click on the ‘Start’ button at the top to start the machine and a ‘Console’ to access the command line. You can login to the machine using the username root and the same password given to you.
iv. In the command line, start with updating the machine repository using two commands: 
sudo apt upgrade 
 sudo full-upgrade
 
2. Enable SSH to access the VM remotely 
i. Create a new user, using the command and change the user_name: sudo adduser user_name 
Type in your desired password and skip the details 
ii. Allow SSH traffic using the command: sudo ufw allow ssh 
iii. Enable the firewall: sudo ufw enable 
iv. And verify the status, should now display ‘active’: 
ssh -p 604## user_name@ccscloud.dlsu.edu.ph 
b. Then type the user_name’s password that you set. 
vi. a. sudo ufw status 
v. Now, use your own computer’s command line and type the command - change the username to the one you created and the port 604## to the assigned SSH port to you: 
a. The name on your command line (displayed on the left) should be 
user_name@CCDEVAP##-Server and you should be able to run commands on your command line. 
vii. To close connection, type: 
a. logout 
3. Setup GitHub and Upload Files
i. Install the necessary libraries: 
sudo apt install apache2 php libapache2-mod-php php-mysql mariadb-server sqlite3 php-sqlite3 php-gd php-mbstring php-dom
ii. To check if Apache is successfully installed, access the homepage in the link: ‘ccscloud.dlsu.edu.ph:601##’
iii. Next, go to the /var/www/html/ directory and create your web app folder. This will contain all your web app files. 
a. cd /var/www/html 
iv. Using GitHub 
a. Install git to the VM 
1. sudo apt update 
2. sudo apt install git -y 
b. Clone the git repository into /var/www/html 
1. git clone -b MCO2 https://github.com/ilovestudying123/CCDEVAP-S16-4-CafeAnoTara.git
v. Update the password in CCDEVAP-S16-4-CafeAnoTara/backend/config/connection.php
nano connection.php
$password   = "your_password";

3. Setup a Database
i. To setup the MySQL, run the command: mysql_secure_installation 
Enter your preferred password 
Switch to unix_socket authentication [Y/n] n 
Change the root password? [Y/n] n 
Remove anonymous users? [Y/n] y 
Disallow root login remotely? [Y/n] y 
Remove test database and access to it? [Y/n] y 
Reload privilege tables now? [Y/n] y 
ii. Access the MySQL server using the command below then enter your password. Update the root accounts’ privileges. DO NOT CHANGE ANYTHING ELSE aside from the ‘abc123’ to your preferred password. 
a. mysql -u root -p 
b. CREATE USER 'root'@'localhost' IDENTIFIED BY 'abc123'; 
c. ALTER USER 'root'@'localhost' IDENTIFIED WITH auth_socket BY 'abc123'; 
d. SET PASSWORD FOR 'root'@localhost = PASSWORD("abc123"); 
e. GRANT ALL PRIVILEGES ON *.* TO 'root'@'localhost' WITH GRANT OPTION; 
f. CREATE USER 'root'@'192.168.%.%' IDENTIFIED BY 'abc123';
g. ALTER USER 'root'@'192.168.%.%' IDENTIFIED WITH auth_socket BY 'abc123'; 
h. SET PASSWORD FOR 'root'@'192.168.%.%' = PASSWORD("abc123"); 
i. GRANT ALL PRIVILEGES ON *.* TO 'root'@'192.168.%.%' WITH GRANT OPTION; 
j. CREATE USER 'root'@'10.%.%.%' IDENTIFIED BY 'abc123'; 
k. ALTER USER 'root'@'10.%.%.%' IDENTIFIED WITH auth_socket BY 'abc123'; 
l. SET PASSWORD FOR 'root'@'10.%.%.%' = PASSWORD("abc123"); 
m. GRANT ALL PRIVILEGES ON *.* TO 'root'@'10.%.%.%' WITH GRANT OPTION; 
n. flush privileges; 
o. flush privileges; 
p. quit 
vii. Restart the MySQL server to take effect 
a. sudo service mysql restart 
viii. Lastly, allow the HTTP and MySQL ports through the firewall then restart the machine: 
a. sudo ufw allow 80 
b. sudo ufw allow 3306 
c. sudo reboot

4. Setup MySQL Database
i. Open MySQL and create the database that is used by Cafe, Ano Tara?
mysql -u root -p
Enter password from Step 3, ii.
CREATE DATABASE cafeanotara;
EXIT;
ii. Import the SQL file into the database that was created earlier, with the path leading to the SQL file
sudo mysql cafeanotara < /var/www/html/CCDEVAP-S16-4-CafeAnotara/backend/database/cafeanotara.sql
iii. Turn off case sensitivity for the Database
 sudo nano /etc/mysql/mariadb.conf.d/50-server.cnf 
iv. Add this line below the [mysql]
lower_case_table_names = 1 
v. Reset MariaDB
sudo systemctl restart mariadb 

5. Access the Website
i. Replace the link with the HTTP port, and open the link at: “http://ccscloud.dlsu.edu.ph:601##/CCDEVAP-S16-4-CafeAnoTara/”
ii. Enter the FF credentials:
Customer
Email: customer1@gmail.com
		Password: P@ss12345
Owner
Email: owner1@gmail.com
Password: P@ss12345
Admin
Email: admin@gmail.com
Password: P@ss12345
