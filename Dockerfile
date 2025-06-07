FROM php:8.2-cli

RUN apt-get update && apt-get install -y unzip

WORKDIR /app

COPY . .

EXPOSE 10000

# 👇 Make upload folders writable
RUN chmod -R 777 /app/public/uploads

CMD ["php", "-S", "0.0.0.0:10000", "-t", "public"]