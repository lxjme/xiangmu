package com.lxj.diancan.entity;

import java.util.Date;

public class DinnerTable {

	private int id;
	private String table_name;
	private int table_status; 
	private Date orderDate;
	public int getId() {
		return id;
	}
	public void setId(int id) {
		this.id = id;
	}
	
	public Date getOrderDate() {
		return orderDate;
	}
	public void setOrderDate(Date orderDate) {
		this.orderDate = orderDate;
	}


	public String getTable_name() {
		return table_name;
	}

	public void setTable_name(String table_name) {
		this.table_name = table_name;
	}

	public int getTable_status() {
		return table_status;
	}

	public void setTable_status(int table_status) {
		this.table_status = table_status;
	}

	@Override
	public String toString() {
		return "DinnerTable [id=" + id + ", orderDate=" + orderDate + ", table_name=" + table_name + ", table_status="
				+ table_status + "]";
	}

	
	
	
}
