package com.lxj.diancan.service;

import java.util.List;
import java.util.Map;

import com.lxj.diancan.entity.Cart;
import com.lxj.diancan.entity.Food;
import com.lxj.diancan.utils.PageUtils;

/**
 * IFoodService
 */
public interface IFoodService {

    List<Map<String, Object>> list(PageUtils pageUtils, String keys);
    int getTotal(String keywords);
    Food getFoodById(int id);
    // 同一个菜系得菜品数量
    int getCountById(int id);

    // 更新
    int update(Food dt);
    // 添加
    void save(Food dt);
    // 批量添加
    int[] insertBatch(List<Cart> cart_list);
    // 删除
    int delete(Food dt);
}