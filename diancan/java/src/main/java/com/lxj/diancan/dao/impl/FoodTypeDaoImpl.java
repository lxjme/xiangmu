package com.lxj.diancan.dao.impl;

import java.sql.SQLException;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Date;
import java.util.List;
import java.util.TimeZone;

import com.lxj.diancan.dao.IFoodTypeDao;
import com.lxj.diancan.entity.FoodType;
import com.lxj.diancan.utils.JdbcUtils;

import org.apache.commons.dbutils.handlers.BeanListHandler;
import org.apache.commons.dbutils.handlers.ScalarHandler;

/**
 * FoodTypeDaoImpl
 */
public class FoodTypeDaoImpl implements IFoodTypeDao {
    private String tableName = "food_type";

    @Override
    public List<FoodType> list(int start, int limit, String keyword) {
        StringBuilder sb = new StringBuilder();
        sb.append("select * from " + this.tableName);
        if (keyword != null) {
            sb.append(" where type_name like '%" + keyword + "%'");
        }
        sb.append(" order by id desc limit ?,?");

        String sql = sb.toString();
        List<FoodType> res = null;
        try {
            res = JdbcUtils.getQueryRunner().query(sql, new Object[] { start, limit },
                    new BeanListHandler<>(FoodType.class));
        } catch (Exception e) {
            e.printStackTrace();
        }
        return res;
    }


    @Override
    public void save(FoodType dt) {
        String sql = "insert into "+this.tableName+" values (null,?)";
        // 时间
        SimpleDateFormat bjSdf = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss"); // 北京
        TimeZone time = TimeZone.getTimeZone("Asia/Shanghai");
        TimeZone.setDefault(time);

        Object[] params = new Object[] { dt.getType_name() };

        try {
            int effect_rows = JdbcUtils.getQueryRunner().execute(sql, params);
            int id = 0;

            if(effect_rows  > 0) {
                Object obj = JdbcUtils.getQueryRunner().query("SELECT LAST_INSERT_ID()", new ScalarHandler<>());
                id = Integer.parseInt(String.valueOf(obj));
            }
            dt.setId(id);
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
            sql += " where table_name like '%" + keyword + "%'";
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
    public int update(FoodType dt) {
        StringBuilder sb = new StringBuilder();
        sb.append("update " + this.tableName + " set ");

        List<Object> olist = new ArrayList<>();
        if (dt.getType_name() != null) {
            sb.append(" type_name = ?, ");
            olist.add(dt.getType_name());
        }

        String sql = sb.toString().trim();

        sql = sql.substring(0, sql.length() - 1) + " where id = ? ";

        System.out.println("======="+sql);

        olist.add(dt.getId());
        System.out.println("======="+olist);

        int line = 0;
        try {
            line = JdbcUtils.getQueryRunner().update(sql, olist.toArray());
        } catch (Exception e) {
            e.printStackTrace();
        }

        return line;
    }

    @Override
    public int delete(FoodType dt) {
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
    public List<FoodType> listAll() {
        String sql = "select * from " + this.tableName;

        List<FoodType> list = null;
        try {
            // list = JdbcUtils.getQueryRunner().query(sql, new Object[] { start, limit },   new BeanListHandler<>(FoodType.class))
            list = JdbcUtils.getQueryRunner().query(sql, new Object[] {}, new BeanListHandler<>(FoodType.class));
        } catch (Exception e) {
            e.printStackTrace();
        }

        return list;
    }




    
}