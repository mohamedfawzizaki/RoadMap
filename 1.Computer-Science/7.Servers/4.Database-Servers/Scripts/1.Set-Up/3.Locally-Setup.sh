#!/bin/bash

# ===============================
# Dynamic MySQL Setup Script for Ubuntu
# Author: Mohamed Fawzi Zaki
# Version: 1.5
# ===============================

# Colors
GREEN="\e[32m"
RED="\e[31m"
YELLOW="\e[33m"
RESET="\e[0m"

# check if local or remote:








echo -e "${GREEN}Updating system packages...${RESET}"
sudo apt update -y && sudo apt upgrade -y || error_exit "Failed to update system packages."

echo -e "${GREEN}Checking if MySQL is installed...${RESET}"
if ! command -v mysql &> /dev/null; then
    echo -e "${GREEN}Installing MySQL Server...${RESET}"
    sudo apt install mysql-server -y || error_exit "Failed to install MySQL Server."
else
    echo -e "${GREEN}MySQL is already installed.${RESET}"
    echo -e "${GREEN}Removing.......=>>>> mysql-server mysql-client mysql-common mysql-server-core-* mysql-client-core-* ${RESET}"
    sudo apt-get purge mysql-server mysql-client mysql-common mysql-server-core-* mysql-client-core-*
    echo -e "${GREEN}Removing.......=>>>> /etc/mysql /var/lib/mysql /var/log/mysql ${RESET}"
    sudo rm -rf /etc/mysql /var/lib/mysql /var/log/mysql
    sudo apt-get autoremove
    sudo apt-get autoclean

    echo -e "${GREEN}Reinstalling.................${RESET}"
    sudo apt-get install mysql-server
fi

echo -e "${GREEN}Starting and enabling MySQL service...${RESET}"
sudo systemctl start mysql || error_exit "Failed to start MySQL service."
sudo systemctl enable mysql || error_exit "Failed to enable MySQL service."


# Function to display error messages and exit
error_exit() {
    echo -e "${RED}Error: $1${RESET}" >&2
    exit 1
}

# Function to validate input
validate_input() {
    if [[ -z "$1" ]]; then
        error_exit "Input cannot be empty. Please try again."
    fi
}

