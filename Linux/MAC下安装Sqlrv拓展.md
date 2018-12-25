在mac下需要连接SqlServer数据。需要安装拓展
### 1. 下载最新的编译好的拓展。
[https://github.com/Microsoft/msphpsql/releases](https://github.com/Microsoft/msphpsql/releases)

### 2. 安装odbc driver 13
```bash
$ brew tap microsoft/mssql-release https://github.com/Microsoft/homebrew-mssql-release
$ brew update
$ brew install --no-sandbox msodbcsql@13.1.9.2 mssql-tools@14.0.6.0
```

参考文档
- [https://github.com/Microsoft/msphpsql](https://github.com/Microsoft/msphpsql)
- [安装 Linux 和 macOS 上的 Microsoft ODBC Driver for SQL Server](https://docs.microsoft.com/zh-cn/sql/connect/odbc/linux-mac/installing-the-microsoft-odbc-driver-for-sql-server?view=sql-server-2017#microsoft-odbc-driver-131-for-sql-server)
