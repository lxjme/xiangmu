package com.lxj.diancan.dao;
import java.util.List;

import com.lxj.diancan.entity.DinnerTable;

/**
 * IDinnerTableDao
 */
public interface IDinnerTableDao {
    // 查询
    List<DinnerTable> list();
    List<DinnerTable> list(int start, int limit, String keyword);
    int getTotal(String keyword);

    List<DinnerTable> noYdTableList();

    // 添加
    void save(DinnerTable dt);
    // 更新
    int update(DinnerTable dt);
    // 删除
    int delete(DinnerTable dt);
    
}