#!/bin/bash

###############################################################################
# VirtualBox VM Creation Script
# 
# This script automates the creation of VirtualBox virtual machines with:
# - Customizable hardware specifications
# - Unattended OS installation
# - Network port forwarding
# - Input validation and error handling
#
# Usage: Run the script and follow the interactive prompts
###############################################################################

# Set strict error handling:
# -e: Exit immediately if any command fails
# -u: Treat unset variables as errors
# -o pipefail: Consider pipeline failures in error checking
set -euo pipefail

###############################################################################
# COLOR DEFINITIONS FOR USER-FRIENDLY OUTPUT
###############################################################################

# Red color for errors
RED='\033[0;31m'
# Green color for success messages
GREEN='\033[0;32m'
# Yellow color for warnings and prompts
YELLOW='\033[1;33m'
# No Color (reset)
NC='\033[0m'

###############################################################################
# VALIDATION FUNCTIONS
###############################################################################

# Function to validate integer input within a range
# Parameters:
#   $1: Input value to validate
#   $2: Minimum allowed value
#   $3: Maximum allowed value
#   $4: Name of the parameter for error messages
validate_integer() {
    local input="$1"
    local min="$2"
    local max="$3"
    local name="$4"
    
    # Check if input is a number
    if ! [[ "$input" =~ ^[0-9]+$ ]]; then
        echo -e "${RED}Error: $name must be a number${NC}"
        return 1
    fi
    
    # Check minimum value
    if [ "$input" -lt "$min" ]; then
        echo -e "${RED}Error: $name must be at least $min${NC}"
        return 1
    fi
    
    # Check maximum value
    if [ "$input" -gt "$max" ]; then
        echo -e "${RED}Error: $name cannot exceed $max${NC}"
        return 1
    fi
    
    return 0
}

# Function to validate port numbers
# Parameters:
#   $1: Port number to validate
validate_port() {
    local port="$1"
    
    # Check if port is a number and within valid range
    if ! [[ "$port" =~ ^[0-9]+$ ]] || [ "$port" -lt 1024 ] || [ "$port" -gt 65535 ]; then
        echo -e "${RED}Error: Port must be between 1024 and 65535${NC}"
        return 1
    fi
    
    # Check if port is already in use
    if ss -tuln | grep -q ":$port "; then
        echo -e "${RED}Error: Port $port is already in use${NC}"
        return 1
    fi
    
    return 0
}

# Function to validate ISO file
# Parameters:
#   $1: Path to ISO file
validate_iso() {
    local iso_path="$1"
    
    # Check if file exists
    if [ ! -f "$iso_path" ]; then
        echo -e "${RED}Error: ISO not found at $iso_path${NC}"
        return 1
    fi
    
    # Check if file is a valid ISO
    if file "$iso_path" | grep -qv "ISO 9660"; then
        echo -e "${RED}Error: $iso_path doesn't appear to be a valid ISO file${NC}"
        return 1
    fi
    
    return 0
}

# Function to validate VM name
# Parameters:
#   $1: Proposed VM name
validate_vm_name() {
    local name="$1"
    
    # Check for valid characters
    if [[ ! "$name" =~ ^[a-zA-Z0-9_-]+$ ]]; then
        echo -e "${RED}Error: VM name can only contain letters, numbers, hyphens, and underscores${NC}"
        return 1
    fi
    
    # Check if VM with this name already exists
    if VBoxManage list vms | grep -q "\"$name\""; then
        echo -e "${RED}Error: A VM with name '$name' already exists${NC}"
        return 1
    fi
    
    return 0
}

# Function to validate folder path
# Parameters:
#   $1: Folder path to validate
validate_folder() {
    local folder="$1"
    
    # Check if parent directory exists
    if [[ ! -d "$(dirname "$folder")" ]]; then
        echo -e "${RED}Error: Parent directory $(dirname "$folder") does not exist${NC}"
        return 1
    fi
    
    # Warn if folder already exists
    if [[ -d "$folder" ]]; then
        echo -e "${YELLOW}Warning: Folder $folder already exists${NC}"
        read -p "Continue and use existing folder? [y/N]: " USE_EXISTING
        if [[ ! "$USE_EXISTING" =~ ^[yY] ]]; then
            return 1
        fi
    fi
    
    return 0
}

