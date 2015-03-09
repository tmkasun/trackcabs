package com.hao.cabapp;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import com.hao.cabapp.UserActivity.Read;
import com.hao.cabapp.models.GeoJson;
import com.hao.cabapp.utils.CabAppConstants;
import com.hao.cabapp.utils.CentralUtils;
import com.hao.cabapp.utils.DataManipulationUtils;
import com.hao.cabapp.utils.DbUtils;
import com.hao.cabapp.utils.JSONParser;

import android.os.AsyncTask;
import android.os.Bundle;
import android.app.Activity;
import android.app.AlertDialog;
import android.content.BroadcastReceiver;
import android.content.ComponentName;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.IntentFilter;
import android.content.pm.PackageManager;
import android.telephony.SmsManager;
import android.telephony.SmsMessage;
import android.view.Menu;
import android.widget.Toast;

public class NotifySMS extends Activity {

	private static final String LOG_TAG = "SMSReceiver";
	public static final int NOTIFICATION_ID_RECEIVED = 0x1221;
	static final String ACTION = "android.provider.Telephony.SMS_RECEIVED";
	Activity myActivity;
	CentralUtils cu = CentralUtils.getInstance();

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		myActivity = this;
		final SmsManager sms = SmsManager.getDefault();
		final String message = this.getIntent().getStringExtra("message");
		final String senderNum = this.getIntent().getStringExtra("senderNum");
		final DbUtils db = new DbUtils(getApplicationContext());
		final DataManipulationUtils dataManipulationUtils = new DataManipulationUtils();
		String[] preAr = dataManipulationUtils.readDetailsFromSMS(message);
		if (!preAr[0].equals("")) {
			cu.getGeoObject().setCurrentOrderID(preAr[1]);
			if (Integer.parseInt(preAr[0]) == 1) {
				AlertDialog ad = new AlertDialog.Builder(this)
						.setTitle("New Order")
						.setCancelable(false)
						.setMessage(preAr[2] + " Accept This?")
						.setPositiveButton(android.R.string.yes,
								new DialogInterface.OnClickListener() {
									public void onClick(DialogInterface dialog,
											int which) {
										String[] ar = dataManipulationUtils
												.readDetailsFromSMS(message);
										// / Set vcancel validation Logic
										if (ar[2] != null) {
											cu.getGeoObject().setHash(ar[2]);
											cu.getGeoObject()
													.setHashCode(ar[4]);
											cu.getGeoObject()
													.setState(
															CabAppConstants.MESSAGE_COPIED_STATUS);
											// cu.getGeoObject().setDriverID(ar[3]);
											cu.getGeoObject()
													.setCurrentOrderID(ar[1]);
											//Log.d("aawa", "order id :" + ar[1]);
											/*
											 * sms.sendTextMessage(senderNum,
											 * null, "Order Accepted :)", null,
											 * null); myActivity.finish();
											 */db.addData(
													CabAppConstants.MESSAGE_COPIED_STATUS,
													ar[1], ar[4]);
											GeoJson geoJson = cu.getGeoObject();
											long timeStamp = System
													.currentTimeMillis() / 1000L;
											new Push().execute(
													geoJson.getLatitiude() + "",
													geoJson.getLongitude() + "",
													geoJson.getEstimatedTime(),
													geoJson.getState(),
													geoJson.getHash(),
													geoJson.getCurrentOrderID(),
													geoJson.getDriverID(),
													geoJson.getSpeed() + "",
													geoJson.getBearing() + "",
													timeStamp + "",
													geoJson.getCabID());
											myActivity.finish();
											Intent i = new Intent(
													getApplicationContext(),
													UserActivity.class);
											startActivity(i);
										}
									}
								})
						.setIcon(android.R.drawable.ic_dialog_alert)
						.show();
			} else {
				AlertDialog ad = new AlertDialog.Builder(this)
						.setTitle("Cancel Order")
						.setCancelable(false)
						.setMessage(
								preAr[2] + " This order has been cancelled .")
						.setPositiveButton(android.R.string.yes,
								new DialogInterface.OnClickListener() {
									public void onClick(DialogInterface dialog,
											int which) {
										// / Set vcancel validation Logic
										cu.getGeoObject().setHash("");
										cu.getGeoObject().setHashCode("");
										cu.getGeoObject().setState(
												CabAppConstants.IDLE_STATUS);
										db.addData(CabAppConstants.IDLE_STATUS,
												db.getOrderid(),
												db.getOrderhash());
										// cu.getGeoObject().setDriverID("");
										// ///////////check this
										cu.getGeoObject().setCurrentOrderID("");
										myActivity.finish();
										cu.getUserActivity().finish();
									}
								}).setIcon(android.R.drawable.ic_dialog_alert)
						.show();
			}

		}
	}

	public class Push extends AsyncTask<String, Integer, String> {
		String jsonString;

		@Override
		protected void onPostExecute(String jstring) {
			//Log.d("Sent", jstring);
			/*Toast.makeText(getApplicationContext(), jstring, Toast.LENGTH_SHORT)
					.show();*/
			CentralUtils cu = CentralUtils.getInstance();
			/*
			 * if(cu.getGeoObject().getState().equals(CabAppConstants.IDLE_STATUS
			 * )){ cu.getGeoObject().setCurrentOrderID(""); }
			 */
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
}
