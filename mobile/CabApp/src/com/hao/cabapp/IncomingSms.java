package com.hao.cabapp;

import java.util.ArrayList;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import com.hao.cabapp.DataPushService.Read;
import com.hao.cabapp.models.GeoJson;
import com.hao.cabapp.utils.CabAppConstants;
import com.hao.cabapp.utils.CentralUtils;
import com.hao.cabapp.utils.DataManipulationUtils;
import com.hao.cabapp.utils.DbUtils;
import com.hao.cabapp.utils.JSONParser;

import android.app.AlertDialog;
import android.content.BroadcastReceiver;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.database.Cursor;
import android.net.Uri;
import android.os.AsyncTask;
import android.os.Bundle;
import android.telephony.SmsManager;
import android.telephony.SmsMessage;
import android.view.ViewDebug.FlagToString;
import android.widget.Toast;

public class IncomingSms extends BroadcastReceiver {

	// Get the object of SmsManager
	final SmsManager sms = SmsManager.getDefault();

	@Override
	public void onReceive(Context arg0, Intent arg1) {
		final Bundle bundle = arg1.getExtras();

		try {

			if (bundle != null) {

				final Object[] pdusObj = (Object[]) bundle.get("pdus");

				for (int i = 0; i < pdusObj.length; i++) {

					SmsMessage currentMessage = SmsMessage
							.createFromPdu((byte[]) pdusObj[i]);
					String phoneNumber = currentMessage
							.getDisplayOriginatingAddress();

					final String senderNum = phoneNumber;
					final String message = currentMessage
							.getDisplayMessageBody();

					/*
					 * Log.i("SmsReceiver", "senderNum: " + senderNum +
					 * "; message: " + message);
					 */
					final CentralUtils cu = CentralUtils.getInstance();
					DbUtils dbUtils = new DbUtils(arg0.getApplicationContext());
					DataManipulationUtils dataManipulationUtils = new DataManipulationUtils();
					String[] preAr = dataManipulationUtils
							.readDetailsFromSMS(message);
					if (cu.getGeoObject().getState()
							.equalsIgnoreCase(CabAppConstants.IDLE_STATUS)) {
						if (!preAr[0].equals("") /*
												 * check for state is on journey
												 * and dont let this happen &&
												 * preAr[3].trim().equals(cu.
												 * getGeoObject().getDriverID())
												 */) {
							cu.getGeoObject().setState(
									CabAppConstants.MESSAGE_NOT_COPIED_STATUS);
							// cu.getGeoObject().setDriverID(preAr[3]);
							dbUtils.addData(
									CabAppConstants.MESSAGE_NOT_COPIED_STATUS,
									"", "");
							Intent kl = new Intent(arg0, NotifySMS.class);
							kl.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK);
							kl.putExtra("message", message);
							kl.putExtra("senderNum", senderNum);
							arg0.startActivity(kl);

							/*
							 * Uri uri = Uri.parse("content://sms/inbox");
							 * Cursor cursor =
							 * arg0.getContentResolver().query(uri, null, null,
							 * null, null); cursor.moveToFirst();
							 * cursor.etString(cursor.getColumnIndex("read"))
							 */
							// Show Alert
							GeoJson geoJson = cu.getGeoObject();
							long timeStamp = System.currentTimeMillis() / 1000L;
							new Read().execute(geoJson.getLatitiude() + "",
									geoJson.getLongitude() + "",
									geoJson.getEstimatedTime(),
									geoJson.getState(), geoJson.getHash(),
									geoJson.getCurrentOrderID(),
									geoJson.getDriverID(), geoJson.getSpeed()
											+ "", geoJson.getBearing() + "",
									timeStamp + "", geoJson.getCabID());
							/*
							 * Toast toast = Toast.makeText(arg0, "senderNum: "+
							 * senderNum + ", message: " + message, duration);
							 * toast.show();
							 */
						}

					} else {
						if (preAr[0].equals("2") /*
												 * check for state is on journey
												 * and dont let this happen &&
												 * preAr[3].trim().equals(cu.
												 * getGeoObject().getDriverID())
												 */) {
							ArrayList<String> ar = dbUtils.getPendingOrderIds();
							if (ar.contains(preAr[1].trim())) {
								dbUtils.deleteOrder(preAr[1]);
							} else {
								cu.getGeoObject()
										.setState(
												CabAppConstants.MESSAGE_NOT_COPIED_STATUS);
								// cu.getGeoObject().setDriverID(preAr[3]);
								dbUtils.addData(
										CabAppConstants.MESSAGE_NOT_COPIED_STATUS,
										"", "");
								Intent kl = new Intent(arg0, NotifySMS.class);
								kl.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK);
								kl.putExtra("message", message);
								kl.putExtra("senderNum", senderNum);
								arg0.startActivity(kl);

								/*
								 * Uri uri = Uri.parse("content://sms/inbox");
								 * Cursor cursor =
								 * arg0.getContentResolver().query(uri, null,
								 * null, null, null); cursor.moveToFirst();
								 * cursor
								 * .etString(cursor.getColumnIndex("read"))
								 */
								// Show Alert
								GeoJson geoJson = cu.getGeoObject();
								long timeStamp = System.currentTimeMillis() / 1000L;
								new Read().execute(geoJson.getLatitiude() + "",
										geoJson.getLongitude() + "",
										geoJson.getEstimatedTime(),
										geoJson.getState(), geoJson.getHash(),
										geoJson.getCurrentOrderID(),
										geoJson.getDriverID(),
										geoJson.getSpeed() + "",
										geoJson.getBearing() + "", timeStamp
												+ "", geoJson.getCabID());
								/*
								 * Toast toast = Toast.makeText(arg0,
								 * "senderNum: "+ senderNum + ", message: " +
								 * message, duration); toast.show();
								 */
							}
						} else {
							dbUtils.addOrder(preAr[1], message);
						}

					}
				}
			}
		} catch (Exception e) {
			// Log.e("SmsReceiver", "Exception smsReceiver" + e);

		}

	}

	public class Read extends AsyncTask<String, Integer, String> {
		String jsonString;

		@Override
		protected void onPostExecute(String jstring) {
			// Log.d("Sent", jstring);
			CentralUtils cu = CentralUtils.getInstance();
			if (cu.getGeoObject().getState()
					.equals(CabAppConstants.IDLE_STATUS)) {
				cu.getGeoObject().setCurrentOrderID("");
			}
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
