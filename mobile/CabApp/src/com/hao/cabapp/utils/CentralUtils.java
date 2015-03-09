package com.hao.cabapp.utils;

import java.util.TimerTask;

import android.app.Activity;
import android.content.ContentResolver;
import android.content.Context;
import android.content.Intent;
import android.database.Cursor;
import android.location.Location;
import android.net.Uri;
import android.util.Log;

import com.hao.cabapp.models.GeoJson;

public class CentralUtils {
	private static GeoJson geoObject;
	private static CentralUtils centralutils;
	private static GPSTracker gpsTracker;
	private static Intent dataPushService;
	private static Context context;
	private static TimerTask timerTask;
	private static TimerTask statusTimer;
	private static String dispatcherNo="+94716866386";
	private double updateInterval= 5000;
	private Activity userActivity;
	private String ip;
	private String loggedin="logout";
	private String address;
	
	public static String getDispatcherNo() {
		return dispatcherNo;
	}


	public static void setDispatcherNo(String dispatcherNo) {
		CentralUtils.dispatcherNo = dispatcherNo;
	}


	public Context getContext() {
		return context;
	}


	public static void setContext(Context context) {
		CentralUtils.context = context;
	}


	public static CentralUtils getInstance(){
		if(centralutils==null){
			centralutils=new CentralUtils();
			geoObject=new GeoJson();
			gpsTracker=new GPSTracker(context); 
			
		}
		return centralutils;
	}
	
	public static void remove(){
		centralutils=null;
	}
	public GeoJson getGeoObject() {
		return geoObject;
	}

	public Location getLocation(Context cont){
		
		/*GeoJson geoObject=getGeoObject();
		 * 
		*/
		
		double newLat=0.0;
		double newLng=0.0;
		if((geoObject.getLatitiude()==0) && (geoObject.getLongitude()==0)){
		}else{
			gpsTracker.stopUsingGPS();
			newLat=gpsTracker.getLatitude();
			newLng=gpsTracker.getLongitude();
		}
		double distance=calculateDistance(geoObject.getLatitiude(), geoObject.getLongitude(), newLat, newLng);
		getGeoObject().setSpeed(calculateSpeed(distance, this.updateInterval)); 
		getGeoObject().setBearing(calculateBearing(geoObject.getLatitiude(), geoObject.getLongitude(), newLat, newLng));
		//getGeoObject().setBearing(gpsTracker.getLocation().getBearing());
		//getGeoObject().setSpeed(gpsTracker.getLocation().getSpeed());
		
		getGeoObject().setLatitiude(newLat);
		getGeoObject().setLongitude(newLng);
		return gpsTracker.getLocation();
	}
	
	public double calculateSpeed(double distance,double timeInterval){
		double result = (distance/timeInterval)*1000;
		return result*1000d/3600d;
	}
	
	
	
	public double calculateDistance(double lat1, double lng1, double lat2, double lng2) {
	    double dLat = Math.toRadians(lat2 - lat1);
	    double dLon = Math.toRadians(lng2 - lng1);
	    double a = Math.sin(dLat / 2) * Math.sin(dLat / 2)
	            + Math.cos(Math.toRadians(lat1))
	            * Math.cos(Math.toRadians(lat2)) * Math.sin(dLon / 2)
	            * Math.sin(dLon / 2);
	    double c = 2 * Math.atan2(Math.sqrt(a),Math.sqrt(1-a));
	    double distanceInMeters = 6371000 * c;
	   // Log.d("Speed", "distance :"+distanceInMeters);
	    return distanceInMeters;
	}
	
	public double calculateBearing(double lat1, double lng1, double lat2, double lng2) {
	    double dLat = Math.toRadians(lat2 - lat1);
	    double dLon = Math.toRadians(lng2 - lng1);
	    double y=Math.sin(Math.toRadians(lng2)-Math.toRadians(lng1)) * Math.cos(Math.toRadians(lat2));
	    double x=(Math.cos(Math.toRadians(lat1))*Math.sin(Math.toRadians(lat2))) - (Math.sin(Math.toRadians(lat1)*Math.cos(Math.toRadians(lat2))*Math.cos(dLon)));
	    double c = Math.toDegrees(Math.atan2(y, x));
	    double h =(c+180) % 360;
	    return h;
	}
	
	public String getLastSMS(ContentResolver contentResolver){
		Cursor cursor=contentResolver.query(Uri.parse("content://sms/inbox"), new String[]{"body","address"}, null, null, "date desc limit 1");
		cursor.moveToFirst();
		if(cursor.getString(1).equals(dispatcherNo) && cursor.getString(0).startsWith("#")){
			return cursor.getString(0);
		}else{
			return null;
		}
	}


	public TimerTask getTimerTask() {
		return timerTask;
	}


	public void setTimerTask(TimerTask timerTask) {
		CentralUtils.timerTask = timerTask;
	}


	public double getUpdateInterval() {
		return updateInterval;
	}


	public void setUpdateInterval(double updateInterval) {
		this.updateInterval = updateInterval;
	}


	public Activity getUserActivity() {
		return userActivity;
	}


	public void setUserActivity(Activity userActivity) {
		this.userActivity = userActivity;
	}


	public String getIp() {
		return ip;
	}


	public void setIp(String ip) {
		this.ip = ip;
	}


	public String getLoggedin() {
		return loggedin;
	}


	public void setLoggedin(String loggedin) {
		Log.d("aawa", "Logged in set to "+loggedin);
		this.loggedin = loggedin;
	}


	public static Intent getDataPushService() {
		return dataPushService;
	}


	public static void setDataPushService(Intent dataPushService) {
		CentralUtils.dataPushService = dataPushService;
	}


	public String getAddress() {
		return address;
	}


	public void setAddress(String address) {
		this.address = address;
	}


	public TimerTask getStatusTimer() {
		return statusTimer;
	}


	public void setStatusTimer(TimerTask statusTimer) {
		CentralUtils.statusTimer = statusTimer;
	}
	
}
