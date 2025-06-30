#!/bin/sh

set -e  # Exit immediately if a command exits with a non-zero status

# Validate environment variables
if [ -z "$username" ] || [ -z "$version" ]; then
  echo "Error: You must set 'username' and 'version' environment variables."
  echo "Example: username=myuser version=1.0 ./deploy.sh"
  exit 1
fi

echo "Building and pushing backend: $username/leman-pos-backend:$version"
docker build -t "$username/leman-pos-backend:$version" .

echo "Pushing backend image..."
docker push "$username/leman-pos-backend:$version"

echo "Building and pushing Nginx: $username/leman-pos-nginx:$version"
docker build -f Dockerfile.nginx -t "$username/leman-pos-nginx:$version" .

echo "Pushing nginx image..."
docker push "$username/leman-pos-nginx:$version"

echo "✅ Done."
