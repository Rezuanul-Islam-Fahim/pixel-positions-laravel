# Deployment Architecture

This document explains the architecture of the Pixel Positions Laravel application when deployed using Dokploy.

## System Architecture

```
┌─────────────────────────────────────────────────────────────┐
│                         Internet                             │
└──────────────────────┬──────────────────────────────────────┘
                       │
                       │ HTTPS (443) / HTTP (80)
                       │
                ┌──────▼──────┐
                │   Dokploy   │
                │    Proxy    │
                │  (Traefik)  │
                └──────┬──────┘
                       │
                       │ HTTP (80)
                       │
        ┌──────────────▼──────────────┐
        │    Docker Container         │
        │  (Pixel Positions App)      │
        │                             │
        │  ┌───────────────────────┐  │
        │  │   Supervisor          │  │
        │  │                       │  │
        │  │  ┌─────────────────┐  │  │
        │  │  │   Nginx :80     │  │  │
        │  │  └────────┬────────┘  │  │
        │  │           │           │  │
        │  │  ┌────────▼────────┐  │  │
        │  │  │  PHP-FPM :9000  │  │  │
        │  │  │  (Laravel App)  │  │  │
        │  │  └─────────────────┘  │  │
        │  │                       │  │
        │  │  ┌─────────────────┐  │  │
        │  │  │ Queue Worker    │  │  │
        │  │  │ (Background)    │  │  │
        │  │  └─────────────────┘  │  │
        │  └───────────────────────┘  │
        └──────────────┬──────────────┘
                       │
                       │ MySQL Protocol (3306)
                       │
        ┌──────────────▼──────────────┐
        │    Docker Container         │
        │    (MySQL Database)         │
        │                             │
        │  ┌───────────────────────┐  │
        │  │   MySQL 8.0           │  │
        │  │   Database            │  │
        │  │   Storage Volume      │  │
        │  └───────────────────────┘  │
        └─────────────────────────────┘
```

## Component Details

### Dokploy Proxy (Traefik)

