package com.lxj.diancan.dao;

import java.util.List;

import com.lxj.diancan.entity.FoodType;

/**
 * IFoodTypeDao
 */
public interface IFoodTypeDao {

    List<FoodType> listAll();
    List<FoodType> list(int start, int limit, String keyword);
    int getTotal(String keyword);

    // 添加
    void save(FoodType dt);
    // 更新
    int update(FoodType dt);
    // 删除
    int delete(FoodType dt);
    
}