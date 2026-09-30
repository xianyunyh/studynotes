## Ant

### 1. Ant 构建文件 build.xml

ant 默认的构建文件是 `build.xml`

```xml
<?xml version="1.0"?>
<project name="app">
	<target name="deploy" depends="package">
  	....
	</target>

    <target name="package" depends="clean,compile">
      ....
    </target>

    <target name="clean" >
      ....
    </target>
</project>
```



- `project` 属性是根节点
  - name 项目名
  - default 表示构建脚本默认运行的目标。默认的target
  - basedir 项目的基准目录

- `target` 就是项目的运行的任务。任务之间可以有依赖
  - name 任务名字
  - depends 任务的依赖
  - description 任务的功能表述
  - if  用于验证指定的属性是否存在，若不存在，所在 target 将不会被执行
  - unless 该属性的功能与 if 属性的功能正好相反，它也用于验证指定的属性是否存在，若不存在，所在 target 将会被执行。

### 2. Ant 属性

Ant 构建文件是用 XML 编写的

Ant 使用**属性 (property)** 元素来让你能够具体说明属性。这就允许这些属性能够在不同的构建和不同的环境下发生改变。

```xml
<?xml version="1.0"?>
<project name="Hello World Project" default="info">

   <property name="sitename" value="www.tutorialspoint.com"/>
   <target name="info">
      <echo>Apache Ant version is ${ant.version} - You are at ${sitename} </echo>
   </target>

</project>
```

默认情况下，Ant 提供以下预定义的属性，这些属性都是可以在构建文件中使用的：

- `ant.file` 项目构建的完整路径
- `ant.version` ant的版本信息
- `basedir` 构建文件的路径
- `ant.java.version` ant使用的java 版本
- `ant.project.name` 项目的名字
- `ant.project.default.target` 默认的target
- `ant.project.invoked-targets`  

当你只需要对小部分属性进行设置时，可以选择直接在构建文件中设置。然而，对于大项目，最好将设置属性的信息存储在一个独立的文件中。

但是一般情况下，属性文件都被命名为 **build.properties**， 并且与 **build.xml** 存放在同一目录层。 你可以基于部署环境 ——比如： **build.properties.dev** 和 **build.properties.test** 创建多个 **build.properties** 文件。

```xml
<?xml version="1.0"?>
<project name="Hello World Project" default="info">

   <property file="build.properties"/>

   <target name="info">
      <echo>Apache Ant version is ${ant.version} - You are at ${sitename} </echo>
   </target>

</project>

```

```ini
#build.properties
sitename=wiki.w3cschool.cn
buildversion=3.3.2
```



### 3. Ant 数据类型

标签

- 文件集 **fileset**

  文件集的数据类型代表了一个文件集合。它被当作一个过滤器，用来包括或移除匹配某种模式的文件。

  - include 包含
  - exclude 排除

  ```xml
  <fileset dir="${src}" casesensitive="yes">
     <include name="**/*.java"/>
     <exclude name="**/*Stub*"/>
  </fileset>
  ```

- 模式集合 **patternset**

一个模式集合指的是一种模式，基于这种模式，能够很容易地过滤文件或者文件夹。模式可以使用下述的元字符进行创建。

- **?** －仅匹配一个字符
- ***** －匹配零个或者多个字符
- ****** －递归地匹配零个或者多个目录

```xml
<patternset id="java.files.without.stubs">
   <include name="src/**/*.java"/>
   <exclude name="src/**/*Stub*"/>
</patternset>
```

- 过滤器集合 filterset

```xml
<fileset dir="${releasenotes.dir}" includes="**/*.txt"/>
<filterset>
    <filter token="VERSION" value="${current.version}"/>
</filterset>
```

- 路径 path

  **path** 数据类型通常被用来表示一个类路径。各个路径之间用分号或者冒号隔开。然而，这些字符在运行时被替代为执行系统的路径分隔符

  ```xml
  <path id="build.classpath.jar">
     <pathelement path="${env.J2EE_HOME}/${j2ee.jar}"/>
     <fileset dir="lib">
        <include name="**/*.jar"/>
     </fileset>
  </path>
  ```
