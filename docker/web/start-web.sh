#!/bin/sh
set -e

cd /app

LOCK_HASH_FILE="node_modules/.package-lock.hash"
CURRENT_HASH="$(sha256sum package-lock.json | awk '{print $1}')"
INSTALLED_HASH=""

if [ -f "$LOCK_HASH_FILE" ]; then
  INSTALLED_HASH="$(cat "$LOCK_HASH_FILE")"
fi

if [ ! -d node_modules ] || [ ! -f node_modules/.package-lock.json ] || [ "$CURRENT_HASH" != "$INSTALLED_HASH" ]; then
  npm install
  mkdir -p node_modules
  printf '%s' "$CURRENT_HASH" > "$LOCK_HASH_FILE"
fi

exec npm run dev -- --host 0.0.0.0 --port 3000
