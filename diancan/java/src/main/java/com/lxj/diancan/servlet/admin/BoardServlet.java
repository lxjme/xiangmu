package com.lxj.diancan.servlet.admin;

import java.io.UnsupportedEncodingException;
import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.Date;
import java.util.TimeZone;

import javax.servlet.RequestDispatcher;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

import com.lxj.diancan.entity.DinnerTable;
import com.lxj.diancan.servlet.BaseServlet;
import com.lxj.diancan.utils.PageUtils;

/**
 * AdminServlet
 */
public class BoardServlet extends BaseServlet {

    private static final long serialVersionUID = 1L;



    /**
     * 餐桌管理
     */
    public RequestDispatcher boardList(HttpServletRequest req, HttpServletResponse res) {
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
        
        int total = iDinnerTableService.getTotal(keyword);


        PageUtils pageUtils = new PageUtils(total, page);
        
        req.setAttribute("pageUtils", pageUtils);
        req.setAttribute("list", iDinnerTableService.list(pageUtils, keyword));


        return req.getRequestDispatcher("/sys/boardList.jsp");
    }

    /**
     * 添加餐桌
     * 
     * @param req
     * @return
     * @throws UnsupportedEncodingException
     */
    public Object saveBoard(HttpServletRequest req, HttpServletResponse res)
            throws UnsupportedEncodingException {
        // req.setCharacterEncoding(env);
        String table_name = req.getParameter("bName");
        Object return_val = null;
        if (table_name != null) {
            // System.out.println(table_name);
            DinnerTable dt = new DinnerTable();
            dt.setTable_name(table_name);
            iDinnerTableService.save(dt);

            if(dt.getId() > 0) {
                // 添加成功
                return_val = "/admin/boardList";
            } else {
                // 添加失败
                req.setAttribute("message", "添加失败");
                // res.set
                return_val = req.getRequestDispatcher("/error/error.jsp");
            }
        } else {
            return_val = req.getRequestDispatcher("/sys/saveBoard.jsp");
        }

        return return_val;
    }

    /**
     * 更新餐桌
     */
    public Object updateBoard(HttpServletRequest request, HttpServletResponse response) {
        String id = request.getParameter("id");

        Object return_val = null;

        if(id == null) {
            // 跳到错误页面
            request.setAttribute("message", "缺少ID参数");
            // res.set
            return_val = request.getRequestDispatcher("/error/error.jsp");
        }
        DinnerTable dt = new DinnerTable();
        dt.setId(Integer.valueOf(id));

        String status = request.getParameter("status");

        if(status != null) {
            dt.setTable_status(Integer.valueOf(status));
        }

        int line = iDinnerTableService.update(dt);
        if(line > 0) {
            // 更新成功
            return_val = "/admin/board/boardList";
            System.out.println(return_val);

        } else {
            // 更新失败
             request.setAttribute("message", "更新失败");
             // res.set
             return_val = request.getRequestDispatcher("/error/error.jsp");
        }


        return return_val;
    }

    /**
     * 删除
     * @param request
     * @param response
     * @return
     */
    public Object deleteBoard(HttpServletRequest request, HttpServletResponse response) {
        String id = request.getParameter("id");
        Object return_val = null;

        if(id == null) {
            // 跳到错误页面
            request.setAttribute("message", "缺少ID参数");
            // res.set
            return_val = request.getRequestDispatcher("/error/error.jsp");
        }

        DinnerTable dt = new DinnerTable();
        dt.setId(Integer.valueOf(id));
        int line = iDinnerTableService.delete(dt);
        if(line > 0) {
            // 删除成功
            return_val = "/admin/board/boardList";
            System.out.println(return_val);

        } else {
            // 删除失败
             request.setAttribute("message", "删除失败");
             // res.set
             return_val = request.getRequestDispatcher("/error/error.jsp");
        }




        return return_val;

    }

    public static void main(String[] args) throws ParseException {
        SimpleDateFormat bjSdf = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss");     // 北京
        bjSdf.setTimeZone(TimeZone.getTimeZone("Asia/Shanghai"));  // 设置北京时区
        // System.out.println(bjSdf.parse());
        System.out.println(bjSdf.format(new Date()));
        System.out.println(bjSdf.parse(bjSdf.format(new Date())));
    }

    
}