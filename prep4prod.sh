#!/usr/bin/env bash
set -e

# prep4prod.sh - Prepare and deploy Notable to production
# Run from project root with a valid .env present.

CYAN="\033[36m"
BLUE="\033[34m"
RED="\033[31m"
GREEN="\033[32m"
YELLOW="\033[33m"
RESET="\033[0m"

log_step() { echo -e "\n${CYAN}[$(date +'%H:%M:%S')] $1${RESET}"; }
log_info() { echo -e "${BLUE}[INFO]${RESET} $1"; }
log_ok() { echo -e "${GREEN}[OK]${RESET} $1"; }
log_warn() { echo -e "${YELLOW}[WARN]${RESET} $1"; }
log_error() { echo -e "${RED}[ERROR]${RESET} $1" >&2; }
die() {
  log_error "$1"
  exit 1
}

# Always operate from the script's own directory (project root).
SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
cd "$SCRIPT_DIR"

# ---------------------------------------------------------------------------
# 1. Verify .env exists at the project root.
# ---------------------------------------------------------------------------
log_step "1/6 - Verifying .env file at project root..."
if [ ! -f .env ]; then
  die ".env file not found at project root. Place a valid .env file in the project root and run this script again."
fi
log_ok ".env found"

# ---------------------------------------------------------------------------
# 2. Remove compose.override.yml so the prod compose.yml is used as-is.
# ---------------------------------------------------------------------------
log_step "2/6 - Removing compose.override.yml (dev override)..."
if [ -f compose.override.yml ]; then
  rm -f compose.override.yml
  log_ok "compose.override.yml removed"
else
  log_info "compose.override.yml not present, skipping"
fi

# ---------------------------------------------------------------------------
# 3. Toggle .env values for production.
#    Silently verify each key exists; exit with message if any are missing.
# ---------------------------------------------------------------------------
log_step "3/6 - Toggling .env values for production..."

toggle_env_var() {
  local KEY="$1"
  local VALUE="$2"
  if ! grep -qE "^${KEY}=" .env; then
    die "Required key '${KEY}' not found in .env. Add it before running this script."
  fi
  sed -i "s|^${KEY}=.*|${KEY}=${VALUE}|" .env
  log_info "  ${KEY}=${VALUE}"
}

toggle_env_var "APP_ENV" "production"
toggle_env_var "APP_DEBUG" "false"
toggle_env_var "APP_URL" "https://notable.tomgora.online/"

# ---------------------------------------------------------------------------
# 4. Update notable-entrypoint for production.
#    All operations below are idempotent - safe to re-run.
# ---------------------------------------------------------------------------
log_step "4/6 - Updating notable-entrypoint for production..."

ENTRYPOINT_FILE="notable-entrypoint"
if [ ! -f "$ENTRYPOINT_FILE" ]; then
  die "notable-entrypoint file not found at project root."
fi

# 4a. Uncomment key:generate and migrate if commented.
# No-op if already uncommented (regex won't match).
sed -i -E '
  s|^# php artisan key:generate --quiet$|php artisan key:generate --quiet|
  s|^# php artisan migrate --force --quiet$|php artisan migrate --force --quiet|
' "$ENTRYPOINT_FILE"

# 4b. Comment out optimize:clear if not already commented.
# No-op if already commented.
sed -i -E 's|^php artisan optimize:clear --quiet$|# php artisan optimize:clear --quiet|' "$ENTRYPOINT_FILE"

# 4c. Add cache commands after migrate, but only if not already present.
# Grep check makes this idempotent - won't add duplicates on re-run.
if ! grep -q "^php artisan config:cache --quiet$" "$ENTRYPOINT_FILE"; then
  sed -i '/^php artisan migrate --force --quiet$/a\
php artisan config:cache --quiet\
php artisan route:cache --quiet\
php artisan view:cache --quiet' "$ENTRYPOINT_FILE"
  log_info "  Added config:cache / route:cache / view:cache after migrate"
fi

# 4d. Comment out php artisan serve.
# No-op if already commented.
sed -i -E 's|^php artisan serve --host=0\.0\.0\.0 --port=9000$|# php artisan serve --host=0.0.0.0 --port=9000|' "$ENTRYPOINT_FILE"

# 4e. Uncomment exec "$@" so entrypoint defers to Dockerfile's CMD.
# No-op if already uncommented.
sed -i -E 's|^# exec "\$@"$|exec "$@"|' "$ENTRYPOINT_FILE"

log_ok "notable-entrypoint updated for production"

# 5. Build js assets
log_step "5/7 - Installing JS packages and building assets..."
npm i && npm run build

# 6. Build and start the production stack.
log_step "6/7 - Building and starting services..."
docker compose up -—build -d

# 7. wait for all services to be up and running.
log_step "7/7 - Waiting for services to come online..."

SERVICES=$(docker compose config --services 2>/dev/null)
if [ -z "$SERVICES" ]; then
  die "No services found in docker compose config"
fi

log_info "Services to wait for: $SERVICES"

MAX_WAIT=600 # 10 minutes
INTERVAL=5
ELAPSED=0
TOTAL_COUNT=$(echo "$SERVICES" | wc -l)

while [ $ELAPSED -lt $MAX_WAIT ]; do
  RUNNING_COUNT=$(docker compose ps --services --filter status=running 2>/dev/null | wc -l)

  if [ "$RUNNING_COUNT" -eq "$TOTAL_COUNT" ] && [ "$TOTAL_COUNT" -gt 0 ]; then
    log_ok "All $TOTAL_COUNT services are running"
    break
  fi

  log_info "  [$RUNNING_COUNT/$TOTAL_COUNT] services running, waiting ${INTERVAL}s..."
  sleep $INTERVAL
  ELAPSED=$((ELAPSED + INTERVAL))
done

if [ $ELAPSED -ge $MAX_WAIT ]; then
  die "Timeout waiting for services to be running after ${MAX_WAIT}s"
fi

echo ""
docker compose ps
echo ""
log_ok "Production deployment complete!"
log_info "App should be available at https://notable.tomgora.online/"
