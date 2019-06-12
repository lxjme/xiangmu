package com.lxj.diancan.service.impl;

import java.util.List;
import java.util.Map;

import com.lxj.diancan.dao.IOrderDao;
import com.lxj.diancan.entity.Cart;
import com.lxj.diancan.factory.BeanFactory;
import com.lxj.diancan.service.IOrderService;
import com.lxj.diancan.utils.PageUtils;

/**
 * OrderServiceImpl
 */
public class OrderServiceImpl implements IOrderService {
	private IOrderDao orderDao = BeanFactory.getInstance("orderDaoImpl", IOrderDao.class);

	@Override
	public int save(List<Cart> cart_list, Object table_id, Object total_price) {
		return orderDao.save(cart_list, table_id, total_price);
	}

	@Override
	public List<Map<String, Object>> list(PageUtils pageUtils) {
		return orderDao.list((pageUtils.getCrtPage() - 1) * pageUtils.getLimits(), pageUtils.getLimits());
	}

	@Override
	public int getTotal() {
		return orderDao.getTotal();
	}

	@Override
	public List<Map<String, Object>> order_list(int order_id) {
		return orderDao.order_list(order_id);
	}

	@Override
	public int updateStatus(int status, int id) {
		return orderDao.updateStatus(status, id);
	}
    
}