<%@ page language="java" import="java.util.*" pageEncoding="UTF-8"%>
<%@taglib uri="http://java.sun.com/jsp/jstl/core" prefix="c" %>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
	<link rel="stylesheet" type="text/css" href="${pageContext.request.contextPath }/app/style/css/index.css" />
	<script type="text/javascript">
		// 通知服务员结账
		function callPay(node) {
			var r=confirm("您的订单已经提交!")
			if (r==true) {
				document.write("You pressed OK!")
				window.location.href = "${pageContext.request.contextPath }/index/index";
			}
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
				 	</tr>
					
					<c:forEach var="cart" items="${cart_list}">
						<tr height="60">
							<td align="center" width="20%">${cart.food.food_name}</td>
							<td align="center" width="20%">￥${cart.food.price}</td>
							<td align="center" width="20%">${cart.nums}</td>
							<td align="center" width="20%">${cart.nums * cart.food.price}</td>
						</tr>
					</c:forEach>
				 	

					<tr>
						<td colspan="6" align="right">总计:
							<span style="font-size:36px;">&yen;</span>
							<label
								id="counter" style="font-size:36px">${total_price}</label>
						</td>
					</tr>
					<tr>
						<td colspan="6" style="margin-left: 100px; text-align: center;"align="right">
							<input type="hidden" name="bId" value="">
							<input type="button" value="结账" class="btn_next" lang="" onclick="callPay(this)" />
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
