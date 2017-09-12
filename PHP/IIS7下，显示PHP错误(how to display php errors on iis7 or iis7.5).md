## IIS7下，显示PHP错误(how to display php errors on iis7 or iis7.5)

在php.ini中打开以下配置

```
display_errors = on;
error_reporting = E_ALL & ~E_NOTICE;

```

在网站的根目录下面加入以下web.config配置

```
<?xml version="1.0" encoding="UTF-8"?>
<configuration>
  <system.web>
    <compilation debug="true" targetFramework="4.5"/>
    <httpRuntime targetFramework="4.5"/>
  </system.web>
  <system.webServer>
    <httpErrors errorMode="DetailedLocalOnly" existingResponse="PassThrough">
    </httpErrors>
  </system.webServer>
</configuration>

```