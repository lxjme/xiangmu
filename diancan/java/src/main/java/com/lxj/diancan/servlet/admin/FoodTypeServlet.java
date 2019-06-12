package com.lxj.diancan.servlet.admin;

import javax.servlet.RequestDispatcher;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

import com.lxj.diancan.entity.FoodType;
import com.lxj.diancan.servlet.BaseServlet;
import com.lxj.diancan.utils.PageUtils;

/**
 * FoodTypeServlet
 */
public class FoodTypeServlet extends BaseServlet {

    private static final long serialVersionUID = 1L;

    /**
     * 餐桌管理
     */
    public RequestDispatcher list(HttpServletRequest req, HttpServletResponse res) {
        // 1.获取参数
        int page = 1;
        if(req.getParameter("page") != null) {
            page = Integer.parseInt(req.getParameter("page"));
        }

        // 搜索关键字
        String keyword = req.getParameter("keyword");
        if(keyword == null) {
            keyword = null;
        }
        
        int total = foodTypeService.getTotal(keyword);


        PageUtils pageUtils = new PageUtils(total, page);
        
        req.setAttribute("pageUtils", pageUtils);
        req.setAttribute("list", foodTypeService.list(pageUtils, keyword));
            
        return req.getRequestDispatcher("/sys/foodTypeList.jsp");
    }

    /**
     * 添加菜系
     * 
     * @param req
     * @return
     */
    public Object saveFoodType(HttpServletRequest req, HttpServletResponse res) {
        // req.setCharacterEncoding(env);
        String type_name = req.getParameter("type_name");
        Object return_val = null;
        if (type_name != null) {
            FoodType dt = new FoodType();
            dt.setType_name(type_name);

            foodTypeService.save(dt);

            if(dt.getId() > 0) {
                // 添加成功
                return_val = "/admin/foodtype/list";
            } else {
                // 添加失败
                req.setAttribute("message", "添加失败");
                // res.set
                return_val = req.getRequestDispatcher("/error/error.jsp");
            }
        } else {
            return_val = req.getRequestDispatcher("/sys/saveFoodType.jsp");
        }

        return return_val;
    }

    /**
     * 更新菜系
     */
    public Object updateFoodType(HttpServletRequest request, HttpServletResponse response) {
        String id = request.getParameter("id");

        Object return_val = null;

        if(id == null) {
            // 跳到错误页面
            request.setAttribute("message", "缺少ID参数");
            // res.set
            return_val = request.getRequestDispatcher("/error/error.jsp");
        }
        FoodType dt = new FoodType();
        dt.setId(Integer.valueOf(id));

        // 菜系名称
        String type_name = request.getParameter("type_name");
        if(type_name != null) {
            dt.setType_name(type_name);
        }


        // 方法
        if(request.getMethod().toLowerCase().equals("get")) {
            // 显示页面
            // 显示页面
            request.setAttribute("dt", dt);
            return_val = request.getRequestDispatcher("/sys/saveFoodType.jsp");
        } else {
            // 更新操作
            int line = foodTypeService.update(dt);
            if(line > 0) {
                // 更新成功
                return_val = "/admin/foodtype/list";

            } else {
                // 更新失败
                request.setAttribute("message", "更新失败");
                // res.set
                return_val = request.getRequestDispatcher("/error/error.jsp");
            }
        }

        return return_val;
    }

    /**
     * 删除
     * @param request
     * @param response
     * @return
     */
    public Object deleteFoodType(HttpServletRequest request, HttpServletResponse response) {
        String id = request.getParameter("id");
        Object return_val = null;

        if(id == null) {
            // 跳到错误页面
            request.setAttribute("message", "缺少ID参数");
            // res.set
            return_val = request.getRequestDispatcher("/error/error.jsp");
            return return_val;

        }

        // 删除之前需要判断该菜系是否和菜品关联
        int count = foodService.getCountById(Integer.parseInt(id));
        if(count > 0) {
            // 跳到错误页面
            request.setAttribute("message", "菜品下有菜品,不能删除");
            // res.set
            return_val = request.getRequestDispatcher("/error/error.jsp");
            return return_val;
        }


        FoodType dt = new FoodType();
        dt.setId(Integer.valueOf(id));
        int line = foodTypeService.delete(dt);
        if(line > 0) {
            // 删除成功
            return_val = "/admin/foodtype/list";

        } else {
            // 删除失败
             request.setAttribute("message", "删除失败");
             // res.set
             return_val = request.getRequestDispatcher("/error/error.jsp");
        }
        return return_val;

    }
}