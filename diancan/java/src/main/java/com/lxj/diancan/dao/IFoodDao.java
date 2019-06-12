package com.lxj.diancan.dao;

import java.util.List;
import java.util.Map;

import com.lxj.diancan.entity.Cart;
import com.lxj.diancan.entity.Food;

/**
 * IFoodDao
 */
public interface IFoodDao {

    List<Map<String, Object>> list(int start, int limit, String keyword);
    int getTotal(String keyword);
    Food getFoodById(int id);
    // 同一个菜系得菜品数量
    int getCountById(int id);

    // 添加
    void save(Food dt);

    // 批量添加
    int[] insertBatch(List<Cart> cart_list);

    // 更新
    int update(Food dt);
    // 删除
    int delete(Food dt);
    
}