package com.lxj.diancan.utils;

/**
 * PageUtils
 */
public class PageUtils {

    private int total; // 总条数
    private int limits = 20;  // 每页显示条数
    private int crtPage; // 当前页码

    public PageUtils() {

    }
    public PageUtils(int total, int crtPage) {
        this.total = total;
        this.crtPage = crtPage;
    }

    public int getTotal() {
        return total;
    }

    public void setTotal(int total) {
        this.total = total;
    }

    public int getLimits() {
        return limits;
    }

    public void setLimits(int limits) {
        this.limits = limits;
    }

    public int getCrtPage() {
        return crtPage;
    }

    public void setCrtPage(int crtPage) {
        this.crtPage = crtPage;
    }

    /**
     * 总页数
     * @return
     */
    public int totalPages() {
        return (int) Math.ceil(total / (limits*1.0));
    }
    

}