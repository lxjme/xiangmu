package com.lxj.diancan.utils;

import java.io.IOException;

import javax.servlet.RequestDispatcher;
import javax.servlet.ServletException;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

/**
 * 服务端/客户端跳转
 * 
 * WebUtils
 */
public class WebUtils {

    public static void goTo(HttpServletRequest request, HttpServletResponse response, Object uri)
            throws ServletException, IOException {
        if(uri instanceof RequestDispatcher) {
            // 服务端跳转
            ((RequestDispatcher) uri).forward(request, response);
        } else if(uri instanceof String) {
            // 客户端跳转
            System.out.println(request.getContextPath());
            response.sendRedirect(request.getContextPath() + uri);
        }
    }
}