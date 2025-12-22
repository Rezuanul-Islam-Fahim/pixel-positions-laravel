# Deploying Pixel Positions Laravel to VPS using Dokploy

This guide will walk you through deploying the Pixel Positions Laravel application to your VPS using Dokploy.

## Prerequisites

Before you begin, ensure you have:

- A VPS with Ubuntu 20.04+ or Debian 11+
- Root or sudo access to your VPS
- A domain name (optional, but recommended)
- Git installed on your VPS
- At least 2GB RAM and 20GB storage

## Step 1: Install Dokploy on Your VPS

SSH into your VPS and run the following command to install Dokploy:

```bash
curl -sSL https://dokploy.com/install.sh | sh
```

This will:
- Install Docker and Docker Compose
- Install Dokploy
- Set up the Dokploy dashboard
- Start Dokploy services

After installation, Dokploy will be accessible at:
```
http://your-vps-ip:3000
```

## Step 2: Access Dokploy Dashboard

1. Open your browser and navigate to `http://your-vps-ip:3000`
2. Complete the initial setup by creating an admin account
3. Log in to the Dokploy dashboard

## Step 3: Create a New Project

1. In the Dokploy dashboard, click on **"Create Project"**
2. Enter a project name (e.g., `pixel-positions`)
3. Click **"Create"**

## Step 4: Add Your Application

1. Inside your project, click **"Create Application"**
2. Choose **"GitHub"** as the source (or your preferred Git provider)
3. Connect your GitHub account if not already connected
4. Select the repository: `Rezuanul-Islam-Fahim/pixel-positions-laravel`
5. Configure the following settings:

### Build Configuration

- **Build Type**: Dockerfile
- **Dockerfile Path**: `./Dockerfile`
- **Branch**: `main` (or your deployment branch)

### Environment Variables

Add the following environment variables (click "Add Variable" for each):

**Required Variables:**
```
APP_NAME=PixelPositions
APP_ENV=production
APP_KEY=base64:YOUR_APP_KEY_HERE
APP_DEBUG=false
APP_URL=https://your-domain.com

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=pixel_positions_laravel
DB_USERNAME=laravel_user
DB_PASSWORD=your_secure_password

SESSION_DRIVER=database
QUEUE_CONNECTION=database
CACHE_STORE=database

LOG_CHANNEL=stack
LOG_LEVEL=error
```

**Optional Variables:**
```
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@your-domain.com
MAIL_FROM_NAME="${APP_NAME}"
```

### Port Configuration

- **Port**: 80

## Step 5: Create a MySQL Database

1. In your project, click **"Create Database"**
2. Choose **"MySQL"**
3. Configure:
   - **Database Name**: `pixel_positions_laravel`
   - **Username**: `laravel_user`
   - **Password**: (use a strong password)
   - **Version**: 8.0
4. Click **"Create"**
5. Note the internal hostname (usually `mysql` or `mysql-[id]`)

Update your application's `DB_HOST` environment variable with this hostname.

## Step 6: Generate APP_KEY

If you don't have an APP_KEY, generate one:

**Option 1: Using Laravel Artisan (locally)**
```bash
php artisan key:generate --show
```

**Option 2: Using PHP directly**
```bash
php -r "echo 'base64:' . base64_encode(random_bytes(32)) . PHP_EOL;"
```

Copy the generated key and add it to the `APP_KEY` environment variable in Dokploy.

## Step 7: Deploy the Application

1. Review all your settings
2. Click **"Deploy"** button
3. Monitor the build logs in real-time
4. Wait for the deployment to complete (this may take 5-10 minutes for the first build)

The deployment process will:
- Clone your repository
- Build the Docker image
- Install PHP dependencies
- Build frontend assets
- Run database migrations
- Start the application

## Step 8: Configure Domain (Optional but Recommended)

### Using Dokploy's Built-in Proxy

1. In your application settings, go to **"Domains"**
2. Click **"Add Domain"**
3. Enter your domain name (e.g., `pixel-positions.example.com`)
4. Enable **"Generate SSL Certificate"** for automatic HTTPS
5. Click **"Add"**

### DNS Configuration

Point your domain to your VPS:
```
A Record: @ -> your-vps-ip
A Record: www -> your-vps-ip
```

Wait for DNS propagation (can take up to 24 hours, usually much faster).

## Step 9: Verify Deployment

1. Visit your domain or `http://your-vps-ip:PORT`
2. You should see the Pixel Positions application
3. Test key functionality:
   - Browse jobs
   - Create an account (if applicable)
   - Post a job (if applicable)

## Step 10: Post-Deployment Tasks

### Set Up Monitoring

In Dokploy:
1. Go to your application settings
2. Enable **"Monitoring"**
3. Set up alerts for:
   - Application crashes
   - High CPU/Memory usage
   - Disk space

### Configure Backups

1. In your project, go to **"Backups"**
2. Enable automatic backups for your database
3. Choose backup frequency (daily recommended)
4. Configure backup retention (keep at least 7 days)

