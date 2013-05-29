##fis-server-fisdata

使用FIS开发时，提供本地调试数据功能。


###使用

    //require必要的类文件
    require_once ("<DIR_FIS_DATA>/TestData.php");

    //初始化类，必须放在其他router的最前面
    TestData::init();
    
    //渲染数据
    // $templateEngine 模板引擎，必须包含方法assign, display 如:smarty
    // $tmpl 当前要渲染的模板
    TestData::renderHelper($templateEngine, $tmpl);

####浏览器书签
    
    //新建浏览器书签，网址为以下内容
    javascript: void function() {var d = new Date();d.setFullYear(d.getFullYear() + 1);document.cookie='FIS_DEBUG_DATA=4f10e208f47bfb4d35a5e6f115a6df1a;path=/;expires=' + d.toGMTString() + '';location.reload(); }();

在预览的时候点击书签，进入数据管理页面，修改数据后再进行渲染。


###在FIS安装

    //安装特定版本
    fis server install fisdata@1.0.1
    
    or
    
    //安装最新版本
    fis server install fisdata
