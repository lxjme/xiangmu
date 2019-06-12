package com.lxj.diancan.entity;

public class Food {

	private int id;
	private String food_name;
	private int type_id;
	private double price;
	private double mp_price;
	private String remark;
	private String img;
	private FoodType foodType;

	public int getId() {
		return id;
	}

	public void setId(int id) {
		this.id = id;
	}

	public String getFood_name() {
		return food_name;
	}

	public void setFood_name(String food_name) {
		this.food_name = food_name;
	}

	public int getType_id() {
		return type_id;
	}

	public void setType_id(int type_id) {
		this.type_id = type_id;
	}

	public double getPrice() {
		return price;
	}

	public void setPrice(double price) {
		this.price = price;
	}

	public double getMp_price() {
		return mp_price;
	}

	public void setMp_price(double mp_price) {
		this.mp_price = mp_price;
	}

	public String getRemark() {
		return remark;
	}

	public void setRemark(String remark) {
		this.remark = remark;
	}

	public String getImg() {
		return img;
	}

	public void setImg(String img) {
		this.img = img;
	}

	public FoodType getFoodType() {
		return foodType;
	}

	public void setFoodType(FoodType foodType) {
		this.foodType = foodType;
	}

	@Override
	public String toString() {
		return "Food [foodType=" + foodType + ", food_name=" + food_name + ", id=" + id + ", img=" + img + ", mp_price="
				+ mp_price + ", price=" + price + ", remark=" + remark + ", type_id=" + type_id + "]";
	}

	
	
	
}