- **Purpose**: Reverse proxy and load balancer
- **Functions**:
  - Routes incoming traffic to correct application
  - Handles SSL/TLS termination
  - Manages domain routing
  - Generates and renews SSL certificates (Let's Encrypt)

### Application Container

The main container runs multiple services managed by Supervisor:

#### 1. Nginx Web Server

- **Port**: 80 (internal)
- **Purpose**: Serves static files and proxies PHP requests
- **Configuration**: `/docker/nginx/default.conf`
- **Features**:
  - Serves Laravel public directory
  - Routes PHP requests to PHP-FPM
  - Handles static assets (CSS, JS, images)
  - Security headers configured

#### 2. PHP-FPM (FastCGI Process Manager)

- **Port**: 9000 (internal)
- **Purpose**: Executes PHP code
- **Features**:
  - PHP 8.2
  - Optimized with OPcache
  - Runs as www-data user
  - Extensions: PDO, MySQL, GD, etc.

#### 3. Laravel Queue Worker

- **Purpose**: Processes background jobs
- **Configuration**: Processes jobs from database queue
- **Features**:
  - Auto-restart on failure
  - Configurable worker count
  - Logs to storage/logs/worker.log

### Database Container

- **Image**: MySQL 8.0
- **Purpose**: Persistent data storage
- **Features**:
  - Separate container for isolation
  - Persistent volume for data
  - Internal network communication
  - Automatic backups via Dokploy

## Data Flow

### HTTP Request Flow

```
1. User Browser
   ↓ (HTTPS Request)
2. Dokploy Proxy (Traefik)
   ↓ (SSL Termination)
3. Nginx (Container)
   ↓ (Route to PHP-FPM)
4. PHP-FPM (Laravel)
   ↓ (Query Database)
5. MySQL Container
   ↑ (Return Data)
6. PHP-FPM (Laravel)
   ↑ (Render Response)
7. Nginx
   ↑ (Send Response)
8. Dokploy Proxy
   ↑ (HTTPS Response)
9. User Browser
```

### Background Job Flow

```
1. User Action
   ↓
2. Laravel Application
   ↓ (Dispatch Job)
3. Database (jobs table)
   ↓
4. Queue Worker (picks up job)
   ↓ (Process Job)
5. Database (update job status)
   ↓
6. Job Completion
```

## Network Communication

### External Network

- **Port 80/443**: Public HTTP/HTTPS access
- **Port 3000**: Dokploy dashboard (optional, can be restricted)

### Internal Docker Network

- **Application Container**: Communicates with database container
- **Database Container**: Only accessible from application container
- **Network**: Bridge network created by Dokploy

## Storage and Persistence

### Application Container

**Ephemeral (recreated on deploy)**:
- Application code
- Vendor dependencies
- Compiled assets

**Persistent (should be volume-mounted)**:
- `/var/www/html/storage` - User uploads, logs, cache files

### Database Container

**Persistent**:
- `/var/lib/mysql` - Database files (Docker volume)
- Managed by Dokploy
- Included in backups

## Deployment Process

```
1. Git Push to Repository
   ↓
2. Dokploy Webhook Trigger (if auto-deploy enabled)
   ↓
3. Dokploy clones repository
   ↓
4. Docker Build
   ├─ Install system packages
   ├─ Install PHP extensions
   ├─ Copy application files
   ├─ Install Composer dependencies
   ├─ Build frontend assets (npm)
   └─ Set permissions
   ↓
5. Create Container from Image
   ↓
6. Run Entrypoint Script
   ├─ Wait for database
   ├─ Create storage directories
   ├─ Run migrations
   ├─ Cache configuration
   └─ Start Supervisor
   ↓
7. Container Running
   ├─ Nginx listening on port 80
   ├─ PHP-FPM processing requests
   └─ Queue worker processing jobs
   ↓
8. Dokploy Proxy Routes Traffic
   ↓
9. Application Live ✓
```

## Scaling Strategies

### Vertical Scaling

Increase resources for existing containers:
- Upgrade VPS plan
- Allocate more CPU/RAM
- No application changes needed

### Horizontal Scaling

Add more application instances:
- Increase replica count in Dokploy
- Dokploy automatically load balances
- Shared database and storage required
- Session storage must be database/redis (not file-based)

## Security Layers

```
┌─────────────────────────────────────┐
│  1. Firewall (VPS Level)            │ ← UFW/iptables
├─────────────────────────────────────┤
│  2. Dokploy Proxy                   │ ← SSL/TLS, rate limiting
├─────────────────────────────────────┤
│  3. Container Isolation             │ ← Docker namespaces
├─────────────────────────────────────┤
│  4. Application (Laravel)           │ ← CSRF, authentication
├─────────────────────────────────────┤
│  5. Database Access Control         │ ← User permissions, network isolation
└─────────────────────────────────────┘
```

## Monitoring Points

1. **Application Level**
   - Response times
   - Error rates
   - Memory usage
   - CPU usage

2. **Container Level**
   - Container health
   - Resource limits
   - Restart count

3. **Database Level**
   - Query performance
   - Connection count
   - Storage usage

4. **System Level**
   - Disk space
   - Network I/O
   - System load

## Backup Strategy

```
┌─────────────────────────────────────┐
│  Automated Daily Backups            │
│  (Dokploy Scheduler)                │
└──────────┬──────────────────────────┘
           │
           ├─ Database Backup (mysqldump)
           │  └─ Stored in backup volume
           │
           ├─ Storage Files Backup (optional)
           │  └─ User uploads, logs
           │
           └─ Retention Policy
              └─ Keep 7 daily, 4 weekly, 3 monthly
```

## High Availability Options

For production systems requiring high availability:

1. **Load Balancing**: Multiple application instances
2. **Database Replication**: Master-slave MySQL setup
3. **Shared Storage**: NFS or object storage for uploads
4. **Redis Cache**: Distributed caching layer
5. **Queue System**: Redis/RabbitMQ for better queue management
6. **CDN**: CloudFlare/CloudFront for static assets

## Related Documentation

- [DEPLOYMENT.md](DEPLOYMENT.md) - Step-by-step deployment guide
- [DOKPLOY.md](DOKPLOY.md) - Quick start guide
- [docker/README.md](docker/README.md) - Docker configuration details
