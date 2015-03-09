package com.hao.cabapp;

import java.util.HashMap;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;
import android.graphics.PorterDuff;

import com.hao.cabapp.DataPushService.Read;
import com.hao.cabapp.MainActivity.End;
import com.hao.cabapp.R.color;
import com.hao.cabapp.models.GeoJson;
import com.hao.cabapp.utils.CabAppConstants;
import com.hao.cabapp.utils.CentralUtils;
import com.hao.cabapp.utils.DataManipulationUtils;
import com.hao.cabapp.utils.DbUtils;
import com.hao.cabapp.utils.JSONParser;

import android.net.ConnectivityManager;
import android.net.NetworkInfo;
import android.os.AsyncTask;
import android.os.Bundle;
import android.os.Handler;
import android.annotation.SuppressLint;
import android.app.Activity;
import android.app.AlertDialog;
import android.app.ProgressDialog;
import android.content.ComponentName;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.pm.PackageManager;
import android.graphics.Color;
import android.telephony.SmsManager;
import android.view.Menu;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.inputmethod.InputMethodManager;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ImageButton;
import android.widget.TextView;
import android.widget.Toast;

public class UserActivity extends Activity {
	Activity loopback;
	Context thisCon;
	private String hash;

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		loopback = this;
		setContentView(R.layout.activity_user);
		this.thisCon = getApplicationContext();
		final Button reachedHome = (Button) findViewById(R.id.reachedHome);
		final Button passengerOnBoard = (Button) findViewById(R.id.passengerOnBoard);
		final Button endJourney = (Button) findViewById(R.id.endJourney);
		final ImageButton logout = (ImageButton) findViewById(R.id.logout);
		final ImageButton close = (ImageButton) findViewById(R.id.close);
		final DbUtils db = new DbUtils(getApplicationContext());
		final TextView tv = (TextView) findViewById(R.id.textView1);
		final EditText estimatedTime = (EditText) findViewById(R.id.estimatedTime);
		GeoJson json = CentralUtils.getInstance().getGeoObject();
		CentralUtils cu = CentralUtils.getInstance();
		cu.setUserActivity(loopback);
		hash = cu.getGeoObject().getHash();
		DataManipulationUtils dataManipulationUtils = new DataManipulationUtils();
		estimatedTime.setVisibility(View.INVISIBLE);
		close.setVisibility(View.INVISIBLE);
		if (json.getState().trim()
				.equals(CabAppConstants.MESSAGE_COPIED_STATUS)) {
			fillData(dataManipulationUtils, db, cu);
			logout.setVisibility(View.INVISIBLE);
			close.setVisibility(View.VISIBLE);
			passengerOnBoard.setVisibility(View.INVISIBLE);
			endJourney.setVisibility(View.INVISIBLE);
			tv.setText("Order ID : "+cu.getGeoObject().getCurrentOrderID()+" Details - "+ hash);
			// estimatedTime.setVisibility(View.INVISIBLE);
		} else if ((json.getState().trim()
				.equals(CabAppConstants.AT_THE_PLACE_STATUS))) {
			fillData(dataManipulationUtils, db, cu);
			reachedHome.getBackground().setColorFilter(color.DarkRed,
					PorterDuff.Mode.DARKEN);
			logout.setVisibility(View.INVISIBLE);
			close.setVisibility(View.VISIBLE);
			reachedHome.setVisibility(View.INVISIBLE);
			passengerOnBoard.setVisibility(View.VISIBLE);

			// estimatedTime.setVisibility(View.INVISIBLE);
			endJourney.setVisibility(View.INVISIBLE);
			tv.setText("Order ID : "+cu.getGeoObject().getCurrentOrderID()+" Details - "+ hash);
		}
		else if ((json.getState().trim()
				.equals(CabAppConstants.PASSENGER_ON_BOARD_STATUS))) {
			fillData(dataManipulationUtils, db, cu);
			InputMethodManager inputManager = (InputMethodManager) getSystemService(this.INPUT_METHOD_SERVICE);
			logout.setVisibility(View.INVISIBLE);
			close.setVisibility(View.VISIBLE);
			/*
			 * inputManager.hideSoftInputFromWindow(getCurrentFocus().getWindowToken
			 * (), InputMethodManager.HIDE_NOT_ALWAYS);
			 */
			reachedHome.setVisibility(View.INVISIBLE);
			passengerOnBoard.setVisibility(View.INVISIBLE);
			endJourney.setVisibility(View.VISIBLE);
			// estimatedTime.setVisibility(View.INVISIBLE);
			passengerOnBoard.getBackground().setColorFilter(color.DarkRed,
					PorterDuff.Mode.DARKEN);
			tv.setText("Order ID : "+cu.getGeoObject().getCurrentOrderID()+" Details - "+ hash);
		}
		else {
			// endJourney.getBackground().setColorFilter(color.DarkRed,PorterDuff.Mode.DARKEN);

			reachedHome.setVisibility(View.INVISIBLE);
			passengerOnBoard.setVisibility(View.INVISIBLE);
			endJourney.setVisibility(View.INVISIBLE);
			close.setVisibility(View.INVISIBLE);
			tv.setText("");
			// estimatedTime.setVisibility(View.INVISIBLE);
		}
		
