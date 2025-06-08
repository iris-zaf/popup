FROM php:8.2-cli

RUN apt-get update && apt-get install -y unzip

WORKDIR /app

COPY . .

EXPOSE 10000

# 👇 Create upload folders & make them writable
RUN mkdir -p /app/public/uploads/images/popup \
    && chmod -R 777 /app/public/uploads \
    && chmod -R 777 /app/config  # 👈 Add this line

CMD ["php", "-S", "0.0.0.0:10000", "-t", "public"]
