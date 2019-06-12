package com.lxj.diancan.servlet.admin;

import javax.servlet.RequestDispatcher;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

import com.lxj.diancan.servlet.BaseServlet;

/**
 * IndexServlet
 */
public class IndexServlet extends BaseServlet {

    private static final long serialVersionUID = 1L;

    /**
     * 后台首页
     * 
     * @return
     * 
     * @throws IOException
     * @throws ServletException
     */
    public RequestDispatcher index(HttpServletRequest req, HttpServletResponse res) {
        return req.getRequestDispatcher("/sys/index.jsp");
    }
    
}