		reachedHome.setOnClickListener(new OnClickListener() {

			@Override
			public void onClick(View arg0) {

				AlertDialog.Builder builder = new AlertDialog.Builder(
						UserActivity.this);
				builder.setTitle("Confirmation")
						.setCancelable(true)
						.setMessage("Are you sure you want to Change state?")
						.setPositiveButton("Yes",
								new DialogInterface.OnClickListener() {
									public void onClick(DialogInterface dialog,
											int id) {
										CentralUtils cu = CentralUtils
												.getInstance();
										if (cu.getGeoObject()
												.getState()
												.equals(CabAppConstants.MESSAGE_COPIED_STATUS)) {
											cu.getGeoObject()
													.setState(
															CabAppConstants.AT_THE_PLACE_STATUS);
											db.addData(
													CabAppConstants.AT_THE_PLACE_STATUS,
													cu.getGeoObject()
															.getCurrentOrderID(),
													cu.getGeoObject()
															.getHashCode());
											reachedHome
													.setVisibility(View.INVISIBLE);
											passengerOnBoard
													.setVisibility(View.VISIBLE);
											// estimatedTime.setVisibility(View.VISIBLE);
											reachedHome
													.getBackground()
													.setColorFilter(
															color.DarkRed,
															PorterDuff.Mode.DARKEN);
											reachedHome.setEnabled(false);
											/*
											 * SmsManager sms =
											 * SmsManager.getDefault();
											 * sms.sendTextMessage
											 * (cu.getDispatcherNo(), null,
											 * cu.getGeoObject
											 * ().getHashCode()+" "
											 * +cu.getGeoObject().getState(),
											 * null, null);
											 */
											GeoJson geoJson = cu.getGeoObject();
											long timeStamp = System
													.currentTimeMillis() / 1000L;
											new Read().execute(
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
										} else {
											AlertDialog.Builder builder = new AlertDialog.Builder(
													UserActivity.this);
											builder.setTitle("No Pending Order")
													.setCancelable(true)
													.setMessage(
															"No new order has been recieved")
													.setPositiveButton(
															"OK",
															new DialogInterface.OnClickListener() {
																public void onClick(
																		DialogInterface dialog,
																		int id) {
																	// loginID.setText("");
																	// password.setText("");
																}
															});
											AlertDialog alert = builder
													.create();
											alert.show();
										}
									}
								})
						.setNegativeButton("No",
								new DialogInterface.OnClickListener() {
									public void onClick(DialogInterface dialog,
											int id) {

									}
								});
				AlertDialog alert = builder.create();
				alert.show();

			}
		});

		passengerOnBoard.setOnClickListener(new OnClickListener() {

			@Override
			public void onClick(View arg0) {

				AlertDialog.Builder builder = new AlertDialog.Builder(
						UserActivity.this);
				builder.setTitle("Confirmation")
						.setCancelable(true)
						.setMessage("Are you sure you want to Change state?")
						.setPositiveButton("Yes",
								new DialogInterface.OnClickListener() {
									public void onClick(DialogInterface dialog,
											int id) {
										CentralUtils cu = CentralUtils
												.getInstance();
										if (cu.getGeoObject()
												.getState()
												.equals(CabAppConstants.AT_THE_PLACE_STATUS)) {
											if (!estimatedTime.getText()
													.toString().trim()
													.equals("")) {
												cu.getGeoObject()
														.setEstimatedTime(
																estimatedTime
																		.getText()
																		.toString());
											} else {
												cu.getGeoObject()
														.setEstimatedTime("");
											}
											cu.getGeoObject()
													.setState(
															CabAppConstants.PASSENGER_ON_BOARD_STATUS);
											db.addData(
													CabAppConstants.PASSENGER_ON_BOARD_STATUS,
													cu.getGeoObject()
															.getCurrentOrderID(),
													cu.getGeoObject()
															.getHashCode());
											passengerOnBoard
													.setVisibility(View.INVISIBLE);
											// estimatedTime.setVisibility(View.INVISIBLE);
											endJourney
													.setVisibility(View.VISIBLE);
											/*
											 * SmsManager sms =
											 * SmsManager.getDefault();
											 * sms.sendTextMessage
											 * (cu.getDispatcherNo(), null,
											 * cu.getGeoObject
											 * ().getHashCode()+" "
											 * +cu.getGeoObject().getState(),
											 * null, null);
											 */GeoJson geoJson = cu
													.getGeoObject();
											long timeStamp = System
													.currentTimeMillis() / 1000L;
											new Read().execute(
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
											passengerOnBoard
													.getBackground()
													.setColorFilter(
															color.DarkRed,
															PorterDuff.Mode.DARKEN);
											passengerOnBoard.setEnabled(false);
										} else {
											/*
											 * AlertDialog.Builder builder = new
											 * AlertDialog.Builder(
											 * UserActivity.this);
											 * builder.setTitle
											 * ("No Pending Order")
											 * .setCancelable(true) .setMessage(
											 * "No new order has been recieved")
											 * .setPositiveButton("OK", new
											 * DialogInterface.OnClickListener()
											 * { public void onClick(
											 * DialogInterface dialog, int id) {
											 * //loginID.setText("");
											 * //password.setText(""); } });
											 * AlertDialog alert =
											 * builder.create(); alert.show();
											 */
										}
									}
								})
						.setNegativeButton("No",
								new DialogInterface.OnClickListener() {
									public void onClick(DialogInterface dialog,
											int id) {

									}
								});
				AlertDialog alert = builder.create();
				alert.show();

			}
		});

		endJourney.setOnClickListener(new OnClickListener() {

			@Override
			public void onClick(View arg0) {
				if(isNetworkAvailable()){
				AlertDialog.Builder builder = new AlertDialog.Builder(
						UserActivity.this);
				builder.setTitle("Confirmation")
						.setCancelable(true)
						.setMessage("Are you sure you want to Change state?")
						.setPositiveButton("Yes",
								new DialogInterface.OnClickListener() {
									public void onClick(DialogInterface dialog,
											int id) {
										CentralUtils cu = CentralUtils
												.getInstance();
										if (cu.getGeoObject()
												.getState()
												.equals(CabAppConstants.PASSENGER_ON_BOARD_STATUS)) {
											cu.getGeoObject()
													.setState(
															CabAppConstants.IDLE_STATUS);
											/*
											 * endJourney.setVisibility(View.
											 * INVISIBLE);
											 */
											// Log.d("aawa",
											// "order id :"+cu.getGeoObject().getCurrentOrderID());
											db.addData(
													CabAppConstants.IDLE_STATUS,
													cu.getGeoObject()
															.getCurrentOrderID(),
													cu.getGeoObject()
															.getHashCode());
											cu.getGeoObject().setEstimatedTime(
													"");
											/*
											 * SmsManager sms =
											 * SmsManager.getDefault();
											 * sms.sendTextMessage
											 * (cu.getDispatcherNo(), null,
											 * cu.getGeoObject
											 * ().getHashCode()+" "
											 * +cu.getGeoObject().getState(),
											 * null, null);
											 */GeoJson geoJson = cu
													.getGeoObject();
											long timeStamp = System
													.currentTimeMillis() / 1000L;
											new Read().execute(
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
											/*
											 * cu.getGeoObject().setCurrentOrderID
											 * ("");
											 * cu.getGeoObject().setHash("");
											 */
											HashMap<String, String> hm = db
													.getNextOrder();
											if (hm.size() != 0
													&& !hm.get("test").equals(
															"false")) {
												cu.getGeoObject()
														.setState(
																CabAppConstants.MESSAGE_NOT_COPIED_STATUS);
												db.addData(
														CabAppConstants.MESSAGE_NOT_COPIED_STATUS,
														"", "");
												Intent kl = new Intent(
														loopback,
														NotifySMS.class);
												kl.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK);
												kl.putExtra("message",
														hm.get("orderHash"));
												kl.putExtra("senderNum", 0);
												loopback.startActivity(kl);
											}
											endJourney
													.getBackground()
													.setColorFilter(
															color.DarkRed,
															PorterDuff.Mode.DARKEN);
											loopback.finish();
										} else {
											/*
											 * AlertDialog.Builder builder = new
											 * AlertDialog.Builder(
											 * UserActivity.this);
											 * builder.setTitle
											 * ("No Pending Order")
											 * .setCancelable(true) .setMessage(
											 * "No order has been recieved")
											 * .setPositiveButton("OK", new
											 * DialogInterface.OnClickListener()
											 * { public void onClick(
											 * DialogInterface dialog, int id) {
											 * //loginID.setText("");
											 * //password.setText(""); } });
											 * AlertDialog alert =
											 * builder.create(); alert.show();
											 */
										}
									}
								})
						.setNegativeButton("No",
								new DialogInterface.OnClickListener() {
									public void onClick(DialogInterface dialog,
											int id) {

									}
								});
				AlertDialog alert = builder.create();
				alert.show();
				}else{
					AlertDialog.Builder builder = new AlertDialog.Builder(
							UserActivity.this);
					builder.setTitle("No Network")
							.setCancelable(true)
							.setMessage("Internet connection is not available.Please contact Hao cabs admin")
							.setPositiveButton("OK",
									new DialogInterface.OnClickListener() {
										public void onClick(DialogInterface dialog,
												int id) {
											// loginID.setText("");
											// password.setText("");
										}
									});
					AlertDialog alert = builder.create();
					alert.show();
				}
			}
		});
		
		//////////////////////////////////////////////////////////////////////////////////////////////////
		close.setOnClickListener(new OnClickListener() {

			@Override
			public void onClick(View arg0) {
				if(isNetworkAvailable()){
					GeoJson geo = CentralUtils.getInstance().getGeoObject();
				AlertDialog.Builder builder = new AlertDialog.Builder(
						UserActivity.this);
				builder.setTitle("Confirmation")
						.setCancelable(true)
						.setMessage("Are you sure you want to finish order? \n Order ID :"+ geo.getCurrentOrderID() +" \n Address :"+geo.getHash())
						.setPositiveButton("Yes",
								new DialogInterface.OnClickListener() {
									public void onClick(DialogInterface dialog,
											int id) {
										CentralUtils cu = CentralUtils
												.getInstance();
										
											cu.getGeoObject()
													.setState(
															CabAppConstants.IDLE_STATUS);
											/*
											 * endJourney.setVisibility(View.
											 * INVISIBLE);
											 */
											// Log.d("aawa",
											// "order id :"+cu.getGeoObject().getCurrentOrderID());
											db.addData(
													CabAppConstants.IDLE_STATUS,
													cu.getGeoObject()
															.getCurrentOrderID(),
													cu.getGeoObject()
															.getHashCode());
											cu.getGeoObject().setEstimatedTime(
													"");
											/*
											 * SmsManager sms =
											 * SmsManager.getDefault();
											 * sms.sendTextMessage
											 * (cu.getDispatcherNo(), null,
											 * cu.getGeoObject
											 * ().getHashCode()+" "
											 * +cu.getGeoObject().getState(),
											 * null, null);
											 */GeoJson geoJson = cu
													.getGeoObject();
											long timeStamp = System
													.currentTimeMillis() / 1000L;
											new Read().execute(
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
											/*
											 * cu.getGeoObject().setCurrentOrderID
											 * ("");
											 * cu.getGeoObject().setHash("");
											 */
											HashMap<String, String> hm = db
													.getNextOrder();
											if (hm.size() != 0
													&& !hm.get("test").equals(
															"false")) {
												cu.getGeoObject()
														.setState(
																CabAppConstants.MESSAGE_NOT_COPIED_STATUS);
												db.addData(
														CabAppConstants.MESSAGE_NOT_COPIED_STATUS,
														"", "");
												Intent kl = new Intent(
														loopback,
														NotifySMS.class);
												kl.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK);
												kl.putExtra("message",
														hm.get("orderHash"));
												kl.putExtra("senderNum", 0);
												loopback.startActivity(kl);
											}
											endJourney
													.getBackground()
													.setColorFilter(
															color.DarkRed,
															PorterDuff.Mode.DARKEN);
											loopback.finish();
										
									}
								})
						.setNegativeButton("No",
								new DialogInterface.OnClickListener() {
									public void onClick(DialogInterface dialog,
											int id) {

									}
								});
				AlertDialog alert = builder.create();
				alert.show();
				}else{
					AlertDialog.Builder builder = new AlertDialog.Builder(
							UserActivity.this);
					builder.setTitle("No Network")
							.setCancelable(true)
							.setMessage("Internet connection is not available.Please contact Hao cabs admin")
							.setPositiveButton("OK",
									new DialogInterface.OnClickListener() {
										public void onClick(DialogInterface dialog,
												int id) {
											// loginID.setText("");
											// password.setText("");
										}
									});
					AlertDialog alert = builder.create();
					alert.show();
				}
			}
		});
		/////////////////////////////////////////////////////////////////////////////////////////////////

		tv.setOnClickListener(new OnClickListener() {

			@Override
			public void onClick(View arg0) {
				GeoJson geo = CentralUtils.getInstance().getGeoObject();
				AlertDialog.Builder builder = new AlertDialog.Builder(
						UserActivity.this);
				builder.setTitle("Order Details")
						.setCancelable(true)
						.setMessage(
								" Order ID : " + geo.getCurrentOrderID()
										+ "\n Info : " + hash + "\n State : "
										+ geo.getState() + "\n Other : " + "")
						.setPositiveButton("OK",
								new DialogInterface.OnClickListener() {
									public void onClick(DialogInterface dialog,
											int id) {
										// loginID.setText("");
										// password.setText("");
									}
								});
				AlertDialog alert = builder.create();
				alert.show();
			}
		});

		logout.setOnClickListener(new OnClickListener() {
			@Override
			public void onClick(View v) {
				AlertDialog.Builder builder = new AlertDialog.Builder(
						UserActivity.this);
				builder.setTitle("Confirmation")
						.setCancelable(true)
						.setMessage("Are you sure you want to Logout?")
						.setPositiveButton("Yes",
								new DialogInterface.OnClickListener() {
									public void onClick(DialogInterface dialog,
											int id) {
										new End().execute();
									}
								})
						.setNegativeButton("No",
								new DialogInterface.OnClickListener() {
									public void onClick(DialogInterface dialog,
											int id) {

									}
								});
				AlertDialog alert = builder.create();
				alert.show();

			}
		});

	}

	@Override
	public boolean onCreateOptionsMenu(Menu menu) {
		// Inflate the menu; this adds items to the action bar if it is present.
		getMenuInflater().inflate(R.menu.user, menu);
		return true;
	}

	public void fillData(DataManipulationUtils dataManipulationUtils,
			DbUtils db, CentralUtils cu) {
		String[] ar = dataManipulationUtils.readDetailsFromSMS(db
				.getOrderhash());
		cu.getGeoObject().setHash(ar[2]);
		cu.getGeoObject().setHashCode(ar[4]);
		// cu.getGeoObject().setDriverID(ar[3]);
		cu.getGeoObject().setCurrentOrderID(ar[1]);
	}

	@Override
	public void onBackPressed() {

		/*
		 * Intent i=new Intent(getApplicationContext(),MainActivity.class);
		 * startActivity(i); super.onBackPressed();
		 */
	}

	public class Read extends AsyncTask<String, Integer, String> {
		String jsonString;

		@Override
		protected void onPostExecute(String jstring) {
			// Log.d("Sent", jstring);
			// Toast.makeText(getApplicationContext(), jstring,
			// Toast.LENGTH_SHORT).show();
			//Toast.makeText(getApplicationContext(), jstring, Toast.LENGTH_LONG).show();
			CentralUtils cu = CentralUtils.getInstance();
			if (cu.getGeoObject().getState()
					.equals(CabAppConstants.IDLE_STATUS)) {
				cu.getGeoObject().setCurrentOrderID("");
				cu.getGeoObject().setHash("");
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
			return jsonString;
		}
	}

	public class End extends AsyncTask<String, Integer, String> {
		String res;
		private ProgressDialog progressDialog;

		@Override
		protected void onPreExecute() {
			super.onPreExecute();
			progressDialog = new ProgressDialog(UserActivity.this);
			progressDialog.setCancelable(true);
			progressDialog.setMessage("Log Out ...");
			progressDialog.setProgressStyle(ProgressDialog.STYLE_SPINNER);
			progressDialog.setProgress(0);
			progressDialog.show();
		}

		@Override
		protected void onPostExecute(String result) {

			JSONObject ob;
			// loginID.setText(result);
			try {
				ob = new JSONObject(result);
				String isAuthorized = "false";
				//Toast.makeText(getApplicationContext(), result, Toast.LENGTH_LONG).show();
				if (ob.has("isAuthorized"))
					isAuthorized = ob.getString("isAuthorized");
				if (!isAuthorized.trim().equals("true")) {
					AlertDialog.Builder builder = new AlertDialog.Builder(
							UserActivity.this);
					builder.setTitle("Cant Logout")
							.setCancelable(true)
							.setMessage(
									"Logout is not allowed. Please contact the authorized personnel ")
							.setPositiveButton("OK",
									new DialogInterface.OnClickListener() {
										public void onClick(
												DialogInterface dialog, int id) {
											// loginID.setText("");
											// password.setText("");
										}
									});
					AlertDialog alert = builder.create();
					alert.show();
				} else {
					CentralUtils cu = CentralUtils.getInstance();
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
			} catch (JSONException e) {

			}

			progressDialog.dismiss();
		}

		@Override
		protected String doInBackground(String... params) {
			String h = "";
			try {
				JSONParser jp = new JSONParser();
				JSONObject jo = new JSONObject();
				long timeStamp = System.currentTimeMillis() / 1000L;
				jo.put("uName", CentralUtils.getInstance().getGeoObject()
						.getDriverID());
				jo.put("timeStamp", timeStamp);
				/*
				 * jo.put("pass", password.getText().toString());
				 * jo.put("login", "logout");
				 */
				h = jo.toString();
				res = jp.sendJSONToUrl(CabAppConstants.LOGOUT_URL,
						jo.toString());

			} catch (Exception e) {
				e.printStackTrace();
			}
			return res;
		}

	}
	private boolean isNetworkAvailable() {
	    ConnectivityManager connectivityManager 
	          = (ConnectivityManager) getSystemService(Context.CONNECTIVITY_SERVICE);
	    NetworkInfo activeNetworkInfo = connectivityManager.getActiveNetworkInfo();
	    return activeNetworkInfo != null && activeNetworkInfo.isConnected();
	}
}
