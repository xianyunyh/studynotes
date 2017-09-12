## Nginx 负载均衡配置

>  配置后端的机器,nginx 的 upstream默认是以轮询的方式实现负载均衡，这种方式中，每个请求按时间顺序逐一分配到不同的后端服务器

	upstream backend {

             server 192.168.1.251;

             server 192.168.1.252;

             server 192.168.1.247;

         }

> 配置反向代理

	location / {

        	#设置主机头和客户端真实地址，以便服务器获取客户端真实IP
             proxy_set_header Host $host;
             proxy_set_header X-Real-IP $remote_addr;
        	 proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
             #禁用缓存
             proxy_buffering off;
             #反向代理的地址
             proxy_pass http://backend;     

        }

    }

### Nginx 负载的几种方式

1.1 轮询

> 每个请求按时间顺序逐一分配到不同的后端服务器，如果后端服务器down掉，能自动剔除。
		
	upstream backend {

             server 192.168.1.251;

             server 192.168.1.252;

             server 192.168.1.247;

         }
1.2 权重(weight)

> 指定轮询几率，weight和访问比率成正比，用于后端服务器性能不均的情况

	upstream bakend {
	server 192.168.159.10 weight=1;
	server 192.168.159.11 weight=10;
	}

1.3 ip_hash

> 每个请求按访问ip的hash结果分配，这样每个访客固定访问一个后端服务器，可以解决session的问题

	upstream bakend{
		ip_hash;
		server 192.168.159.10:8080;
		server 192.168.159.11:8080;
	}
1.4 fair

> 按后端服务器的响应时间来分配请求，响应时间短的优先分配

	upstream bakend{
			server 192.168.159.10:8080;
			server 192.168.159.11:8080;
			fair;
		}