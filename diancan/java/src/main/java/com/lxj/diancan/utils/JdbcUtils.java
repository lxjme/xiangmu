package com.lxj.diancan.utils;

import javax.sql.DataSource;

import com.mchange.v2.c3p0.ComboPooledDataSource;

import org.apache.commons.dbutils.QueryRunner;

/**
 * 简化数据库操作
 * JdbcUtils
 */
public class JdbcUtils {

    private static DataSource dataSource;
    static {
        // 初始化数据连接池
        dataSource = new ComboPooledDataSource();
    }

    public static DataSource getDataSource() {
        return dataSource;
    }

    public static QueryRunner getQueryRunner() {
        return new QueryRunner(dataSource);
    }

    public static void main(String[] args) {
        System.out.println(dataSource);
    }

    
}