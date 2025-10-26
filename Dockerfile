# Usa imagem oficial do PHP com Apache embutido
FROM php:8.2-apache

# Copia os arquivos para dentro do container
COPY . /var/www/html/

# Permissões e ativação do mod_rewrite (opcional, mas bom ter)
RUN a2enmod rewrite && chown -R www-data:www-data /var/www/html

# Porta padrão
EXPOSE 80

# Inicia o Apache automaticamente
CMD ["apache2-foreground"]
