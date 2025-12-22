# Quick Start - Dokploy Deployment

This is a quick reference guide for deploying to Dokploy. For detailed instructions, see [DEPLOYMENT.md](DEPLOYMENT.md).

## Prerequisites
- VPS with Ubuntu 20.04+ or Debian 11+
- Domain name (optional)

## Installation Steps

### 1. Install Dokploy on VPS
```bash
curl -sSL https://dokploy.com/install.sh | sh
```

### 2. Access Dashboard
Open `http://your-vps-ip:3000` in your browser

### 3. Create Project & Application
- Create a new project
- Add application from GitHub repository
- Select: `Rezuanul-Islam-Fahim/pixel-positions-laravel`

### 4. Configure Environment Variables

**Essential variables:**
```env
APP_NAME=PixelPositions
APP_ENV=production
APP_KEY=base64:YOUR_GENERATED_KEY
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
```

### 5. Create MySQL Database
- In Dokploy, create a MySQL 8.0 database
- Use the same credentials as in environment variables

### 6. Deploy
Click the "Deploy" button and wait for completion (5-10 minutes)

### 7. Configure Domain (Optional)
- Add your domain in Dokploy
- Enable SSL certificate
- Update DNS A records to point to your VPS IP

## Generate APP_KEY

```bash
# Option 1: Using Laravel
php artisan key:generate --show

# Option 2: Using PHP
php -r "echo 'base64:' . base64_encode(random_bytes(32)) . PHP_EOL;"
```

## Quick Commands

### View Logs
```bash
docker logs [container-name] -f
```

### Run Migrations
```bash
docker exec -it [container-name] php artisan migrate
```

### Clear Cache
```bash
docker exec -it [container-name] php artisan cache:clear
```

### Maintenance Mode
```bash
# Enable
docker exec -it [container-name] php artisan down

# Disable
docker exec -it [container-name] php artisan up
```

## Troubleshooting

| Issue | Solution |
|-------|----------|
| Build fails | Check build logs, verify environment variables |
| Database connection error | Verify DB_HOST, credentials, and database is running |
| 500 error | Check logs, verify APP_KEY is set, check permissions |
| Assets not loading | Ensure `npm run build` completed successfully |

## Need Help?

See the complete [DEPLOYMENT.md](DEPLOYMENT.md) guide for detailed instructions and troubleshooting.

## Files Included

This repository includes all necessary files for Dokploy deployment:

- `Dockerfile` - Container configuration
- `docker-compose.yml` - Local testing setup
- `.dockerignore` - Build optimization
- `docker/nginx/default.conf` - Nginx web server config
- `docker/supervisor/supervisord.conf` - Process manager config
- `docker/entrypoint.sh` - Container startup script
- `DEPLOYMENT.md` - Complete deployment guide
