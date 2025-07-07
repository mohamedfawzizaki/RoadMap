FROM nginx:latest

# Remove the default configuration file
RUN rm /etc/nginx/conf.d/default.conf

# Copy your custom static content
COPY . /usr/share/nginx/my-app-1

# Copy your custom Nginx site config
COPY ./my-site.conf /etc/nginx/conf.d


