# Docker Configuration

This directory contains Docker-related configuration files for deploying the Pixel Positions Laravel application.

## Directory Structure

```
docker/
├── nginx/
│   └── default.conf         # Nginx web server configuration
├── supervisor/
│   └── supervisord.conf     # Supervisor process manager configuration
└── entrypoint.sh           # Container startup script
```

## Files Description

### nginx/default.conf

Nginx configuration for serving the Laravel application:
- Listens on port 80
- Routes requests to PHP-FPM (running on port 9000)
- Handles static files
- Configures proper security headers
- Sets maximum upload size to 20MB

### supervisor/supervisord.conf

Supervisor configuration that manages multiple processes:
- **php-fpm**: PHP FastCGI Process Manager
- **nginx**: Web server
- **laravel-worker**: Queue worker for background jobs

All processes are configured to:
- Start automatically
- Restart on failure
- Log to stdout/stderr for Docker logging

### entrypoint.sh

Container startup script that:
1. Waits for database to be ready
2. Creates necessary storage directories
3. Sets proper file permissions
4. Runs Laravel optimizations (cache config, routes, views)
5. Runs database migrations
6. Starts supervisor to manage all services

## Usage

These files are automatically used when building the Docker image with:

```bash
docker build -t pixel-positions .
```

Or when using docker-compose:

```bash
docker-compose up -d
```

## Customization

### Changing Nginx Configuration

Edit `nginx/default.conf` to:
- Modify upload size limit
- Add custom headers
- Configure additional security settings
- Add custom routes or redirects

After making changes, rebuild the Docker image.

### Modifying Supervisor Configuration

Edit `supervisor/supervisord.conf` to:
- Adjust number of queue workers
- Add new Laravel processes (scheduler, horizon, etc.)
- Modify restart policies
- Change logging configuration

### Updating Entrypoint Script

Edit `entrypoint.sh` to:
- Add custom startup commands
- Modify database wait logic
- Add additional Laravel artisan commands
- Configure custom health checks

**Note**: After editing `entrypoint.sh`, ensure it remains executable with Unix line endings (LF, not CRLF).

## Troubleshooting

### Permission Issues

If you encounter permission errors:

```bash
docker exec -it [container-name] sh
chown -R www-data:www-data /var/www/html/storage
chmod -R 775 /var/www/html/storage
```

### Nginx Not Starting

Check nginx configuration:

```bash
docker exec -it [container-name] nginx -t
```

### PHP-FPM Issues

View PHP-FPM logs:

```bash
docker exec -it [container-name] cat /var/log/php-fpm.log
```

### Queue Worker Issues

Check worker logs:

```bash
docker exec -it [container-name] cat /var/www/html/storage/logs/worker.log
```

## Best Practices

1. **Don't modify files directly in running containers** - Changes will be lost on restart
2. **Always rebuild after configuration changes** - Use `docker build` or `docker-compose build`
3. **Test changes locally** - Use docker-compose to test before deploying to production
4. **Monitor logs** - Use `docker logs [container-name] -f` to watch for issues
5. **Keep backups** - Always backup database before major changes

## Security Considerations

- Supervisor runs as root (required for managing services)
- PHP-FPM runs as www-data (non-root)
- Laravel workers run as www-data (non-root)
- Nginx runs as root but workers run as www-data
- All sensitive configuration should be in environment variables, not these files

## Related Documentation

- [DEPLOYMENT.md](../DEPLOYMENT.md) - Complete deployment guide
- [DOKPLOY.md](../DOKPLOY.md) - Quick start for Dokploy
- [README.md](../README.md) - Project overview