# Function to validate MySQL password
validate_mysql_password() {
    local PASSWORD=$1
    local POLICY=$(sudo mysql -u root -p"$MYSQL_ROOT_PASSWORD" -sN -e "SHOW VARIABLES LIKE 'validate_password.policy';" | awk '{print $2}')
    local LENGTH=$(sudo mysql -u root -p"$MYSQL_ROOT_PASSWORD" -sN -e "SHOW VARIABLES LIKE 'validate_password.length';" | awk '{print $2}')

    if [[ ${#PASSWORD} -lt $LENGTH ]]; then
        error_exit "Password must be at least $LENGTH characters long."
    fi

    if [[ "$POLICY" == "MEDIUM" || "$POLICY" == "STRONG" ]]; then
        if ! [[ "$PASSWORD" =~ [A-Z] ]]; then
            error_exit "Password must contain at least one uppercase letter."
        fi
        if ! [[ "$PASSWORD" =~ [a-z] ]]; then
            error_exit "Password must contain at least one lowercase letter."
        fi
        if ! [[ "$PASSWORD" =~ [0-9] ]]; then
            error_exit "Password must contain at least one number."
        fi
        if [[ "$POLICY" == "STRONG" ]] && ! [[ "$PASSWORD" =~ [[:punct:]] ]]; then
            error_exit "Password must contain at least one special character."
        fi
    fi
}

# Prompting for user input with validation
read -rp "Enter MySQL Root Password: " MYSQL_ROOT_PASSWORD
validate_input "$MYSQL_ROOT_PASSWORD"

read -rp "Enter New MySQL Username: " MYSQL_NEW_USER
validate_input "$MYSQL_NEW_USER"

read -rp "Enter Password for New MySQL User: " MYSQL_NEW_PASSWORD
validate_input "$MYSQL_NEW_PASSWORD"
validate_mysql_password "$MYSQL_NEW_PASSWORD"

read -rp "Enter Database Name to Create: " MYSQL_DATABASE
validate_input "$MYSQL_DATABASE"

# MySQL Config File
MYSQL_CONFIG_FILE="/etc/mysql/mysql.conf.d/mysqld.cnf"


# Check if MySQL root user is using auth_socket
echo -e "${GREEN}Checking MySQL root authentication method...${RESET}"
if sudo mysql -u root -e "SELECT 1;" &> /dev/null; then
    echo -e "${YELLOW}MySQL root user is using auth_socket. Switching to password authentication...${RESET}"
    sudo mysql -u root -e "ALTER USER 'root'@'localhost' IDENTIFIED WITH mysql_native_password BY '$MYSQL_ROOT_PASSWORD'; FLUSH PRIVILEGES;" || error_exit "Failed to set root password."
fi

echo -e "${GREEN}Securing MySQL installation...${RESET}"
sudo mysql -u root -p"$MYSQL_ROOT_PASSWORD" -e "DELETE FROM mysql.user WHERE User='';" || error_exit "Failed to remove anonymous users."
sudo mysql -u root -p"$MYSQL_ROOT_PASSWORD" -e "DROP DATABASE IF EXISTS test;" || error_exit "Failed to drop test database."
sudo mysql -u root -p"$MYSQL_ROOT_PASSWORD" -e "DELETE FROM mysql.db WHERE Db='test' OR Db='test\\_%';" || error_exit "Failed to remove test database privileges."
sudo mysql -u root -p"$MYSQL_ROOT_PASSWORD" -e "FLUSH PRIVILEGES;" || error_exit "Failed to flush privileges."

echo -e "${GREEN}Creating new MySQL user and database...${RESET}"
sudo mysql -u root -p"$MYSQL_ROOT_PASSWORD" -e "CREATE DATABASE IF NOT EXISTS $MYSQL_DATABASE;" || error_exit "Failed to create database."
sudo mysql -u root -p"$MYSQL_ROOT_PASSWORD" -e "CREATE USER '$MYSQL_NEW_USER'@'%' IDENTIFIED BY '$MYSQL_NEW_PASSWORD';" || error_exit "Failed to create new user."
sudo mysql -u root -p"$MYSQL_ROOT_PASSWORD" -e "GRANT ALL PRIVILEGES ON $MYSQL_DATABASE.* TO '$MYSQL_NEW_USER'@'%';" || error_exit "Failed to grant privileges."
sudo mysql -u root -p"$MYSQL_ROOT_PASSWORD" -e "FLUSH PRIVILEGES;" || error_exit "Failed to flush privileges."

echo -e "${GREEN}Configuring MySQL for Remote Access...${RESET}"
sudo sed -i "s/bind-address.*/bind-address = 0.0.0.0/" $MYSQL_CONFIG_FILE || error_exit "Failed to update MySQL bind address."

echo -e "${GREEN}Optimizing MySQL Configuration...${RESET}"
sudo tee -a $MYSQL_CONFIG_FILE > /dev/null <<EOT
[mysqld]
max_connections = 500
innodb_buffer_pool_size = 256M
innodb_flush_log_at_trx_commit = 1
innodb_lock_wait_timeout = 50
log_error = /var/log/mysql/error.log
slow_query_log = 1
slow_query_log_file = /var/log/mysql/mysql-slow.log
long_query_time = 2
EOT

echo -e "${GREEN}Restarting MySQL to apply changes...${RESET}"
sudo systemctl restart mysql || error_exit "Failed to restart MySQL service."

echo -e "${GREEN}Setting up a MySQL backup script...${RESET}"
BACKUP_SCRIPT="/usr/local/bin/mysql_backup.sh"
sudo tee $BACKUP_SCRIPT > /dev/null <<EOT
#!/bin/bash
TIMESTAMP=\$(date +%F-%H%M)
BACKUP_DIR="/var/backups/mysql"
mkdir -p \$BACKUP_DIR || { echo "Failed to create backup directory"; exit 1; }
mysqldump -u root -p'$MYSQL_ROOT_PASSWORD' --all-databases > \$BACKUP_DIR/mysql-\$TIMESTAMP.sql || { echo "Failed to create backup"; exit 1; }
find \$BACKUP_DIR -type f -mtime +7 -exec rm {} \;
EOT

sudo chmod +x $BACKUP_SCRIPT || error_exit "Failed to set execute permissions on backup script."
echo "0 2 * * * root $BACKUP_SCRIPT" | sudo tee -a /etc/crontab || error_exit "Failed to add backup script to crontab."

echo -e "${GREEN}Allowing MySQL through Firewall...${RESET}"
sudo ufw allow 3306/tcp || error_exit "Failed to allow MySQL port through firewall."
sudo ufw reload || error_exit "Failed to reload firewall."

echo -e "${GREEN}MySQL setup completed successfully!${RESET}"
echo "---------------------------------------"
echo -e "${YELLOW}Root User: root${RESET}"
echo -e "${YELLOW}Root Password: $MYSQL_ROOT_PASSWORD${RESET}"
echo -e "${YELLOW}New User: $MYSQL_NEW_USER${RESET}"
echo -e "${YELLOW}New User Password: $MYSQL_NEW_PASSWORD${RESET}"
echo -e "${YELLOW}Database: $MYSQL_DATABASE${RESET}"
echo -e "${YELLOW}Backup Script: $BACKUP_SCRIPT${RESET}"
echo "---------------------------------------"