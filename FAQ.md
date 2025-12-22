# Frequently Asked Questions (FAQ) - Dokploy Deployment

## General Questions

### Q: What is Dokploy?
**A:** Dokploy is an open-source Platform as a Service (PaaS) that helps you deploy applications to your own VPS easily. It's similar to Heroku or Railway but runs on your infrastructure, giving you full control and lower costs.

### Q: Why use Dokploy instead of deploying manually?
**A:** Dokploy provides:
- Easy deployment with a web interface
- Automatic SSL certificates
- Built-in monitoring and logging
- Database management
- One-click deployments
- Automatic backups
- No need to manually configure nginx, SSL, or Docker

### Q: How much does it cost?
**A:** Dokploy itself is free and open-source. You only pay for:
- Your VPS hosting (usually $5-20/month)
- Domain name (optional, ~$10-15/year)
- That's it!

### Q: What are the minimum VPS requirements?
**A:**
- **RAM**: 2GB minimum (4GB recommended)
- **Storage**: 20GB minimum (40GB recommended)
- **OS**: Ubuntu 20.04+ or Debian 11+
- **CPU**: 1 core minimum (2+ cores recommended)

## Pre-Deployment Questions

### Q: Do I need to know Docker to use this?
**A:** No! While understanding Docker helps, Dokploy handles all Docker complexity for you. Just follow the deployment guide.

### Q: Can I deploy without a domain name?
**A:** Yes! You can access your application via `http://your-vps-ip:PORT`. However, for production, a domain with HTTPS is highly recommended.

### Q: What VPS providers are compatible?
**A:** Any VPS provider works! Popular choices:
- DigitalOcean
- Linode
- Vultr
- Hetzner
- AWS Lightsail
- Google Cloud
- Any provider offering Ubuntu/Debian VPS

### Q: Do I need to install anything on my local machine?
**A:** Only if you want to test locally:
- Git (to clone the repository)
- Docker (for local testing - optional)
- SSH client (to access your VPS)

## Installation Questions

### Q: How long does Dokploy installation take?
**A:** Usually 5-10 minutes. The script installs Docker, Docker Compose, and Dokploy automatically.

### Q: What if the installation fails?
**A:** 
1. Check your VPS meets minimum requirements
2. Ensure you have root/sudo access
3. Try running the script again
4. Check Dokploy documentation for troubleshooting

### Q: Can I install Dokploy on a VPS that already has other services?
**A:** Yes, but be careful:
- Dokploy uses ports 80, 443, and 3000
- If you have services on these ports, there will be conflicts
- Consider using a fresh VPS for Dokploy

### Q: How do I access Dokploy after installation?
**A:** Open your browser and go to `http://your-vps-ip:3000`

## Deployment Questions

### Q: How long does the first deployment take?
**A:** First deployment typically takes 5-10 minutes:
- Building Docker image: 3-5 minutes
- Installing dependencies: 2-3 minutes
- Starting services: 1-2 minutes

### Q: Do I need to redeploy after every code change?
**A:** Yes, but you can enable auto-deploy:
- Enable "Auto Deploy" in Dokploy
- Push to your Git branch
- Dokploy automatically deploys

### Q: What happens to my data during redeployment?
**A:** 
- **Database**: Persisted (not affected)
- **Uploaded files**: Lost unless using volumes (configure storage volume)
- **Environment variables**: Preserved
- **Application code**: Updated to new version

### Q: Can I rollback to a previous version?
**A:** Yes! In Dokploy:
1. Go to your application
2. View deployment history
3. Click "Rollback" on a previous deployment

## Environment Variables Questions

### Q: How do I generate the APP_KEY?
**A:** Two methods:

Method 1 (if you have Laravel locally):
```bash
php artisan key:generate --show
```

Method 2 (using PHP):
```bash
php -r "echo 'base64:' . base64_encode(random_bytes(32)) . PHP_EOL;"
```

