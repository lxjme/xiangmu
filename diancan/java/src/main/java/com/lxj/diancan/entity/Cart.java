package com.lxj.diancan.entity;

/**
 * Cart
 */
public class Cart {

    private int id;
    private int nums = 0;
    private Food food;

    public Cart() {

    }

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public int getNums() {
        return nums;
    }

    public void setNums(int nums) {
        this.nums = nums;
    }

    public Food getFood() {
        return food;
    }

    public void setFood(Food food) {
        this.food = food;
    }

    
}