package com.lxj.diancan.dao.impl;

import java.sql.SQLException;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.List;
import java.util.Map;
import java.util.TimeZone;

import com.lxj.diancan.dao.IFoodDao;
import com.lxj.diancan.entity.Cart;
import com.lxj.diancan.entity.Food;
import com.lxj.diancan.utils.JdbcUtils;

import org.apache.commons.dbutils.handlers.BeanHandler;
import org.apache.commons.dbutils.handlers.MapListHandler;
import org.apache.commons.dbutils.handlers.ScalarHandler;

/**
 * FoodDaoImpl
 */
public class FoodDaoImpl implements IFoodDao {
    private String tableName = "food";

    @Override
    public List<Map<String, Object>> list(int start, int limit, String keyword) {
        StringBuilder sb = new StringBuilder();
        sb.append("select f.*,ft.type_name from " + this.tableName
                + " as f left join food_type as ft on f.type_id = ft.id");
        if (keyword != null) {
            sb.append(" where f.food_name like '%" + keyword + "%'");
        }
        sb.append(" order by f.id desc limit ?,?");

        String sql = sb.toString();

        List<Map<String, Object>> mapList = null;
        try {
            // res = JdbcUtils.getQueryRunner().query(sql, new Object[] { start, limit },
            // new BeanListHandler<>(Food.class));

            mapList = JdbcUtils.getQueryRunner().query(sql, new MapListHandler(), new Object[] { start, limit });

        } catch (Exception e) {
            e.printStackTrace();
        }
        return mapList;
    }

    @Override
    public void save(Food dt) {
        String sql = "insert into " + this.tableName + " values (null,?,?,?,?,?,?)";
        // 时间
        SimpleDateFormat bjSdf = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss"); // 北京
        TimeZone time = TimeZone.getTimeZone("Asia/Shanghai");
        TimeZone.setDefault(time);

        Object[] params = new Object[] { dt.getFood_name(),dt.getType_id(),dt.getPrice(),dt.getMp_price(),dt.getRemark(),dt.getImg() };

        try {
            int effect_rows = JdbcUtils.getQueryRunner().update(sql, params);
            System.out.println("===========================");
            System.out.println("=============="+effect_rows);
            if(effect_rows > 0) {
                Object obj = JdbcUtils.getQueryRunner().query("SELECT LAST_INSERT_ID()", new ScalarHandler<>());

                int id = Integer.parseInt(String.valueOf(obj));
                dt.setId(id);
            }
        } catch (Exception e) {
            e.printStackTrace();
        }

    }

    /**
     * 获取总数
     * 
     * @throws SQLException
     */
    @Override
    public int getTotal(String keyword) {

        String sql = "select count(id) count from " + this.tableName;
        if (keyword != null) {
            sql += " where food_name like '%" + keyword + "%'";
        }
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
    public int update(Food dt) {
        StringBuilder sb = new StringBuilder();
        sb.append("update " + this.tableName + " set ");

        List<Object> olist = new ArrayList<>();
        if (dt.getFood_name() != null) {
            sb.append(" food_name = ?, ");
            olist.add(dt.getFood_name());
        }
        // 菜系ID
        if(dt.getType_id() > 0) {
            sb.append(" type_id = ?, ");
            olist.add(dt.getType_id());
        }
        if(dt.getPrice() > 0) {
            sb.append(" price = ?, ");
            olist.add(dt.getPrice());
        }
        if(dt.getMp_price() > 0) {
            sb.append(" mp_price = ?, ");
            olist.add(dt.getMp_price());
        }
        if(dt.getRemark() != null) {
            sb.append(" remark = ?, ");
            olist.add(dt.getRemark());
        }
        if(dt.getImg() != null) {
            sb.append(" img = ?, ");
            olist.add(dt.getImg());
        }

        String sql = sb.toString().trim();

        sql = sql.substring(0, sql.length() - 1) + " where id = ? ";


        olist.add(dt.getId());

        int line = 0;
        try {
            line = JdbcUtils.getQueryRunner().update(sql, olist.toArray());
        } catch (Exception e) {
            e.printStackTrace();
        }

        return line;
    }

    @Override
    public int delete(Food dt) {
        String sql = "delete from " + this.tableName + " where id = " + dt.getId();

        int line = 0;

        try {
            line = JdbcUtils.getQueryRunner().update(sql);
        } catch (Exception e) {
            e.printStackTrace();
        }

        return line;
    }

    @Override
    public Food getFoodById(int id) {
        String sql = "select * from " + this.tableName + " where id = ?";

        Food food = null;
        try {
            food = JdbcUtils.getQueryRunner().query(sql, new Object[]{id}, new BeanHandler<>(Food.class));
        } catch (Exception e) {
            e.printStackTrace();
        }
        return food;
    }

    /**
     * 批量添加订单
     */
    @Override
    public int[] insertBatch(List<Cart> cart_list) {
        String sql = "insert into orderdetail values (null,null,?,?)";
        int[] res = null;

        Object[][] params =  new Object[cart_list.size()][];
        for (int i = 0; i < cart_list.size(); i++) {
            params[i] = new Object[]{cart_list.get(i).getFood().getId(),cart_list.get(i).getNums()};
        }

        try {
            res = JdbcUtils.getQueryRunner().batch(sql, params);
        } catch (SQLException e) {
            e.printStackTrace();
        }

        return res;
    }

    @Override
    public int getCountById(int id) {
        String sql = "select count(id) count from " + this.tableName + " where type_id = ?";

        Object obj;
        int total = 0;
        try {
            obj = JdbcUtils.getQueryRunner().query(sql, new Object[]{id}, new ScalarHandler<>());
            total = Integer.parseInt(String.valueOf(obj));
        } catch (SQLException e) {
            e.printStackTrace();
        }

        return total;
    }





    
}