### Q: What environment variables are required?
**A:** Essential variables:
- `APP_KEY` - Application encryption key
- `APP_ENV` - Should be "production"
- `APP_DEBUG` - Should be "false" in production
- `DB_HOST`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` - Database credentials

### Q: Can I change environment variables after deployment?
**A:** Yes:
1. Update variables in Dokploy
2. Click "Redeploy" or "Restart"
3. Changes take effect immediately

### Q: Where do I put sensitive values like API keys?
**A:** Always use environment variables in Dokploy, never commit them to Git!

## Database Questions

### Q: Do I need to create the database manually?
**A:** No! Dokploy can create a MySQL database for you with one click.

### Q: Can I use an external database instead?
**A:** Yes! Just set the database environment variables to point to your external database.

### Q: How do I backup my database?
**A:** 
1. Enable automatic backups in Dokploy
2. Or manually: `docker exec [mysql-container] mysqldump -u user -p database > backup.sql`

### Q: Can I access the database directly?
**A:** Yes, but only from within the VPS or via SSH tunnel:
```bash
ssh -L 3306:localhost:3306 user@vps-ip
# Then connect to localhost:3306
```

### Q: What if I need to restore a database backup?
**A:** 
```bash
docker exec -i [mysql-container] mysql -u user -p database < backup.sql
```

## Domain & SSL Questions

### Q: How do I add my domain?
**A:** 
1. In Dokploy, go to your application
2. Click "Domains"
3. Add your domain
4. Enable "Generate SSL Certificate"
5. Update your DNS A records

### Q: How long does SSL certificate generation take?
**A:** Usually 2-5 minutes. Dokploy uses Let's Encrypt automatically.

### Q: What if SSL generation fails?
**A:** Common issues:
- DNS not propagated yet (wait 24 hours)
- Domain not pointing to correct IP
- Port 80/443 blocked by firewall
- Rate limit hit (wait 1 hour)

### Q: Can I use my own SSL certificate?
**A:** Yes, you can configure custom SSL certificates in Dokploy.

### Q: Do I need to renew SSL certificates?
**A:** No! Dokploy automatically renews Let's Encrypt certificates.

## Performance Questions

### Q: How many users can my application handle?
**A:** Depends on your VPS resources:
- 2GB RAM: ~100-500 concurrent users
- 4GB RAM: ~500-2000 concurrent users
- 8GB RAM: ~2000-5000 concurrent users

(These are rough estimates; actual numbers depend on your application)

### Q: How can I improve performance?
**A:** 
1. Upgrade your VPS plan
2. Enable Redis caching
3. Use a CDN for static assets
4. Optimize database queries
5. Enable OPcache (already enabled in our Dockerfile)
6. Add more application replicas in Dokploy

### Q: Can I scale horizontally?
**A:** Yes! In Dokploy:
1. Increase replica count
2. Dokploy automatically load balances
3. Ensure you use database sessions (not file-based)

## Troubleshooting Questions

### Q: My application shows a 500 error, what should I do?
**A:**
1. Check logs: `docker logs [container-name] -f`
2. Verify APP_KEY is set correctly
3. Check database connection
4. Ensure migrations ran successfully
5. Check storage permissions

### Q: The build fails, what's wrong?
**A:** Common causes:
- Missing environment variables
- Composer dependency conflicts
- NPM build errors
- Out of disk space
- Check build logs for specific error

### Q: Application won't start after deployment
**A:**
1. Check container logs
2. Verify database is running
3. Check environment variables
4. Ensure ports aren't conflicting
5. Try redeploying

### Q: How do I view application logs?
**A:**
- In Dokploy dashboard: Go to application → Logs
- Via SSH: `docker logs [container-name] -f`
- Laravel logs: In container at `/var/www/html/storage/logs/`

### Q: My assets (CSS/JS) aren't loading
**A:**
1. Check if `npm run build` completed successfully
2. Clear browser cache
3. Check nginx configuration
4. Verify `APP_URL` is set correctly

## Maintenance Questions

### Q: How do I update my application?
**A:**
1. Push changes to GitHub
2. In Dokploy, click "Redeploy"
3. Wait for deployment to complete

### Q: How do I enable maintenance mode?
**A:**
```bash
docker exec -it [container-name] php artisan down
```

To disable:
```bash
docker exec -it [container-name] php artisan up
```

### Q: How do I run artisan commands?
**A:**
```bash
docker exec -it [container-name] php artisan [command]
```

Examples:
- Clear cache: `php artisan cache:clear`
- Run migrations: `php artisan migrate`
- Create user: `php artisan tinker`

### Q: Can I SSH into the container?
**A:** Yes:
```bash
docker exec -it [container-name] sh
```

### Q: How do I update Laravel dependencies?
**A:**
1. Update `composer.json` locally
2. Push to GitHub
3. Redeploy in Dokploy

## Security Questions

### Q: Is my application secure?
**A:** The setup includes:
- ✅ HTTPS/SSL encryption
- ✅ Container isolation
- ✅ Non-root processes
- ✅ Security headers
- ✅ Environment variable protection

But you should also:
- Use strong passwords
- Keep dependencies updated
- Review code for vulnerabilities
- Monitor logs regularly

### Q: Should I allow access to Dokploy dashboard from anywhere?
**A:** No! Restrict access:
```bash
sudo ufw allow from YOUR_IP to any port 3000
```

### Q: How do I secure my VPS?
**A:**
1. Configure firewall (UFW)
2. Disable root SSH login
3. Use SSH keys instead of passwords
4. Keep system updated
5. Enable automatic security updates

### Q: What ports should be open on my VPS?
**A:**
- Port 22: SSH (restrict to your IP if possible)
- Port 80: HTTP
- Port 443: HTTPS
- Port 3000: Dokploy dashboard (restrict to your IP)

## Cost Questions

### Q: What are the ongoing costs?
**A:**
- VPS: $5-20/month (depends on provider and resources)
- Domain: $10-15/year (optional)
- Dokploy: Free
- SSL Certificates: Free (Let's Encrypt)

### Q: Can I use the free tier of VPS providers?
**A:** Some providers offer free credits:
- DigitalOcean: $200 credit for 60 days
- Linode: $100 credit
- Google Cloud: $300 credit for 90 days

But there's no permanent free tier for VPS.

### Q: How can I reduce costs?
**A:**
1. Start with smaller VPS, upgrade as needed
2. Use single VPS for multiple apps
3. Choose affordable providers (Hetzner, Vultr)
4. Optimize application to use fewer resources

## Advanced Questions

### Q: Can I use Redis for caching?
**A:** Yes! 
1. Create Redis database in Dokploy
2. Update environment variables:
   - `CACHE_STORE=redis`
   - `REDIS_HOST=redis`
   - `REDIS_PORT=6379`
3. Redeploy

### Q: Can I run scheduled tasks (cron jobs)?
**A:** Yes, Laravel's scheduler is built-in. Add to supervisor config:
```ini
[program:laravel-scheduler]
command=php /var/www/html/artisan schedule:work
```

### Q: How do I use Laravel Horizon?
**A:**
1. Install Horizon: `composer require laravel/horizon`
2. Add to supervisor config
3. Redeploy

### Q: Can I deploy multiple environments (staging, production)?
**A:** Yes! Create separate applications in Dokploy:
- One for staging branch
- One for production branch
- Use different domains/ports

### Q: How do I monitor application performance?
**A:** Options:
- Use Dokploy's built-in monitoring
- Install Laravel Telescope
- Use external services (New Relic, DataDog, etc.)
- Set up custom monitoring with Prometheus

## Getting Help

### Q: Where can I get more help?
**A:**
- This repository's [DEPLOYMENT.md](DEPLOYMENT.md) guide
- [Dokploy Documentation](https://dokploy.com/docs)
- [Laravel Documentation](https://laravel.com/docs)
- Dokploy Discord/Community
- GitHub Issues

### Q: Can I get professional help with deployment?
**A:** Yes, consider:
- Hiring a DevOps consultant
- Laravel deployment services
- Freelance developers on Upwork/Fiverr

### Q: How do I report issues with this deployment setup?
**A:** Open an issue on this GitHub repository with:
- Description of the problem
- Error messages/logs
- Steps to reproduce
- Your environment details

## Quick Reference

### Most Used Commands

```bash
# View logs
docker logs [container-name] -f

# Restart application
docker restart [container-name]

# Run artisan command
docker exec -it [container-name] php artisan [command]

# SSH into container
docker exec -it [container-name] sh

# View running containers
docker ps

# Database backup
docker exec [mysql-container] mysqldump -u user -p db > backup.sql
```

### Important Files

- `Dockerfile` - Container configuration
- `docker-compose.yml` - Local development
- `DEPLOYMENT.md` - Complete deployment guide
- `DOKPLOY.md` - Quick start guide
- `.env.production.example` - Environment variables template

### Helpful Links

- [Dokploy Website](https://dokploy.com)
- [Laravel Deployment Docs](https://laravel.com/docs/deployment)
- [Docker Documentation](https://docs.docker.com)

---

**Still have questions?** Check the other documentation files or open an issue on GitHub!
