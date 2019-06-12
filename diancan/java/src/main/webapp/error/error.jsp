<%@ page language="java" contentType="text/html; charset=UTF-8" pageEncoding="UTF-8" isELIgnored="false"%>
<%@ page isELIgnored="false" %>
<%@ taglib uri="http://java.sun.com/jsp/jstl/core" prefix="c"%>
<!DOCTYPE HTML>
<html>
    <head>
        <title>错误页面</title>
    </head>
<body style="background-color: #fbf5f5;">
    <div style="width:500px;border:1px solid #dedcdc;margin:200px auto;padding:80px">

        系统 出现了异常，异常原因是：
            <span style="color:brown;">${message}</span>
            <br><br>
            出现异常的地址是：
            <span style="color:brown;">${url}</span>
    </div>
</body>
</html>
