package com.lxj.diancan.dao.impl;

import java.sql.SQLException;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Date;
import java.util.List;
import java.util.TimeZone;

import com.lxj.diancan.dao.IDinnerTableDao;
import com.lxj.diancan.entity.DinnerTable;
import com.lxj.diancan.utils.JdbcUtils;

import org.apache.commons.dbutils.handlers.BeanListHandler;
import org.apache.commons.dbutils.handlers.ScalarHandler;

/**
 * DinnerTableDaoImpl
 */
public class DinnerTableDaoImpl implements IDinnerTableDao {
    protected  final String tabelName = "dinnertable";


    @Override
    public List<DinnerTable> list() {
       return list(0, Short.MAX_VALUE, null);
    }
    @Override
    public List<DinnerTable> list(int start, int limit, String keyword) {
        StringBuilder sb = new StringBuilder();
        sb.append("select * from " + this.tabelName);
        if(keyword != null) {
            sb.append(" where table_name like '%"+keyword+"%'");
        }
        sb.append(" order by id desc limit ?,?");

        String sql = sb.toString();
        List<DinnerTable> res = null;
        try {
            res = JdbcUtils.getQueryRunner().query(sql, new Object[]{start, limit}, new BeanListHandler<>(DinnerTable.class));
        } catch (Exception e) {
            e.printStackTrace();
        }
        return  res;
    }
    /**
     * 获取未预定得餐桌
     */
    @Override
    public List<DinnerTable> noYdTableList() {
        String sql = "select * from " + this.tabelName + " where table_status = 0 order by id";
        List<DinnerTable> list = null;
        try {
            list = JdbcUtils.getQueryRunner().query(sql, new BeanListHandler<>(DinnerTable.class));
        } catch (Exception e) {
            e.printStackTrace();
        }
        return list;
    }

    public static void main(String[] args) {
        List<DinnerTable> list =  new DinnerTableDaoImpl().list();
        System.out.println(list);
    }

    @Override
    public void save(DinnerTable dt) {
        String sql = "insert into dinnertable values (null,?,0,?)";
        // 时间
        SimpleDateFormat bjSdf = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss");     // 北京
        TimeZone time = TimeZone.getTimeZone("Asia/Shanghai");
        TimeZone.setDefault(time);
        
        Object[] params = new Object[]{dt.getTable_name(), bjSdf.format(new Date())};

        try {
            JdbcUtils.getQueryRunner().execute(sql, params);
            Object obj = JdbcUtils.getQueryRunner().query("SELECT LAST_INSERT_ID()", new ScalarHandler<>());

            int id = Integer.parseInt(String.valueOf(obj));
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

        String sql = "select count(id) count from "+this.tabelName;
        if(keyword != null) {
            sql += " where table_name like '%"+keyword+"%'";
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
    public int update(DinnerTable dt) {
        StringBuilder sb = new StringBuilder();
        sb.append("update "+this.tabelName+" set ");

        List<Object> olist = new ArrayList<>();
        if(dt.getTable_name() != null) {
            sb.append(" table_name = ?, ");
            olist.add(dt.getTable_name());
        }
        sb.append(" table_status = ?, ");
        olist.add(dt.getTable_status());

        String sql = sb.toString().trim();

        sql = sql.substring(0, sql.length()-1) + " where id = ? ";



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
    public int delete(DinnerTable dt) {
        String sql = "delete from "+this.tabelName + " where id = "+dt.getId();

        int line = 0;

        try {
            line = JdbcUtils.getQueryRunner().update(sql);
        } catch (Exception e) {
            e.printStackTrace();
        }

        return line;
    }

    

    
}