package com.hao.cabapp;

import java.util.Timer;
import java.util.TimerTask;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import com.hao.cabapp.models.GeoJson;
import com.hao.cabapp.utils.CabAppConstants;
import com.hao.cabapp.utils.CentralUtils;
import com.hao.cabapp.utils.DbUtils;
import com.hao.cabapp.utils.GPSTracker;
import com.hao.cabapp.utils.JSONParser;

import android.app.IntentService;
import android.app.Notification;
import android.app.PendingIntent;
import android.app.Service;
import android.content.ComponentName;
import android.content.Intent;
import android.content.pm.PackageManager;
import android.location.Location;
import android.location.LocationListener;
import android.location.LocationManager;
import android.os.AsyncTask;
import android.os.Bundle;
import android.os.Handler;
import android.os.IBinder;
import android.util.Log;
import android.widget.Toast;


public class DataPushService extends Service implements LocationListener {
	private LocationManager myManager;
	private Location location = new Location("");
	/*
	 * public DataPushService() { super("My service"); }
	 */

	final Handler handler = new Handler();
	final Handler handler2 = new Handler();
	Timer timer2 = new Timer();
	
	TimerTask doAsynchronousTask2;

	/*
	 * @Override protected void onHandleIntent(Intent arg0) {
	 * 
	 * doAsynchronousTask2 = new TimerTask() {
	 * 
	 * @Override public void run() { handler.post(new Runnable() { public void
	 * run() { CentralUtils cu = CentralUtils.getInstance(); Location
	 * location=cu.getLocation(getApplicationContext()); GeoJson
	 * geoJson=cu.getGeoObject(); long timeStamp=System.currentTimeMillis() /
	 * 1000L; if(location!=null){ geoJson.setLatitiude(location.getLatitude());
	 * geoJson.setLongitude(location.getLongitude()); } new
	 * Read().execute(geoJson
	 * .getLatitiude()+"",geoJson.getLongitude()+"",geoJson
	 * .getEstimatedTime(),geoJson
	 * .getState(),geoJson.getHash(),geoJson.getCurrentOrderID
	 * (),geoJson.getDriverID
	 * (),geoJson.getSpeed()+"",geoJson.getBearing()+"",timeStamp
	 * +"",geoJson.getCabID()); Log.d("Aawa",
	 * geoJson.getLatitiude()+":"+geoJson.
	 * getLongitude()+":"+geoJson.getState()+":"+geoJson.getHash()); } }); } };
	 * CentralUtils cu = CentralUtils.getInstance();
	 * cu.setTimerTask(doAsynchronousTask2); timer2.schedule(cu.getTimerTask(),
	 * 0, 5000);
	 * 
	 * }
	 */

	public class Read extends AsyncTask<String, Integer, String> {
		String jsonString;

		@Override
		protected void onPostExecute(String jstring) {
			//Log.d("Sent", jstring);
			/*Toast.makeText(getApplicationContext(), jstring, Toast.LENGTH_SHORT)
					.show();*/
			CentralUtils cu = CentralUtils.getInstance();
			/*if (cu.getGeoObject().getState()
					.equals(CabAppConstants.IDLE_STATUS)) {
				cu.getGeoObject().setCurrentOrderID("");
			}*/
		}

