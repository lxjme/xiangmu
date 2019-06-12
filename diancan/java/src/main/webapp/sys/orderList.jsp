<%@ page language="java" import="java.util.*" pageEncoding="UTF-8"%>
<%@taglib uri="http://java.sun.com/jsp/jstl/core" prefix="c" %>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
	<!-- 包含公共的JSP代码片段 -->
	
<title>无线点餐平台</title>



<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="${pageContext.request.contextPath }/sys/style/js/jquery.js"></script>
<script type="text/javascript" src="${pageContext.request.contextPath }/sys/style/js/page_common.js"></script>
<link href="${pageContext.request.contextPath }/sys/style/css/common_style_blue.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="${pageContext.request.contextPath }/sys/style/css/index_1.css" />
	<script type="text/javascript">
		// setInterval(function(){
		// 	window.location.href = "/wirelessplatform/client.html?method=list";
		// },1000 * 50);
	</script>
</head>
<body>
	<!-- 页面标题 -->
	<div id="TitleArea">
		<div id="TitleArea_Head"></div>
		<div id="TitleArea_Title">
			<div id="TitleArea_Title_Content">
				<img border="0" width="13" height="13"
					src="${pageContext.request.contextPath }/sys/style/images/title_arrow.gif" /> 餐厅订单列表
			</div>
		</div>
		<div id="TitleArea_End"></div>
	</div>

	<!-- 主内容区域（数据列表或表单显示） -->
	<div id="MainArea">
		<table class="MainArea_Content" align="center" cellspacing="0" cellpadding="0">
			<!-- 表头-->
			<thead>
				<tr align="center" valign="middle" id="TableTitle">
					<td>订单编号</td>
					<td>餐桌名</td>
					<td>下单日期</td>
					<td>总金额</td>
					<td>状态</td>
					<td>操作</td>
				</tr>
			</thead>
			<!--显示数据列表 -->
			<tbody id="TableData">
				<c:forEach items="${list}" var="dt" varStatus="st">
			 		<tr height="60">
				 		<td align="center">${dt.id}</td>
				 		<td align="center">${dt.table_name}</td>
				 		<td align="center">${dt.orderDate}</td>
				 		<td align="center">${dt.totalPrice}</td>
				 		<td align="center">
							<c:choose>
								<c:when test="${dt.orderStatus == 1}">
									已结账
								</c:when>
								<c:otherwise>
									未结账
								</c:otherwise>
							</c:choose> 
						</td>
				 		<td align="center">
							<a href="orderDetail?id=${dt.id}" class="FunctionButton">详细</a> 
							<c:choose>
								<c:when test="${dt.orderStatus != 1}">
				 					<a href="updateStatus?id=${dt.id}&status=${dt.orderStatus}" class="FunctionButton">结账</a>
								</c:when>
							</c:choose> 
				 		</td>
			 		</tr>
				</c:forEach>
			</tbody>
		</table>
		<ul class="pagination">
			<li><a href="?page=1">首页</a></li>
			<c:choose>
				<c:when test="${pageUtils.crtPage > 1}">
					<li><a href="?page=${pageUtils.crtPage - 1}">上一页</a></li>
				</c:when>
			</c:choose>
			
			<li><span>${pageUtils.crtPage}</span></li>
			<c:choose>
				<c:when test="${pageUtils.crtPage < pageUtils.totalPages()}">
					<li><a href="?page=${pageUtils.crtPage + 1}">下一页</a></li>
				</c:when>
			</c:choose>
			<li><a href="?page=${pageUtils.totalPages()}">末页</a></li>
			<li><span>共${pageUtils.total}条数据</span></li>
		</ul>
		<!-- 其他功能超链接 -->
		<div id="TableTail" align="center">
		</div>
	</div>
</body>
</html>
