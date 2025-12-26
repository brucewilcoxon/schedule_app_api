# Server Configuration Guide for Image Uploads

This document provides instructions for configuring your Ubuntu server to support large image uploads (up to 5MB).

## Overview

The application requires specific PHP and web server configurations to handle image uploads properly. The configuration depends on your server setup:

- **Apache + mod_php**: Uses `.htaccess` file (already configured)
- **Apache + PHP-FPM**: Requires `.user.ini` file
- **Nginx + PHP-FPM**: Requires both Nginx and PHP-FPM configuration

## Required PHP Settings

The following PHP settings must be configured:

```ini
upload_max_filesize = 10M
post_max_size = 12M
max_execution_time = 300
max_input_time = 300
```

**Note**: `post_max_size` must be larger than `upload_max_filesize`.

## Configuration by Server Type

### Option 1: Apache with mod_php

The `.htaccess` file in `public/.htaccess` should handle this automatically. If it doesn't work, check:

1. Apache has `mod_php` enabled
2. `AllowOverride` is set to `All` or `FileInfo` in your Apache virtual host configuration
3. Restart Apache after changes: `sudo systemctl restart apache2`

### Option 2: Apache/Nginx with PHP-FPM

#### Step 1: Create `.user.ini` file

Create a file named `.user.ini` in the `public` directory with the following content:

```ini
upload_max_filesize = 10M
post_max_size = 12M
max_execution_time = 300
max_input_time = 300
```

**Location**: `schedule_app_api/public/.user.ini`

**Note**: `.user.ini` files are read by PHP-FPM and work similarly to `.htaccess` but for PHP-FPM.

#### Step 2: Configure PHP-FPM Pool

Edit your PHP-FPM pool configuration file (usually located at `/etc/php/{version}/fpm/pool.d/www.conf`):

```ini
request_terminate_timeout = 300s
```

Replace `{version}` with your PHP version (e.g., `8.1`, `8.2`).

#### Step 3: Restart PHP-FPM

```bash
sudo systemctl restart php{version}-fpm
```

Replace `{version}` with your PHP version.

### Option 3: Nginx with PHP-FPM

#### Step 1: Configure Nginx

Edit your Nginx site configuration file (usually in `/etc/nginx/sites-available/your-site`):

```nginx
server {
    # ... existing configuration ...
    
    # Increase client body size limit
    client_max_body_size 12M;
    
    # Increase timeouts for large uploads
    client_body_timeout 300s;
    proxy_read_timeout 300s;
    proxy_connect_timeout 300s;
    
    location ~ \.php$ {
        # ... existing PHP configuration ...
        
        # Increase FastCGI timeout
        fastcgi_read_timeout 300s;
        fastcgi_send_timeout 300s;
    }
}
```

#### Step 2: Create `.user.ini` file

Follow Step 1 from "Option 2" above.

#### Step 3: Configure PHP-FPM Pool

Follow Step 2 from "Option 2" above.

#### Step 4: Restart Services

```bash
sudo systemctl restart nginx
sudo systemctl restart php{version}-fpm
```

## Verification

After making changes, verify the configuration:

### Check PHP Settings

Create a temporary PHP file in your `public` directory:

```php
<?php
phpinfo();
```

Access it via your browser and check:
- `upload_max_filesize` should be `10M` or higher
- `post_max_size` should be `12M` or higher
- `max_execution_time` should be `300` or higher
- `max_input_time` should be `300` or higher

**Important**: Delete this file after verification for security.

### Check PHP-FPM Settings (if applicable)

```bash
php-fpm{version} -i | grep request_terminate_timeout
```

### Check Nginx Settings (if applicable)

```bash
nginx -T | grep client_max_body_size
nginx -T | grep client_body_timeout
```

## Troubleshooting

### Uploads Still Failing

1. **Check Laravel logs**: `storage/logs/laravel.log`
   - Look for PHP configuration values logged during upload attempts
   - Verify the actual values match your expectations

2. **Check web server error logs**:
   - Apache: `/var/log/apache2/error.log`
   - Nginx: `/var/log/nginx/error.log`

3. **Check PHP-FPM error logs**:
   - Usually: `/var/log/php{version}-fpm.log`

4. **Verify file permissions**:
   ```bash
   chmod 755 public
   chmod 644 public/.user.ini  # if using .user.ini
   ```

5. **Check disk space**:
   ```bash
   df -h
   ```

### Common Issues

#### Issue: `.htaccess` not working
- **Solution**: Check if `AllowOverride` is enabled in Apache config
- **Alternative**: Use `.user.ini` for PHP-FPM setups

#### Issue: Timeout errors
- **Solution**: Increase all timeout values (PHP, PHP-FPM, Nginx/Apache)
- **Check**: All timeout layers must be configured

#### Issue: "413 Request Entity Too Large"
- **Solution**: Increase `client_max_body_size` in Nginx or `LimitRequestBody` in Apache

## Security Notes

- Never expose `phpinfo()` files in production
- Ensure `.user.ini` files are not publicly accessible (they should be in `public` directory which is safe)
- Regularly check and clean uploaded files
- Consider implementing file type validation and virus scanning

## Additional Resources

- [PHP Configuration](https://www.php.net/manual/en/ini.core.php)
- [Nginx File Upload Configuration](https://nginx.org/en/docs/http/ngx_http_core_module.html#client_max_body_size)
- [PHP-FPM Configuration](https://www.php.net/manual/en/install.fpm.configuration.php)

