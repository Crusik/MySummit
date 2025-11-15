#!/bin/bash

# Setup Laravel Sanctum in Docker

echo "Installing Laravel Sanctum..."

# Run composer install inside the app container
docker-compose exec app composer install

# Publish Sanctum's configuration and migrations
docker-compose exec app php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"

# Run migrations
docker-compose exec app php artisan migrate

echo "Sanctum installation complete!"
echo ""
echo "Next steps:"
echo "1. Add Sanctum middleware to your API routes (routes/api.php)"
echo "2. Update your frontend to use Sanctum for authentication"
echo ""
echo "Example API route with Sanctum:"
echo "Route::middleware('auth:sanctum')->get('/user', function (Request \$request) {"
echo "    return \$request->user();"
echo "});"
