package com.lxj.diancan.filter;

import java.io.IOException;
import java.util.Enumeration;
import java.util.Map.Entry;

import javax.servlet.Filter;
import javax.servlet.FilterChain;
import javax.servlet.ServletException;
import javax.servlet.ServletRequest;
import javax.servlet.ServletResponse;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import javax.servlet.http.HttpSession;

import org.apache.commons.lang3.StringUtils;
// import org.apache.log4j.BasicConfigurator;
// import org.apache.log4j.Logger;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;

/**
 * FirstFilter
 */
public class FirstFilter implements Filter {
    private static Logger logger = LoggerFactory.getLogger(FirstFilter.class);
    // private static Logger logger =  (Logger) LogManager.getLogger(LogManager.ROOT_LOGGER_NAME);
    // private static Logger logger = Logger.getLogger(FirstFilter.class);

    public static void main(String[] args) {
        // BasicConfigurator.configure();
        logger.info("============");
    }

    @Override
    public void doFilter(ServletRequest request, ServletResponse response, FilterChain chain)
            throws IOException, ServletException {
        HttpServletRequest req = (HttpServletRequest) request;
        HttpServletResponse res = (HttpServletResponse) response;
        req.setCharacterEncoding("utf-8");

        String path = req.getContextPath();
        HttpSession session = req.getSession();
        String strURI = req.getRequestURI().replace(path, "");
        
        httpReuqestLog(session,req,strURI);


        chain.doFilter(req, res);

    }

    //打印请求日志
	private void httpReuqestLog(HttpSession session,HttpServletRequest reuqest, String uri){
		if(uri.endsWith(".jsp")){
        	logger.info(" ====================================================================");
        	// logger.info(" userId:"+(session.getAttribute(GlobalUtil.session_userid)==null ? "" : BeanUtil.toString(session.getAttribute(GlobalUtil.session_userid))));
        	logger.info(" uri:"+uri);
	        logger.info(" ====================================================================\n\n");
        }
        StringBuilder sb = new StringBuilder();
        String remoteAddr = reuqest.getHeader("X-Real-IP");
        if(remoteAddr==null){
        	remoteAddr = reuqest.getRemoteAddr();
        }
        sb.append("IP:["+remoteAddr+"]    ");
        sb.append("URI:["+reuqest.getRequestURI()+"]");
        logger.info(sb.toString());
        logger.info("====================================================================");
        logger.info("sessionID:"+session.getId());
        logger.info("------------------session------------------");
        Enumeration<String> names = session.getAttributeNames();
        while(names.hasMoreElements()){
        	String name=names.nextElement();
        	Object val=session.getAttribute(name);
        	logger.info(name+":"+val);
        }
        logger.info("------------------request------------------");
        for(Entry<String, String[]> entry:reuqest.getParameterMap().entrySet()){
        	logger.info(entry.getKey()+":"+StringUtils.join(entry.getValue(), ","));
        }
        logger.info("====================================================================\n\n");
	}

    
}