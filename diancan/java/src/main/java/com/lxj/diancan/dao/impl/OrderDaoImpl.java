package com.lxj.diancan.dao.impl;

import java.sql.SQLException;
import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.Date;
import java.util.List;
import java.util.Map;
import java.util.TimeZone;

import com.lxj.diancan.dao.IOrderDao;
import com.lxj.diancan.entity.Cart;
import com.lxj.diancan.utils.JdbcUtils;

import org.apache.commons.dbutils.handlers.MapListHandler;
import org.apache.commons.dbutils.handlers.ScalarHandler;

/**
 * OrderDaoImpl
 */
public class OrderDaoImpl implements IOrderDao {
    private String tableName = "orders";

    @Override
    public int save(List<Cart> cart_list, Object table_id, Object total_price) {
        String sql = "insert into orders values (null, ?,?,?)";
        int id = 0;

        // 组装订单数据
        Object[] params = new Object[3];
        params[0] = table_id;

        SimpleDateFormat bjSdf = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss"); // 北京
        bjSdf.setTimeZone(TimeZone.getTimeZone("Asia/Shanghai")); // 设置北京时区
        try {
            params[1] = bjSdf.parse(bjSdf.format(new Date()));
        } catch (ParseException e1) {
            e1.printStackTrace();
        }
        params[2] = total_price;



        try {
            int effect_rows = JdbcUtils.getQueryRunner().execute(sql, params);

            if(effect_rows > 0) {
                Object obj = JdbcUtils.getQueryRunner().query("SELECT LAST_INSERT_ID()", new ScalarHandler<>());
                id = Integer.parseInt(String.valueOf(obj));
            }
        } catch (Exception e) {
            e.printStackTrace();
        }
        if(id > 0) {
            // 批量添加订单项
            String batch_sql = "insert into orderdetail values (null, ?,?,?)";
            Object[][] batch_params =  new Object[cart_list.size()][];
            for (int i = 0; i < cart_list.size(); i++) {
                batch_params[i] = new Object[]{id,cart_list.get(i).getFood().getId(),cart_list.get(i).getNums()};
            }

            int[] res = null;

            try {
                res = JdbcUtils.getQueryRunner().batch(batch_sql, batch_params);
            } catch (SQLException e) {
                e.printStackTrace();
            }
        }
        return id;
    }

    @Override
    public List<Map<String, Object>> list(int start, int limit) {
        String sql = "select o.*,t.table_name from orders o left join dinnertable t ON o.table_id = t.id order by o.id desc limit ?,?";

        List<Map<String, Object>> mapList = null;
        try {
            mapList = JdbcUtils.getQueryRunner().query(sql, new MapListHandler(), new Object[] { start, limit });
        } catch (Exception e) {
            e.printStackTrace();
        }

        return mapList;
    }

    /**
     * 获取总数
     * 
     * @throws SQLException
     */
    @Override
    public int getTotal() {

        String sql = "select count(id) count from " + this.tableName;

        Object obj;
        int total = 0;
        try {
            obj = JdbcUtils.getQueryRunner().query(sql, new ScalarHandler<>());
            total = Integer.parseInt(String.valueOf(obj));
        } catch (SQLException e) {
            e.printStackTrace();
        }

        return total;

    }

    @Override
    public List<Map<String, Object>> order_list(int order_id) {
        String sql = "select od.*,f.food_name,f.price from orderdetail od left join food f on f.id = od.food_id where od.orderId = ?";

            System.out.println(sql);
        List<Map<String, Object>> mapList = null;
        try {
            mapList = JdbcUtils.getQueryRunner().query(sql, new MapListHandler(), new Object[] { order_id });
        } catch (Exception e) {
            e.printStackTrace();
        }

        return mapList;
    }

    @Override
    public int updateStatus(int status,int id) {
        String sql = "update orders set orderStatus = ? where id = ?";

        int line = 0;
        try {
            line = JdbcUtils.getQueryRunner().update(sql, new Object[] { status, id });
        } catch (SQLException e) {
            e.printStackTrace();
        }

        return line;
    }



    
}