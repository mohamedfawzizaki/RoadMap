#!/bin/bash

# ===============================
# Advanced MySQL Backup Script
# Author: Mohamed Fawzi Zaki
# Version: 1.0
# ===============================

# backup type :
# -a : all databases
# -spd [db1, db2, db3] : specific databases
# -spt [db1:t1,t2,t3, db2:t1,t2,t3] : specific tables in specefic databases
# -s : structure only
# -d : data only
# -w : routines,events,triggers,single-transaction,default-parallelism
# -c : compression
# -bd: backup directory

# additives:
# email notification

# location:
    # locally : 
    # remote  : 
            # remote server
            # aws s3


# Credinitials:
# 1. connecting to mysql : 
            # username
            # password
            # host
            # port
# 3. connecting to remote server to take  mysql backup from it:
            # username
            # password or use keys
            # host orip
            # port
# 4. connecting to remote server to store mysql backup in it:
            # username
            # password or use keys
            # host orip
            # port
# 3. aws s3 :
            # aws_access_key_id
            # aws_secret_access_key
            # region
            # bucket
            # endpoint




# Configuration
MYSQL_USER="root"                          # MySQL username
MYSQL_PASSWORD="your_root_password"        # MySQL password
BACKUP_DIR="/var/backups/mysql"            # Backup directory
ENCRYPTION_KEY="/path/to/encryption_key"   # Encryption key file (for OpenSSL)
LOG_FILE="/var/log/mysql_backup.log"       # Log file
RETENTION_DAYS=7                           # Number of days to keep backups
COMPRESS=true                              # Enable compression (true/false)
ENCRYPT=true                               # Enable encryption (true/false)
EMAIL_NOTIFY="admin@example.com"           # Email for notifications
DATE=$(date +%F-%H%M)                      # Timestamp for backup files

# Colors for logging
GREEN="\e[32m"
RED="\e[31m"
YELLOW="\e[33m"
RESET="\e[0m"

# Logging function
log() {
    local LOG_LEVEL=$1
    local MESSAGE=$2
    echo -e "$(date "+%Y-%m-%d %H:%M:%S") [$LOG_LEVEL] $MESSAGE" | tee -a "$LOG_FILE"
}

# Error handling function
error_exit() {
    log "ERROR" "$1"
    if [[ -n "$EMAIL_NOTIFY" ]]; then
        echo -e "Subject: MySQL Backup Failed\n\n$1" | sendmail -t "$EMAIL_NOTIFY"
    fi
    exit 1
}

# Validate MySQL credentials
validate_mysql_credentials() {
    if ! mysql -u "$MYSQL_USER" -p"$MYSQL_PASSWORD" -e "SHOW DATABASES;" &> /dev/null; then
        error_exit "Invalid MySQL credentials. Please check the username and password."
    fi
}

# Create backup directory
create_backup_dir() {
    if [[ ! -d "$BACKUP_DIR" ]]; then
        mkdir -p "$BACKUP_DIR" || error_exit "Failed to create backup directory: $BACKUP_DIR"
        log "INFO" "Backup directory created: $BACKUP_DIR"
    fi
}

# Perform MySQL backup
perform_backup() {
    local BACKUP_FILE="$BACKUP_DIR/mysql-backup-$DATE.sql"
    log "INFO" "Starting MySQL backup..."

    # Dump all databases
    mysqldump -u "$MYSQL_USER" -p"$MYSQL_PASSWORD" --all-databases > "$BACKUP_FILE" || error_exit "Failed to create MySQL backup."

    log "INFO" "MySQL backup completed: $BACKUP_FILE"

    # Compress backup
    if [[ "$COMPRESS" == true ]]; then
        log "INFO" "Compressing backup..."
        gzip "$BACKUP_FILE" || error_exit "Failed to compress backup."
        BACKUP_FILE="$BACKUP_FILE.gz"
        log "INFO" "Backup compressed: $BACKUP_FILE"
    fi

    # Encrypt backup
    if [[ "$ENCRYPT" == true ]]; then
        log "INFO" "Encrypting backup..."
        openssl enc -aes-256-cbc -salt -in "$BACKUP_FILE" -out "$BACKUP_FILE.enc" -pass file:"$ENCRYPTION_KEY" || error_exit "Failed to encrypt backup."
        rm -f "$BACKUP_FILE"  # Remove unencrypted backup
        BACKUP_FILE="$BACKUP_FILE.enc"
        log "INFO" "Backup encrypted: $BACKUP_FILE"
    fi

    log "INFO" "Backup completed successfully: $BACKUP_FILE"
}

# Clean up old backups
cleanup_old_backups() {
    log "INFO" "Cleaning up backups older than $RETENTION_DAYS days..."
    find "$BACKUP_DIR" -type f -name "mysql-backup-*" -mtime +"$RETENTION_DAYS" -exec rm -f {} \;
    log "INFO" "Old backups cleanup completed."
}

# Send success notification
send_notification() {
    if [[ -n "$EMAIL_NOTIFY" ]]; then
        echo -e "Subject: MySQL Backup Successful\n\nBackup completed successfully: $BACKUP_FILE" | sendmail -t "$EMAIL_NOTIFY"
        log "INFO" "Notification email sent to $EMAIL_NOTIFY"
    fi
}

