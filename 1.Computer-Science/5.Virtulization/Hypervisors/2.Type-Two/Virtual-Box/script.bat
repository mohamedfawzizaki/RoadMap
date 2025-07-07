@echo off
setlocal

:: Prompt for input
set /p VM_NAME=Enter VM name (e.g., my-vm-1): 
set "DEFAULT_FOLDER=D:\VirtualBox\%VM_NAME%"
set /p VM_FOLDER=Enter VM folder path [default: %DEFAULT_FOLDER%]: 
if "%VM_FOLDER%"=="" set "VM_FOLDER=%DEFAULT_FOLDER%"
set /p ISO_PATH=Enter full path to Ubuntu ISO (e.g., D:\ISOs\ubuntu.iso): 
if not exist "%ISO_PATH%" (
    echo ISO not found at %ISO_PATH%
    pause
    exit /b
)
set /p OS_TYPE=Enter OS type ID [default: Ubuntu24_LTS_64]: 
if "%OS_TYPE%"=="" set OS_TYPE=Ubuntu24_LTS_64
set /p USERNAME=Enter Linux username: 
set /p FULL_NAME=Enter full user name: 
set /p PASSWORD=Enter password: 
set /p TIMEZONE=Enter time zone [default: CET]: 
if "%TIMEZONE%"=="" set TIMEZONE=CET

:: Derived variable
set "VDI_FILE=%VM_FOLDER%\%VM_NAME%.vdi"

:: Begin execution
echo Creating VM folder...
mkdir "%VM_FOLDER%"

echo Creating VM...
VBoxManage createvm --name "%VM_NAME%" --ostype "%OS_TYPE%" --register

echo Creating virtual hard disk...
VBoxManage createhd --filename "%VDI_FILE%" --size 32768

echo Adding SATA controller...
VBoxManage storagectl "%VM_NAME%" --name "SATA Controller" --add sata --controller IntelAHCI

echo Attaching VDI...
VBoxManage storageattach "%VM_NAME%" --storagectl "SATA Controller" --port 0 --device 0 --type hdd --medium "%VDI_FILE%"

echo Adding IDE controller...
VBoxManage storagectl "%VM_NAME%" --name "IDE Controller" --add ide

echo Attaching ISO...
VBoxManage storageattach "%VM_NAME%" --storagectl "IDE Controller" --port 0 --device 0 --type dvddrive --medium "%ISO_PATH%"

echo Configuring VM...
VBoxManage modifyvm "%VM_NAME%" --ioapic on
VBoxManage modifyvm "%VM_NAME%" --boot1 dvd --boot2 disk --boot3 none --boot4 none
VBoxManage modifyvm "%VM_NAME%" --memory 8192 --vram 128

echo Starting unattended install...
VBoxManage unattended install "%VM_NAME%" ^
    --iso="%ISO_PATH%" ^
    --user=%USERNAME% ^
    --full-user-name=%FULL_NAME% ^
    --user-password=%PASSWORD% ^
    --install-additions ^
    --time-zone=%TIMEZONE%

echo Starting VM...
VBoxManage startvm "%VM_NAME%"

echo Done!
pause
