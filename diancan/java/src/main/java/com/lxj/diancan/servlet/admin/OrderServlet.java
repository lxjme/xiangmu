package com.lxj.diancan.servlet.admin;

import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

import com.lxj.diancan.servlet.BaseServlet;
import com.lxj.diancan.utils.PageUtils;

/**
 * OrderServlet
 */
public class OrderServlet extends BaseServlet {

    /**
     * 订单列表
     * @param request
     * @param response
     * @return
     */
    public Object list(HttpServletRequest request, HttpServletResponse response) {

        // 1.获取参数
        int page = 1;
        if(request.getParameter("page") != null) {
            page = Integer.parseInt(request.getParameter("page"));
        }

        int total = orderService.getTotal();

        PageUtils pageUtils = new PageUtils(total, page);
        
        request.setAttribute("pageUtils", pageUtils);
        request.setAttribute("list", orderService.list(pageUtils));

        return request.getRequestDispatcher("/sys/orderList.jsp");

    }

    /**
     * 订单详情
     */
    public Object orderDetail(HttpServletRequest request, HttpServletResponse response) {
        String id = request.getParameter("id");

        Object return_val = null;

        if(id == null) {
            // 跳到错误页面
            request.setAttribute("message", "缺少ID参数");
            // res.set
            return_val = request.getRequestDispatcher("/error/error.jsp");
        }

        request.setAttribute("order_detail_list", orderService.order_list(Integer.parseInt(id)));

        return request.getRequestDispatcher("/sys/orderDetail.jsp");

    }

    /**
     * 结账
     */
    public Object updateStatus(HttpServletRequest request, HttpServletResponse response) {
        String id = request.getParameter("id");

        Object return_val = null;

        if(id == null) {
            // 跳到错误页面
            request.setAttribute("message", "缺少ID参数");
            // res.set
            return_val = request.getRequestDispatcher("/error/error.jsp");
        }

        int status = Integer.parseInt(request.getParameter("status"));

        orderService.updateStatus(((status == 1) ? 0 : 1), Integer.parseInt(id));

        return "/admin/order/list";



    }
}