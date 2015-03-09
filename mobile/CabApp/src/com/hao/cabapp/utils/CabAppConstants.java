package com.hao.cabapp.utils;

public class CabAppConstants {

	public static final String START_STATUS = "START";
	
	public static final String MESSAGE_COPIED_STATUS = "MSG_COPIED";
	
	public static final String MESSAGE_NOT_COPIED_STATUS = "MSG_NOT_COPIED";
	
	public static final String AT_THE_PLACE_STATUS = "AT_THE_PLACE";
	
	public static final String PASSENGER_ON_BOARD_STATUS = "POB";
	
	public static final String END_STATUS = "END";
	
	public static final String CANCEL_STATUS = "CANCEL";
	
	public static final String DISPATCHER_CANCEL_STATUS = "DIS_CANCEL";
	
	public static final String IDLE_STATUS = "IDLE";
	
	public static final String DISENGAGE_STATUS = "DISENGAGE";
	
	public static final double GPS_UPDATE_TIME_INTERVAL = 5000; 
	
	public static final String LOGIN_URL = "http://hao.knnect.com/index.php/authenticate/driver";
	
	public static final String LOGOUT_URL = "http://hao.knnect.com/index.php/authenticate/logout";

	public static final String DATA_PUSH_URL = "http://hao.knnect.com:9763/endpoints/GpsDataOverHttp/geoJson";

	public static final String STATUS_CHECK_URL = "http://hao.knnect.com/index.php/authenticate/checkStatus";
}
