package com.lxj.diancan.service.impl;

import java.util.List;

import com.lxj.diancan.dao.IFoodTypeDao;
import com.lxj.diancan.entity.FoodType;
import com.lxj.diancan.factory.BeanFactory;
import com.lxj.diancan.service.IFoodTypeService;
import com.lxj.diancan.utils.PageUtils;

/**
* FoodTypeServiceImpl
*/
public class FoodTypeServiceImpl implements IFoodTypeService {
   private IFoodTypeDao foodTypeDao = BeanFactory.getInstance("foodTypeDaoImpl", IFoodTypeDao.class);


     /**
    * 餐桌列表 分页
    */
   @Override
   public List<FoodType> list(PageUtils pageUtils, String keys) {
       return foodTypeDao.list((pageUtils.getCrtPage()-1)*pageUtils.getLimits(), pageUtils.getLimits(), keys);
   }

   @Override
   public void save(FoodType dt) {
       foodTypeDao.save(dt);
   }

   @Override
   public int getTotal(String keywords) {
       return foodTypeDao.getTotal(keywords);
   }

   public static void main(String[] args) {
       // System.out.println(new FoodTypeServiceImpl().getTotal());
   }

   @Override
   public int update(FoodType dt) {
       return foodTypeDao.update(dt);
   }

   @Override
   public int delete(FoodType dt) {
       return foodTypeDao.delete(dt);

   }

    @Override
    public List<FoodType> listAll() {
        return foodTypeDao.listAll();
    }




}