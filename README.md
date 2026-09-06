**Azure VM is Ubuntu**, || simple hands-on setup for **Apache + PHP**. Azure Linux VMs are normally administered over SSH, and HTTP access requires port **80** to be allowed in the VM's NSG. 

### 1. Azure VM requirements

Create/use an Ubuntu VM with:

```text
OS       : Ubuntu Server
NSG      : SSH 22
           HTTP 80
           HTTPS 443 (optional)
Username : azureuser
```

Connect:

```bash
ssh azureuser@<PUBLIC-IP>
```

### 2. Update Ubuntu

```bash
sudo apt update
sudo apt upgrade -y
```

### 3. Install Apache

```bash
sudo apt install apache2 -y

sudo systemctl start apache2
sudo systemctl enable apache2

sudo systemctl status apache2
```

Check:

```bash
apache2 -v
```

Open:

```text
http://<PUBLIC-IP>
```

You should see the **Apache2 Ubuntu Default Page**.

### 4. Install PHP

```bash
sudo apt install php libapache2-mod-php -y
```

Check PHP:

```bash
php -v
```

Microsoft's Azure documentation also uses Apache + PHP as the standard LAMP-style configuration on Ubuntu VMs. ([Microsoft Learn][2])

### 5. Create PHP test page

```bash
sudo nano /var/www/html/info.php
```

Add:

```php
<?php
phpinfo();
?>
```

Save and restart Apache:

```bash
sudo systemctl restart apache2
```

Open:

```text
http://<PUBLIC-IP>/info.php
```

You should get the **PHP Information** page.

### 6. Create simple PHP website

```bash
sudo nano /var/www/html/index.php
```

Add:

```php
<!DOCTYPE html>
<html>
<head>
    <title>PHP Web Server</title>
</head>
<body>
    <h1>PHP Web Server</h1>
    <h2>Azure VM</h2>

    <?php
        echo "<p>PHP is working!</p>";
        echo "<p>Server: " . gethostname() . "</p>";
        echo "<p>PHP Version: " . phpversion() . "</p>";
    ?>
</body>
</html>
```

Remove the default Apache page:

```bash
sudo rm -f /var/www/html/index.html
```

Then access:

```text
http://<PUBLIC-IP>/index.php
```

### 7. Useful PHP packages

For a more practical PHP server:

```bash
sudo apt install php-cli php-common php-curl php-xml php-mbstring php-mysql -y
```

Check modules:

```bash
php -m
```

Then:

```bash
sudo systemctl restart apache2
```

### Architecture

```text
User Browser
     |
     | HTTP : 80
     ↓
Azure Public IP
     |
     ↓
Azure NSG
Allow TCP 80
     |
     ↓
Ubuntu Azure VM
     |
     ↓
Apache2
     |
     ↓
PHP
     |
     ↓
index.php
```

**Key locations/commands for training:**

| Item           | Value                      |
| -------------- | -------------------------- |
| Web Server     | Apache2                    |
| Language       | PHP                        |
| Document Root  | `/var/www/html/`           |
| Main PHP file  | `/var/www/html/index.php`  |
| Apache service | `apache2`                  |
| PHP version    | `php -v`                   |
| Apache status  | `systemctl status apache2` |
| HTTP Port      | `80`                       |
| HTTPS Port     | `443`                      |
| PHP config     | `/etc/php/`                |

For production, delete `info.php` after testing because `phpinfo()` exposes detailed server configuration information.

[Microsoft Learn: Azure Linux VM documentation](https://learn.microsoft.com/en-us/azure/virtual-machines/linux-vm-connect?utm_source=chatgpt.com)

[1]: https://learn.microsoft.com/en-us/azure/virtual-machines/linux-vm-connect?utm_source=chatgpt.com "Connect to a Linux VM - Azure Virtual Machines | Microsoft Learn"
[2]: https://learn.microsoft.com/zh-cn/azure/virtual-machines/linux/tutorial-lamp-stack?utm_source=chatgpt.com "教程 - 在 VM 上部署 LAMP 和 WordPress - Azure Virtual Machines | Microsoft Learn"