# Main script execution
main() {
    log "INFO" "Starting MySQL backup process..."
    validate_mysql_credentials
    create_backup_dir
    perform_backup
    cleanup_old_backups
    send_notification
    log "INFO" "MySQL backup process completed successfully."
}

# Run the script
main

























#----------------------------------------------------------------------------------------------------
#!/bin/bash

# MySQL Credentials
DB_USER="root"
DB_PASS="your_password"
DB_NAME="my_database"

# Backup Directory
BACKUP_DIR="/path/to/backup"
TIMESTAMP=$(date +"%Y%m%d_%H%M%S")

# Create backup directory if not exists
mkdir -p "$BACKUP_DIR"

# Backup Type Selection
echo "Select Backup Type:"
echo "1) Full Backup (Structure + Data)"
echo "2) Structure Only"
echo "3) Data Only"
read -p "Enter choice [1-3]: " choice

case $choice in
    1)
        BACKUP_FILE="$BACKUP_DIR/${DB_NAME}_full_$TIMESTAMP.sql"
        mysqldump -u "$DB_USER" -p"$DB_PASS" "$DB_NAME" > "$BACKUP_FILE"
        echo "✅ Full Backup Created: $BACKUP_FILE"
        ;;
    2)
        BACKUP_FILE="$BACKUP_DIR/${DB_NAME}_structure_$TIMESTAMP.sql"
        mysqldump -u "$DB_USER" -p"$DB_PASS" --no-data "$DB_NAME" > "$BACKUP_FILE"
        echo "✅ Structure-Only Backup Created: $BACKUP_FILE"
        ;;
    3)
        BACKUP_FILE="$BACKUP_DIR/${DB_NAME}_data_$TIMESTAMP.sql"
        mysqldump -u "$DB_USER" -p"$DB_PASS" --no-create-info "$DB_NAME" > "$BACKUP_FILE"
        echo "✅ Data-Only Backup Created: $BACKUP_FILE"
        ;;
    *)
        echo "❌ Invalid choice. Exiting."
        exit 1
        ;;
esac

# Compress Backup File
gzip "$BACKUP_FILE"
echo "📦 Backup Compressed: ${BACKUP_FILE}.gz"

#----------------------------------------------------------------------------------------------------
#!/bin/bash

# MySQL Credentials
DB_USER="root"
DB_PASS="your_password"
DB_NAME="my_database"

# Backup Directory (Change this to your actual backup folder)
BACKUP_DIR="/path/to/backup"

# List available backups
echo "Available backup files in $BACKUP_DIR:"
ls -1 "$BACKUP_DIR"/*.sql* 2>/dev/null
echo

# Ask user to select a backup file
read -p "Enter the backup filename to restore (with extension): " BACKUP_FILE
BACKUP_PATH="$BACKUP_DIR/$BACKUP_FILE"

# Check if file exists
if [[ ! -f "$BACKUP_PATH" ]]; then
    echo "❌ Backup file not found!"
    exit 1
fi

# Backup Type Selection
echo "Select Restore Type:"
echo "1) Full Restore (Structure + Data)"
echo "2) Structure Only"
echo "3) Data Only"
read -p "Enter choice [1-3]: " choice

# Ensure database exists before restoring
mysql -u "$DB_USER" -p"$DB_PASS" -e "CREATE DATABASE IF NOT EXISTS $DB_NAME;"

case $choice in
    1)
        echo "🔄 Restoring full backup..."
        if [[ "$BACKUP_PATH" == *.gz ]]; then
            gunzip -c "$BACKUP_PATH" | mysql -u "$DB_USER" -p"$DB_PASS" "$DB_NAME"
        else
            mysql -u "$DB_USER" -p"$DB_PASS" "$DB_NAME" < "$BACKUP_PATH"
        fi
        echo "✅ Full restore completed!"
        ;;
    2)
        echo "🔄 Restoring table structures only..."
        if [[ "$BACKUP_PATH" == *.gz ]]; then
            gunzip -c "$BACKUP_PATH" | grep -v "INSERT INTO" | mysql -u "$DB_USER" -p"$DB_PASS" "$DB_NAME"
        else
            grep -v "INSERT INTO" "$BACKUP_PATH" | mysql -u "$DB_USER" -p"$DB_PASS" "$DB_NAME"
        fi
        echo "✅ Structure-only restore completed!"
        ;;
    3)
        echo "🔄 Restoring data only..."
        if [[ "$BACKUP_PATH" == *.gz ]]; then
            gunzip -c "$BACKUP_PATH" | grep "INSERT INTO" | mysql -u "$DB_USER" -p"$DB_PASS" "$DB_NAME"
        else
            grep "INSERT INTO" "$BACKUP_PATH" | mysql -u "$DB_USER" -p"$DB_PASS" "$DB_NAME"
        fi
        echo "✅ Data-only restore completed!"
        ;;
    *)
        echo "❌ Invalid choice. Exiting."
        exit 1
        ;;
esac

#----------------------------------------------------------------------------------------------------