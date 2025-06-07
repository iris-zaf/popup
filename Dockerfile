# Use an official PHP base image
FROM php:8.2-cli

# Install extensions (optional — safe to leave as is)
RUN apt-get update && apt-get install -y unzip

# Set working directory inside the container
WORKDIR /app

# Copy your project files into the container
COPY . .

# Open port 10000 (Render uses this)
EXPOSE 10000

# Start PHP's built-in server on the public folder
CMD ["php", "-S", "0.0.0.0:10000", "-t", "public"]
