# Use the official Apache image based on Alpine
FROM httpd:alpine

# Copy your static website files into the container
COPY . /usr/local/apache2/htdocs/

# Expose port 80 to access the web server
EXPOSE 80
