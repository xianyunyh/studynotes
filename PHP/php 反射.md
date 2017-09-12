## 反射

> 反射，一种计算机处理方式。是程序可以访问、检测和修改它本身状态或行为的一种能力

### ReflectionClass

> ReflectionClass 报告了一个类的相关情况。

- public mixed getConstant ( string $name )  **获取定义的常量**

    

- public array getConstants ( void )  获取所有定义的常量
- public ReflectionMethod getConstructor ( void ) 获取构造函数
- public array getDefaultProperties ( void )
- public string getDocComment ( void )
- public int getEndLine ( void )
- public ReflectionExtension getExtension ( void )
- public string getExtensionName ( void )
- public string getFileName ( void )
- public array getInterfaceNames ( void )
- public array getInterfaces ( void )
- public ReflectionMethod getMethod ( string $name )
- public array getMethods ([ int $filter ] )
- public int getModifiers ( void )
- public string getName ( void )
- public string getNamespaceName ( void )
- public ReflectionClass getParentClass ( void )
- public array getProperties ([ int $filter ] )
- public ReflectionProperty getProperty ( string $name )
- public string getShortName ( void )
- public int getStartLine ( void )
- public array getStaticProperties ( void )
- public mixed getStaticPropertyValue ( string $name [, mixed &$def_value ] )
- public array getTraitAliases ( void )
- public array getTraitNames ( void )
- public array getTraits ( void )
- public bool hasConstant ( string $name )
- public bool hasMethod ( string $name )
- public bool hasProperty ( string $name )
- public bool implementsInterface ( string $interface )
- public bool inNamespace ( void )
- public bool isAbstract ( void )
- public bool isAnonymous ( void )
- public bool isCloneable ( void )
- public bool isFinal ( void )
- public bool isInstance ( object $object ) //判断是不是一个实例
- public bool isInstantiable ( void )
- public bool isInterface ( void ) //判断是不是一个接口
- public bool isInternal ( void )
- public bool isIterateable ( void )
- public bool isSubclassOf ( string $class )
- public bool isTrait ( void )
- public bool isUserDefined ( void )
- public object newInstance ( mixed $args [, mixed $... ] ) 创建一个实例
- public object newInstanceArgs ([ array $args ] )
- public object newInstanceWithoutConstructor ( void )
- public void setStaticPropertyValue ( string $name , string $value )
- public string __toString ( void )
