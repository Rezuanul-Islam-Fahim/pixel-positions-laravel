# Dokploy Deployment Checklist

Use this checklist to ensure a smooth deployment of Pixel Positions Laravel to your VPS.

## Pre-Deployment Checklist

### VPS Setup
- [ ] VPS is running Ubuntu 20.04+ or Debian 11+
- [ ] Have root/sudo access to VPS
- [ ] VPS has at least 2GB RAM and 20GB storage
- [ ] SSH access is configured
- [ ] Domain name is available (optional)

### Dokploy Installation
- [ ] Run: `curl -sSL https://dokploy.com/install.sh | sh`
- [ ] Verify Dokploy is accessible at `http://your-vps-ip:3000`
- [ ] Create admin account in Dokploy
- [ ] Successfully logged into Dokploy dashboard

## Deployment Steps Checklist

### 1. Project Setup
- [ ] Created new project in Dokploy
- [ ] Named project appropriately (e.g., "pixel-positions")

### 2. Application Configuration
- [ ] Created new application in Dokploy
- [ ] Connected GitHub account
- [ ] Selected repository: `Rezuanul-Islam-Fahim/pixel-positions-laravel`
- [ ] Set build type to "Dockerfile"
- [ ] Set Dockerfile path to `./Dockerfile`
- [ ] Selected correct branch (e.g., "main")

### 3. Environment Variables
- [ ] Generated APP_KEY using: `php artisan key:generate --show`
- [ ] Added APP_NAME
- [ ] Added APP_ENV=production
- [ ] Added APP_KEY
- [ ] Set APP_DEBUG=false
- [ ] Added APP_URL with your domain
- [ ] Added all database credentials (DB_*)
- [ ] Added SESSION_DRIVER=database
- [ ] Added QUEUE_CONNECTION=database
- [ ] Added CACHE_STORE=database
- [ ] Added LOG_CHANNEL and LOG_LEVEL
- [ ] Added optional mail configuration (if needed)

### 4. Database Setup
- [ ] Created MySQL 8.0 database in Dokploy
- [ ] Database name matches DB_DATABASE env var
- [ ] Database username matches DB_USERNAME env var
- [ ] Database password matches DB_PASSWORD env var
- [ ] Noted internal database hostname
- [ ] Updated DB_HOST in application env vars

### 5. Port Configuration
- [ ] Set application port to 80
- [ ] Verified port is available

### 6. Deployment
- [ ] Clicked "Deploy" button
- [ ] Monitored build logs for errors
- [ ] Build completed successfully
- [ ] Application started without errors
- [ ] Container is running

### 7. Domain Configuration (Optional)
- [ ] Added domain in Dokploy application settings
- [ ] Enabled SSL certificate generation
- [ ] Configured DNS A records:
  - [ ] @ -> VPS IP address
  - [ ] www -> VPS IP address
- [ ] Waited for DNS propagation
- [ ] Verified HTTPS is working

## Post-Deployment Checklist

### Verification
- [ ] Application is accessible via domain/IP
- [ ] Homepage loads correctly
- [ ] Can navigate through different pages
- [ ] Database connection is working
- [ ] No errors in application logs
- [ ] Static assets (CSS, JS) are loading
- [ ] Forms are working
- [ ] User registration works (if applicable)
- [ ] User login works (if applicable)

### Monitoring & Maintenance
- [ ] Enabled monitoring in Dokploy
- [ ] Set up alerts for crashes
- [ ] Set up alerts for high CPU/memory
- [ ] Configured automatic database backups
- [ ] Set backup frequency (daily recommended)
- [ ] Set backup retention (7 days minimum)
- [ ] Tested backup restoration process

### Security
- [ ] Changed default database passwords
- [ ] APP_DEBUG is set to false
- [ ] Using HTTPS (SSL/TLS enabled)
- [ ] Configured firewall on VPS:
  ```bash
  sudo ufw allow 22/tcp
  sudo ufw allow 80/tcp
  sudo ufw allow 443/tcp
  sudo ufw allow 3000/tcp
  sudo ufw enable
  ```
- [ ] Environment variables contain no sensitive data in Git
- [ ] .env file is in .gitignore
- [ ] Strong passwords used for all services

### Performance
- [ ] Application response time is acceptable
- [ ] Database queries are optimized
- [ ] OPcache is enabled (default in Dockerfile)
- [ ] Considered adding Redis for caching (optional)
- [ ] Log rotation is configured

### Documentation
- [ ] Documented any custom configuration
- [ ] Noted all environment variables used
- [ ] Saved database credentials securely
- [ ] Documented deployment process for team

## Auto-Deployment Setup (Optional)

- [ ] Enabled "Auto Deploy" in Dokploy
- [ ] Selected branch to watch
- [ ] Tested auto-deployment with a small change
- [ ] Verified automatic deployment works

## Troubleshooting Reference

If you encounter issues, refer to:
- [ ] Build logs in Dokploy dashboard
- [ ] Application logs: `docker logs [container-name] -f`
- [ ] DEPLOYMENT.md troubleshooting section
- [ ] Dokploy documentation

## Rollback Plan

- [ ] Know how to access previous deployment
- [ ] Can revert to previous container image
- [ ] Have recent database backup
- [ ] Know how to restore from backup

## Testing Checklist

After deployment, test these critical features:
- [ ] Homepage loads
- [ ] Job listings display
- [ ] Search functionality works
- [ ] User authentication (if applicable)
- [ ] Job creation (if applicable)
- [ ] Tag filtering works
- [ ] Forms submit correctly
- [ ] No JavaScript errors in browser console
- [ ] Mobile responsiveness works
- [ ] Email notifications work (if configured)

## Success Criteria

Your deployment is successful when:
- ✅ Application is live and accessible
- ✅ All features work as expected
- ✅ No errors in logs
- ✅ HTTPS is enabled (if using domain)
- ✅ Monitoring is active
- ✅ Backups are configured
- ✅ Auto-deployment works (if enabled)

## Notes

Use this space to document any custom configurations or issues encountered:

```
Date: _______________
Deployed by: _______________

Custom configurations:
-
-
-

Issues encountered and solutions:
-
-
-
```

## Next Steps

After successful deployment:
1. Monitor application performance for 24-48 hours
2. Test all critical features thoroughly
3. Share the URL with stakeholders
4. Plan for regular maintenance windows
5. Set up monitoring alerts
6. Document any operational procedures

---

**Need Help?**
- Quick Start: See [DOKPLOY.md](DOKPLOY.md)
- Detailed Guide: See [DEPLOYMENT.md](DEPLOYMENT.md)
- Troubleshooting: Check logs and documentation
