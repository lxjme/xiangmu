package com.lxj.diancan.servlet;

import java.util.ArrayList;
import java.util.Arrays;
import java.util.Date;
import java.util.List;

import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

import com.lxj.diancan.entity.Cart;
import com.lxj.diancan.entity.DinnerTable;
import com.lxj.diancan.entity.Food;
import com.lxj.diancan.utils.PageUtils;

/**
 * IndexServlet
 */
public class IndexServlet extends BaseServlet {

    private static final long serialVersionUID = 8569993990729414977L;

    /**
     * 首页
     * @param request
     * @param response
     * @return
     */
	public Object index(HttpServletRequest request, HttpServletResponse response) {
        Object uri = null;
        // List<>
        uri = request.getRequestDispatcher("/app/index.jsp");

        // 餐桌列表（没有被预定的）
        List<DinnerTable> dinnerList = iDinnerTableService.noYdTableList();
        request.setAttribute("dinnerList", dinnerList);
        return uri;
    }

    /**
     * 餐桌列表
     */
    public Object menu(HttpServletRequest request, HttpServletResponse response) {
        // 菜品列表
        // 1.获取参数
        int page = 1;
        if(request.getParameter("page") != null) {
            page = Integer.parseInt(request.getParameter("page"));
        }

        // 餐桌ID 存到session
        String table_id = request.getParameter("table_id");
        if(table_id != null) {
            request.getSession().setAttribute("table_id", table_id);
        }

        // 搜索关键字
        String keyword = request.getParameter("keyword");
        if(keyword == null) {
            keyword = null;
        }
        
        int total = foodService.getTotal(keyword);

        PageUtils pageUtils = new PageUtils(total, page);
        
        pageUtils.setLimits(6);
        request.setAttribute("pageUtils", pageUtils);
        request.setAttribute("food_list", foodService.list(pageUtils, keyword));

        System.out.println(foodService.list(pageUtils, keyword));


        /* 菜系列表 */
        request.setAttribute("food_type_list", foodTypeService.listAll());

        Object uri = null;

        uri = request.getRequestDispatcher("/app/caidan.jsp");
        return uri;
    }

    /**
     * 菜品信息
     * @param request
     * @param response
     * @return
     */
    public Object foodInfo(HttpServletRequest request, HttpServletResponse response) {
        Object uri = null;
        // 1.获取参数
        String id = request.getParameter("id");
        if(id == null) {
            request.setAttribute("message", "添加失败");
            uri = request.getRequestDispatcher("/error/error.jsp");
        }
        

        // 2.获取菜品信息
        Food food = foodService.getFoodById(Integer.parseInt(id));
        request.setAttribute("food", food);

        System.out.println(foodTypeService.listAll());
        // 3.菜系列表
        request.setAttribute("food_type_list", foodTypeService.listAll());

        return request.getRequestDispatcher("/app/caixiangxi.jsp");
    }

    /**
     * 购物车
     * @param request
     * @param response
     * @return
     */
    public Object addCart(HttpServletRequest request, HttpServletResponse response) {
        Object uri = null;
        // 1.获取参数
        String id = request.getParameter("id");
        if(id == null) {
            request.setAttribute("message", "id为null");
            request.setAttribute("url",request.getRequestURI());
            uri = request.getRequestDispatcher("/error/error.jsp");
            return uri;
        }

        // 2.获取菜品信息
        Food food = foodService.getFoodById(Integer.parseInt(id));
        // request.setAttribute("food", food);

        // 3.购物车
        Cart cart = new Cart();
        cart.setFood(food);
        cart.setNums(1);
        
        List<Cart> cart_list = (List<Cart>) request.getSession().getAttribute("cart_list");
        if(cart_list == null) {
            cart_list = new ArrayList<>();
            request.getSession().setAttribute("cart_list", cart_list);
        }

        boolean found = false;
        double total_price = 0;
        

        for (Cart c : cart_list) {
            if(c.getFood().getId() == cart.getFood().getId()) {
                if(request.getParameter("nums") != null) {
                    c.setNums(Integer.parseInt(request.getParameter("nums")));
                } else {
                    c.setNums(c.getNums() + cart.getNums());
                }

                found = true;
            }

            total_price += c.getNums()*c.getFood().getPrice();
        }

        if(!found) {
            cart_list.add(cart);
        }

        total_price += cart.getFood().getPrice();

        request.getSession().setAttribute("total_price", total_price);
        // 4.菜系列表
        request.setAttribute("food_type_list", foodTypeService.listAll());

        uri = "/index/cartList";

        return uri;
    }

    /**
     * 购物车列表
     * @param request
     * @param response
     * @return
     */
    public Object cartList(HttpServletRequest request, HttpServletResponse response) {
        /* 菜系列表 */
        request.setAttribute("food_type_list", foodTypeService.listAll());

        return request.getRequestDispatcher("/app/clientCart.jsp");
    }

    /**
     * 删除购物车
     * @param request
     * @param response
     * @return
     */
    public Object cartDel(HttpServletRequest request, HttpServletResponse response) {
        Object uri = null;
        // 1.获取参数
        String food_id = request.getParameter("food_id");


        if(food_id == null) {
            request.setAttribute("message", "添加失败");
            uri = request.getRequestDispatcher("/error/error.jsp");
        }

        List<Cart> cart_list = (List<Cart>) request.getSession().getAttribute("cart_list");

        System.out.println(cart_list.size());

        Double total_price =   (Double) request.getSession().getAttribute("total_price");
        System.out.println(total_price);

        if(null != cart_list) {
            for (Cart c : cart_list) {
                if(c.getFood().getId() == Integer.parseInt(food_id)) {
                    cart_list.remove(c);
                    total_price -= c.getNums()*c.getFood().getPrice();
                    break;
                }
    
            }
        }



        request.getSession().setAttribute("total_price", total_price);

        //     System.out.println(total_price);
        uri = "/index/cartList";

        return uri;

    }

    /**
     * 下单
     * @return
     */
    public Object addOrder(HttpServletRequest request, HttpServletResponse response) {
        Object uri = null;
        List<Cart> cart_list = (List<Cart>) request.getSession().getAttribute("cart_list");

        // int[] res_int = foodService.insertBatch(cart_list);

        uri = "/index/orderList";

        

        int order_id = orderService.save(cart_list, request.getSession().getAttribute("table_id"), request.getSession().getAttribute("total_price"));
        if(order_id > 0) {
            // 添加成功
        } else {

        }
        System.out.println("====================");
        System.out.println("===================="+order_id);

        
        return uri;

    }

    /**
     * 订单列表
     */
    public Object orderList(HttpServletRequest request, HttpServletResponse response) {
        Object uri = null;


        uri = request.getRequestDispatcher("/app/clientOrderList.jsp");

        // 4.菜系列表
        request.setAttribute("food_type_list", foodTypeService.listAll());
        
        return uri;
    }
    
}