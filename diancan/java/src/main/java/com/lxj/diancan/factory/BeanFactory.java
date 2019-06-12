package com.lxj.diancan.factory;

import java.util.ResourceBundle;

/**
 * 读取属性
 */
public class BeanFactory {
	
	private static ResourceBundle bundle;
	static {
		bundle = ResourceBundle.getBundle("instance");
	}

	/**
	 * @return
	 */
	public static <T> T getInstance(String key,Class<T> clazz) {
		String className = bundle.getString(key);
		try {
			return (T) Class.forName(className).newInstance();
		} catch (Exception e) {
			throw new RuntimeException(e);
		}
	}


}










