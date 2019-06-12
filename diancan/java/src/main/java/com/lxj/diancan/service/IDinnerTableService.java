package com.lxj.diancan.service;

import java.util.List;

import com.lxj.diancan.entity.DinnerTable;
import com.lxj.diancan.utils.PageUtils;

/**
 * IDinnerTableService
 */
public interface IDinnerTableService {

    List<DinnerTable> list();
    List<DinnerTable> list(PageUtils pageUtils, String keys);
    int getTotal(String keywords);

    List<DinnerTable> noYdTableList();


    // 更新
    int update(DinnerTable dt);
    // 添加
    void save(DinnerTable dt);
    // 删除
    int delete(DinnerTable dt);
}