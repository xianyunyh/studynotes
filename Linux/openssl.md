## 使用开启扩展SAN的证书
### 1. 生成根证书

**ca.conf**

```ini
[ req ]
default_bits       = 4096
distinguished_name = req_distinguished_name
 
[ req_distinguished_name ]
countryName                 = Country Name (2 letter code)
countryName_default         = CN
stateOrProvinceName         = State or Province Name (full name)
stateOrProvinceName_default = Shanghai
localityName                = Locality Name (eg, city)
localityName_default        = Shanghai
organizationName            = Organization Name (eg, company)
organizationName_default    = Sheld
commonName                  = Common Name (e.g. server FQDN or YOUR name)
commonName_max              = 64
commonName_default          = localhost
```

```shell
$ openssl genrsa -out ca.key 4096
$ openssl rsa -in ca.key -out ca.key
$ openssl req -new -sha256 -out ca.csr -key ca.key -config ca.conf
$ openssl x509 -req -days 3650 -in ca.csr -signkey ca.key -out ca.pem
```
### 2.生成服务器证书

**server.conf**

```ini
[ req ]
default_bits       = 2048
distinguished_name = req_distinguished_name
req_extensions     = req_ext
 
[ req_distinguished_name ]
countryName                 = Country Name (2 letter code)
countryName_default         = CN
stateOrProvinceName         = State or Province Name (full name)
stateOrProvinceName_default = Shanghai
localityName                = Locality Name (eg, city)
localityName_default        = Shanghai
organizationName            = Organization Name (eg, company)
organizationName_default    = Sheld
commonName                  = Common Name (e.g. server FQDN or YOUR name)
commonName_max              = 64
commonName_default          = localhost
 
[ req_ext ]
subjectAltName = @alt_names
 
[alt_names]
DNS.1   = localhost
IP      = 192.168.1.63
```
```shell
$ openssl genrsa -out server.key 2048
$ openssl req -new -sha256 -out server.csr -key server.key -config server.conf
$ openssl x509 -req -days 3650 -CA ca.pem -CAkey ca.key -CAcreateserial -in server.csr -out server.pem -extensions req_ext -extfile server.conf
```
