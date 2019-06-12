<div id="dish_class">
		
			<div id="dish_top">
				<ul>
				<li class="dish_num"></li>
					<li>
						<a href="#">
							<img src="${pageContext.request.contextPath }/app/style/images/call2.gif" />
						</a>
					</li>
				</ul>
			</div>
			<div id="dish_2">
				<ul style="height: 225px; overflow:scroll;">
					
					<!-- 迭代菜系列表 -->
					<c:forEach var="foodType" items="${food_type_list}">
						<li>
							<a href="menu?type_id=${foodType.id}">${foodType.type_name }</a>
							<input type="hidden" name="foodTypeId" value="${foodType.id}">
						</li>
					</c:forEach>
						
				</ul>
			</div>
			<div id="dish_3">
				<!-- 搜索菜品表单  -->
				<form action="menu" method="get">
					<input type="hidden" name="type_id" value="${pageContext.request.getParameter('type_id')}">
					<input type="hidden" name="table_id" value="${pageContext.request.getParameter('table_id')}">
					<table width="166px">
						<tr>
							<td>
								<input type="text" id="dish_name" value="${pageContext.request.getParameter('keyword')}" name="keyword" class="select_value" /> 
								<%--<input type="hidden" value="selectFood" name="method">--%>
							</td>
						</tr>
						<tr>
							<td><input type="submit" id="sub" value="" /></td>
						</tr>
						<tr>
							<td>
								<a href="${pageContext.request.contextPath }/index/menu">
									<img src="${pageContext.request.contextPath }/app/style/images/look.gif" />
								</a>
							</td>
						</tr>
					</table>
				</form>
			</div>
		</div>