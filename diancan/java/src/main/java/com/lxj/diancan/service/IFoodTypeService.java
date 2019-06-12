package com.lxj.diancan.service;

import java.util.List;

import com.lxj.diancan.entity.FoodType;
import com.lxj.diancan.utils.PageUtils;

/**
 * IFoodTypeService
 */
public interface IFoodTypeService {

    List<FoodType> listAll();
    List<FoodType> list(PageUtils pageUtils, String keys);
    int getTotal(String keywords);

    // 更新
    int update(FoodType dt);
    // 添加
    void save(FoodType dt);
    // 删除
    int delete(FoodType dt);
}