		@Override
		protected String doInBackground(String... arg0) {
			/*
			 * CentralUtils cu = CentralUtils.getInstance(); GPSTracker gp = new
			 * GPSTracker(getApplicationContext());
			 *//*
				 * cu.getGeoObject().setLatitiude(location.getLatitude()) ;
				 * cu.getGeoObject().setLongitude(location.getLongitude ());
				 */JSONObject jb = new JSONObject();
			try {
				jb.put("type", "Feature");
				jb.put("id", arg0[6]);

				JSONObject propertyJb = new JSONObject();
				propertyJb.put("speed", arg0[7]);
				propertyJb.put("heading", arg0[8]);
				propertyJb.put("orderId", arg0[5]);
				propertyJb.put("cabId", arg0[10]);
				propertyJb.put("estimatedTime", arg0[2]);
				propertyJb.put("state", arg0[3]);
				propertyJb.put("timeStamp", arg0[9]);
				propertyJb.put("information", arg0[4]);
				jb.put("properties", propertyJb);
				JSONObject geometryJb = new JSONObject();
				geometryJb.put("type", "Point");
				// JSONArray jar=new JSONArray();
				// JSONObject latLng=new JSONObject();
				JSONArray latLng = new JSONArray();
				latLng.put(arg0[1]);
				latLng.put(arg0[0]);
				// jar.put(latLng);
				geometryJb.put("coordinates", latLng);
				jb.put("geometry", geometryJb);
			} catch (JSONException e) {
				e.printStackTrace();
			}
			CentralUtils cu = new CentralUtils();
			JSONParser jp = new JSONParser();
			/*
			 * jsonString=jp.sendJSONToUrl("http://50.18.212.27:3001",
			 * jb.toString());
			 *//*
				 * jsonString=jp.sendJSONToUrl("http://"+cu.getIp()+
				 * ":9764/endpoints/GpsDataOverHttp/trackingstream",
				 * jb.toString());
				 */
			jsonString = jp.sendJSONToUrl(CabAppConstants.DATA_PUSH_URL,
					jb.toString());
			// jsonString=jp.getJSONFromUrl("http://maps.googleapis.com/maps/api/directions/json");
			return jb.toString();
		}
	}

	@Override
	public void onDestroy() {
		super.onDestroy();
		//Log.d("Destroy", "Destroyed");
		/*
		 * if(CentralUtils.getInstance().getLoggedin().equals("login")){ Intent
		 * i2 = new Intent(getApplicationContext(), DataPushService.class);
		 * startService(i2); }
		 */

	}
	
	public class Status extends AsyncTask<String, Integer, String> {
		String jsonString;

		@Override
		protected void onPostExecute(String jstring) {
			JSONObject ob;
			try {
				ob = new JSONObject(jstring);
				String loggedOut = ob.getString("loggedOut");
				String isIdle = ob.getString("isIdle");
				CentralUtils cu = CentralUtils.getInstance();
				DbUtils db = new DbUtils(getApplicationContext());
				if (loggedOut.trim().equals("true")) {
					
					if (cu.getTimerTask() != null) {
						cu.getTimerTask().cancel();
						cu.setTimerTask(null);
					}
					ComponentName component = new ComponentName(
							getApplicationContext(), IncomingSms.class);
					getPackageManager().setComponentEnabledSetting(component,
							PackageManager.COMPONENT_ENABLED_STATE_DISABLED,
							PackageManager.DONT_KILL_APP);
					cu.setLoggedin("logout");
					cu.remove();
					System.exit(1);
				}
				
				if (isIdle.trim().equals("true")) {
					cu.getGeoObject().setHash("");
					cu.getGeoObject().setHashCode("");
					cu.getGeoObject().setState(
							CabAppConstants.IDLE_STATUS);
					db.addData(CabAppConstants.IDLE_STATUS,
							db.getOrderid(),
							db.getOrderhash());
					cu.getGeoObject().setCurrentOrderID("");
					cu.getUserActivity().finish();
				}
				
			} catch (JSONException e) {
				e.printStackTrace();
			}
			
			
		}

		@Override
		protected String doInBackground(String... arg0) {
				JSONObject jb = new JSONObject();
				try {
					jb.put("id", arg0[0]);
				} catch (JSONException e) {
					e.printStackTrace();
				}
			JSONParser jp = new JSONParser();
			jsonString = jp.sendJSONToUrl(CabAppConstants.STATUS_CHECK_URL,jb.toString());
			return jsonString;
		}
	}

