package com.lxj.diancan.dao;

import java.util.List;
import java.util.Map;

import com.lxj.diancan.entity.Cart;

/**
 * IOrderDao
 */
public interface IOrderDao {
    // 添加订单
    int save(List<Cart> cart_list, Object table_id, Object total_price);

    // // 批量添加订单项
    // void saveBatch(Object[][] params);

    // 查询
    List<Map<String, Object>> list(int start, int limit);
    // 总数
    int getTotal();
    // 查询订单详情
    List<Map<String, Object>> order_list(int order_id);

    // 更新
    int updateStatus(int status, int id);




}