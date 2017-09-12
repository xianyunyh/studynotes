```
{
	"bold_folder_labels": true,
	"caret_style": "smooth",
	"default_line_ending": "unix",
	"draw_white_space": false,
	"expand_tabs_on_save": true,
	"font_face": "Source Code Pro",
	"font_size": 16,
	"highlight_line": true,
	"ignored_packages":
	[
		"Vintage"
	],
	"match_brackets_angle": false,
	"match_brackets_braces": false,
	"match_brackets_square": false,
	"show_encoding": true,
	"show_full_path": true,
	"tab_size": 4,
	"translate_tabs_to_spaces": true,
	"trim_trailing_white_space_on_save": true,
    "theme": "Soda Dark 3.sublime-theme",
    "update_check": false
}

```

### 安装package control

```
import urllib.request,os,hashlib; h = 'df21e130d211cfc94d9b0905775a7c0f' + '1e3d39e33b79698005270310898eea76'; pf = 'Package Control.sublime-package'; ipp = sublime.installed_packages_path(); urllib.request.install_opener( urllib.request.build_opener( urllib.request.ProxyHandler()) ); by = urllib.request.urlopen( 'http://packagecontrol.io/' + pf.replace(' ', '%20')).read(); dh = hashlib.sha256(by).hexdigest(); print('Error validating download (got %s instead of %s), please try manual install' % (dh, h)) if dh != h else open(os.path.join( ipp, pf), 'wb' ).write(by)

```

### sublime 常用插件

1. go语言插件

```
    gosublime godef gofmt 
    
```


2. php相关插件


```
phpcs 代码检查

phpfmt 代码格式化

ctags 代码追踪
```

3. 前端插件

```
Emmet 

JSFormat js格式化

Alignment 自动对齐

Bracket Highlighter 匹配高亮

codeFormat 代码格式化 支持css js l html等

jquery  写jq快速提示

Doc Blockr 代码注释



```

4. 其他工具


```
git 版本控制器

ftpsync ftp客户端

SublimeCodeIntel 代码提示 支持多种语言

a file icon  //icon 文件图标


```

5. 更改sublime的packs的位置
安装完packcontrol配置package的位置

```

package_destination:""

```

6. 注册码

```
—– BEGIN LICENSE —–
Michael Barnes
Single User License
EA7E-821385
8A353C41 872A0D5C DF9B2950 AFF6F667
C458EA6D 8EA3C286 98D1D650 131A97AB
AA919AEC EF20E143 B361B1E7 4C8B7F04
B085E65E 2F5F5360 8489D422 FB8FC1AA
93F6323C FD7F7544 3F39C318 D95E6480
FCCC7561 8A4A1741 68FA4223 ADCEDE07
200C25BE DBBC4855 C4CFB774 C5EC138C
0FEC1CEF D9DCECEC D3A5DAD1 01316C36
—— END LICENSE ——

```