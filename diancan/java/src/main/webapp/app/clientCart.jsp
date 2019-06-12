<%@ page language="java" import="java.util.*" pageEncoding="UTF-8" isELIgnored="false" import="com.lxj.diancan.servlet.*,java.util.List"%>
<%@taglib uri="http://java.sun.com/jsp/jstl/core" prefix="c" %>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
	<title>购物车</title>
	<link rel="stylesheet" type="text/css" href="${pageContext.request.contextPath }/app/style/css/index.css" />
	<script type="text/javascript">
		 // 删除菜品项
		function removeSorder(food_id) {
			window.location.href = "cartDel?food_id="+food_id;
		}
		
		// 修改菜品项数量
		function alterSorder(node, id) {
			var snumber = node.value;
			window.location.href = 'addCart?id='+id+'&nums='+snumber
		}
		// 下单
		function genernateOrder() {
			window.location.href = "${pageContext.request.contextPath }/index/addOrder";
		}
	</script>
</head>

<body style="text-align: center">
	<div id="all">
		<div id="menu">
			<!-- 餐车div -->
			<div id="count">
				<table align="center" width="100%">
					<tr height="40">
				 		<td align="center" width="20%">菜名</td>
				 		<td align="center" width="20%">单价</td>
				 		<td align="center" width="20%">数量</td>
				 		<td align="center" width="20%">小计</td>
				 		<td align="center" width="20%">操作</td>
				 	</tr>
					<c:forEach var="cart" items="${cart_list}">
						<tr height="60">
							<td align="center" width="20%">${cart.food.food_name}</td>
							<td align="center" width="20%">￥${cart.food.price}</td>
							<td align="center" width="20%">
								<input type="text" value="${cart.nums}" size="3" lang="3" onblur="alterSorder(this,${cart.food.id})"/>
							</td>
							<td align="center" width="20%">${cart.food.price * cart.nums}</td>
							<td align="center" width="20%">
								<input type="button" value="删除" class="btn_next" lang="" onclick="removeSorder(${cart.food.id})" />
							</td>
							<%
							%>
						</tr>
					 </c:forEach>

					<tr>
						<td colspan="6" align="right">总计:
							<span style="font-size:36px;">&yen;&nbsp;${total_price}</span>
							<label
								id="counter" style="font-size:36px"></label>
						</td>
					</tr>
					<tr>
						<td colspan="6" style="margin-left: 100px; text-align: center;"align="right">
							<input type="hidden" name="bId" value="">
							<input type="button" value="下单" class="btn_next" onclick="genernateOrder()" />
						</td>
					</tr>
				</table>
			</div>
		</div>

		<!-- 右边菜系列表，菜品搜索框  -->
		<%@include file="right.jsp" %>
	</div>
</body>
</html>
