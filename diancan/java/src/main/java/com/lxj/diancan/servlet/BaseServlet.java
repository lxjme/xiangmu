package com.lxj.diancan.servlet;

import java.io.IOException;
import java.lang.reflect.Method;

import javax.servlet.ServletException;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

import com.lxj.diancan.factory.BeanFactory;
import com.lxj.diancan.service.IDinnerTableService;
import com.lxj.diancan.service.IFoodService;
import com.lxj.diancan.service.IFoodTypeService;
import com.lxj.diancan.service.IOrderService;
import com.lxj.diancan.utils.WebUtils;

/**
 * BaseServlet
 */
public abstract class BaseServlet extends HttpServlet {

    private static final long serialVersionUID = 1L;
    // service
    protected IDinnerTableService iDinnerTableService = BeanFactory.getInstance("dinnerTableService", IDinnerTableService.class);
    // 菜系服务
    protected IFoodTypeService foodTypeService = BeanFactory.getInstance("foodTypeServiceImpl", IFoodTypeService.class);
    // 菜品服务
    protected IFoodService foodService = BeanFactory.getInstance("foodServiceImpl", IFoodService.class);
    // 订单服务
    protected IOrderService orderService = BeanFactory.getInstance("orderServiceImpl", IOrderService.class);

    protected void doGet(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {
        Object returnValue = null;
        String methodName = request.getPathInfo().substring(1);

        try {
            Class clazz = this.getClass();
            Method method = clazz.getDeclaredMethod(methodName, HttpServletRequest.class, HttpServletResponse.class);
            returnValue = method.invoke(this, request, response);

            
        } catch (Exception e) {
            e.printStackTrace();
            // returnValue = "/error/error.jsp";
            returnValue = null;
        }
        WebUtils.goTo(request, response, returnValue);
    }

    protected void doPost(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {
        this.doGet(request, response);
    }


    
}