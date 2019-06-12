package com.lxj.diancan.service;

import java.util.List;
import java.util.Map;

import com.lxj.diancan.entity.Cart;
import com.lxj.diancan.utils.PageUtils;

/**
 * IOrderService
 */
public interface IOrderService {

    // 添加订单
    int save(List<Cart> cart_list, Object table_id, Object total_price); 
    // 列表
    List<Map<String, Object>> list(PageUtils pageUtils);
    // 总数
    int getTotal();
    // 查询订单详情
    List<Map<String, Object>> order_list(int order_id);
    // 更新
    int updateStatus(int status, int id);

}