# ---------------------------------
# Stage 1: Build Stage (Dependencies)
# ---------------------------------
FROM composer:2 AS builder
WORKDIR /app
COPY database/ database/
COPY composer.json composer.lock ./

# Install dependencies --scripts නොකර (artisan run වීම නවත්වන්න)
RUN composer install --no-dev --no-interaction --no-scripts

# Autoloader එක optimize කිරීම
RUN composer dump-autoload --optimize --no-dev --classmap-authoritative --no-scripts

# ---------------------------------
# Stage 2: Final Stage (Production)
# ---------------------------------
# --- !! මෙන්න අලුත් Apache image එක !! ---
FROM webdevops/php-apache:8.2

# Set working directory
WORKDIR /app

# --- Nginx config file එක copy කරන line එක අපි අයින් කළා ---
# --- Apache config file එකක් අවශ්‍ය නෑ! ---

# Copy dependencies from the builder stage
COPY --from=builder /app/vendor/ /app/vendor/

# Copy the rest of the application code
COPY . .

# Set correct permissions
RUN chown -R application:application /app/storage /app/bootstrap/cache && \
    chmod -R 775 /app/storage /app/bootstrap/cache