# Function to validate password strength
# Parameters:
#   $1: Password to validate
validate_password() {
    local password="$1"
    
    # Check minimum length
    if [[ ${#password} -lt 8 ]]; then
        echo -e "${RED}Error: Password must be at least 8 characters long${NC}"
        return 1
    fi
    
    return 0
}

###############################################################################
# CLEANUP FUNCTION FOR ERROR HANDLING
###############################################################################

# Function to clean up partially created VM on error
cleanup() {
    echo -e "${RED}Error occurred. Cleaning up...${NC}"
    
    # Unregister and delete VM if it exists
    if VBoxManage list vms | grep -q "\"$VM_NAME\""; then
        VBoxManage unregistervm "$VM_NAME" --delete >/dev/null 2>&1 || true
    fi
    
    # Remove VM folder if it exists
    if [ -d "$VM_FOLDER" ]; then
        rm -rf "$VM_FOLDER" >/dev/null 2>&1 || true
    fi
    
    exit 1
}

# Register the cleanup function to run on error
trap cleanup ERR

###############################################################################
# MAIN SCRIPT - USER INPUT COLLECTION
###############################################################################

echo -e "${GREEN}=== VirtualBox VM Creation Script ===${NC}"

# Prompt for and validate VM name
while true; do
    read -p "Enter VM name (e.g., my-vm-1): " VM_NAME
    if validate_vm_name "$VM_NAME"; then
        break
    fi
done

# Prompt for and validate VM folder
DEFAULT_FOLDER="$HOME/VirtualBox VMs/$VM_NAME"
while true; do
    read -p "Enter VM folder path [default: $DEFAULT_FOLDER]: " VM_FOLDER
    VM_FOLDER=${VM_FOLDER:-$DEFAULT_FOLDER}
    if validate_folder "$VM_FOLDER"; then
        break
    fi
done

# Prompt for and validate ISO path
while true; do
    read -p "Enter full path to Ubuntu ISO (e.g., /home/user/Downloads/ubuntu.iso): " ISO_PATH
    if validate_iso "$ISO_PATH"; then
        break
    fi
done

# Prompt for OS type with suggestions
echo -e "${YELLOW}Common OS types: Ubuntu_64, Ubuntu24_LTS_64, Debian_64, Linux_64${NC}"
read -p "Enter OS type ID [default: Ubuntu24_LTS_64]: " OS_TYPE
OS_TYPE=${OS_TYPE:-Ubuntu24_LTS_64}

# Prompt for and validate username (lowercase only)
while true; do
    read -p "Enter Linux username (lowercase letters only): " USERNAME
    if [[ "$USERNAME" =~ ^[a-z]+$ ]]; then
        break
    else
        echo -e "${RED}Error: Username must contain only lowercase letters${NC}"
    fi
done

# Prompt for full user name
read -p "Enter full user name: " FULL_NAME

# Prompt for and validate password
while true; do
    read -s -p "Enter password (min 8 chars): " PASSWORD
    echo
    if validate_password "$PASSWORD"; then
        read -s -p "Confirm password: " PASSWORD_CONFIRM
        echo
        if [ "$PASSWORD" == "$PASSWORD_CONFIRM" ]; then
            break
        else
            echo -e "${RED}Error: Passwords do not match!${NC}"
        fi
    fi
done

# Prompt for timezone with auto-detection
DEFAULT_TZ=$(timedatectl show --property=Timezone --value 2>/dev/null || echo "CET")
read -p "Enter time zone [default: $DEFAULT_TZ]: " TIMEZONE
TIMEZONE=${TIMEZONE:-$DEFAULT_TZ}

###############################################################################
# HARDWARE CONFIGURATION
###############################################################################

# Prompt for disk size (in MB)
while true; do
    read -p "Enter disk size in MB (default: 32768): " DISK_SIZE
    DISK_SIZE=${DISK_SIZE:-32768}
    if validate_integer "$DISK_SIZE" 1024 131072 "Disk size"; then
        break
    fi
done

# Prompt for memory size (in MB)
while true; do
    read -p "Enter memory size in MB (default: 8192): " MEMORY_SIZE
    MEMORY_SIZE=${MEMORY_SIZE:-8192}
    if validate_integer "$MEMORY_SIZE" 512 131072 "Memory size"; then
        break
    fi
done

# Prompt for VRAM size (in MB)
while true; do
    read -p "Enter VRAM size in MB (default: 128): " VRAM_SIZE
    VRAM_SIZE=${VRAM_SIZE:-128}
    if validate_integer "$VRAM_SIZE" 4 256 "VRAM size"; then
        break
    fi
done

# Prompt for CPU configuration
while true; do
    read -p "Enter number of CPUs (default: 2): " CPU_COUNT
    CPU_COUNT=${CPU_COUNT:-2}
    if validate_integer "$CPU_COUNT" 1 32 "CPU count"; then
        break
    fi
done

# Prompt for CPU execution cap
while true; do
    read -p "Enter CPU execution cap percentage (default: 100): " CPU_CAP
    CPU_CAP=${CPU_CAP:-100}
    if validate_integer "$CPU_CAP" 1 100 "CPU execution cap"; then
        break
    fi
done

###############################################################################
# NETWORK CONFIGURATION - PORT FORWARDING
###############################################################################

echo -e "${YELLOW}Configuring SSH Port Forwarding${NC}"

# Prompt for port forwarding rule name
read -p "Enter port forwarding rule name [default: guestssh]: " PF_NAME
PF_NAME=${PF_NAME:-guestssh}

# Prompt for protocol (TCP/UDP)
read -p "Enter protocol (tcp/udp) [default: tcp]: " PF_PROTOCOL
PF_PROTOCOL=${PF_PROTOCOL:-tcp}

# Prompt for and validate host port
while true; do
    read -p "Enter host port for SSH forwarding [default: 2222]: " HOST_PORT
    HOST_PORT=${HOST_PORT:-2222}
    if validate_port "$HOST_PORT"; then
        break
    fi
done

# Prompt for host IP binding
read -p "Enter host IP to bind to [default: empty for all interfaces]: " HOST_IP
HOST_IP=${HOST_IP:-}

# Prompt for guest port (default: 22 for SSH)
GUEST_PORT=22
read -p "Enter guest SSH port [default: 22]: " GUEST_PORT_INPUT
if [[ -n "$GUEST_PORT_INPUT" ]]; then
    if validate_port "$GUEST_PORT_INPUT"; then
        GUEST_PORT=$GUEST_PORT_INPUT
    else
        echo -e "${YELLOW}Using default port 22 due to invalid input${NC}"
    fi
fi

# Prompt for guest IP binding
read -p "Enter guest IP [default: empty for any]: " GUEST_IP
GUEST_IP=${GUEST_IP:-}

# Construct the port forwarding rule
PF_RULE="${PF_NAME},${PF_PROTOCOL},${HOST_IP},${HOST_PORT},${GUEST_IP},${GUEST_PORT}"
# Clean up any double commas from empty values
PF_RULE=$(echo "$PF_RULE" | sed 's/,,/,/g' | sed 's/,,/,/g')

###############################################################################
# VM CREATION AND CONFIGURATION
###############################################################################

# Set VDI file path
VDI_FILE="$VM_FOLDER/$VM_NAME.vdi"

# Create VM folder
mkdir -p "$VM_FOLDER"

# Step 1: Create the VM
echo -e "${GREEN}[1/8] Creating VM...${NC}"
VBoxManage createvm --name "$VM_NAME" --ostype "$OS_TYPE" --register --basefolder "$VM_FOLDER"

# Step 2: Create virtual hard disk
echo -e "${GREEN}[2/8] Creating virtual hard disk (${DISK_SIZE}MB)...${NC}"
VBoxManage createhd --filename "$VDI_FILE" --size "$DISK_SIZE" --format VDI --variant Standard

# Step 3: Add SATA controller
echo -e "${GREEN}[3/8] Adding SATA controller...${NC}"
VBoxManage storagectl "$VM_NAME" --name "SATA Controller" --add sata --controller IntelAHCI --bootable on

# Step 4: Attach virtual disk
echo -e "${GREEN}[4/8] Attaching VDI...${NC}"
VBoxManage storageattach "$VM_NAME" --storagectl "SATA Controller" --port 0 --device 0 --type hdd --medium "$VDI_FILE"

# Step 5: Add IDE controller
echo -e "${GREEN}[5/8] Adding IDE controller...${NC}"
VBoxManage storagectl "$VM_NAME" --name "IDE Controller" --add ide --bootable on

# Step 6: Attach ISO
echo -e "${GREEN}[6/8] Attaching ISO...${NC}"
VBoxManage storageattach "$VM_NAME" --storagectl "IDE Controller" --port 0 --device 0 --type dvddrive --medium "$ISO_PATH"

# Step 7: Configure VM settings
echo -e "${GREEN}[7/8] Configuring VM settings...${NC}"
VBoxManage modifyvm "$VM_NAME" --ioapic on
VBoxManage modifyvm "$VM_NAME" --boot1 dvd --boot2 disk --boot3 none --boot4 none
VBoxManage modifyvm "$VM_NAME" --memory "$MEMORY_SIZE" --vram "$VRAM_SIZE"
VBoxManage modifyvm "$VM_NAME" --cpus "$CPU_COUNT" --cpuexecutioncap "$CPU_CAP"
VBoxManage modifyvm "$VM_NAME" --nic1 nat --natpf1 "$PF_RULE"
VBoxManage modifyvm "$VM_NAME" --audio none --usb off
VBoxManage modifyvm "$VM_NAME" --graphicscontroller vmsvga

# Step 8: Perform unattended installation
echo -e "${GREEN}[8/8] Running unattended install...${NC}"
VBoxManage unattended install "$VM_NAME" \
    --iso="$ISO_PATH" \
    --user="$USERNAME" \
    --full-user-name="$FULL_NAME" \
    --user-password="$PASSWORD" \
    --install-additions \
    --time-zone="$TIMEZONE" \
    --post-install-command="apt-get update && apt-get upgrade -y"

###############################################################################
# VM STARTUP AND FINAL OUTPUT
###############################################################################

# Start the VM in headless mode (no GUI)
echo -e "${GREEN}Starting VM...${NC}"
VBoxManage startvm "$VM_NAME" --type headless

###############################################################################
# SUCCESS MESSAGE WITH VM DETAILS AND CONFIGURATION SUMMARY
###############################################################################

# Clear screen for better visibility of the summary
clear

# Define log file path
LOG_FILE="${VM_FOLDER}/vm_creation_summary_${VM_NAME}.log"

# Create a function to display and log the output
display_and_log() {
    echo -e "$1" | tee -a "$LOG_FILE"
}

# Redirect all output to both console and log file
{
    # Display success banner
    display_and_log "${GREEN}*******************************************************************************${NC}"
    display_and_log "${GREEN}* VIRTUAL MACHINE CREATED SUCCESSFULLY!                                      *${NC}"
    display_and_log "${GREEN}*******************************************************************************${NC}"
    display_and_log ""

    # Display basic VM information
    display_and_log "${YELLOW}VM Name:${NC} $VM_NAME"
    display_and_log "${YELLOW}Location:${NC} $VM_FOLDER"
    display_and_log "${YELLOW}OS Type:${NC} $OS_TYPE"
    display_and_log "${YELLOW}ISO Used:${NC} $ISO_PATH"
    display_and_log ""

    # Display hardware configuration
    display_and_log "${GREEN}=== HARDWARE CONFIGURATION ==="
    display_and_log "${YELLOW}Disk Size:${NC} $DISK_SIZE MB ($((DISK_SIZE/1024))GB)"
    display_and_log "${YELLOW}Memory:${NC} $MEMORY_SIZE MB ($((MEMORY_SIZE/1024))GB)"
    display_and_log "${YELLOW}VRAM:${NC} $VRAM_SIZE MB"
    display_and_log "${YELLOW}CPU Cores:${NC} $CPU_COUNT"
    display_and_log "${YELLOW}CPU Execution Cap:${NC} $CPU_CAP%"
    display_and_log ""

    # Display user account information
    display_and_log "${GREEN}=== USER ACCOUNT DETAILS ==="
    display_and_log "${YELLOW}Username:${NC} $USERNAME"
    display_and_log "${YELLOW}Full Name:${NC} $FULL_NAME"
    display_and_log "${YELLOW}Timezone:${NC} $TIMEZONE"
    display_and_log ""

    # Display network configuration
    display_and_log "${GREEN}=== NETWORK CONFIGURATION ==="
    display_and_log "${YELLOW}NIC 1:${NC} NAT"
    display_and_log "${YELLOW}Port Forwarding Rule:${NC} $PF_RULE"
    display_and_log ""

    # Display connection instructions if SSH is configured
    if [[ "$PF_PROTOCOL" == "tcp" && "$GUEST_PORT" == "22" ]]; then
        display_and_log "${GREEN}=== CONNECTION INSTRUCTIONS ==="
        if [ -z "$HOST_IP" ]; then
            display_and_log "${YELLOW}SSH Command:${NC} ssh -p ${HOST_PORT} ${USERNAME}@localhost"
        else
            display_and_log "${YELLOW}SSH Command:${NC} ssh -p ${HOST_PORT} ${USERNAME}@${HOST_IP}"
        fi
        display_and_log "${YELLOW}GUI Access:${NC} VirtualBox GUI → Select VM → Show"
        display_and_log ""
    fi

    # Display final notes
    display_and_log "${YELLOW}NOTES:${NC}"
    display_and_log "  - The VM has started in headless mode (no GUI window)"
    display_and_log "  - Guest additions have been installed automatically"
    display_and_log "  - System updates were applied during installation"
    display_and_log ""
    display_and_log "${GREEN}VM creation process completed at $(date)${NC}"
    display_and_log ""
    display_and_log "This summary has been saved to: $LOG_FILE"

} | tee "$LOG_FILE"

# Set appropriate permissions for the log file
chmod 600 "$LOG_FILE"