### Set Up Log Rotation

SSH into your VPS and create a log rotation config:

```bash
sudo nano /etc/logrotate.d/laravel
```

Add:
```
/var/log/laravel/*.log {
    daily
    missingok
    rotate 14
    compress
    delaycompress
    notifempty
    create 0640 www-data www-data
    sharedscripts
}
```

## Troubleshooting

### Build Fails

**Check build logs:**
- Look for specific error messages in the Dokploy build logs
- Common issues:
  - Missing environment variables
  - Composer dependency conflicts
  - NPM build errors

**Solutions:**
- Ensure all required environment variables are set
- Try rebuilding with cleared cache
- Check Dockerfile for any syntax errors

### Application Not Starting

**Check application logs:**
```bash
# SSH into your VPS
ssh user@your-vps-ip

# View Docker logs
docker logs [container-name] -f
```

**Common issues:**
- Database connection failures
- Missing APP_KEY
- Permission issues with storage directories

### Database Connection Issues

**Verify:**
- Database is running: Check in Dokploy dashboard
- Correct credentials in environment variables
- DB_HOST matches the internal database hostname

### 500 Internal Server Error

**Debug steps:**
1. Check application logs in Dokploy
2. Verify storage directory permissions
3. Ensure APP_KEY is set correctly
4. Check database migrations have run

**Enable debug mode temporarily:**
- Set `APP_DEBUG=true` in environment variables
- Redeploy
- Check error details
- **Remember to set it back to `false` after debugging!**

### Storage Permission Issues

SSH into your VPS and fix permissions:
```bash
docker exec -it [container-name] sh
chown -R www-data:www-data /var/www/html/storage
chmod -R 775 /var/www/html/storage
```

## Updating Your Application

### Automatic Deployment (Recommended)

1. In Dokploy application settings, enable **"Auto Deploy"**
2. Set the branch to watch (e.g., `main`)
3. Now when you push to GitHub, Dokploy will automatically deploy

### Manual Deployment

1. Push your changes to GitHub
2. In Dokploy, click **"Redeploy"** button
3. Monitor the deployment logs

## Scaling Your Application

### Horizontal Scaling

In Dokploy:
1. Go to application settings
2. Under **"Replicas"**, increase the number of instances
3. Dokploy will load balance between instances

### Vertical Scaling

Upgrade your VPS:
1. Choose a larger VPS plan from your provider
2. Resize your VPS
3. No changes needed in Dokploy

## Security Best Practices

1. **Use Strong Passwords**: For database and admin accounts
2. **Enable SSL/TLS**: Always use HTTPS in production
3. **Keep Updated**: Regularly update your dependencies
4. **Environment Variables**: Never commit `.env` to Git
5. **Firewall**: Configure UFW on your VPS:
   ```bash
   sudo ufw allow 22/tcp
   sudo ufw allow 80/tcp
   sudo ufw allow 443/tcp
   sudo ufw allow 3000/tcp  # Dokploy dashboard
   sudo ufw enable
   ```
6. **Regular Backups**: Enable and test database backups
7. **Monitor Logs**: Regularly check application and error logs

## Performance Optimization

### Enable OPcache

OPcache is already enabled in the Dockerfile. Verify it's working:
```bash
docker exec -it [container-name] php -i | grep opcache
```

### Enable Redis Cache (Optional)

For better performance, consider adding Redis:

1. In Dokploy, create a Redis database
2. Update environment variables:
   ```
   CACHE_STORE=redis
   REDIS_HOST=redis
   REDIS_PASSWORD=your_redis_password
   REDIS_PORT=6379
   ```
3. Redeploy

### Database Optimization

- Regularly optimize database tables
- Add indexes for frequently queried columns
- Monitor slow query logs

## Maintenance Mode

To enable maintenance mode:

```bash
docker exec -it [container-name] php artisan down
```

To disable:
```bash
docker exec -it [container-name] php artisan up
```

## Backup and Restore

### Manual Database Backup

```bash
# SSH into your VPS
docker exec [mysql-container-name] mysqldump -u laravel_user -p pixel_positions_laravel > backup.sql
```

### Restore Database

```bash
docker exec -i [mysql-container-name] mysql -u laravel_user -p pixel_positions_laravel < backup.sql
```

## Resources

- [Dokploy Documentation](https://dokploy.com/docs)
- [Laravel Deployment Documentation](https://laravel.com/docs/deployment)
- [Docker Documentation](https://docs.docker.com/)

## Support

If you encounter issues:
1. Check Dokploy logs in the dashboard
2. Review this deployment guide
3. Consult Laravel documentation
4. Check Dokploy community forums

## Summary

You now have:
- ✅ Pixel Positions Laravel application running on your VPS
- ✅ MySQL database configured
- ✅ Automatic deployments set up (optional)
- ✅ SSL/HTTPS enabled (if domain configured)
- ✅ Monitoring and backups configured

Your application is now live and ready to use!
