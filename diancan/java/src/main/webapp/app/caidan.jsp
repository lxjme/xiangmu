<%@ page language="java" import="java.util.*" pageEncoding="UTF-8"%>
<%@taglib uri="http://java.sun.com/jsp/jstl/core" prefix="c" %>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
	<!-- 包含公共的JSP代码片段 -->
	
<title>无线点餐平台</title>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<script type="text/javascript" src="${pageContext.request.contextPath }/app/style/js/jquery.js"></script>
<script type="text/javascript" src="${pageContext.request.contextPath }/app/style/js/page_common.js"></script>

<link href="${pageContext.request.contextPath }/app/style/css/common_style_blue.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="${pageContext.request.contextPath }/app/style/css/index_1.css" />
<link href="${pageContext.request.contextPath }/app/style/css/index.css" rel="stylesheet" type="text/css" />
</head>

<body style="text-align: center">
	<div id="all">
		<div id="menu">
			<!-- 显示菜品的div -->
			<div id="top">
				<ul>
					<!-- 循环列出菜品 -->
					<c:forEach var="food" items="${food_list}">
						<li>
							<dl>
								<dt>
									<a href="foodInfo?id=${food.id}">
										<img width="214px" height="145px" src="${pageContext.request.contextPath }/uploaded/${food.img}" />
									</a>
								</dt>
								<dd class="f1">
									<a href="#">${food.food_name }</a>
								</dd>
								<dd class="f2">
									<a href="foodInfo?id=${food.id}">&yen;${food.price }</a>
								</dd>
							</dl>
						</li>
					</c:forEach>
						
					
				</ul>
			</div>
			
			<!-- 底部分页导航条div -->
			<div id="foot">
				<span
					style="float:left; line-height:53PX; margin-left:-50px; font-weight:bold; ">
					<span style="font-weight:bold">&lt;&lt;</span>
				</span>
				<div id="btn">
					当前${pageUtils.crtPage }/${pageUtils.totalPages() }页 &nbsp;
					 <a href="?page=1&keyword=${pageContext.request.getParameter('keyword')}">首页</a>
					 <c:choose>
						<c:when test="${pageUtils.crtPage > 1}">
							<a href="?page=${pageUtils.crtPage-1 }&keyword=${pageContext.request.getParameter('keyword')}">上一页</a>
						</c:when>
					</c:choose>
					 <c:choose>
						<c:when test="${pageUtils.crtPage < pageUtils.totalPages()}">
							 <a href="?page=${pageUtils.crtPage+1}&keyword=${pageContext.request.getParameter('keyword')}">下一页</a>
						</c:when>
					</c:choose>
					 <a href="?page=${pageUtils.totalPages() }&keyword=${pageContext.request.getParameter('keyword')}">尾页</a>
				</div>
				<span style="float:right; line-height:53px; margin-right:10px;  ">
					<span style="font-weight:bold">&gt;&gt;</span>
				</span>
			</div>
			
		</div>

		<!-- 右边菜系列表，菜品搜索框  -->
		
		<%@include file="right.jsp" %>
	</div>
</body>
</html>
