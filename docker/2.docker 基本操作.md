## docker 基本操作

1. 查看运行的容器

   ```shell
   docker ps
   ```

2. 停止容器

   ```bash
   docker stop container-id
   ```

3. 启动容器

   ```
   docker run xx/xx
   ```

4. 进去容器

   ```bash
   docker exec -it [CONTAINER-ID] /bin/sh
   ```

5. 退出容器

   ```bash
   exit
   ```

### docker 端口和本地宿主机器端口映射

假设容器的名字叫ubuntu

1. 对容器暴露所有的端口，随机映射宿主机端口

   ```bash
   docker run -P -it ubuntu /bin/bash
   ```

2. 映射宿主机随机端口到容器指定的端口

   ```bash
   docker run -p 80 -it ubuntu /bin/bash
   ```

3. 映射宿主机的指定端口到容器指定端口 1对1

   ```bash
   docker run -p 8080:8080 -it ubuntu /bin/bash
   ```

4. 指定容器ip和容器端口，宿主机端口随机映射

   ```bash
   docker run -p 127.0.0.1::80 -it ubuntu /bin/bash
   ```
