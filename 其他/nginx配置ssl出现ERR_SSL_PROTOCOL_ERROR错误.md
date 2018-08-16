## ERR_SSL_PROTOCOL_ERROR错误

本地搭建了一个nginx，生成了一个证书，然后配置ssl的时候，出现了ERR_SSL_PROTOCOL_ERROR。google了一下，是因为ssl_session_tickets 打开导致的。
关机就可以解决问题。

```conf
server {
        server_name         dev.io;
        listen              443 ssl;
        

        root                "/www/dev/public";
        # access_log          "/Applications/MAMP/logs/nginx_ssl_access.log";
        error_log           "/Applications/MAMP/logs/nginx_ssl_error.log";

        ssl_certificate     "/Users/xx/Documents/dev.io.crt";
        ssl_certificate_key "/Users/xx/Documents/dev.io.key";
        ssl_session_cache   shared:SSL:10m;
        ssl_session_timeout 10m;
        #ssl_session_tickets off;

        ssl_protocols       TLSv1 TLSv1.1 TLSv1.2;
        ssl_ciphers         'ECDHE-ECDSA-AES256-GCM-SHA384:ECDHE-RSA-AES256-GCM-SHA384:ECDHE-ECDSA-CHACHA20-POLY1305:ECDHE-RSA-CHACHA20-POLY1305:ECDHE-ECDSA-AES128-GCM-SHA256:ECDHE-RSA-AES128-GCM-SHA256:ECDHE-ECDSA-AES256-SHA384:ECDHE-RSA-AES256-SHA384:ECDHE-ECDSA-AES128-SHA256:ECDHE-RSA-AES128-SHA256';
        ssl_prefer_server_ciphers  on;

        location / {
            try_files       try_files $uri $uri/ /index.php?$args;
            index           index.html index.php;
            autoindex       on;
            allow           all;
            deny            all;
        }

        
        location ~ \.php$ {
			      include  /Applications/MAMP/conf/nginx/cors.conf;#配置cors 跨域
            try_files        $uri =404;
            fastcgi_pass     unix:/Applications/MAMP/Library/logs/fastcgi/nginxFastCGI_php7.2.1.sock;
            fastcgi_param    SCRIPT_FILENAME $document_root$fastcgi_script_name;
            include          /Applications/MAMP/conf/nginx/fastcgi_params;
        }
        

        

        
    }
```
