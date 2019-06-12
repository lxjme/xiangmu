package com.lxj.diancan.service.impl;

import java.util.List;
import java.util.Map;

import com.lxj.diancan.dao.IFoodDao;
import com.lxj.diancan.entity.Cart;
import com.lxj.diancan.entity.Food;
import com.lxj.diancan.factory.BeanFactory;
import com.lxj.diancan.service.IFoodService;
import com.lxj.diancan.utils.PageUtils;

/**
 * FoodServiceImpl
 */
public class FoodServiceImpl implements IFoodService {
    private IFoodDao foodDao = BeanFactory.getInstance("foodDaoImpl", IFoodDao.class);

    /**
     * 餐桌列表 分页
     */
    @Override
    public List<Map<String, Object>> list(PageUtils pageUtils, String keys) {
        return foodDao.list((pageUtils.getCrtPage() - 1) * pageUtils.getLimits(), pageUtils.getLimits(), keys);
    }

    @Override
    public void save(Food dt) {
        foodDao.save(dt);
    }

    @Override
    public int getTotal(String keywords) {
        return foodDao.getTotal(keywords);
    }

    public static void main(String[] args) {
        // System.out.println(new FoodServiceImpl().getTotal(null));
        System.out.println(new FoodServiceImpl().foodDao);
    }

    @Override
    public int update(Food dt) {
        return foodDao.update(dt);
    }

    @Override
    public int delete(Food dt) {
        return foodDao.delete(dt);

    }

    @Override
    public Food getFoodById(int id) {
        return foodDao.getFoodById(id);
    }

    @Override
    public int[] insertBatch(List<Cart> cart_list) {
        return foodDao.insertBatch(cart_list);
    }

    @Override
    public int getCountById(int id) {
        return foodDao.getCountById(id);
    }

}