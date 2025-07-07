#!/bin/bash


# Automated Health Check Script (Bash)
# This script:

# Checks HTTP/HTTPS endpoints.

# Verifies database connectivity.

# Monitors disk space and CPU usage.

# Logs failures and sends alerts.

# Setup Instructions
# Replace yourserver.com and your_database_details with actual values.

# Schedule it via cron (e.g., run every 5 minutes: crontab -e → */5 * * * * /path/to/health_check.sh).




# Configuration
LOG_FILE="/var/log/health_check.log"
ALERT_EMAIL="admin@example.com"

# Server and service details
WEB_URL="http://yourserver.com/health"
DB_HOST="localhost"
DB_USER="youruser"
DB_PASS="yourpassword"
DB_NAME="yourdatabase"
DISK_THRESHOLD=90  # Alert if disk usage exceeds this (%)
CPU_THRESHOLD=80   # Alert if CPU usage exceeds this (%)

# Check HTTP status
check_http() {
    HTTP_STATUS=$(curl -s -o /dev/null -w "%{http_code}" $WEB_URL)
    if [ "$HTTP_STATUS" -ne 200 ]; then
        log_failure "HTTP check failed! Status: $HTTP_STATUS"
    else
        echo "✅ HTTP check passed"
    fi
}

# Check database connectivity
check_db() {
    mysql -h $DB_HOST -u $DB_USER -p$DB_PASS -e "USE $DB_NAME;" > /dev/null 2>&1
    if [ $? -ne 0 ]; then
        log_failure "Database check failed!"
    else
        echo "✅ Database check passed"
    fi
}

# Check disk space
check_disk() {
    USAGE=$(df / | awk 'NR==2 {print $5}' | sed 's/%//')
    if [ "$USAGE" -gt "$DISK_THRESHOLD" ]; then
        log_failure "Disk usage high: $USAGE%"
    else
        echo "✅ Disk check passed"
    fi
}

# Check CPU usage
check_cpu() {
    CPU_LOAD=$(top -bn1 | grep "Cpu(s)" | awk '{print $2 + $4}')
    CPU_INT=${CPU_LOAD%.*}
    if [ "$CPU_INT" -gt "$CPU_THRESHOLD" ]; then
        log_failure "High CPU usage: $CPU_LOAD%"
    else
        echo "✅ CPU check passed"
    fi
}

# Log failure and send alert
log_failure() {
    MESSAGE="$1"
    echo "$(date) - ERROR: $MESSAGE" | tee -a $LOG_FILE
    echo "$MESSAGE" | mail -s "Health Check Alert" $ALERT_EMAIL
}

# Run checks
echo "Running health checks..."
check_http
check_db
check_disk
check_cpu

echo "Health check completed ✅"
