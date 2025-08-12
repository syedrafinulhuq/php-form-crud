FROM php:8.3-cli

# Set working directory
WORKDIR /app

# Copy project files
COPY . .

# Run PHP's built-in server, using the Render-provided $PORT variable
CMD ["sh", "-c", "php -S 0.0.0.0:${PORT:-8080} -t ./"]
