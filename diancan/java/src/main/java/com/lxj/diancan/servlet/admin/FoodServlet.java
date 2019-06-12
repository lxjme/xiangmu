package com.lxj.diancan.servlet.admin;

import java.io.File;
import java.io.FileOutputStream;
import java.io.InputStream;
import java.util.List;

import javax.servlet.RequestDispatcher;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

import com.lxj.diancan.entity.Food;
import com.lxj.diancan.entity.FoodType;
import com.lxj.diancan.servlet.BaseServlet;
import com.lxj.diancan.utils.PageUtils;

import org.apache.commons.fileupload.FileItem;
import org.apache.commons.fileupload.disk.DiskFileItemFactory;
import org.apache.commons.fileupload.servlet.ServletFileUpload;

/**
 * FoodServlet
 */
public class FoodServlet extends BaseServlet {

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
        
        int total = foodService.getTotal(keyword);

        PageUtils pageUtils = new PageUtils(total, page);
        
        req.setAttribute("pageUtils", pageUtils);
        req.setAttribute("list", foodService.list(pageUtils, keyword));

        return req.getRequestDispatcher("/sys/foodList.jsp");
    }

    /**
     * 添加菜系
     * 
     * @param req
     * @return
     */
    public Object saveFood(HttpServletRequest req, HttpServletResponse res) {
        Object return_val = null;
        if(req.getHeader("Content-Type") == null) {
            // 显示页面
            // 获取菜系数据
            List foodTypeList = foodTypeService.listAll();
            req.setAttribute("type_list", foodTypeList);
            
            return_val = req.getRequestDispatcher("/sys/saveFood.jsp");

        } else {
            DiskFileItemFactory factory = new DiskFileItemFactory();
            ServletFileUpload sfu = new ServletFileUpload(factory);

            Food dt = new Food();

            String filename = null;

            try {
                List<FileItem> list = sfu.parseRequest(req);
                String field_name = null;
                String field_value = null;
                for (FileItem fi : list) {
                    if (!fi.isFormField()) {
                        // 根据时间戳创建头像文件
                        filename = System.currentTimeMillis() + ".jpg";
                        
                        //通过getRealPath获取上传文件夹，如果项目在e:/project/j2ee/web,那么就会自动获取到 e:/project/j2ee/web/uploaded
                        String photoFolder =req.getServletContext().getRealPath("uploaded");
                        
                        File f = new File(photoFolder, filename);
                        f.getParentFile().mkdirs();
    
                        // 通过item.getInputStream()获取浏览器上传的文件的输入流
                        InputStream is = fi.getInputStream();
    
                        // 复制文件
                        FileOutputStream fos = new FileOutputStream(f);
                        byte b[] = new byte[1024 * 1024];
                        int length = 0;
                        while (-1 != (length = is.read(b))) {
                            fos.write(b, 0, length);
                        }
                        fos.close();

                        dt.setImg(filename);

                    } else {
                        field_name = fi.getFieldName();
                        field_value = fi.getString("utf-8");

                        // 菜系ID
                        if(field_name.equals("type_id")) {
                            if(field_value != null) {
                                dt.setType_id(Integer.parseInt(field_value));
                            }
                        } else if(field_name.equals("price")) {
                            // 价格
                            if(field_value != null) {
                                dt.setPrice(Double.parseDouble(field_value));
                            }
                        } else if(field_name.equals("mp_price")) {
                            // 优惠价格
                            if(field_value != null) {
                                dt.setMp_price(Double.parseDouble(field_value));
                            }
                        } else if(field_name.equals("remark")) {
                            if(field_value != null) {
                                dt.setRemark(field_value);
                            }
                        } else if(field_name.equals("food_name")) {
                            // 菜品名称
                            if(field_value != null) {
                                dt.setFood_name(field_value);;
                            }
                        } 
                    }
                }

                foodService.save(dt);

                if(dt.getId() > 0) {
                    // 添加成功
                    return_val = "/admin/food/list";
                } else {
                    // 添加失败
                    req.setAttribute("message", "添加失败");
                    // res.set
                    return_val = req.getRequestDispatcher("/error/error.jsp");
                }
            } catch (Exception e) {
                e.printStackTrace();
            }
        }
        
        return return_val;
    }

    /**
     * 更新菜系
     */
    public Object updateFood(HttpServletRequest request, HttpServletResponse response) {
        String id = request.getParameter("id");

        Object return_val = null;

        if(id == null) {
            // 跳到错误页面
            request.setAttribute("message", "缺少ID参数");
            // res.set
            return_val = request.getRequestDispatcher("/error/error.jsp");
        }
        Food dt = null;

        // 方法
        if(request.getMethod().toLowerCase().equals("get")) {
            // 显示页面
            
            // 通过ID获取菜品信息
            dt = foodService.getFoodById(Integer.parseInt(id));
            request.setAttribute("dt", dt);
            // 获取菜系数据
            List foodTypeList = foodTypeService.listAll();
            request.setAttribute("type_list", foodTypeList);

            return_val = request.getRequestDispatcher("/sys/updateFood.jsp");
        } else {
            // 更新操作
            DiskFileItemFactory factory = new DiskFileItemFactory();
            ServletFileUpload sfu = new ServletFileUpload(factory);

            dt = new Food();

            String filename = null;

            try {
                List<FileItem> list = sfu.parseRequest(request);
                String field_name = null;
                String field_value = null;
                for (FileItem fi : list) {
                    if (!fi.isFormField() && fi.getSize() > 0) {
                        // 根据时间戳创建头像文件
                        filename = System.currentTimeMillis() + ".jpg";
                        
                        //通过getRealPath获取上传文件夹，如果项目在e:/project/j2ee/web,那么就会自动获取到 e:/project/j2ee/web/uploaded
                        String photoFolder =request.getServletContext().getRealPath("uploaded");
                        
                        File f = new File(photoFolder, filename);
                        f.getParentFile().mkdirs();
    
                        // 通过item.getInputStream()获取浏览器上传的文件的输入流
                        InputStream is = fi.getInputStream();
    
                        // 复制文件
                        FileOutputStream fos = new FileOutputStream(f);
                        byte b[] = new byte[1024 * 1024];
                        int length = 0;
                        while (-1 != (length = is.read(b))) {
                            fos.write(b, 0, length);
                        }
                        fos.close();

                        dt.setImg(filename);

                    } else {
                        field_name = fi.getFieldName();
                        field_value = fi.getString("utf-8");

                        // 菜系ID
                        if(field_name.equals("type_id")) {
                            if(field_value != null) {
                                dt.setType_id(Integer.parseInt(field_value));
                            }
                        } else if(field_name.equals("price")) {
                            // 价格
                            if(field_value != null) {
                                dt.setPrice(Double.parseDouble(field_value));
                            }
                        } else if(field_name.equals("mp_price")) {
                            // 优惠价格
                            if(field_value != null) {
                                dt.setMp_price(Double.parseDouble(field_value));
                            }
                        } else if(field_name.equals("remark")) {
                            if(field_value != null) {
                                dt.setRemark(field_value);
                            }
                        } else if(field_name.equals("food_name")) {
                            // 菜品名称
                            if(field_value != null) {
                                dt.setFood_name(field_value);;
                            }
                        } else if(field_name.equals("id")) {
                            // 菜品ID
                            if(field_value != null) {
                                dt.setId(Integer.parseInt(field_value));;
                            }
                        } 
                    }
                }
                System.out.println("======"+dt.toString());

                int line = foodService.update(dt);

                if(line > 0) {
                    // 更新成功
                    return_val = "/admin/food/list";
    
                } else {
                    // 更新失败
                    request.setAttribute("message", "更新失败");
                    // res.set
                    return_val = request.getRequestDispatcher("/error/error.jsp");
                }
            } catch (Exception e) {
                e.printStackTrace();
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
    public Object deleteFood(HttpServletRequest request, HttpServletResponse response) {
        String id = request.getParameter("id");
        Object return_val = null;

        if(id == null) {
            // 跳到错误页面
            request.setAttribute("message", "缺少ID参数");
            // res.set
            return_val = request.getRequestDispatcher("/error/error.jsp");
        }

        Food dt = new Food();
        dt.setId(Integer.valueOf(id));
        int line = foodService.delete(dt);
        if(line > 0) {
            // 删除成功
            return_val = "/admin/food/list";
            System.out.println(return_val);

        } else {
            // 删除失败
             request.setAttribute("message", "删除失败");
             // res.set
             return_val = request.getRequestDispatcher("/error/error.jsp");
        }
        return return_val;

    }
}