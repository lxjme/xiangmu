package com.lxj.diancan.entity;

/**
 *  菜系
 * @author lxj
 */
public class FoodType {

	private int id;
	private String type_name;
	
	
	public int getId() {
		return id;
	}
	public void setId(int id) {
		this.id = id;
	}


	public String getType_name() {
		return this.type_name;
	}

	public void setType_name(String type_name) {
		this.type_name = type_name;
	}

	@Override
	public String toString() {
		return "FoodType [id=" + id + ", type_name=" + type_name + "]";
	}

	
	
	
}
