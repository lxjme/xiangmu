package com.lxj.diancan.service.impl;

import java.util.List;

import com.lxj.diancan.dao.IDinnerTableDao;
import com.lxj.diancan.entity.DinnerTable;
import com.lxj.diancan.factory.BeanFactory;
import com.lxj.diancan.service.IDinnerTableService;
import com.lxj.diancan.utils.PageUtils;

/**
 * DinnerTableService
 */
public class DinnerTableServiceImpl implements IDinnerTableService {
    private IDinnerTableDao dinnerTableDao = BeanFactory.getInstance("dinnerTableDao", IDinnerTableDao.class);
    // private IDinnerTableDao dinnerTableDao = new DinnerTableDaoImpl();

    /** 
     * 餐桌列表
     */
    public List<DinnerTable> list() {
        return dinnerTableDao.list();
    }
    /** 
     * 餐桌列表 分页
     */
    @Override
    public List<DinnerTable> list(PageUtils pageUtils, String keys) {
        return dinnerTableDao.list((pageUtils.getCrtPage()-1)*pageUtils.getLimits(), pageUtils.getLimits(), keys);
    }

    @Override
    public void save(DinnerTable dt) {
        dinnerTableDao.save(dt);
    }

    @Override
    public int getTotal(String keywords) {
        return dinnerTableDao.getTotal(keywords);
    }

    public static void main(String[] args) {
        // System.out.println(new DinnerTableServiceImpl().getTotal());
    }

    @Override
    public int update(DinnerTable dt) {
        return dinnerTableDao.update(dt);
    }

    @Override
    public int delete(DinnerTable dt) {
        return dinnerTableDao.delete(dt);
        
    }

    @Override
    public List<DinnerTable> noYdTableList() {
        return dinnerTableDao.noYdTableList();
    }

    
}