	@Override
	public int onStartCommand(Intent intent, int flags, int startId) {

		doAsynchronousTask2 = new TimerTask() {
			@Override
			public void run() {
				handler2.post(new Runnable() {
					public void run() {
						myManager = (LocationManager) getSystemService(LOCATION_SERVICE);
						CentralUtils cu = CentralUtils.getInstance();
						update();
						GeoJson geoJson = cu.getGeoObject();
						long timeStamp = System.currentTimeMillis() / 1000L;
						if (location != null) {
							double newLat=location.getLatitude();
							double newLng=location.getLongitude();
							Double distance=calculateDistance(geoJson.getLatitiude(), geoJson.getLongitude(), newLat, newLng);
							geoJson.setSpeed(calculateSpeed(distance, 5000)); 
							geoJson.setBearing(calculateBearing(geoJson.getLatitiude(), geoJson.getLongitude(), newLat, newLng));
							geoJson.setLatitiude(newLat);
							geoJson.setLongitude(newLng);
													
						}
						new Read().execute(geoJson.getLatitiude() + "",
								geoJson.getLongitude() + "",
								geoJson.getEstimatedTime(), geoJson.getState(),
								geoJson.getHash(), geoJson.getCurrentOrderID(),
								geoJson.getDriverID(), geoJson.getSpeed() + "",
								geoJson.getBearing() + "", timeStamp + "",
								geoJson.getCabID());
						
						
						/*Log.d("Aawa",
								geoJson.getLatitiude() + ":"
										+ Send a message...
History is off
geoJson.getLongitude() + ":"
										+ geoJson.getState() + ":"
										+ geoJson.getHash());*/
					}
				});
			}
		};
		
		
		
		/*
		doAsynchronousTask3 = new TimerTask() {
			@Override
			public void run() {
				handler2.post(new Runnable() {
					public void run() {
						CentralUtils cu = CentralUtils.getInstance();
						GeoJson geoJson = cu.getGeoObject();
						new Status().execute(geoJson.getDriverID());
						
					}
				});
			}
		};
		*/
		
		
		
		CentralUtils cu = CentralUtils.getInstance();
		cu.setTimerTask(doAsynchronousTask2);
		timer2.schedule(cu.getTimerTask(), 0, 5000);
		Intent i=new Intent(this, FrontController.class);;
		i.setFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP
				| Intent.FLAG_ACTIVITY_SINGLE_TOP);
		Notification note = new Notification(R.drawable.haologo,
				"Tracking Service Started", System.currentTimeMillis());
		PendingIntent pi = PendingIntent.getActivity(this, 0, i, 0);
		note.setLatestEventInfo(this, "Hao City Cabs", "Hao city cabs driver app is up and running", pi);
		note.flags |= Notification.FLAG_NO_CLEAR;
		startForeground(1337, note);
		// We want this service to continue running until it is explicitly
		// stopped, so return sticky.
		return START_NOT_STICKY;

	}

	@Override
	public boolean stopService(Intent name) {
		stopForeground(true);
		stopSelf();
		return super.stopService(name);
	}

	public void update() {
		myManager.requestLocationUpdates(LocationManager.NETWORK_PROVIDER, 0, 0,
				this);
		myManager.requestLocationUpdates(LocationManager.GPS_PROVIDER, 0, 0,
				this);
	}

	@Override
	public void onLocationChanged(Location location) {
		this.location = location;

	}

	@Override
	public void onProviderDisabled(String provider) {
		// TODO Auto-generated method stub 

	}

	@Override
	public void onProviderEnabled(String provider) {
		// TODO Auto-generated method stub

	}

	@Override
	public void onStatusChanged(String provider, int status, Bundle extras) {
		// TODO Auto-generated method stub

	}

	@Override
	public IBinder onBind(Intent intent) {
		// TODO Auto-generated method stub
		return null;
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
	    double h =(c) % 360;
	    return h;
	}
}